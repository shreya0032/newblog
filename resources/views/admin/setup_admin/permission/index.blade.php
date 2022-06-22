@extends('admin.layout.app')
@section('content')


<div class="row">
    <div class="col-12">

        <div class="card">

            <!-- /.card-header -->
            <div class="card-header">
                <h4 class="m-t-0 header-title font-weight-bold text-center">Permission List</h4>
            </div>
            <!-- /.card-header -->

            <!-- /.card-body -->
            <div class="card-body">

                <div class="mt-4">
                    <table id="permissionList"
                        class="table tableStyle table-bordered table-bordered dt-responsive nowrap" cellspacing="0"
                        width="100%">
                        <thead>
                            <tr>
                                <th>Permission</th>
                            </tr>
                        </thead>

                        <tbody>

                        </tbody>

                    </table>
                </div>

                <div class="mt-4">
                    <div class="pull-right">
                        <a class="btn btn-dark" href="{{ route('permission.create') }}"><i
                                class="ion-plus-circled"></i> Add New Table</a>
                    </div>
                </div>
                <div class="mt-4">
                    <table id="dynamicTableList"
                        class="table tableStyle table-bordered table-bordered dt-responsive nowrap" cellspacing="0"
                        width="100%">
                        <thead>
                            <tr>
                                <th>Table Name</th>
                                <th>Action</th>
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
