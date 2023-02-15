<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\withPagination;

class ShopComponent extends Component
{
    use withPagination;
    public function render()
    {
        $products = Product::paginate(12);
        return view('livewire.shop-component',['products'=>$products]);
    }
}
