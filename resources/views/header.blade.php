<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('public/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{ asset('public/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('public/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{ asset('public/plugins/jqvmap/jqvmap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('public/dist/css/adminlte.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('public/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('public/plugins/daterangepicker/daterangepicker.css') }}">
  <!-- DataTable -->
  <link href="//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link href="//cdn.datatables.net/buttons/1.5.6/css/buttons.bootstrap4.min.css" rel="stylesheet">
  <!-- Sweet alert -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/0.2.0/sweet-alert.css" integrity="sha512-g9k+CnZOpfd3BjCvr9L6M9F1u42RbYxtiurifk4KmqTNTyZRnKixRgZl6SzPESunaaCnyelHhKicHWcQUwALYQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- Select Box -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet"/>
  <!--SummerNote-->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">

</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">

        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown p-0">
          <a class="nav-link p-0" data-toggle="dropdown" href="#">
            {{-- <i class="far fa-user"></i> --}}
            @if(!empty(user_details()))
                <img src="{{ ( (user_details()->image != '') || (user_details()->image != null) ) ? asset('public/admin/users/'.user_details()->image) : asset('public/admin/users/blank.png') }}" alt="User Avatar" class="m-0 img-circle" width="40" height="40">
                {{ user_details()->username }}
            @else
                <img src="{{ asset('public/admin/users/blank.png') }}" alt="User Avatar" class="m-0 img-circle" width="40" height="40">
                Not Found
            @endif
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <div class="dropdown-divider"></div>
                @if(!empty(user_details()))
                    <a href="{{ route('profile',user_details()->user_id) }}" class="dropdown-item bg-dark"><i class="fa fa-user-circle pr-2"></i> Your Profile</a>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="dropdown-item text-center bg-red">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                @else
                    <a href="#" class="dropdown-item bg-dark"><i class="fa fa-user-circle pr-2"></i> Your Profile</a>
                    <a href="#" class="dropdown-item text-center bg-red">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                @endif
        </li>
      </ul>

  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link text-center">
      {{-- <img src="{{ asset('public/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> --}}
      <span class="brand-text font-weight-light">NAVIGATION</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        {{-- Dashboard --}}
          <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link {{ (request()->is('dashboard')) ? 'active' : ''}}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Dashboard</p>
            </a>
          </li>

          {{-- @if(auth()->user()->user_group_id == 1) --}}
            {{-- Categories --}}
            <li class="nav-item">
                <a href="{{ route('category') }}" class="nav-link {{ (request()->is('category')) ? 'active' : ''}}">
                    <i class="nav-icon fas fa-list-alt"></i>
                    <p>Categories</p>
                </a>
              </li>


          {{-- @endif --}}

          <li class="nav-item">
            <a href="{{ route('product') }}" class="nav-link">
                <i class="nav-icon fas fa-list-alt"></i>
                <p>Products</p>
            </a>
          </li>

          {{-- @if(auth()->user()->user_group_id == 1) --}}
          {{-- Categories --}}
          <li class="nav-item {{ (request()->is('usersgroup') || request()->is('users')) ? 'menu-open' : ''}}">
              <a href="" class="nav-link {{ (request()->is('usersgroup') || request()->is('users')) ? 'active' : ''}}">
                  <i class="nav-icon fas fa-user-alt"></i>
                  <p>Users <i class="right fas fa-angle-left"></i></p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item pl-2">
                  <a href="{{ route('users') }}" class="nav-link {{ request()->is('users') ? 'active' : ''}}">
                    <i class="fa fa-user nav-icon"></i>
                    <p>Users</p>
                  </a>
                </li>
                <li class="nav-item pl-2">
                  <a href="{{ route('usersgroup') }}" class="nav-link {{ request()->is('usersgroup') ? 'active' : ''}}">
                    <i class="fa fa-users nav-icon"></i>
                    <p>User Groups</p>
                  </a>
                </li>
            </ul>
            </li>
        {{-- @endif --}}

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>

  </aside>
