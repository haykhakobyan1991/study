<div class="page-wrapper">

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Page</h4>
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

        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4">List of page
                    <a href="<?= base_url('admin/' . ($this->uri->segment(2) != '' ? $this->uri->segment(2) : 'hy') . '/add_grade_converter') ?>">
                        <button type="button" class="float-right btn btn-secondary">Add</button>
                    </a>
                </h5>

                <div class="table-responsive">
                    <table id="zero_config" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>id</th>
                            <th>Title</th>
                            <th>Children</th>
                            <th>Status</th>
                            <th>Edit</th>
                        </tr>
                        </thead>
                        <tbody>
                        <? foreach ($result as $value) : ?>
                            <tr>
                                <td><?= $value['id'] ?></td>
                                <td><?= $value['title'] ?></td>
                                <td><?= $value['children'] ?></td>
                                <td><?= ($value['status'] == 1 ? 'Active' : 'Passive') ?></td>
                                <td><a href="<?= base_url('admin/' . ($this->uri->segment(2) != '' ? $this->uri->segment(2) : 'hy') . '/edit_grade_converter/'.$value['id']) ?>"><i class="fas fa-edit"></i></a></td>
                            </tr>
                        <? endforeach; ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>id</th>
                            <th>Title</th>
                            <th>Children</th>
                            <th>Status</th>
                            <th>Edit</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>

            </div>
        </div>

    </div>


    <footer class="footer text-center">
        All Rights Reserved by Matrix-admin. Designed and Developed by <a href="https://wrappixel.com">WrapPixel</a>.
    </footer>
</div>
