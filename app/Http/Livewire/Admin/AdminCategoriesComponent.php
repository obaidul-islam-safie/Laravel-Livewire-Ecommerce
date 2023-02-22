<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\withPagination;
use App\Models\Category;

class AdminCategoriesComponent extends Component
{
    use withPagination;
    public function render()
    {
        $categories = Category::orderBy('name','ASC')->paginate(5);
        return view('livewire.admin.admin-categories-component',['categories'=>$categories]);
    }
}
