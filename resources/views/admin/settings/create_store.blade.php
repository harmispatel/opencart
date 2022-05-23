{{-- Header --}}
@include('header')
{{-- End Header --}}

<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">

{{-- CUSTOM CSS --}}
<style>
    /* Custom Radio Button */
    .enable_booking_module
    {
        display: none;
    }
    .enable_booking_module:checked+label
    {
        background: dimgrey !important;
        color: #fff;
    }


    .sms_notification_status
    {
        display: none;
    }
    .sms_notification_status:checked+label
    {
        background: dimgrey !important;
        color: #fff;
    }


    .enable_ajax_checkout
    {
        display: none;
    }
    .enable_ajax_checkout:checked+label
    {
        background: dimgrey !important;
        color: #fff;
    }


    .enable_notify_email
    {
        display: none;
    }
    .enable_notify_email:checked+label
    {
        background: dimgrey !important;
        color: #fff;
    }

    .enable_res_api
    {
        display: none;
    }
    .enable_res_api:checked+label
    {
        background: dimgrey !important;
        color: #fff;
    }


    .enable_msg_api
    {
        display: none;
    }
    .enable_msg_api:checked+label
    {
        background: dimgrey !important;
        color: #fff;
    }
</style>
{{-- END CUSTOM CSS --}}

