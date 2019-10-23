        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

            <div class="row">
                <div class="col-lg-6">
                    <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
                    <?= $this->session->flashdata('message'); ?>
                    <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newMenuModal">Tambah Menu Baru</a>

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Menu</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($menu as $m) : ?>
                                <tr>
                                    <th scope="row"><?= $i; ?></th>
                                    <td><?= $m['menu']; ?></td>
                                    <td>
                                        <a href="<?= base_url('menu/editmenu/') . $m['usermenuid']; ?>" class="badge badge-success">edit</a>
                                        <a href="<?= base_url('menu/deletemenu/') . $m['usermenuid']; ?>" class="badge badge-danger" data-toggle="modal" data-target="#deteleMenuModal">hapus</a>
                                    </td>
                                </tr>
                                <?php $i++; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                </div>
            </div>


        </div>
        <!-- End of Main Content -->

        <!-- Modal -->
        <div class="modal fade" id="newMenuModal" tabindex="-1" role="dialog" aria-labelledby="newMenuModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="newMenuModalLabel">Tambah Menu Baru</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="<?= base_url('menu'); ?>" method="post">
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="text" class="form-control" id="menu" name="menu" placeholder="Nama Menu">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="deteleMenuModal" tabindex="-1" role="dialog" aria-labelledby="deteleMenuModal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deteleMenuModal">Delete Menu</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="<?= base_url('menu/deletemenu/') . $m['usermenuid']; ?>" method="post">
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="text" class="form-control" id="menu" name="menu" placeholder="<?= $m['menu']; ?>">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>