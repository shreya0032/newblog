@extends('admin.layout.app')

@section('content')
<div class="row">
    <div class="col-12">
<div class="card">
    <!-- /.card-header -->
    <div class="card-header">
        <h4 class="m-t-0 header-title font-weight-bold text-center"> Manage Permissions </h4>
        {{-- <a class="btn btn-dark" href="{{ route('roles.index') }}">Back </a> --}}
    </div>
    <!-- /.card-header -->


    <!-- /.card-body -->
    <div class="card-body">
       
        <a class="btn btn-dark" href="{{ route('roles.index') }}">Back </a>
        <form method="POST" action="{{ route('roles.permission.update') }}"
            id="updateManagePermission" data-redirecturl="">
            @csrf

            <input type="hidden" name="id" value="{{ $roles->id }}">

            <div class="flex space-x-2 mt-4 p-2">
                <h4>Table view permission</h4>
                @if($roles->permissions)
                    @foreach($roles->permissions as $role_permission)
                        @if($role_permission->name == 'add' ||$role_permission->name == 'edit'|| $role_permission->name == 'details')
                        <button class="mr-3 rounded">
                                <a href="" class="delete btn btn-info btn-sm link-light deleteper" data-type="delete"  title="Delete">
                                    "{{ $role_permission->name }}"
                                </a>
                                <i data-href="{{ route('roles.permission.delete', [$roles->id, $role_permission->id]) }}" class="fa fa-times deletePermission" aria-hidden="true" id=""  style="color: black;"></i>                                                
                            
                        </button>
                        @endif
                    @endforeach
                @endif
            </div>

            <div class="sm:col-span-6">
                <label for="permission" class="block font-medium text-gray-700">Permission</label>
                <select id="permission" name="permission" autocomplete="permission-name"
                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value=" " selected>Select your option</option>
                    @foreach($permissionView as $permission)
                        <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                    @endforeach
                </select>
                <span class="text-danger error-text name_error"></span>
            </div>


            <div class="flex space-x-2 p-2">   
                <h4>Table permission</h4> 
                @if($roles->permissions)
                    @foreach($roles->permissions as $role_permission)
                        @if($role_permission->name == 'add' ||$role_permission->name == 'edit'|| $role_permission->name == 'details' ||$role_permission->name == 'delete')
                            @continue
                        @endif
                        <button class="mr-3 rounded">
                            <a href="" class="delete btn btn-info btn-sm link-light deleteper" data-type="delete"  title="Delete">
                                {{ $role_permission->name }}
                            </a>
                            <i data-href="{{ route('roles.permission.delete', [$roles->id, $role_permission->id]) }}" class="fa fa-times deletePermission" aria-hidden="true" id=""  style="color: black;"></i>                                                
                        
                        </button>
                    @endforeach
                @endif
            </div>
            
            <div class="sm:col-span-6">
                <label for="table_permission" class="block text-sm font-medium text-gray-700">Table Permission</label>
                <select id="table_permission" name="table_permission" 
                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value=" " selected>Select your option</option>
                    @foreach($permissionTable as $permission)
                        <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                    @endforeach
                </select>
                <span class="text-danger error-text name_error"></span>
            </div>

            {{-- px-4 py-2 bg-green-500 hover:bg-green-700 rounded-md --}}

            <div class="sm:col-span-6 pt-5">
                <button type="submit" id="updateManagePermissionBtn" class="btn btn-primary">Assign</button>
            </div>
        </form>
    </div>
</div>
</div>
</div>

</div>

@endsection
