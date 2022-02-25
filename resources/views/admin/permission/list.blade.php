@include('header')

<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">

{{-- Section of List Permissions --}}
<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Permissions</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Permissions </li>
                        </ol>
                    </div>
                    {{-- End Breadcumb --}}
                </div>
            </div>
        </section>
        {{-- End Header Section --}}

        {{-- List Section Start --}}
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        {{-- Card Start --}}
                        <div class="card card-primary">
                            {{-- Card Header --}}
                            <div class="card-header d-flex justify-content-between
                            p-2" style="background: #f6f6f6">
                                <h3 class="card-title pt-2" style="color: black">
                                    <i class="fa fa-check pr-1"></i>
                                    Users Permissions
                                </h3>
                            </div>
                            {{-- End Card Header --}}

                            {{-- Card Body --}}
                            <div class="card-body">
                                {{-- All Menu Variable --}}
                                @php
                                    $pactions = $menus;
                                @endphp
                                {{-- End All Menu Variable --}}

                                {{-- Form Start --}}
                                <form action="">
                                    {{-- Table Start --}}
                                    <table class="table table-bordered" id="usersGroup">
                                        {{-- Thead Start --}}
                                        <thead>
                                            <tr  class="bg-dark">
                                                <th>Actions</th>
                                                @foreach ($user_roles as $userrole)
                                                    <th>{{ $userrole->name }}</th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        {{-- Thead End --}}

                                        {{-- Tbody Start --}}
                                        <tbody>
                                            {{-- Foreach Loop Start For Main Menu --}}
                                            @foreach ($pactions as $paction)
                                                {{-- TR for main Menu --}}
                                                <tr style="background: rgb(168, 168, 168);">
                                                    {{-- TD for main Menu List --}}
                                                    <td>
                                                        <b>{{ $paction->main_menu }}</b>
                                                    </td>
                                                    {{-- End TD for main Menu List --}}

                                                    {{-- Foreach Loop Start For Main Menus Checkbox --}}
                                                    @foreach ($user_roles as $userrole)
                                                        {{-- Variables and condition for Main Menus Checkbox --}}
                                                        @php
                                                            $where = array('role_id'=>$userrole->user_group_id, 'menu_id'=>$paction->id, 'action_id'=>0, 'subaction_id'=>0);
                                                            $query = get_rel_userrole_action($where);
                                                            $checked = (!empty($query)) ? 'checked' : '';
                                                        @endphp
                                                        {{-- End Variables and condition for Main Menus Checkbox --}}

                                                        {{-- TD for main Menus Checkbox --}}
                                                        <td>
                                                            <input type="checkbox" name="access[]" id="menu_id" value="{{ $userrole->user_group_id }}_{{ $paction->id }}_0_0" class="checkbox" {{ $checked }}>
                                                        </td>
                                                        {{-- End TD for main Menus Checkbox --}}
                                                    @endforeach
                                                    {{-- End Foreach Loop For Main Menus Checkbox --}}
                                                </tr>
                                                {{-- END TR for main Menu --}}








                                                {{-- All SubMenu Variable --}}
                                                @php
                                                    $fetchsubmenu = submenu($paction->id);
                                                @endphp
                                                {{-- End All SubMenu Variable --}}

                                                {{-- Count Condition for Submenu --}}
                                                @if (count($fetchsubmenu))
                                                    {{-- Foreach Loop Start For Sub Menu --}}
                                                    @foreach ($fetchsubmenu as $key => $value1)
                                                        {{-- Variable for Action id --}}
                                                        @php
                                                            $actionId=$value1->id;
                                                        @endphp
                                                        {{-- End Variable for Action id --}}

                                                        {{-- TR for Sub Menu --}}
                                                        <tr style="background: rgb(214, 214, 214);">
                                                            {{-- TD for Sub Menu List --}}
                                                            <td style="padding-left: 20px;">
                                                                <b>- {{ $value1->name }}</b>
                                                            </td>
                                                            {{-- End TD for Sub Menu List --}}

                                                            {{-- Foreach Loop Start For Sub Menus Checkbox --}}
                                                            @foreach ($user_roles as $userrole)
                                                                {{-- Variables and condition for Sub Menus Checkbox --}}
                                                                @php
                                                                    $where = array('role_id'=>$userrole->user_group_id, 'menu_id'=>$paction->id, 'action_id'=>$value1->id, 'subaction_id'=>0);
                                                                    $query = get_rel_userrole_action($where);
                                                                    $checked = !empty($query) ? 'checked' : '';
                                                                @endphp
                                                                {{-- End Variables and condition for Sub Menus Checkbox --}}

                                                                {{-- TD for Sub Menus Checkbox --}}
                                                                <td>
                                                                    <input type="checkbox" name="access[]" id="menu_id" value="{{ $userrole->user_group_id }}_{{ $paction->id }}_{{ $actionId }}_0" {{ $checked }} class="checkbox">
                                                                </td>
                                                                {{-- End TD for Sub Menus Checkbox --}}
                                                            @endforeach
                                                            {{-- End Foreach Loop For Sub Menus Checkbox --}}
                                                        </tr>
                                                        {{-- End TR for Sub Menu --}}





                                                        {{-- All SubMenu of Submenu Variable --}}
                                                        @php
                                                            $fetchsubmenuofsubmenu = submenuofsubmenu($value1->id);
                                                        @endphp
                                                        {{-- End All SubMenu of Submenu Variable --}}

                                                        {{-- Count Condition for Submenu of Submenu --}}
                                                        @if (count($fetchsubmenuofsubmenu))
                                                            {{-- Foreach Loop Start For Sub Menu of Submenu --}}
                                                            @foreach ($fetchsubmenuofsubmenu as $key => $value2)
                                                                {{-- Variable of Subaction of Subaction Id --}}
                                                                @php
                                                                    $subactionofsubactionId=$value2->id;
                                                                @endphp
                                                                {{-- End Variable of Subaction of Subaction Id --}}

                                                                {{-- TR for Sub Menu of Submenu --}}
                                                                <tr style="background: rgb(245, 240, 240);">
                                                                    {{-- TD for Sub Menu of Submenu List --}}
                                                                    <td style="padding-left: 28px;">
                                                                        <b> - - {{ $value2->name }}</b>
                                                                    </td>
                                                                    {{-- End TD for Sub Menu of Submenu List --}}

                                                                    {{-- Start Foreach Loop For Sub Menus of Submenus Checkbox --}}
                                                                    @foreach ($user_roles as $userrole)
                                                                        {{-- Variables and condition for Sub Menus of Submenu Checkbox --}}
                                                                        @php
                                                                            $where = array('role_id'=>$userrole->user_group_id, 'menu_id'=>$value2->parent_id, 'action_id'=>$value2->id, 'subaction_id'=>$value2->id);
                                                                            $query = get_rel_userrole_action($where);
                                                                            $checked = !empty($query) ? 'checked' : '';
                                                                        @endphp
                                                                        {{-- End Variables and condition for Sub Menus of Submenu Checkbox --}}

                                                                        {{-- TD for Sub Menus of submenu Checkbox --}}
                                                                        <td>
                                                                            <input type="checkbox" name="access[]" id="menu_id" value="{{ $userrole->user_group_id }}_{{ $value2->parent_id }}_{{ $subactionofsubactionId }}_{{ $value2->id }}" {{ $checked }} class="checkbox">
                                                                        </td>
                                                                        {{-- End TD for Sub Menus of submenu Checkbox --}}

                                                                    @endforeach
                                                                    {{-- End Foreach Loop For Sub Menus of Submenus Checkbox --}}
                                                                </tr>
                                                                {{-- End TR for Sub Menu of Submenu --}}

                                                            @endforeach
                                                            {{-- Foreach Loop Start For Sub Menu of Submenu --}}
                                                        @endif
                                                        {{-- End Count Condition for Submenu of Submenu --}}



                                                    @endforeach
                                                    {{-- End Foreach Loop For Sub Menu --}}
                                                @endif
                                                {{-- Count Condition for Submenu --}}
                                            @endforeach
                                            {{-- End Foreach Loop For Main Menu --}}
                                        </tbody>
                                        {{-- End Tbody --}}
                                    </table>
                                    {{-- Table End --}}
                                </form>
                                {{-- Form End --}}

                            </div>
                            {{-- End Card Body --}}
                        </div>
                        {{-- End Card --}}
                    </div>
                </div>
            </div>
        </section>
        {{-- End Form Section --}}

    </div>
</section>
{{-- End Section of List Permissions --}}



@include('footer')

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">

    var passchedkId=0;

    $('.checkbox').change(function(){
            var passchedkId=$(this).val();
            var checkboxVal=this.checked ? 1 : 0;
            $.ajax({
                type: "POST",
                dataType: "json",
                url:'{{ url("storerelation") }}',
                data: {"_token": "{{ csrf_token() }}",passchedkId:passchedkId,ischeckked:checkboxVal},
                success: function(response) {
                    console.log(response);
                    alert('sucess');
                    // location.reload();
                }

            });

    });

</script>
