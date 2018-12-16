<link rel="stylesheet" type="text/css"
      href="<?= base_url('assets/admin/typeahead/jquery.typeahead.css') ?>">
<div class="page-wrapper">

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Edit courses</h4>
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
                <form class="edit_courses">
                    <div class="row">

                        <div class="col-8">

                            <input type="hidden" name="language"
                                   value="<?= ($this->uri->segment(2) != '' ? $this->uri->segment(2) : 'hy') ?>">
                            <input type="hidden" name="courses_id"
                                   value="<?= $result['id'] ?>">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="short_name" class="col-sm-3  control-label col-form-label">
                                            Title</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control"
                                                   id="title"
                                                   name="title"
                                                   value="<?= $result['title'] ?>"
                                                   placeholder="Title">
                                            <input type="hidden" name="alias" value="<?= $result['alias'] ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>

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
                                                 src="<?= ($result['background_image'] != '' ? base_url('application/uploads/courses/' . $result['background_image']) :
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
                                            <h4 class="card-title">What does the course entail?</h4>
                                            <div class="form-group row">
                                                <input type="text" class="form-control"
                                                       name="why1"
                                                       value="<?= $result['why1'] ?>"
                                                       placeholder="What does the course entail?">
                                            </div>
                                            <div class="form-group row">
                                                <input type="text" class="form-control"
                                                       name="why2"
                                                       value="<?= $result['why2'] ?>"
                                                       placeholder="What does the course entail?">
                                            </div>
                                            <div class="form-group row">
                                                <input type="text" class="form-control"
                                                       name="why3"
                                                       value="<?= $result['why3'] ?>"
                                                       placeholder="What does the course entail?">
                                            </div>
                                        </div>
                                        <div class="col-sm-2 float-left"></div>
                                        <div class="col-sm-5 float-left">
                                            <h4 class="card-title">Career Opportunities</h4>
                                            <div class="form-group row">
                                                <input type="text" class="form-control"
                                                       name="career1"
                                                       value="<?= $result['career1'] ?>"
                                                       placeholder="Career Opportunities">
                                            </div>
                                            <div class="form-group row">
                                                <input type="text" class="form-control"
                                                       name="career2"
                                                       value="<?= $result['career2'] ?>"
                                                       placeholder="Career Opportunities">
                                            </div>
                                            <div class="form-group row">
                                                <input type="text" class="form-control"
                                                       name="career3"
                                                       value="<?= $result['career3'] ?>"
                                                       placeholder="Career Opportunities">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="col-md-3 m-t-15">Specialist Partners</label>

                                        <div class="col-md-12">


                                            <table class="vehicle table table-striped table-hover">
                                                <thead>
                                                <tr>
                                                    <th>
                                                        <input type="hidden" name="child_id[0]" value="<?= (isset($result_partners[0]['id']) ? $result_partners[0]['id'] : '') ?>">
                                                        <input type="hidden" name="child_id[1]" value="<?= (isset($result_partners[1]['id']) ? $result_partners[1]['id'] : '') ?>">
                                                        <input type="hidden" name="child_id[2]" value="<?= (isset($result_partners[2]['id']) ? $result_partners[2]['id'] : '') ?>">
                                                        <input type="hidden" name="child_id[3]" value="<?= (isset($result_partners[3]['id']) ? $result_partners[3]['id'] : '') ?>">

                                                        <div class="typeahead__container">
                                                            <div class="typeahead__field">
                                                                <div class="typeahead__query">
                                                                    <input class="js-typeahead-countries form-control"
                                                                           name="specialist_partners[1]"
                                                                           type="search"
                                                                           value="<?= (isset($result_partners[0]['title']) ? $result_partners[0]['title'] : '') ?>"

                                                                           autocomplete="off">
                                                                    <input name="partner_universities_id[1]"
                                                                           class="form-control"
                                                                           value="<?= (isset($result_partners[0]['partner_university_id']) ? $result_partners[0]['partner_university_id'] : '') ?>"
                                                                           type="hidden"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="typeahead__container">
                                                            <div class="typeahead__field">
                                                                <div class="typeahead__query">
                                                                    <input class="js-typeahead-countries form-control"
                                                                           name="specialist_partners[2]"
                                                                           type="search"
                                                                           value="<?= (isset($result_partners[1]['title']) ? $result_partners[1]['title'] : '') ?>"

                                                                           autocomplete="off">
                                                                    <input name="partner_universities_id[2]"
                                                                           class="form-control"
                                                                           value="<?= (isset($result_partners[1]['partner_university_id']) ? $result_partners[1]['partner_university_id'] : '') ?>"
                                                                           type="hidden"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="typeahead__container">
                                                            <div class="typeahead__field">
                                                                <div class="typeahead__query">
                                                                    <input class="js-typeahead-countries form-control"
                                                                           name="specialist_partners[3]"
                                                                           type="search"
                                                                           value="<?= (isset($result_partners[2]['title']) ? $result_partners[2]['title'] : '') ?>"

                                                                           autocomplete="off">
                                                                    <input name="partner_universities_id[3]"
                                                                           class="form-control"
                                                                           value="<?= (isset($result_partners[2]['partner_university_id']) ? $result_partners[2]['partner_university_id'] : '') ?>"
                                                                           type="hidden"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="typeahead__container">
                                                            <div class="typeahead__field">
                                                                <div class="typeahead__query">
                                                                    <input class="js-typeahead-countries form-control"
                                                                           name="specialist_partners[4]"
                                                                           type="search"
                                                                           value="<?= (isset($result_partners[3]['title']) ? $result_partners[3]['title'] : '') ?>"

                                                                           autocomplete="off">
                                                                    <input name="partner_universities_id[4]"
                                                                           class="form-control"
                                                                           value="<?= (isset($result_partners[3]['partner_university_id']) ? $result_partners[3]['partner_university_id'] : '') ?>"
                                                                           type="hidden"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3">Make status a passive?</label>
                                        <div class="col-md-12">
                                            <div class="custom-control custom-checkbox mr-sm-2">
                                                <input name="status"
                                                       type="checkbox"
                                                    <?= $result['status'] == -1 ? 'checked' : '' ?>
                                                       class="custom-control-input"
                                                       id="customControlAutosizing3"
                                                       value="-1"
                                                >
                                                <label class="custom-control-label"
                                                       for="customControlAutosizing3"></label>
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
                                              name="meta_keyword"><?= $result['meta_keyword'] ?></textarea>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Meta description</h4>
                                    <textarea placeholder="Meta description" rows="6" class="form-control border radius"
                                              name="meta_description"><?= $result['meta_description'] ?></textarea>
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

