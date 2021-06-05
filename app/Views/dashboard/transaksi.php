<?= $this->extend('_template/template'); ?>

<?= $this->section('main'); ?>
    <div class="row">
        <div class="container">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <div class="table-responsive">
                            <?= session()->getFlashdata('message'); ?>
                            <table class="table text-center table-hover table-bordered" id="sampleTable">
                                <thead>
                                    <tr>
                                        <th>Invoice ID</th>
                                        <th>Tipe</th>
                                        <th>Nama Kursus</th>
                                        <th>Harga</th>
                                        <th>Tanggal Order</th>
                                        <th>Bukti Pembayaran</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($transaksi as $row) : ?>
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
                                            <td><img src="<?= base_url();?>/assets/uploads/buktipembayaran/<?= $row->bukti_pembayaran;?>" alt="" style="height: 220px;"></td>
                                            <td><?php if($row->waiting_confirmation == '1'){ echo "<small class='text-white bg-primary pt-1 pr-1 pb-1 pl-1'>Menunggu</small>";} ?></td>
                                            <td><a href="<?= site_url('admin/verify_payment/' . $row->transaction_id); ?>" class="btn btn-sm btn-success"><i class="fa fa-check mx-auto"></i></a></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?= $this->endSection(); ?>