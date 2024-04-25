<?= $this->extend('template/layouts') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <h5>Edit Profile</h5>
    <a href="/superadmin/dashboard" class="btn btn-outline-danger mb-3"> <i class="fas fa-arrow-alt-circle-left"></i> Back </a>
    <?php if(session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif ?>

    <?php if(session()->getFlashdata('error_input')) : ?>
    <div class="alert alert-danger"><?= session()->getFlashdata('error_input') ?></div>
    <?php endif ?>

    <?php if(session()->getFlashdata('success')) : ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif ?>

    <div class="card">
        <div class="card-shadow">
            <div class="card-body">
                <form action="/superadmin/update-profile/<?= $profile['id_user'] ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" value="<?= $profile['id_user'] ?>">
                <div class="row">
                    <div class="col">
                        <label for="">Name</label>
                        <input type="text" class="form-control" name="name" value="<?= $profile['name'] ?>">
                    </div>
                    <div class="col">
                        <label for="">Position</label>
                        <input type="text" class="form-control" name="position" value="<?= $profile['position'] ?>">
                    </div>
                </div>
<hr>
                <div class="row">
                    <div class="col">
                        <label for="">Username</label>
                        <input type="text" class="form-control" name="username" value="<?= $profile['username'] ?>">
                    </div>
                    <div class="col">
                        <label for="">Password</label>
                        <input type="password" class="form-control" name="password" value="<?= $profile['password'] ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label for="">Gambar</label>
                        <input type="file" class="form-control" name="gambar">
                        <input type="hidden" name="gambar_lama" value="<?= $profile['gambar'] ?>">
                    </div>
                </div>

                <div class="row">
            <div class="col">
                <?php if($profile['gambar'] == null) : ?>
                <img src="/assets/img/none.png" class="img-thumbnail mt-3" alt="..." style="width: 8rem;">
                <?php else : ?>
                    <img src="/assets/img/<?= $profile['gambar'] ?>" class="img-thumbnail mt-3" alt="..." style="width: 8rem;">
                <?php endif ?>
            </div>
        </div>
                <button type="submit" class="btn btn-outline-danger mt-3"> <i class="fas fa-edit"></i> Update </button>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>