<?= $this->extend('_template/template'); ?>

<?= $this->section('main'); ?>
    <div class="row">
        <div class="container">
            <div class="col-md-12">
                <a href="<?= site_url('admin/diskon/tambah');?>" class="btn btn-primary mb-3 text-right">Tambah Promo</a>
                <div class="tile">
                    <div class="tile-body">
                        <div class="table-responsive">
                            <?= session()->getFlashdata('message');?>
                            <table class="table table-hover table-bordered text-center" id="sampleTable">
                                <thead>
                                    <tr>
                                        <th>Kode Promo</th>
                                        <th>Potongan</th>
                                        <th>Durasi</th>
                                        <th width="15%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($discounts as $discount):?>
                                    <tr>
                                        <td><?= $discount->promo_code;?></td>
                                        <td><?= $discount->discount;?>%</td>
                                        <td><?= $discount->from . ' - ' . $discount->to;?></td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="<?= site_url('admin/diskon/edit/' . $discount->promo_code);?>" class="btn btn-warning btn-sm mr-2">Ubah</a>
                                                <a href="<?= site_url('admin/diskon/delete/' . $discount->promo_code);?>" class="btn btn-danger btn-sm">Hapus</a>
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