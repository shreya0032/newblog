@extends('admin.layout.app')
@section('content')


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="m-t-0 header-title font-weight-bold text-center">Update User </h4>
                <a class= 'btn btn-dark' href="{{ route('user.index') }}" role="button">Back</a>
            </div>
            <div class="card-body">
                <form action="{{ route('user.update') }}" method="POST" id="updateUserForm" data-redirecturl="{{ route('user.index')}}">
                   
                    @csrf
                    <input type="hidden" name="id" value="{{ $user->id }}">
                    
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" class="form-control" name="name" value="{{ $user->name }}">
                        <span class="text-danger error-text name_error"></span>

                    </div>


                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" id="email" class="form-control" name="email" value="{{ $user->email }}">
                        <span class="text-danger error-text email_error"></span>
                    </div>

                    <div class="form-group">
                        <label for="roles">Role Assign</label>
                        <select id="roles" name="roles" autocomplete="roles-name"
                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            @foreach($roles as $role)
                                @if ($role->name != "super admin")
                                   <option 
                                   @if($user->roles[0]->id == $role->id)
                                    selected style="background-color: #007bff"
                                   @endif
                                   
                                   value="{{ $role->name }}">{{ $role->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <button type="submit" id="submitUpdateForm" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>

            <!-- /.card-body -->
        </div>

    </div>
    <!-- /.col -->
</div>

@endsection


