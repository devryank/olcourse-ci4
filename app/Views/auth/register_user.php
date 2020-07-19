<?= $this->extend('_template/template_user'); ?>

<?= $this->section('main'); ?>
<!-- ##### Regular Page Area Start ##### -->
<div class="regular-page-area section-padding-100">
    <div class="container page-content">
        <div class="row h-100">
            <div class="col-6 mx-auto">
                <?= session()->getFlashdata('message'); ?>
                <p class="text-center mb-4"><a href="<?= site_url('user/login');?>"><---- Kembali ke halaman login</a></p>
                <h3 class="text-center mb-3">Register</h3>
                <?= form_open('auth/proses-register'); ?>
                    <div class="form-group">
                        <label class="control-label">NAMA LENGKAP</label>
                        <input class="form-control" name="full_name" type="text" placeholder="John Doe" autofocus autocomplete="off">
                        <small class="text-danger"><?= \Config\Services::validation()->getError('full_name'); ?></small>
                    </div>
                    <div class="form-group">
                        <label class="control-label">USERNAME</label>
                        <input class="form-control" name="username" type="text" placeholder="John Doe" autofocus autocomplete="off">
                        <small class="text-danger"><?= \Config\Services::validation()->getError('username'); ?></small>
                    </div>
                    <div class="form-group">
                        <label class="control-label">E-MAIL</label>
                        <input class="form-control" name="email" type="email" placeholder="Email" autofocus autocomplete="off">
                        <small class="text-danger"><?= \Config\Services::validation()->getError('email'); ?></small>
                    </div>
                    <div class="form-group">
                        <label class="control-label">PASSWORD</label>
                        <input class="form-control" name="password" type="password" placeholder="Password">
                        <small class="text-danger"><?= \Config\Services::validation()->getError('password'); ?></small>
                    </div>
                    <div class="form-group">
                        <label class="control-label">KETIK ULANG PASSWORD</label>
                        <input class="form-control" name="re_password" type="password" placeholder="re-type password">
                        <small class="text-danger"><?= \Config\Services::validation()->getError('re_password'); ?></small>
                    </div>
                    <input type="submit" value="Login" class="btn btn-primary btn-block mt-4">
                </form>
            </div>
        </div>
    </div>
</div>
<!-- ##### Regular Page Area End ##### -->
<?= $this->endSection(); ?>