@extends('admin.layout.app')
@section('content')


<div class="row">
    <div class="col-12">
        <div class="card">
            {{-- <h2>ss</h2> --}}
            <!-- /.card-header -->
            <div class="card-header">
                <h4 class="m-t-0 header-title font-weight-bold text-center">Update User </h4>
                <a class= 'btn btn-dark' href="{{ route('user.index') }}" role="button">Back</a>
            </div>
            <!-- /.card-header -->

            <!-- /.card-body -->
            <div class="card-body">
                <form action="{{ route('user.update') }}" method="POST" id="updateUserForm">
                    {{-- updateUserForm --}}
                    @csrf
                    <input type="hidden" name="id" value="{{ $user->id }}">
                    
                    <div class="form-group">
                        <label for="name">User Name</label>
                        {{-- {{ dd($user->name) }} --}}
                        <input type="text" id="name" class="form-control" name="name" value={{ $user->name }}>
                        <span class="text-danger error-text name_error"></span>

                    </div>


                    <div class="form-group">
                        <label for="email">User Email</label>
                        <input type="text" id="email" class="form-control" name="email" value={{ $user->email }}>
                        <span class="text-danger error-text email_error"></span>

                    </div>


                    <div class="form-group">
                        <label for="permission">User Roles:</label>
                        @if ($user->roles)
                            @foreach ($user->roles as $user_role)
                            <span class='badge badge-success'>{{ $user_role->name }}</span>
                            @endforeach
                        @endif
                    </div>


                    <div class="form-group">
                        <label for="roles">Role Assign</label>
                        <select id="roles" name="roles" autocomplete="roles-name"
                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value=" " selected>Select your option</option>
                            @foreach($roles as $role)
                                @if ($role->name == "super admin")
                                    <option hidden></option>
                                @else
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endif
                                    
                            @endforeach
                        </select>

                    </div>

                    {{-- <div class="form-group">
                        <label for="permission">User Permission on Table:</label>
                        @if ($user->permissions)
                            @foreach ($user->permissions as $user_role)
                            
                            <span class='badge badge-success'>{{ $user_role->name }}</span>
                            <form method="POST" action="{{ route('user.role.delete', [$user->id, $user_role->id]) }}"
                                    onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    
                                    <button  class="btn btn-success">{{ $user_role->name }}</button>
                            </form>
                            @endforeach
                        @endif
                    </div> --}}


                    {{-- <div class="form-group">
                        <label for="permission">Permission Assign</label>
                        <select id="permission" name="permission" autocomplete="permission-name"
                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value=""></option>
                            @foreach($permissions as $permission)
                                <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                            @endforeach
                        </select>
                    </div> --}}

                    <div class="form-group">
                        <button type="submit" id="submitUpdateForm" class="btn btn-primary btn-block">Update</button>
                    </div>
                </form>
            </div>

            <!-- /.card-body -->
        </div>

    </div>
    <!-- /.col -->
</div>

@endsection


