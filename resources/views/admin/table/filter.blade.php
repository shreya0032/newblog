@php
$urls = url()->current();
$url = explode('/', $urls);
$count = sizeOf($url);
$tableName = $url[$count-1];    
@endphp

@extends('admin.layout.app')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="header-title font-weight-bold text-center">Filter</h4>
                
            </div>

            <div class="card-body">
                @if (Session::get('msg'))
                    <div class="alert alert-danger">
                        <ul>
                            <li>{{ Session::get('msg') }}</li>
                        </ul>
                    </div>
                    
                @endif
                <form action="{{ route('filter.search', $tableName) }}" method="POST" id="">
                    @csrf
                    @foreach ($columns as $column)
                    <div class="form-group">                        
                        <div class="input-group mb-3">
                            {{-- <div class="input-group-prepend"> --}}
                                <label class="input-group-text" for="operator">{{ $column }}</label>
                                <select class="form-select" name='select[]' id="operator">
                                    <option selected >Operator</option>
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
                            {{-- </div> --}}
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