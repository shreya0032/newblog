@extends('admin.layout.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-row card-default">
            <div class="card-header bg-info">
                <h3 class="card-title">
                    Manage Permission
                </h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('roles.permission.update') }}">
                    @csrf   
                    @foreach($permissionTable as $permission)
                        <div class="card card-light card-outline">
                            <div class="card-header">
                                <!-- <h5 class="card-title">{{ $permission->name }}</h5> -->
                                <h5 class="card-title"><input type="checkbox" class="form-check-input" name="permissionTable[]" value="{{ $permission->name }}">{{ $permission->name }}</h5>
                            </div>
                            <div class="card-body">
                                @foreach($permissionView as $permissions)
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="permissionView['{{ $permission->name }}'][]" value="{{ $permissions->name }}">{{ $permissions->name }}
                                        <!-- <label class="form-check-label" for="exampleCheck1">{{ $permissions->name }}</label> -->
                                        
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach

                    <!-- <button type="submit" id="updateManagePermissionBtn" class="btn btn-primary">Save Changes</button> -->
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>

            </div>
        </div>
    </div>
</div>



@endsection
