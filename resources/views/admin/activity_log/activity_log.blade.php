@extends('admin.layout.app')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="m-t-0 header-title font-weight-bold text-center">Activity Log</h4>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="activity-log"
                    class="table tableStyle table-bordered table-bordered dt-responsive nowrap dataTable" width="100%">
                    <thead>
                        <tr>
                            
                            <th>Table Name</th>
                            <th>Description</th>
                            <th>Role</th>
                            <th>Previous Info</th>
                            <th>Present Info</th>
                        </tr>
                    </thead>

                    <tbody>

                    </tbody>

                </table>

            </div>

            <!-- /.card-body -->
        </div>
    </div>
</div>

    @endsection
