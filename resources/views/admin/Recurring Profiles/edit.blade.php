@include('header')

<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">

{{-- Section of Add Manufacturers --}}
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
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('recurringprofiles') }}">Recurring
                                    Profiles</a></li>
                            <li class="breadcrumb-item active">AddRecurring</li>
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
                            <div class="card-header" style="background: #f6f6f6">
                                <h3 class="card-title pt-2" style="color: black">
                                    <i class="fas fa-pencil-alt"></i>
                                    Add Recurring Profiles
                                </h3>

                                <div class="container" style="text-align: right">
                                    <button type="submit" form="manuForm" class="btn btn-sm btn-primary"><i
                                            class="fa fa-save"></i> Save</button>
                                    <a href="{{ route('recurringprofiles') }}" class="btn btn-sm btn-danger"><i
                                            class="fa fa-arrow-left"></i> Back</a>
                                </div>

                            </div>
                            {{-- End Card Header --}}

                            {{-- Form Strat --}}
                            <form action="{{ route('updaterecurring') }}" id="manuForm" method="POST"
                                enctype="multipart/form-data">
                                {{ @csrf_field() }}
                                {{-- Card Body --}}
                                <div class="card-body">
                                    <div class="tab-content pt-4" id="myTabContent">
                                        {{-- Genral Tab --}}
                                        <div class="tab-pane fade show active" id="genral" role="tabpanel"
                                            aria-labelledby="genral-tab">


                                            <div class="mb-3">
                                                <input type="hidden" name="id" id="id" value="{{ $data['recuring']->recurring_id }}">
                                                <label for="recurring" class="form-label">Name</label>
                                                <input type="text" name="name" class="form-control" id="recurring"
                                                    placeholder="Name" value="{{ $data['description']->name }}">
                                                    @error('name')
                                                    <div class="alert alert-danger mt-1 mb-1">Profile Name must be greater than 3 and less than 255 characters!</div>
                                                    @enderror
                                            </div>

                                            <h3>Recurring Profiles</h3>

                                            <div class="mb-3">
                                                <label for="Price" class="form-label">Price</label>
                                                <input type="text" name="price" class="form-control" id="Price"
                                                    value="{{ $data['recuring']->price }}" placeholder="Price">
                                            </div>

                                            <div class="mb-3">
                                                <label for="duration" class="form-label">Duration</label>
                                                <input type="text" name="duration" class="form-control" id="Price"
                                                    value="{{ $data['recuring']->duration }}" placeholder="Duration">
                                            </div>

                                            <div class="mb-3">
                                                <label for="cycle" class="form-label">Cycle</label>
                                                <input type="text" name="cycle" class="form-control" id="cycle"
                                                    value="{{ $data['recuring']->cycle }}" placeholder="Cycle">
                                            </div>

                                            <div class="mb-3">
                                                <label for="frequency" class="form-label">Frequency</label>
                                                <select name="frequency" id="frequency" class="form-control">
                                                    <option value="{{ $data['recuring']->frequency }}" selected style="display: none">{{ $data['recuring']->frequency }}</option>
                                                    <option value="day">Day</option>
                                                    <option value="week">Week</option>
                                                    <option value="semi_month">Semi Month</option>
                                                    <option value="month">Month</option>
                                                    <option value="year">Year</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label for="status" class="form-label">Status</label>
                                                <select name="trial_status" id="status" class="form-control">
                                                    <option value="{{ $data['recuring']->trial_status }}" selected style="display: none">{{ $data['recuring']->trial_status }}</option>
                                                    <option value="Enabled">Enabled</option>
                                                    <option value="Disabled">Disabled</option>
                                                </select>
                                            </div>

                                            <h3>Trial Profile</h3>

                                            <div class="mb-3">
                                                <label for="trialprice" class="form-label">Trial price</label>
                                                <input type="text" name="trial_price" class="form-control" id="trialprice"
                                                    value="{{ $data['recuring']->trial_price }}" placeholder="Trial price">
                                            </div>

                                            <div class="mb-3">
                                                <label for="trialduration" class="form-label">Trial duration</label>
                                                <input type="text" name="trial_duration" class="form-control"
                                                    id="trialduration" value="{{ $data['recuring']->trial_duration }}" placeholder="Trial duration">
                                            </div>

                                            <div class="mb-3">
                                                <label for="trialcycle" class="form-label">Trial cycle</label>
                                                <input type="text" name="trial_cycle" class="form-control"
                                                    id="trialcycle" value="{{ $data['recuring']->trial_cycle }}" placeholder="Trial cycle">
                                            </div>
                                            <div class="mb-3">
                                                <label for="trialfrequency" class="form-label">Trial
                                                    frequency</label>
                                                <select name="trial_frequency" id="trialfrequency"
                                                    class="form-control">
                                                    <option value="{{ $data['recuring']->trial_frequency }}" selected style="display: none">{{ $data['recuring']->trial_frequency }}</option>

                                                    <option value="day">Day</option>
                                                    <option value="week">Week</option>
                                                    <option value="semi_month">Semi Month</option>
                                                    <option value="month">Month</option>
                                                    <option value="year">Year</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label for="status" class="form-label">Trial status</label>
                                                <select name="status" id="status" class="form-control">
                                                    <option value="{{ $data['recuring']->status }}" selected style="display: none">{{ $data['recuring']->status }}</option>
                                                    <option value="Enabled">Enabled</option>
                                                    <option value="Disabled">Disabled</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label for="sort_order" class="form-label">Sort Order</label>
                                                <input type="text" name="sort_order" class="form-control"
                                                    id="sortorder" value="{{ $data['recuring']->sort_order }}" placeholder="Sort Order">
                                            </div>
                                        </div>
                                        {{-- End Genral Tab --}}
                                    </div>
                                </div>
                                {{-- End Card Body --}}
                            </form>
                            {{-- Form End --}}
                        </div>
                        {{-- End Card --}}
                    </div>
                </div>
            </div>
        </section>
        {{-- End Form Section --}}
    </div>
</section>
{{-- End Section of Add Manufacturers --}}



@include('footer')

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">

</script>
