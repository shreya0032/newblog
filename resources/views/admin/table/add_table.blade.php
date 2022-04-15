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
    <div class="col-md-6">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">General</h3>
            </div>

            <div class="card-body">
                <form action="{{ route('product.add.save', $lastSeg) }}" method="POST" id="">
                    @csrf
                    @foreach( $data as $items => $item )

                        <div class="form-group">
                            
                            @if ($item == 'id'|| $item == 'created_at'|| $item == 'updated_at')

                            @else

                                <label for="{{ $item }}">{{ $item }}</label>
                                <input type="text" id="{{ $item }}" class="form-control" name="{{ $item }}">
                                <span class="text-danger error-text {{ $item }}_error"></span>

                            @endif

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
