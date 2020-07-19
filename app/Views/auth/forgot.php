<?= $this->extend('_template/template_auth');?>

<?= $this->section('main_auth');?>
<section class="material-half-bg">
    <div class="cover"></div>
</section>
<section class="login-content">
    <div class="logo">
        <h1>Vali</h1>
    </div>
    <div class="login-box" style="min-height: 300px">
        <?= form_open('auth/proses-login', ['class' => 'login-form']);?>
            <h3 class="login-head"><i class="fa fa-lg fa-fw fa-key"></i>Forgot Password</h3>
            <?= session()->getFlashdata('message');?>
            <div class="form-group">
                <label class="control-label">E-MAIL</label>
                <input class="form-control" name="email" type="email" placeholder="Email" autofocus>
                <small class="text-danger"><?= \Config\Services::validation()->getError('email'); ?></small>
            </div>
            <div class="form-group btn-container">
                <button class="btn btn-primary btn-block" type="submit"><i class="fa fa-paper-plane fa-lg fa-fw"></i>Send Verification Link</button>
            </div>
        </form>
    </div>
</section>
<?= $this->endSection();?>