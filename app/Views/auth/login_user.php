<?= $this->extend('_template/template_user'); ?>

<?= $this->section('main'); ?>
<!-- ##### Regular Page Area Start ##### -->
<div class="regular-page-area section-padding-100">
    <div class="container page-content">
        <div class="row h-100">
            <div class="col-6">
                <?= session()->getFlashdata('message'); ?>
                <h3 class="text-center mb-3">Login</h3>
                <?= form_open('auth/proses-login');?>
                    <div class="form-group">
                        <label for="E-MAIL">E-MAIL</label>
                        <input type="email" name="email" placeholder="Masukkan E-mail" class="form-control" autofocus required>
                        <small class="text-danger"><?= \Config\Services::validation()->getError('email'); ?></small>
                    </div>
                    <div class="form-group">
                        <label class="control-label">PASSWORD</label>
                        <input class="form-control" name="password" type="password" placeholder="Password">
                        <small class="text-danger"><?= \Config\Services::validation()->getError('password'); ?></small>
                    </div>
                    <small><a href="<?= site_url('user/forgot-password');?>">Lupa Password?</a></small>
                    <input type="submit" value="Login" class="btn btn-primary btn-block mt-4">
                </form>
            </div>
            <div class="col-6 text-center my-auto">
                <p>Belum memiliki akun?</p>
                <p><a href="<?= site_url('user/register');?>">Daftar Sekarang</a></p>
            </div>
        </div>
    </div>
</div>
<!-- ##### Regular Page Area End ##### -->
<?= $this->endSection(); ?>