{{-- Header --}}
@include('header')
{{-- End Header --}}

<link rel="stylesheet" href="sweetalert2.min.css">

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
                            <li class="breadcrumb-item"><a href="{{ route('voucherlist') }}">Voucher List</a></li>
                            <li class="breadcrumb-item active">Gift Voucher</li>
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
                            {{-- End Card Header --}}

                            {{-- Card Body --}}
                            @if (count($errors) > 0)
                            @if ($errors->any())
                                <div class="alert alert-success alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                    {{ 'Warning: Please check the form carefully for errors!' }}
                                </div>
                            @endif
                        @endif
                        <form action="{{ route('voucherupdate') }}" id="voucherform" method="POST">
                            {{ @csrf_field() }}
                            <div class="card-body">
                                <nav>
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                        <a class="nav-item nav-link active" id="nav-General-tab" data-toggle="tab"
                                            href="#nav-General" role="tab" aria-controls="nav-General"
                                            aria-selected="true">General</a>
                                        <a class="nav-item nav-link" id="nav-history-tab" data-toggle="tab" href="#nav-history"
                                            role="tab" aria-controls="nav-history" aria-selected="false">history</a>
                                        {{-- <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Contact</a> --}}
                                    </div>
                                </nav>
                                <div class="tab-content" id="nav-tabContent">
                                    <div class="tab-pane fade show active" id="nav-General" role="tabpanel"
                                        aria-labelledby="nav-General-tab">
                                        <div class="form-group">
                                            <label for="code">*Code</label>
                                            <input type="text" class="form-control" maxlength="10" name="code" id="code"
                                                value="{{ $vouchers->code }}" aria-describedby="codehelp" placeholder="Code">
                                            <input type="hidden" name="voucherid" value="{{ $vouchers->voucher_id }}">
                                            <small id="codehelp" class="form-text text-muted">The code the customer enters to
                                                activate the voucher.</small>
                                            @if ($errors->has('code'))
                                                <div style="color: red">{{ $errors->first('code') }}</div>
                                            @endif
                                        </div>
            
                                        <div class="form-group">
                                            <label for="cname" style="min-width: 100px">* Appy for</label>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="apply" id="delivery" value="1"
                                                    {{ $vouchers->apply_shipping == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="delivery">Delivery</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="apply" id="collection" value="2"
                                                    {{ $vouchers->apply_shipping == 2 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="collection">Collection</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="apply" id="both" value="3"
                                                    {{ $vouchers->apply_shipping == 3 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="both">Both</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="formname">* Form Name:</label>
                                            <input class="form-control" name="formname" id="formname" type="text"
                                                value="{{ $vouchers->from_name }}" placeholder="Form name">
                                            @if ($errors->has('formname'))
                                                <div style="color: red">{{ $errors->first('formname') }}</div>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="email">* From E-Mail:</label>
                                            <input class="form-control" name="email" id="email"
                                                value="{{ $vouchers->from_email }}" type="email" placeholder="Email">
                                            @if ($errors->has('email'))
                                                <div style="color: red">{{ $errors->first('email') }}</div>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="name">* To Name:</label>
                                            <input class="form-control" name="name" id="name" value="{{ $vouchers->to_name }}"
                                                type="text" placeholder="Telehone">
                                            @if ($errors->has('name'))
                                                <div style="color: red">{{ $errors->first('name') }}</div>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="toemail">* To E-Mail:</label>
                                            <input class="form-control" name="toemail" id="toemail"
                                                value="{{ $vouchers->to_email }}" type="text" placeholder="Email">
                                            @if ($errors->has('toemail'))
                                                <div style="color: red">{{ $errors->first('toemail') }}</div>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="theme">Theme:</label>
                                            <select class="form-control" id="theme" name="theme">
                                                @foreach ($themes as $theme)
                                                    <option value="{{ $theme->voucher_theme_id }}" {{ $theme->voucher_theme_id == $vouchers->voucher_theme_id ? 'selected' : '' }}>{{ $theme->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="message">* Message:</label>
                                            <textarea class="form-control" name="message" id="message" rows="3">{{ $vouchers->message }}</textarea>
                                            @if ($errors->has('message'))
                                                <div style="color: red">{{ $errors->first('message') }}</div>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="amount">Amount:</label>
                                            <input class="form-control" name="amount" id="amount"
                                                value="{{ $vouchers->amount }}" type="text" placeholder="Ammout">
                                            @if ($errors->has('amount'))
                                                <div style="color: red">{{ $errors->first('amount') }}</div>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="status">Status:</label>
                                            <select class="form-control" id="status" name="status">
                                                <option value="1" {{ $vouchers->status == 1 ? 'selected' : '' }}>Enable
                                                </option>
                                                <option value="2" {{ $vouchers->status == 2 ? 'selected' : '' }}>disable
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="nav-history" role="tabpanel" aria-labelledby="nav-history-tab">
                                        <table class="table table-bordered" id="myTable">
                                            <thead>
                                              <tr class="text-center">
                                                <th scope="col">Order id</th>
                                                <th scope="col">Customer</th>
                                                <th scope="col">Amount</th>
                                                <th scope="col">Date Added</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($history as $value)                                                    
                                                <tr class="text-center">
                                                  <th scope="row">{{ $value->order_id }}</th>
                                                  <td>{{ $value->voucher_history_id }}</td>
                                                  <td>{{ $value->amount }}</td>
                                                  <td>{{ date("d-m-Y",strtotime($value->date_added)) }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                          </table>    
                                    </div>
                                    {{-- <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">...</div> --}}
                                </div>
                            </div>
            
                        </form>
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
{{-- End Section of Add Category --}}

{{-- Footer --}}
@include('footer')
{{-- End Footer --}}

<script>
    $(document).ready( function () {
    $('#myTable').DataTable();
} );
</script>

