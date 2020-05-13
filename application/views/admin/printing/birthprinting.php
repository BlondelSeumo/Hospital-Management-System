<div class="content-wrapper" style="min-height: 348px;">  
    <section class="content">
        <div class="row">
            <div class="col-md-2">
                <?php
                $this->load->view('admin/printing/sidebar');
                ?>
            </div>
            <div class="col-md-10">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title titlefix"><?php echo $this->lang->line('birth') . " " . $this->lang->line('header') . " " . $this->lang->line('footer'); ?></h3>
                        <?php if (empty($printing_list)) { ?>
                            <div class="box-tools pull-right">
                                <?php if ($this->rbac->hasPrivilege('birth_print_header_footer', 'can_add')) { ?>
                                    <a data-toggle="modal" data-target="#myModal" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> <?php echo $this->lang->line('add'); ?></a> 
                                <?php } ?>  
                            </div><!-- /.box-tools -->
                        <?php } ?>
                    </div>                  
                    <div class="box-body">
                        <div class="download_label"><?php echo $this->lang->line('birth') . " " . $this->lang->line('header') . " " . $this->lang->line('footer'); ?></div>
                        <div class="table-responsive mailbox-messages">
                            <table class="table table-hover table-striped table-bordered example">
                                <thead>
                                    <tr>                                    

                                        <th><?php echo $this->lang->line('header'); ?></th>
                                        <th><?php echo $this->lang->line('footer'); ?></th>
                                        <th class="text-right"><?php echo $this->lang->line('action'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (empty($printing_list)) {
                                        ?>
                                        <?php
                                    } else {
                                        foreach ($printing_list as $key => $value) {
                                            ?>
                                            <tr>
                                                <td class="mailbox-name">
                                                    <a href="#" data-toggle="popover" class="detail_popover"><img src="<?php echo base_url() . $value['print_header'] ?>" style="width: 370px;height: 50px;"></a>
                                                </td>
                                                <td><?php echo $value['print_footer']; ?></td>

                                                <td class="mailbox-date pull-right">
                                                    <?php if ($this->rbac->hasPrivilege('birth_print_header_footer', 'can_edit')) { ?>
                                                        <a href="#" onclick="getRecord('<?php echo $value['id'] ?>')" class="btn btn-default btn-xs" data-target="#myModalEdit" data-toggle="tooltip" title="" data-original-title="<?php echo $this->lang->line('edit'); ?>">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                                                    <?php } ?>
                                                    <?php if ($this->rbac->hasPrivilege('birth_print_header_footer', 'can_delete')) { ?>
                                                        <a href="#" class="btn btn-default btn-xs" data-toggle="tooltip" title="" onclick="delete_record('<?php echo $value['id'] ?>');" data-original-title="<?php echo $this->lang->line('delete'); ?>">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table><!-- /.table -->
                        </div><!-- /.mail-box-messages -->
                    </div><!-- /.box-body -->
                </div>
            </div><!--/.col (left) -->
            <!-- right column -->
        </div>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<!-- new END -->
</div><!-- /.content-wrapper -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="box-title"> <?php echo $this->lang->line('print') . " " . $this->lang->line('setting'); ?></h4> 
            </div>
            <form id="addbed" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                <div class="modal-body pt0 pb0">
                    <div class="ptt10">
                        <div class="row" id="edit_bedtypedata">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('header'); ?> (2230px X 300px)</label><span class="req"> *</span>
                                    <input  name="print_header" placeholder="" type="file" class="form-control filestyle" />
                                    <span class="text-danger name"></span>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('footer'); ?></label>
                                    <textarea  name="print_footer"  type="text" class="form-control editor"></textarea>
                                    <input  name="setting_for" placeholder="" value="birth" type="hidden" class="form-control"   />
                                    <span class="text-danger name"></span>
                                </div>
                            </div>
                        </div>
                    </div>  
                </div>    
                <div class="box-footer">
                    <div class="pull-right">
                        <button type="submit" data-loading-text="<?php echo $this->lang->line('processing') ?>" id="addbedbtn" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>    
</div>
</div>
</div>    
</div>

<div class="modal fade" id="myModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="box-title"><?php echo $this->lang->line('print') . " " . $this->lang->line('setting'); ?></h4> 
            </div>

            <form id="editbed" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                <div class="modal-body pt0 pb0">
                    <div class="ptt10">
                        <div class="row" id="edit_bedtypedata">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('header'); ?> (2230px X 300px)</label>
                                    <input  name="print_header"  placeholder="" type="file" class="form-control filestyle"   />
                                    <span class="text-danger name"></span>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <img src="#" class="img-responsive" id="header_image" >
                                <br/>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('footer'); ?></label>
                                    <textarea name="print_footer" id="print_footer" placeholder="" type="text" class="form-control editor" ></textarea>
                                    <input  name="previous_header" id="print_header" placeholder="" type="hidden" class="form-control"   />
                                    <input  name="printid" id="printid" placeholder="" type="hidden" class="form-control"   />

                                    <span class="text-danger name"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>  

                <div class="box-footer clear ">
                    <div class="pull-right ">
                        <button type="submit" id="editbedbtn" data-loading-text="<?php echo $this->lang->line('processing') ?>" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('.detail_popover').popover({
            placement: 'right',
            trigger: 'hover',
            container: 'body',
            html: true,
            content: function () {
                return $(this).closest('td').find('.fee_detail_popover').html();
            }
        });
    });

    $(function () {
        $(".editor").wysihtml5({
            toolbar: {
                "image": false,
            }
        });
    });
    $(document).ready(function (e) {// e mai functiojn ki defination aa gye
        $('#addbed').on('submit', (function (e) {
            $("#addbedbtn").button('loading');
            e.preventDefault();
            $.ajax({
                url: '<?php echo base_url(); ?>admin/printing/add',
                type: "POST",
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {

                    // alert(data);
                    if (data.status == "fail") {
                        var message = "";
                        $.each(data.error, function (index, value) {
                            //alert(index);
                            $('.' + index).html(value);
                            message += value;
                        });
                        // alert(message);
                        errorMsg(message);
                    } else {
                        successMsg(data.message);
                        window.location.reload(true);
                    }
                    $("#addbedbtn").button('reset');
                },
                error: function () {
                    alert("Fail")
                }
            });


        }));

    });


    $(document).ready(function (e) {// e mai functiojn ki defination aa gye
        $('#editbed').on('submit', (function (e) {
            $("#editbedbtn").button('loading');
            e.preventDefault();
            $.ajax({
                url: '<?php echo base_url(); ?>admin/printing/update',
                type: "POST",
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {

                    // alert(data);
                    if (data.status == "fail") {
                        var message = "";
                        $.each(data.error, function (index, value) {
                            message += value;
                        });
                        errorMsg(message);
                    } else {
                        successMsg(data.message);
                        window.location.reload(true);
                    }
                    $("#editbedbtn").button('reset');
                },
                error: function () {
                    alert("Fail")
                }
            });


        }));

    });

    function getRecord(id) {

        $('#myModalEdit').modal('show');
        $.ajax({
            url: '<?php echo base_url(); ?>admin/printing/getRecord/' + id,
            type: "POST",
            dataType: "json",
            success: function (data) {
                $("#print_header").val(data.print_header);
                $("#printid").val(id);
                $("#print_footer").val(data.print_footer);
                $("#header_image").attr("src", '<?php echo base_url() ?>' + data.print_header)
                $('.wysihtml5-sandbox').contents().find('.wysihtml5-editor').html(data.print_footer);
            },
            error: function () {
                alert("Fail")
            }

        })

    }
    function delete_record(id) {
        if (confirm('<?php echo $this->lang->line('delete_conform') ?>')) {
            $.ajax({
                url: '<?php echo base_url(); ?>admin/printing/delete/' + id,
                type: "POST",
                data: {opdid: ''},
                dataType: 'json',
                success: function (data) {
                    successMsg('<?php echo $this->lang->line('delete_message'); ?>');
                    window.location.reload(true);
                }
            })
        }
    }
</script>