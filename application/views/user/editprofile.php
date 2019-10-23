        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>


            <div class="row">
                <div class="col-lg-8">

                    <?php echo form_open_multipart('user/editprofile'); ?>

                    <div class="form-group row">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="email" name="email" value="<?= $user['email']; ?>" readonly>
                            <?= form_error('name', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">Nama Lengkap</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" name="name" value="<?= $user['name']; ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nip" class="col-sm-2 col-form-label">NIP</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nip" name="nip" value="<?= $user['nip']; ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="seksi" class="col-sm-2 col-form-label">Seksi</label>
                        <div class="col-sm-10">
                            <select name="seksiid" id="seksiid" class="form-control">
                                <option value="">Pilih Seksi</option>
                                <?php foreach ($seksi as $s) : ?>
                                    <?php if ($s['namaseksi'] == $user['seksi']) : ?>
                                        <option value="<?= $s['namaseksi']; ?>" selected><?= $s['namaseksi']; ?></option>

                                    <?php else : ?>
                                        <option value="<?= $s['namaseksi']; ?>"><?= $s['namaseksi']; ?></option>
                                    <?php endif; ?>


                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>



                    <div class="form-group row">
                        <div class="col-sm-2">Gambar Profil</div>
                        <div class="col sm-10">
                            <div class="row">
                                <div class="col-sm-3">
                                    <img src="<?= base_url('assets/img/profile/') . $user['image']; ?>" class="img-thumbnail">
                                </div>
                                <div class="col-sm-9">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="image" name="image">
                                        <label class="custom-file-label" for="image">Pilih file gambar</label>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row justify-content-end">
                        <div class="class col-sm-10">
                            <button type="submit" class="btn btn-primary">Edit</button>
                        </div>
                    </div>
                    </form>

                </div>
            </div>


        </div>

        </div>
        <!-- End of Main Content -->