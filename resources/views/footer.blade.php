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

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>


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
        special_row++;
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


    var filter_row=0;

    function addfilter(){
      
        html='<tr id="filter-row' + filter_row + '">';
        html +='<td class="left"><input type="text" name="filter[' + filter_row + '][filter_id]"  class="form-control" placeholder="filter Nmae"></td>';
        html +='<td class="left"><input type="test" name="sort_order[' + filter_row + '][filter_id]" class="form-control" placeholder="Sort Order"></td>';
        html +='<td class="text-right"><a onclick="$(\'#filter-row' + filter_row + '\').remove()" data-toggle="tooltip" title="Remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></a></td>';
        html +='</tr>';
        $('#filter tbody').append(html);;
        filter_row++;
    }


     var option_row=0;
        function  addoption(){
        html='<tr id="option-row' + option_row + '">';
        html +='<td class="left"><input type="text" name="option[' + option_row + '][option_id]"  class="form-control" placeholder="Option Value Name"></td>';
        html +='<td><input type="file" name="image" class="form-control"><img src="https://cdn.pixabay.com/photo/2015/04/23/22/00/tree-736885__480.jpg"weight="80px" height="80px"></td>';
        html +='<td class="left"><input type="test" name="sort_order[' + option_row + '][option_id]" class="form-control" placeholder="Sort Order"></td>';
        html +='<td class="text-right"><a onclick="$(\'#option-row' + option_row + '\').remove()" data-toggle="tooltip" title="Remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></a></td>';
        html +='</tr>';
        $('#option tbody').append(html);;
        option_row++;
        
     }
    
   
    </script>
    <script>
          $('#option_showww').on('change', function (e) { 
             
            //  alert(this.value);
            var optionval = this.value;
            var option_rows = 0;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

                $.ajax({
                    type: "post",
                    url: "{{ route('getoptionhtml') }}",
                    dataType: "json",
                    data: {type: optionval},
                    success: function(response) {
                        html = '';
                        $.each(response.option, function(key, item) {
                            html += '<div class="tab-pane" id="tab-option' + option_rows + '">';
                            html += '<div class="form-group">';
		                    html += '<label class="col-sm-2 control-label" for="input-required' + option_rows + '">Required</label>';
		                    html += '<div class="col-sm-12"><select name="product_option[' + option_rows + '][required]" id="input-required' + option_rows + '" class="form-control">';
		                    html += '<option value="1">Yes</option>';
		                    html += '<option value="0">No</option>';
		                    html += '</select></div>';
		                    html += '</div>';

                           if(item['type'] == 'text'){
                             
                            html += '<div class="form-group">';
			                html += '<label class="col-sm-2 control-label" for="input-value' + option_rows + '">Option Value</label>';
                            html += '<div class="col-sm-12"><input type="text" name="product_option[' + option_rows + '][value]" value="" placeholder="Option Value" id="input-value' + option_rows + '" class="form-control" /></div>';
			                html += '</div>';
                            html +='</div>';
                           }

                            if (item['type'] == 'textarea') {
			                    html += '	<div class="form-group">';
			                    html += '	  <label class="col-sm-2 control-label" for="input-value' + option_rows + '">Option Value</label>';
			                    html += '<div class="col-sm-12"><textarea name="product_option[' + option_rows+ '][value]" rows="5" placeholder="Option Value" id="input-value' + option_rows + '" class="form-control"></textarea></div>';
			                    html += '</div>';
                                html +='</div>';
		                    }

                            if(item['type'] == 'date')
                            {
                                html += '<div class="form-group">';
			                    html += '<label class="col-sm-2 control-label" for="input-value' + option_rows + '">Option Value</label>';
                                html +='<div class="col-sm-6"><input type="date" name="product_option[' + option_rows+ '][value]" class="form-control"></div>';
                                html +='</div>';
                                html +='</div>';
                            }

                            if(item['type'] == 'Date&Time'){
                                html += '<div class="form-group">';
			                    html += '<label class="col-sm-2 control-label" for="input-value' + option_rows + '">Option Value</label>';
                                html +='<div class="col-sm-6"><input type="date" name="product_option[' + option_rows+ '][value]" class="form-control"></div>';
                                html +='</div>';
                                html +='</div>';
                            }

                            if(item['type'] == 'time'){
                                html += '<div class="form-group">';
			                    html += '<label class="col-sm-2 control-label" for="input-value' + option_rows + '">Option Value</label>';
                                html +='<div class="col-sm-6"><input type="time" name="product_option[' + option_rows+ '][value]" class="form-control"></div>';
                                html +='</div>';
                                html +='</div>';
                            }

                            if(item['type'] == 'radio' || item['type'] == 'Size' || item['type'] == 'checkbox' || item['type'] == 'select'){
                                html += '<div class="table-responsive">';
			                    html += '<table id="option-value' + option_rows + '" class="table table-striped table-bordered table-hover">';
			                    html += '<thead>';
			                    html += '<tr>';
			                    html += '<td class="text-left">Option Value</td>';
			                    html += '<td class="text-right">Quantity</td>';
			                    html += '<td class="text-left">Subtract Stock</td>';
			                    html += '<td class="text-right">Price</td>';
			                    html += '<td class="text-right">Points</td>';
			                    html += '<td class="text-right">Weight</td>';
                                html += '<td class="text-right">Action</td>';
			                    html += '</tr>';
			                    html += '</thead>';
			                    html += '<tbody>';
			                    html += '</tbody>';
			                    html += '<tfoot>';
			                    html += '<tr>';
			                    html += '<td colspan="6"></td>';
			                    html += '<td class="text-right"><button type="button" onclick="addOptionValue(' + option_rows + ');" data-toggle="tooltip" title="Add Option Value" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>';
			                    html += '</tr>';
			                    html += '</tfoot>';
			                    html += '</table>';
			                    html += '</div>';
                            }
                        });
                        $('#appandoption').append(html);
                        
                    }
                });
          });  

          var addoption_row =0;
         function addOptionValue(){
            html = '<tr id="option-row' + addoption_row + '" >';
            html +='<td></td>';
            html +='<td><div><input type="text" name="quantity[' + addoption_row+ '][value]" class="form-control" placeholder="Quantity"></div></td>';
            html +='<td><select name="Subtract[' + addoption_row+ '][value]" class="form-control"><option value="1">Yes</option><option value="0">No</option></select></td>';
            html +='<td><select name="price[' + addoption_row+ '][value]" class="form-control"><option value="1">+</option><option value="0">-</option></select><div><input type="text" name="product_option[' + addoption_row+ '][value]" class="form-control" placeholder="Price"></div></td>';
            html +='<td><select name="points[' + addoption_row+ '][value]" class="form-control"><option value="1">+</option><option value="0">-</option></select><div><input type="text" name="product_option[' + addoption_row+ '][value]" class="form-control" placeholder="Points"></div></td>';
            html +='<td><select name="Weight[' + addoption_row+ '][value]" class="form-control"><option value="1">+</option><option value="0">-</option></select><div><input type="text" name="product_option[' + addoption_row+ '][value]" class="form-control" placeholder="Weight"></div></td>';
            html +='<td class="text-right"><a onclick="$(\'#option-row' + addoption_row + '\').remove()" data-toggle="tooltip" title="Remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></a></td>';
            html +='</tr>';
            $('#option tbody').append(html);;
            addoption_row++;
         }

    </script>
   

</body>

</body>
</html>
