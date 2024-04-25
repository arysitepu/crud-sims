<?= $this->extend('template/layouts') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <h5>Profile</h5>

    <div class="card">
        <div class="card-shadow">
            <div class="card-body">
            <div class="row">
                <div class="col">
                <?php if($profile['gambar'] == null) : ?>
                <img src="/assets/img/none.png" class="img-thumbnail mt-3" alt="..." style="width: 10rem;">
                <?php else : ?>
                    <img src="/assets/img/<?= $profile['gambar'] ?>" class="img-thumbnail mt-3" alt="..." style="width: 10rem;">
                <?php endif ?>
                </div>
                <div class="col col-md-2 mt-3">
                    <a href="/superadmin/edit-profile/<?= $profile['id_user'] ?>" class="btn btn-outline-danger"> <i class="fas fa-edit"></i> Edit Profile </a>
                </div>
            </div>
            <hr>
            <div class="row mt-3">
                <div class="col">
                    <h4>Nama:</h4>
                </div>
                <div class="col">
                    <h4><?= $profile['name'] ?></h4>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col">
                    <h4>Position:</h4>
                </div>
                <div class="col">
                    <h4><?= $profile['position'] ?></h4>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>