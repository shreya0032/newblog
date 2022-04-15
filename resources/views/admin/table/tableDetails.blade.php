@php

    $urls = url()->current();
    $url = explode('/', $urls);
    $count = sizeOf($url);
    $tableName = $url[$count-1];

    // $columns = DB::getSchemaBuilder()->getColumnListing($tableName);
    // dd($columns);

@endphp

@extends('admin.layout.app')

@section('content')

<div class="row">
    <div class="col-12">

        <div class="card">
            <div class="card-header">
                <h4 class="m-t-0 header-title font-weight-bold text-center">{{ ucfirst($tableName) }} Table</h4>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                
                @if(auth()->user()->can('add'))

                    <div class="btn-group pull-left  m-t-15">
                        <a href="{{ route('product.add', $tableName) }}" class="btn btn-dark"><i
                                class="ion-plus-circled"></i> Add New Item
                        </a>
                    </div>
                @endif


                @if(auth()->user()->can('details'))

                    <div class="btn-group pull-right ">
                        <a class="btn btn-primary"
                            href="{{ route('filter', $tableName) }}">Filter</a>

                    </div>

                    <div class="mt-4">
                        <table id="example1"
                            class="table tableStyle table-bordered table-bordered dt-responsive nowrap dataTable"
                            width="100%">
                            <thead>
                                <tr>
                                    @foreach($columns as $column)

                                        <th>{{ $column }}</th>

                                    @endforeach
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($table_data as $item)

                                    <tr>
                                        @foreach($columns as $column)
                                            <td>{{ $item->$column }}</td>
                                        @endforeach
                                        <td>
                                            @if(auth()->user()->can('edit'))
                                                <a class="edit btn btn-primary btn-sm mr-3"
                                                    href="{{ route('product.edit', [$tableName, $item->id]) }}">Edit</a>
                                            @endif
                                            {{-- @if(auth()->user()->can('delete'))
                                            <a class="delete btn btn-danger btn-sm"
                                                href="{{ route('product.delete', [$tableName, $item->id]) }}">Delete</a>
                                @endif--}}
                                </td>
                                </tr>
                @endforeach

                </tbody>

                </table>
            </div>
            @endif
        </div>

        <!-- /.card-body -->
    </div>

</div>
<!-- /.col -->
</div>

@endsection
