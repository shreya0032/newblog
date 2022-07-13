@extends('admin.layout.app')

@section('content')


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="m-t-0 header-title font-weight-bold text-center">{{ ucfirst($tableName) }} Table</h4>
            </div>
            <div class="card-body">

                <div class="btn-group pull-left  m-t-15">
                    <a href="{{ route('dashboard') }}" class="btn btn-dark"> Back </a>
                </div>

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

                        <table id="example1" class="table table-bordered dt-responsive" width="100%">
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
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>

                        </table>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>

@endsection
