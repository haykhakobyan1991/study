<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->
<script src="<?=base_url('assets/admin/assets/libs/jquery/dist/jquery.min.js')?>"></script>
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

    $(document).ready(function() {
        var brand = document.getElementById('validatedCustomFile');
        brand.className = 'attachment_upload';
        brand.onchange = function() {
            document.getElementById('fakeUploadLogo').value = this.value.substring(12);
        };

        // Source: http://stackoverflow.com/a/4459419/6396981
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('.img-preview').attr('src', e.target.result);
                    console.log(e)
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#validatedCustomFile").change(function() {
            readURL(this);
        });
    });
</script>

</body>