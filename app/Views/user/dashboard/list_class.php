<?= $this->extend('_template/template_user'); ?>

<?= $this->section('main'); ?>


                <!-- Single Cool Facts Area -->
    <div class="col-12 col-sm-6 col-lg-12 pt-5 pb-5">
        <div class="single-cool-facts-area text-center mb-100 wow fadeInUp" data-wow-delay="1000ms">
            <div class="icon">
            <?php if($value_check == '1'):?>
            <h4>Masa aktif pembelajaran paket <?= $packageName;?> sudah berakhir.</h4>
            <?php elseif($value_check == '0'):?>
            <h4>Daftar kelas dari paket <?= $packageName;?></h4>
            <?php endif;?>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-lg-8 offset-lg-2">

        <?php if($value_check == '0'):?>
            <?php foreach ($listClass as $class):?>
                <a href="<?= site_url('topics/' . $class->slug);?>" class="btn clever-btn w-100 mb-2"><?= $class->class_name;?></a>
            <?php endforeach;?>
        <?php endif;?>
    </div>
</div>

<?= $this->endSection(); ?>