@php

    $urlArray = explode('/', url()->current());
    // dd($urlArray[3]);
@endphp 
 
 <!-- Navbar -->
 <nav class="main-header navbar navbar-expand navbar-white navbar-light">
     <!-- Left navbar links -->
     <ul class="navbar-nav">
         <li class="nav-item">
             <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
         </li>
         {{-- <li class="nav-item d-none d-sm-inline-block">
             <a href="{{ route('home') }}" class="nav-link">home</a>
         </li> --}}
         
     </ul>

     <!-- Right navbar links -->
     <ul class="navbar-nav ml-auto">
         <li class="nav-item dropdown">
           
            <a data-toggle="dropdown" href="#">
                
                    {{-- <img src="{{ asset('assets/backend/dist/img/default_avatar.jpg') }}"
                class="user-img" alt="User Image"> --}}
                
                
                <span class="hidden-xs">{{ ucwords(auth()->user()->name) }}</span>
            </a>
             <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('assets/backend/dist/img/default_avatar.jpg') }}"
                    class="user-img" alt="User Image">
                    </div>
                    <div class="info">
                        <h4>{{ ucwords(auth()->user()->name) }}</h4>
                        <p class="text-muted">{{ auth()->user()->email }}</p>
                        <a href="" class="btn btn-danger btn-rounded">Update Avatar</a>
                    </div>
                </div>
                <div class="dropdown-divider"></div>
                
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal-default">
                    <i class="fas fa-user-edit mr-2"></i> Update My Profile
                    
                </a>                
                <a href="#" class="dropdown-item">
                    <i class="fas fa-lock mr-2"></i> Update Password
                    
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
             </div>
            
         </li>


     </ul>
 </nav>

 <div class="modal fade" id="modal-default">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Update My Profile</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          {{-- <p>One fine body&hellip;</p> --}}
          <form action="{{ route('user.update') }}" method="POST" id="updateUserForm">
            {{-- updateUserForm --}}
            @csrf
            <input type="hidden" name="id" value="{{ auth()->user()->id }}">
            
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" class="form-control" name="name" value="{{ auth()->user()->name }}">
                <span class="text-danger error-text name_error"></span>

            </div>


            <div class="form-group">
                <label for="email">User Email</label>
                <input type="text" id="email" class="form-control" name="email" value="{{ auth()->user()->email }}">
                <span class="text-danger error-text email_error"></span>

            </div>
            <div class="form-group">
                <button type="submit" id="submitUpdateForm" class="btn btn-primary btn-block">Update</button>
            </div>
        </form>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>