@php
$urls = url()->current();
$url = explode('/', $urls);
$count = sizeOf($url);
$tableName = $url[$count-1];    
@endphp

@extends('admin.layout.app')

@section('content')

<div class="row">
    <div class="col-md-6">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">General</h3>
            </div>

            <div class="card-body">
                <form action="{{ route('filter.search', $tableName) }}" method="GET" id="">
                    {{-- @csrf --}}
                    @foreach ($columns as $column)
                    <div class="form-group">                        
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="operator">{{ $column }}</label>
                                <select class="custom-select" name='select[]' id="operator">
                                    <option selected>Operator</option>
                                    <option value="="> = </option>
                                    <option value=">"> > </option>
                                    <option value=">="> >= </option>
                                    <option value="<"> < </option>
                                    <option value="<="> <= </option>
                                    <option value="like"> LIKE </option>
                                    <option value="like%...%"> LIKE%...% </option>
                                    <option value="not_like"> NOT LIKE </option>
                                    <option value="is_null"> IS NULL </option>
                                    <option value="is_not_null"> IS NOT NULL </option>
                                </select>
                            </div>
                            <input name='column[]' type="text" class="form-control" aria-label="Text input with segmented dropdown button">
                        </div>
                    </div>
                    @endforeach
                    
                    <div class="form-group">
                        <button type="submit" id="" class="btn btn-primary btn-block">Submit</button>
                    </div>
                </form>

            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>



@endsection