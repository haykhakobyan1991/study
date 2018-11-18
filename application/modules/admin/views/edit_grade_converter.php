<style>
    .select2-selection.select2-selection--multiple {
        height: auto;
    }
</style>
<div class="page-wrapper">

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Edit page</h4>
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
                <form class="edit_grade_converter">
                    <div class="row">

                        <div class="col-8">
                            <input type="hidden" name="grade_converter_id"
                                   value="<?= $result['id'] ?>">
                            <input type="hidden" name="language"
                                   value="<?= ($this->uri->segment(2) != '' ? $this->uri->segment(2) : 'hy') ?>">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="title" class="col-sm-3  control-label col-form-label">
                                            Title</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control"
                                                   id="title"
                                                   name="title"
                                                   value="<?=$result['title']?>"
                                                   placeholder="Title">
                                            <input type="hidden" name="alias">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Text</h4>
                                    <!-- Create the editor container -->
                                    <div id="text" style="height: 300px;"><?=$result['text']?></div>
                                </div>
                            </div>
                            <textarea hidden name="text" id="text_text" cols="30"
                                      rows="10"><?=$result['text']?></textarea>

                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="col-md-3 m-t-15">Children</label>
                                        <div class="col-md-12">
                                            <select title="Choose..." name="child[]" multiple class="select2 form-control m-t-15"
                                                    style="height: 36px;width: 100%;">
                                                <? foreach ($grade_converter as $row) { ?>
                                                    <option
                                                       <?=(in_array($row['id'], explode(',', $result['child_ids'])) ? 'selected' : '')?>
                                                       value="<?= $row['id']?>"
                                                    >
                                                        <?= $row['title'] ?>
                                                    </option>
                                                <? } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3">Make status a passive?</label>
                                        <div class="col-md-12">
                                            <div class="custom-control custom-checkbox mr-sm-2">
                                                <input name="status"
                                                       type="checkbox"
                                                    <?= $result['status'] == -1 ? 'checked' : ''?>
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
<link rel="stylesheet" type="text/css"
      href="<?= base_url('assets/admin/assets/libs/select2/dist/css/select2.min.css') ?>">
<link rel="stylesheet" type="text/css"
      href="<?= base_url('assets/admin/assets/libs/jquery-minicolors/jquery.minicolors.css') ?>">
<script src="<?= base_url('assets/admin/assets/libs/select2/dist/js/select2.full.min.js') ?>"></script>
<script src="<?= base_url('assets/admin/assets/libs/select2/dist/js/select2.min.js') ?>"></script>
<script>

    $(".select2").select2({
        placeholder: 'Choose...'
    });

    var options = {
        placeholder: 'Waiting for your precious content',
        theme: 'snow'
    };

    var editor = new Quill('#text', options);

    editor.on('text-change', function () {
        var justHtml = editor.root.innerHTML;
        $('#text_text').text(justHtml);
    });


</script>
