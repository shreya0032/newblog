@extends('admin.layout.app')
@section('content')


<div class="row">
    <div class="col-12">
        <div class="card">
            {{-- <h2>ss</h2> --}}
            <!-- /.card-header -->
            <div class="card-header">
                <h4 class="m-t-0 header-title">Update Permission </h4>
                {{-- {{ dd($permission) }} --}}
            </div>
            <!-- /.card-header -->

            <!-- /.card-body -->
            <div class="card-body">
                    <form action="{{ route('permission.update') }}" method="POST"
                        id="">
                        @csrf
                        <input type="hidden" name="id" value="{{ $permission->id }}">
                        <div class="form-group">
                            <label for="permission">Permission</label>
                            <input type="text" id="permission" class="form-control" name="name" value={{ $permission->name }}>
                            @error('name')
                                <span class="text-danger error-text role_error">
                                    {{ $message }}
                                </span>
                            @enderror
                            
                        </div>
                        <div class="form-group">
                            <button type="submit" id="submitBtn" class="btn btn-primary btn-block">Submit</button>
                        </div>
                    </form>
            </div>

            <!-- /.card-body -->
        </div>

    </div>
    <!-- /.col -->
</div>

@endsection
