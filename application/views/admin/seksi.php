        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

            <div class="row">
                <div class="col-lg-6">
                    <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
                    <?= $this->session->flashdata('message'); ?>
                    <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newSeksiModal">Tambah Seksi</a>

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nama Seksi</th>
                                <th scope="col">Kode Seksi</th>
                                <th scope="col">Keterangan</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($seksi as $s) : ?>
                                <tr>
                                    <th scope="row"><?= $i; ?></th>
                                    <td><?= $s['namaseksi']; ?></td>
                                    <td><?= $s['kodeseksi']; ?></td>
                                    <td><?= $s['keterangan']; ?></td>
                                    <td>
                                        <a href="<?= base_url('admin/hapusseksi/') . $s['seksiid']; ?>" class="badge badge-danger" onclick="return confirm('Beneran nih?')">Hapus</a>
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
        <div class="modal fade" id="newSeksiModal" tabindex="-1" role="dialog" aria-labelledby="newSeksiModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="newSeksiModalLabel">Tambah Seksi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="<?= base_url('admin/tambahseksi'); ?>" method="post">
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="text" class="form-control" id="namaseksi" name="namaseksi" placeholder="Nama Seksi">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="kodeseksi" name="kodeseksi" placeholder="Kode Seksi">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Keterangan">
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
        </div>