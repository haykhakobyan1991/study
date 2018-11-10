<div class="page-wrapper">

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Add partner university</h4>
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
        <div class="alert d-none alert-success" role="alert"></div>
        <div class="alert d-none alert-info" role="alert"></div>
        <div class="alert d-none alert-danger" role="alert"></div>

        <div class="row">
            <div class="col-12">
                <form class="add_partner_university">
                    <div class="row">

                        <div class="col-8">

                            <input type="hidden" name="language"
                                   value="<?= ($this->uri->segment(2) != '' ? $this->uri->segment(2) : 'hy') ?>">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="short_name" class="col-sm-3  control-label col-form-label">
                                            Short name</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control"
                                                   id="short_name"
                                                   name="short_name"
                                                   placeholder="Short name">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="short_name" class="col-sm-3  control-label col-form-label">
                                            Name</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control"
                                                   id="name"
                                                   name="name"
                                                   placeholder="Name">
                                            <input type="hidden" name="alias">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Overview</h4>
                                    <!-- Create the editor container -->
                                    <div id="overview" style="height: 300px;">
                                      <?//=$about?>
                                    </div>
                                </div>
                            </div>
                            <textarea hidden name="overview" id="overview_text" cols="30"
                                      rows="10"></textarea>

                            <div class="card">
                                <div class="card-body">
                                    <div class="col-12">
                                        <div class="col-12">
                                            <div class="form-group row">
                                                <label class="col-md-12">Background image</label>
                                                <div class="custom-file">
                                                    <input name="background_image" type="file" class="custom-file-input"
                                                           id="background">
                                                    <label class="custom-file-label" for="background">Choose
                                                        file...</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <img class="radius shadow p-4 " style="width: 70%;height: auto"
                                                 src="<?= ( /* $background_image != '' ? base_url('application/uploads/basic_info/' . $background_image) : */
                                                 base_url('assets/img/background.jpg')) ?>"
                                                 alt="" id="background_image">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <div class="col-sm-12 float-left">
                                        <div class="col-sm-5 float-left">
                                            <h4 class="card-title">Top subjects</h4>
                                            <div class="form-group row">
                                                <input type="text" class="form-control"
                                                       name="subject1"
                                                       placeholder="Subject 1">
                                            </div>
                                            <div class="form-group row">
                                                <input type="text" class="form-control"
                                                       name="subject2"
                                                       placeholder="Subject 2">
                                            </div>
                                            <div class="form-group row">
                                                <input type="text" class="form-control"
                                                       name="subject2"
                                                       placeholder="Subject 3">
                                            </div>
                                        </div>
                                        <div class="col-sm-2 float-left"></div>
                                        <div class="col-sm-5 float-left">
                                            <h4 class="card-title">Requirements</h4>
                                            <div class="form-group row">
                                                <input type="text" class="form-control"
                                                       name="requirement1"
                                                       placeholder="Requirement 1">
                                            </div>
                                            <div class="form-group row">
                                                <input type="text" class="form-control"
                                                       name="requirement2"
                                                       placeholder="Requirement 2">
                                            </div>
                                            <div class="form-group row">
                                                <input type="text" class="form-control"
                                                       name="requirement3"
                                                       placeholder="Requirement 3">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="col-md-3 m-t-15">Grade Converter</label>
                                        <div class="col-md-12">
                                            <select  name="grade_converter" class="select2 form-control m-t-15" style="height: 36px;width: 100%;">
                                                <option value="">Choose ...</option>
                                                <option value="1">Grade Converter 1</option>
                                                <option value="2">Grade Converter 2</option>
                                                <option value="3">Grade Converter 3</option>
                                                <option value="4">Grade Converter 4</option>
                                                <option value="5">Grade Converter 5</option>
                                                <option value="6">Grade Converter 6</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3">Make status a passive?</label>
                                        <div class="col-md-12">
                                            <div class="custom-control custom-checkbox mr-sm-2">
                                                <input name="status"
                                                       type="checkbox"
                                                       class="custom-control-input"
                                                       id="customControlAutosizing3"
                                                       value="-1"
                                                >
                                                <label class="custom-control-label" for="customControlAutosizing3"></label>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>

                        <div class="col-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Meta keyword</h4>
                                    <textarea placeholder="Meta keyword" rows="6" class="form-control border radius"
                                              name="meta_keyword"></textarea>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Meta description</h4>
                                    <textarea placeholder="Meta description" rows="6" class="form-control border radius"
                                              name="meta_description"></textarea>
                                </div>
                            </div>
                        </div>


                    </div>

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
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/admin/assets/libs/select2/dist/css/select2.min.css')?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/admin/assets/libs/jquery-minicolors/jquery.minicolors.css')?>">
<script src="<?= base_url('assets/admin/assets/libs/select2/dist/js/select2.full.min.js')?>"></script>
<script src="<?= base_url('assets/admin/assets/libs/select2/dist/js/select2.min.js')?>"></script>
<script>

    $(".select2").select2();

    var options = {
        placeholder: 'Waiting for your precious content',
        theme: 'snow'
    };

    var editor = new Quill('#overview', options);

    editor.on('text-change', function () {
        var justHtml = editor.root.innerHTML;
        $('#overview_text').text(justHtml);
    });


</script>

<script>
    function readURL(input, image_id) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#' + image_id).attr('src', e.target.result);
                $(input).parent('div').children('label').text(input.files[0]['name']);
                console.log(input.files);
            };



            reader.readAsDataURL(input.files[0]);
        }
    }

    $(document).ready(function () {

        $("#background").change(function () {
            readURL(this, 'background_image');
        });
    })

</script>