<div class="page-wrapper">

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Add courses</h4>
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
                <form class="add_courses">
                    <div class="row">

                        <div class="col-8">

                            <input type="hidden" name="language"
                                   value="<?= ($this->uri->segment(2) != '' ? $this->uri->segment(2) : 'hy') ?>">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="short_name" class="col-sm-3  control-label col-form-label">
                                            Title</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control"
                                                   id="title"
                                                   name="title"
                                                   placeholder="Title">
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
                                            <h4 class="card-title">What does the course entail?</h4>
                                            <div class="form-group row">
                                                <input type="text" class="form-control"
                                                       name="why1"
                                                       placeholder="What does the course entail?">
                                            </div>
                                            <div class="form-group row">
                                                <input type="text" class="form-control"
                                                       name="why2"
                                                       placeholder="What does the course entail?">
                                            </div>
                                            <div class="form-group row">
                                                <input type="text" class="form-control"
                                                       name="why3"
                                                       placeholder="What does the course entail?">
                                            </div>
                                        </div>
                                        <div class="col-sm-2 float-left"></div>
                                        <div class="col-sm-5 float-left">
                                            <h4 class="card-title">Career Opportunities</h4>
                                            <div class="form-group row">
                                                <input type="text" class="form-control"
                                                       name="career1"
                                                       placeholder="Career Opportunities">
                                            </div>
                                            <div class="form-group row">
                                                <input type="text" class="form-control"
                                                       name="career2"
                                                       placeholder="Career Opportunities">
                                            </div>
                                            <div class="form-group row">
                                                <input type="text" class="form-control"
                                                       name="career3"
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
                                                        <input placeholder="Specialist Partners"
                                                               name="specialist_partners[1]" class="form-control"
                                                               type="text"/>
                                                        <input name="partner_universities_id[1]" class="form-control"
                                                               type="hidden"/>
                                                    </th>
                                                    <th>
                                                        <button type="button"
                                                                class="btn btn-outline-secondary add_new_item"><i
                                                                    class="fa fa-plus"></i></button>
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody id="new_items">

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
<link rel="stylesheet" type="text/css"
      href="<?= base_url('assets/admin/assets/libs/select2/dist/css/select2.min.css') ?>">
<link rel="stylesheet" type="text/css"
      href="<?= base_url('assets/admin/assets/libs/jquery-minicolors/jquery.minicolors.css') ?>">
<script src="<?= base_url('assets/admin/assets/libs/select2/dist/js/select2.full.min.js') ?>"></script>
<script src="<?= base_url('assets/admin/assets/libs/select2/dist/js/select2.min.js') ?>"></script>
<script src="<?= base_url('assets/js/typeahead.js') ?>"></script>

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

    var i = 1;
    $(document).on('click', '.add_new_item', function () {
        i++;
        $('#new_items').append(
            '<tr>' +
            '<td>' +
            '<input placeholder="Specialist Partners" name="specialist_partners[' + i + ']" class="form-control" type="text"  />' +
            '<input name="partner_universities_id[' + i + ']" class="form-control" type="hidden"  />' +
            '</td>' +
            '<td>' +
            '<button type="button" class="btn mt-2 btn-outline-secondary del_item">\n' +
            '<i class="fa fa-trash"></i>\n' +
            '</button>' +
            '</td>' +
            '<tr/>'
        );

        $('#new_scripts').append(
            '<script ' +
            'data-id="' + i + '">' +
            '// search in staff\n' +
            'var url = "<?=base_url('admin/' . $this->uri->segment(2) . '/search_partner_universities/')?>";\n' +
            '\n' +
            '$.get(url, function (data) {\n' +
            '// use a data source with \'id\' and \'name\' keys\n' +
            '$(\'input[name="specialist_partners[' + i + ']"]\').typeahead({\n' +
            '\n' +
            '    source: function (query, process) {\n' +
            '                objects = [];\n' +
            '                map = {};\n' +
            '                $.each(data, function (i, object) {\n' +
            '                    map[object.name] = object;\n' +
            '                    objects.push(object.name);\n' +
            '                });\n' +
            '                process(objects);\n' +
            '\n' +
            '                $(\'input[name="partner_universities_id[' + i + ']"]\').val(\'\');\n' +
            '            },\n' +
            '            updater: function (item) {\n' +
            '                $(\'input[name="partner_universities_id[' + i + ']"]\').val(map[item].id);\n' +
            '                return item;\n' +
            '            }\n' +
            '        });\n' +
            '    }, \'json\');\n' +
            '\n' +
            '</' +
            'scri' +
            'pt>'
        );
    });

    // search in staff
    var url = '<?=base_url('admin/' . $this->uri->segment(2) . '/search_partner_universities/')?>';

    $.get(url, function (data) {
        // use a data source with 'id' and 'name' keys
        $("input[name=\"specialist_partners[1]\"]").typeahead({

            source: function (query, process) {
                objects = [];
                map = {};
                $.each(data, function (i, object) {
                    map[object.name] = object;
                    objects.push(object.name);
                });
                process(objects);

                $('input[name="partner_universities_id[1]"]').val('');
            },
            updater: function (item) {
                $('input[name="partner_universities_id[1]"]').val(map[item].id);
                return item;
            }
        });
    }, 'json');

    $(document).on('click', '.del_item', function () {
        $(this).parent('td').parent('tr').remove();
    });

</script>

<div id="new_scripts"></div>