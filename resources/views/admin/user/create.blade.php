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

                <form action="{{ route('user.store') }}" method="POST" id="createUserForm">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="name">Name<span class="text-danger">*</span></label>
                            <span class="text-danger error-text name_error"></span>
                        </div>
            
                        <div class="form-group col-md-12" >
                            <label for="email">Email<span class="text-danger">*</span></label>
                            <input type="text" name="email" id="email" placeholder="Email" class="form-control" value="">
                            {{-- <span role="alert" id="emailErr" style="color:red;font-size: 12px"></span> --}}
                            <span class="text-danger error-text email_error"></span>
                        </div>
            
                        <div class="form-group col-md-6">
                            <label for="password">Password<span class="text-danger">*</span></label>
                            <div class="input-group">
                                {{-- <div class="input-group-addon"> --}}
                                    <span toggle="#password" class="fa fa-fw fa-eye-slash field-icon toggle-password"></span>
                                {{-- </div> --}}
                                <input type="password" name="password" id="password" placeholder="Password" class="form-control" value="">
                            </div>
                            <span class="text-danger error-text password_error"></span>
                        </div>
            
                        <div class="form-group col-md-6">
                            <label for="confirmPassword">Confirm Password<span class="text-danger">*</span></label>
                            <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirm Password" class="form-control" value="">
                            {{-- <span role="alert" id="confirmPasswordErr" style="color:red;font-size: 12px"></span> --}}
                            <span class="text-danger error-text confirmPassword_error"></span>
                        </div>
            
                        <!-- <div class="form-group col-md-12">
                            <label for="role">Role<span class="text-danger"></span></label>
                            <select name="roles" id="role" class="selectpicker" data-style="btn-primary btn-custom">
                                <option value="">Select Role Type</option>
                                
                                {{-- @foreach ($roles as $item)
                                
                                <option value="{{ $item}}">{{ $item }}</option>
                                @endforeach --}}
                            </select>
                            <span role="alert" id="roleErr" style="color:red;font-size: 12px"></span>
                        </div> -->
                        
                        <div class="form-group col-md-3">
                            <button type="submit" id="submitUserForm" class="btn btn-primary btn-block">Submit</button>
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
