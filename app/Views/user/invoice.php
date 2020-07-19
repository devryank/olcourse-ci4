<?= $this->extend('_template/template_user'); ?>

<?= $this->section('main'); ?>

<div class="regular-page-area section-padding-100">
    <div class="container">
        <?= session()->getFlashdata('message'); ?>
        <div class="row">
            <div class="col-12">
                <div class="page-content text-center">
                    <h4>Invoice</h4>
                    <table class="table table-hovered">
                        <thead>
                            <th>Invoice ID</th>
                            <th>Tipe</th>
                            <th>Nama Kursus</th>
                            <th>Harga</th>
                            <th>Tanggal Order</th>
                            <th>Status</th>
                            <th>Token</th>
                        </thead>
                        <tbody>
                            <?php foreach ($invoice as $row) : ?>
                                <tr>
                                    <td>#<?= $row->transaction_id; ?></td>
                                    <td><?php if ($row->option == 'package') {
                                            echo 'Paket';
                                        } else {
                                            echo 'Kelas';
                                        }; ?></td>
                                    <td><?= $row->course_name; ?></td>
                                    <td><?= "Rp " . number_format($row->amount, 0, ',', '.'); ?></td>
                                    <td><?= $row->order_date; ?></td>
                                    <td><?php if ($row->is_paid == '0') {
                                            if($row->waiting_confirmation == '1')
                                            {
                                                echo '<small class="text-white bg-warning pt-1 pr-1 pb-1 pl-1">Menunggu Konfirmasi</small>';
                                            } else {
                                                echo '<small class="text-white bg-warning pt-1 pr-1 pb-1 pl-1">Belum dibayar</small>';
                                            }
                                        } else {
                                            echo '<small class="text-white bg-success pt-1 pr-1 pb-1 pl-1">Dibayar</small>';
                                        }; ?></td>
                                    <td><?= $row->token; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <p class="mt-3">>> <a href="<?= site_url('user/konfirmasi-pembayaran');?>">Halaman konfirmasi pembayaran</a></p>
    </div>
</div>
<?= $this->endSection(); ?>
<!-- SELECT DISTINCT transactions.option, transactions.transaction_id, transactions.id, course_id, course_name, transactions.amount, transactions.is_paid, transactions.order_date, transactions.token FROM `transactions` JOIN ((SELECT packages.package_id as course_id, packages.package_name as course_name from packages JOIN transactions ON transactions.id = packages.package_id where transactions.option = 'package') UNION (SELECT classes.class_id as course_id, classes.class_name as course_name from classes JOIN transactions ON transactions.id = classes.class_id where transactions.option = 'class')) ids ON transactions.id = course_id GROUP by transactions.transaction_id -->