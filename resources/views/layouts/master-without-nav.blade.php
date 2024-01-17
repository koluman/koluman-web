<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-topbar="light" data-sidebar-image="none"
    data-theme="default" data-theme-colors="default">

<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | Koluman - Admin & Yönetim Paneli</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Admin & Yönetim Paneli" name="description" />
    <meta content="Koluman" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('build/images/favicon.ico') }}">
    @include('layouts.head-css')
</head>

@yield('body')

@yield('content')

@include('layouts.vendor-scripts')
</body>

</html>
