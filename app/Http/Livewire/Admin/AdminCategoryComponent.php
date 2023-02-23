<?php

namespace App\Http\Livewire\Admin;


use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\Category;

class AdminCategoryComponent extends Component
{
    public $name;
    public $slug;
    public function geneateSlug(){
        $this->slug = Str::slug($this->name);
    }
    public function updated($fields){
        $this->validateOnly($fields,[
            'name'=>'required',
            'slug'=>'required'
        ]);
    }
    public function storeCategory(){
        $this->validate([
            'name'=>'required',
            'slug'=>'required'
        ]);
        $category = new Category();
        $category->name = $this->name;
        $category->slug = $this->slug;
        $category->save();
        session()->flash('message','Category created successfully!');

    }
    public function render()
    {
        return view('livewire.admin.admin-category-component');
    }
}
