<?= $this->extend('_template/template'); ?>

<?= $this->section('main'); ?>
    <div class="row">
        <div class="container">
            <div class="col-md-12">
                <a href="<?= site_url('admin/diskon'); ?>" class="btn btn-primary mb-3 text-right">Kembali</a>
                <div class="tile">
                    <?= session()->getFlashdata('message'); ?>
                    <div class="tile-body">
                        <?= form_open('admin/diskon/proses-edit/' . $discount->promo_code); ?>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Kode Promo</label>
                                <input name="promo_code" class="form-control" type="text" placeholder="Masukkan kode promo" value="<?= $discount->promo_code;?>">
                                <small class="text-danger"><?= \Config\Services::validation()->getError('promo_code'); ?></small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Potongan</label>
                                <input name="discount" class="form-control" type="text" placeholder="Masukkan potongan harga" value="<?= $discount->discount;?>">
                                <small class="text-danger"><?= \Config\Services::validation()->getError('discount'); ?></small>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Dari</label>
                                        <input name="from" class="form-control" type="datetime-local" value="<?php $datetime = strtotime($discount->from); echo date('Y-m-d\TH:i', $datetime);?>">
                                        <small class="text-danger"><?= \Config\Services::validation()->getError('from'); ?></small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Sampai</label>
                                        <input name="to" class="form-control" type="datetime-local" value="<?php $datetime = strtotime($discount->to); echo date('Y-m-d\TH:i', $datetime);?>">
                                        <small class="text-danger"><?= \Config\Services::validation()->getError('to'); ?></small>
                                    </div>
                                </div>
                            </div>                            
                        </div>
                        <div class="tile-footer">
                            <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Edit</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="<?= site_url('admin/diskon'); ?>"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?= $this->endSection(); ?>