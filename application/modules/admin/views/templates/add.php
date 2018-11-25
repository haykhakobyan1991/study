<?

$controller = $this->router->fetch_class();

$page = $this->router->fetch_method();

//$url=base_url().'admin/'.$controller.'/'.substr($this->uri->segment(3), 4);
$url = base_url() . 'admin/' . ($this->uri->segment(2) != '' ? $this->uri->segment(2) : 'hy') . '/' . $page;

if ($page == 'add_partner_university' || $page == 'edit_partner_university') {
    $url = base_url() . 'admin/' . ($this->uri->segment(2) != '' ? $this->uri->segment(2) : 'hy') . '/' . 'partner_university';
}

if($page == 'add_grade_converter' || $page == 'edit_grade_converter') {
    $url = base_url() . 'admin/' . ($this->uri->segment(2) != '' ? $this->uri->segment(2) : 'hy') . '/' . 'grade_converter';
}

if($page == 'add_courses' || $page == 'edit_courses') {
    $url = base_url() . 'admin/' . ($this->uri->segment(2) != '' ? $this->uri->segment(2) : 'hy') . '/' . 'courses';
}

?>


<!-- Bootstrap tether Core JavaScript -->

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


    function alias() {

        var alias = $('input[name="alias"]');

        var title = $('input[name="title"]').val();

        var name = $('input[name="name"]').val();


        if (title !== undefined) {
            $(alias).val(convert(title));
        } else if (name !== undefined) {
            $(alias).val(convert(name));
        }

    }

    function convert(unsafe) {

        var unsafe = unsafe.toLowerCase();

        return unsafe

        // Rus

            .replace(/а/g, "a")

            .replace(/б/g, "b")

            .replace(/в/g, "v")

            .replace(/г/g, "g")

            .replace(/д/g, "d")

            .replace(/е/g, "e")

            .replace(/ё/g, "yo")

            .replace(/ж/g, "zh")

            .replace(/з/g, "z")

            .replace(/и/g, "i")

            .replace(/й/g, "i")

            .replace(/к/g, "k")

            .replace(/л/g, "l")

            .replace(/м/g, "m")

            .replace(/н/g, "n")

            .replace(/о/g, "o")

            .replace(/п/g, "p")

            .replace(/р/g, "r")

            .replace(/с/g, "s")

            .replace(/т/g, "t")

            .replace(/у/g, "u")

            .replace(/ф/g, "f")

            .replace(/х/g, "kh")

            .replace(/ц/g, "tc")

            .replace(/ч/g, "ch")

            .replace(/ш/g, "sh")

            .replace(/щ/g, "shch")

            .replace(/ы/g, "y")

            .replace(/э/g, "e")

            .replace(/ю/g, "yu")

            .replace(/я/g, "ya")

            // Hy

            .replace(/ա/g, "a")

            .replace(/բ/g, "b")

            .replace(/գ/g, "g")

            .replace(/դ/g, "d")

            .replace(/ե/g, "e")

            .replace(/զ/g, "z")

            .replace(/է/g, "e")

            .replace(/ը/g, "y")

            .replace(/թ/g, "t")

            .replace(/ժ/g, "zh")

            .replace(/ի/g, "i")

            .replace(/լ/g, "l")

            .replace(/խ/g, "kh")

            .replace(/ծ/g, "ts")

            .replace(/կ/g, "k")

            .replace(/հ/g, "h")

            .replace(/ձ/g, "dz")

            .replace(/ղ/g, "gh")

            .replace(/ճ/g, "ch")

            .replace(/մ/g, "m")

            .replace(/յ/g, "y")

            .replace(/ն/g, "n")

            .replace(/շ/g, "sh")

            .replace(/չ/g, "ch")

            .replace(/պ/g, "p")

            .replace(/ջ/g, "j")

            .replace(/ռ/g, "r")

            .replace(/ս/g, "s")

            .replace(/վ/g, "v")

            .replace(/տ/g, "t")

            .replace(/ր/g, "r")

            .replace(/ց/g, "c")

            .replace(/ու/g, "u")

            .replace(/ո/g, "vo")

            .replace(/փ/g, "p")

            .replace(/ք/g, "q")

            .replace(/և/g, "ev")

            .replace(/օ/g, "o")

            .replace(/ֆ/g, "f")

            //Glob

            .replace(/\s\s+/g, ' ')

            .replace(/ /g, "_")

            .replace(/[^\w.-]+/g, "_")

            .replace(/[^a-z0-9_-]+/g, '')

            .replace(/_+/g, "_")


    }

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
            $('.alert-success, .alert-danger, .alert-info').addClass('d-none');
        }, 3000);

    }


    function scroll_top() {

        $('html, body').animate({scrollTop: 0}, 700);

    }


    function loading(e = 'start') {

        if (e == 'start') {

            $('.alert-info').removeClass('d-none');
            $('.alert-info').html('<div style="\n' +
                '    text-align: center;\n' +
                '" class="loader loader--style6" title="Loading...">\n' +
                '  <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"\n' +
                '     width="24px" height="30px" viewBox="0 0 24 30" style="enable-background:new 0 0 50 50;" xml:space="preserve">\n' +
                '    <rect x="0" y="13" width="4" height="5" fill="#333">\n' +
                '      <animate attributeName="height" attributeType="XML"\n' +
                '        values="5;21;5" \n' +
                '        begin="0s" dur="0.6s" repeatCount="indefinite" />\n' +
                '      <animate attributeName="y" attributeType="XML"\n' +
                '        values="13; 5; 13"\n' +
                '        begin="0s" dur="0.6s" repeatCount="indefinite" />\n' +
                '    </rect>\n' +
                '    <rect x="10" y="13" width="4" height="5" fill="#333">\n' +
                '      <animate attributeName="height" attributeType="XML"\n' +
                '        values="5;21;5" \n' +
                '        begin="0.15s" dur="0.6s" repeatCount="indefinite" />\n' +
                '      <animate attributeName="y" attributeType="XML"\n' +
                '        values="13; 5; 13"\n' +
                '        begin="0.15s" dur="0.6s" repeatCount="indefinite" />\n' +
                '    </rect>\n' +
                '    <rect x="20" y="13" width="4" height="5" fill="#333">\n' +
                '      <animate attributeName="height" attributeType="XML"\n' +
                '        values="5;21;5" \n' +
                '        begin="0.3s" dur="0.6s" repeatCount="indefinite" />\n' +
                '      <animate attributeName="y" attributeType="XML"\n' +
                '        values="13; 5; 13"\n' +
                '        begin="0.3s" dur="0.6s" repeatCount="indefinite" />\n' +
                '    </rect>\n' +
                '  </svg>\n' +
                '</div>');

        } else {

            $('.alert-info').addClass('d-none');

        }

    }


    function progressHandlingFunction(e) {

    }


    function beforeSendHandler(e) {

        $('.alert-success, .alert-danger, .alert-info').addClass('d-none');

        loading();

    }


    function completeHandler(e) {

        var error = '';

        $('input').removeClass('border border-danger');
        $('input').parent('div').children('label').removeClass('border border-danger');
        $('div').removeClass('border border-danger');
        $('select').parent('div').children('span').removeClass('border border-danger');


        if ($.isArray(e.error.elements)) {


            scroll_top();

            $.each(e.error.elements, function (index) {

                $.each(e.error.elements[index], function (index, value) {

                    if (value != '') {

                        $("input[name='" + index + "']").addClass('border border-danger');
                        $("input[name='" + index + "']").parent('div').children('label').addClass('border border-danger');
                        $('div#' + index).addClass('border border-danger');

                        $("select[name='" + index + "']").parent('div').children('span').addClass('border border-danger');

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

            $('.alert-danger').addClass('d-none');
            $('.alert-info').addClass('d-none');

            $('.alert-success').removeClass('d-none');

            $('.alert-success').html(e.message);

            var url = "<?=$url?>";

            $(location).attr('href', url);

            loading('stop');

            close_message();

        } else {

            scroll_top();

            $('.alert-success').addClass('d-none');

            $('.alert-danger').removeClass('d-none');

            $('.alert-danger').html(error);

            loading('stop');

        }

    }


    function errorHandler(e) {

        scroll_top();

        $('.alert-danger').removeClass('d-none');

        $('.alert-danger').html(e);

        loading('stop');

    }


    $(document).ready(function () {


        $('#submit').click(function () {

            alias();

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