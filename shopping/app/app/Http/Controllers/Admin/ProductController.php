<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\Color;
use App\Models\Product;
use App\Models\category;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\ProductFormRequset;
use App\Models\ProductColor;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('admin.products.index' , compact('products'));
    }
    public function create()
    {
        $categories = category::all();
        $brands = Brand::all();
        $colors = Color::where('status', '0')->get();

        return view('admin.products.create', compact('categories','brands','colors'));
    }
    public function store(ProductFormRequset $requset)
    {
          $validatedData = $requset->validated();
          $category = category::findOrFail($validatedData['category_id']);
          $product =$category->products()->create([
            'category_id' =>$validatedData['category_id'],
            'name' =>$validatedData['name'],
            'slug' =>Str::slug($validatedData['slug']),
            'brand' =>$validatedData['brand'],
            'small_description' =>$validatedData['small_description'],
            'description' =>$validatedData['description'],
            'original_price' =>$validatedData['original_price'],
            'selling_price' =>$validatedData['selling_price'],
            'quantity' =>$validatedData['quantity'],
            'trending' =>$requset->trending == true ? '1':'0',
            'status' =>$requset->status == true ? '1':'0',
            'meta_title' =>$validatedData['meta_title'],
            'meta_keyword' =>$validatedData['meta_keyword'],
            'meta_description' =>$validatedData['meta_description'],
          ]);




          if($requset->hasFile('image')){
            $uploadPath = 'uploads/products/';
            $i = 1;
            foreach($requset->file('image') as $imageFile){
                $extention = $imageFile->getClientOriginalExtension();
                $filename = time().$i++.'.'.$extention;
                $imageFile->move($uploadPath,$filename);
                $finalImagepathName = $uploadPath.$filename;

                $product->protectImages()->create([

                    'product_id' => $product->id,
                    'image' => $finalImagepathName,

                ]);
            }

          }

          if($requset->colors){
            foreach($requset->colors as $key => $color){
                $product->ProductColors()->create([
                    'product_id' => $product->id,
                    'color_id' => $color,
                    'quantity' => $requset->colorquantity[$key] ?? 0,


                ]);
            }
          }
        return redirect('/admin/products')->with('message','Product Added Successfuliy');

    }
    public function edit(int $product_id){


        $categories = category::all();
        $brands = Brand::all();
        $product = Product::findOrFail($product_id);
        $product_color = $product->productColors->pluck('color_id')->toArray();
        $colors = Color::whereNotIn('id',$product_color)->get();

        return view('admin.products.edit', compact('categories' ,'brands' , 'product', 'colors'));

    }
    public function update(ProductFormRequset $requset, int $product_id)

    {
        $validatedData = $requset->validated();
        $product = category::findOrFail($validatedData['category_id'])
                            ->products()->where('id',$product_id)->first();

        if($product)
        
        {
            $product->update([
            'category_id' =>$validatedData['category_id'],
            'name' =>$validatedData['name'],
            'slug' =>Str::slug($validatedData['slug']),
            'brand' =>$validatedData['brand'],
            'small_description' =>$validatedData['small_description'],
            'description' =>$validatedData['description'],
            'original_price' =>$validatedData['original_price'],
            'selling_price' =>$validatedData['selling_price'],
            'quantity' =>$validatedData['quantity'],
            'trending' =>$requset->trending == true ? '1':'0',
            'status' =>$requset->status == true ? '1':'0',
            'meta_title' =>$validatedData['meta_title'],
            'meta_keyword' =>$validatedData['meta_keyword'],
            'meta_description' =>$validatedData['meta_description'],

            ]);
            if($requset->hasFile('image')){
                $uploadPath = 'uploads/products/';
                $i = 1;
                foreach($requset->file('image') as $imageFile){
                    $extention = $imageFile->getClientOriginalExtension();
                    $filename = time().$i++.'.'.$extention;
                    $imageFile->move($uploadPath,$filename);
                    $finalImagepathName = $uploadPath.'-'.$filename;

                    $product->protectImages()->create([

                        'product_id' => $product->id,
                        'image' => $finalImagepathName,

                    ]);
                }

              }
            //   $product->update();
        return redirect('/admin/products')->with('message','Product Update Successfuliy');

        }
        else
        {
        return redirect('admin/products')->with('message','No Such Product Id Found');

        }



    }
    public function destoryImage(int $product_image_id)
    {
        $productImage = ProductImage::findOrFail($product_image_id);
        if(File::exists($productImage->image)){
            File::delete($productImage->image);
        }

        $productImage->delete();
        return redirect()->back()->with('message','Product Image Deleted');
    }
    public function destroy(int $product_id)
    {
        $product = Product::findOrFail($product_id);
        if($product->productImage){
            foreach($product->productImage as $image){
                if(File::exists($image->image)){
                    File::delete($image->image);
            }

        }
    }
        $product->delete();
        return redirect()->back()->with('message','Product Deleted with all its image');

    }
    public function updateProdColorQty(Request $request, $prod_color_id)
    {
        $productColorData = Product::findOrFail($request->product_id)
                                            ->productColors()->where('id', $prod_color_id)->first();
        $productColorData->update([
            'quantity' => $request->qty

        ]);
        return response()->json(['message' => 'Product Color Qty updated']);
    }
    public function deleteProdColor($prod_color_id)
    {
        $prodColor = ProductColor::findOrFail($prod_color_id);
        $prodColor->delete();
        return response()->json(['message' => 'Product Color Deleted']);
    }


}



