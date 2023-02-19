<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\withPagination;
use Cart;

class ShopComponent extends Component
{
    use withPagination;
    public $pageSize = 10;
    public $orderBy = "Default Sorting";

    public function store($product_id,$product_name,$product_price){

        Cart::add($product_id,$product_name,1,$product_price)->associate('\App\Models\Product');
        session()->flash('success_message','Item added in Cart');
        return redirect()->route('shop.cart');
    }

    public function changePageSize($size){
        $this->pageSize = $size;
    }

    public function changeOrderBy($order){
        $this->orderBy = $order;
    }

    public function render()
    {
        if($this->orderBy == 'Price: Low to High'){
            $products = Product::orderBy('regular_price','ASC')->paginate($this->pageSize);
        }
        elseif($this->orderBy == 'Price: High to Low'){
            $products = Product::orderBy('regular_price','DESC')->paginate($this->pageSize);
        }
        elseif($this->orderBy == 'Sort By Newness Date'){
            $products = Product::orderBy('created_at','DESC')->paginate($this->pageSize);
        }
        else{
            $products = Product::paginate($this->pageSize);
        }
        
        return view('livewire.shop-component',['products'=>$products]);
    }
}
