@extends('admin.layout.app')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="pull-left">
                    <h4 class="m-t-0 header-title font-weight-bold text-center">Create New User</h4>
                </div>

                <div class="pull-right">
                    <a class="btn btn-dark" href="{{ route('user.index') }}"> Back</a>
                </div>
                
            </div>

            <div class="card-body">

                <form action="{{ route('user.store') }}" method="POST" id="createUserForm" data-redirecturl="{{ route('user.index')}}">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" placeholder="Name" class="form-control" value="">
                            <span class="text-danger error-text name_error"></span>
                        </div>
            
                        <div class="form-group col-md-12" >
                            <label for="email">Email</label>
                            <input type="text" name="email" id="email" placeholder="Email" class="form-control" value="">
                            <span class="text-danger error-text email_error"></span>
                        </div>
            
                        <div class="form-group col-md-6">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <span toggle="#password" class="fa fa-fw fa-eye-slash field-icon toggle-password"></span>
                                    </div>
                                </div>
                                <input type="password" name="password" id="password" placeholder="Password" class="form-control" value="">
                            </div>
                            
                            <span class="text-danger error-text password_error"></span>
                        </div>
            
                        <div class="form-group col-md-6">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <span toggle="#confirmPassword" class="fa fa-fw fa-eye-slash field-icon toggle-password"></span>
                                    </div>
                                </div>
                                <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirm Password" class="form-control" value="">
                            </div>
                            
                            <span class="text-danger error-text confirmPassword_error"></span>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="roles">Role Assign</label>
                            <select id="roles" name="roles" autocomplete="roles-name"
                                class="form-select" aria-label="Default select example">
                                <option value=" ">Choose a role</option>
                                    @foreach($roles as $role)
                                        @if ($role->name != "super admin")
                                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                                        @endif
                                            
                                    @endforeach
                            </select> <br> 
                            <span class="text-danger error-text roles_error"></span>  
                        </div>

                        <div class="form-group col-md-12">
                            <button type="submit" id="submitUserForm" class="btn btn-primary">Submit</button>                            
                        </div>
                </form>
            </div>
        </div>

        
    </div>
</div>



@if(Session::get('error'))
<span style="color:red">{{Session::get('error')}}</span>
@endif


@endsection
