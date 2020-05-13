<style type="text/css">
    .material-switch > input[type="checkbox"] {
        display: none;
    }

    .material-switch > label {
        cursor: pointer;
        height: 0px;
        position: relative;
        width: 40px;
    }

    .material-switch > label::before {
        background: rgb(0, 0, 0);
        box-shadow: inset 0px 0px 10px rgba(0, 0, 0, 0.5);
        border-radius: 8px;
        content: '';
        height: 16px;
        margin-top: -8px;
        position:absolute;
        opacity: 0.3;
        transition: all 0.4s ease-in-out;
        width: 40px;
    }
    .material-switch > label::after {
        background: rgb(255, 255, 255);
        border-radius: 16px;
        box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
        content: '';
        height: 24px;
        left: -4px;
        margin-top: -8px;
        position: absolute;
        top: -4px;
        transition: all 0.3s ease-in-out;
        width: 24px;
    }
    .material-switch > input[type="checkbox"]:checked + label::before {
        background: inherit;
        opacity: 0.5;
    }
    .material-switch > input[type="checkbox"]:checked + label::after {
        background: inherit;
        left: 20px;
    }
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">


    <!-- Main content -->
    <section class="content">
        <div class="row">
            <?php $this->load->view('setting/sidebar') ?>
            <!-- left column -->
            <div class="col-md-10">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header ptbnull">
                        <h3 class="box-title titlefix"><?php echo $this->lang->line('front_cms_setting'); ?></h3>
                        <div class="box-tools pull-right">
                        </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="">
                        <form role="form" id="custom" action="<?php echo site_url('admin/frontcms') ?>" class="form-horizontal" method="post" enctype="multipart/form-data">
                            <div class="box-body">
                                <?php if ($this->session->flashdata('msg')) {
                                    ?>
                                    <?php echo $this->session->flashdata('msg') ?>
                                    <?php
                                }
                                ?>


                                <div class="row">
                                    <div class="">
                                        <div class="col-md-7">
                                            <input type="hidden" name="id" value="<?php echo set_value('id', $frontcmslist->id) ?>">
                                            <div class="form-group">
                                                <label class="col-sm-5 control-label"><?php echo $this->lang->line('front_cms'); ?></label>
                                                <div class="col-sm-7">
                                                    <div class="material-switch">
                                                        <input id="enable_frontcms" name="is_active_front_cms" type="checkbox" class="chk" value="1" <?php echo set_checkbox('is_active_front_cms', '1', (set_value('is_active_front_cms', $frontcmslist->is_active_front_cms) == 1) ? true : false); ?>>
                                                        <label for="enable_frontcms" class="label-success"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-5 control-label"><?php echo $this->lang->line('sidebar'); ?></label>
                                                <div class="col-sm-7">
                                                    <div class="material-switch">
                                                        <input id="enable_sidebar" name="is_active_sidebar" type="checkbox" class="chk" value="1" <?php echo set_checkbox('is_active_sidebar', '1', (set_value('is_active_sidebar', $frontcmslist->is_active_sidebar) == 1) ? true : false); ?>>
                                                        <label for="enable_sidebar" class="label-success"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-5 control-label"><?php echo $this->lang->line('language_rtl_text_mode'); ?></label>
                                                <div class="col-sm-7">
                                                    <div class="material-switch">
                                                        <input id="enable_rtl" name="is_active_rtl" type="checkbox" class="chk" value="1" <?php echo set_checkbox('is_active_rtl', '1', (set_value('is_active_rtl', $frontcmslist->is_active_rtl) == 1) ? true : false); ?>>
                                                        <label for="enable_rtl" class="label-success"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-5 control-label"><?php echo $this->lang->line('sidebar_option'); ?></label>
                                                <div class="col-sm-7">
                                                    <label class="checkbox-inline">
                                                        <input type="checkbox" name="sidebar_options[]" value="news" <?php echo set_checkbox('sidebar_options[]', 'news', (set_value('sidebar_options[]', in_array("news", json_decode($frontcmslist->sidebar_options))) == 1) ? true : false); ?>> <?php echo $this->lang->line('notice'); ?>
                                                    </label>
                                                    <label class="checkbox-inline">
                                                        <input type="checkbox" name="sidebar_options[]" value="complain" <?php echo set_checkbox('sidebar_options[]', 'complain', (set_value('sidebar_options[]', in_array("complain", json_decode($frontcmslist->sidebar_options))) == 1) ? true : false); ?>> <?php echo $this->lang->line('complain'); ?>
                                                    </label>
                                                </div>
                                            </div>



                                            <div class="form-group hide">
                                                <label class="col-sm-5 control-label">Contact us Page Email --r </label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control" name="contact_us_email" value="<?php echo set_value('contact_us_email', $frontcmslist->contact_us_email) ?>">
                                                    <span class="text text-danger"></span>
                                                </div>

                                            </div>
                                            <div class="form-group hide">
                                                <label class="col-sm-5 control-label">Complain Page Email --r </label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control" name="complain_form_email" value="<?php echo set_value('complain_form_email', $frontcmslist->complain_form_email) ?>">
                                                    <span class="text text-danger"></span>
                                                </div>

                                            </div>


                                            <div class="form-group">
                                                <label class="col-sm-5 control-label"><?php echo $this->lang->line('logo'); ?> (369px X 76px)<?php //echo base_url($frontcmslist->logo);   ?></label>
                                                <div class="col-sm-7">
                                                    <input type="file" class="filestyle form-control-file" name="logo" id="exampleInputFile" data-height="100" data-default-file="<?php echo base_url($frontcmslist->logo); ?>">
                                                    <span class="text-danger"><?php echo form_error('logo'); ?></span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-5 control-label"><?php echo $this->lang->line('favicon'); ?> (32px X 32px)</label>
                                                <div class="col-sm-7">
                                                    <input type="file" class="filestyle form-control-file" name="fav_icon" id="exampleInputFile" data-height="50" data-default-file="<?php echo base_url($frontcmslist->fav_icon); ?>">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-5 control-label"><?php echo $this->lang->line('footer_text'); ?></label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control" name="footer_text" value="<?php echo set_value('footer_text', $frontcmslist->footer_text) ?>">
                                                    <span class="text text-danger"></span>
                                                </div>

                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-5 control-label"><?php echo $this->lang->line('google_analytics'); ?> </label>
                                                <div class="col-sm-7">
                                                    <textarea class="form-control" name="google_analytics" rows="5"><?php echo set_value('google_analytics', $frontcmslist->google_analytics) ?></textarea>

                                                    <span class="text text-danger"></span>
                                                </div>

                                            </div>


                                        </div><!--./col-md-7-->
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label class="col-sm-5 control-label"><?php echo $this->lang->line('facebook_url'); ?> </label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control" name="fb_url" value="<?php echo set_value('fb_url', $frontcmslist->fb_url) ?>">
                                                    <span class="text text-danger"></span>
                                                </div>

                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-5 control-label"><?php echo $this->lang->line('twitter_url'); ?> </label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control" name="twitter_url" value="<?php echo set_value('twitter_url', $frontcmslist->twitter_url) ?>">
                                                    <span class="text text-danger"></span>
                                                </div>

                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-5 control-label"><?php echo $this->lang->line('youtube_url'); ?> </label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control" name="youtube_url" value="<?php echo set_value('youtube_url', $frontcmslist->youtube_url) ?>">
                                                    <span class="text text-danger"></span>
                                                </div>

                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-5 control-label"><?php echo $this->lang->line('google_plus_url'); ?> </label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control" name="google_plus" value="<?php echo set_value('google_plus', $frontcmslist->google_plus) ?>">
                                                    <span class="text text-danger"></span>
                                                </div>

                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-5 control-label"><?php echo $this->lang->line('linkedin_url'); ?> </label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control" name="linkedin_url" value="<?php echo set_value('linkedin_url', $frontcmslist->linkedin_url) ?>">
                                                    <span class="text text-danger"></span>
                                                </div>

                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-5 control-label"><?php echo $this->lang->line('instagram_url'); ?> </label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control" name="instagram_url" value="<?php echo set_value('instagram_url', $frontcmslist->instagram_url) ?>">
                                                    <span class="text text-danger"></span>
                                                </div>

                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-5 control-label"><?php echo $this->lang->line('pinterest_url'); ?> </label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control" name="pinterest_url" value="<?php echo set_value('pinterest_url', $frontcmslist->pinterest_url) ?>">
                                                    <span class="text text-danger"></span>
                                                </div>

                                            </div>
                                        </div><!--./col-md-5-->

                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <hr/>
                                <div class="">
                                    <div class="">
                                        <label for="input-type"><?php echo $this->lang->line('current_theme'); ?></label>
                                        <div id="input-type" class="mediarow">
                                            <div class="row">
                                                <?php
                                                foreach ($front_themes as $theme_key => $theme_value) {
                                                    ?>
                                                    <div class="col-sm-2 col-xs-4 img_div_modal">
                                                        <label class="radio-img">
                                                            <input name="theme"  value="<?php echo $theme_key; ?>" type="radio" <?php echo set_radio('theme', $theme_key, (set_value('theme', $frontcmslist->theme) == $theme_key) ? true : false); ?> />

                                                            <img src="<?php echo base_url('backend/images/front_theme/' . $theme_value); ?>">
                                                        </label>
                                                    </div>
                                                    <?php
                                                }
                                                ?>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- /.box-body -->

                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary pull-right">Save</button>&nbsp;&nbsp;<span class="custom_loader"></span>
                            </div>
                        </form>
                    </div><!-- /.box-body -->
                </div>
            </div><!--/.col (left) -->
            <!-- right column -->

        </div>

    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
