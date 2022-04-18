@extends('admin.layout.app')
@section('content')


<div class="row">
    <div class="col-12">
        <div class="card">
            {{-- <h2>ss</h2> --}}
            <!-- /.card-header -->
            <div class="card-header">
                <h4 class="m-t-0 header-title font-weight-bold text-center">Update Permission </h4>
               
                {{-- {{ dd($permission) }} --}}
            </div>
            <!-- /.card-header -->

            <!-- /.card-body -->
            <div class="card-body">
                <a class= 'btn btn-dark mb-3' href="{{ route('permission.index') }}" role="button">BACK</a>
                    <form action="{{ route('permission.update') }}" method="POST"
                        id="updatePermission">
                        @csrf
                        <input type="hidden" name="id" value="{{ $permission->id }}">
                        <div class="form-group">
                            <label for="permission">Permission</label>
                            <input type="text" id="permission" class="form-control" name="name" value={{ $permission->name }}>
                            <span class="text-danger error-text name_error"></span>
                            
                        </div>
                        <div class="form-group">
                            <button type="submit" id="updatePermissionBtn" class="btn btn-primary btn-block">Submit</button>
                        </div>
                    </form>
            </div>

            <!-- /.card-body -->
        </div>

    </div>
    <!-- /.col -->
</div>

@endsection