<script src="<?= base_url('assets/admin/typeahead/jquery.typeahead.js') ?>"></script>

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

    });


    var url = '<?=base_url('admin/' . $this->uri->segment(2) . '/search_partner_universities/')?>';

    $.get(url, function (data) {


        typeof $.typeahead === 'function' && $.typeahead({
            input: "input[name=\"specialist_partners[1]\"]",
            minLength: 0,
            searchOnFocus: true,
            blurOnTab: false,
            hint: true,
            display: ["name"],
            source: {
                data: data
            },

            callback: {
                onClickBefore: ['window.myClass.typeahead1', ['param1', 'param2']],
                onSearch: ['window.myClass.cancel1']
            },

            debug: true
        });

        typeof $.typeahead === 'function' && $.typeahead({
            input: "input[name=\"specialist_partners[2]\"]",
            minLength: 0,
            searchOnFocus: true,
            blurOnTab: false,
            hint: true,
            display: ["name"],
            source: {
                data: data
            },

            callback: {
                onClickBefore: ['window.myClass.typeahead2', ['param1', 'param2']],
                onSearch: ['window.myClass.cancel2']
            },

            debug: true
        });


        typeof $.typeahead === 'function' && $.typeahead({
            input: "input[name=\"specialist_partners[3]\"]",
            minLength: 0,
            searchOnFocus: true,
            blurOnTab: false,
            hint: true,
            display: ["name"],
            source: {
                data: data
            },

            callback: {
                onClickBefore: ['window.myClass.typeahead3', ['param1', 'param2']],
                onSearch: ['window.myClass.cancel3']
            },

            debug: true
        });

        typeof $.typeahead === 'function' && $.typeahead({
            input: "input[name=\"specialist_partners[4]\"]",
            minLength: 0,
            searchOnFocus: true,
            blurOnTab: false,
            hint: true,
            display: ["name"],
            source: {
                data: data
            },

            callback: {
                onClickBefore: ['window.myClass.typeahead4', ['param1', 'param2']],
                onSearch: ['window.myClass.cancel4']
            },

            debug: true
        });

        window.myClass = {
            // Your params will be Prepended to the regular Typeahead onClickBefore params
            typeahead1: function (param1, param2, node, a, item, event) {
                $('input[name="partner_universities_id[1]"]').val(item.id);
            },

            typeahead2: function (param1, param2, node, a, item, event) {
                $('input[name="partner_universities_id[2]"]').val(item.id);
            },

            typeahead3: function (param1, param2, node, a, item, event) {
                $('input[name="partner_universities_id[3]"]').val(item.id);
            },

            typeahead4: function (param1, param2, node, a, item, event) {
                $('input[name="partner_universities_id[4]"]').val(item.id);
            },

            cancel1: function () {
                $('input[name="partner_universities_id[1]"]').val('')
            },

            cancel2: function () {
                $('input[name="partner_universities_id[2]"]').val('')
            },

            cancel3: function () {
                $('input[name="partner_universities_id[3]"]').val('')
            },

            cancel4: function () {
                $('input[name="partner_universities_id[4]"]').val('')
            }
        };


    }, 'json');
</script>

<div id="new_scripts"></div>