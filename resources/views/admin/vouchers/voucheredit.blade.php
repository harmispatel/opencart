@include('header')

<link rel="stylesheet" href="sweetalert2.min.css">
<link rel="stylesheet" type="text/css"
    href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.css" />


{{-- Section of List Category --}}
<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Gift Voucher</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Gift Voucher</li>
                        </ol>
                    </div>
                    {{-- End Breadcumb --}}

                </div>
                <div class="card-header d-flex p-2" style="background: #f6f6f6">
                    <h3 class="card-title pt-2 m-0" style="color: black">
                        <i class="fas fa-pencil-alt"></i>
                        Gift Voucher
                    </h3>
                    <div class="form-group ml-auto">
                        <button type="submit" form="voucherform" class="btn btn-primary">Save</button>
                        <a href="{{ route('voucherlist') }}" class="btn btn-danger">Back</a>
                    </div>
                </div>
            </div>
        </section>
        {{-- End Header Section --}}

        {{-- List Section Start --}}
        <section class="content">
            @if (count($errors) > 0)
            @if ($errors->any())
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                {{ "Warning: Please check the form carefully for errors!" }}
            </div>
            @endif
            @endif
            <form action="{{ route('voucherinsert') }}" id="voucherform" method="POST">
                {{ @csrf_field() }}
                <div class="card-body">

                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-customer-tab" data-toggle="tab"
                                href="#nav-customer" role="tab" aria-controls="nav-customer"
                                aria-selected="true">General</a>
             
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active mt-3" id="nav-customer" role="tabpanel"
                            aria-labelledby="nav-customer-tab">
                            <div class="form-group">
                                <label for="code">*Code</label>
                                <input type="text" class="form-control" name="code" id="code" value="{{ $vouchers->code }}" aria-describedby="codehelp" placeholder="Code">
                                <small id="codehelp" class="form-text text-muted">The code the customer enters to activate the voucher.</small>
                                @if ($errors->has('code'))
                                <div style="color: red">{{ $errors->first('code') }}</div>
                                @endif
                              </div>
                            
                            <div class="form-group">
                                <label for="cname" style="min-width: 100px">* Appy for</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="apply" id="delivery" value="{{ $vouchers->apply_shipping == 1 ? "checked" : ""}}" >
                                    <label class="form-check-label" for="delivery">Delivery</label>
                                  </div>
                                  <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="apply" id="collection" value="{{ $vouchers->apply_shipping == 2 ? "checked" : ""}}">
                                    <label class="form-check-label" for="collection">Collection</label>
                                  </div>
                                  <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="apply" id="both" value="{{ $vouchers->apply_shipping == 3 ? "checked" : ""}}">
                                    <label class="form-check-label" for="both">Both</label>
                                  </div>
                            </div>
                            <div class="form-group">
                                <label for="formname">* Form Name:</label>
                                <input class="form-control" name="formname" id="formname" type="text" value="{{ $vouchers->from_name }}"
                                    placeholder="Form name">
                                @if ($errors->has('formname'))
                                <div style="color: red">{{ $errors->first('formname') }}</div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="email">* From E-Mail:</label>
                                <input class="form-control" name="email" id="email" value="{{ $vouchers->from_email }}" type="email"
                                    placeholder="Email">
                                @if ($errors->has('email'))
                                <div style="color: red">{{ $errors->first('email') }}</div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="name">* To Name:</label>
                                <input class="form-control" name="name" id="name" value="{{ $vouchers->to_name }}" type="text"
                                    placeholder="Telehone">
                                @if ($errors->has('name'))
                                <div style="color: red">{{ $errors->first('name') }}</div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="toemail">* To E-Mail:</label>
                                <input class="form-control" name="toemail" id="toemail" value="{{ $vouchers->to_email }}" type="text" placeholder="Email">
                                @if ($errors->has('toemail'))
                                <div style="color: red">{{ $errors->first('toemail') }}</div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="theme">Theme:</label>
                                <select class="form-control" id="theme" name="theme"> 
                                    <option value="" selected></option>
                                    @foreach ($themes as $theme)
                                        <option value="{{ $theme->voucher_theme_id }}">{{ $theme->name }}</option>                                        
                                    @endforeach
                                  </select>
                            </div>
                            <div class="form-group">
                                <label for="message">* Message:</label>
                                    <textarea class="form-control" name="message"  id="message" rows="3">{{ $vouchers->message }}</textarea>
                                @if ($errors->has('message'))
                                <div style="color: red">{{ $errors->first('message') }}</div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="amount">Amount:</label>
                                <input class="form-control" name="amount" id="amount" value="{{ $vouchers->from_email }}" type="text"
                                    placeholder="Ammout">
                                @if ($errors->has('amount'))
                                <div style="color: red">{{ $errors->first('amount') }}</div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="status">Status:</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="1">Enable</option>
                                    <option value="2">disable</option>
                                  </select>
                            </div>
                        </div>
                    </div>
                </div>

            </form>

        </section>
        {{-- End Form Section --}}

    </div>
</section>
{{-- End Section of Add Category --}}
@include('footer')
