@extends('admin.layout.app')

@section('content')
<div class="row">
    <div class="col-12">
        {{-- <div class="py-12 w-full">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-2">
                <div class="flex p-2">
                    <a href="{{ route('roles.index') }}"
        class="px-4 py-2 bg-green-700 hover:bg-green-500 text-slate-100 rounded-md">Role Index</a>
    </div>

    <div class="mt-6 p-2 bg-slate-100">
        <h2 class="text-2xl font-semibold">Role Permissions</h2>
        <div class="flex space-x-2 mt-4 p-2">
            @if($roles->permissions)
                @foreach($roles->permissions as $role_permission)
                    <button>
                        <a
                            href="{{ route('roles.permission.delete', [$roles->id, $role_permission->id]) }}">{{ $role_permission->name }}</a>
                    </button>

                @endforeach
            @endif
        </div>


        <div class="max-w-xl mt-6">
            <form method="POST" action="{{ route('roles.permission.update') }}">
                @csrf

                <input type="hidden" name="id" value="{{ $roles->id }}">

                <div class="sm:col-span-6">
                    <label for="permission" class="block text-sm font-medium text-gray-700">Permission</label>
                    <select id="permission" name="permission" autocomplete="permission-name"
                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @foreach($permissions as $permission)
                            <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                        @endforeach
                    </select>
                </div>



                <div class="sm:col-span-6 pt-5">
                    <button type="submit" class="px-4 py-2 bg-green-500 hover:bg-green-700 rounded-md">Assign</button>
                </div>
            </form>
        </div>


    </div>
</div>
</div>
</div> --}}


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
            id="updateManagePermission">
            @csrf

            <input type="hidden" name="id" value="{{ $roles->id }}">



            <div class="flex space-x-2 mt-4 p-2">
                <h4>Table view permission</h4>
                @if($roles->permissions)
                    @foreach($roles->permissions as $role_permission)
                        @if($role_permission->name == 'add' ||$role_permission->name == 'edit'|| $role_permission->name == 'details')
                            <button class="btn btn-success link-light">
                                
                                <i class="fa fa-times" aria-hidden="true" id="close" style="color: red;"></i>                                                
    
                                    {{ $role_permission->name }}
                            </button>
                        @endif
                    @endforeach
                @endif
            </div>

            <div class="sm:col-span-6">
                <label for="permission" class="block font-medium text-gray-700">Permission</label>
                <select id="permission" name="permission" autocomplete="permission-name"
                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value=""></option>
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
                        <button class="btn btn-success link-light">
                            <a class="btn btn-success link-light" href="{{ route('roles.permission.delete', [$roles->id, $role_permission->id]) }}" role="button">
                            <i class="fa fa-times" aria-hidden="true" id="close" style="color: red;"></i>                                                
    
                                {{ $role_permission->name }}
                                
                            </a>
                        </button>
                    @endforeach
                @endif
            </div>

            <div class="sm:col-span-6">
                <label for="table_permission" class="block text-sm font-medium text-gray-700">Table Permission</label>
                <select id="table_permission" name="table_permission" 
                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    {{-- <option value=""></option>
                    @foreach ($tables as $table)
                        @foreach ( $table as $tableList)
                            <option value="{{ $tableList }}">{{ $tableList }}</option>
                        @endforeach                        
                    @endforeach --}}

                    <option value=""></option>
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
