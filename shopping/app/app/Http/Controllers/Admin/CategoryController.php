<?php

namespace App\Http\Controllers\Admin;

use App\Models\category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\CategoryFormRequset;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.category.index');
    }
    public function create()
    {
        return view('admin.category.create');
    }
    public function store(CategoryFormRequset $request)
    {
        $validatedData = $request->validated();
        $category = new category();
        $category->name = $validatedData ['name'];
        $category->slug = Str::slug( $validatedData ['slug']);
        $category->description = $validatedData ['description'];

        $uploadPath = 'uploads/category/';
        if($request->hasFile('image')){
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;

            $file->move('uploads/category/',$filename);
            $category->image = $uploadPath.$filename;
        }


        $category->meta_title = $validatedData ['meta_title'];
        $category->meta_keyword = $validatedData ['meta_keyword'];
        $category->meta_description = $validatedData ['meta_description'];
        $category->status = $request->status == true ? '1':'0';
        $category->save();

        return redirect('admin/category')->with('message','Category Added Successfuliy');




    }
    public function edit(category $category)
    {
        return view('admin.category.edit',compact('category'));
    }
    public function update(categoryFormRequset $request,  $category)
    {
        $validatedData = $request->validated();
        $category = category::findOrFail($category);
        $category->name = $validatedData ['name'];
        $category->slug = Str::slug( $validatedData ['slug']);
        $category->description = $validatedData ['description'];

        if($request->hasFile('image')){
            $uploadPath = 'uploads/category/';

            $path = 'uploads/category/'.$category->image;
            if(File::exists($path)){
                File::delete($path );
            }
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;

            $file->move('uploads/category/',$filename);
            $category->image = $uploadPath.$filename;
        }
        $category->meta_title = $validatedData ['meta_title'];
        $category->meta_keyword = $validatedData ['meta_keyword'];
        $category->meta_description = $validatedData ['meta_description'];
        $category->status = $request->status == true ? '1':'0';
        $category->update();

        return redirect('admin/category')->with('message','category Update Successfuliy');
    }



}
