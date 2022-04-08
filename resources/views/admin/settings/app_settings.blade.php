{{-- Header --}}
@include('header')
{{-- End Header --}}


<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">

{{-- Custom CSS --}}
<style>
    [data-toggle="collapse"] .fa:before
    {
        content: "\f13a";
    }

    [data-toggle="collapse"].collapsed .fa:before
    {
        content: "\f139";
    }
</style>
{{-- End Custom CSS --}}

{{-- Section of App Settings --}}
<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>App Settings</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">App Settings </li>
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
                @if(Session::has('success'))
                    <div class="alert alert-success del-alert alert-dismissible" id="alert" role="alert">
                        {{ Session::get('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="row">
                    <div class="col-md-12">
                        {{-- Card --}}
                        <div class="card">
                            {{-- Form --}}
                            <form action="{{ route('updateappsettings') }}" method="POST" enctype="multipart/form-data">
                                {{ @csrf_field() }}
                                {{-- Card Header --}}
                                <div class="card-header" style="background: #1bbc9b ">
                                    <h3 class="card-title pt-2 text-white">
                                        <i class="fas fa-cog mr-2"></i>
                                        SETTINGS
                                    </h3>
                                    <div class="container" style="text-align: right">
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <i class="fa fa-save"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-dark" data-toggle="collapse" data-target="#coll" aria-expanded="true" aria-controls="coll" onclick="changeAngle()">
                                            <i class="fa" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                                {{-- End Card Header --}}

                                <div class="collapse show" id="coll">
                                    {{-- Card Body --}}
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="android_app_id">Android App ID</label>
                                                    <input type="text" name="android_app_id" id="android_app_id" class="form-control" value="{{ $map_category['android_app_id'] }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="apple_app_id">Apple App ID</label>
                                                    <input type="text" name="apple_app_id" id="apple_app_id" class="form-control" value="{{ $map_category['apple_app_id'] }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="app_available">App Available</label>
                                                    <div class="form-control">
                                                        <input type="checkbox" name="app_available" id="app_available" value="0" {{ ($map_category['app_available'] == 0) ? 'checked' : '' }}>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="home_bg_color">Home Background Color</label>
                                                    <input type="color" name="home_bg_color" id="home_bg_color" class="form-control" value="{{ $map_category['home_bg_color'] }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="menu_background_image">Menu Background Image</label>
                                                    <input type="file" name="menu_background_image" id="menu_background_image" class="form-control p-1 mb-1">
                                                    @if(!empty($map_category['menu_background_image']) || $map_category['menu_background_image'] != '')
                                                        <img src="{{ $map_category['menu_background_image'] }}" width="70">
                                                    @else
                                                        Image Not Selected
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <label for="polianna_logo_bg_color">Logo Background Color</label>
                                                    <input type="color" name="polianna_logo_bg_color" id="polianna_logo_bg_color" class="form-control" value="{{ $map_category['polianna_logo_bg_color'] }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="polianna_menu_cross_color">Menu Cross Color</label>
                                                    <input type="color" name="polianna_menu_cross_color" id="polianna_menu_cross_color" class="form-control" value="{{ $map_category['polianna_menu_cross_color'] }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="polianna_notification_bg_color">Notification Background Color</label>
                                                    <input type="color" name="polianna_notification_bg_color" id="polianna_notification_bg_color" class="form-control" value="{{ $map_category['polianna_notification_bg_color'] }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="polianna_notification_font_color">Notification Font Color</label>
                                                    <input type="color" name="polianna_notification_font_color" id="polianna_notification_font_color" class="form-control" value="{{ $map_category['polianna_notification_font_color'] }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="title_image_url">Title Image URL</label>
                                                    <input type="text" name="title_image_url" id="title_image_url" class="form-control p-1 mb-2" value="{{ $map_category['title_image_url'] }}">
                                                    @if(!empty($map_category['title_image_url']) || $map_category['title_image_url'] != '')
                                                        <img src="{{ $map_category['title_image_url'] }}" width="70">
                                                    @else
                                                        Url Not Available
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- End Card Body --}}
                                </div>
                            </form>
                            {{-- End Form --}}
                        </div>
                        {{-- End Card --}}
                    </div>
                </div>
            </div>
        </section>
        {{-- End Form Section --}}
    </div>
</section>
{{-- End Section of App Settings --}}


{{-- Footer --}}
@include('footer')
{{-- End Footer --}}
