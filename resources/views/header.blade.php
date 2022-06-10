<!--
    THIS IS HEADER PAGE FOR ADMIN PANEL
    ----------------------------------------------------------------------------------------------
    header.blade.php
    It's Included Some CSS Links.
    it is used for admin panel's top navigation & Sidebar Menu
    ----------------------------------------------------------------------------------------------
-->


@php
    // GET ALL STORES
    $stores = getStores();

    // CURRENT ADMIN STORE ID
    $current_store_id = currentStoreId();

    // ADMIN USER DETAILS
    $user_details = user_details();
    if(isset($user_details))
    {
        $user_group_id = $user_details['user_group_id'];
    }

    // USER SHOP DETAILS
    $user_shop = user_shop_detail($user_details['user_shop']);

    // USER ACCESS
    $useraccess = user_details()->user_group_id;

@endphp


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{{ asset('public/admin/favicon/myfoodbasket-icon.png') }}}">
    <title>{{ Str::ucfirst(request()->route()->getName())}}</title>

    <!-- CUSTOM CSS -->
    <style>
        .select2-container--default .select2-selection--single .select2-selection__rendered
        {
            line-height: 18px!important;
        }
        .select2-container--default .select2-selection--single
        {
                margin-top: 8px!important;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow b
        {
            margin-top: 7px!important;
        }

        .custom-nav > .nav-item > .nav-link {height: 40px !important;}
    </style>
    <!-- END CUSTOM CSS -->

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

    {{-- JQ UI --}}
    <link rel="stylesheet" href="{{ asset('public/plugins/jquery-ui/jquery-ui.min.css') }}">

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/0.2.0/sweet-alert.css"/>

    <!-- Select Box -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet"/>

    <!-- Summernote -->
    <link rel="stylesheet" href="{{ asset('public/plugins/summernote/summernote.min.css') }}">

    <!-- Gallary Style -->
    <link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">

</head>
<body class="hold-transition sidebar-mini layout-fixed">

    <div class="wrapper">

        <!-- NAVBAR -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- LEFT TOP NAVBAR -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>

                <!-- If user is ADMIN then show add new store option -->
                @if ($user_group_id == 1)
                    <li class="nav-item pt-1 pr-3">
                        <a href="{{ route('createstore') }}" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> NEW</a>
                    </li>
                    <li class="nav-item">
                        <select class="form-control" id="SearchStore">
                            <option value="0">Store Front</option>
                            @foreach ($stores as $store)
                                <option value="{{ $store->store_id }}" {{ ($current_store_id == $store->store_id) ? 'selected' : '' }}>{{ html_entity_decode($store->name) }}</option>
                            @endforeach
                        </select>
                    </li>
                    <li class="nav-item pl-3 pt-2 pr-3">
                        <a href="{{ getCurrentStoreURL($current_store_id) }}" target="_blanck" id="visitShop">Visit Shop</a>
                    </li>
                <!-- Otherwise Only Show Shop Name -->
                @else
                    <li class="nav-item pt-1">
                        <h3>{{ $user_shop->name }}</h3>
                    </li>
                @endif
            </ul>
            <!-- END LEFT TOP NAVBAR -->

            <!-- RIGHT TOP NAVBAR -->
            <ul class="navbar-nav ml-auto">
                <!-- USER PROFILE SECTION -->
                <li class="nav-item dropdown p-0">
                    <a class="nav-link p-0 text-uppercase" style="color: rgb(71, 69, 69); font-weight: 700;font-family: verdana" data-toggle="dropdown" href="#">
                        <!-- If User have a profile image then shown image -->
                        @if(!empty(user_details()))
                            <img src="{{ ( (user_details()->image != '') || (user_details()->image != null) ) ? asset('public/admin/users/'.user_details()->image) : asset('public/admin/users/blank.png') }}" class="m-0 img-circle" width="40" height="40">
                            {{ user_details()->username }}
                        <!-- Else Show Message Not Found -->
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
                    </div>
                </li>
                <!-- END USER PROFILE SECTION -->
            </ul>
            <!-- END RIGHT TOP NAVBAR -->
        </nav>
        <!-- END NAVBAR -->

        <!-- SIDEBAR FOR LINKS -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="{{ route('dashboard') }}" class="brand-link text-center" style="background: #357f94; color: white;">
                <span class="brand-text font-weight-light"><b>MANAGER</b></span>
            </a>

            <!-- SIDEBAR -->
            <div class="sidebar" style="background: #3742;">
                <!-- SIDEBAR MENU -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column custom-nav" data-widget="treeview" role="menu" data-accordion="false">

                        <!-- DYNAMIC SIDEBAR -->
                        @if(!empty(sidebar()))
                            <!-- If user is Main Admin Then All Menu show -->
                            @if ($useraccess == 1)
                                @foreach (sidebar() as $item)
                                    <!-- SINGLE MENU LINK -->
                                    @if( ($item->alias != '') || ($item->alias) != null )
                                        <li class="nav-item">
                                            <a href="{{ route($item->alias) }}" class="nav-link {{ (request()->is($item->alias)) ? 'active' : ''}}">
                                                <i class="nav-icon {{ $item->icon_class }}"></i>
                                                <p>{{ $item->main_menu }}</p>
                                            </a>
                                        </li>
                                    <!-- SUBMENU LINK -->
                                    @else
                                        @php
                                            // This Function is used for get submenu of Menu
                                            $arr = fetch_mainmenu_submenucolumn($item->id);
                                            $activecls = '';
                                            $stylecss = '';

                                            $sub_activecls = '';
                                            $sub_stylecss = '';

                                            $str = Request::segment(1);
                                            $str1 = $str.Request::segment(2);
                                            $str2 = $str.$str1.Request::segment(3);
                                            $str3 = $str.$str1.$str2.Request::segment(4);

                                            $data = array();

                                            foreach ($arr as $key => $value) {
                                                $data[] = $value['slugurl'];

                                                $get_par = fetch_subof_sub($value['id']);


                                                $mdata = array();

                                                if(count($get_par) > 0)
                                                {
                                                    foreach ($get_par as $val) {
                                                       $mdata[] = $val['slugurl'];
                                                    }

                                                    if(count($mdata))
                                                    {
                                                        if(in_array($str, $mdata) || in_array($str1, $mdata) || in_array($str2, $mdata) || in_array($str3, $mdata) )
                                                        {
                                                            $sub_activecls = "active";
                                                            $sub_stylecss = 'menu-open';
                                                        }
                                                    }
                                                }

                                            }
                                            if(count($data))
                                            {
                                                if(in_array($str, $data) || in_array($str1, $data) || in_array($str2, $data) || in_array($str3, $data) )
                                                {
                                                    $activecls = "active";
                                                    $stylecss = 'menu-open';
                                                }
                                            }
                                        @endphp

                                        <li class="nav-item {{ $stylecss }} {{ $sub_stylecss }}">
                                            <a href="" class="nav-link {{ $activecls }} {{ $sub_activecls }}">
                                                <i class="nav-icon {{ $item->icon_class }}"></i>
                                                <p>{{ $item->main_menu }} <i class="right fas fa-angle-left"></i></p>
                                            </a>

                                            <!-- SUBMENUS -->
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

                                                        @php
                                                            $subarr = fetch_submenuof_submenu($submenu->id);
                                                            $subactivecls = '';
                                                            $substylecss = '';


                                                            $substr = Request::segment(1);
                                                            $substr1 = $substr.Request::segment(2);
                                                            $substr2 = $substr.$substr1.Request::segment(3);
                                                            $substr3 = $substr.$substr1.$substr2.Request::segment(4);

                                                            $data2 = array();

                                                            foreach ($subarr as $value2) {
                                                                $data2[] = $value2['slugurl'];
                                                            }

                                                            if(count($data2))
                                                            {
                                                                if(in_array($substr, $data2) || in_array($substr1, $data2) || in_array($substr2, $data2) || in_array($substr3, $data2) )
                                                                {
                                                                    $subactivecls = "bg-primary";
                                                                    $substylecss = 'menu-open';
                                                                }
                                                            }

                                                        @endphp

                                                            <li class="nav-item pl-2 {{ $substylecss }}">
                                                                <a href="" class="nav-link {{ $subactivecls }}">
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
                                            <!-- END SUBMENUS -->
                                        </li>
                                    @endif
                                @endforeach
                            <!-- Else Show Permission Accessed Menu -->
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

                                                    $sub_activecls = '';
                                                    $sub_stylecss = '';

                                                    $str = Request::segment(1);
                                                    $str1 = $str.Request::segment(2);
                                                    $str2 = $str.$str1.Request::segment(3);
                                                    $str3 = $str.$str1.$str2.Request::segment(4);

                                                    $data = array();

                                                    foreach ($arr as $key => $value2) {
                                                        $data[] = $value2['slugurl'];

                                                        $get_par = fetch_subof_sub($value2['id']);


                                                        $mdata = array();

                                                        if(count($get_par) > 0)
                                                        {
                                                            foreach ($get_par as $val) {
                                                            $mdata[] = $val['slugurl'];
                                                            }

                                                            if(count($mdata))
                                                            {
                                                                if(in_array($str, $mdata) || in_array($str1, $mdata) || in_array($str2, $mdata) || in_array($str3, $mdata) )
                                                                {
                                                                    $sub_activecls = "active";
                                                                    $sub_stylecss = 'menu-open';
                                                                }
                                                            }
                                                        }

                                                    }
                                                    if(count($data))
                                                    {
                                                        if(in_array($str, $data) || in_array($str1, $data) || in_array($str2, $data) || in_array($str3, $data) )
                                                        {
                                                            $activecls = "active";
                                                            $stylecss = 'menu-open';
                                                        }
                                                    }
                                                @endphp

                                                <li class="nav-item {{ $stylecss }} {{ $sub_stylecss }}">
                                                    <a href="" class="nav-link {{ $activecls }} {{ $sub_activecls }}">
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
                                                                            <a href="{{ URL::To($value1->slugurl) }}" class="nav-link {{ request()->is($value1->slugurl) ? 'active' : ''}}">
                                                                        @endif

                                                                        <i class="nav-icon {{ $value1->icon_class }}"></i>
                                                                        <p>{{ $value1->alias }}</p>
                                                                        </a>
                                                                    </li>
                                                                @else

                                                                    @php
                                                                        $subarr = fetch_submenuof_submenu($value1->id);
                                                                        $subactivecls = '';
                                                                        $substylecss = '';


                                                                        $substr = Request::segment(1);
                                                                        $substr1 = $substr.Request::segment(2);
                                                                        $substr2 = $substr.$substr1.Request::segment(3);
                                                                        $substr3 = $substr.$substr1.$substr2.Request::segment(4);

                                                                        $data2 = array();

                                                                        foreach ($subarr as $value2) {
                                                                            $data2[] = $value2['slugurl'];
                                                                        }

                                                                        if(count($data2))
                                                                        {
                                                                            if(in_array($substr, $data2) || in_array($substr1, $data2) || in_array($substr2, $data2) || in_array($substr3, $data2) )
                                                                            {
                                                                                $subactivecls = "bg-primary";
                                                                                $substylecss = 'menu-open';
                                                                            }
                                                                        }
                                                                    @endphp

                                                                    <li class="nav-item pl-2 {{ $substylecss }}">
                                                                        <a href="" class="nav-link {{ $subactivecls }}">
                                                                        <i class="nav-icon {{ $value1->icon_class }}"></i>
                                                                        <p>{{ $value1->alias }}</p> <i class="right fas fa-angle-left"></i>
                                                                        </a>

                                                                        <ul class="nav nav-treeview">

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
                        <!-- END DYNAMIC SIDEBAR -->
                    </ul>
                </nav>
                <!-- END SIDEBAR MENU -->
            </div>
            <!-- END SIDEBAR -->
        </aside>
        <!-- END SIDEBAR FOR LINKS -->
