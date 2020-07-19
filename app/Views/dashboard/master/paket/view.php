<?= $this->extend('_template/template'); ?>

<?= $this->section('main'); ?>
    <div class="row">
        <div class="container">
            <div class="col-md-12">
                <a href="<?= site_url('admin/paket/tambah');?>" class="btn btn-primary mb-3 text-right">Tambah Paket</a>
                <div class="tile">
                    <div class="tile-body">
                        <div class="table-responsive">
                            <?= session()->getFlashdata('message');?>
                            <table class="table table-hover table-bordered" id="sampleTable">
                                <thead class="text-center">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Paket</th>
                                        <th>Kelas</th>
                                        <th>Harga</th>
                                        <th>Tanggal Rilis</th>
                                        <th>Durasi</th>
                                        <th width="15%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; foreach ($listPackage as $paket):?>
                                    <tr>
                                        <td><?= $no++;?></td>
                                        <td><?= $paket->package_name;?></td>
                                        <td><?= $paket->class_name;?></td>
                                        <td><?= $paket->price;?></td>
                                        <td><?= $paket->created_at;?></td>
                                        <td><?= $paket->duration;?> hari</td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <a href="<?= site_url('admin/paket/edit/' . $paket->slug);?>" class="btn btn-warning btn-sm mr-2">Ubah</a>
                                                <a href="<?= site_url('admin/paket/delete/' . $paket->slug);?>" class="btn btn-danger btn-sm">Hapus</a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?= $this->endSection(); ?>