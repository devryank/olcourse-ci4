<?= $this->extend('_template/template'); ?>

<?= $this->section('main'); ?>
    <div class="row">
        <div class="container">
            <div class="col-md-12">
                <a href="<?= site_url('admin/paket'); ?>" class="btn btn-primary mb-3 text-right">Kembali</a>
                <div class="tile">
                    <?= session()->getFlashdata('message'); ?>
                    <div class="tile-body">
                        <?= form_open_multipart('admin/paket/proses-edit/' . $slug); ?>
                        <?php 
                            foreach ($package as $key => $package):
                                $class_id = $package->class_id;
                            $data_class = explode(',', $class_id);
                            $countClass = count($data_class) - 1;
                        ?>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Nama Paket</label>
                                <input name="package_name" class="form-control" type="text" placeholder="Masukkan nama kelas" value="<?= $package->package_name;?>">
                                <small class="text-danger"><?= \Config\Services::validation()->getError('package_name'); ?></small>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Kelas</label>
                                <select name="class_id[]" class="form-control selectpicker"  id="demoSelect" multiple="">
                                    <optgroup label="Select Class">
                                    <?php foreach ($listClass as $key => $class):?>
                                    <option value="<?= $class->class_id;?>" <?php for ($i=0; $i <= $countClass; $i++) { 
                                if($class->class_id == $data_class[$i]){echo 'selected';}
                            } ?>><?= $class->class_name;?></option>
                                    <?php endforeach;?>
                                    </optgroup>
                                </select>
                                <small class="text-danger"><?= \Config\Services::validation()->getError('class_id'); ?></small>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Foto</label>
                                <img src="<?= base_url();?>/assets/uploads/packages/<?= $package->img;?>" alt="" class="col-lg-12">
                                <input name="img" id="file" class="form-control mt-3" type="file">
                                <small class="text-danger"><?= \Config\Services::validation()->getError('img'); ?></small>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Harga</label>
                                <input name="price" class="form-control" type="number" placeholder="Masukkan harga paket" value="<?= $package->price;?>">
                                <small class="text-danger"><?= \Config\Services::validation()->getError('price'); ?></small>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Durasi</label>
                                <select name="duration" class="form-control">
                                    <option>-- Pilih hari --</option>
                                    <option value="10" <?php if($package->duration == '10'){echo 'selected';}?>>10 Hari</option>
                                    <option value="20" <?php if($package->duration == '20'){echo 'selected';}?>>20 Hari</option>
                                    <option value="30" <?php if($package->duration == '30'){echo 'selected';}?>>30 Hari</option>
                                    <option value="60" <?php if($package->duration == '60'){echo 'selected';}?>>60 Hari</option>
                                </select>
                                <small class="text-danger"><?= \Config\Services::validation()->getError('duration'); ?></small>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Detail</label>
                                <textarea id="editor" name="detail" rows="10" cols="30"><?= $package->detail;?></textarea>
                                <small class="text-danger"><?= \Config\Services::validation()->getError('detail'); ?></small>
                            </div>
                        </div>
                        <div class="tile-footer">
                            <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Edit</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="<?= site_url('admin/paket'); ?>"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                        </div>
                        <?php endforeach;?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?= $this->endSection(); ?>