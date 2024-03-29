<?= $this->extend('_template/template'); ?>

<?= $this->section('main'); ?>
    <div class="row">
        <div class="container">
            <div class="col-md-12">
                <a href="<?= site_url('admin/topik'); ?>" class="btn btn-primary mb-3 text-right">Kembali</a>
                <div class="tile">
                    <?= session()->getFlashdata('message'); ?>
                    <div class="tile-body">
                        <?= form_open('admin/topik/proses-tambah'); ?>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Nama Topik</label>
                                <input name="topic_name" class="form-control" type="text" placeholder="Masukkan nama topik" value="<?= set_value('topic_name');?>">
                                <small class="text-danger"><?= \Config\Services::validation()->getError('topic_name'); ?></small>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Kelas</label>
                                <select name="class_id" class="form-control">
                                    <option value="">-- Pilih Kelas --</option>
                                    <?php foreach ($listClasses as $class):?>
                                    <option value="<?= $class->class_id;?>"><?= $class->class_name;?></option>
                                    <?php endforeach;?>
                                </select>
                                <small class="text-danger"><?= \Config\Services::validation()->getError('class_id'); ?></small>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Nomor</label>
                                <input name="number" class="form-control" type="number" placeholder="contoh: 1" value="<?= set_value('number');?>">
                                <small class="text-danger"><?= \Config\Services::validation()->getError('number'); ?></small>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Konten</label>
                                <textarea id="editor" name="content" rows="10" cols="30"></textarea>
                                <small class="text-danger"><?= \Config\Services::validation()->getError('content'); ?></small>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Konten Videos Link Youtube</label>
                                <textarea id="editor" name="content_videos" rows="10" cols="30"></textarea>
                                <small class="text-danger"><?= \Config\Services::validation()->getError('content_videos'); ?></small>
                            </div>
                        </div>
                        <div class="tile-footer">
                            <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Tambah</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="<?= site_url('admin/topik'); ?>"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?= $this->endSection(); ?>