<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Services\Shop\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Response;

class ProductsController extends Controller
{
    protected $productService;
    /**
     * 開頭宣告
     *
     * @return void
     */
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    
    /**
     * 判斷要導向哪一種商品
     *
     * @return route
     */
    public function show($product_id)
    {
    	$product = $this->productService->find($product_id);
        if(!$product){
            abort(404);
        }
        
        switch ($product->product_category_id) {
            case 1:
                return redirect()->route('admin.shop.product.account_transfer.show',$product_id);
                break;
            case 2:
                return redirect()->route('admin.shop.product.share.show',$product_id);
                break;
            case 3:
                return redirect()->route('admin.shop.product.own_share.show',$product_id);
                break;
            case 4:
                return redirect()->route('admin.shop.product.member_card.show',$product_id);
                break;
            case 5:
                return redirect()->route('admin.shop.product.register_card.show',$product_id);
                break;
            case 6:
                return redirect()->route('admin.shop.product.auction.show',$product_id);
                break;
            default:
                abort(404);
                break;
        }
    }

    


}
