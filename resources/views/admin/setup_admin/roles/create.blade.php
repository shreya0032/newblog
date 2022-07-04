@extends('admin.layout.app')
@section('content')


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="m-t-0 header-title font-weight-bold text-center">Add Role </h4>
                <a class= 'btn btn-dark' href="{{ route('roles.index') }}" role="button">Back</a>
            </div>
            <div class="card-body">
                    <form action="{{ route('roles.store') }}" method="POST" data-redirecturl="{{ route('roles.index')}}" id="roleForm">
                        @csrf
                        <div class="form-group">
                            <label for="role">Role</label>
                            <input type="text" id="role" class="form-control" name="name">
                            <span class="text-danger error-text name_error"></span>                           
                        </div>

                        <div class="form-group">
                            <button type="submit" id="roleSubmitBtn" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
            </div>
        </div>

    </div>
</div>

@endsection
