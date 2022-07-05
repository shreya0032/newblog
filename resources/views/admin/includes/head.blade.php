@php

    $urlArray = explode('/', url()->current());
    // dd($urlArray);
    $total = sizeOf($urlArray);
    $lastSeg = $urlArray[$total-1];
    $beforeLastSeg = $urlArray[$total-2];

@endphp
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
@if ($lastSeg == "dashboard" || $lastSeg == "activity-log" )
    <title>{{ config('app.name') }} {{ ucwords($lastSeg)}} </title>
@else
    <title>{{ config('app.name') }} {{ ucwords($urlArray[3]) }} | {{ ucwords($urlArray[4]) }}</title>
@endif


<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome -->
<link rel="stylesheet" href="{{ asset('assets/backend/plugins/fontawesome-free/css/all.min.css') }}">
<!-- Ionicons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<!-- Tempusdominus Bootstrap 4 -->
<link rel="stylesheet"
    href="{{ asset('assets/backend/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
<!-- iCheck -->
<link rel="stylesheet" href="{{ asset('assets/backend/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
<!-- JQVMap -->
<link rel="stylesheet" href="{{ asset('assets/backend/plugins/jqvmap/jqvmap.min.css') }}">
<!-- Theme style -->
<link rel="stylesheet" href="{{ asset('assets/backend/dist/css/adminlte.min.css') }}">
<!-- overlayScrollbars -->
<link rel="stylesheet" href="{{ asset('assets/backend/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
<!-- Daterange picker -->
<link rel="stylesheet" href="{{ asset('assets/backend/plugins/daterangepicker/daterangepicker.css') }}">
<!-- summernote -->
<link rel="stylesheet" href="{{ asset('assets/backend/plugins/summernote/summernote-bs4.min.css') }}">
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('assets/backend/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/backend/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/backend/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/backend/plugins/dropify/css/dropify.min.css') }}">


<!-- ( LC Switch CDN ) -->
<link href="{{ asset('assets/backend/plugins/LC-switch-master/lc_switch.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/backend/dist/js/toast/jquery.toast.min.css') }}" rel="stylesheet" />

<!-- ( Favicon) -->
<link href="{{ asset('onepatch.ico') }}" rel="shortcut icon">


