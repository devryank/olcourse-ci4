<?= $this->extend('_template/template_user'); ?>

<?= $this->section('main'); ?>

    <!-- ##### Hero Area Start ##### -->
    <section class="hero-area bg-img bg-overlay-2by5" style="background-image: url(assets/user/img/bg-img/bg1.jpg);">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <!-- Hero Content -->
                    <div class="hero-content text-center">
                        <h2>Let's Study Together</h2>
                        <a href="<?= site_url('courses');?>" class="btn clever-btn">Get Started</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ##### Hero Area End ##### -->

    <!-- ##### Cool Facts Area Start ##### -->
    <section class="cool-facts-area section-padding-100-0">
        <div class="container">
            <div class="row">
                <!-- Single Cool Facts Area -->
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="single-cool-facts-area text-center mb-100 wow fadeInUp" data-wow-delay="250ms">
                        <div class="icon">
                            <i class="fa fa-cubes fa-4x mb-4" style="color: gray;"></i>
                        </div>
                        <h2><span class="counter"><?= $countPackage;?></span></h2>
                        <h5>Paket</h5>
                    </div>
                </div>

                <!-- Single Cool Facts Area -->
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="single-cool-facts-area text-center mb-100 wow fadeInUp" data-wow-delay="500ms">
                        <div class="icon">
                            <i class="fa fa-cube fa-4x mb-4" style="color: gray;"></i>
                        </div>
                        <h2><span class="counter"><?= $countClass;?></span></h2>
                        <h5>Kelas</h5>
                    </div>
                </div>

                <!-- Single Cool Facts Area -->
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="single-cool-facts-area text-center mb-100 wow fadeInUp" data-wow-delay="1000ms">
                        <div class="icon">
                            <i class="fa fa-file fa-4x mb-4" style="color: gray;"></i>
                        </div>
                        <h2><span class="counter"><?= $countTopic;?></span></h2>
                        <h5>Topik</h5>
                    </div>
                </div>
                
                <!-- Single Cool Facts Area -->
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="single-cool-facts-area text-center mb-100 wow fadeInUp" data-wow-delay="750ms">
                        <div class="icon">
                            <i class="fa fa-user fa-4x mb-4" style="color: gray;"></i>
                        </div>
                        <h2><span class="counter"><?= $countUser;?></span></h2>
                        <h5>Pengguna</h5>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- ##### Cool Facts Area End ##### -->

    <!-- ##### Popular Courses Start ##### -->
    <section class="popular-courses-area section-padding-100-0" style="background-image: url(assets/user/img/core-img/texture.png);">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-heading">
                        <h3>Popular Online Courses</h3>
                    </div>
                </div>
            </div>

            <div class="row">
            <?php foreach ($packages as $package):?>
                <!-- Single Popular Course -->
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
                            </div>
                            <div class="course-fee h-100">
                                <a href="<?= site_url('course/package/' . $package->slug);?>" class="<?php if($package->price == 0){echo 'free';}?>"><?= "Rp " . number_format($package->price,0,',','.');?></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach;?>
            </div>
        </div>
    </section>
    <!-- ##### Popular Courses End ##### -->

<?= $this->endSection(); ?>