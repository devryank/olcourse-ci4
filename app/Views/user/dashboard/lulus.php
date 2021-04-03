<?= $this->extend('_template/template_user'); ?>

<?= $this->section('main'); ?>


<!-- Single Cool Facts Area -->
<div class="col-12 col-sm-6 col-lg-12 pt-5 pb-5">
    <div class="single-cool-facts-area text-center mb-100 wow fadeInUp" data-wow-delay="1000ms">
        <div class="icon">
            <h4>Kelas yang sudah diselesaikan</h4>
        </div>
    </div>
    <div class="col-12 col-md-12 col-lg-8 mx-auto">
        <div class="row">
            <?php if(!empty($class_list)):?>
            <?php foreach ($class_list as $class):?>
            <div class="col-12 col-sm-12 col-md-6 col-lg-4">
                <div class="single-popular-course mb-100 wow fadeInUp" data-wow-delay="250ms" style="height: 260px !important;">
                    <a href="<?= site_url('course/class/' . $class->slug); ?>"><img src="<?= base_url(); ?>/assets/uploads/classes/<?= $class->img;?>" alt=""></a>
                    <!-- Course Content -->
                    <div class="course-content">
                        <a href="<?= site_url('course/class/' . $class->slug); ?>">
                            <h4><?= $class->class_name;?></h4>
                        </a>
                        <a type="button" class="btn clever-btn mb-30 w-100" href="<?= site_url('home/generateCertificate/' . $class->slug)?>">
                            Generate certificate
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach;?>
            <?php else:?>
                <div class="col-12 col-sm-12 col-md-12 mb-100 wow fadeInUp" data-wow-delay="250ms">
                    <h4 class="text-center">Belum ada kelas yang diselesaikan</h4>
                </div>
            <?php endif;?>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>