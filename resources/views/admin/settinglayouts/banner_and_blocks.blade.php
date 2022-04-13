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
                                                        <li class="nav-item" id="address-add">
                                                            <a href="#" class="nav-link active" onclick="addModule();">Add  Module
                                                                <i class="fa fa-plus-circle pl-4"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                    {{-- End Inner Tab Links --}}
                                                </div>
                                                <div class="col-md-10">
                                                    <div class="tab-content">

                                                    </div>
                                                </div>
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

        var Module_row = 1;

        function addModule(){
             
            
            html ='<div class="tab-pane" id="tab-customer-'+Module_row+'">';

            html  +='<h3>Module - '+Module_row+'</h3>';
            html  +='<div class="form-group">';
            html +='<labelfor="title"><span class="text-danger">*</span><b>Title</b></label>';
            html +='<input type="text" name="htmlBox_module[title]['+Module_row +']" class="form-control" placeholder="Enter The Title">';    
            html +='</div>';

            html +='<div class="form-group">';
            html +='<labelfor="title"><b>Description</b></label>';
            html +='<input type="text" name="htmlBox_module[Description]['+Module_row +']" class="form-control" id="summernote" placeholder="Enter The Title">';    
            html +='</div>';

            html +='<div class="form-group">';
            html +='<labelfor="title"><b>Show Title</b><br><span>shows the title in the header box</span></label>';
            html +='<br>';
            html +='<div class="form-control"><input type="checkbox" name="htmlBox_module[borderless]['+Module_row +']" ></div>';    
            html +='</div>';

            html +='<div class="form-group">';
            html +='<labelfor="title"><b>Type size</b></label>';
            html +='<select name="htmlBox_module[typesize]['+Module_row +']" class="form-control"><option></option></select>';    
            html +='</div>';

            html +='<div class="form-group">';
            html +='<labelfor="title"><b>Default Layout</b></label>';
            html +='<select name="htmlBox_module[layout_id]['+Module_row +']" class="form-control"><option></option></select>';
            html +='</div>';

            html +='<div class="form-group">';
            html +='<labelfor="title"><b>Position</b></label>';
            html +='<select name="htmlBox_module[position]['+Module_row +']" class="form-control"><option></option></select>';    
            html +='</div>';

            html +='<div class="form-group">';
            html +='<labelfor="title"><b>Status</b></label>';
            html +='<select name="htmlBox_module[status]['+Module_row +']" class="form-control"><option></option></select>';    
            html +='</div>';

            html +='<div class="form-group">';
            html +='<labelfor="title"><b>Sort Order</b></label>';
            html +='<input type="text" name="htmlBox_module[sort_order]['+Module_row +']" class="form-control">';    
            html +='</div>';

            html +='</div>';       
               
            
            $('#genral .tab-content').append(html); 
        
            $('#address-add').before('<li class="nav-item"><a href="#tab-customer-' + Module_row + '" data-toggle="tab" class="nav-link"> module ' + Module_row + ' <i class="fa fa-minus-circle pl-4" onclick="$(\'#address a:first\').tab(\'show\'); $(\'a[href=\\\'#tab-customer-' + Module_row + '\\\']\').parent().remove(); $(\'#tab-customer-' + Module_row + '\').remove();"></i></a></li>');

            Module_row ++;
        }
      
         


</script>
