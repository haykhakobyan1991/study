<!-- Bootstrap tether Core JavaScript -->
<script src="<?=base_url('assets/admin/assets/libs/popper.js/dist/umd/popper.min.js')?>"></script>
<script src="<?=base_url('assets/admin/assets/libs/bootstrap/dist/js/bootstrap.min.js')?>"></script>
<script src="<?=base_url('assets/admin/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js')?>"></script>
<script src="<?=base_url('assets/admin/assets/extra-libs/sparkline/sparkline.js')?>"></script>
<!--Wave Effects -->
<script src="<?=base_url('assets/admin/dist/js/waves.js')?>"></script>
<!--Menu sidebar -->
<script src="<?=base_url('assets/admin/dist/js/sidebarmenu.js')?>"></script>
<!--Custom JavaScript -->
<script src="<?=base_url('assets/admin/dist/js/custom.min.js')?>"></script>
<!--This page JavaScript -->
<!-- <script src="../../dist/js/pages/dashboards/dashboard1.js"></script> -->
<!-- Charts js Files -->
<script src="<?=base_url('assets/admin/assets/libs/flot/excanvas.js')?>"></script>
<script src="<?=base_url('assets/admin/assets/libs/flot/jquery.flot.js')?>"></script>
<script src="<?=base_url('assets/admin/assets/libs/flot/jquery.flot.pie.js')?>"></script>
<script src="<?=base_url('assets/admin/assets/libs/flot/jquery.flot.time.js')?>"></script>
<script src="<?=base_url('assets/admin/assets/libs/flot/jquery.flot.stack.js')?>"></script>
<script src="<?=base_url('assets/admin/assets/libs/flot/jquery.flot.crosshair.js')?>"></script>
<script src="<?=base_url('assets/admin/assets/libs/flot.tooltip/js/jquery.flot.tooltip.min.js')?>"></script>
<script src="<?=base_url('assets/admin/dist/js/pages/chart/chart-page-init.js')?>"></script>
<!--Wave Effects -->
<script src="<?=base_url('assets/admin/dist/js/waves.js')?>"></script>
<!--Menu sidebar -->
<script src="<?=base_url('assets/admin/dist/js/sidebarmenu.js')?>"></script>

<!-- this page js -->
<script src="<?=base_url('assets/admin/assets/extra-libs/multicheck/datatable-checkbox-init.js')?>"></script>
<script src="<?=base_url('assets/admin/assets/extra-libs/multicheck/jquery.multicheck.js')?>"></script>
<script src="<?=base_url('assets/admin/assets/extra-libs/DataTables/datatables.min.js')?>"></script>


<script>
    $(document).on('click', '.langs > li.lang:not(.active)', function () {
        var lang = $(this).data('lang');
        var current_url = '<?=current_url()?>';
        $.ajax({
            type: 'POST',
            url: '<?=base_url('admin/Sysadmin/change_lang')?>',
            data: {lang: lang, current_url: current_url},
            success: function (url) {
                if (url != '') {
                    $(location).attr('href', url);
                }
            }
        });
    });

</script>

<script>
    $('#zero_config').DataTable();
</script>


</body>