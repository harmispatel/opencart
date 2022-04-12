@include('header')

<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">


{{-- Section of List Banner & Blocks Setting --}}
<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Banner & Blocks Setting</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Slider Setting </li>
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
                                    <i class="fa fa-cog fw"></i>
                                    Settings
                                </h3>
                                <div class="container" style="text-align: right">
                                    <button  class="btn btn-sm btn-primary"><i class="fa fa-save"></i></button>
                                    <a href="#" class="btn btn-sm btn-danger"><i class="fa fa-arrow-left"></i></a>
                                </div>
                            </div>
                            {{-- End Card Header --}}
                             <form id="manuForm" enctype="multipart/form-data">
                                {{ @csrf_field() }}
                                {{-- Card Body --}}
                                <div class="card-body">
                                    {{-- Tabs Link --}}
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="genral-tab" data-toggle="tab" href="#genral" role="tab" aria-controls="genral" aria-selected="true">English</a>
                                        </li>
                                     
                                    </ul>
                                    {{-- End Tabs Link --}}

                                    {{-- Tab Content --}}
                                    <div class="tab-content pt-4" id="myTabContent">

                                        {{-- Genral Tab --}}
                                        <div class="tab-pane fade show active" id="genral" role="tabpanel" aria-labelledby="genral-tab">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    {{-- Inner Tab Links --}}
                                                    <ul class="nav nav-pills nav-stacked list-group" style="display: grid!important" id="address">
                                                        {{-- <li class="nav-item">
                                                            <a href="#tab-customer" class="nav-link active" data-toggle="tab" role="tab" aria-controls="data">General</a>
                                                        </li> --}}
                                                        <li class="nav-item" id="address-add">
                                                            <a href="#" class="nav-link active" onclick="addModule();">Add  Module
                                                                <i class="fa fa-plus-circle pl-4"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                    {{-- End Inner Tab Links --}}
                                                </div>
                                                {{-- <div class="col-md-10"> --}}
                                                    {{-- Genral Customer Tab --}}
                                                    {{-- <div class="tab-content">
                                                        <div class="tab-pane active" id="tab-customer">

                                                          
                                                            <div class="form-group">
                                                                <label for="firstname"><span class="text-danger">*</span>Title:</label>
                                                                <input type="text" name="firstname" id="firstname" class="form-control" placeholder="First Name">
                                                                <div class="invalid-feedback" style="display: none" id="fnameError">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="lastname"><span class="text-danger">*</span> Last Name</label>
                                                                <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Last Name">
                                                                <div class="invalid-feedback" style="display: none" id="lnameError">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="email"><span class="text-danger">*</span> Email</label>
                                                                <input type="text" name="email" id="email" class="form-control" placeholder="E-mail">
                                                                <div class="invalid-feedback" style="display: none" id="emailError">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="phone"><span class="text-danger">*</span> Phone No.</label>
                                                                <input type="text" name="phone" id="phone" class="form-control" placeholder="Phone">
                                                                <div class="invalid-feedback" style="display: none" id="phoneError">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="fax">Fax</label>
                                                                <input type="text" name="fax" id="fax" class="form-control" placeholder="Fax">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="password"><span class="text-danger">*</span> Password</label>
                                                                <input type="password" name="password" id="password" class="form-control">
                                                                <div class="invalid-feedback" style="display: none" id="passwordError">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="password"><span class="text-danger">*</span> Confirm Password</label>
                                                                <input type="password" name="confirm" id="confirm" class="form-control">
                                                                <div class="invalid-feedback" style="display: none" id="confirmError">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="newsletter">Newsletter</label>
                                                                <select name="newsletter" id="newsletter" class="form-control">
                                                                    <option value="1">Enabled</option>
                                                                    <option value="0" selected>Disabled</option>
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="status">Status</label>
                                                                <select name="status" id="status" class="form-control">
                                                                    <option value="1">Enabled</option>
                                                                    <option value="0">Disabled</option>
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="customergroup">Customer Group</label>
                                                                <select name="customer_group_id" id="customergroup" class="form-control">
                                                                 
                                                                </select>
                                                            </div>

                                                        </div>
                                                    </div> --}}
                                                    {{-- End Genral Customer Tab --}}
                                                {{-- </div> --}}
                                            </div>
                                        </div>
                                        {{-- End Genral Tab --}}
                                    </div>
                                    {{-- End Tab Content --}}

                                </div>
                                {{-- End Card Body --}}

                            </form>
                        </div>
                        {{-- End Card --}}
                    </div>
                </div>
            </div>
        </section>
        {{-- End Form Section --}}

    </div>
</section>
{{-- End Section of List Banner & Blocks Setting --}}



@include('footer')

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>

        var Module_row = 0;

        function addModule(){
             
            html ='<div class="col-md-10">';
            html +='<div class="tab-content'+Module_row +'">';
            html +='<div class="tab-pane active" id="tab-customer">';
            html +='<div class="form-group">';
            html +='<labelfor="title"><span class="text-danger">*</span>Title:</label>';
            html +='<input type="text" name="htmlBox_module[title]['+Module_row +']" class="form-control" placeholder="Enter The Title">';    
            html +='</div>';
            html +='<div class="form-group">';
            html +='<labelfor="title">Description</label>';
            html +='<input type="text" name="htmlBox_module[Description]['+Module_row +']" class="form-control" id="summernote" placeholder="Enter The Title">';    
            html +='</div>';
            html +='<div class="form-group">';
            html +='<labelfor="title">Show Title:<span>shows the title in the header box</span></label>';
            html +='<input type="checkbox" name="htmlBox_module[borderless]['+Module_row +']" >';    
            html +='</div>';
            html +='<div class="form-group">';
            html +='<labelfor="title"><span class="text-danger">*</span>Type size</label>';
            html +='<select><option>1</option></select>';    
            html +='</div>';
            html +='<div class="form-group">';
            html +='<labelfor="title"><span class="text-danger">*</span>Default Layout:	</label>';
            html +='<select><option>1</option></select>';
            html +='</div>';
            html +='<div class="form-group">';
            html +='<labelfor="title"><span class="text-danger">*</span>Position</label>';
            html +='<select><option>1</option></select>';    
            html +='</div>';
            html +='<div class="form-group">';
            html +='<labelfor="title"><span class="text-danger">*</span>Status</label>';
            html +='<select><option>1</option></select>';    
            html +='</div>';
            html +='</div>';       
            html +='</div>';       
            html +='</div>';    
            
            $('.tab-content').append(html); 
            Module_row ++;
        }
      
         


</script>
