<?= $this->extend('_template/template_user'); ?>

<?= $this->section('main'); ?>
<!-- ##### Regular Page Area Start ##### -->
<div class="regular-page-area section-padding-100">
    <div class="container page-content">
        <div class="row h-100">
            <div class="col-8 mx-auto">
                <?= session()->getFlashdata('message'); ?>
                <h3 class="text-center mb-3">Forgot Password</h3>
                <?= form_open('user/proses-forgot-password');?>
                    <div class="form-group">
                        <label for="E-MAIL">E-MAIL</label>
                        <input type="email" name="email" placeholder="Masukkan E-mail" class="form-control" autofocus required>
                        <small class="text-danger"><?= \Config\Services::validation()->getError('email'); ?></small>
                    </div>
                    <input type="submit" value="Login" class="btn btn-primary btn-block mt-4">
                </form>
            </div>
        </div>
    </div>
</div>
<!-- ##### Regular Page Area End ##### -->
<?= $this->endSection(); ?>