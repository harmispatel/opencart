<!--
    THIS IS HEADER VoucherEdit PAGE FOR ADMIN PANEL
    ----------------------------------------------------------------------------------------------
    voucheredit.blade.php
    This for Edit Voucher
    ----------------------------------------------------------------------------------------------
-->


{{-- Header --}}
@include('header')
{{-- End Header --}}


{{-- Section of Edit Gift Voucher --}}
<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Gift Vouchers</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('voucherlist') }}">Gift Vouchers</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </div>
                    {{-- End Breadcumb --}}
                </div>
            </div>
        </section>
        {{-- End Header Section --}}

        {{-- Edit Data Section --}}
        <section class="content">
            <div class="container-fluid">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Warning: Please check the form carefully for errors!</strong>
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
                            <form action="{{ route('voucherupdate') }}" id="voucherform" method="POST">
                                {{ @csrf_field() }}

                                {{-- Card Header --}}
                                <div class="card-header">
                                    <h3 class="card-title pt-2 m-0" style="color: black">
                                        <i class="fas fa-pencil-alt"></i>
                                        EDIT
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
                                        <a class="nav-item nav-link active" id="nav-General-tab" data-toggle="tab"
                                            href="#nav-General" role="tab" aria-controls="nav-General"
                                            aria-selected="true">General</a>
                                        <a class="nav-item nav-link" id="nav-history-tab" data-toggle="tab"
                                            href="#nav-history" role="tab" aria-controls="nav-history"
                                            aria-selected="false">history</a>
                                    </div>
                                    {{-- End Tabs Link --}}

                                    {{-- Tabs Content --}}
                                    <div class="tab-content" id="nav-tabContent">
                                        {{-- General Tab --}}
                                        <div class="tab-pane fade show active" id="nav-General" role="tabpanel"
                                            aria-labelledby="nav-General-tab">
                                            <div class="row mt-4">
                                                <div class="col-md-12">

                                                    <div class="form-group">
                                                        <input type="hidden" name="voucherid"
                                                            value="{{ $vouchers->voucher_id }}">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="code">
                                                            <span class="text-danger">*</span>
                                                            Code
                                                        </label>
                                                        <input type="text"
                                                            class="form-control {{ $errors->has('code') ? 'is-invalid' : '' }}"
                                                            maxlength="10" name="code" id="code"
                                                            value="{{ $vouchers->code }}" placeholder="Code">
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
                                                                <input class="form-check-input" type="radio"
                                                                    name="apply" id="delivery" value="1"
                                                                    {{ $vouchers->apply_shipping == 1 ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="delivery">Delivery</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="apply" id="collection" value="2"
                                                                    {{ $vouchers->apply_shipping == 2 ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="collection">Collection</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="apply" id="both" value="3"
                                                                    {{ $vouchers->apply_shipping == 3 ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="both">Both</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="formname">
                                                            <span class="text-danger">*</span>
                                                            From Name
                                                        </label>
                                                        <input
                                                            class="form-control {{ $errors->has('formname') ? 'is-invalid' : '' }}"
                                                            name="formname" id="formname" type="text"
                                                            value="{{ $vouchers->from_name }}"
                                                            placeholder="Form name">
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
                                                        <input
                                                            class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                                            name="email" id="email"
                                                            value="{{ $vouchers->from_email }}" type="email"
                                                            placeholder="Email">
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
                                                        <input
                                                            class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                                            name="name" id="name" value="{{ $vouchers->to_name }}"
                                                            type="text" placeholder="Telehone">
                                                        @if ($errors->has('name'))
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
                                                        <input
                                                            class="form-control {{ $errors->has('toemail') ? 'is-invalid' : '' }}"
                                                            name="toemail" id="toemail"
                                                            value="{{ $vouchers->to_email }}" type="text"
                                                            placeholder="Email">
                                                        @if ($errors->has('toemail'))
                                                            <div class="invalid-feedback">
                                                                {{ $errors->first('toemail') }}
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="theme">Themes</label>
                                                        <select class="form-control" id="theme" name="theme">
                                                            @foreach ($themes as $theme)
                                                                <option value="{{ $theme->voucher_theme_id }}"
                                                                    {{ $theme->voucher_theme_id == $vouchers->voucher_theme_id ? 'selected' : '' }}>
                                                                    {{ $theme->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="message">Message</label>
                                                        <textarea class="form-control" name="message" id="message">{{ $vouchers->message }}</textarea>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="amount">
                                                            <span class="text-danger">*</span>
                                                            Amount
                                                        </label>
                                                        <input
                                                            class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}"
                                                            name="amount" value="{{ $vouchers->amount }}" type="text"
                                                            placeholder="Ammout">
                                                        @if ($errors->has('amount'))
                                                            <div class="invalid-feedback">
                                                                {{ $errors->first('amount') }}
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="status">Status:</label>
                                                        <select class="form-control" id="status" name="status">
                                                            <option value="1"
                                                                {{ $vouchers->status == 1 ? 'selected' : '' }}>Enable
                                                            </option>
                                                            <option value="0"
                                                                {{ $vouchers->status == 0 ? 'selected' : '' }}>
                                                                Disable</option>
                                                        </select>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        {{-- End General Tab --}}

                                        {{-- Voucher History Tab --}}
                                        <div class="tab-pane fade" id="nav-history" role="tabpanel"
                                            aria-labelledby="nav-history-tab">
                                            <div class="row mt-4">
                                                <div class="col-md-12">
                                                    <table class="table table-bordered table-striped" id="myTable">
                                                        <thead class="bg-dark">
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
                                                                    <td>{{ date('d-m-Y', strtotime($value->date_added)) }}
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- End Voucher History Tab --}}
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
        {{-- End Edit Data Section --}}
    </div>
</section>
{{-- End Section of Edit Gift Voucher --}}

{{-- Footer --}}
@include('footer')
{{-- End Footer --}}


{{-- SCRIPT --}}
<script type="text/javascript">

   // Data Table
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
</script>
{{-- END SCRIPT --}}
