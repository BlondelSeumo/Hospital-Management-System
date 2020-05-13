<?php
if (isset($banner_images) && !empty($banner_images)) {
    ?>
    <div id="bootstrap-touch-slider" class="carousel bs-slider slide  control-round" data-ride="carousel" data-interval="8000">
        <div class="carousel-inner">
            <?php
            $banner_first = TRUE;
            foreach ($banner_images as $banner_img_key => $banner_img_value) {
                ?>
                <div class="item <?php if ($banner_first) echo 'active'; ?>">
                    <img src="<?php echo base_url($banner_img_value->dir_path . $banner_img_value->img_name); ?>" alt="" />
                </div>
                <?php
                $banner_first = FALSE;
            }
            ?>
        </div><!--./carousel-inner-->
        <a class="left carousel-control" href="#bootstrap-touch-slider"  data-slide="prev">
            <span class="fa fa-angle-left"></span>
            <span class="sr-only">Previous</span>
        </a>
        <!-- Right Control-->
        <a class="right carousel-control" href="#bootstrap-touch-slider" data-slide="next">
            <span class="fa fa-angle-right"></span>
            <span class="sr-only">Next</span>
        </a>
    </div> <!--./bootstrap-touch-slider-->
    <?php
}
?>