<?= $this->extend('_template/template_user'); ?>

<?= $this->section('main'); ?>

    <div class="regular-page-area section-padding-100">
        <div class="container"> 
            <div class="row">
                <div class="col-8">
                    <div class="page-content">
                        <h4 class="mb-4">Cart</h4>
                        <div class="row">
                            <div class="col-lg-3 my-auto">
                                <img src="<?= base_url();?>/assets/uploads/classes/<?= $course->img;?>" alt="">
                            </div>
                            <div class="col-lg-9 my-auto">
                                <h5><?= $course->class_name;?></h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="page-content mb-3">
                        <div class="row">
                            <div class="col-lg-6">
                                <p>Harga: </p>
                                <p>Kode unik: </p>
                                <p>Potongan: </p>
                            </div>
                            <div class="col-lg-6 text-right">
                                <p><?= "Rp " . number_format($course->price,0,',','.');?></p>
                                <p><?= $random_number;?></p>
                                <p><?= $discount;?>%</p>
                            </div>
                            <div class="col-lg-12">
                                <hr>
                            </div>
                            <div class="col-lg-6">
                                <p>Total: </p>
                            </div>
                            <div class="col-lg-6 text-right">
                                <p class="text-success"><?= "Rp " . number_format($price,0,',','.');?></p>
                            </div>
                        </div>
                    </div>
                    <a href="<?= site_url('buy');?>" class="btn clever-btn btn-block">Buy</a>
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection();?>