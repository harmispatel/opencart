<!--
    THIS IS HEADER SendMeaasges PAGE FOR ADMIN PANEL
    ----------------------------------------------------------------------------------------------
    sendmessages.blade.php
    Its Used for Insert New SendMeaasges
    ----------------------------------------------------------------------------------------------
-->

{{-- Header --}}
@include('header')
{{-- End Header --}}


<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">


{{-- Section of List Send Messages --}}
<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Send Messages</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Send Messages </li>
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
                        {{-- Card Start --}}
                        <div class="card">
                            {{-- Card Header --}}
                            <div class="card-header" style="background: #f6f6f6">
                                <h3 class="card-title pt-2 m-0" style="color: black">
                                    <i class="fa fa-list pr-2"></i>
                                    Send Messages
                                </h3>
                                <div class="form-group ml-auto float-right">
                                    <button type="submit" form="addmessage" class="btn btn-sm btn-primary">
                                        <i class="fa fa-save"></i>
                                    </button>
                                    <a href="{{ route('messages') }}" class="btn btn-sm btn-danger">
                                        <i class="fa fa-arrow-left"></i>
                                    </a>
                                </div>
                            </div>
                            {{-- End Card Header --}}

                            {{-- Card Body --}}
                            <div class="card-body">
                                {{-- Table --}}
                                @if(Session::has('success'))
                                    <div class="alert alert-success del-alert alert-dismissible" id="alert" role="alert">
                                        {{ Session::get('success') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                               <form action="{{ route("messageinsert") }}" method="post" id="addmessage">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" class="form-control {{ ($errors->has('title')) ? 'is-invalid' : '' }}" id="title">
                                    @if ($errors->has('title'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('title') }}
                                    </div>
                                @endif
                                  </div>
                                <div class="form-group">
                                    <label for="message">Message</label>
                                    <textarea class="form-control {{ ($errors->has('message')) ? 'is-invalid' : '' }}" name="message" id="message" rows="3"></textarea>
                                    @if ($errors->has('message'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('message') }}
                                    </div>
                                @endif
                                  </div>
                               </form>
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
{{-- End Section of List Send Messages --}}


{{-- Footer --}}
@include('footer')
{{-- End Footer --}}


{{-- Script Sction --}}
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

{{-- Script Sction --}}
