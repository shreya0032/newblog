@extends('admin.layout.app')

@section('content')
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
          <div class="inner">
            <h3>
              @php
                $count = DB::table('users')->whereIn('name', ['super admin'])->count();
              @endphp
              {{ $count }}
            </h3>

            <p>User Registrations</p>
          </div>
          
        </div>
      </div>
      
    </div>
    <!-- /.row -->
  
    
    

@endsection