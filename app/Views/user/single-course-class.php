<?= $this->extend('_template/template_user'); ?>

<?= $this->section('main'); ?>
<style>
.rating {
    float:left;
    width:300px;
}
.rating span { float:right; position:relative; }
.rating span input {
    position:absolute;
    top:0px;
    left:0px;
    opacity:0;
}
.rating span label {
    display:inline-block;
    width:30px;
    height:30px;
    text-align:center;
    color:#FFF;
    background:#ccc;
    font-size:30px;
    margin-right:2px;
    line-height:30px;
    border-radius:50%;
    -webkit-border-radius:50%;
}
.rating span:hover ~ span label,
.rating span:hover label,
.rating span.checked label,
.rating span.checked ~ span label {
    background:#F90;
    color:#FFF;
}
</style>
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

                            <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab--1">
                                <div class="clever-description">

                                    <!-- About Course -->
                                    <div class="about-course mb-30">
                                        <h4>Testimonials</h4>
                                        <div class="row">
                                            <?php foreach ($testimonial as $testi) : ?>
                                                <div class="col-lg-12">
                                                    <div class="single-instructor d-flex align-items-center mb-30">
                                                        <div class="instructor-thumb h-100 pt-3 pb-3 pl-3">
                                                            
                                                        </div>
                                                        <div class="instructor-info">
                                                            <b><?= $testi->full_name; ?></b>
                                                            <br/>
                                                            <br/>
                                                            <?php
                                                            for( $x = 0; $x < $testi->rating ; $x++ )
                                                            {
                                                               echo '<li style="list-style-type:none; float:left;"><i class="fa fa-star"></i></li>'; 
                                                            }
                                                            ?>
                                                            <br/>

                                                            <h5><?= $testi->judul; ?></h5>
                                                            <p><?= $testi->deskripsi; ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                            <?php if ($status == '1') : ?>
                                                <form action="<?= site_url('home/tambahTestimonial/'.$course->class_id)?>" class='stars' method="post" accept-charset="utf-8" enctype="multipart/form-data">
                                                        </div>
                                                        <div class="instructor-info">
                                                        <div class="form-group">
                                                            <div class="rating">
                                                                <span><input type="radio" name="rating" id="str5" value="5"><label for="str5"><i class="fa fa-star"></i></label></span>
                                                                <span><input type="radio" name="rating" id="str4" value="4"><label for="str4"><i class="fa fa-star"></i></label></span>
                                                                <span><input type="radio" name="rating" id="str3" value="3"><label for="str3"><i class="fa fa-star"></i></label></span>
                                                                <span><input type="radio" name="rating" id="str2" value="2"><label for="str2"><i class="fa fa-star"></i></label></span>
                                                                <span><input type="radio" name="rating" id="str1" value="1"><label for="str1"><i class="fa fa-star"></i></label></span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" id="judul" aria-describedby="judul" placeholder="Enter judul" name="judul">
                                                        </div>
                                                        <div class="form-group">
                                                            <textarea name="deskripsi" class="form-control" placeholder="Enter deskripsi"></textarea> 
                                                        </div>
                                                        <div class="col-lg-12 text-left">
                                                            <input type="submit" class="btn clever-btn mt-5" value="Konfirmasi">
                                                        </div>
                                                
                                                </form>
                                            <?php endif; ?>
                                        </div>
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
<script type="text/javascript">
$(document).ready(function(){
    // Check Radio-box
    $(".rating input:radio").attr("checked", false);

    $('.rating input').click(function () {
        $(".rating span").removeClass('checked');
        $(this).parent().addClass('checked');
    });

    $('input:radio').change(
      function(){
        var userRating = this.value;
        alert(userRating);
    }); 
});
</script>
<!-- ##### Courses Content End ##### -->
<?= $this->endSection(); ?>