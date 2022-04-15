@extends('admin.layout.app')
@section('content')


<div class="row">
    <div class="col-12">
        <div class="card">
            {{-- <h2>ss</h2> --}}
            <!-- /.card-header -->
            <div class="card-header">
                <h4 class="m-t-0 header-title">Update Permission </h4>
                <a class= 'btn btn-dark' href="{{ route('roles.index') }}" role="button">BACK</a>
                {{-- {{ dd($permission) }} --}}
            </div>
            <!-- /.card-header -->

            <!-- /.card-body -->
            <div class="card-body">
                    <form action="{{ route('roles.update') }}" method="POST"
                        id="updateRoleForm">
                        @csrf
                        <input type="hidden" name="id" value="{{ $roles->id }}">
                        <div class="form-group">
                            <label for="permission">Role Name</label>
                            <input type="text" id="permission" class="form-control" name="name" value={{ $roles->name }}>
                            <span class="text-danger error-text name_error"></span>                                 
                        </div>
                        <div class="form-group">
                            <button type="submit" id="updateRoleBtn" class="btn btn-primary btn-block">Submit</button>
                        </div>
                    </form>
            </div>

            <!-- /.card-body -->
        </div>

    </div>
    <!-- /.col -->
</div>

@endsection
