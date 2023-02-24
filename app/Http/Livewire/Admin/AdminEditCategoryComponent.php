<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Str;

class AdminEditCategoryComponent extends Component
{
    public $categoty_id;
    public $name;
    public $slug;

    public function mount($category_id){
        $category = Category::find($category_id);
        $this->category_id = $category->id;
        $this->name = $category->name;
        $this->laug = $category->slug;

    }
    public function geneateSlug(){
        $this->slug = Str::slug($this->name);
    }
    public function updated($fields){
        $this->validateOnly($fields,[
            'name'=>'required',
            'slug'=>'required'
        ]);
    }
    public function updateCategory(){
        $this->validate([
            'name'=>'required',
            'slug'=>'required'
        ]);
        $category = Category::find($this->category_id);
        $category->name = $this->name;
        $category->slug = $this->slug;
        $category->save();
        session()->flash('message','Category Update successfully!');
    }

    public function render()
    {
        return view('livewire.admin.admin-edit-category-component');
    }
}
