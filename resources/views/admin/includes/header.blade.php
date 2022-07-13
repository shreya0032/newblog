<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle displayProfile" data-backdrop="false" data-toggle="dropdown" href="#">
                <span class="hidden-xs">{{ ucwords(auth()->user()->name) }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="max-width: 500px">
                <div class="user-panel mt-3 pb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('assets/backend/dist/img/upload/'.auth()->user()->avatar) }}"
                            class="img-circle" alt="User Image">
                    </div>
                    <div class="info">
                        <h4>{{ (auth()->user()->name) }}</h4>
                        <p class="text-muted">{{ auth()->user()->email }}</p>
                        <a href="#" class="btn btn-danger btn-rounded avatar" data-toggle="modal" data-target="#modal-avatar">Update Avatar</a>
                    </div>
                </div>
                <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item profile" data-toggle="modal" data-target="#modal-profile" data-id={{ auth()->user()->id }} data-url={{ route('get.user.profile') }}>
                        <i class="fas fa-user-edit mr-2"></i> Update My Profile
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


<div class="modal fade" id="modal-profile" tabindex="-1" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header ">
                <h4 class="modal-title w-100 font-weight-bold text-center">Update My Profile</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('user.profile') }}" method="POST" id="updateUserProfile">
                    @csrf
                    <input type="hidden" name="profile_id" id="profile_id">

                    <div class="form-group">
                        <label for="name">User Name</label>
                        <input type="text" id="username" class="form-control" name="user_name">
                            
                        <span class="text-danger error-text user_name_error"></span>

                    </div>


                    <div class="form-group">
                        <label for="email">User Email</label>
                        <input type="text" id="useremail" class="form-control" name="user_email">
                            
                        <span class="text-danger error-text user_email_error"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" form="updateUserProfile" id="submitUserProfile" class="btn btn-primary">Update</button>
                
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modal-avatar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title w-100 font-weight-bold text-center">Update My Avatar</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('user.avatar') }}" method="POST" id="updateUserAvatar" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ auth()->user()->id }}">

                    <div class="form-group">
                        <label for="exampleInputFile">File input</label>
                        <div class="input-group">
                          <div class="custom-file">
                            <input type="file" name="avatar" id="avatar_file">
                          </div>
                        </div>
                        <span class="text-danger error-text avatar_error"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" form="updateUserAvatar"  class="btn btn-primary" id="submitUserAvatar">Upload</button>
            </div>
        </div>
    </div>
</div>