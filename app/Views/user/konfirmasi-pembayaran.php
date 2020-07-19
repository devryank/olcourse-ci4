<?= $this->extend('_template/template_user'); ?>

<?= $this->section('main'); ?>

<div class="regular-page-area section-padding-100">
    <div class="container">
        <?= session()->getFlashdata('message'); ?>
        <div class="row">
            <div class="col-12">
                <div class="page-content text-center">
                    <h4>Konfirmasi Pembayaran</h4>
                    <form action="<?= site_url('user/proses-konfirmasi-pembayaran');?>" method="post">
                    <div class="row mt-5">
                        <div class="col-md-4 text-right my-auto">
                            <label for="invoice_id">Saya telah melakukan pembayaran pada ID</label>
                        </div>
                        <div class="col-md-6">
                            <input type="number" name="invoice_id" class="form-control" placeholder="012007190001" autocomplete="off">
                            <small class="text-danger"><?= \Config\Services::validation()->getError('invoice_id'); ?></small>
                        </div>
                        <div class="col-lg-12 text-left">
                            <input type="submit" class="btn clever-btn mt-5" value="Konfirmasi">
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
<!-- SELECT DISTINCT transactions.option, transactions.transaction_id, transactions.id, course_id, course_name, transactions.amount, transactions.is_paid, transactions.order_date, transactions.token FROM `transactions` JOIN ((SELECT packages.package_id as course_id, packages.package_name as course_name from packages JOIN transactions ON transactions.id = packages.package_id where transactions.option = 'package') UNION (SELECT classes.class_id as course_id, classes.class_name as course_name from classes JOIN transactions ON transactions.id = classes.class_id where transactions.option = 'class')) ids ON transactions.id = course_id GROUP by transactions.transaction_id -->