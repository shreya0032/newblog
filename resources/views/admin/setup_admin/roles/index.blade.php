@extends('admin.layout.app')
@section('content')


<div class="row">
    <div class="col-12">

        <div class="card">

            <!-- /.card-header -->
            <div class="card-header">
                <h4 class="m-t-0 header-title font-weight-bold text-center">Role Lists</h4>
            </div>
            <!-- /.card-header -->

            <!-- /.card-body -->
            <div class="card-body">
                
                <div class="pull-right">
                    <a class="btn btn-dark" href="{{ route('roles.create') }}"><i
                        class="ion-plus-circled"></i> Add New Role</a>
                </div>


                <div class='mt-3'>
                    <table id="rolelist"
                    class="table tableStyle table-bordered table-bordered dt-responsive nowrap" cellspacing="0"
                    width="100%">
                    <thead>
                        <tr>
                            <th>Sl no</th>
                            <th>Roles</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    {{-- @foreach($roles as $item )
                    <tbody>
                        
                           <td>{{ $item->id }}</td>
                           <td>{{ $item->name }}</td>
                        
                            <td>
                                <a href="{{ route('roles.edit', $item->id) }}" class="edit btn btn-primary btn-sm">Edit</a>
                                <a href="{{ route('roles.delete', $item->id) }}" class="edit btn btn-danger btn-sm">Delete</a>
                                <a href="{{ route('roles.permission', $item->id) }}" class="edit btn btn-success btn-sm">Manage Permission</a>
                            </td>
                           
                    </tbody>
                    @endforeach --}}

                    <tbody>

                    </tbody>

                </table>
                </div>
            </div>

            <!-- /.card-body -->
        </div>

    </div>
    <!-- /.col -->
</div>

@endsection
