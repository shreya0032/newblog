<!-- jQuery -->
<script src="{{ asset('assets/backend/plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('assets/backend/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)

</script>
<!-- Bootstrap 4 -->
<script
    src="{{ asset('assets/backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}">
</script>
<!-- ChartJS -->
<script src="{{ asset('assets/backend/plugins/chart.js/Chart.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('assets/backend/plugins/sparklines/sparkline.js') }}"></script>
<!-- JQVMap -->
<script src="{{ asset('assets/backend/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/jqvmap/maps/jquery.vmap.usa.js') }}">
</script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('assets/backend/plugins/jquery-knob/jquery.knob.min.js') }}">
</script>
<!-- daterangepicker -->
<script src="{{ asset('assets/backend/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/daterangepicker/daterangepicker.js') }}">
</script>
<!-- Tempusdominus Bootstrap 4 -->
<script
    src="{{ asset('assets/backend/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}">
</script>
<!-- Summernote -->
<script src="{{ asset('assets/backend/plugins/summernote/summernote-bs4.min.js') }}">
</script>
<!-- overlayScrollbars -->
<script
    src="{{ asset('assets/backend/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}">
</script>
<!-- AdminLTE App -->
<script src="{{ asset('assets/backend/dist/js/adminlte.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('assets/backend/dist/js/demo.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('assets/backend/dist/js/pages/dashboard.js') }}"></script>
<!-- custom js -->
<script src="{{ asset('assets/backend/dist/js/custom_js.js') }}"></script>
<script src="{{ asset('assets/backend/dist/js/jquery-3.5.1.min.js') }}"></script>
<!-- DataTables  & Plugins -->
<script src="{{ asset('assets/backend/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/datatables-buttons/js/buttons.html5.min.j') }}s"></script>
<script src="{{ asset('assets/backend/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/dropify/js/dropify.min.js') }}"></script>
<script src="{{ asset('assets/backend/dist/js/datatable.js') }}"></script>
<script src="{{ asset('assets/backend/js/csv.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

{{-- sweet alert --}}

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- ( LC Switch CDN ) -->
<script src="{{ asset('assets/backend/plugins/LC-switch-master/lc_switch.js') }}" type="text/javascript"></script>

<script>    
    (function($) {
        'use strict';
        $('.dropify').dropify();
    })(jQuery);

</script>


<script>
    $(document).ready(function () {

        $('#updatePermissionBtnTop').click(function(){
            $(this).closest('.row').find('form').trigger('submit');
        });

        $('.PermiAll').click(function () {
            $('#CheckAll').trigger('click');
        });

        setTimeout(() => {
            $('.checkbox').lc_switch();
        }, 3000);

        $('#CheckAll').change(function () {
            if ($(this).prop("checked") == true) {
                $('.checkbox').lcs_on();
                $('.checkbox').val(1);
            } else if ($(this).prop("checked") == false) {
                $('.checkbox').val(0);
                $('.checkbox').lcs_off();
            }
        });

        $('#updatePermissionForm').delegate('.lcs_switch', 'click', function () {
            var val = $(this).closest('.lcs_wrap').find('.checkbox').val();
            if (val == 1) {
                $(this).closest('.lcs_wrap').find('.checkbox').val(0);
            } else {
                $(this).closest('.lcs_wrap').find('.checkbox').val(1);
            }
        });

    });

</script>


{{-- <script>
    
    function testDeleteFunction(dataUrl){
        console.log(dataUrl);
        // window.location.replace(url);
    }
</script> --}}
