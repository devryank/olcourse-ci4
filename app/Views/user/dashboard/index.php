<?= $this->extend('_template/template_user'); ?>

<?= $this->section('main'); ?>


<!-- Single Cool Facts Area -->
<div class="col-12 col-sm-6 col-lg-12 pt-5 pb-5">
    <div class="single-cool-facts-area text-center mb-100 wow fadeInUp" data-wow-delay="1000ms">
        <div class="icon">
            <h4>Selamat Datang di Dashboard, <br><?= session()->get('full_name'); ?></h4>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-lg-8 offset-lg-2">
        <div class="row">
            <div class="card col-lg-5 text-center mx-auto">
                <div class="card-title pt-5 pb-2">
                    <h6>Paket dan kelas yang kamu ikuti</h6>
                </div>
                <div class="card-body">
                    <hr>
                    <button type="button" class="btn btn-block btn-outline-primary" data-toggle="modal" data-target="#modal">
                        Lihat
                    </button>
                </div>
            </div>

            <div class="card col-lg-5 ml-1 text-center mx-auto">
                <div class="card-title pt-5 pb-2">
                    <h6>Lihat kelas yang sudah diselesaikan</h6>
                </div>
                <div class="card-body">
                    <hr>
                    <a href="<?= site_url('user/lulus');?>" class="btn btn-block btn-outline-primary">Lihat</a>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Paket dan kelas yang kamu ikuti</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php if ($count_packages > 0) : ?>
                        <?php foreach ($packages as $package) : ?>
                            <div class="col-lg-12 my-4">
                                <div class="row">
                                    <div class="col-lg-4"><img src="<?= base_url(); ?>/assets/uploads/packages/<?= $package->img; ?>" alt=""></div>
                                    <div class="col-lg-8">
                                        <h6><?= $package->package_name; ?></h6>
                                        <a href="<?= site_url('my-package/' . $package->slug); ?>" class="btn btn-sm btn-block btn-primary mt-4">Pelajari</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <?php if ($count_classes > 0) : ?>
                        <?php foreach ($classes as $class) : ?>
                            <div class="col-lg-12 my-4">
                                <div class="row">
                                    <div class="col-lg-4"><img src="<?= base_url(); ?>/assets/uploads/classes/<?= $class->img; ?>" alt=""></div>
                                    <div class="col-lg-8">
                                        <h6><?= $class->class_name; ?></h6>
                                        <a href="<?= site_url('topics/' . $class->slug); ?>" class="btn btn-sm btn-block btn-primary mt-4">Pelajari</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <?php if ($count_packages == 0 and $count_classes == 0) : ?>
                        <p class="text-center">Tidak ada paket</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>