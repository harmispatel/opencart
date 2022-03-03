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
                        <h1>Downloads</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('download') }}">Downloads
                                    </a></li>
                            <li class="breadcrumb-item active">AddDownloads</li>
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
                                    Add Downloads
                                </h3>

                                <div class="container" style="text-align: right">
                                    <button type="submit" form="manuForm" class="btn btn-sm btn-primary"><i
                                            class="fa fa-save"></i> Save</button>
                                    <a href="{{ route('download') }}" class="btn btn-sm btn-danger"><i
                                            class="fa fa-arrow-left"></i> Back</a>
                                </div>

                            </div>
                            {{-- End Card Header --}}

                            {{-- Form Strat --}}
                            <form action="{{ route('addDownload') }}" id="manuForm" method="POST"
                                enctype="multipart/form-data">
                                {{ @csrf_field() }}
                                {{-- Card Body --}}
                                <div class="card-body">
                                    <div class="tab-content pt-4" id="myTabContent">
                                        {{-- Genral Tab --}}
                                        <div class="tab-pane fade show active" id="genral" role="tabpanel"
                                            aria-labelledby="genral-tab">
                                            <div class="mb-3">
                                                <label for="download" class="form-label">Download Name</label>
                                                <div class="input-group">
                                                    <span class="input-group-text" id="basic-addon1"><img
                                                            src="{{ asset('public/admin/image/en-gb.png') }}"></span>
                                                    <input type="text" name="download" placeholder="Download Name"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label for="image" class="form-label">Filename</label>
                                                <div class="col-sm-13">
                                                    <div class="input-group">
                                                      <input type="text" name="filename" value="" placeholder="Filename" id="input-filename" class="form-control" />
                                                      <span class="input-group-btn">
                                                      <button type="button" id="button-upload" data-loading-text="Loading..." class="btn btn-primary"><i class="fa fa-upload"></i> Upload</button>
                                                      </span> </div>
                                                                </div>
                                                </div>
                            
                                            </div>
                        
                                            <div class="mb-3">
                                                <label for="mask" class="form-label">Mask</label>
                                                <input type="text" name="mask" class="form-control" id="mask" placeholder="Mask">
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

<script>
 $('#button-upload').on('click', function() {
    $('#form-upload').remove();
	$('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');
	$('#form-upload input[name=\'file\']').trigger('click');

    if (typeof timer != 'undefined') {
    	clearInterval(timer);
	}
    
       timer =setInterval(function(){
        if($('#form-upload input[name=\'file\']').val() != '') {
			clearInterval(timer);
        }
       });
 });
</script>
