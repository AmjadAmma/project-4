@extends('layouts.admin')


@section('content')

<div class="row">
    <div class="col-md-12">
        @if(session()->has('message'))
            <div class="alert alert-success">{{ session()->get('message') }}</div>
            @endif
      <div class="card">
        <div class="cart-header p-2">
          <h3>Colors List
            <a href="{{url('admin/colors/create')}}" class="btn btn-primary btn-sm text-wihte float-end">Add Color</a>

          </h3>

        </div>
        <div class="card-body">

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Color Name</th>
                        <th>Color Color</th>
                        <th>Status</th>
                        <th>Action</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach($colors as $item)
                    <tr>
                        <td>{{$item->name}}</td>
                        <td>{{$item->code}}</td>
                        <td>{{$item->Status == '1' ?'Hidden':'Visible'}}</td>
                        <td>
                            <a href="{{url('admin/colors/'.$item->id.'/edit')}}" class="btn btn-sm btn-success">Edite</a>
                            <a href="{{url('admin/colors/'.$item->id.'/delete')}}" onclick="return confirm('Are you sure, you want to delete this date?')" class="btn btn-sm btn-danger">Delete</a>


                        </td>

                    </tr>

                    @endforeach
                </tbody>

            </table>





        </div>
    </div>
  </div>
</div>

@endsection