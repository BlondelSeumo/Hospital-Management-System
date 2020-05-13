<div class="content-wrapper" style="min-height: 348px;">  

    <section class="content">
        <div class="row">

            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header ptbnull">
                        <h3 class="box-title titlefix"><?php echo $this->lang->line('postal_dispatch'); ?> <?php echo $this->lang->line('list'); ?></h3>
                        <div class="box-tools pull-right">
                            <div class="box-tools pull-right">
                                <?php if ($this->rbac->hasPrivilege('postal_dispatch', 'can_add')) { ?>
                                    <a data-toggle="modal" data-target="#myModal" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> <?php echo $this->lang->line('add'); ?> <?php echo $this->lang->line('dispatch'); ?> </a> 
                                <?php } ?>
                            </div>
                        </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="download_label"><?php echo $this->lang->line('postal_dispatch'); ?><?php echo $this->lang->line('list'); ?></div>
                        <div class="table-responsive mailbox-messages">
                            <table class="table table-hover table-striped table-bordered example">
                                <thead>
                                    <tr>                                    
                                        <th><?php echo $this->lang->line('to_title'); ?></th>
                                        <th><?php echo $this->lang->line('reference_no'); ?></th>
                                        <th><?php echo $this->lang->line('from_title'); ?></th>
                                        <th><?php echo $this->lang->line('date'); ?></th>
                                        <th class="text-right"><?php echo $this->lang->line('action'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (empty($DispatchList)) {
                                        ?>
                                        <?php
                                    } else {
                                        foreach ($DispatchList as $key => $value) {
                                            ?>
                                            <tr>

                                                <td class="mailbox-name"><?php echo $value->to_title; ?></td>
                                                <td class="mailbox-name"><?php echo $value->reference_no; ?></td>
                                                <td class="mailbox-name"> <?php echo $value->from_title; ?></td>
                                                <td class="mailbox-name"> <?php echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($value->date)); ?></td>
                                                <td class="mailbox-date pull-right" >
                                                    <a  onclick="getRecord(<?php echo $value->id; ?>)" class="btn btn-default btn-xs" data-target="#receviedetails"  data-original-title="<?php echo $this->lang->line('view'); ?>">
                                                        <i class="fa fa-reorder"></i>
                                                    </a>
                                                    <?php if ($value->image !== "") { ?>
                                                        <a href="<?php echo base_url(); ?>admin/dispatch/download/<?php echo $value->image; ?>" class="btn btn-default btn-xs" data-toggle="tooltip" title="" data-original-title="<?php echo $this->lang->line('download') ?>">
                                                            <i class="fa fa-download"></i>
                                                        </a>  <?php } ?>
                                                    <?php if ($this->rbac->hasPrivilege('postal_dispatch', 'can_edit')) { ?>                                                   
                                                        <a  onclick="get(<?php echo $value->id; ?>);"  class="btn btn-default btn-xs" data-toggle="tooltip" data-target="#editmyModal" title="" data-original-title="<?php echo $this->lang->line('edit') ?>">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                                                        <?php
                                                    }
                                                    if ($this->rbac->hasPrivilege('postal_dispatch', 'can_delete')) {
                                                        ?>
                                                        <a  class="btn btn-default btn-xs" data-toggle="tooltip" title="" onclick="delete_recordById('<?php echo base_url(); ?>admin/dispatch/delete/<?php echo $value->id; ?>/<?php echo $value->image; ?>', '<?php echo $this->lang->line('delete_message'); ?>')" data-original-title="<?php echo $this->lang->line('delete') ?>">
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
<div id="receviedetails" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog2 modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('details'); ?></h4>
            </div>
            <div class="modal-body" id="getdetails">
            </div>
        </div>
    </div>
</div>
</div><!-- /.content-wrapper -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="box-title"> <?php echo $this->lang->line('add'); ?> <?php echo $this->lang->line('dispatch'); ?></h4> 
            </div>
            <form id="formadd" method="post" accept-charset="utf-8" enctype="multipart/form-data" >
                <div class="modal-body pt0 pb0">
                    <div class="ptt10">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pwd"><?php echo $this->lang->line('to_title'); ?></label>   <small class="req"> *</small> 
                                    <input type="text" class="form-control" value="<?php echo set_value('from_title'); ?>" name="to_title">
                                    <span class="text-danger"><?php echo form_error('from_title'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('reference_no'); ?></label>

                                    <input type="text" class="form-control" value="<?php echo set_value('ref_no'); ?>" name="ref_no">
                                    <span class="text-danger"><?php echo form_error('ref_no'); ?></span>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pwd"><?php echo $this->lang->line('address'); ?></label>
                                    <textarea class="form-control" id="description"  name="address" rows="3"><?php echo set_value('address'); ?></textarea>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email"><?php echo $this->lang->line('note'); ?></label> 
                                    <textarea class="form-control" id="description" name="note" name="note" rows="3"><?php echo set_value('note'); ?></textarea>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pwd"><?php echo $this->lang->line('from_title'); ?></label> 
                                    <input type="text" class="form-control" value="<?php echo set_value('to_title'); ?>"  name="from_title">
                                    <span class="text-danger"><?php echo form_error('to_title'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pwd"><?php echo $this->lang->line('date'); ?></label>
                                    <input id="date" name="date" placeholder="" type="text" class="form-control"  value="<?php echo set_value('date', date($this->customlib->getSchoolDateFormat())); ?>" readonly="readonly" />
                                    <span class="text-danger"><?php echo form_error('date'); ?></span>
                                </div>
                            </div>






                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="exampleInputFile"><?php echo $this->lang->line('attach_document'); ?></label>
                                    <div><input class="filestyle form-control" type='file' name='file'  />
                                    </div>
                                    <span class="text-danger"><?php echo form_error('file'); ?></span></div>
                            </div>

                        </div><!-- /.box-body -->
                    </div>
                </div><!--./modal-body-->
                <div class="box-footer">
                    <button type="submit" data-loading-text="<?php echo $this->lang->line('processing') ?>" id="formaddbtn" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                </div>
            </form>



        </div>

    </div>
</div>
<!-- /.content-wrapper -->

<div id="editmyModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="box-title"> <?php echo $this->lang->line('edit'); ?> <?php echo $this->lang->line('dispatch'); ?></h4> 
            </div>
            <div class="modal-body pt0 pb0">
                <form id="editformadd"    method="post" accept-charset="utf-8" enctype="multipart/form-data" >
                    <div class="box-body">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pwd"><?php echo $this->lang->line('to_title'); ?></label>   <small class="req"> *</small> 
                                    <input type="text" id="efrom_title" class="form-control" value="<?php echo set_value('from_title'); ?>" name="to_title">
                                    <input type="hidden" name="id" id="id">

                                    <span class="text-danger"><?php echo form_error('from_title'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('reference_no'); ?></label>

                                    <input type="text" id="ref_no" class="form-control" value="<?php echo set_value('ref_no'); ?>" name="ref_no">
                                    <span class="text-danger"><?php echo form_error('ref_no'); ?></span>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pwd"><?php echo $this->lang->line('address'); ?></label>
                                    <textarea class="form-control" id="eaddress"  name="address" rows="3"><?php echo set_value('address'); ?></textarea>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email"><?php echo $this->lang->line('note'); ?></label> 
                                    <textarea class="form-control" id="enote"  name="note" rows="3"><?php echo set_value('note'); ?></textarea>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pwd"><?php echo $this->lang->line('from_title'); ?></label> 
                                    <input type="text" id="to_title" class="form-control" value="<?php echo set_value('to_title'); ?>"  name="from_title">
                                    <span class="text-danger"><?php echo form_error('to_title'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pwd"><?php echo $this->lang->line('date'); ?></label>
                                    <input id="edate" name="date" placeholder="" type="text" class="form-control"  value="<?php echo set_value('date', date($this->customlib->getSchoolDateFormat())); ?>" readonly="readonly" />
                                    <span class="text-danger"><?php echo form_error('date'); ?></span>
                                </div>
                            </div>






                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="exampleInputFile"><?php echo $this->lang->line('attach_document'); ?></label>
                                    <div><input class="filestyle form-control" type='file' name='file'  />
                                    </div>
                                    <span class="text-danger"><?php echo form_error('file'); ?></span></div>
                            </div>

                        </div><!-- /.box-body -->
                    </div>

                    <div class="box-footer">
                        <button type="submit" id="editformaddbtn" data-loading-text="<?php echo $this->lang->line('processing') ?>" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                    </div>
                </form>


            </div>
        </div>

    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        var date_format = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(), ['d' => 'dd', 'm' => 'mm', 'Y' => 'yyyy',]) ?>';

        $('#date').datepicker({

            format: date_format,
            autoclose: true
        });
    });
    $(document).ready(function () {
        var date_format = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(), ['d' => 'dd', 'm' => 'mm', 'Y' => 'yyyy',]) ?>';

        $('#date_of_call').datepicker({

            format: date_format,
            autoclose: true
        });
    });
    function getRecord(id) {
        $('#receviedetails').modal('show');

        $.ajax({
            url: '<?php echo base_url(); ?>admin/dispatch/details/' + id + '/dispatch',
            success: function (result) {

                $('#getdetails').html(result);
            }
        });
    }


    function get(id) {
        $('#editmyModal').modal('show');


        $.ajax({

            dataType: 'json',

            url: '<?php echo base_url(); ?>admin/receive/get_receive/' + id,

            success: function (result) {

                $('#efrom_title').val(result.to_title);
                $('#ref_no').val(result.reference_no);
                $('#ename').val(result.address);
                $('#to_title').val(result.from_title);
                $('#eedate').val(result.datedd);
                $('#eaddress').val(result.address);
                $('#enote').val(result.note);
                $('#id').val(result.id);
                $('#eaction_taken').val(result.action_taken);
                $('#eassigned').val(result.assigned);

            }

        });

    }


    $(document).ready(function (e) {
        $("#formadd").on('submit', (function (e) {
            $("#formaddbtn").button('loading');
            e.preventDefault();
            $.ajax({
                url: '<?php echo base_url(); ?>admin/dispatch/add',
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

    $(document).ready(function (e) {
        $("#editformadd").on('submit', (function (e) {
            $("#editformaddbtn").button('loading');
            e.preventDefault();
            $.ajax({
                url: '<?php echo base_url(); ?>admin/dispatch/editdispatch',
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
