<?= $this->extend('_template/template_user'); ?>

<?= $this->section('main'); ?>

<!-- ##### Popular Course Area Start ##### -->
<section class="popular-courses-area section-padding-100">
    <div class="container">
        <h2 class="text-center mb-5">Paket</h2>
        <div class="row">
            <!-- Single Popular Course -->
            <?php foreach ($packages as $package) : ?>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="single-popular-course mb-100 wow fadeInUp" data-wow-delay="250ms">
                        <a href="<?= site_url('course/package/' . $package['slug']); ?>"><img src="<?= base_url(); ?>/assets/uploads/packages/<?= $package['img']; ?>" alt="" style="height: 220px;"></a>
                        <!-- Course Content -->
                        <div class="course-content">
                            <a href="<?= site_url('course/package/' . $package['slug']); ?>">
                                <h4><?= $package['package_name']; ?></h4>
                            </a>
                        </div>
                        <!-- Seat Rating Fee -->
                        <div class="seat-rating-fee d-flex justify-content-between">
                            <div class="seat-rating h-100 d-flex align-items-center">
                                <div class="seat">
                                    <i class="fa fa-user" aria-hidden="true"></i> 10
                                </div>
                            </div>
                            <div class="course-fee h-100">
                                <a href="<?= site_url('course/package/' . $package['slug']); ?>" class="<?php if ($package['price'] == 0) {
                                                                                                            echo 'free';
                                                                                                        } ?>"><?= "Rp " . number_format($package['price'], 0, ',', '.'); ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="row">
            <div class="col-lg-12 text-center">
                <?= $pager->links('bootstrap', 'bootstrap_pagination'); ?>
            </div>
        </div>
    </div>
</section>
<!-- ##### Popular Course Area End ##### -->

<?= $this->endSection(); ?>