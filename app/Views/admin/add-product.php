<?= $this->extend('template/layouts') ?>
<?= $this->section('content') ?>

<div class="container-fluid">

<h5 class="">Add product</h5>
<a href="/superadmin/product" class="btn btn-outline-danger mb-3"> <i class="fas fa-arrow-alt-circle-left"></i> Back</a>
<?php if(session()->getFlashdata('error')) : ?>
<div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
<?php endif ?>

<?php if(session()->getFlashdata('success')) : ?>
<div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif ?>

<?php if(session()->getFlashdata('error_input')) : ?>
<div class="alert alert-danger"><?= session()->getFlashdata('error_input') ?></div>
<?php endif ?>
<div class="card">
    <div class="card-body">
        <form action="/superadmin/save-product" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col">
                <label for="" class="form-label">Nama product</label>
                <input type="text" class="form-control" name="nama_barang">
            </div>
            <div class="col">
                <label for="" class="form-label">Kategori</label>
                <select name="id_category" id="" class="form-control">
                <option value="">Pilih</option>
                <?php foreach($categories  as $category) : ?> 
                <option value="<?= $category['id_category'] ?>"><?= $category['name_category'] ?></option>
                <?php endforeach ?>
                </select>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col">
                    <label for="" class="form-label">Harga beli</label>
                    <input type="text" class="form-control" name="harga_beli" id="harga_beli">
                    <a onclick="calculateHargaJual()" class="btn btn-sm btn-outline-danger mt-2">Calculate</a>
                    
            </div>
            <div class="col">
                    <label for="" class="form-label">Harga Jual</label>
                    <input type="text" class="form-control" name="harga_jual" id="harga_jual" readonly>
                    <span class="text-danger">harap click calculate untuk mengisi harga jual</span>
            </div>
        </div>
<hr>
        <div class="row">
            <div class="col">
                <label for="" class="form-label">Stok Barang</label>
                <input type="text" class="form-control" name="stock_barang">
            </div>
            <div class="col">
                <label for="" class="form-label">Gambar</label>
                <input type="file" class="form-control" name="gambar">
            </div>
        </div>
<hr>
        <button class="btn btn-outline-danger mt-3" type="submit"> <i class="fas fa-save"></i> Save </button>
        </form>
    </div>
</div>
</div>

<script type="text/javascript">
   function calculateHargaJual() {
        let hargaBeli = parseFloat(document.getElementById('harga_beli').value);
        let hargaJual = hargaBeli * 1.3; // Menambahkan 30% dari harga beli
        document.getElementById('harga_jual').value = hargaJual.toFixed(0); 
    }
</script>

<?= $this->endSection() ?>