<div>
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header"><h4>Brands</h4></div>
                    <div class="card-body">
                        @foreach($category->brands as $brandItem)
                        <label class="d-block">
                            <input type="checkbox" wire:model="brandInputs" value="{{$brandItem->name}}"/>{{$brandItem->name}}
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>

        <div class="col-md-9">
        <div class="row">
            @forelse($products as $productsItem)
            <div class="col-md-3">
                <div class="product-card">
                    <div class="product-card-img">
                        @if($productsItem->quantity > 0)
                        <label class="stock bg-success">In Stock</label>
                        @else
                        <label class="stock bg-danger">Out of Stock</label>
                        @endif

                        @if($productsItem->protectImages->count() > 0)
                        <a href="{{url('/collections/'.$productsItem->category->slug.'/'.$productsItem->slug)}}">

                        <img src="{{ asset($productsItem->protectImages[0]->image)}}">
                        </a>
                        @endif
                    </div>
                    <div class="product-card-body">
                        <p class="product-brand">{{$productsItem->brand}}</p>
                        <h5 class="product-name">
                           <a href="{{url('/collections/'.$productsItem->category->slug.'/'.$productsItem->slug)}}">
                                {{$productsItem->name}}
                           </a>
                        </h5>
                        <div>
                            <span class="selling-price">{{$productsItem->selling_price}}</span>
                            <span class="original-price">{{$productsItem->original_price}}</span>
                        </div>

                    </div>
                </div>
            </div>
            @empty
            <div class="col-md-12">
                <div class="p-2">
                    <h4> No products Available for {{$category->name}}</h4>
                </div>
            </div>
            @endforelse
        </div>
        </div>
    </div>
</div>
