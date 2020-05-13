<div class="content-wrapper" style="min-height: 946px;">
    <!-- Content Header (Page header) -->

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <?php $this->load->view('setting/sidebar'); ?>
            <div class="col-md-10">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo $this->lang->line('language_list'); ?></h3>

                        <div class="box-tools pull-right">
                            <div class="box-tools pull-right">
                               <!--  <a href="<?php echo base_url(); ?>admin/language/create" class="btn btn-primary btn-sm"  data-toggle="tooltip" title="<?php echo $this->lang->line('add'); ?>" >
                                    <i class="fa fa-plus"></i> <?php echo $this->lang->line('add'); ?>
                                </a> -->
                                <a href="#" data-target="#myModal" class="btn btn-primary btn-sm"  data-toggle="modal" title="<?php echo $this->lang->line('add'); ?>" >
                                    <i class="fa fa-plus"></i> <?php echo $this->lang->line('add'); ?>
                                </a>
                            </div>
                        </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="alert alert-warning">
                            To change language key phrases, go your language directory e.g. for English language go edit file  /application/language/English/app_files/system_lang.php
                        </div>
                        <?php if ($this->session->flashdata('msg')) { ?>
                            <?php echo $this->session->flashdata('msg') ?>
                        <?php } ?>
                        <div class="table-responsive mailbox-messages">
                            <table class="table table-hover table-striped">
                                <tbody>
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo $this->lang->line('language'); ?></th>
                                        <th><?php echo $this->lang->line('status'); ?></th>
                                        <th class="text-right"><?php echo $this->lang->line('action'); ?></th>
                                    </tr>
                                    <?php
                                    $count = 1;
                                    foreach ($languagelist as $language) {
                                        ?>
                                        <tr>
                                            <td><?php echo $count . "."; ?></td>
                                            <td class="mailbox-name"> <?php echo $language['language'] ?></td>
                                            <td class="mailbox-name"><?php
                                                if ($this->customlib->getSessionLanguage() == $language['id']) {
                                                    ?>
                                                    <span class="label bg-green"><?php echo $this->lang->line('active'); ?></span>
                                                    <?php
                                                } else {
                                                    
                                                }
                                                ?></td>
                                            <td class="mailbox-date pull-right">
                                                <?php if ($this->customlib->getSessionLanguage() != $language['id']) {
                                                    ?>
                                                    <a class="btn btn-primary btn-xs text-right" href="<?php echo base_url() . "admin/language/active_language/" . $language["id"] ?>">Active</a>
                                                <?php } ?>
                                            </td>

                                        </tr>
                                        <?php
                                        $count++;
                                    }
                                    ?>

                                </tbody>
                            </table><!-- /.table -->
                        </div><!-- /.mail-box-messages -->
                    </div><!-- /.box-body -->
                    <div class="box-footer">
                        <div class="mailbox-controls">
                        </div>
                    </div>
                </div>
            </div>
        </div>   <!-- /.row -->
    </section><!-- /.content -->
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm400" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="box-title"> <?php echo $this->lang->line('add') . " " . $this->lang->line('language'); ?></h4> 
            </div>

            <div class="modal-body pt0 pb0">
                <form id="addlanguage"  class="ptt10" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo $this->lang->line('language'); ?></label>
                                <input id="invoice_no" name="language" placeholder="" type="text" class="form-control"  value="<?php echo set_value('language'); ?>" />

                            </div>
                        </div>

                    </div><!-- /.box-body -->
                    <div class="box-footer">
                        <div class="pull-right ">
                            <button type="submit" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<script type="text/javascript">
    $(document).ready(function (e) {
        $("#addlanguage").on('submit', (function (e) {
            e.preventDefault();
            $.ajax({
                url: '<?php echo base_url(); ?>admin/language/create',
                type: "POST",
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {

                    //alert(data);
                    if (data.status == "fail") {
                        var message = "";
                        $.each(data.error, function (index, value) {
                            $("." + index).html(value);
                            message += value;

                        });
                        errorMsg(message);
                    } else {
                        successMsg(data.message);
                        window.location.reload(true);
                    }
                },
                error: function () {
                    alert("Fail")
                }
            });
        }));
    });
</script>           