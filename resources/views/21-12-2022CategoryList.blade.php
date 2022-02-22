@include('header')

<link rel="stylesheet" href="sweetalert2.min.css">

{{-- Section of List Category --}}
<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Category List</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Category List </li>
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
                            <div class="card-header d-flex justify-content-between
                            p-2">
                                <h3 class="card-title">
                                    {{-- Total Categories - ({{ count($categoriescount) }}) --}}
                                </h3>
                                <a href="#" onclick="addCat()" class="btn btn-sm btn-success ml-auto"><i class="fa fa-plus"></i></a>
                            </div>
                            {{-- End Card Header --}}

                                {{-- Card Body --}}
                                <div class="card-body">
                                    <table class="table table-striped">
                                        <div class="alert alert-success del-alert alert-dismissible" id="alert" style="display: none" role="alert">
                                            <p id="success-message" class="mb-0"></p>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                        </div>
                                        <thead class="text-center">
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Slug</th>
                                            <th>Image</th>
                                            <th>Published on</th>
                                            <th>Action</th>
                                        </thead>
                                        <tbody class="text-center cat-list">

                                        </tbody>
                                    </table>
                                </div>
                                {{-- End Card Body --}}
                                {{-- Start Card Footer --}}
                                {{-- <div class="card-footer">
                                    {{ $categories->links() }}
                                </div> --}}
                                {{-- End Card Footer --}}
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



{{-- Add Data Popup Modal --}}
  <!-- Modal -->
  <div class="modal fade" id="categoryModal" tabindex="-1" role="dialog" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">ADD CATEGORY</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" id="category" enctype="multipart/form-data">
            {{ @csrf_field() }}
            <div class="modal-body">
                <div class="form-group">
                    <label for="name">Category</label>
                    <input type="text" id="cat_name" name="name" value="" class="form-control">
                    <div class="name_error invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label for="slug">Slug</label>
                    <input type="text" id="cat_slug" name="slug" value="" class="form-control">
                    <div class="slug_error invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label for="name">Image</label>
                    <input type="file" id="cat_image" name="image" value="" class="form-control">
                    <div class="image_error invalid-feedback"></div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" onclick="saveCategory()">INSERT</button>
            </div>
        </form>
      </div>
    </div>
  </div>
{{-- End Add Data Popup Modal --}}



@include('footer')

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">


// Open Add Category Modal
function addCat()
{
    $('#categoryModal').modal();
}
// End Open Add Category Modal


// Get Categories
getCategories();

function getCategories()
{
    $.ajax({
            type: "GET",
            url: "{{ url('getcategory') }}",
            dataType: "JSON",
            success: function (data) {
                if(data.success == 1)
                {
                    $('.cat-list').html(data.category);
                }
            }
    });
}

// End Get Categories




// Save Category
function saveCategory()
{
    var form_data = new FormData(document.getElementById("category"));

    $.ajax({
            type: "POST",
            url: "{{ url('categoryAdd') }}",
            data: form_data,
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {

                if(data.success == 1)
                {
                    $('#category').trigger('reset');

                    $('#categoryModal').modal('hide');

                    $('.cat-list').html('');
                    getCategories();

                    $('#alert').show();
                    $('#success-message').text('Data has been Inserted..');

                    // setTimeout(function(){
                    //     $('#alert').hide();
                    // }, 3000);
                }
                if(data.success==2)
                {
                    $('.slug_error').text('Slug is Already Exists');
                    $('#cat_slug').attr('class','form-control is-invalid');
                }
                else
                {
                    $('.slug_error').hide();
                    $('#cat_slug').attr('class','form-control');
                }
            },
            error: function(data){

                // Name
                if(data.responseJSON.errors.name != null)
                {
                    $('.name_error').text(data.responseJSON.errors.name);
                    $('#cat_name').attr('class','form-control is-invalid');
                }
                else
                {
                    $('.name_error').hide();
                    $('#cat_name').attr('class','form-control');
                }

                // Slug
                if(data.responseJSON.errors.slug != null)
                {
                    $('.slug_error').text(data.responseJSON.errors.slug);
                    $('#cat_slug').attr('class','form-control is-invalid');
                }
                else
                {
                    $('.slug_error').hide();
                    $('#cat_slug').attr('class','form-control');
                }


                // Image
                if(data.responseJSON.errors.image != null)
                {
                    $('.image_error').text(data.responseJSON.errors.image);
                    $('#cat_image').attr('class','form-control is-invalid');
                }
                else
                {
                    $('.image_error').hide();
                    $('#cat_image').attr('class','form-control');
                }


            }
    });

}
// End Save Category





// Delete Category
function deleteCat(id)
{

    swal({
            title: "Are you sure You want to Delete It ?",
            text: "Once deleted, you will not be able to recover this Record",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete)
            {

                $.ajax({
                        type: "POST",
                        url: '{{ url("/deleteCategory") }}',
                        data: {"_token": "{{ csrf_token() }}",'id':id},
                        dataType : 'JSON',
                        success: function (data)
                        {
                            if(data.success == 1)
                            {
                                swal("Your Record has been deleted!", {
                                    icon: "success",
                                });

                                $('.cat-list').html('');
                                getCategories();
                            }
                        }
                });

            }
            else
            {
                swal("Cancelled");
            }
        });


}
// End Delete Category




</script>



