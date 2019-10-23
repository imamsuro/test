        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

            <div class="row">
                <div class="col-lg-6">
                    <?php if (validation_errors()) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?= validation_errors(); ?>
                        </div>
                    <?php endif; ?>
                    <?= $this->session->flashdata('message'); ?>
                    <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#inputAgenda">Tambah Agenda Surat</a>

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Agenda</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($agenda as $a) : ?>
                                <tr>
                                    <th scope="row"><?= $i; ?></th>
                                    <td><?= $a['namaagenda']; ?></td>
                                    <td>
                                        <a href="<?= base_url('agenda/editagenda/') . $a['agendaid']; ?>" class="badge badge-success">edit</a>
                                        <a href="<?= base_url('agenda/deleteagenda/') . $a['agendaid']; ?>" class="badge badge-danger" data-toggle="modal" data-target="#deteleMenuModal">delete</a>
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
        <div class="modal fade" id="inputAgenda" tabindex="-1" role="dialog" aria-labelledby="inputAgendaLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="inputAgendaLabel">Tambah Agenda Surat</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="<?= base_url('surat/agenda'); ?>" method="post">
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="text" class="form-control" id="agenda" name="agenda" placeholder="Nama Agenda" autocomplete="off">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        </div>