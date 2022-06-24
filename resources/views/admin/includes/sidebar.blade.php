@auth
<aside class="main-sidebar sidebar-light-primary elevation-4">
   
    <a href="" class="brand-link">
        <img src="{{ asset('assets/backend/dist/img/onepatchnew.png') }}" alt="Onepatch Logo"
            class="brand-image" style="opacity: .8">
        <span class="brand-text">OnePatch DB Support</span>
    </a>

    <div class="sidebar">
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
                            <i class="nav-icon fas fa-user"></i>
                            <p>
                                User
                            </p>
                        </a>
                    </li>
                @endrole

                @role('super admin')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-table "></i>
                            <p>
                                Table
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">
                            @foreach($dynamic_table as $values)
                                @foreach($values as $key=>$value)
                                    <li class="nav-item">
                                        <a href="{{ route("table.show", $value) }}"
                                            class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>{{ $value }}</p>
                                        </a>
                                    </li>
                                @endforeach
                            @endforeach
                        </ul>


                    </li>
                @else
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-table "></i>
                            <p>
                                Table
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">
                            @foreach($dynamic_table as $values)
                                @foreach($values as $key=>$value)
                                    @if(auth()->user()->hasAnyPermission($value))
                                        <li class="nav-item">
                                            <a href="{{ route("table.show", $value) }}"
                                                class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>{{ $value }}</p>
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            @endforeach
                        </ul>
                    </li>
                @endrole

                @auth
                @role('super admin')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-cogs"></i>
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
    </div>
</aside>
@endauth