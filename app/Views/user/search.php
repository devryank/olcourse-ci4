<?= $this->extend('_template/template_user'); ?>

<?= $this->section('main'); ?>

    <!-- ##### Popular Course Area Start ##### -->
    <section class="popular-courses-area section-padding-100">
        <div class="container">
            <h2 class="text-center mb-5">Paket</h2>
            <div class="row">
                <!-- Single Popular Course -->
                <?php if(!empty($package_search)):?>
                <?php foreach ($package_search as $package):?>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="single-popular-course mb-100 wow fadeInUp" data-wow-delay="250ms">
                        <a href="<?= site_url('course/package/' . $package->slug);?>"><img src="<?= base_url();?>/assets/uploads/packages/<?= $package->img;?>" alt="" style="height: 220px;"></a>
                        <!-- Course Content -->
                        <div class="course-content">
                            <a href="<?= site_url('course/package/' . $package->slug);?>"><h4><?= $package->package_name;?></h4></a>
                        </div>
                        <!-- Seat Rating Fee -->
                        <div class="seat-rating-fee d-flex justify-content-between">
                            <div class="seat-rating h-100 d-flex align-items-center">
                                <div class="seat">
                                </div>
                            </div>
                            <div class="course-fee h-100">
                                <a href="<?= site_url('course/package/' . $package->slug);?>" class="<?php if($package->price == 0){echo 'free';}?>"><?= "Rp " . number_format($package->price,0,',','.');?></a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach;?>
                <?php else:?>
                    <div class="col-12 col-lg-12 wow fadeInUp"data-wow-delay="250ms">
                        <h4 class="text-center">Tidak ada paket</h4>
                    </div>
                <?php endif;?>
            </div>
        </div>
    </section>
    
    <section class="popular-courses-area section-padding-100">
        <div class="container">
            <h2 class="text-center mb-5">Kelas</h2>
            <div class="row">
                <!-- Single Popular Course -->
                <?php if(!empty($class_search)):?>
                <?php foreach ($class_search as $class):?>
                    <div class="col-12 col-md-6 col-lg-4">
                    <div class="single-popular-course mb-100 wow fadeInUp" data-wow-delay="250ms">
                        <a href="<?= site_url('course/class/' . $class->slug);?>"><img src="<?= base_url();?>/assets/uploads/classes/<?= $class->img;?>" style="height: 220px;" alt=""></a>
                        <!-- Course Content -->
                        <div class="course-content">
                            <a href="<?= site_url('course/class/' . $class->slug);?>"><h4><?= $class->class_name;?></h4></a>
                        </div>
                        <!-- Seat Rating Fee -->
                        <div class="seat-rating-fee d-flex justify-content-between">
                            <div class="seat-rating h-100 d-flex align-items-center">
                                <div class="seat">
                                </div>
                            </div>
                            <div class="course-fee h-100">
                                <a href="<?= site_url('course/class/' . $class->slug);?>" class="<?php if($class->price == 0){echo 'free';}?>"><?= "Rp " . number_format($package->price,0,',','.');?></a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach;?>
                <?php else:?>
                    <div class="col-12 col-lg-12 wow fadeInUp"data-wow-delay="250ms">
                        <h4 class="text-center">Tidak ada kelas</h4>
                    </div>
                <?php endif;?>
            </div>
        </div>
    </section>
    <!-- ##### Popular Course Area End ##### -->

<?= $this->endSection(); ?>
