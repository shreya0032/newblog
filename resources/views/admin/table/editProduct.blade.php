@php
    // $tables = DB::select('SHOW TABLES');
    // foreach ($tables as $keys => $values) {
    //     foreach ($values as $key => $value) {

    //     }
    // }
    //             //     foreach ($values as $key => $value) 
                    
                //     endforeach
                // endforeach

    $urls = url()->current();
    $url = explode('/', $urls);
    $count = sizeOf($url);
    $lastSeg = $url[$count-3];

// dd($lastSeg);
@endphp

@extends('admin.layout.app')

@section('content')
{{-- {{ dd($data) }} --}}
<div class="row">
    <div class="col-md-6">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">General</h3>
            </div>
            <div class="card-body">
               
                <form id="updateAdminForm" action="{{ route('product.update', $lastSeg) }}" method="POST"
                    enctype="multipart/form-data">
                    
                    @csrf

                    <input type="hidden" name="id" value="{{ $data->id }}">
                    @foreach( $data as $items => $item )
                        <div class="form-group">

                            @if ($items == 'id'|| $items == 'created_at'|| $items == 'updated_at')

                            @else
                                <label for="{{ $items }}">{{ $items }}</label>
                                <input type="text" id="{{ $items }}" class="form-control" name="{{ $items }}"
                                    value="{{ $item }}">
                                <span class="text-danger error-text {{ $items }}_error"></span>
                            @endif
                        </div>
                    @endforeach
                    <div class="form-group">
                        <button type="submit" id="submitBtn" class="btn btn-primary btn-block">Update</button>
                    </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>

@endsection
