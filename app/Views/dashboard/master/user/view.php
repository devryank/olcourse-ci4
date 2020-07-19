<?= $this->extend('_template/template'); ?>

<?= $this->section('main'); ?>
    <div class="row">
        <div class="container">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <div class="table-responsive">
                            <?= session()->getFlashdata('message');?>
                            <table class="table table-hover table-bordered" id="sampleTable">
                                <thead class="text-center">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Lengkap</th>
                                        <th>Username</th>
                                        <th>E-Mail</th>
                                        <th>Aktif</th>
                                        <th>Dibuat tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; foreach ($listUser as $user):?>
                                    <tr>
                                        <td class="text-center"><?= $no++;?></td>
                                        <td><?= $user->full_name;?></td>
                                        <td><?= $user->username;?></td>
                                        <td><?= $user->email;?></td>
                                        <td><?php if($user->is_active == 1){echo 'Aktif';} else {echo 'Tidak Aktif';}?></td>
                                        <td><?= $user->created_at;?></td>
                                    </tr>
                                    <?php endforeach;?>
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