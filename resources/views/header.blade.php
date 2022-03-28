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
  <!-- Custom style -->
  <link rel="stylesheet" href="{{ asset('public/dist/css/custom.css') }}">
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
{{-- Summernote --}}
<link rel="stylesheet" href="{{ asset('public/plugins/summernote/summernote.min.css') }}">


<style>
    .custom-nav > .nav-item > .nav-link {height: 40px !important;}
</style>
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
      <li>
          <select class="form-control">
              <option>Default select</option>
            </select>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown p-0">
          <a class="nav-link p-0 text-uppercase" style="color: rgb(71, 69, 69); font-weight: 700;font-family: verdana" data-toggle="dropdown" href="#">
            {{-- <i class="far fa-user"></i> --}}
            @if(!empty(user_details()))
                <img src="{{ ( (user_details()->image != '') || (user_details()->image != null) ) ? asset('public/admin/users/'.user_details()->image) : asset('public/admin/users/blank.png') }}" class="m-0 img-circle" width="40" height="40">
                {{ user_details()->username }}
            @else
                <img src="{{ asset('public/admin/users/blank.png') }}" class="m-0 img-circle" width="40" height="40">
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
    <a href="{{ route('dashboard') }}" class="brand-link text-center" style="background: #1f5361; color: white;">
      {{-- <img src="{{ asset('public/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> --}}
      <span class="brand-text font-weight-light"><b>MANAGER</b></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar" style="background: #3742;">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column custom-nav" data-widget="treeview" role="menu" data-accordion="false">

           @if(!empty(sidebar()))

                @php
                    $useraccess = user_details()->user_group_id;
                @endphp

                @if ($useraccess == 1)

                    @foreach (sidebar() as $item)
                        @if( ($item->alias != '') || ($item->alias) != null )
                            <li class="nav-item">
                                <a href="{{ route($item->alias) }}" class="nav-link {{ (request()->is($item->alias)) ? 'active' : ''}}">
                                    <i class="nav-icon {{ $item->icon_class }}"></i>
                                    <p>{{ $item->main_menu }}</p>
                                </a>
                            </li>
                        @else

                            @php
                                $arr = fetch_mainmenu_submenucolumn($item->id);
                                $activecls = '';
  		                        $stylecss = '';

                                $str = Request::segment(1).Request::segment(2);
                                $str1 = Request::segment(1).Request::segment(2).Request::segment(3);
                                $str2 = Request::segment(1).Request::segment(2).Request::segment(3).Request::segment(4);
                                $str3 = Request::segment(1);

                                if(count($arr))
                                {
                                    if(in_array($str, $arr) || in_array($str1, $arr) || in_array($str2, $arr) || in_array($str3, $arr) )
                                    {
                                        $activecls = "active";
                                        $stylecss = 'menu-open';
                                    }
                                }

                            @endphp

                            <li class="nav-item {{ $stylecss }}">
                                <a href="" class="nav-link {{ $activecls }}">
                                    <i class="nav-icon {{ $item->icon_class }}"></i>
                                    <p>{{ $item->main_menu }} <i class="right fas fa-angle-left"></i></p>
                                </a>
                                <ul class="nav nav-treeview">

                                    @php
                                        $submenus = submenu($item->id);
                                    @endphp

                                    @if(!empty($submenus))
                                        @foreach($submenus as $submenu)

                                            @if(!empty($submenu->slugurl))
                                                <li class="nav-item pl-2">

                                                    @if($submenu->url_id == 1)
                                                        <a href="{{ route($submenu->slugurl,user_details()->user_id) }}" class="nav-link {{ request()->is($submenu->slugurl.'/'.user_details()->user_id) ? 'active' : ''}}">
                                                    @else
                                                        <a href="{{ URL::To($submenu->slugurl) }}" class="nav-link {{ request()->is($submenu->slugurl) ? 'active' : ''}}">
                                                    @endif

                                                            <i class="nav-icon {{ $submenu->icon_class }}"></i>
                                                            <p>{{ $submenu->alias }}</p>
                                                        </a>
                                                </li>
                                            @else

                                            {{-- @php
                                                $subarr = fetch_mainmenu_submenucolumn($submenu->parent_id);
                                                $subactivecls = '';
                                                $substylecss = '';

                                                $substr = Request::segment(1).Request::segment(2);
                                                $substr1 = Request::segment(1).Request::segment(2).Request::segment(3);
                                                $substr2 = Request::segment(1).Request::segment(2).Request::segment(3).Request::segment(4);

                                                if(count($subarr))
                                                {
                                                    if(in_array($substr, $subarr) || in_array($substr1, $subarr) || in_array($substr2, $subarr) )
                                                    {
                                                        $subactivecls = "bg-primary";
                                                        $substylecss = 'menu-open';
                                                    }
                                                }

                                            @endphp --}}

                                                <li class="nav-item pl-2">
                                                    <a href="" class="nav-link">
                                                    <i class="nav-icon {{ $submenu->icon_class }}"></i>
                                                    <p>{{ $submenu->alias }}</p> <i class="right fas fa-angle-left"></i>
                                                    </a>

                                                    <ul class="nav nav-treeview">

                                                        @php
                                                            $submenusofsubmenu = submenuofsubmenu($submenu->id);
                                                        @endphp

                                                        @if(!empty($submenusofsubmenu))
                                                            @foreach($submenusofsubmenu as $subofsubmenu)
                                                                @if(!empty($subofsubmenu->slugurl))
                                                                    <li class="nav-item pl-2">
                                                                        <a href="{{ route($subofsubmenu->slugurl) }}" class="nav-link {{ request()->is($subofsubmenu->slugurl) ? 'active' : ''}}">
                                                                            <i class="nav-icon {{ $subofsubmenu->icon_class }}"></i>
                                                                            <p>{{ $subofsubmenu->alias }}</p>
                                                                        </a>
                                                                    </li>
                                                                @else
                                                                    <li class="nav-item pl-2">
                                                                        <a href="" class="nav-link">
                                                                            <i class="nav-icon {{ $subofsubmenu->icon_class }}"></i>
                                                                            <p>{{ $subofsubmenu->alias }}</p>
                                                                        </a>
                                                                    </li>
                                                                @endif
                                                            @endforeach
                                                        @endif

                                                    </ul>

                                                </li>
                                            @endif
                                        @endforeach
                                    @endif

                                </ul>
                            </li>
                        @endif
                    @endforeach

                @else

                    @php
                        $where = array('role_id'=>$useraccess,'action_id'=>0,'subaction_id'=>0);
                        $mainmenu = fetch_otherusers_mainmenu($where);
                    @endphp

                    @if (count($mainmenu))
                        @foreach ($mainmenu as $key=>$value)

                            @php
                                $where = array('role_id'=>$useraccess,'oc_userrole_actions.menu_id'=>$value->id,'subaction_id'=>0);
                                $fetchsubmenu= fetch_otherusers_mainmenu_submenu($where);
                            @endphp

                                @if( ($value->alias != '') || ($value->alias) != null )
                                    <li class="nav-item">
                                        <a href="{{ route($value->alias) }}" class="nav-link {{ (request()->is($value->alias)) ? 'active' : ''}}">
                                            <i class="nav-icon {{ $value->icon_class }}"></i>
                                            <p>{{ $value->main_menu }}</p>
                                        </a>
                                    </li>
                                @else

                                    @php
                                        $arr = fetch_mainmenu_submenucolumn($value->id);
                                        $activecls = '';
                                        $stylecss = '';

                                        $str = Request::segment(1).Request::segment(2);
                                        $str1 = Request::segment(1).Request::segment(2).Request::segment(3);
                                        $str2 = Request::segment(1).Request::segment(2).Request::segment(3).Request::segment(4);
                                        $str3 = Request::segment(1);

                                        if(count($arr))
                                        {
                                            if(in_array($str, $arr) || in_array($str1, $arr) || in_array($str2, $arr) || in_array($str3, $arr) )
                                            {
                                                $activecls = "active";
                                                $stylecss = 'menu-open';
                                            }
                                        }

                                    @endphp

                                    <li class="nav-item {{ $stylecss }}">
                                        <a href="" class="nav-link {{ $activecls }}">
                                            <i class="nav-icon {{ $value->icon_class }}"></i>
                                            <p>{{ $value->main_menu }} <i class="right fas fa-angle-left"></i></p>
                                        </a>
                                        <ul class="nav nav-treeview">

                                            @if(!empty($fetchsubmenu))
                                                @foreach($fetchsubmenu as $key => $value1)
                                                    @if(!empty($value1->slugurl))
                                                        <li class="nav-item pl-2">

                                                            @if($value1->url_id == 1)
                                                                <a href="{{ route($value1->slugurl,user_details()->user_id) }}" class="nav-link {{ request()->is($value1->slugurl.'/'.user_details()->user_id) ? 'active' : ''}}">
                                                            @else
                                                                <a href="{{ route($value1->slugurl) }}" class="nav-link {{ request()->is($value1->slugurl) ? 'active' : ''}}">
                                                            @endif

                                                            <i class="nav-icon {{ $value1->icon_class }}"></i>
                                                            <p>{{ $value1->alias }}</p>
                                                            </a>
                                                        </li>
                                                    @else

                                                        {{-- @php
                                                            $subarr = fetch_mainmenu_submenucolumn($value1->parent_id);
                                                            $subactivecls = '';
                                                            $substylecss = '';

                                                            $substr = Request::segment(1).Request::segment(2);
                                                            $substr1 = Request::segment(1).Request::segment(2).Request::segment(3);
                                                            $substr2 = Request::segment(1).Request::segment(2).Request::segment(3).Request::segment(4);

                                                            if(count($subarr))
                                                            {
                                                                if(in_array($substr, $subarr) || in_array($substr1, $subarr) || in_array($substr2, $subarr) )
                                                                {
                                                                    $subactivecls = "bg-primary";
                                                                    $substylecss = 'menu-open';
                                                                }
                                                            }

                                                    @endphp --}}

                                                        <li class="nav-item pl-2">
                                                            <a href="" class="nav-link">
                                                            <i class="nav-icon {{ $value1->icon_class }}"></i>
                                                            <p>{{ $value1->alias }}</p> <i class="right fas fa-angle-left"></i>
                                                            </a>

                                                            <ul class="nav nav-treeview">

                                                                {{-- @php
                                                                    $submenusofsubmenu = submenuofsubmenu($value1->id);
                                                                @endphp --}}

                                                                @php
                                                                    $where = array('role_id'=>$useraccess,'oc_userrole_actions.menu_id'=>$value1->id);
                                                                    $submenusofsubmenu= fetch_otherusers_mainmenu_submenu($where);
                                                                @endphp

                                                                @if(!empty($submenusofsubmenu))
                                                                    @foreach($submenusofsubmenu as $subofsubmenu)
                                                                        @if(!empty($subofsubmenu->slugurl))
                                                                            <li class="nav-item pl-2">
                                                                                <a href="{{ route($subofsubmenu->slugurl) }}" class="nav-link {{ request()->is($subofsubmenu->slugurl) ? 'active' : ''}}">
                                                                                    <i class="nav-icon {{ $subofsubmenu->icon_class }}"></i>
                                                                                    <p>{{ $subofsubmenu->alias }}</p>
                                                                                </a>
                                                                            </li>
                                                                        @else
                                                                            <li class="nav-item pl-2">
                                                                                <a href="" class="nav-link">
                                                                                    <i class="nav-icon {{ $subofsubmenu->icon_class }}"></i>
                                                                                    <p>{{ $subofsubmenu->alias }}</p>
                                                                                </a>
                                                                            </li>
                                                                        @endif
                                                                    @endforeach
                                                                @endif

                                                            </ul>

                                                        </li>


                                                    @endif
                                                @endforeach
                                            @endif

                                        </ul>
                                    </li>

                                @endif

                        @endforeach
                    @endif

                @endif

           @endif

       

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>

  </aside>
