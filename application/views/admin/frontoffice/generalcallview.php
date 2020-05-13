
<div class="content-wrapper" style="min-height: 348px;">  

    <?php $call_type = $this->customlib->getCalltype(); ?>
    <section class="content">
        <div class="row">

            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header ptbnull">
                        <h3 class="box-title titlefix"><?php echo $this->lang->line('phone_call_log'); ?> <?php echo $this->lang->line('list'); ?></h3>
                        <div class="box-tools pull-right">
                            <?php if ($this->rbac->hasPrivilege('phone_call_log', 'can_add')) { ?>
                                <a data-toggle="modal" data-target="#myModal" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> <?php echo $this->lang->line('add') . " " . $this->lang->line('call_log'); ?> </a> 
                            <?php } ?>


                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="download_label"><?php echo $this->lang->line('phone_call_log'); ?></div>
                        <div class="table-responsive mailbox-messages">
                            <table class="table table-hover table-striped table-bordered example">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('name'); ?>
                                        </th>
                                        <th><?php echo $this->lang->line('phone'); ?>
                                        </th>
                                        <th><?php echo $this->lang->line('date'); ?>
                                        </th>
                                        <th><?php echo $this->lang->line('next_follow_up_date'); ?></th>
                                        <th><?php echo $this->lang->line('call_type'); ?>
                                        </th>
                                        <th class="text-right"><?php echo $this->lang->line('action'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (empty($CallList)) {
                                        ?>

                                        <?php
                                    } else {
                                        foreach ($CallList as $key => $value) {
                                            // print_r($value);
                                            ?>
                                            <tr>
                                                <td class="mailbox-name"><?php echo $value['name']; ?></td>
                                                <td class="mailbox-name"><?php echo $value['contact']; ?></td>
                                                <td class="mailbox-name"><?php echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($value['date'])); ?> </td>
                                                <td class="mailbox-name"> <?php echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($value['follow_up_date'])); ?></td>
                                                <td class="mailbox-name"> <?php echo $value['call_type']; ?></td>
                                                <td class="mailbox-date pull-right" "="">
                                                    <a  onclick="getRecord(<?php echo $value['id']; ?>)" class="btn btn-default btn-xs" data-target="#calldetails" data-toggle="tooltip"  data-original-title="<?php echo $this->lang->line('view'); ?>"><i class="fa fa-reorder"></i></a>   <?php if ($this->rbac->hasPrivilege('phone_call_log', 'can_edit')) { ?>
                                                        <a class="btn btn-default btn-xs" data-toggle="tooltip" onclick="get(<?php echo $value['id']; ?>);" data-target="#editmyModal" title="" data-original-title="<?php echo $this->lang->line('edit'); ?>">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                                                    <?php } ?>
                                                    <?php if ($this->rbac->hasPrivilege('phone_call_log', 'can_delete')) { ?>
                                                        <a  class="btn btn-default btn-xs" data-toggle="tooltip" title="" onclick="delete_recordById('<?php echo base_url('admin/generalcall/delete/' . $value['id']) ?>', '<?php echo $this->lang->line('delete_message') ?>')" data-original-title="<?php echo $this->lang->line('delete'); ?>">
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
<div id="calldetails" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog2 modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('call') . " " . $this->lang->line('details') ?></h4>
            </div>
            <div class="modal-body" id="getdetails">


            </div>
        </div>
    </div>
</div>
</div><!-- /.content-wrapper -->
<div id="editmyModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="box-title"> <?php echo $this->lang->line('edit') . " " . $this->lang->line('call_log'); ?> </h4> 
            </div>

            <form id="editformadd" method="post" accept-charset="utf-8" enctype="multipart/form-data" >
                <div class="modal-body pt0 pb0">  
                    <div class="ptt10">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pwd"><?php echo $this->lang->line('name'); ?></label>  <small class="req"> *</small>
                                    <input type="text" id="ename" class="form-control" value="<?php echo set_value('name'); ?>" name="name">
                                    <span class="text-danger"><?php echo form_error('name'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pwd"><?php echo $this->lang->line('phone'); ?></label>
                                    <input type="text" class="form-control" id="econtact" value="<?php echo set_value('contact'); ?>" name="contact">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pwd"><?php echo $this->lang->line('date'); ?></label>
                                    <input id="edate" name="date" placeholder="" type="text" class="form-control"  value="<?php echo set_value('date', date($this->customlib->getSchoolDateFormat())); ?>" readonly="readonly" />
                                    <span class="text-danger"><?php echo form_error('date'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email"><?php echo $this->lang->line('description'); ?></label> 
                                    <textarea class="form-control" id="edescription" name="description"  rows="3"><?php echo set_value('description'); ?></textarea>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="pwd"><?php echo $this->lang->line('next_follow_up_date'); ?></label>     <input id="efollow_up_date" name="follow_up_date" placeholder="" type="text" class="form-control"  value="<?php echo set_value('follow_up_date'); ?>" readonly="readonly" />
                                        <span class="text-danger"><?php echo form_error('follow_up_date'); ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pwd"><?php echo $this->lang->line('call_duration'); ?></label>
                                    <input id="ecall_dureation" type="text" class="form-control" value="<?php echo set_value('call_dureation'); ?>" name="call_dureation">
                                    <span class="text-danger"><?php echo form_error('call_dureation'); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pwd"><?php echo $this->lang->line('note'); ?></label>
                                    <textarea class="form-control" id="enote" name="note" rows="3"><?php echo set_value('note'); ?></textarea>
                                    <input type="hidden" name="id" id="generalcall_id" >
                                    <span class="text-danger"><?php echo form_error('note'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pwd"><?php echo $this->lang->line('call_type'); ?></label>

                                    <small class="req"> *</small>  

                                    <?php
                                    $n = 1;
                                    foreach ($call_type as $key => $value) {
                                        ?>
                                        <label class="radio-inline"><input type="radio" id="<?php echo $n++; ?>" name="call_type" value="<?php echo $key; ?>" <?php if (set_value('call_type') == $key) { ?> checked=""<?php } ?>> <?php echo $value; ?></label>

                                    <?php } ?>

                                    <span class="text-danger"><?php echo form_error('call_type'); ?></span>
                                </div>
                            </div>
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

<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="box-title"> <?php echo $this->lang->line('add') . " " . $this->lang->line('call_log'); ?></h4> 
            </div>
            <form id="formadd" method="post" accept-charset="utf-8" enctype="multipart/form-data" >
                <div class="modal-body pt0 pb0">

                    <div class="ptt10">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pwd"><?php echo $this->lang->line('name'); ?></label>  <small class="req"> *</small>
                                    <input type="text" class="form-control" value="<?php echo set_value('name'); ?>" name="name">
                                    <span class="text-danger"><?php echo form_error('name'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pwd"><?php echo $this->lang->line('phone'); ?></label>
                                    <input type="text" class="form-control" value="<?php echo set_value('contact'); ?>" name="contact">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pwd"><?php echo $this->lang->line('date'); ?></label>
                                    <input id="date" name="date" placeholder="" type="text" class="form-control"  value="<?php echo set_value('date', date($this->customlib->getSchoolDateFormat())); ?>" readonly="readonly" />
                                    <span class="text-danger"><?php echo form_error('date'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email"><?php echo $this->lang->line('description'); ?></label> 
                                    <textarea class="form-control" id="description" name="description"  rows="3"><?php echo set_value('description'); ?></textarea>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="pwd"><?php echo $this->lang->line('next_follow_up_date'); ?></label>     <input id="follow_up_date" name="follow_up_date" placeholder="" type="text" class="form-control"  value="<?php echo set_value('follow_up_date'); ?>" readonly="readonly" />
                                        <span class="text-danger"><?php echo form_error('follow_up_date'); ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pwd"><?php echo $this->lang->line('call_duration'); ?></label>
                                    <input type="text" class="form-control" value="<?php echo set_value('call_dureation'); ?>" name="call_dureation">
                                    <span class="text-danger"><?php echo form_error('call_dureation'); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pwd"><?php echo $this->lang->line('note'); ?></label>
                                    <textarea class="form-control" id="description" name="note" name="note" rows="3"><?php echo set_value('note'); ?></textarea>
                                    <span class="text-danger"><?php echo form_error('note'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pwd"><?php echo $this->lang->line('call_type'); ?></label>

                                    <small class="req"> *</small>  

                                    <?php foreach ($call_type as $key => $value) { ?>
                                        <label class="radio-inline"><input type="radio" name="call_type" value="<?php echo $key; ?>" <?php if (set_value('call_type') == $key) { ?> checked=""<?php } ?>> <?php echo $value; ?></label>

                                    <?php } ?>

                                    <span class="text-danger"><?php echo form_error('call_type'); ?></span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- /.box-body --> 

                <div class="box-footer">
                    <button type="submit" data-loading-text="<?php echo $this->lang->line('processing') ?>" id="formaddbtn" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                </div>

            </form>


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

        $('#follow_up_date').datepicker({

            format: date_format,
            autoclose: true
        });

        $('#efollow_up_date').datepicker({

            format: date_format,
            autoclose: true
        });


    });

    function getRecord(id) {

        $('#calldetails').modal('show');
        $.ajax({
            url: '<?php echo base_url(); ?>admin/generalcall/details/' + id,
            success: function (result) {

                $('#getdetails').html(result);
            }


        });
    }

    function get(id) {
        $('#editmyModal').modal('show');
        $.ajax({
            dataType: 'json',
            url: '<?php echo base_url(); ?>admin/generalcall/get_calls/' + id,
            success: function (result) {

                if (result.call_type == "Incoming") {
                    $('#1').prop("checked", true);
                } else {
                    $('#2').prop("checked", true);
                }

                $('#efollow_up_date').val(result.efollow_up_date);
                $('#epurpose').val(result.purpose);
                $('#ename').val(result.name);
                $('#econtact').val(result.contact);
                $('#eedate').val(result.datedd);
                $('#edescription').val(result.description);
                $('#enote').val(result.note);
                $('#generalcall_id').val(result.id);
                $('#ecall_dureation').val(result.call_dureation);

            }


        });
    }


    $(document).ready(function (e) {
        $("#formadd").on('submit', (function (e) {
            $("#formaddbtn").button('loading');
            e.preventDefault();
            $.ajax({
                url: '<?php echo base_url(); ?>admin/generalcall/add',
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
                url: '<?php echo base_url(); ?>admin/generalcall/edit',
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
