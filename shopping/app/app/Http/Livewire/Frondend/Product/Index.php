<?php

namespace App\Http\Livewire\Frondend\Product;

use App\Models\Product;
use Livewire\Component;

class Index extends Component
{

    public $products, $category, $brandInputs = [] ;
    protected $queryString = ['brandInputs' => ['except' => '', 'as' => 'brand'],];
    public function mount( $category )
    {
            // $this->products = $products;
        $this->category = $category;

    }


    public function render()
    {
        $this->products = Product::where('category_id',$this->category->id)
                                    ->when($this->brandInputs, function($q){
                                        $q->whereIn('brand',$this->brandInputs);
                                    })
                                    ->where('status','0')
                                    ->get();
        return view('livewire.frondend.product.index', [
            'products' => $this->products,
            'category' => $this->category
        ]);
    }
}
