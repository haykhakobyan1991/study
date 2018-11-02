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

        <div class="row">
            <div class="col-12">
                <form class="about_us">
                    <input type="hidden" name="language" value="<?=($this->uri->segment(2) != '' ? $this->uri->segment(2) : 'hy')?>">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">About us</h4>
                            <!-- Create the editor container -->
                            <div id="about_us" style="height: 300px;">
                                <?=$about?>
                            </div>
                        </div>
                    </div>
                    <textarea hidden name="about_us" id="about_us_text" cols="30" rows="10"><?=$about?></textarea>

                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Why apply with us?</h4>
                            <!-- Create the editor container -->
                            <div id="why_apply" style="height: 300px;">
                                 <?=$why_apply?>
                            </div>
                        </div>
                    </div>
                    <textarea hidden name="why_apply" id="why_apply_text" cols="30" rows="10"><?=$why_apply?></textarea>

                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Why recruit with us?</h4>
                            <!-- Create the editor container -->
                            <div id="why_recruit" style="height: 300px;">
                              <?=$why_recruit?>
                            </div>
                        </div>
                    </div>
                    <textarea hidden name="why_recruit" id="why_recruit_text" cols="30" rows="10"><?=$why_recruit?></textarea>
                </form>
            </div>

            <div class="border-top col-12">
                <div class="card-body ">
                    <button id="submit" type="button" class="btn btn-primary float-right">Submit</button>
                </div>
            </div>

        </div>

    </div>


    <footer class="footer text-center">
        All Rights Reserved by Matrix-admin. Designed and Developed by <a href="https://wrappixel.com">WrapPixel</a>.
    </footer>

</div>
