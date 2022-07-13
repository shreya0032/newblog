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
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                {{-- <h3 class="card-title ">--}}
                    <div class="card-title btn-group pull-left  m-t-15">
                        <a href="{{ route('table.show', $lastSeg) }}" class="btn btn-dark"> Back </a>
                    </div>
                {{--</h3> --}}
                <h4 class="m-t-0 header-title font-weight-bold text-center">Update {{ ucfirst($lastSeg) }}</h4>
                
            </div>
            
            <div class="card-body">
                @if (Session::get('msg'))
                    <div class="alert alert-danger">
                        <ul>
                            <li>{{ Session::get('msg') }}</li>
                        </ul>
                    </div>
                    
                @endif
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
                        <button type="submit" id="submitBtn" class="btn btn-primary">Update</button>
                    </div>
            </div>
        </div>
    </div>
</div>

@endsection
