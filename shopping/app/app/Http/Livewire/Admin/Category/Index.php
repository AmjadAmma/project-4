<?php

namespace App\Http\Livewire\Admin\Category;

use Livewire\Component;
use App\Models\category;
use Livewire\WithPagination;
use Illuminate\Support\Facades\File;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $category_id;

    public function deleteCategory($category_id)
    {


        $this->category_id = $category_id;
    }


    public function destroyCategory() {


        $category = category::find($this->category_id);
        // dd($category);
        $path ='uploads/category/'.$category->image;

        if (File::exists($path)) {
            File::delete($path);
        }
        $category->delete();
        session()->flash('message', 'Category Deleted');
        $this->dispatchBrowserEvent('close-modal');
    }



    public function render()
    {
        $categories = category::orderBy('id','DESC')->paginate(10);
        return view('livewire.admin.category.index',['categories' => $categories])
                    ->extends('layouts.admin')
                    ->section('content');

        ;
    }
}
