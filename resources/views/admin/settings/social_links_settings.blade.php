<!--
    THIS IS HEADER Social_Links_Setting PAGE FOR ADMIN PANEL
    ----------------------------------------------------------------------------------------------
    social_links_setting.blade.php
    This for Edit Social_Links_Setting
    ----------------------------------------------------------------------------------------------

-->

{{-- Header --}}
@include('header')
{{-- End Header --}}

<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">


{{-- Section of List Social Links Settings --}}
<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
        <section class="content-header">
            <div class="container-fluid">
                @if(Session::has('success'))
                    <div class="alert alert-success del-alert alert-dismissible" id="alert" role="alert">
                        {{ Session::get('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Social Links Settings</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Social Links Settings </li>
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
                        <div class="card">
                            {{-- Form --}}
                            <form method="POST" action="{{ route('updatesociallinks') }}" enctype="multipart/form-data">
                                {{ @csrf_field() }}

                                {{-- Card Header --}}
                                <div class="card-header" style="background: #f6f6f6">
                                    <h3 class="card-title pt-2" style="color: black">
                                        <i class="fas fa-cog mr-2"></i>
                                        SETTINGS
                                    </h3>
                                    <div class="container" style="text-align: right">
                                        @if (check_user_role(91) == 1)
                                            <button type="submit" class="btn btn-sm btn-primary">
                                                <i class="fa fa-save"></i>
                                            </button>
                                        @else
                                            <button class="btn btn-sm btn-primary" disabled>
                                                <i class="fa fa-save"></i>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                                {{-- End Card Header --}}

                                 {{-- Card Body --}}
                                 <div class="card-body">
                                     @php
                                        $current_store = currentStoreId();

                                        $user_details = user_details();
                                        if(isset($user_details))
                                        {
                                            $user_group_id = $user_details['user_group_id'];
                                        }
                                        $user_shop_id = $user_details['user_shop'];

                                        if($user_group_id == 1)
                                        {
                                            $facebook = getStoreDetails($current_store,'polianna_facebook_id');
                                            $twitter = getStoreDetails($current_store,'polianna_twitter_username');
                                            $gplus = getStoreDetails($current_store,'polianna_gplus_id');
                                            $linkedin = getStoreDetails($current_store,'polianna_linkedin_id');
                                            $youtube = getStoreDetails($current_store,'polianna_youtube_id');
                                        }
                                        else
                                        {
                                            $facebook = getStoreDetails($user_shop_id,'polianna_facebook_id');
                                            $twitter = getStoreDetails($user_shop_id,'polianna_twitter_username');
                                            $gplus = getStoreDetails($user_shop_id,'polianna_gplus_id');
                                            $linkedin = getStoreDetails($user_shop_id,'polianna_linkedin_id');
                                            $youtube = getStoreDetails($user_shop_id,'polianna_youtube_id');
                                        }

                                     @endphp
                                    <div class="form-group">
                                        <i class="fab fa-facebook-square pr-2" style="font-size: 20px;"></i>
                                        <label>Facebook Profile</label>
                                        <input type="text" name="polianna_facebook_id" id="polianna_facebook_id" class="form-control" value="{{ $facebook }}">
                                    </div>
                                    <div class="form-group">
                                        <i class="fab fa-twitter-square pr-2" style="font-size: 20px;"></i>
                                        <label>Twitter Profile</label>
                                        <input type="text" name="polianna_twitter_username" id="polianna_twitter_username" class="form-control" value="{{ $twitter }}">
                                    </div>
                                    <div class="form-group">
                                        <i class="fab fa-google-plus-square pr-2" style="font-size: 20px;"></i>
                                        <label>Google+ Profile</label>
                                        <input type="text" name="polianna_gplus_id" id="polianna_gplus_id" class="form-control" value="{{ $gplus }}">
                                    </div>
                                    <div class="form-group">
                                        <i class="fab fa-linkedin pr-2" style="font-size: 20px;"></i>
                                        <label>Linkedin Profile</label>
                                        <input type="text" name="polianna_linkedin_id" id="polianna_linkedin_id" class="form-control" value="{{ $linkedin }}">
                                    </div>
                                    <div class="form-group">
                                        <i class="fab fa-youtube pr-2" style="font-size: 20px;"></i>
                                        <label>Youtube Profile</label>
                                        <input type="text" name="polianna_youtube_id" id="polianna_youtube_id" class="form-control" value="{{ $youtube }}">
                                    </div>
                                 </div>
                                 {{-- End Card Body --}}
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
{{-- End Section of List Social Links Settings --}}


{{-- Footer --}}
@include('footer')
{{-- End Footer --}}
