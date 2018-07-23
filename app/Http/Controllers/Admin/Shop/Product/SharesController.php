<?php

namespace App\Http\Controllers\Admin\Shop\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Services\Shop\CategoryService;
use App\Services\Shop\Product\ShareService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Response;

class SharesController extends Controller
{
    /**
     * 參數設定
     *
     * @var string
     */
    protected $shareService;
    protected $page_title = '娛樂幣';
    protected $menu_title = '商品管理';
    protected $route_code = 'share';
    protected $view_data = [];
    protected $category ;


    /**
     * 開頭宣告
     *
     * @return void
     */
    public function __construct(CategoryService $categoryService,ShareService $shareService)
    {
        $this->shareService = $shareService;
        $this->categoryService = $categoryService;
        $this->category = $this->categoryService->find(2);
        $this->view_data = [
            'route_code' => $this->route_code,
            'page_title' => $this->page_title,
            'menu_title' => $this->menu_title,
        ];
    }
    
    /**
     * 所有資料頁面
     *
     * @return view admin/shop/product/share/index.blade.php
     */
    public function index()
    {
    	$share = $this->shareService->findByCategoryId($this->category->id); 
        $data =[
            'data' => $share,
        ];
        return view('admin.shop.product.'.$this->route_code.'.index',array_merge($this->view_data,$data));
    }

    /**
     * 資訊頁面
     *
     * @param  int $id
     * @return view admin/shop/product/share/show.blade.php
     */
    public function show($id)
    {   
        $item = $this->shareService->find($id);
        if(!$item){
            return json_encode(array('result' => 0, 'text' => '資料不存在'));
        }
        if($item->product_category_id != $this->category->id){
            return json_encode(array('result' => 0, 'text' => '資料不存在'));
        }
        $data =[
            'data' => $item,
        ];
        return view('admin.shop.product.'.$this->route_code.'.show',array_merge($this->view_data,$data));
    }




    /**
     * 資料更新處理
     *
     * @param  int $id
     * @param Request $request
     * @return json
     */
    public function update(Request $request)
    {   
        $data = [
            'category_id' => $this->category->id,
            'name' =>  $request->name,
            'description' => $request->description,
            'price' => $request->price
        ];

        $result = $this->shareService->update($data);
        if ($result['status']) {
            return json_encode(array('result' => 1, 'text' => 'Success'));
        } else {
            return json_encode(array('result' => 0, 'text' => 'Failed：'.$result['error_msg'],'content' => $result['detail']));
        }
    }

    /**
     * 資料更新處理
     *
     * @param  int $id
     * @param Request $request
     * @return json
     */
    public function changeStatus($id,Request $request)
    {   

        $result = $this->shareService->changeStatus($id,$request->status);
        if ($result['status']) {
            return json_encode(array('result' => 1, 'text' => 'Success'));
        } else {
            return json_encode(array('result' => 0, 'text' => 'Failed：'.$result['error_code'],'content' => $result['error_msg']));
        }
    }


}
