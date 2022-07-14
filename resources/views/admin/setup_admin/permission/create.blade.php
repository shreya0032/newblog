@extends('admin.layout.app')
@section('content')


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="m-t-0 header-title font-weight-bold text-center">Add Permission Table</h4>

            </div>

            <div class="card-body">
                <a class='btn btn-dark mb-3' href="{{ route('permission.index') }}"
                    role="button">Back</a>

                <form action="{{ route('permission.store') }}" method="POST" id="permissionForm"
                    data-redirecturl="{{ route('permission.index') }}">
                    @csrf
                    {{-- <div class="form-group">
                            <label for="permission">Permission</label>
                            <input type="text" id="permission" class="form-control" name="name">
                            <span class="text-danger error-text name_error"></span>
                        </div> --}}   

                    <div class="form-group">
                        <label for="permission">Permission</label>
                        <select id="permission" name="name" class="form-control">
                            <option value=" ">Choose table for permission</option>
                            @foreach($dynamic_table as $table)
                                <option value="{{ $table->Tables_in_dbms }}">{{ $table->Tables_in_dbms }}</option>
                            @endforeach
                        </select> 
                        <span class="text-danger error-text name_error"></span>
                    </div>

                    <div class="form-group">
                        <button type="submit" id="submitPermissionBtn" class="btn btn-primary">Submit</button>
                        <!-- <button type="submit" class="btn btn-primary">Submit</button> -->
                    </div>




                </form>
            </div>
        </div>
    </div>
</div>

@endsection
