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
        <?php foreach ($listTopics as $topic) : ?>
            <?php if($topic->topic_id != NULL):?>
                    <a href="<?= site_url('learn/' . $segment[1] . '/' . $topic->slug); ?>" class="text-left btn clever-btn btn-2 w-100 mb-2" style="color: black;">
                        <div class="row">
                            <div class="col-lg-11">
                                <?= $topic->topic_name; ?>
                            </div>
                            <div class="col-lg-1 text-right">
                                <i class="fa fa-check"></i>
                            </div>
                        </div>
                    </a>
            <?php else:?>
            <a href="<?= site_url('learn/' . $segment[1] . '/' . $topic->slug); ?>" class="text-left btn clever-btn btn-2 w-100 mb-2" style="color: black;"><?= $topic->topic_name; ?></a>
            <?php endif;?>
        <?php endforeach; ?>
    </div>
</div>

<?= $this->endSection(); ?>