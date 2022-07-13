@extends('admin.layout.app')
@section('content')


<div class="row">
    <div class="col-12">
        <div class="card">
            {{-- <h2>ss</h2> --}}
            <!-- /.card-header -->
            <div class="card-header">
                <h4 class="m-t-0 header-title font-weight-bold text-center">Update Role </h4>
            </div>
            <!-- /.card-header -->

            <!-- /.card-body -->
            <div class="card-body">
                <a class= 'btn btn-dark mb-3' href="{{ route('roles.index') }}" role="button">Back</a>
                    <form action="{{ route('roles.update') }}" method="POST"
                              data-redirecturl="{{ route('roles.index')}}"
                        id="updateRoleForm">
                        @csrf
                        <input type="hidden" name="id" value="{{ $roles->id }}">
                        <div class="form-group">
                            <label for="permission">Role Name</label>
                            <input type="text" id="permission" class="form-control" name="name" value="{{ $roles->name }}">
                            <span class="text-danger error-text name_error"></span>                                 
                        </div>
                        <div class="form-group">
                            <button type="submit" id="updateRoleBtn" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
            </div>

            <!-- /.card-body -->
        </div>

    </div>
    <!-- /.col -->
</div>

@endsection
