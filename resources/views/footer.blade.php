<!--
    THIS IS FOOTER PAGE FOR ADMIN PANEL
    ----------------------------------------------------------------------------------------------
    footer.blade.php
    It's Included Some JS Links & Custom JS.
    it is used for admin panel's Bottom Part
    ----------------------------------------------------------------------------------------------
-->

    <!-- Footer -->
    <footer class="main-footer">
        <strong>Powered by Best <a href="">Epos.</a> All Rights Reserved.</strong>
    </footer>
    <!-- End Footer -->

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
<script src="{{ asset('public/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('public/plugins/daterangepicker/daterangepicker.js') }}"></script>

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
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>

<!-- Datatable -->
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

<!-- Summernote -->
<script src="{{ asset('public/plugins/summernote/summernote.min.js') }}"></script>


<!-- Custom Scripts -->
<script type="text/javascript">

    $('#summernote').summernote({
        minHeight: 300,
    });

    $(document).ready(function() {
        $('#SearchStore').select2();

        var storeid = $('#SearchStore :selected').val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "{{ url('setStore') }}",
            data: {'store_id':storeid},
            dataType: "json",
            success: function (response) {

            }
        });


    });

    $('#SearchStore').change(function()
    {
        var store_id = $(this).val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "{{ url('setStore') }}",
            data: {'store_id':store_id},
            dataType: "json",
            success: function (response) {
                if(response.success == 1)
                {
                    location.reload();
                }
            }
        });
    });

</script>
<!-- End Custom Scripts -->

</body>
</html>
