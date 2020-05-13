
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
                        <h3 class="box-title titlefix"><?php echo $this->lang->line('bed') . " " . $this->lang->line('group') . " " . $this->lang->line('list'); ?></h3>
                        <div class="box-tools pull-right">
                            <?php if ($this->rbac->hasPrivilege('bed', 'can_add')) { ?>
                                <a data-toggle="modal" data-target="#myModal" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> <?php echo $this->lang->line('add'); ?></a> 
                            <?php } ?>


                        </div><!-- /.box-tools -->
                    </div>

                    <div class="box-body">
                        <div class="download_label"><?php echo $this->lang->line('bed') . " " . $this->lang->line('group') . " " . $this->lang->line('list'); ?></div>
                        <div class="table-responsive mailbox-messages">
                            <table class="table table-hover table-striped table-bordered example">
                                <thead>
                                    <tr>                                    
                                        <th><?php echo $this->lang->line('name'); ?></th>
                                        <th><?php echo $this->lang->line('floor'); ?></th>
                                        <th><?php echo $this->lang->line('description'); ?></th>
                                        <th class="text-right"><?php echo $this->lang->line('action'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (empty($bedgroup_list)) {
                                        ?>
                                        <?php
                                    } else {
                                        foreach ($bedgroup_list as $key => $value) {
                                            ?>
                                            <tr>

                                                <td class="mailbox-name">
                                                    <a href="#" ><?php echo $value['name'] ?></a>


                                                </td>
                                                <td class="mailbox-date">
                                                    <?php echo $value["floor_name"] ?>
                                                </td>  
                                                <td class="mailbox-date">
                                                    <?php echo $value["description"] ?>
                                                </td>                                                

                                                <td class="mailbox-date pull-right">
                                                    <?php if ($this->rbac->hasPrivilege('bed', 'can_edit')) { ?>
                                                        <a  data-target="#myeditModal" onclick="edit(<?php echo $value['id']; ?>)"  class="btn btn-default btn-xs" data-toggle="tooltip" title="" data-original-title="<?php echo $this->lang->line('edit'); ?>">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                                                    <?php } ?>
                                                    <?php if ($this->rbac->hasPrivilege('bed', 'can_delete')) { ?>
                                                        <a  class="btn btn-default btn-xs" data-toggle="tooltip" title="" onclick="delete_recordById('<?php echo base_url(); ?>admin/setup/bedgroup/delete_bedgroup/<?php echo $value['id']; ?>', '<?php echo $this->lang->line('delete_message') ?>')" data-original-title="<?php echo $this->lang->line('delete') ?>">
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
                <h4 class="box-title"> <?php echo $this->lang->line('add') . " " . $this->lang->line('bed') . " " . $this->lang->line('group'); ?></h4> 
            </div>
            <div class="modal-body pt0 pb0">
                <div class="">
                    <div class=""   id="edit_expensedata">
                        <form id="addward"  class="ptt10" method="post"  accept-charset="utf-8" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('name'); ?></label>
                                        <span class="req"> *</span>
                                        <input  name="name" placeholder="" type="text" class="form-control"  value="<?php echo set_value('invoice_no'); ?>" />
                                        <span class="text-danger name"></span>

                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('floor'); ?></label>
                                        <span class="req"> *</span>
                                        <select name="floor" class="form-control">
                                            <option value=""><?php echo $this->lang->line('select') ?></option>
                                            <?php foreach ($floor as $key => $floorvalue) {
                                                ?>
                                                <option value="<?php echo $floorvalue["id"] ?>"><?php echo $floorvalue["name"] ?></option>
                                            <?php } ?>
                                        </select>
                                        <span class="text-danger floor"></span>

                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('description'); ?></label>
                                        <textarea class="form-control"  name="description" placeholder="" rows="2" placeholder="Enter ..."><?php echo set_value('description'); ?><?php echo set_value('description') ?></textarea>
                                        <span class="text-danger description"></span>

                                    </div>
                                </div>
                            </div><!-- /.box-body -->
                            <div class="box-footer">
                                <div class="pull-right">
                                    <button type="submit" data-loading-text="<?php echo $this->lang->line('processing') ?>" id="addwardbtn" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>    
</div>

<div class="modal fade" id="myeditModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm400" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="box-title"> <?php echo $this->lang->line('edit') . " " . $this->lang->line('bed') . " " . $this->lang->line('group'); ?></h4> 
            </div>

            <div class="modal-body pt0 pb0">
                <div class="row">
                    <form id="editbedgroup"  class="ptt10" method="post"  accept-charset="utf-8" enctype="multipart/form-data">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo $this->lang->line('name'); ?></label>
                                <span class="req"> *</span>
                                <input id="name" name="name" placeholder="" type="text" class="form-control"  value="<?php echo set_value('name'); ?>" />
                                <input type="hidden" id="id" name="id">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo $this->lang->line('floor'); ?></label>
                                <span class="req"> *</span>
                                <select name="floor" id="floor" class="form-control">
                                    <option value=""><?php echo $this->lang->line('select') ?></option>
                                    <?php foreach ($floor as $key => $floorvalue) {
                                        ?>
                                        <option value="<?php echo $floorvalue["id"] ?>"><?php echo $floorvalue["name"] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo $this->lang->line('description'); ?></label>
                                <textarea class="form-control" id="description" name="description" placeholder="" rows="2" placeholder="Enter ..."><?php echo set_value('description'); ?><?php echo set_value('description') ?></textarea>

                            </div>
                        </div>
                        <div class="box-footer">
                            <div class="pull-right">
                                <button type="submit" id="editbedgroupbtn" data-loading-text="<?php echo $this->lang->line('processing') ?>" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                            </div>
                        </div>
                    </form>
                </div><!-- /.box-body -->
            </div>

        </div>
    </div>    
</div>
<script>
    $(document).ready(function (e) {
        $("#addward").on('submit', (function (e) {
            e.preventDefault();
            $("#addwardbtn").button('loading');
            $.ajax({
                url: '<?php echo base_url(); ?>admin/setup/bedgroup/add_bed_group',
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
                            // $("."+index).html(value);
                            message += value;
                        });
                        errorMsg(message);
                    } else {
                        successMsg(data.message);
                        window.location.reload(true);
                    }
                    $("#addwardbtn").button('reset');
                },
                error: function () {
                    alert("Fail")
                }
            });
        }));
    });



    function edit(id) {
        $('#myeditModal').modal('show');
        $.ajax({
            url: '<?php echo base_url(); ?>admin/setup/bedgroup/getbedgroupdata/' + id,
            dataType: 'json',
            success: function (data) {
                console.log(data);
                $('#id').val(data.id);
                $('#name').val(data.name);
                $('#floor').val(data.floor);
                $('#description').val(data.description);

            }

        });

    }

    $(document).ready(function (e) {
        $("#editbedgroup").on('submit', (function (e) {
            $("#editbedgroupbtn").button('loading');
            e.preventDefault();
            $.ajax({
                url: '<?php echo base_url(); ?>admin/setup/bedgroup/update_bedgroup',
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
                            message += value;
                        });
                        errorMsg(message);
                    } else {
                        successMsg(data.message);
                        window.location.reload(true);
                    }
                    $("#editbedgroupbtn").button('reset');
                },
                error: function () {
                    alert("Fail")
                }
            });
        }));
    });
</script>