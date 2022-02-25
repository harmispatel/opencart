@include('header')

<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
{{-- Section of List Category --}}
<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Recurring Profiles</h1>
                        
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active"><a href="{{ route('recurringprofiles') }}">Recurring
                                    Profiles</li>
                            </a>
                            {{-- <li class="breadcrumb-item active">All</li> --}}
                        </ol>
                    </div>
                    {{-- End Breadcumb --}}
                    <div class="form-group ml-auto">
                        <button type="submit" form="catform" class="btn btn-primary"><i
                                class="fa fa-save">Save</i></button>
                        <a href="{{ route('category') }}" class="btn btn-danger"><i class="fa fa-arrow-left">
                                Back</i></a>
                    </div>
                </div>
                <div class="alert alert-info"><i class="fa fa-info-circle"></i>Recurring amounts are calculated by the frequency and cycles.</p><p>For example if you use a frequency of "week" and a cycle of "2", then the user will be billed every 2 weeks.</p><p>The duration is the number of times the user will make a payment, set this to 0 if you want payments until they are cancelled.</p></div>
                <div class="card-header d-flex justify-content-between
                        p-2"
                    style="background: #f6f6f6">
                    <h3 class="card-title pt-2" style="color: black">
                        <i class="fas fa-pencil-alt"></i>
                        Recurring Profiles
                    </h3>

                </div>
                {{-- </section>
        {{-- End Header Section --}}

                {{-- List Section Start --}}
                {{-- <section class="content"> --}}
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="recurring" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" id="recurring" placeholder="Name">
                    </div>

                    <h3>Recurring Profiles</h3>

                    <div class="mb-3">
                        <label for="Price" class="form-label">Price</label>
                        <input type="text" name="name" class="form-control" id="Price" value="0" placeholder="Price">
                    </div>

                    <div class="mb-3">
                        <label for="duration" class="form-label">Duration</label>
                        <input type="text" name="duration" class="form-control" id="Price" value="0"
                            placeholder="Duration">
                    </div>

                    <div class="mb-3">
                        <label for="cycle" class="form-label">Cycle</label>
                        <input type="text" name="cycle" class="form-control" id="cycle" value="1" placeholder="Cycle">
                    </div>

                    <div class="mb-3">
                        <label for="frequency" class="form-label">Frequency</label>
                        <select name="frequency" id="frequency" class="form-control">
                            <option value="day">Day</option>
                            <option value="week">Week</option>
                            <option value="semi_month">Semi Month</option>
                            <option value="month">Month</option>
                            <option value="year">Year</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="1">Enabled</option>
                            <option value="0" selected="selected">Disabled</option>
                        </select>
                    </div>

                    <h3>Trial Profile</h3>

                    <div class="mb-3">
                        <label for="trialprice" class="form-label">Trial price</label>
                        <input type="text" name="name" class="form-control" id="trialprice" value="0"
                            placeholder="Trial price">
                    </div>

                    <div class="mb-3">
                        <label for="trialduration" class="form-label">Trial duration</label>
                        <input type="text" name="trialduration" class="form-control" id="trialduration" value="0"
                            placeholder="Trial duration">
                    </div>

                    <div class="mb-3">
                        <label for="trialcycle" class="form-label">Trial cycle</label>
                        <input type="text" name="trialcycle" class="form-control" id="trialcycle" value="1"
                            placeholder="Trial cycle">
                    </div>

                    <div class="mb-3">
                        <label for="trialfrequency" class="form-label">Trial frequency</label>
                        <select name="trialfrequency" id="trialfrequency" class="form-control">
                            <option value="day">Day</option>
                            <option value="week">Week</option>
                            <option value="semi_month">Semi Month</option>
                            <option value="month">Month</option>
                            <option value="year">Year</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="trialstatus" class="form-label">Trial status</label>
                        <select name="trialstatus" id="trialstatus" class="form-control">
                            <option value="1">Enabled</option>
                            <option value="0" selected="selected">Disabled</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="sortorder" class="form-label">Sort Order</label>
                        <input type="text" name="sortorder" class="form-control" id="sortorder" value="0"
                            placeholder="Sort Order">
                    </div>



                </form>
        </section>
        {{-- End Form Section --}}
    </div>
</section>
{{-- End Section of Add Category --}}
@include('footer')
