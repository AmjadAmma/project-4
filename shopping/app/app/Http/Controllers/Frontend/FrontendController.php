<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\category;
use App\Models\Slider;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index()
    {
        $sliders = Slider::where('status', '0')->get();
        return view('frontend.index', compact('sliders'));
    }
    public function categories()
    {
        $categories = category::where('status', '0')->get();
        return view('frontend.collections.category.index',compact('categories'));
    }
    public function products($category_slug)
    {
        $category = category::where('slug',$category_slug)->first();
        if($category){

            // $products = $category->products()->get();
            // dd($products);
            // dd($category);
            return view('frontend.collections.products.index',compact('category'));
        }else{
            return redirect()->back();
        }
    }
}
