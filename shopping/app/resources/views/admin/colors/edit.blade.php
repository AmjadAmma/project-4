@extends('layouts.admin')


@section('content')

<div class="row">
    <div class="col-md-12">
        @if(session()->has('message'))
            <div class="alert alert-success">{{ session()->get('message') }}</div>
            @endif
      <div class="card">
        <div class="cart-header p-2">
          <h3>Edit Color
            <a href="{{url('admin/colors')}}" class="btn btn-danger btn-sm text-wihte float-end">Back</a>

          </h3>

        </div>
        <div class="card-body">
            <form action="{{url('admin/colors/'.$color->id)}}"method="POST">
                @csrf
                @method('put')


                <div class="mb-3">
                    <label>Color Name</label>
                    <input type="text" name="name" value="{{$color->name}}" class="form-control"/>

                </div>
                <div class="mb-3">
                    <label>Color code</label>
                    <input type="text" name="code" value="{{$color->code}}" class="form-control"/>

                </div>
                <div class="mb-3">
                    <label>Status</label><br/>
                    <input type="checkbox" name="status" {{$color->status? 'checked':''}} style="width:20px;height:20px"/>Checket=Hiddden,UnChecken=Visible

                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Update</button>

                </div>

            </form>





        </div>
    </div>
  </div>
</div>

@endsection
