<?php

namespace App\Http\Controllers\Front\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Services\Shop\ShareTransactionService;
use App\Services\Shop\Product\ShareService;
use App\Services\Shop\ProductBagService;
use App\Services\System\ParameterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Auth;
use Exception;

class ShareTransactionsController extends Controller
{
    /**
     * 參數設定
     *
     * @var string
     */
    protected $transactionService;
    protected $shareService;
    protected $parameterService;
    protected $bagService;
    protected $page_title = '娛樂幣交易';
    protected $route_code = 'share_transaction';
    protected $view_data = [];
    protected $user;
    protected $member;

    /**
     * 開頭宣告
     *
     * @return void
     */
    public function __construct(
        ShareTransactionService $transactionService,
        ShareService $shareService,
        ParameterService $parameterService,
        ProductBagService $bagService
    ) {
        $this->transactionService = $transactionService;
        $this->shareService = $shareService;
        $this->parameterService = $parameterService;
        $this->bagService = $bagService;
        $this->user = Auth::guard('web')->user();
        $this->member = $this->user->member;
        $this->view_data =[
            'route_code' => $this->route_code,
        ];
    }
    
    /**
     * 交易平台入口選單頁面
     * @return view front/shop/share_transaction/index.blade.php
     */
    public function index()
    {
        $data = [
            'page_title' => '娛樂幣交易'
        ];
        return view('front.shop.'.$this->route_code.'.index',array_merge($this->view_data,$data));
    }

    /**
     * 目前牌價頁面
     * @return view front/shop/share_transaction/current_price.blade.php
     */
    public function currentPrice()
    {
        $data =[
            'datas' => $this->transactionService->getCheapestDatas(0,5),
            'user' => $this->user,
            'page_title' => '娛樂幣購買'
        ];
        //商城娛樂幣、個人餘額資訊
        $account_info = $this->getShareAndAccountInfo();
        $data = array_merge($data,$account_info);

        return view('front.shop.'.$this->route_code.'.current_price',array_merge($this->view_data,$data));
    }

    /**
     * 我的交易資訊-上架
     * @param date $start
     * @param date $end
     * @return view front/shop/share_transaction/my_on_the_shelf_transaction.blade.php
     */
    public function myOnTheShelfTransaction($start = null, $end = null)
    {
        if(!$start || !$end){
            $date_info = getDefaultDateRange(30);
            $start = $date_info['start'];
            $end = $date_info['end'];
        }
        $datas = $this->transactionService->getCheapestDatas(0,5000,$this->user->id); 
        $data =[
            'transactions' => $datas,
            'start' => $start,
            'end' => $end,
            'page_title' => '我的交易'
        ];
        //商城娛樂幣、個人餘額資訊
        $account_info = $this->getShareAndAccountInfo();
        $data = array_merge($data,$account_info);
        return view('front.shop.'.$this->route_code.'.my_on_the_shelf_transaction',array_merge($this->view_data,$data));
    }

    /**
     * 我的交易資訊-歷史上架
     * @return view front/shop/share_transaction/my_history_transaction.blade.php
     */
    public function myHistoryTransaction()
    {
        //兩個月
        $date_info = getDefaultDateRange(60);
        $start = $date_info['start'];
        $end = $date_info['end'];

        $buy_datas = $this->transactionService->allByBuyerId($this->user->id,1,$start,$end); 
        $sell_datas = $this->transactionService->allBySellerId($this->user->id,'%',$start,$end); 
        $data =[
            'buy_transactions' => $buy_datas,
            'sell_transactions' => $sell_datas,
            'page_title' => '我的交易'
        ];
        //商城娛樂幣、個人餘額資訊
        $account_info = $this->getShareAndAccountInfo();
        $data = array_merge($data,$account_info);
        return view('front.shop.'.$this->route_code.'.my_history_transaction',array_merge($this->view_data,$data));
    }

    /**
     * 我的交易資訊-歷史購買
     * @return view front/shop/share_transaction/buy_history_transaction.blade.php
     */
    public function buyHistoryTransaction()
    {
        //僅顯示兩個月資料
        $date_info = getDefaultDateRange(60);
        $start = $date_info['start'];
        $end = $date_info['end'];

        $buy_datas = $this->transactionService->allByBuyerId($this->user->id,1,$start,$end); 
        $data =[
            'buy_transactions' => $buy_datas,
            'page_title' => '我的交易'
        ];
        //商城娛樂幣、個人餘額資訊
        $account_info = $this->getShareAndAccountInfo();
        $data = array_merge($data,$account_info);
        return view('front.shop.'.$this->route_code.'.buy_history_transaction',array_merge($this->view_data,$data));
    }


