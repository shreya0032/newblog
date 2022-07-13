@php
    // foreach ($data as $item => $item) {
    // // array_splice($item, -1);
    // if ($item == "product_file ") {
    // $input_type = "file";
    // }
    // else{
    // $input_type = "text";
    // }
    // };

    // $tables = DB::select('SHOW TABLES');

$urls = url()->current();
$url = explode('/', $urls);
$count = sizeOf($url);
$lastSeg = $url[$count-2];

    // dd($lastSeg);


@endphp

@extends('admin.layout.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                    <div class="card-title btn-group pull-left  m-t-15">
                        <a href="{{ route('table.show', $lastSeg) }}" class="btn btn-dark"> Back </a>
                    </div>
                
                <h4 class="m-t-0 header-title font-weight-bold text-center">Add {{ ucfirst($lastSeg) }}</h4>
            </div>

            <div class="card-body">
                @if (Session::get('msg'))
                    <div class="alert alert-danger">
                        <ul>
                            <li>{{ Session::get('msg') }}</li>
                        </ul>
                    </div>
                    
                @endif

                <form action="{{ route('product.add.save', $lastSeg) }}" method="POST" id="{{ $lastSeg }}">
                    @csrf
                    @foreach( $data as $items => $item )

                        <div class="form-group">
                            
                            @if ($item == 'id'|| $item == 'created_at'|| $item == 'updated_at')

                            @else

                                <label for="{{ $item }}">{{ ucwords(str_replace('_', ' ', $item )) }}</label>
                                <input type="text" id="{{ $item }}" class="form-control" name="{{ $item }}">
                                <span class="text-danger error-text {{ $item }}_error"></span>

                            @endif

                        </div>
                    @endforeach
                    <div class="form-group">
                        <button type="submit" id="" class="btn btn-primary">Submit</button>
                    </div>
                </form>

            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection
