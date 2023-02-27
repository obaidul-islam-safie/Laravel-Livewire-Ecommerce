<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\withPagination;
use App\Models\Product;

class AdminProductComponent extends Component
{
    use withPagination;
    public function render()
    {
        $products = Product::orderBy('created_at','DESC')->paginate(10);
        return view('livewire.admin.admin-product-component',['products'=>$products]);
    }
}
