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
        <div class="row">
            <form class="basic_settings col-12">
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
                             src="<?= base_url('assets/img/logo.png') ?>" alt="" id="logo_image">
                    </div>
                </div>

                <hr class="h4">

                <div class="col-12">
                    <div class="col-12">
                        <div class="form-group row">
                            <label class="col-md-12">Change background image</label>
                            <div class="custom-file">
                                <input name="background_image" type="file" class="custom-file-input" id="background">
                                <label class="custom-file-label" for="background">Choose file...</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <img class="radius shadow p-4 " style="width: 70%;height: auto"
                             src="<?= base_url('assets/img/background.jpg') ?>" alt="" id="background_image">
                    </div>
                </div>
            </form>
        </div>
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
