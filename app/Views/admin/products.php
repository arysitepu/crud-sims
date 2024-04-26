<?= $this->extend('template/layouts') ?>
<?= $this->section('content') ?>
    <div class="container-fluid">
        <h5>Products</h5>
        <a href="/superadmin/add-product" class="btn btn-outline-danger mb-3"> <i class="fas fa-plus"></i> add </a>
        <?php if(session()->getFlashdata('success')) : ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif ?>

        <div class="card mb-3">
            <div class="card-body">
                <form action="/superadmin/search">
                <div class="row">
                    <div class="col">
                        <label for="" class="form-label">Nama barang</label>
                        <input type="text" class="form-control" name="nama_barang">
                    </div>
                    <div class="col">
                    <label for="" class="form-label">Kategori</label>
                    <select name="id_category" id="" class="form-control">
                            <option value="">Pilih</option>
                            <?php foreach($categories as $category) : ?>
                            <option value="<?= $category['id_category'] ?>"><?= $category['name_category'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <button class="btn btn-outline-danger mt-2"> <i class="fas fa-search"></i> Search </button>
                <a href="/superadmin/product" class="btn btn-outline-danger mt-2"> <i class="fas fa-sync"></i> Reset </a>
                <button type="submit" formaction="/superadmin/export-excel" class="btn btn-outline-success mt-2"> <i class="fas fa-download"></i> Excel </button>
            </form>
            </div>
        </div>

            <div class="card">
                <div class="card-body">
                    <div class="table table-responsive">
                        <table class="table" id="example">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Gambar</th>
                                    <th>Nama Produk</th>
                                    <th>Kategori Produk</th>
                                    <th>Harga Beli (Rp)</th>
                                    <th>Harga Jual (Rp)</th>
                                    <th>Stock Produk</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <?php 
                                $no = 1;
                            ?>
                            <tbody>
                                <?php foreach($products as $product) : ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td>
                                        <?php if($product['gambar'] == null) : ?>
                                            <span class="text-info">None</span>
                                        <?php else : ?>
                                            <img src="/assets/img/<?= $product['gambar'] ?>" alt="..." class="img-thumbnail" style="width: 3rem;">
                                        <?php endif ?>
                                    </td>
                                    <td><?= $product['nama_barang'] ?></td>
                                    <td><?= $product['name_category'] ?></td>
                                    <td><?= number_format($product['harga_beli'], 0, ',', '.') ?></td>
                                    <td><?= number_format($product['harga_jual'], 0, ',', '.') ?></td>
                                    <td class="text-center"><?= $product['stock_barang'] ?></td>
                                    <td>
                                        <a href="/superadmin/edit-product/<?= $product['id_product'] ?>" class="btn btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="/superadmin/product/<?= $product['id_product'] ?>" method="post" class="d-inline">
                                            <?= csrf_field(); ?>
                                            <input type="hidden" name="_method" value="delete">
                                            <button type="submit" class="btn btn-sm" onclick="return confirm('apakah anda yakin?.');" ><i class="fas fa-trash-alt"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </div>

 <?= $this->endSection() ?>