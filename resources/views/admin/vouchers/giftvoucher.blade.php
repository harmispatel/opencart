{{-- Header --}}
@include('header')
{{-- End Header --}}


{{-- Section of Add Gift Vouchers --}}
<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
        <section class="content-header">
            <div class="container-fluid">
                @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Warning: Please check the form carefully for errors!</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Gift Vouchers</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('voucherlist') }}">Gift Vouchers</a></li>
                            <li class="breadcrumb-item active">Insert</li>
                        </ol>
                    </div>
                    {{-- End Breadcumb --}}
                </div>
            </div>
        </section>
        {{-- End Header Section --}}

        {{-- Insert Data Section --}}
        <section class="content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-12">
                        {{-- Card --}}
                        <div class="card">
                            {{-- Form --}}
                            <form action="{{ route('voucherinsert') }}" id="voucherform" method="POST">
                            {{ @csrf_field() }}

                                {{-- Card Header --}}
                                <div class="card-header">
                                    <h3 class="card-title pt-2 m-0" style="color: black">
                                        <i class="fa fa-pencil-alt pr-2"></i>
                                        INSERT
                                    </h3>
                                    <div class="container" style="text-align: right">
                                        <button type="submit" class="btn btn-sm btn-primary ml-auto">
                                            <i class="fa fa-save"></i>
                                        </button>
                                        <a href="{{ route('voucherlist') }}" class="btn btn-sm btn-danger ml-1">
                                            <i class="fa fa-arrow-left"></i>
                                        </a>
                                    </div>
                                </div>
                                {{-- End Card Header --}}

                                {{-- Card Body --}}
                                <div class="card-body">
                                    {{-- Tabs Link --}}
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                        <a class="nav-item nav-link active" id="nav-customer-tab" data-toggle="tab" href="#nav-customer" role="tab" aria-controls="nav-customer" aria-selected="true">General</a>
                                    </div>
                                    {{-- End Tabs Link --}}

                                    {{-- Tabs Content --}}
                                    <div class="tab-content" id="nav-tabContent">
                                        {{-- General Tab --}}
                                        <div class="tab-pane fade show active mt-3" id="nav-customer" role="tabpanel" aria-labelledby="nav-customer-tab">

                                            <div class="form-group">
                                                <label for="code">
                                                    <span class="text-danger">*</span>
                                                    Code
                                                </label>
                                                <input type="text" class="form-control {{ ($errors->has('code')) ? 'is-invalid' :'' }}" maxlength="10" name="code" id="code" value="{{ old('code') }}" placeholder="Code">
                                                @if ($errors->has('code'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('code') }}
                                                    </div>
                                                @endif
                                                <small id="codehelp" class="text-muted">
                                                    The code the customer enters to activate the voucher.
                                                </small>
                                            </div>

                                            <div class="form-group">
                                                <label for="apply">
                                                    <span class="text-danger">*</span>
                                                    Appy for
                                                </label>
                                                <div class="form-control">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="apply" id="delivery" value="1" checked>
                                                        <label class="form-check-label" for="delivery">Delivery</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="apply" id="collection" value="2">
                                                        <label class="form-check-label" for="collection">Collection</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="apply" id="both" value="3">
                                                        <label class="form-check-label" for="both">Both</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="formname">
                                                    <span class="text-danger">*</span>
                                                    From Name
                                                </label>
                                                <input class="form-control {{ ($errors->has('formname')) ? 'is-invalid' : '' }}" name="formname" id="formname" type="text" value="{{ old('formname') }}" placeholder="Form name">
                                                @if ($errors->has('formname'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('formname') }}
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                <label for="email">
                                                    <span class="text-danger">*</span>
                                                    From E-Mail
                                                </label>
                                                <input class="form-control {{ ($errors->has('email')) ? 'is-invalid' : '' }}" name="email" id="email" value="{{ old('email') }}" type="email" placeholder="Email">
                                                @if ($errors->has('email'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('email') }}
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                <label for="name">
                                                    <span class="text-danger">*</span>
                                                    To Name
                                                </label>
                                                <input class="form-control {{ ($errors->has('name')) ? 'is-invalid' : '' }}" name="name" id="name" value="{{ old('name') }}" type="text" placeholder="To Name">
                                                @if($errors->has('name'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('name') }}
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                <label for="toemail">
                                                    <span class="text-danger">*</span>
                                                    To E-Mail
                                                </label>
                                                <input class="form-control {{ ($errors->has('toemail')) ? 'is-invalid' : '' }}" name="toemail" id="toemail" value="{{ old('toemail') }}" type="text" placeholder="Email">
                                                @if($errors->has('toemail'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('toemail') }}
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                <label for="theme">Themes</label>
                                                <select class="form-control" id="theme" name="theme">
                                                    @foreach ($themes as $theme)
                                                        <option value="{{ $theme->voucher_theme_id }}">{{ $theme->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="message">Message</label>
                                                <textarea class="form-control" name="message" id="message">{{ old('message') }}</textarea>
                                            </div>

                                            <div class="form-group">
                                                <label for="amount">
                                                    <span class="text-danger">*</span>
                                                    Amount
                                                </label>
                                                <input class="form-control {{  ($errors->has('amount')) ? 'is-invalid' : '' }}" name="amount" value="{{ old('amount') }}" type="text" placeholder="Ammout">
                                                @if ($errors->has('amount'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('amount') }}
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                <label for="status">Status:</label>
                                                <select class="form-control" id="status" name="status">
                                                    <option value="1">Enable</option>
                                                    <option value="0">Disable</option>
                                                  </select>
                                            </div>
                                        </div>
                                        {{-- End General Tab --}}
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
        {{-- End Insert Data Section --}}
    </div>
</section>
{{-- End Section of Add Gift Vouchers --}}

{{-- Footer --}}
@include('footer')
{{-- End Footer --}}
