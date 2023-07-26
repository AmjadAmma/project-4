<div>

@include('livewire.admin.category.model-form')


<div class="row">
    <div class="col-md-12">
        @if(session()->has('message'))
            <h2 class="alert alert-success">{{ session()->get('message') }}</h2>
            @endif
      <div class="card">
        <div class="cart-header">
          <h3>Category
            <a href="{{url('admin/category/create')}}" class="btn btn-primary btn-sm float-end">Add Category</a>

          </h3>

        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Action</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                    <tr>
                        <td>{{$category->id}}</td>
                        <td>{{$category->name}}</td>
                        <td>{{$category->Status == '1' ?'Hidden':'Visible'}}</td>
                        <td>
                            <a href="{{url('admin/category/'.$category->id.'/edit')}}" class="btn btn-sm btn-success">Edite</a>
                            <a href="#" wire:click="deleteCategory({{$category->id}})" data-bs-toggle="modal" data-bs-target="#deleteModal" class="btn btn-sm btn-danger">Delete</a>

                        </td>

                    </tr>

                    @endforeach
                </tbody>

            </table>
            <div>
                {{ $categories->links()}}
            </div>

        </div>

      </div>
    </div>
</div>
</div>
@push('script')
<script>
    window.addEventListener('close-modal', event => {
        $('#deleteModal').modal('hide');
    });
</script>
@endpush


