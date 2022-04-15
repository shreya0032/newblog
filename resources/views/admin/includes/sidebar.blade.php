@php    
    $dynamic_table = DB::connection('mysql2')->select('SHOW TABLES');
    
    // $permissionNames = auth()->user()->getPermissionNames();
    

    // foreach ($dynamic_table as $keys => $values) {
    //     foreach($values as $key=>$value){
    //         if($value == $permissionNames){
    //             dd($permissionNames);
    //         }
    //     }
    // }

    // foreach ($dynamic_table as $keys => $values) {
    //     foreach($values as $key=>$value){
    //         if(auth()->user()->hasAnyPermission($value)){
    //             dd($value);
    //         }
    //     }
    // }


    

@endphp

<aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{ asset('assets/backend/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('assets/backend/dist/img/user2-160x160.jpg') }}"
                    class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><b>{{ auth()->user()->name }}</b></a>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item ">
                    <a href="{{ route('dashboard') }}" class="nav-link ">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>

                @role('super admin')
                <li class="nav-item ">
                    <a href="{{ route('user.index') }}" class="nav-link ">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            User
                        </p>
                    </a>
                </li>
                @endrole
                
                <li class="nav-item menu-open">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-table "></i>
                        <p>
                            Table
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>

                    {{-- <ul class="nav nav-treeview">
                        @foreach($dynamic_table as $values)
                            @foreach($values as $key=>$value)
                                <li class="nav-item">
                                    <a href="{{ route("table.show", $value) }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>{{ $value }}</p>
                                    </a>
                                </li>
                            @endforeach
                        @endforeach
                    </ul> --}}

                    <ul class="nav nav-treeview">
                        @foreach($dynamic_table as $values)
                            @foreach($values as $key=>$value)
                                @if(auth()->user()->hasAnyPermission($value))
                                <li class="nav-item">
                                    <a href="{{ route("table.show", $value) }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>{{ $value }}</p>
                                    </a>
                                </li>
                                @endif
                            @endforeach
                        @endforeach
                    </ul>
                </li>
                
                @auth
                    @role('super admin')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-table"></i>
                            <p>
                                Admin SetUp
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
    
                            <li class="nav-item">
                                <a href="{{ route('roles.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Roles</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('permission.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Permission</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('activity_log') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Activity log</p>
                                </a>
                            </li>
                           
                        </ul>
                    </li>
                    @endrole
                @endauth
                
                
            
            </ul>
           
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>


{{-- @endif --}}













 
