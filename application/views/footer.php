<footer>
    <div class="center" style="padding-top: 50px;" >
        <ul>
            <li>example@example.com</li>
            <li>+(789) 456 456</li>
            <li>22 Gilbert Street, London, W1K 5EJ, United Kingdom</li>
        </ul>
        <div class="soc_footer">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-google-plus"></i></a>
            <a href="#"><i class="fab fa-youtube"></i></a>
        </div>
        <p style="margin-top: 50px;">©2018 GLOBAL STUDY AM LTD</p>
        <p>Registration number: 07519266. Address: C/O</p>
        <p style="margin-bottom: 50px;">Cunningham & CO, 135 Notting Hill Gate. London W11 3LB</p>
    </div>
</footer>


<script>
    $(document).on('click', '.langs > ul > li:not(.active)', function () {
        var lang = $(this).data('lang');
        var current_url = '<?=current_url()?>';
        $.ajax({
            type: 'POST',
            url: '<?=base_url('Main/change_lang')?>',
            data: {lang: lang, current_url: current_url},
            success: function (url) {
                if (url != '') {
                    $(location).attr('href', url);
                }
            }
        });
    });
</script>

</body>
</html>