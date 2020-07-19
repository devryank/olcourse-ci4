<?= $this->extend('_template/template_user'); ?>

<?= $this->section('main'); ?>
<!-- ##### Regular Page Area Start ##### -->
<div class="regular-page-area section-padding-100">
    <div class="container page-content">
        <div class="row h-100">
            <div class="col-8 mx-auto">
                <?= session()->getFlashdata('message'); ?>
                <h3 class="text-center mb-3">Forgot Password</h3>
                <?= form_open('user/proses-new-password/' . $segment[2]); ?>
                <div class="form-group">
                    <label class="control-label">Sandi Baru</label>
                    <input class="form-control" name="password" type="password" placeholder="Sandi Baru" autofocus required>
                    <small class="text-danger"><?= \Config\Services::validation()->getError('password'); ?></small>
                </div>
                <div class="form-group">
                    <label class="control-label">Ketik Ulang Sandi Baru</label>
                    <input class="form-control" name="re_password" type="password" placeholder="Ketik Ulang Sandi Baru" required>
                    <small class="text-danger"><?= \Config\Services::validation()->getError('re_password'); ?></small>
                </div>
                <input type="submit" value="Ubah Sandi" class="btn btn-primary btn-block mt-4">
                </form>
            </div>
        </div>
    </div>
</div>
<!-- ##### Regular Page Area End ##### -->
<?= $this->endSection(); ?>