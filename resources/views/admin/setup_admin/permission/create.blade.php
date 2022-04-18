@php
    $tables = DB::connection('mysql2')->select('SHOW TABLES');
    // foreach ($tables as $item){
    //     dd($tables);
    //     dd($item->Tables_in_onepatch_dynamic);
    // }
    
    // endforeach    // Permission::create($tables);
@endphp

@extends('admin.layout.app')
@section('content')


<div class="row">
    <div class="col-12">
        <div class="card">
            {{-- <h2>ss</h2> --}}
            <!-- /.card-header -->
            <div class="card-header">
                <h4 class="m-t-0 header-title font-weight-bold text-center">Add Permission </h4>
                
            </div>
            <!-- /.card-header -->
            
            <!-- /.card-body -->
            <div class="card-body">
                <a class= 'btn btn-dark mb-3' href="{{ route('permission.index') }}" role="button">BACK</a>
                    
                    <form action="{{ route('permission.store') }}" method="POST" id="permissionForm" >
                        @csrf
                        <div class="form-group">
                            <label for="permission">Permission</label>
                            <input type="text" id="permission" class="form-control" name="name">
                            <span class="text-danger error-text name_error"></span>
                        </div>
                        <div class="form-group">
                            <button type="submit" id="submitPermissionBtn" class="btn btn-primary btn-block">Submit</button>
                        </div>
                    </form>
            </div>

            <!-- /.card-body -->
        </div>

    </div>
    <!-- /.col -->
</div>

@endsection
