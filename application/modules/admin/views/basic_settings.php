<div class="page-wrapper">

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Basic Settings</h4>
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
        <form class="basic_settings">
            <div class="row">
                <div class="col-8">
                    <input type="hidden" name="language"
                           value="<?= ($this->uri->segment(2) != '' ? $this->uri->segment(2) : 'hy') ?>">
                    <div class="col-12">
                        <div class="col-12">
                            <div class="form-group row">
                                <label class="col-md-12">Change your logo</label>
                                <div class="custom-file">
                                    <input name="logo" type="file" class="custom-file-input" id="logo">
                                    <label class="custom-file-label" for="logo">Choose file...</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <img class="radius shadow p-3 bg-gray border" style="width: 200px; height: auto"
                                 src="<?= ($logo != '' ? base_url('application/uploads/basic_info/' . $logo) : base_url('assets/img/logo.png')) ?>"
                                 alt="" id="logo_image">
                        </div>
                    </div>

                    <hr class="h4">

                    <div class="col-12">
                        <div class="col-12">
                            <div class="form-group row">
                                <label class="col-md-12">Change background image</label>
                                <div class="custom-file">
                                    <input name="background_image" type="file" class="custom-file-input"
                                           id="background">
                                    <label class="custom-file-label" for="background">Choose file...</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <img class="radius shadow p-4 " style="width: 70%;height: auto"
                                 src="<?= ($background_image != '' ? base_url('application/uploads/basic_info/' . $background_image) : base_url('assets/img/background.jpg')) ?>"
                                 alt="" id="background_image">
                        </div>
                    </div>
                </div>

                <div class="col-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Meta keyword</h4>
                            <textarea placeholder="Meta keyword" rows="5" class="form-control border radius"
                                      name="meta_keyword"><?= $meta_keyword ?></textarea>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Meta description</h4>
                            <textarea placeholder="Meta description" rows="5" class="form-control border radius"
                                      name="meta_description"><?= $meta_description ?></textarea>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>

    <div class="border-top col-12">
        <div class="card-body ">
            <button id="submit" type="button" class="btn btn-primary float-right">Save</button>
        </div>
    </div>

</div>

</div>


<footer class="footer text-center">
    All Rights Reserved by Matrix-admin. Designed and Developed by <a href="https://wrappixel.com">WrapPixel</a>.
</footer>
</div>

<script>
    function readURL(input, image_id) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#' + image_id).attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $(document).ready(function () {
        $("#logo").change(function () {
            readURL(this, 'logo_image');
        });

        $("#background").change(function () {
            readURL(this, 'background_image');
        });
    })

</script>
