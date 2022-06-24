@extends('admin.layout.app')
@section('content')

{{-- @csrf --}}
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
                            <th><input type="checkbox" name="all_checkbox" id="checkAll"></th>
                            <th>Roles</th>
                            <th>Action <button type="button" class="btn btn-sm btn-danger d-none" id="deleteAll">Delete All</button> </th>

                        </tr>
                    </thead>
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
