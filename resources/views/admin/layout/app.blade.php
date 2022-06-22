@php
    // $urlArray = explode('/', url()->current());
    // dd($urlArray);
    // $x = 0; $count = 0;
    // foreach ($urlArray as $key => $value) {
    //     $x = (($value == 'admin') ? ($x+1) : $x);
    //     $count = (($x >= 1) ? ($count+1) : 0);
    // }
    // $checkFor = ($count >= 2) ? 'dashboardPage' : 'loginPage';
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
        @include('admin.includes.head')
    </head>

    <body class="hold-transition sidebar-mini layout-fixed">

        <!--== ( Wrapper Start ) ==-->

        <div class="wrapper">

            <!------ ( Loader Content Start ) ------>
            @include('admin.includes.loader')
            <!------ ( Loader Content End ) ------>



            <!------ ( Header Start ) ------>
            @include('admin.includes.header')
            <!------ ( Header End ) ------>




            <!------ ( Side-Bar Start ) ------>
            @include('admin.includes.sidebar')
            <!------ ( Side-Bar End ) ------>



            <!------ ( Content Start ) ------>
            <div class="content-wrapper">

                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                {{-- <h1>{{ $tableName }}</h1> --}}
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        @yield('content')
                    </div>
                </section>
                <!-- /.content -->
            </div>
            <!------ ( Content End ) ------>



            <!------ ( Footer Start ) ------>
            @include('admin.includes.footer')
            <!------ ( Footer End ) ------>


        </div>

        <!--== ( Wrapper End ) ==-->

        @include('admin.includes.foot')

        @stack('scripts')
    </body>



</html>
