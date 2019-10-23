        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>


            <div class="row">
                <div class="col-lg-8">
                    <?= $this->session->flashdata('message'); ?>
                    <form class="user" method="post" action="<?= base_url('user/buatuser'); ?>">
                        <div class="form-group row">
                            <label for="email" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="email" name="email">
                                <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-sm-2 col-form-label">Nama Lengkap</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="name" name="name">
                                <?= form_error('name', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-sm-2 col-form-label">NIP</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="nip" name="nip">
                                <?= form_error('nip', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="seksi" class="col-sm-2 col-form-label">Seksi</label>
                            <div class="col-sm-10">
                                <select name="namaseksi" id="namaseksi" class="form-control">
                                    <option value="">Pilih Seksi</option>
                                    <?php foreach ($seksi as $s) : ?>
                                        <option value="<?= $s['namaseksi']; ?>"><?= $s['namaseksi']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class=" form-group row">
                            <label for="email" class="col-sm-2 col-form-label">Password</label>
                            <div class="col-sm-5 mb-3 mb-sm-0">
                                <input type="password" class="form-control form-control-user" id="password1" name="password1" placeholder="Password">
                                <?= form_error('password1', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                            <div class="col-sm-5">
                                <input type="password" class="form-control form-control-user" id="password2" name="password2" placeholder="Ulang Password">
                            </div>
                        </div>

                        <div class="form-group row justify-content-end">
                            <div class="class col-sm-10">
                                <button type="submit" class="btn btn-primary">Buat</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>


        </div>

        </div>
        <!-- End of Main Content -->