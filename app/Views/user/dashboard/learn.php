<?= $this->extend('_template/template_user'); ?>

<?= $this->section('main'); ?>


<!-- Single Cool Facts Area -->
<div class="col-12 col-sm-6 col-lg-12 pt-5 pb-5">
    <div class="single-cool-facts-area text-center mb-100 wow fadeInUp" data-wow-delay="1000ms">
        <div class="icon">
            <h4><?= $className; ?></h4>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-lg-8 offset-lg-2">
        <div class="page-content">
            <h4 class="text-center"><?= $topic->topic_name;?></h4>
            <p><?= $topic->content;?></p>
        </div>
        <div class="text-center mt-4">
            <a href="<?= site_url('learn/' . $segment[1] . '/' . $segment[2] . '/done');?>" class="btn clever-btn">Selesai</a>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>