{{-- Section of Shop Settings --}}
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
                        <h1>Shop Settings</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Shop Settings </li>
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
                            <form action="{{ route('savestoredata') }}" method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}

                                    {{-- Card Header --}}
                                    <div class="card-header" style="background: #f6f6f6">
                                        <h3 class="card-title pt-2" style="color: black">
                                            <i class="fa fa-cog pr-2"></i>
                                            SETTINGS
                                        </h3>

                                        <div class="container" style="text-align: right">
                                            <button type="submit" class="btn btn-sm btn-primary">
                                                <i class="fa fa-save"></i>
                                            </button>
                                        </div>
                                    </div>
                                {{-- End Card Header --}}

                                {{-- Card Body --}}
                                <div class="card-body">
                                    {{-- Tabs Link --}}
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                        <a class="nav-link active" id="general-tab" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="true">General</a>
                                        </li>
                                        <li class="nav-item">
                                        <a class="nav-link" id="notification-tab" data-toggle="tab" href="#notification" role="tab" aria-controls="notification" aria-selected="false">Notification</a>
                                        </li>
                                        <li class="nav-item">
                                        <a class="nav-link" id="suspend-maintenance-tab" data-toggle="tab" href="#suspend-maintenance" role="tab" aria-controls="suspend-maintenance" aria-selected="false">Suspend / Maintenance Mode</a>
                                        </li>
                                    </ul>
                                    {{-- End Tabs Link --}}

                                    {{-- Tabs Content --}}
                                    <div class="tab-content" id="myTabContent">

                                        {{-- General Tab --}}
                                        <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                                            <div class="row mt-4">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <input type="hidden" name="setting" value="shop">
                                                    </div>
                                                    <div class="form-group">
                                                        <label><span class="text-danger">*</span> Website Address:</label>
                                                        <input type="text" class="form-control {{ ($errors->has('config_url')) ? 'is-invalid' : '' }}" id="config_url" name="config_url" value="{{ old('config_url') }}">
                                                        <code class="text-muted">
                                                            Include the full URL to your store. Make sure to add '/' at the end. Example: http://www.yourdomain.com/path/. <br> Don't use directories to create a new store. You should always point another domain or sub domain to your hosting.
                                                        </code>
                                                        @if ($errors->has('config_url'))
                                                            <div class="invalid-feedback">
                                                                {{ $errors->first('config_url') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <hr>
                                                    <div class="form-group">
                                                        <label>Use SSL</label>
                                                        <div class="form-control">
                                                            <input type="radio" name="config_secure" value="1" {{(old('config_secure') == 1) ? 'checked' : ''}}>
                                                            <label class="form-check-label">Yes</label>
                                                            <input type="radio" name="config_secure" value="0" {{(old('config_secure') == 0) ? 'checked' : ''}}>
                                                            <label class="form-check-label">No</label>
                                                        </div>
                                                        <code class="text-muted">
                                                            To use SSL check with your host if a SSL certificate is installed.
                                                        </code>
                                                    </div>
                                                    <hr>
                                                    <div class="form-group">
                                                        <label>SSL URL</label>
                                                        <input type="text" class="form-control {{ ($errors->has('config_ssl')) ? 'is-invalid' : '' }}" id="config_ssl" name="config_ssl"  >
                                                        <code class="text-muted">
                                                            SSL URL to your store. Make sure to add '/' at the end. Example: http://www.yourdomain.com/path/ <br> Don't use directories to create a new store. You should always point another domain or sub domain to your hosting.
                                                        </code>
                                                        @if ($errors->has('config_ssl'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('config_ssl') }}
                                                        </div>
                                                    @endif
                                                    </div>
                                                    <hr>
                                                    <div class="form-group">
                                                        <label><span class="text-danger">*</span> Shop Name</label>
                                                        <input type="text" class="form-control {{ ($errors->has('config_name')) ? 'is-invalid' : '' }}" id="config_name" name="config_name" value="{{ old('config_name') }}">
                                                        @if ($errors->has('config_name'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('config_name') }}
                                                        </div>
                                                    @endif
                                                    </div>
                                                    <hr>
                                                    <div class="form-group">
                                                        <label><span class="text-danger">*</span> Shop Owner Name</label>
                                                        <input type="text" class="form-control {{ ($errors->has('config_owner')) ? 'is-invalid' : '' }}" id="config_owner" name="config_owner" value="{{ old('config_owner') }}">
                                                        @if ($errors->has('config_owner'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('config_owner') }}
                                                        </div>
                                                    @endif
                                                    </div>
                                                    <hr>
                                                    <div class="form-group">
                                                        <label><span class="text-danger">*</span> Address</label>
                                                        <textarea class="form-control {{ ($errors->has('config_address')) ? 'is-invalid' : '' }}" id="config_address" name="config_address" rows="3">{{ old('config_address') }}</textarea>
                                                        @if ($errors->has('config_address'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('config_address') }}
                                                        </div>
                                                    @endif
                                                    </div>
                                                    <hr>
                                                    <div class="form-group">
                                                        <label>Country</label>
                                                        <select class="form-control {{ ($errors->has('config_country_id')) ? 'is-invalid' : '' }}" id="country_id" name="config_country_id" onchange="getstate()">
                                                            <option value="">Select Counrty</option>
                                                            @foreach ($countries as $country)
                                                                <option value="{{ $country->country_id }}">{{ $country->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @if ($errors->has('config_country_id'))
                                                            <div class="invalid-feedback">
                                                                {{ $errors->first('config_country_id') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <hr>
                                                    <div class="form-group">
                                                        <input type="hidden" name="zone_id" id="zone_id">
                                                        <label>Region</label>
                                                        <select class="form-control {{ ($errors->has('config_url')) ? 'is-invalid' : '' }}" id="config_zone_id" name="config_zone_id"></select>
                                                        @if ($errors->has('config_zone_id'))
                                                            <div class="invalid-feedback">
                                                                {{ $errors->first('config_zone_id') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <hr>
                                                    <div class="form-group">
                                                        <label>Post code</label>
                                                        <input type="text" class="form-control {{ ($errors->has('map_post_code')) ? 'is-invalid' : '' }}" id="map_post_code" name="map_post_code" value="{{ old('map_post_code') }}">
                                                        @if ($errors->has('map_post_code'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('map_post_code') }}
                                                        </div>
                                                    @endif
                                                    </div>
                                                    <hr>
                                                    <div class="form-group">
                                                        <label>Google Maps</label>
                                                        <input type="text" class="form-control" id="map_ifram" name="map_ifram" value="{{ old('map_ifram') }}">
                                                    </div>
                                                    <hr>
                                                    <div class="form-group">
                                                        <label>Google Sitemap URL</label>
                                                        <input type="text" class="form-control" id="sitemap_url" name="sitemap_url" value="{{ old('sitema_url') }}">
                                                    </div>
                                                    <hr>
                                                    <div class="form-group">
                                                        <label><span class="text-danger">*</span> Telephone 1</label>
                                                        <input type="text" class="form-control {{ ($errors->has('config_telephone')) ? 'is-invalid' : '' }}" id="config_telephone" name="config_telephone" value="{{ old('config_telephone') }}">
                                                        @if ($errors->has('config_telephone'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('config_telephone') }}
                                                        </div>
                                                    @endif
                                                    </div>
                                                    <hr>
                                                    <div class="form-group">
                                                        <label>Telephone 2</label>
                                                        <input type="text" class="form-control" id="config_fax" name="config_fax" value="{{ old('config_fax') }}">
                                                    </div>
                                                    <hr>
                                                    <div class="form-group">
                                                        <label>Language</label>
                                                        <select class="form-control" id="config_language" name="config_language">
                                                            @foreach ($language as $lang)
                                                                <option value="{{ $lang->code }}">{{ $lang->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <hr>
                                                    <div class="form-group">
                                                        <label>Currency</label>
                                                        <select class="form-control" id="config_currency" name="config_currency">
                                                            @foreach ($currency as $curr)
                                                                <option value="{{ $curr->code }}">{{ $curr->title }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <hr>
                                                    <div class="form-group">
                                                        <label><span class="text-danger">*</span> Title</label>
                                                        <input type="text" class="form-control {{ ($errors->has('config_title')) ? 'is-invalid' : '' }}" id="config_title" name="config_title" value="{{ old('config_title') }}">
                                                        @if ($errors->has('config_title'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('config_title') }}
                                                        </div>
                                                    @endif
                                                    </div>
                                                    <hr>
                                                    <div class="form-group">
                                                        <label>Meta Tag Description</label>
                                                        <textarea class="form-control" id="config_meta_description" name="config_meta_description" rows="3">{{ old('config_mata_description') }}</textarea>
                                                    </div>
                                                    <hr>
                                                    <div class="form-group">
                                                        <label>Logo</label>
                                                        <input type="file" class="form-control p-1" name="config_logo" id="config_logo" value="{{ old('config_logo') }}">
                                                    </div>
                                                    <hr>
                                                    <div class="form-group">
                                                        <label>Icon</label>
                                                        <input type="file" class="form-control p-1" name="config_icon" id="config_icon" value="{{ old('config_icon') }}">
                                                        <code class="text-muted">
                                                            The icon should be a PNG that is 16px x 16px.
                                                        </code><br>
                                                    </div>
                                                    <hr>
                                                    <div class="form-group">
                                                        <label>Google ReCaptcha</label>
                                                        <select class="form-control" id="grecaptcha" name="grecaptcha">
                                                            <option value="1" {{(old('grecapcha') == 1) ? 'checked': ''}}>Enable</option>
                                                            <option value="0" {{(old('grecapcha') == 0) ? 'checked': ''}}>Disable</option>
                                                        </select>
                                                    </div>
                                                    <hr>
                                                    <div class="form-group">
                                                        <label>Booking Module</label><br>
                                                        <div class="btn-group">
                                                            <input type="radio" class="enable_booking_module" id="enable_booking_module1" name="enable_booking_module" value="1"/>
                                                            <label class="btn btn-sm" style=" background: green;color:white;" for="enable_booking_module1">Enable</label>

                                                            <input type="radio" class="enable_booking_module" id="enable_booking_module2" name="enable_booking_module" value="0"/>
                                                            <label class="btn btn-sm" style=" background: red;color: white;" for="enable_booking_module2">Disable</label>
                                                         </div>
                                                    </div>
                                                    <hr>
                                                    <div class="form-group">
                                                        <label>File Directory URL</label>
                                                        <input type="text" class="form-control {{ ($errors->has('file_directory_url')) ? 'is-invalid' : '' }}" id="file_directory_url" name="file_directory_url" value="{{ old('file_directory_url') }}">
                                                        @if ($errors->has('file_directory_url'))
                                                            <div class="invalid-feedback">
                                                                {{ $errors->first('file_directory_url') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <hr>
                                                    <div class="form-group">
                                                        <label class="mr-3">Service Charges</label>
                                                        <input type="radio" name="service_charge_type" value="1">
                                                        <label>Fixed</label>
                                                        <input type="radio" name="service_charge_type" value="2">
                                                        <label>Percentage</label>
                                                        <input type="text" class="form-control" id="service_charge" name="service_charge">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- End General Tab --}}

                                        {{-- Notification Tab --}}
                                        <div class="tab-pane fade" id="notification" role="tabpanel" aria-labelledby="notification-tab">
                                            <div class="row mt-4">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label><span class="text-danger">*</span> E-Mail</label>
                                                        <input type="text" class="form-control {{ ($errors->has('config_email')) ? 'is-invalid' : '' }}" id="config_email" name="config_email" value="{{ old('config_ssl') }}">
                                                        @if ($errors->has('config_email'))
                                                            <div class="invalid-feedback">
                                                                {{ $errors->first('config_email') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <hr>
                                                    <h4 class="text-warning" style="border-bottom: dotted black 1px">SMS NOTTIFICATION</h4>
                                                    <div class="form-group">
                                                        <label>SMS API URL</label>
                                                        <input type="text" class="form-control" id="sms_api_url" name="sms_api_url" value="{{ old('sms_api_url') }}"                  >
                                                        <code class="text-muted">[PhoneNumber] = Notification Number [SenderId] : Order Id [Store Message] = Message Content</code>
                                                    </div>
                                                    <hr>
                                                    <div class="form-group">
                                                        <label>SMS NOTIFICATION</label><br>
                                                        <div class="btn-group">
                                                            <input type="radio" class="sms_notification_status" id="sms_notification_status1" name="sms_notification_status" value="1"/>
                                                            <label class="btn btn-sm" style=" background: green;color:white;" for="sms_notification_status1">Enable</label>

                                                            <input type="radio" class="sms_notification_status" id="sms_notification_status2" name="sms_notification_status" value="0"/>
                                                            <label class="btn btn-sm" style=" background: red;color: white;" for="sms_notification_status2">Disable</label>
                                                         </div>
                                                    </div>
                                                    <hr>
                                                    <div class="form-group">
                                                        <label>SMS Notification Time [MIN]</label>
                                                        <input class="form-control" type="number" id="sms_notification_time" name="sms_notification_time" value="{{ old('sms_notification_time') }}">
                                                        <code class="text-muted">0 for instant SMS Order Notification</code>
                                                    </div>
                                                    <hr>
                                                    <div class="form-group">
                                                        <label>Notification Number</label>
                                                        <input class="form-control" type="number" id="sms_notification_number" name="sms_notification_number" value="{{ old('sms_notification_number') }}">
                                                    </div>
                                                    <hr><br>
                                                    <h4 class="text-warning" style="border-bottom: dotted black 1px">PRINTER CONFIG</h4>
                                                    <div class="form-group">
                                                        <label class="mr-4">Restaurant ID</label>
                                                    </div>
                                                    <hr>
                                                    <div class="form-group">
                                                        <label>Account</label>
                                                        <input class="form-control" type="text" id="config_account_printer" name="config_account_printer" value="{{ old('config_account_printer') }}">
                                                    </div>
                                                    <hr>
                                                    <div class="form-group">
                                                        <label>Password</label>
                                                        <input class="form-control" type="text" id="config_password_printer" name="config_password_printer" value="{{ old('config_password_printer') }}">
                                                    </div>
                                                    <hr>
                                                    <div class="form-group">
                                                        <label>Feed url</label><br>
                                                        <span>''</span>
                                                    </div>
                                                    <hr>
                                                    <div class="form-group">
                                                        <label>Callback url</label><br>
                                                        <span>''</span>
                                                    </div>
                                                    <hr>
                                                    <div class="form-group">
                                                        <label>API Feed url</label><br>
                                                        <span>''</span>
                                                    </div>
                                                    <hr>
                                                    <div class="form-group">
                                                        <label>Order API Callback url</label><br>
                                                        <span>''</span>
                                                    </div>
                                                    <hr>
                                                    <div class="form-group">
                                                        <label>Reservation API Callback url</label><br>
                                                        <span>''</span>
                                                    </div>
                                                    <hr>
                                                    <div class="form-group">
                                                        <label>Message API Callback url</label><br>
                                                        <span>''</span>
                                                    </div>
                                                    <hr>
                                                    <div class="form-group">
                                                        <label>ENABLE AJAX CHECKOUT</label><br>
                                                        <div class="btn-group">
                                                            <input type="radio" class="enable_ajax_checkout" id="enable_ajax_checkout1" name="enable_ajax_checkout"/>
                                                            <label class="btn btn-sm" style=" background: green;color:white;" for="enable_ajax_checkout1">Enable</label>

                                                            <input type="radio" class="enable_ajax_checkout" id="enable_ajax_checkout2" name="enable_ajax_checkout"/>
                                                            <label class="btn btn-sm" style=" background: red;color: white;" for="enable_ajax_checkout2">Disable</label>
                                                         </div>
                                                    </div>
                                                    <hr>
                                                    <div class="form-group">
                                                        <label>ENABLE NOTIFICATION E-MAIL</label><br>
                                                        <div class="btn-group">
                                                            <input type="radio" class="enable_notify_email" id="enable_notify_email1" name="enable_notify_email"/>
                                                            <label class="btn btn-sm" style=" background: green;color:white;" for="enable_notify_email1">Enable</label>

                                                            <input type="radio" class="enable_notify_email" id="enable_notify_email2" name="enable_notify_email"/>
                                                            <label class="btn btn-sm" style=" background: red;color: white;" for="enable_notify_email2">Disable</label>
                                                         </div>
                                                    </div>
                                                    <hr>
                                                    <div class="form-group">
                                                        <label>ENABLE RESERVATION API</label><br>
                                                        <div class="btn-group">
                                                            <input type="radio" class="enable_res_api" id="enable_res_api1" name="enable_res_api" value="1"/>
                                                            <label class="btn btn-sm" style=" background: green;color:white;" for="enable_res_api1">Enable</label>

                                                            <input type="radio" class="enable_res_api" id="enable_res_api2" name="enable_res_api" value="0"/>
                                                            <label class="btn btn-sm" style=" background: red;color: white;" for="enable_res_api2">Disable</label>
                                                         </div>
                                                    </div>
                                                    <hr>
                                                    <div class="form-group">
                                                        <label>ENABLE MESSAGE API</label><br>
                                                        <div class="btn-group">
                                                            <input type="radio" class="enable_msg_api" id="enable_msg_api1" name="enable_msg_api" value="1"/>
                                                            <label class="btn btn-sm" style=" background: green;color:white;" for="enable_msg_api1">Enable</label>

                                                            <input type="radio" class="enable_msg_api" id="enable_msg_api2" name="enable_msg_api" value="0"/>
                                                            <label class="btn btn-sm" style=" background: red;color: white;" for="enable_msg_api2">Disable</label>
                                                         </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- End Notification Tab --}}

                                        {{-- Suspend Tab --}}
                                        <div class="tab-pane fade" id="suspend-maintenance" role="tabpanel" aria-labelledby="suspend-maintenance-tab">
                                            <div class="row mt-4">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Suspend Permanently</label><br>
                                                        <input type="checkbox" name="suspend_permanently" id="suspend_permanently" value="yes" >
                                                    </div>
                                                    <hr>
                                                    <div class="form-group">
                                                        <label>Suspend</label><br>
                                                        <div class="form-control">
                                                            <input type="radio" name="suspend_for" value="web">
                                                            <label>Web</label>
                                                            <input type="radio" name="suspend_for" value="app">
                                                            <label>App</label>
                                                            <input type="radio" name="suspend_for" value="both">
                                                            <label>Both</label>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="form-group">
                                                        <label>Suspend for Time</label>
                                                        <input class="form-control" type="date" id="suspend_time" name="suspend_time" value="{{ old('suspend_time') }}">
                                                    </div>
                                                    <hr>
                                                    <div class="form-group">
                                                        <label>Icon</label>
                                                        <input type="file" class="form-control p-1" id="suspend_logo" name="suspend_logo" value="{{ old('suspend_logo') }}">
                                                    </div>
                                                    <hr>
                                                    <div class="form-group">
                                                        <label>Title</label>
                                                        <input class="form-control" type="text" id="suspend_title" name="suspend_title" value="{{ old('suspend_title') }}">
                                                    </div>
                                                    <hr>
                                                    <div class="form-group">
                                                        <label>Description</label>
                                                        <textarea class="form-control" id="suspend_description" name="suspend_description" rows="3">{{ old('suspend_description') }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- End Suspend Tab --}}
                                    </div>
                                    {{-- End Tabs Content --}}
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
{{-- End Section of Shop Settings --}}


{{-- Footer --}}
@include('footer')
{{-- End Footer --}}


{{-- SCRIPT --}}
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">
    // START Function Get Stat Country ID
    function getstate()
    {
        var country_id = $('#country_id :selected').val();
        $.ajax({
                type: "POST",
                url: "{{ url('getRegionbyCountry') }}",
                data: {'country_id': country_id,"_token": "{{ csrf_token() }}"},
                // data: {'country_id': country_id,"_token": "{{ csrf_token() }}"},
                dataType: "json",
                cache: false,
                success: function(response)
                {
                    $('#config_zone_id').text('');
                    $('#config_zone_id').append(response);
                }
        });
    }
    // End Function Country ID


</script>
{{-- END SCRIPT --}}
