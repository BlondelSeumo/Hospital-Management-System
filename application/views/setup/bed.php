<div class="content-wrapper" style="min-height: 348px;">  
    <section class="content">
        <div class="row">
            <div class="col-md-2">
                <?php
                $this->load->view('setup/bedsidebar');
                ?>
            </div>
            <div class="col-md-10">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title titlefix"><?php echo $this->lang->line('bed') . " " . $this->lang->line('list'); ?></h3>
                        <div class="box-tools pull-right">
                            <?php if ($this->rbac->hasPrivilege('bed', 'can_add')) { ?>
                                <a data-toggle="modal" data-target="#myModal" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> <?php echo $this->lang->line('add'); ?></a>  
                            <?php } ?> 
                        </div><!-- /.box-tools -->
                    </div>                  
                    <div class="box-body">
                        <div class="download_label"><?php echo $this->lang->line('bed') . " " . $this->lang->line('list'); ?></div>
                        <div class="table-responsive mailbox-messages">
                            <table class="table table-hover table-striped table-bordered example">
                                <thead>
                                    <tr>                                    
                                        <th><?php echo $this->lang->line('name'); ?></th>
                                        <th><?php echo $this->lang->line('bed') . " " . $this->lang->line('type'); ?></th>
                                        <th><?php echo $this->lang->line('bed') . " " . $this->lang->line('group'); ?></th>

                                        <th class="text-right"><?php echo $this->lang->line('action'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (empty($bed_list)) {
                                        ?>
                                        <?php
                                    } else {
                                        foreach ($bed_list as $key => $value) {
                                            ?>
                                            <tr>
                                                <td class="mailbox-name">
                                                    <a href="#" data-toggle="popover" class="detail_popover"><?php echo $value['name'] ?></a>

                                                </td>
                                                <td><?php echo $value['bed_type_name']; ?></td>
                                                <td><?php echo $value['bedgroup'] . " - " . $value['floor_name']; ?></td>
                                                <td class="mailbox-date pull-right">
                                                    <?php if ($this->rbac->hasPrivilege('bed', 'can_edit')) { ?>
                                                        <a href="#" onclick="getRecord('<?php echo $value['id'] ?>')" class="btn btn-default btn-xs" data-target="#myModalEdit" data-toggle="tooltip" title="" data-original-title="<?php echo $this->lang->line('edit'); ?>">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                                                    <?php } ?>
                                                    <?php if ($this->rbac->hasPrivilege('bed', 'can_delete')) { ?>
                                                        <a  class="btn btn-default btn-xs" data-toggle="tooltip" title="" onclick="delete_recordById('<?php echo base_url(); ?>admin/setup/bed/delete/<?php echo $value['id']; ?>', '<?php echo $this->lang->line('delete_message') ?>')" data-original-title="<?php echo $this->lang->line('delete') ?>">
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
    <div class="modal-dialog modal-sm400" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="box-title"> <?php echo $this->lang->line('add') . " " . $this->lang->line('bed'); ?></h4> 
            </div>

            <div class="modal-body pt0 pb0">
                <form id="addbed"  class="ptt10" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                    <div class="row">
                        <div class=""   id="edit_bedtypedata">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('name'); ?></label>
                                    <span class="req"> *</span>
                                    <input  name="name" placeholder="" type="text" class="form-control"  value="<?php echo set_value('name'); ?>" />

                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('bed') . " " . $this->lang->line('type'); ?></label>
                                    <span class="req"> *</span>
                                    <select name="bed_type" id="bed_type" class="form-control">
                                        <option value=""><?php echo $this->lang->line('select'); ?></option>
                                        <?php foreach ($bedtype_list as $value) { ?>
                                            <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>

                                        <?php } ?>
                                    </select>

                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('bed') . " " . $this->lang->line('group'); ?></label><span class="req"> *</span>
                                    <select name="bed_group" id="bed_group" class="form-control">
                                        <option value=""><?php echo $this->lang->line('select'); ?></option>
                                        <?php foreach ($bedgroup_list as $bedg) { ?>
                                            <option value="<?php echo $bedg['id']; ?>"><?php echo $bedg['name'] . " - " . $bedg['floor_name']; ?></option>

                                        <?php } ?>
                                    </select>

                                </div>
                            </div>



                            <div class="box-footer clear">
                                <div class="pull-right">
                                    <button type="submit" id="addbedbtn" data-loading-text="<?php echo $this->lang->line('processing') ?>" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                                </div>
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
</div>

<div class="modal fade" id="myModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm400" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="box-title"><?php echo $this->lang->line('edit') . " " . $this->lang->line('bed'); ?></h4> 
            </div>


            <form id="editbed" class="" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                <div class="modal-body pt0 pb0">
                    <div class="ptt10 row" id="edit_bedtypedata">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo $this->lang->line('name'); ?></label>
                                <span class="req"> *</span>
                                <input id="name" name="name" placeholder="" type="text" class="form-control"  value="<?php echo set_value('name'); ?>" />
                                <input id="bedid" name="bedid" placeholder="" type="hidden" class="form-control"  />
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo $this->lang->line('bed') . " " . $this->lang->line('type'); ?></label><span class="req"> *</span>
                                <select name="bed_type" id="bedtype" class="form-control">
                                    <option value=""><?php echo $this->lang->line('select'); ?></option>
                                    <?php foreach ($bedtype_list as $value) { ?>
                                        <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>

                                    <?php } ?>
                                </select>                                 
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo $this->lang->line('bed') . " " . $this->lang->line('group'); ?></label><span class="req"> *</span>
                                <select name="bed_group" id="bedgroup" class="form-control">
                                    <option value=""><?php echo $this->lang->line('select'); ?></option>
                                    <?php foreach ($bedgroup_list as $value) { ?>
                                        <option value="<?php echo $value['id']; ?>"><?php echo $value['name'] . " - " . $value['floor_name']; ?></option>

                                    <?php } ?>
                                </select>                                 
                            </div>
                        </div>

                    </div>
                </div>
                <div class="box-footer clear">
                    <div class="pull-right">
                        <button type="submit" data-loading-text="<?php echo $this->lang->line('processing') ?>" id="editbedbtn" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                    </div>
                </div>

            </form>





        </div>
        </form>
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

    function getbedcat(cate) {

        $.ajax({
            url: '<?php echo base_url() ?>admin/setup/bed/getbed_categore_type/' + cate,
            success: function (data) {
                //alert(data);
                $('#bed_categore_type').html(data);

            }
        });
    }

    $(document).ready(function (e) {// e mai functiojn ki defination aa gye
        $('#addbed').on('submit', (function (e) {
            $("#addbedbtn").button('loading');
            e.preventDefault();
            $.ajax({
                url: '<?php echo base_url(); ?>admin/setup/bed/add',
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
                url: '<?php echo base_url(); ?>admin/setup/bed/update',
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
            url: '<?php echo base_url(); ?>admin/setup/bed/get/' + id,
            type: "POST",
            dataType: "json",
            success: function (data) {

                $("#name").val(data.name);
                $("#bedid").val(id);
                $("#bedtype").val(data.bed_type_id);
                $("#bedgroup").val(data.bed_group_id);

            },
            error: function () {
                alert("Fail")
            }

        })

    }
</script>