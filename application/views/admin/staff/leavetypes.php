<style type="text/css">
    @media print
    {
        .no-print, .no-print *
        {
            display: none !important;
        }
    }
</style>
<div class="content-wrapper" style="min-height: 946px;">  
    <section class="content">
        <div class="row">   
            <div class="col-md-2">
                <div class="box border0">
                    <ul class="tablists">
                        <?php if ($this->rbac->hasPrivilege('leave_types', 'can_view')) { ?>
                            <li><a href="<?php echo base_url(); ?>admin/leavetypes" class="active"><?php echo $this->lang->line('leave_type'); ?></a></li>
                        <?php } ?>
                        <?php if ($this->rbac->hasPrivilege('department', 'can_view')) { ?>
                            <li><a href="<?php echo base_url(); ?>admin/department"><?php echo $this->lang->line('department'); ?></a></li>
                        <?php } if ($this->rbac->hasPrivilege('designation', 'can_view')) { ?>
                            <li><a href="<?php echo base_url(); ?>admin/designation/designation"><?php echo $this->lang->line('designation'); ?></a></li>
                        <?php } ?>                      
                    </ul>
                </div>
            </div>           
            <div class="col-md-10">              
                <div class="box box-primary" id="tachelist">
                    <div class="box-header ptbnull">
                        <h3 class="box-title titlefix"><?php echo $this->lang->line('leave_type'); ?> <?php echo $this->lang->line('list'); ?></h3>
                        <div class="box-tools pull-right">
                            <?php if ($this->rbac->hasPrivilege('leave_types', 'can_add')) { ?>
                                <a data-toggle="modal" data-target="#myModal" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>  <?php echo $this->lang->line('add'); ?> <?php echo $this->lang->line('leave_type'); ?></a> 
                            <?php } ?>    
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="mailbox-controls">
                        </div>
                        <div class="table-responsive mailbox-messages">
                            <div class="download_label"><?php echo $this->lang->line('leave_type'); ?></div>
                            <table class="table table-striped table-bordered table-hover example">
                                <thead>
                                    <tr>

                                        <th><?php echo $this->lang->line('name'); ?></th>
                                     <!--    <th><?php echo $this->lang->line('active'); ?> <?php echo $this->lang->line('status'); ?></th>
                                        -->   <th class="text-right no-print"><?php echo $this->lang->line('action'); ?>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $count = 1;
                                    foreach ($leavetype as $value) {
                                        $status = "";

                                        if ($value["is_active"] == "yes") {

                                            $status = "Active";
                                        } else {
                                            $status = "Inactive";
                                        }
                                        ?>
                                        <tr>

                                            <td class="mailbox-name"> <?php echo $value['type'] ?></td>
                                     <!--        <td><?php echo $this->lang->line($value['is_active']) ?></td>
                                            -->       <td class="mailbox-date pull-right no-print">
                                                <?php if ($this->rbac->hasPrivilege('leave_types', 'can_edit')) { ?>
                                                    <a href="#" class="btn btn-default btn-xs"  data-toggle="tooltip" onclick="get(<?php echo $value['id'] ?>)" data-target="#editmyModal" title="<?php echo $this->lang->line('edit'); ?>">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>
                                                <?php } if ($this->rbac->hasPrivilege('leave_types', 'can_delete')) { ?>
                                                    <a class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('delete'); ?>" onclick="delete_recordById('<?php echo base_url(); ?>admin/leavetypes/leavedelete/<?php echo $value['id'] ?>', '<?php echo $this->lang->line('delete_message'); ?>')";>
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    $count++;
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="">
                        <div class="mailbox-controls">
                        </div>
                    </div>
                </div>
            </div> 

        </div>
    </section>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-mid" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="box-title"> <?php echo $this->lang->line('add'); ?>  <?php echo $this->lang->line('leave_type'); ?></h4> 
            </div>



            <form id="formadd" action="<?php echo site_url('admin/leavetypes/createLeaveType') ?>"  id="employeeform" name="employeeform" method="post" accept-charset="utf-8"  enctype="multipart/form-data">
                <div class="modal-body pt0 pb0">
                    <div class="ptt10">
                        <?php if ($this->session->flashdata('msg')) { ?>
                            <?php echo $this->session->flashdata('msg') ?>
                        <?php } ?>        
                        <?php echo $this->customlib->getCSRF(); ?>
                        <div class="form-group">
                            <label for="exampleInputEmail1"><?php echo $this->lang->line('name'); ?></label><small class="req"> *</small>
                            <input autofocus="" name="type" placeholder="" type="text" class="form-control"  value="<?php
                            if (isset($result)) {
                                echo $result["type"];
                            }
                            ?>" />
                            <span class="text-danger"><?php echo form_error('type'); ?></span>


                        </div>


                    </div>
                </div><!--./modal-->        
                <div class="box-footer">
                    <button type="submit" id="formaddbtn" data-loading-text="<?php echo $this->lang->line('processing') ?>" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                </div>
            </form>


        </div><!--./row--> 
    </div>
</div>


<div class="modal fade" id="editmyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-mid" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="box-title"> <?php echo $this->lang->line('edit'); ?>  <?php echo $this->lang->line('leave_type'); ?></h4> 
            </div>



            <form id="editformadd" action="<?php echo site_url('admin/leavetypes/leaveedit') ?>"  id="employeeform" name="employeeform" method="post" accept-charset="utf-8"  enctype="multipart/form-data">
                <div class="modal-body pt0 pb0">
                    <div class="ptt10">
                        <?php if ($this->session->flashdata('msg')) { ?>
                            <?php echo $this->session->flashdata('msg') ?>
                        <?php } ?>        
                        <?php echo $this->customlib->getCSRF(); ?>
                        <div class="form-group">
                            <label for="exampleInputEmail1"><?php echo $this->lang->line('name'); ?></label><small class="req"> *</small>
                            <input autofocus="" id="type"  name="type" placeholder="" type="text" class="form-control"  />
                            <span class="text-danger"><?php echo form_error('type'); ?></span>

                            <input autofocus="" id="id"  name="leavetypeid" placeholder="" type="hidden" class="form-control"   />
                        </div>


                    </div>
                </div><!--./modal-->    
                <div class="box-footer">
                    <button type="submit" data-loading-text="<?php echo $this->lang->line('processing') ?>" id="editformaddbtn" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                </div>
            </form>


        </div><!--./row--> 
    </div>
</div>
<script>

    $(document).ready(function (e) {
        $('#formadd').on('submit', (function (e) {
            $("#formaddbtn").button('loading');
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: "POST",
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {

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
                    $("#formaddbtn").button('reset');
                },
                error: function () {

                }
            });


        }));

    });


    function get(id) {
        $('#editmyModal').modal('show');
        //alert(id);

        $.ajax({

            dataType: 'json',

            url: '<?php echo base_url(); ?>admin/leavetypes/get_type/' + id,

            success: function (result) {

                $('#id').val(result.id);
                $('#type').val(result.type);


            }

        });

    }


    $(document).ready(function (e) {
        $('#editformadd').on('submit', (function (e) {
            $("#editformaddbtn").button('loading');

            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: "POST",
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {

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
                    $("#editformaddbtn").button('reset');
                },
                error: function () {

                }
            });


        }));

    });


</script>