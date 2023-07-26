@extends('layouts.app')

@section('title', 'Home Page')



@section('content')

<div id="carouselExampleCaptions" class="carousel slide">

    <div class="carousel-inner">
        @foreach($sliders as $key => $slidersItem)


      <div class="carousel-item {{$key == 0 ? 'active':''}}">
        @if($slidersItem->image)
        <img src="{{asset("$slidersItem->image")}}"  class="d-block w-100 h-25" alt="...">
        @endif
        {{-- <div class="carousel-caption d-none d-md-block">
          <h5>{{$slidersItem->title}}</h5>
          <p>{{$slidersItem->description}}</p>
        </div> --}}
        <div class="carousel-caption d-none d-md-block">
        <div class="custom-carousel-content">
            <h1>
                {!!$slidersItem->title !!}
            </h1>
            <p>
                {!!$slidersItem->description !!}
            </p>
            <div>
                <a href="#" class="btn btn-slider">
                    Get Now
                </a>
            </div>
        </div>
    </div>
      </div>
      @endforeach

     </div>





    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>


@endsection