    /**
     * 所有拍賣資訊
     * @return view front/shop/share_transaction/all_auction.blade.php
     */
    public function allAuction()
    {
        $accounts = $this->member->accounts;
        $data =[
            'datas' => $this->transactionService->getCheapestDatas(0,5000),
            'cash_account' => $accounts->where('type','1')->first()->amount,
            'share_product' => $this->shareService->findByCategoryId(2),
            'share_amount' => $accounts->where('type','3')->first()->amount,
            'share' => $this->shareService->getNowShare(),
            'user' => $this->user,
            'page_title' => '玩家交易'
        ];
        return view('front.shop.'.$this->route_code.'.all_auction',array_merge($this->view_data,$data));
    }

    /**
     * 我要拍賣
     * @return view front/shop/share_transaction/sell_index.blade.php
     */
    public function sellIndex()
    {

        $accounts = $this->member->accounts;
        $data=[
            'transactions' => $this->transactionService->getCheapestDatas(0,5000,$this->user->id),
            'fee_percent' => $this->parameterService->find('share_transaction_fee_percent'),
            'expire_day' => $this->parameterService->find('share_transaction_expire_day'),
            'product' => $this->bagService->getProductByCategoryId($this->user->id,6),
            'product_count'=> $this->bagService->getProductCountByCategoryId($this->user->id,6),
            'page_title' => '娛樂幣拍賣'
        ];
        //商城娛樂幣、個人餘額資訊
        $account_info = $this->getShareAndAccountInfo();
        $data = array_merge($data,$account_info);

        return view('front.shop.'.$this->route_code.'.sell_index',array_merge($this->view_data,$data));
    }

    /**
     * 共用基本資訊（牌價、數量、個人金幣娛樂幣餘額）
     * @return array
     */
    public function getShareAndAccountInfo()
    {
        $account = $this->member->accounts;
        $data =[
            'share' => $this->shareService->getNowShare(),
            'share_amount' => $account->where('type','3')->first()->amount,
            'cash_amount' => $account->where('type','1')->first()->amount,
            'share_product' => $this->shareService->findByCategoryId(2),
        ];

        return $data;
    }

    /**
     * 目前最低價掛單
     * @param int $limit
     * @return string
     */
    public function cheapestData($limit=5000)
    {
        return json_encode(['result' => 1,'datas'=>$this->transactionService->getCheapestDatas(0,$limit)]);
    }

    /**
     * 我的最低價前五
     * @return string
     */
    public function myCheapestData($limit=5000)
    {
        return json_encode(['result' => 1,'datas'=>$this->transactionService->getCheapestDatas(0,$limit,$this->user->id)]);
    }

    /**
     * 掛單確認購買
     *
     * @param Request $request
     */
    public function dealTransaction(Request $request)
    {
        DB::beginTransaction();
        try{
            
            $data = $this->transactionService->find($request->id);
            if(!$data){
                throw new Exception('掛單不存在');
            }
            if($data->status != 0){
                throw new Exception('掛單稍早已成交/取消，無法交易');
            }
            $result = $this->transactionService->dealTransaction($request->id);
            
        } catch (Exception $e){
           DB::rollBack();
           return json_encode(['result' => 0, 'error_code' => 'SYSTEM_ERROR', 'error_msg'=> $e->getMessage()]);
        }
        DB::commit();
        if($result['status']){
            return json_encode(['result' => 1]);
        } else {
            return json_encode(['result' => 0, 'error_code' => $result['error_code'], 'error_msg' => $result['error_msg']]);
        }
    }

    /**
     * 掛單取消
     *
     * @param Request $request
     */
    public function cancelTransaction(Request $request)
    {
        DB::beginTransaction();
        try{
            $result = $this->transactionService->cancelTransaction($request->id);
        } catch (Exception $e){
           DB::rollBack();
           return json_encode(['result' => 0, 'error_code' => 'SYSTEM_ERROR', 'error_msg'=> $e->getMessage()]);
        }
        DB::commit();
        if($result['status']){
            return json_encode(['result' =>1,'text'=>'Success']);
        } else {
            return json_encode(['result' => 0, 'error_code' => $result['error_code'], 'error_msg' => $result['error_msg']]);
        }

    }




}
