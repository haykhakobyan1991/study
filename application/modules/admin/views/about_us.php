<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">About us</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Library</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <form class="about_us">
            <div class="row">

                <div class="col-8">

                    <input type="hidden" name="language"
                           value="<?= ($this->uri->segment(2) != '' ? $this->uri->segment(2) : 'hy') ?>">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">About us</h4>
                            <!-- Create the editor container -->
                            <div id="about_us" style="height: 300px;">
                                <?=$about?>
                            </div>
                        </div>
                    </div>
                    <textarea hidden name="about_us" id="about_us_text" cols="30" rows="10"><?= $about ?></textarea>

                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Why apply with us?</h4>
                            <!-- Create the editor container -->
                            <div id="why_apply" style="height: 300px;">
                                 <?=$why_apply?>
                            </div>
                        </div>
                    </div>
                    <textarea hidden name="why_apply" id="why_apply_text" cols="30"
                              rows="10"><?= $why_apply ?></textarea>

                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Why recruit with us?</h4>
                            <!-- Create the editor container -->
                            <div id="why_recruit" style="height: 300px;">
                              <?=$why_recruit?>
                            </div>
                        </div>
                    </div>
                    <textarea hidden name="why_recruit" id="why_recruit_text" cols="30"
                              rows="10"><?= $why_recruit ?></textarea>

                </div>

                <div class="col-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Meta keyword</h4>
                            <textarea placeholder="Meta keyword" rows="5" class="form-control border radius" name="meta_keyword"><?=$meta_keyword?></textarea>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Meta description</h4>
                            <textarea placeholder="Meta description" rows="5" class="form-control border radius" name="meta_description"><?=$meta_description?></textarea>
                        </div>
                    </div>
                </div>


            </div>
            <div class="row">
                <div class="border-top col-12">
                    <div class="card-body ">
                        <button id="submit" type="button" class="btn btn-primary float-right">Submit</button>
                    </div>
                </div>
            </div>
        </form>


    </div>


    <footer class="footer text-center">
        All Rights Reserved by Matrix-admin. Designed and Developed by <a href="https://wrappixel.com">WrapPixel</a>.
    </footer>

</div>


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