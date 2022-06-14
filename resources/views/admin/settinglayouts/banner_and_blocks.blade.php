
{{-- Header --}}
@include('header')
{{-- End  Header --}}


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
                        <h3>Coming Soon...</h3>
                        {{-- End Card --}}
                    </div>
                </div>
            </div>
        </section>
        {{-- End Form Section --}}

    </div>
</section>
{{-- End Section of List Banner & Blocks Setting --}}


{{-- Footer --}}
@include('footer')
{{-- End Footer --}}


{{-- Script Section --}}
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>

        var Module_row = 1;
        // Add Modal
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

{{-- End Script Section --}}
