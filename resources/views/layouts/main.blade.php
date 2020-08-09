<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--  Prevents search engine from indexing pages inheriting this template -->
    <meta name="robots" content="noindex" />

    <title>@yield('title')</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{asset('chiptranz-vendors/vendors/iconfonts/mdi/font/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('chiptranz-vendors/css/vendor.bundle.base.css')}}">
    <link rel="stylesheet" href="{{asset('chiptranz-vendors/css/vendor.bundle.addons.css')}}">
<!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{asset('chiptranz-vendors/vendors/iconfonts/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('chiptranz-vendors/css/style.css')}}">

    <!-- endinject -->
    {{--<link rel="shortcut icon" href="../../images/favicon.png" />--}}
    <script src="{{ asset('js/app.js?ver=1.1') }}" defer></script>
</head>

<body class="sidebar-mini sidebar-dark">
@section('main-content')



@show


@section('main-scripts')
@include('partials.main-scripts')
@show


</body>
</html>