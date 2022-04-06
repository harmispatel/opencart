@include('header')

<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">
<style>
    /* Custom Radio Button */
    .radio {
        display: none;
    }

    .radio:checked+label {
        background: dimgrey !important;
        color: #fff;
    }

</style>

{{-- Section of List Map and Category Settings --}}
<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Map and Category Settings</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Map and Category Settings </li>
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
                            {{-- Card Header --}}
                            {{-- <div class="card-header" style="background: #f6f6f6">
                                <h3 class="card-title pt-2" style="color: black">
                                    <i class="fa fa-list pr-2"></i>
                                    Cart Rule
                                </h3>

                                <div class="container" style="text-align: right">
                                    @if (check_user_role(71) == 1)
                                        <a href="{{ route('addfreerule') }}"
                                            class="btn btn-sm btn-primary ml-auto px-1">Insert</a>
                                    @endif

                                    @if (check_user_role(73) == 1)
                                        <a href="#"
                                            class="btn btn-sm btn-danger ml-auto px-1 deletesellected">Delete</a>
                                    @endif
                                </div>
                            </div> --}}
                            {{-- End Card Header --}}

                            {{-- Card Body --}}
                            <div class="card-body">
                                {{-- Table --}}
                                    {{-- Alert Message Div --}}
                                    <div class="alert alert-success del-alert alert-dismissible" id="alert"
                                        style="display: none" role="alert">
                                        <p id="success-message" class="mb-0"></p>
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    {{-- End Alert Message Div --}}

                                    <form>
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
                                          <div class="tab-content" id="myTabContent">
                                            <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                                                <div class="form-group pt-2">
                                                    <label for="webaddress">* Website Address:</label>
                                                    <input type="text" class="form-control" id="webaddress" name="webaddress" value="" aria-describedby="emailHelp">
                                                    <small class="form-text text-muted">Include the full URL to your store. Make sure to add '/' at the end. Example: http://www.yourdomain.com/path/ <br><br> Don't use directories to create a new store. You should always point another domain or sub domain to your hosting.</small>
                                                  </div>
                                            <div class="form-group">
                                                <label for="webaddress" style="width: 100px">Use SSL:</label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="ssl" id="sslyes" value="1">
                                                    <label class="form-check-label" for="sslyes">Yes</label>
                                                  </div>
                                                  <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="ssl" id="sslno" value="2">
                                                    <label class="form-check-label" for="sslno">No</label>
                                                  </div>
                                                  <small class="form-text text-muted">To use SSL check with your host if a SSL certificate is installed.</small>
                                            </div>
                                            <div class="form-group">
                                                <label for="sslurl">SSL URL:</label>
                                                <input type="text" class="form-control" id="sslurl" name="sslurl" value="" aria-describedby="emailHelp">
                                                <small class="form-text text-muted">SSL URL to your store. Make sure to add '/' at the end. Example: http://www.yourdomain.com/path/ <br><br> Don't use directories to create a new store. You should always point another domain or sub domain to your hosting.</small>
                                              </div>
                                              <div class="form-group">
                                                <label for="shop_name">* Shop Name:</label>
                                                <input type="text" class="form-control" id="shop_name" name="shop_name" value="">
                                              </div>
                                              <div class="form-group">
                                                <label for="owner_name">* Shop Owner Name:</label>
                                                <input type="text" class="form-control" id="owner_name" name="owner_name" value="">
                                              </div>
                                              <div class="form-group">
                                                <label for="address">* Address:</label>
                                                <textarea class="form-control" id="address" name="address" rows="3"></textarea>
                                              </div>
                                              <div class="form-group">
                                                <label for="region">Region:</label>
                                                <select class="form-control" id="region" name="region">
                                                    <option>Default select</option>
                                                  </select>
                                              </div>
                                              <div class="form-group">
                                                <label for="post_code">Post code:</label>
                                                <input type="text" class="form-control" id="post_code" name="post_code" value="">
                                              </div>
                                              <div class="form-group">
                                                <label for="country">Country:</label>
                                                <select class="form-control" id="country" name="country">
                                                    <option>Default select</option>
                                                  </select>
                                              </div>
                                              <div class="form-group">
                                                <label for="gmap">Google Maps:</label>
                                                <input type="text" class="form-control" id="gmap" name="gmap" value="">
                                              </div>
                                              <div class="form-group">
                                                <label for="gsiteurl">Google Sitemap URL:</label>
                                                <input type="text" class="form-control" id="gsiteurl" name="gsiteurl" value="">
                                              </div>
                                              <div class="form-group">
                                                <label for="telephone_1">* Telephone 1:</label>
                                                <input type="text" class="form-control" id="telephone_1" name="telephone_1" value="">
                                              </div>
                                              <div class="form-group">
                                                <label for="telephone_1">* Telephone 2:</label>
                                                <input type="text" class="form-control" id="telephone_2" name="telephone_2" value="">
                                              </div>
                                              <div class="form-group">
                                                <label for="language">Language:</label>
                                                <select class="form-control" id="language" name="language">
                                                    <option>Default select</option>
                                                  </select>
                                              </div>
                                              <div class="form-group">
                                                <label for="currency">Currency:</label>
                                                <select class="form-control" id="currency" name="currency">
                                                    <option>Default select</option>
                                                  </select>
                                              </div>
                                              <div class="form-group">
                                                <label for="title">* Title:</label>
                                                <input type="text" class="form-control" id="title" name="title" value="">
                                              </div>
                                              <div class="form-group">
                                                <label for="meta_description">Meta Tag Description:</label>
                                                <textarea class="form-control" id="meta_description" name="meta_description" rows="3"></textarea>
                                              </div>
                                              <div class="form-group">
                                                <label for="logo">Logo:</label>
                                                <input type="file" class="form-control-file" name="logo" id="logo">
                                              </div>
                                              <div class="form-group">
                                                <label for="icon">Logo:</label>
                                                <input type="file" class="form-control-file" name="icon" id="icon">
                                                <small class="form-text text-muted">The icon should be a PNG that is 16px x 16px.</small>
                                              </div>
                                              <div class="form-group">
                                                <label for="google_captcha">Google ReCaptcha:</label>
                                                <select class="form-control" id="google_captcha" name="google_captcha">
                                                    <option>Default select</option>
                                                  </select>
                                              </div>
                                              <div class="form-group">
                                                <label for="file_url">File Directory URL:</label>
                                                <input type="text" class="form-control" id="file_url" name="file_url" value="/">
                                              </div>
                                              <div class="form-group">
                                                <label for="service_charge" style="width: 150px">Service Charges:</label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="service" id="s_chargey" value="1">
                                                    <label class="form-check-label" for="s_chargey">Yes</label>
                                                  </div>
                                                  <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="service" id="s_chargen" value="2">
                                                    <label class="form-check-label" for="s_chargen">No</label>
                                                  </div>
                                                <input type="text" class="form-control" id="service_charge" name="service_charge" value="">
                                              </div>                                           

                                              </div>
                                            <div class="tab-pane fade" id="notification" role="tabpanel" aria-labelledby="notification-tab">
                                                <div class="form-group">
                                                    <label for="email">* E-Mail:</label>
                                                    <input type="text" class="form-control" id="email" name="email" value="">
                                                  </div>
                                                  <h4 class="text-success" style="border-bottom: dotted black 1px">SMS NOTTIFICATION</h4>
                                                  <div class="form-group">
                                                    <label for="sms_url">SMS API URL</label>
                                                    <input type="text" class="form-control" id="sms_url" name="sms_url" value="">
                                                    <small>[PhoneNumber] = Notification Number [SenderId] : Order Id [Store Message] = Message Content</small>
                                                  </div>
                                                  <div class="btn-group">
                                                    <label for="sms_url" style="width: 198px">SMS Notification</label>
                                                    <input type="radio" class="radio" id="enable" name="on_off" value="1"/>
                                                    <label class="btn btn-sm" style=" background: rgb(117,185,54);color:white;" for="enable">Enable</label>
                                                    <input type="radio" class="radio" id="disable" name="on_off" value="0"/>
                                                    <label class="btn btn-sm" style=" background: rgb(178,178,178);color: white;" for="disable">Disable</label>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sms_time">SMS Notification Time [Min]</label>
                                                    <input class="form-control" type="number" id="sms_time" name="sms_time"/>
                                                    <small>0 for instant SMS Order Notification</small>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sms_number">Notification Number</label>
                                                    <input class="form-control" type="number" id="sms_number" name="sms_number"/>
                                                </div>
                                                <h4 class="text-success" style="border-bottom: dotted black 1px">PRINTER CONFIG</h4>
                                                <div class="form-group">
                                                    <label style="width: 198px">Notification Number</label>0
                                                </div>
                                                <div class="form-group">
                                                    <label for="account">Account</label>
                                                    <input class="form-control" type="text" id="account" name="account" rows="3"/>
                                                </div>
                                                <div class="form-group">
                                                    <label for="password">password</label>
                                                    <input class="form-control" type="password" id="password" name="password" rows="3"/>
                                                </div>
                                                <div class="form-group">
                                                    <div class="d-flex">
                                                    <label style="width: 100%; max-width: 198px">Feed url</label><span>http://www.highworthkebab.co.uk/index.php?route=module/printer/request&a=0&u=highworthkebab&p=wTcSFE@42Wq</span>
                                                </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="d-flex">
                                                    <label style="width: 100%; max-width: 198px">Callback url</label><span>http://www.highworthkebab.co.uk/index.php?route=module/printer/callback&a=0&o=?&ak=?&m=?&dt=?&u=highworthkebab&p=wTcSFE@42Wq</span>
                                                </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="d-flex">
                                                    <label style="width: 100%; max-width: 198px">API Feed url</label><span>http://www.highworthkebab.co.uk/index.php?route=module/notification/feedapi&id=0&u=highworthkebab&p=wTcSFE@42Wq</span>
                                                </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="d-flex">
                                                    <label style="width: 100%; max-width: 198px">Order API Callback url</label><span>http://www.highworthkebab.co.uk/index.php?route=module/notification/callback&id=0&oid=?&ost=?&m=?&ot=?&u=highworthkebab&p=wTcSFE@42Wq</span>
                                                </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="d-flex">
                                                    <label style="width: 100%; max-width: 198px">Reservation API Callback url</label><span>http://www.highworthkebab.co.uk/index.php?route=module/notification/callback&id=0&rid=?&rst=?&m=?&u=highworthkebab&p=wTcSFE@42Wq</span>
                                                </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="d-flex">
                                                    <label style="width: 100%; max-width: 198px">Message API Callback url</label><span>http://www.highworthkebab.co.uk/index.php?route=module/notification/callback&id=0&mid=?&mst=?&m=?&u=highworthkebab&p=wTcSFE@42Wq</span>
                                                </div>
                                                </div>
                                                <div class="form-group">
                                                <div class="btn-group">
                                                    <label style="width: 198px">Enable Ajax Checkout</label>
                                                    <input type="radio" class="radio" id="enableajax" name="ajax_checkout" value="1"/>
                                                    <label class="btn btn-sm" style=" background: rgb(117,185,54);color:white;" for="enableajax">Enable</label>
                                                    <input type="radio" class="radio" id="disableajax" name="ajax_checkout" value="0"/>
                                                    <label class="btn btn-sm" style=" background: rgb(178,178,178);color: white;" for="disableajax">Disable</label>
                                                </div>
                                                </div>
                                                <div class="form-group">
                                                <div class="btn-group">
                                                    <label style="width: 198px">Enable Notification Email</label>
                                                    <input type="radio" class="radio" id="enableemail" name="notification_email" value="1"/>
                                                    <label class="btn btn-sm" style=" background: rgb(117,185,54);color:white;" for="enableemail">Enable</label>
                                                    <input type="radio" class="radio" id="disableemail" name="notification_email" value="0"/>
                                                    <label class="btn btn-sm" style=" background: rgb(178,178,178);color: white;" for="disableemail">Disable</label>
                                                </div>
                                                </div>
                                                <div class="form-group">
                                                <div class="btn-group">
                                                    <label style="width: 198px">Enable Reservation API</label>
                                                    <input type="radio" class="radio" id="enableReservation" name="reservation_api" value="1"/>
                                                    <label class="btn btn-sm" style=" background: rgb(117,185,54);color:white;" for="enableReservation">Enable</label>
                                                    <input type="radio" class="radio" id="disableReservation" name="reservation_api" value="0"/>
                                                    <label class="btn btn-sm" style=" background: rgb(178,178,178);color: white;" for="disableReservation">Disable</label>
                                                </div>
                                                </div>
                                                <div class="form-group">
                                                <div class="btn-group">
                                                    <label style="width: 198px">Enable Message API</label>
                                                    <input type="radio" class="radio" id="enableMessage" name="message_api" value="1"/>
                                                    <label class="btn btn-sm" style=" background: rgb(117,185,54);color:white;" for="enableMessage">Enable</label>
                                                    <input type="radio" class="radio" id="disableMessage" name="message_api" value="0"/>
                                                    <label class="btn btn-sm" style=" background: rgb(178,178,178);color: white;" for="disableMessage">Disable</label>
                                                </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="suspend-maintenance" role="tabpanel" aria-labelledby="suspend-maintenance-tab">
                                                <div class="form-group">
                                                    <div class="btn-group">
                                                        <label style="width: 198px">Suspend Permanently</label>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="1">
                                                        </div>  
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="btn-group">
                                                        <label style="width: 198px">Suspend</label>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="suspend" id="Suspend1" value="1">
                                                            <label class="form-check-label" for="Suspend1">Web</label>
                                                          </div>
                                                          <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="suspend" id="Suspend2" value="2">
                                                            <label class="form-check-label" for="Suspend2">App</label>
                                                          </div>
                                                          <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="suspend" id="Suspend3" value="3">
                                                            <label class="form-check-label" for="Suspend3">Both</label>
                                                          </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="suspend_time">Suspend_Time</label>
                                                    <input class="form-control" type="date" id="suspend_time" name="suspend_time"/>
                                                </div>
                                                <div class="form-group">
                                                    <label for="sicon">Icon</label>
                                                    <input type="file" class="form-control-file" id="sicon" name="sicon">
                                                  </div>
                                                  <div class="form-group">
                                                    <label for="title">Title</label>
                                                    <input class="form-control" type="text" id="title" name="title" />
                                                </div>
                                                <div class="form-group">
                                                    <label for="description">Description</label>
                                                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                                                </div>
                                            </div>
                                          </div>
                                          </div>
                                    </form>
                                    
                                {{-- End Table --}}
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
{{-- End Section of List Map and Category Settings --}}



@include('footer')

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">


</script>
