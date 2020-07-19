<?= $this->extend('_template/template_auth');?>

<?= $this->section('main_auth');?>
<section class="material-half-bg">
    <div class="cover"></div>
</section>
<section class="login-content">
    <div class="logo">
        <h1>Vali</h1>
    </div>
    <div class="login-box">
        <?= form_open('auth/proses-login', ['class' => 'login-form']);?>
            <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>SIGN IN</h3>
            <?= session()->getFlashdata('message');?>
            <div class="form-group">
                <label class="control-label">E-MAIL</label>
                <input class="form-control" name="email" type="email" placeholder="Email" autofocus>
                <small class="text-danger"><?= \Config\Services::validation()->getError('email'); ?></small>
            </div>
            <div class="form-group">
                <label class="control-label">PASSWORD</label>
                <input class="form-control" name="password" type="password" placeholder="Password">
                <small class="text-danger"><?= \Config\Services::validation()->getError('password'); ?></small>
            </div>
            <div class="form-group">
                <div class="utility">
                    <p class="semibold-text mb-2"><a href="<?= site_url('auth/forgot_password');?>" data-toggle="flip">Forgot Password ?</a></p>
                </div>
            </div>
            <div class="form-group btn-container">
                <button class="btn btn-primary btn-block" type="submit"><i class="fa fa-sign-in fa-lg fa-fw"></i>SIGN IN</button>
            </div>
        </form>
    </div>
</section>
<?= $this->endSection();?>