<?php

namespace App\Http\Controllers\Front\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Shop\ProductService;
use App\Services\Shop\CategoryService;
use App\Services\Shop\Product\ShareService;
use App\Services\Member\MemberService;
use App;
use Auth;
use Validator;

class ProductsController extends Controller
{

    protected $productService;
    protected $categoryService;
    protected $shareService;
    protected $memberService;
    protected $user;
    protected $page_title = '購物商城';
    
	public function __construct(
        ProductService $productService,
        CategoryService $categoryService,
        MemberService $memberService,
        ShareService $shareService
    ) {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
        $this->shareService = $shareService;
        $this->memberService = $memberService;
        $this->user = Auth::guard('web')->user();
    }

    /**
     * 列表
     *
     * @return index view
     */
    public function index($category_id = 5)
    {
        $category = $this->categoryService->find($category_id);
        if(!$category){
            abort(404);
        }
        //會員等級資訊
        $member_level_info = $this->memberService->searchMemberLevel($this->user->id,$this->user->type);

        $account = $this->user->member->accounts;
    	$data=[
            'category_items' => $this->categoryService->all(),
            'category' => $category,
            'share' => $this->shareService->getNowShare(),
            'share_product' => $this->shareService->findByCategoryId(2),
            'own_share_amount' => $account->where('type','5')->first()->amount,
            'cash_account' => $account->where('type','1')->first()->amount,
            'page_title' => $this->page_title,
            'level_expire' => $member_level_info['level_expire'],
            'level' => $member_level_info['level_name'],
            'member' => $this->user->member,
            'user' => $this->user
    	];

	    return view('front.shop.product_category',$data);
    }

    /**
     * 購買
     *
     * @param Request $request
     */
    public function buy(Request $request)
    {
        $product = $this->productService->find($request->id);
        if(!$product){
            return json_encode(array('result' => 0, 'text' => '商品不存在'));
        }
        $result = $this->productService->buy($request->id,$request->quantity);
        if ($result['status']) {
            return json_encode(array('result' => 1, 'text' => 'Success'));
        } else {
            return json_encode(array('result' => 0,'error_code'=> $result['error_code'],'error_msg'=>$result['error_msg'], 'text' => $result['error_msg']));
        }
    }

    /**
     * 判斷要導向哪一種商品
     *
     * @return index view
     */
    public function show($product_id,$quantity_show =1)
    {
        $product = $this->productService->find($product_id);
        if(!$product){
            abort(404);
        }

        switch ($product->product_category_id) {
            case 1:
                return redirect()->route('front.shop.product.account_transfer.show',[$product_id,$quantity_show]);
                break;
            case 2:
                return redirect()->route('front.shop.product.share.show',[$product_id,$quantity_show]);
                break;
            case 3:
                return redirect()->route('front.shop.product.own_share.show',[$product_id,$quantity_show]);
                break;
            case 4:
                return redirect()->route('front.shop.product.member_card.show',[$product_id,$quantity_show]);
                break;
            case 5:
                return redirect()->route('front.shop.product.register_card.show',[$product_id,$quantity_show]);
                break;
            case 6:
                return redirect()->route('front.shop.product.auction.show',[$product_id,$quantity_show]);
                break;
            default:
                abort(404);
                break;
        }
    }

    /**
     * 判斷要導向哪一種使用商品頁面
     *
     * @return index view
     */
    public function useRedirect($product_id)
    {
        $product = $this->productService->find($product_id);
        if(!$product){
            abort(404);
        }

        switch ($product->product_category_id) {
            case 1:
                return redirect()->route('front.shop.use.account_transfer.index',$product_id);
                break;
            case 2:
                return redirect()->route('front.shop.use.share.index',$product_id);
                break;
            case 3:
                return redirect()->route('front.shop.use.own_share.index',$product_id);
                break;
            case 4:
                return redirect()->route('front.shop.use.member_card.index',$product_id);
                break;
            case 5:
                return redirect()->route('front.shop.use.register_card.index',$product_id);
                break;
            case 6:
                return redirect()->route('front.shop.share_transaction.sell_index');
                break;
            default:
                abort(404);
                break;
        }
    }


}
