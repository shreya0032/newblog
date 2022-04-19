@extends('admin.layout.app')
@section('content')


<div class="row">
    <div class="col-12">

        <div class="card">

            <!-- /.card-header -->
            <div class="card-header text-center">

                <h4 class="m-t-0 header-title font-weight-bold text-center">User List</h4>
            </div>
            <!-- /.card-header -->

            <!-- /.card-body -->
            <div class="card-body">

                {{-- <div class="btn-group pull-left  m-t-15">
                    @if(auth()->user()->can('add'))
                    <a href="{{ route('user.create') }}" class="btn addBtn waves-effect waves-light"><i
                            class="ion-plus-circled"></i> Create New User
                    </a>
                    @endif
                </div> --}}
                <div class="pull-right">
                    <a class="btn btn-dark" href="{{ route('user.create') }}"><i
                            class="ion-plus-circled"></i> Create New User </a>
                </div>
                 
                {{-- @if(auth()->user()->can('detail')) --}}
                <div class="mt-4">
                    <table id="userlist"
                        class="table tableStyle table-bordered table-bordered dt-responsive nowrap" cellspacing="0"
                        width="100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>

                    </table>
                </div>
                {{-- @endif --}}
            </div>

            <!-- /.card-body -->
        </div>

    </div>
    <!-- /.col -->
</div>

<script>

// $( document ).ready(function() {
//     console.log( "ready!" );
// });


$(document).ready(function () {
//     Swal.fire({
//   title: 'Are you sure?',
//   text: "You won't be able to revert this!",
//   icon: 'warning',
//   showCancelButton: true,
//   confirmButtonColor: '#3085d6',
//   cancelButtonColor: '#d33',
//   confirmButtonText: 'Yes, delete it!'
// }).then((result) => {
//   if (result.isConfirmed) {
//     // Swal.fire(
//     //   'Deleted!',
//     //   'Your file has been deleted.',
//     //   'success'
//     // )
//   }
// })

// $('.testmsg').click(function(event){
//     event.preventDefault();
//     console.log('testmsg');
//     // href
// })
})
</script>

@endsection
