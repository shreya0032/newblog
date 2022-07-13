@extends('admin.layout.app')

@section('content')
@role('super admin')
<div class="row">
  <div class="col-lg-3 col-6">
      <div class="small-box bg-warning">
          <div class="inner">
              <h3>
                  @php
                      $count = DB::table('users')->whereNotIn('name', ['super admin'])->count();
                  @endphp
                  {{ $count }}
              </h3>

              <p>User Registrations</p>
          </div>

      </div>
  </div>
</div>
@endrole
@endsection
