<footer class="main-footer">
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.2.0-rc
    </div>
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset('public/plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('public/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<!-- Bootstrap 4 -->
<script src="{{ asset('public/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- daterangepicker -->
{{-- <script src="{{ asset('public/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script> --}}
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('public/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('public/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('public/dist/js/adminlte.js') }}"></script>
<!-- Sweet Alert -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/0.2.0/sweet-alert.js"
integrity="sha512-2N36vOIIxkP6F+ZuYOIOyiNupgE6uLgNEduYUrKtvrtbgRiqfpc1Mu0f7blAyLx67Y2uwDspjgesfQcOXQ8gdQ=="
crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/0.2.0/sweet-alert.min.js"
integrity="sha512-+q01aE1/3DSt/pNwhpoMKxjkWyRTpXPA7xceLKlhmJMADbLJL020BuGSTCExgwe+fD7bvX2HiVGS1suMf2056A=="
crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- Select -->
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script> --}}

<!-- Datatable -->
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

{{-- Summernote --}}
<script src="{{ asset('public/plugins/summernote/summernote.min.js') }}"></script>


<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $('#summernote').summernote({
        height: 250,
    });
</script>
<script>

    $(document).ready(function() {
    $('.js-example-basic-multiple').select2();
});
</script>
    <script>

var attribute_row = 0;

function addAttribute() {
    html = '<tr id="attribute-row' + attribute_row + '">';
    html += '  <td class="text-left" style="width: 20%;"><input type="text" name="product_attribute[' + attribute_row + '][name]" value="" placeholder="Attribute" class="form-control" /><input type="hidden" name="product_attribute[' + attribute_row + '][attribute_id]" value="" /></td>';
    html += '  <td class="text-left">';
    html += '<div class="input-group"><span class="input-group-addon"><img src="public/admin/image/en-gb.png" title="English" /></span><textarea name="product_attribute[' + attribute_row + '][product_attribute_description][1][text]" rows="5" placeholder="Text" class="form-control"></textarea></div>';
    html += '  </td>';
    html += '  <td class="text-right"><button type="button" onclick="$(\'#attribute-row' + attribute_row + '\').remove();" data-toggle="tooltip" title="Remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
    html += '</tr>';
    $('#attribute tbody').append(html);
    // attributeautocomplete(attribute_row);
    attribute_row++;
}


   var recurring_row =0;
   function recurring(){
      html ='<tr id="recurring-row' + recurring_row + '">';
      html += '  <td class="left">';
	  html += '    <select name="product_recurring[' + recurring_row + '][recurring_id]" class="form-control">';
      html += '    </select>';
	  html += '  </td>';
      html += '  <td class="left">';
	  html += '    <select name="product_recurring[' + recurring_row + '][customer_group_id]" class="form-control">';
      html += '      <option value="1">Default</option>';
      html += '    <select>';
	  html += ' <td class="text-right"><a onclick="$(\'#recurring-row' + recurring_row + '\').remove()" data-toggle="tooltip" title="Remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></a></td>';
	  html += '</tr>';
    $('#attribute tbody').append(html);
    recurring_row++;
   }
   var  discount_row =0;

    function discount(){
        html='<tr id="discount-row' + discount_row + '">';
        html += '<td class="left">';
	    html += '<select name="product_discount[' + discount_row + '][discount_id]" class="form-control">';
        html +='<option vlaue="1">Default</option>';
        html += '</select>';
        html += '</td>';
        html +='<td class="right"><input type="test" name="product_quantity[' + discount_row + '][discount_id]" class="form-control" placeholder="Quantity"></td>';
        html +='<td class="right"><input type="test" name="product_Priority[' + discount_row + '][discount_id]" class="form-control" placeholder="Priority"></td>';
        html +='<td class="right"><input type="test" name="product_Price[' + discount_row + '][discount_id]" class="form-control" placeholder="Price"></td>';
        html +='<td class="right"><input type="date" name="product_date[' + discount_row + '][discount_id]" class="form-control"></td>';
        html +='<td class="right"><input type="date" name="product_date[' + discount_row + '][discount_id]" class="form-control"></td>';
        html += '<td class="text-right"><a onclick="$(\'#discount-row' + discount_row + '\').remove()" data-toggle="tooltip" title="Remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></a></td>';
        html +='</tr>';
        $('#discount tbody').append(html);;
        discount_row++;
    }

    var special_row=0;
    function special(){
        html='<tr id="special-row' + special_row + '">';
        html += '<td class="left">';
	    html += '<select name="product_special[' + special_row + '][special_id]" class="form-control">';
        html +='<option vlaue="1">Default</option>';
        html += '</select>';
        html += '</td>';
        html +='<td class="right"><input type="test" name="product_Priority[' + special_row + '][special_id]" class="form-control" placeholder="Priority"></td>';
        html +='<td class="right"><input type="test" name="product_Price[' + special_row + '][special_id]" class="form-control" placeholder="Price"></td>';
        html +='<td class="right"><input type="date" name="product_date[' + special_row + '][special_id]" class="form-control"></td>';
        html +='<td class="right"><input type="date" name="product_date[' + special_row + '][special_id]" class="form-control"></td>';
        html +='<td class="text-right"><a onclick="$(\'#special-row' + special_row + '\').remove()" data-toggle="tooltip" title="Remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></a></td>';
        html +='</tr>';
        $('#special tbody').append(html);;
        discount_row++;
    }
    // <img src="https://cdn.pixabay.com/photo/2015/04/23/22/00/tree-736885__480.jpg">
    var image_row=0;
    function product_image(){

        html ='<tr id="image-row' + image_row + '">';
        html +='<td><input type="file" name="image" class="form-control"><img src="https://cdn.pixabay.com/photo/2015/04/23/22/00/tree-736885__480.jpg" weight="100px" height="100px"></td>';
        html +='<td class="right"><input type="text" name="product_sort[' + image_row + '][image_id]" class="form-control" placeholder="Sort Order"></td>';
        html +='<td class="text-right"><a onclick="$(\'#image-row' + image_row + '\').remove()" data-toggle="tooltip" title="Remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></a></td>';
        html +='</tr>';
        $('#image tbody').append(html);;
        image_row++;
    }



    </script>
    <script>

        $(document).ready(function(){

                $.ajax({
                type: "get",
                url: "/option",
                dataType: "json",
                success: function(response) {
                    $.each(response.option, function(key, item) {

                      console.log(item);


                    });
                }
            });

        });
    </script>
    <script>
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
    </script>

</body>

</body>
</html>
