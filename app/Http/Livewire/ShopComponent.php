<?php

namespace App\Http\Livewire;

use App\Models\Product;
use App\Models\Category;
use Livewire\Component;
use Livewire\withPagination;
use Cart;

class ShopComponent extends Component
{
    use withPagination;
    public $pageSize = 10;
    public $orderBy = "Default Sorting";

    public $min_value = 0;
    public $max_value = 1000;

    public function store($product_id,$product_name,$product_price){

        Cart::instance('cart')->add($product_id,$product_name,1,$product_price)->associate('\App\Models\Product');
        session()->flash('success_message','Item added in Cart');
        $this->emitTo('cart-icon-component','refreshComponent');
        return redirect()->route('shop.cart');
    }

    public function changePageSize($size){
        $this->pageSize = $size;
    }

    public function changeOrderBy($order){
        $this->orderBy = $order;
    }

    public function addToWishlist($product_id,$product_name,$product_price){

        Cart::instance('wishlist')->add($product_id,$product_name,1,$product_price)->associate('\App\Models\Product');
        $this->emitTo('wishlist-icon-component','refreshComponent');
    }

    public function removeFromWishlist($product_id){
        foreach(Cart::instance('wishlist')->content() as $witem){
            if($witem->id==$product_id){
                Cart::instance('wishlist')->remove($witem->rowId);
                $this->emitTo('wishlist-icon-component','refreshComponent');
                return;
            }
        }
    }

    public function render()
    {
        if($this->orderBy == 'Price: Low to High'){
            $products = Product::whereBetween('regular_price',[$this->min_value,$this->max_value])->orderBy('regular_price','ASC')->paginate($this->pageSize);
        }
        elseif($this->orderBy == 'Price: High to Low'){
            $products = Product::whereBetween('regular_price',[$this->min_value,$this->max_value])->orderBy('regular_price','DESC')->paginate($this->pageSize);
        }
        elseif($this->orderBy == 'Sort By Newness Date'){
            $products = Product::whereBetween('regular_price',[$this->min_value,$this->max_value])->orderBy('created_at','DESC')->paginate($this->pageSize);
        }
        else{
            $products = Product::whereBetween('regular_price',[$this->min_value,$this->max_value])->paginate($this->pageSize);
        }

        $categories = Category::orderBy('name','ASC')->get();
        
        return view('livewire.shop-component',['products'=>$products,'categories'=>$categories]);
    }
}
