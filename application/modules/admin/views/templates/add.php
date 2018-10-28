<?

$controller = $this->router->fetch_class();

$page = $this->router->fetch_method();

//$url=base_url().'admin/'.$controller.'/'.substr($this->uri->segment(3), 4);
$url = base_url() . 'admin/' . ($this->uri->segment(2) != '' ? $this->uri->segment(2) : 'hy') . '/' . $page;

?>


<script src="<?= base_url('assets/admin/assets/libs/jquery/dist/jquery.min.js') ?>"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="<?= base_url('assets/admin/assets/libs/popper.js/dist/umd/popper.min.js') ?>"></script>
<script src="<?= base_url('assets/admin/assets/libs/bootstrap/dist/js/bootstrap.min.js') ?>"></script>
<script src="<?= base_url('assets/admin/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js') ?>"></script>
<script src="<?= base_url('assets/admin/assets/extra-libs/sparkline/sparkline.js') ?>"></script>
<!--Wave Effects -->
<script src="<?= base_url('assets/admin/dist/js/waves.js') ?>"></script>
<!--Menu sidebar -->
<script src="<?= base_url('assets/admin/dist/js/sidebarmenu.js') ?>"></script>
<!--Custom JavaScript -->
<script src="<?= base_url('assets/admin/dist/js/custom.min.js') ?>"></script>
<!--This page JavaScript -->
<!-- <script src="../../dist/js/pages/dashboards/dashboard1.js"></script> -->
<!-- Charts js Files -->
<script src="<?= base_url('assets/admin/assets/libs/flot/excanvas.js') ?>"></script>
<script src="<?= base_url('assets/admin/assets/libs/flot/jquery.flot.js') ?>"></script>
<script src="<?= base_url('assets/admin/assets/libs/flot/jquery.flot.pie.js') ?>"></script>
<script src="<?= base_url('assets/admin/assets/libs/flot/jquery.flot.time.js') ?>"></script>
<script src="<?= base_url('assets/admin/assets/libs/flot/jquery.flot.stack.js') ?>"></script>
<script src="<?= base_url('assets/admin/assets/libs/flot/jquery.flot.crosshair.js') ?>"></script>
<script src="<?= base_url('assets/admin/assets/libs/flot.tooltip/js/jquery.flot.tooltip.min.js') ?>"></script>
<script src="<?= base_url('assets/admin/dist/js/pages/chart/chart-page-init.js') ?>"></script>
<script src="<?= base_url('assets/admin/assets/libs/quill/dist/quill.min.js') ?>"></script>

<script>
    var options = {
        placeholder: 'Waiting for your precious content',
        theme: 'snow'
    };

    var editor = new Quill('#about_us', options);

    editor.on('text-change', function () {
        var justHtml = editor.root.innerHTML;
        $('#about_us_text').text(justHtml);
    });

    var why_apply = new Quill('#why_apply', options);

    why_apply.on('text-change', function () {
        var why_apply_text = why_apply.root.innerHTML;
        $('#why_apply_text').text(why_apply_text);
    });


    var why_recruit = new Quill('#why_recruit', options);

    why_recruit.on('text-change', function () {
        var why_recruit_text = why_recruit.root.innerHTML;
        $('#why_recruit_text').text(why_recruit_text);
    });


</script>

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


<script type='text/javascript'>

    var n = 0;

    var loadText = 'Loading';

    var interval = null;

    function start_load() {

        if (n != 3) {

            $('#loading').append('.');

            n++;

        } else {

            n = 0;

            $('#loading').html(loadText);

        }

    }


    function close_message() {

        setTimeout(function () {
            $('.success, .error').addClass('d_none');
        }, 3000);

    }


    function scroll_top() {

        $('html, body').animate({scrollTop: 0}, 700);

    }


    function loading(e = 'start') {

        if (e == 'start') {

            $('#submit').addClass('d_none');

            $('#loading, #head_load').removeClass('d_none');

            interval = setInterval('start_load()', 1000);

        } else {

            $('#loading').addClass('d_none');

            $('#loading').html(loadText);

            $('#submit').removeClass('d_none');

            $('#head_load').addClass('d_none');

            clearInterval(interval);

        }

    }


    function progressHandlingFunction(e) {

        if (e.lengthComputable) {

            var percentComplete = e.loaded / e.total * 100;

            $('#head_load').css('width', percentComplete + '%');

        }

    }


    function beforeSendHandler(e) {

        $('.success, .error').addClass('d_none');

        loading();

    }


    function completeHandler(e) {

        var error = '';

        $('.fe_err').removeClass('fe_err');


        if ($.isArray(e.error.elements)) {


            scroll_top();

            $.each(e.error.elements, function (index) {

                $.each(e.error.elements[index], function (index, value) {

                    if (value != '') {

                        $("input[name='" + index + "']").addClass('fe_err');

                        $("select[name='" + index + "']").parent('label').children('div').addClass('fe_err');

                        error += value + ' ';

                    }

                });


            });

        } else {

            scroll_top();

            error = e.error;

        }


        if (e.success == '1') {

            scroll_top();

            $('.error').addClass('d_none');

            $('.success').removeClass('d_none');

            $('.success').html(e.message);

            var url = "<?=$url?>";

            $(location).attr('href', url);

            loading('stop');

            close_message();

        } else {

            scroll_top();

            $('.success').addClass('d_none');

            $('.error').removeClass('d_none');

            $('.error').html(error);

            loading('stop');

        }

    }


    function errorHandler(e) {

        scroll_top();

        $('.error').removeClass('d_none');

        $('.error').html(e);

        loading('stop');

    }


    $(document).ready(function () {


        $('#submit').click(function () {


            var url = "<?=base_url() . 'admin/' . $controller . '/' . $this->router->fetch_method() . '_ax'?>";

            var formData = new FormData($('form.<?=$this->router->fetch_method()?>')[0]);
            // var formData = new $('form').serialize();

            $.ajax({

                url: url,

                type: 'POST',

                dataType: 'json',

                xhr: function () {

                    var myXhr = $.ajaxSettings.xhr();

                    if (myXhr.upload) {

                        myXhr.upload.addEventListener('progress', progressHandlingFunction, false);

                    }

                    return myXhr;

                },

                beforeSend: beforeSendHandler,

                success: completeHandler,

                error: errorHandler,

                data: formData,

                cache: false,

                contentType: false,

                processData: false

            });

        });

    });

</script>

</body>