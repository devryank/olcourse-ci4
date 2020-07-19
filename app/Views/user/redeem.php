<?= $this->extend('_template/template_user'); ?>

<?= $this->section('main'); ?>

<div class="regular-page-area section-padding-100">
    <div class="container">
        <?= session()->getFlashdata('message'); ?>
        <div class="row">
            <div class="col-12">
                <div class="page-content text-center">
                    <h4>Redeem Token</h4>
                    <?= form_open('redeem-token'); ?>
                    <input type="text" name="token" class="form-control">
                    <input type="submit" value="Redeem" class="btn clever-btn mt-2">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
