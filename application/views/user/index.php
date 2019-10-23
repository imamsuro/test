        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>


            <div class="row">
                <div class="col-lg-8">
                    <?= $this->session->flashdata('message'); ?>
                </div>
            </div>
            <div class="card mb-3 col-lg-8">
                <div class="row no-gutters">
                    <div class="col-md-4">
                        <img src="<?= base_url('assets/img/profile/') . $user['image']; ?>" class="card-img" alt="...">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">Nama: <?= $user['name']; ?></h5>
                            <p class="card-text">Email: <?= $user['email']; ?></p>
                            <p class="card-text">NIP: <?= $user['nip']; ?></p>
                            <p class="card-text">Seksi: <?= $user['seksi']; ?></p>
                            <p class="card-text"><small class="text-muted">Terdaftar sejak <?= date('d F Y', $user['datecreated']); ?></small></p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->