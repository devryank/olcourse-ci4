<?= $this->extend('_template/template'); ?>

<?= $this->section('main'); ?>
    <div class="row">
        <div class="container">
            <div class="col-md-12">
                <a href="<?= site_url('admin/kelas'); ?>" class="btn btn-primary mb-3 text-right">Kembali</a>
                <div class="tile">
                    <?= session()->getFlashdata('message'); ?>
                    <div class="tile-body">
                        <?= form_open_multipart('admin/kelas/proses-edit/' . $slug); ?>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Nama Kelas</label>
                                <input name="class_name" class="form-control" type="text" placeholder="Masukkan nama kelas" value="<?= $data->class_name; ?>">
                                <small class="text-danger"><?= \Config\Services::validation()->getError('class_name'); ?></small>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Foto</label>
                                <img src="<?= base_url();?>/assets/uploads/<?= $data->img;?>" alt="" class="col-lg-12">
                                <input name="img" id="file" class="form-control mt-3" type="file">
                                <small class="text-danger"><?= \Config\Services::validation()->getError('img'); ?></small>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Harga</label>
                                <input name="price" class="form-control" type="number" placeholder="Masukkan harga kelas" value="<?= $data->price; ?>">
                                <small class="text-danger"><?= \Config\Services::validation()->getError('price'); ?></small>
                            </div>
                        </div>
                        <div class="tile-footer">
                            <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Register</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="<?= site_url('admin/kelas'); ?>"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?= $this->endSection(); ?>