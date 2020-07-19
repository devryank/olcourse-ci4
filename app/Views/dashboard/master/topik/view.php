<?= $this->extend('_template/template'); ?>

<?= $this->section('main'); ?>
    <div class="row">
        <div class="container">
            <div class="col-md-12">
                <a href="<?= site_url('admin/topik/tambah');?>" class="btn btn-primary mb-3 text-right">Tambah Topik</a>
                <div class="tile">
                    <div class="tile-body">
                        <div class="table-responsive">
                            <?= session()->getFlashdata('message');?>
                            <table class="table table-hover table-bordered" id="sampleTable">
                                <thead class="text-center">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Nama Topik</th>
                                        <th>Tanggal Rilis</th>
                                        <th width="15%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($listTopic as $topic):?>
                                    <tr>
                                        <td><?= $topic->number;?></td>
                                        <td><?= $topic->topic_name;?></td>
                                        <td><?= $topic->class_name;?></td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <a href="<?= site_url('admin/topik/edit/' . $topic->slug_class .'/' . $topic->slug_topic);?>" class="btn btn-warning btn-sm mr-2">Ubah</a>
                                                <a href="<?= site_url('admin/topik/delete/' . $topic->slug_class .'/' . $topic->slug_topic);?>" class="btn btn-danger btn-sm">Hapus</a>
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