<?= $this->extend('_template/template'); ?>

<?= $this->section('main'); ?>
    <div class="row">
        <div class="container">
            <div class="col-md-12">
                <a href="<?= site_url('admin/kelas/tambah');?>" class="btn btn-primary mb-3 text-right">Tambah Kelas</a>
                <div class="tile">
                    <div class="tile-body">
                        <div class="table-responsive">
                            <?= session()->getFlashdata('message');?>
                            <table class="table table-hover table-bordered" id="sampleTable">
                                <thead class="text-center">
                                    <tr>
                                        <th>Nama Kelas</th>
                                        <th>Harga</th>
                                        <th>Tanggal Rilis</th>
                                        <th>Durasi</th>
                                        <th width="15%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($listKelas as $kelas):?>
                                    <tr>
                                        <td><?= $kelas->class_name;?></td>
                                        <td><?= "Rp " . number_format($kelas->price,0,',','.');?></td>
                                        <td><?= $kelas->created_at;?></td>
                                        <td><?= $kelas->duration;?> hari</td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <a href="<?= site_url('admin/kelas/edit/' . $kelas->slug);?>" class="btn btn-warning btn-sm mr-2">Ubah</a>
                                                <a href="<?= site_url('admin/kelas/delete/' . $kelas->slug);?>" class="btn btn-danger btn-sm">Hapus</a>
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