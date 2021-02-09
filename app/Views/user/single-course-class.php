<?= $this->extend('_template/template_user'); ?>

<?= $this->section('main'); ?>


<!-- ##### Single Course Intro Start ##### -->
<div class="single-course-intro d-flex align-items-center justify-content-center" style="background-image: url('<?= base_url(); ?>/assets/user/img/bg-img/bg3.jpg');">
    <!-- Content -->
    <div class="single-course-intro-content text-center">
        <h3><?= $course->class_name; ?></h3>
        <div class="meta d-flex align-items-center justify-content-center">
        </div>
        <div class="price"><?php if ($course->price > 0) {
                                echo "Rp " . number_format($course->price, 0, ',', '.');
                            } else {
                                echo 'free';
                            } ?></div>
    </div>
</div>
<!-- ##### Single Course Intro End ##### -->

<!-- ##### Courses Content Start ##### -->
<div class="single-course-content section-padding-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <?= session()->getFlashdata('message'); ?>
            </div>
            <div class="col-12 col-lg-8">
                <div class="course--content">

                    <div class="clever-tabs-content">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="tab--1" data-toggle="tab" href="#tab1" role="tab" aria-controls="tab1" aria-selected="false">Description</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab--2" data-toggle="tab" href="#tab2" role="tab" aria-controls="tab2" aria-selected="true">Curriculum</a>
                            </li>
                        </ul>

                        <div class="tab-content" id="myTabContent">
                            <!-- Tab Text -->
                            <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab--1">
                                <div class="clever-description">

                                    <!-- About Course -->
                                    <div class="about-course mb-30">
                                        <h4>About this course</h4>
                                        <p><?= $course->detail; ?></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Tab Text -->
                            <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab--2">
                                <div class="clever-curriculum">

                                    <!-- Curriculum Level -->
                                    <div class="curriculum-level mb-30">
                                        <p>Daftar materi yang akan dipelajari di dalam kelas ini.</p>

                                        <ul class="curriculum-list">
                                            <?php foreach ($topics as $topic) : ?>
                                                <li><i class="fa fa-file" aria-hidden="true"></i> <?= $topic->topic_name; ?>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="course-sidebar">
                    <!-- Buy Course -->
                    <?php if ($status == '0') : ?>
                        <button type="button" class="btn clever-btn mb-30 w-100" data-toggle="modal" data-target="#discount">
                            Buy course
                        </button>
                    <?php elseif ($status == '1') : ?>
                        <a href="#" class="btn btn-secondary btn-block" style="pointer-events: none;">Kelas telah dibeli</a>
                    <?php endif; ?>
                    <div class="modal fade" id="discount" tabindex="-1" role="dialog" aria-labelledby="discountLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="discountLabel">Kode Promo</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <?= form_open('home/check_promo'); ?>
                                <div class="modal-body">
                                    <input type="text" name="promo_code" placeholder="Masukkan kode promo" class="form-control" autocomplete="off">
                                    <small class="text-danger">* kosongkan jika tidak ada</small>
                                </div>
                                <div class="modal-footer">
                                    <input type="submit" href="<?= site_url('cart'); ?>" class="btn clever-btn" value="Buy course">
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ##### Courses Content End ##### -->
<?= $this->endSection(); ?>