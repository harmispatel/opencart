@include('header')

<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">


{{-- Section of List App Settings --}}
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
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-header" style="background: #f9f3f3">
                            <h3 class="card-title pt-2" style="color: black">
                                <i class="fas fa-cog mr-2"></i>
                                SETTINGS
                            </h3>
                            <div class="container" style="text-align: right">
                                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-save"></i></button>
                            </div>
                        </div>
                        {{-- Card Start --}}
                        <div class="card card-primary">
                            <div class="accordion" id="accordionExample">
                                <div class="card" style="margin-bottom: 0 !important;">
                                    <div class="card-header" id="headingOne" style="background-color: #1BBC9B">
                                        <h2 class="mb-0">
                                            <button class="btn btn-link btn-block text-bold text-white text-left"
                                                type="button" data-toggle="collapse" data-target="#collapseOne"
                                                aria-expanded="true" aria-controls="collapseOne"><i
                                                    class="pr-2 nav-icon fa fa-th"></i>
                                                APP SETTINGS
                                            </button>
                                        </h2>
                                    </div>

                                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                        data-parent="#accordionExample">
                                        <div class="card-body">
                                            <form>
                                                <div class="form-group">
                                                    <label for="manubackground">Menu Background Image</label>
                                                    <input type="file" class="form-control" id="manubackground">
                                                </div>
                                                <div class="form-group">
                                                    <label for="androidappid">Android App Id</label>
                                                    <input type="text" class="form-control" id="androidappid"
                                                        placeholder="Android App Id">
                                                </div>
                                                <div class="btn-group my-2">
                                                    <label style="width: 150px">App Available</label>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="inlineCheckbox1" value="1">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="appleappid">Apple App Id</label>
                                                    <input type="text" class="form-control" id="appleappid"
                                                        placeholder="Apple App Id">
                                                </div>
                                                <div class="form-group">
                                                    <label for="homebgcolor">Home Background Color</label>
                                                    <input type="color" class="form-control" id="homebgcolor">
                                                </div>
                                                <div class="form-group">
                                                    <label for="logobgcolor">Logo Background Color</label>
                                                    <input type="color" class="form-control" id="logobgcolor">
                                                </div>
                                                <div class="form-group">
                                                    <label for="menucolor">Menu Cross Color</label>
                                                    <input type="color" class="form-control" id="menucolor">
                                                </div>
                                                <div class="form-group">
                                                    <label for="notificationcolor">Notification Background Color</label>
                                                    <input type="color" class="form-control" id="notificationcolor">
                                                </div>
                                                <div class="form-group">
                                                    <label for="notificationforncolor">Notification Font Color</label>
                                                    <input type="color" class="form-control" id="notificationforncolor"">
                                                </div>
                                                <div class="form-group">
                                                    <label for="titleurl">Title Image Url</label>
                                                    <input type="file" class="form-control" id="titleurl">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- End Card --}}
                </div>
            </div>
    </div>
</section>
{{-- End Form Section --}}

</div>
</section>
{{-- End Section of List App Settings --}}



@include('footer')


{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/3.4.0/js/bootstrap-colorpicker.min.js"></script> --}}
<script>
    // $(function () {
    //   // Basic instantiation:
    //   $('#demo-input').colorpicker();
      
    //   // Example using an event, to change the color of the #demo div background:
    //   $('#demo-input').on('colorpickerChange', function(event) {
    //     $('#demo').css('background-color', event.color.toString());
    //   });
    // });
  </script>
{{-- </script> --}}
