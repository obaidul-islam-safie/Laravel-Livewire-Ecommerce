<?php

namespace App\Http\Livewire;

use App\Models\Product;
use App\Models\Category;
use Livewire\Component;
use Livewire\withPagination;
use Cart;

class SearchComponent extends Component
{
    use withPagination;
    public $pageSize = 10;
    public $orderBy = "Default Sorting";

    public $q;
    public $search_term;

    public function mount(){
        $this->fill(request()->only('q'));
        $this->search_tram = '%'.$this->q. '%';
    }
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

    public function render()
    {
        if($this->orderBy == 'Price: Low to High'){
            $products = Product::where('name','like',$this->search_tram)->orderBy('regular_price','ASC')->paginate($this->pageSize);
        }
        elseif($this->orderBy == 'Price: High to Low'){
            $products = Product::where('name','like',$this->search_tram)->orderBy('regular_price','DESC')->paginate($this->pageSize);
        }
        elseif($this->orderBy == 'Sort By Newness Date'){
            $products = Product::where('name','like',$this->search_tram)->orderBy('created_at','DESC')->paginate($this->pageSize);
        }
        else{
            $products = Product::where('name','like',$this->search_tram)->paginate($this->pageSize);
        }

        $categories = Category::orderBy('name','ASC')->get();
        
        return view('livewire.search-component',['products'=>$products,'categories'=>$categories]);
    }
}
