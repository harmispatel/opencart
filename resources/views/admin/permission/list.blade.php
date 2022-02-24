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

                                    @php
                                        $pactions = $menus;
                                    @endphp

                                    {{-- Form Start --}}
                                    <form action="">

                                        <table class="table table-striped" id="usersGroup">

                                            <thead>
                                                <tr  class="bg-dark">
                                                    <th>Actions</th>
                                                    @foreach ($user_roles as $userrole)
                                                        <th>{{ $userrole->name }}</th>
                                                    @endforeach
                                                </tr>
                                            </thead>

                                            <tbody>

                                                @foreach ($pactions as $paction)
                                                    <tr style="background: #58595ad9">

                                                        <td>
                                                            <b>
                                                                {{ $paction->main_menu }}
                                                            </b>
                                                        </td>

                                                        @foreach ($user_roles as $userrole)

                                                            @php

                                                                $where = array('role_id'=>$userrole->user_group_id, 'menu_id'=>$paction->id, 'action_id'=>0, 'subaction_id'=>0);

                                                                $query = get_rel_userrole_action($where);

                                                                $checked = (!empty($query)) ? 'checked' : '';

                                                            @endphp

                                                            <td>
                                                                <input type="checkbox" name="access[]" id="menu_id" value="{{ $userrole->user_group_id }}{{ $paction->id }}0_0" class="checkbox" {{ $checked }}>
                                                            </td>

                                                        @endforeach

                                                    </tr>

                                                    @php

                                                        $fetchsubmenu = submenu($paction->id);

                                                    @endphp

                                                    @if (count($fetchsubmenu))

                                                        @foreach ($fetchsubmenu as $key => $value1)

                                                            @php
                                                                $actionId=$value1->id;
                                                            @endphp

                                                            <tr style="background: #a6adb3d9">

                                                                <td>
                                                                    <b>
                                                                        - {{ $value1->name }}
                                                                    </b>
                                                                </td>

                                                                @foreach ($user_roles as $userrole)

                                                                    @php

                                                                        $where = array('role_id'=>$userrole->user_group_id, 'menu_id'=>$paction->id, 'action_id'=>$value1->id, 'subaction_id'=>0);

                                                                        $query = get_rel_userrole_action($where);

                                                                        $checked = !empty($query) ? 'checked' : '';

                                                                    @endphp

                                                                    <td>
                                                                        <input type="checkbox" name="access[]" id="menu_id" value="{{ $userrole->user_group_id }}{{ $paction->id }}{{ $actionId }}_0" {{ $checked }} class="checkbox">
                                                                    </td>

                                                                @endforeach

                                                            </tr>

                                                            @php
                                                                $fetchsubaction = submenuaction($value1->id);
                                                            @endphp

                                                            @if (count($fetchsubaction))

                                                                @foreach ($fetchsubaction as $key => $value2)

                                                                    @php
                                                                        $subactionId=$value2->id;
                                                                    @endphp

                                                                    <tr style="background: rgb(228, 227, 227)">

                                                                        <td>
                                                                            <b>
                                                                                - - {{ $value2->name }}
                                                                            </b>
                                                                        </td>

                                                                        @foreach ($user_roles as $userrole)

                                                                            @php

                                                                                $where = array('role_id'=>$userrole->user_group_id, 'menu_id'=>$paction->id, 'action_id'=>$value1->id, 'subaction_id'=>$value2->id);

                                                                                $query = get_rel_userrole_action($where);

                                                                                $checked = !empty($query) ? 'checked' : '';

                                                                            @endphp

                                                                            <td>
                                                                                <input type="checkbox" name="access[]" id="menu_id" value="{{ $userrole->user_group_id }}{{ $paction->id }}{{ $actionId }}_{{ $subactionId }}" {{ $checked }} class="checkbox">
                                                                            </td>

                                                                        @endforeach

                                                                    </tr>

                                                                @endforeach

                                                            @endif

                                                        @endforeach

                                                    @endif

                                                @endforeach

                                            </tbody>

                                        </table>

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
