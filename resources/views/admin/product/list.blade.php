@include('header')

<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">

{{-- Section of List Products --}}
<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Product List</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Product List</li>
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
                            <div class="card-header" style="background: #f6f6f6">
                                <h3 class="card-title pt-2 m-0" style="color: black">
                                    <i class="fa fa-list pr-2"></i>
                                    Product List
                                </h3>
                                <div class="container" style="text-align: right">
                                    @if(check_user_role(59) == 1)
                                        <a href="{{ route('addproduct') }}" class="btn btn-sm btn-success ml-auto"><i class="fa fa-plus"></i></a>
                                    @endif

                                    @if(check_user_role(61) == 1)
                                        <a href="#" class="btn btn-sm btn-danger ml-1 deletesellected"><i class="fa fa-trash"></i></a>
                                    @endif
                                </div>
                            </div>
                            {{-- End Card Header --}}

                            {{-- Card Body --}}
                            <div class="card-body">
                                {{-- Table Start --}}
                                <table class="table table-bordered">
                                    {{-- Alert Message div --}}
                                    <div class="alert alert-success del-alert alert-dismissible" id="alert" style="display: none" role="alert">
                                        <p id="success-message" class="mb-0"></p>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    {{-- End Alert Message div --}}

                                    {{-- Table Head --}}
                                    <thead class="text-center">
                                        <th>
                                            <input type="checkbox" name="checkall" id="delall">
                                        </th>
                                        <th>Image</th>
                                        <th>Product Name</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                        <th>Sort Order</th>
                                        <th>Action</th>
                                    </thead>
                                    {{-- End Table Head --}}

                                    {{-- Table Body --}}
                                    <tbody class="text-center cat-list">
                                        @foreach ($show_product as $value)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="checkall" class="del_all">
                                                </td>
                                                <td>
                                                    @if( ($value->image != '') || ($value->image != NULL) )
                                                        <img src="{{ asset('public/admin/product/'.$value->image)}}" width="40px">
                                                    @else
                                                        <img src="public/admin/product/no_image.jpg" >
                                                    @endif
                                                </td>
                                                <td>{{ $value->name}}</td>
                                                <td>{{ $value->price }}</td>
                                                <td>
                                                    @if ($value->status == 1)
                                                        Enabled
                                                    @else
                                                        Disabled
                                                    @endif
                                                </td>
                                                <td>{{ $value->sort_order }}</td>
                                                <td>
                                                    @if(check_user_role(60) == 1)
                                                        <a href="#" class="btn btn-sm btn-primary rounded"><i class="fa fa-edit"></i></a>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    {{-- End Table Body --}}
                                </table>
                                {{-- End Table --}}
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
{{-- End Section of Add Category --}}
@include('footer')
<script>
   $(document).ready( function () {
    $('.table').DataTable();
} );
</script>
<script>
    // Select All Checkbox
  $('#delall').on('click', function(e) {
      if($(this).is(':checked',true))
      {
          $(".del_all").prop('checked', true);
      }
      else
      {
          $(".del_all").prop('checked',false);
      }
  });
  // End Select All Checkbox


  // Delete User
  $('.deletesellected').click(function()
  {

      var checkValues = $('.del_all:checked').map(function()
      {
          return $(this).val();
      }).get();

      if(checkValues !='')
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
                          url: '{{ url("deleteproduct") }}',
                          data: {"_token": "{{ csrf_token() }}",'id':checkValues},
                          dataType : 'JSON',
                          success: function (data)
                          {
                              if(data.success == 1)
                              {
                                  swal("Your Record has been deleted!", {
                                      icon: "success",
                                  });

                                  setTimeout(function(){
                                      location.reload();
                                  }, 1500);
                              }
                          }
                  });
              }
              else
              {
                  swal("Cancelled", "", "error");
                  setTimeout(function(){
                      location.reload();
                  }, 1000);
              }
          });
      }
      else
      {
          swal("Please select atleast One Product", "", "warning");
      }
  });
</script>

