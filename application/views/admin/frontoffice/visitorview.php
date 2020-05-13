<div class="content-wrapper" style="min-height: 348px;">  

    <section class="content">
        <div class="row">


            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header ptbnull">
                        <h3 class="box-title titlefix"><?php echo $this->lang->line('visitor'); ?> <?php echo $this->lang->line('list'); ?></h3>
                        <div class="box-tools pull-right">

                            <?php if ($this->rbac->hasPrivilege('visitor_book', 'can_add')) { ?>
                                <a data-toggle="modal" data-target="#myModal" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> <?php echo $this->lang->line('add'); ?> <?php echo $this->lang->line('visitor'); ?></a> 
                            <?php } ?>


                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="download_label"><?php echo $this->lang->line('visitor'); ?> <?php echo $this->lang->line('list'); ?></div>
                        <div class="table-responsive mailbox-messages">
                            <table class="table table-hover table-striped table-bordered example">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('purpose'); ?>
                                        </th>
                                        <th><?php echo $this->lang->line('name'); ?>
                                        </th>
                                        <th><?php echo $this->lang->line('phone'); ?>
                                        </th>
                                        <th><?php echo $this->lang->line('date'); ?></th>
                                        <th><?php echo $this->lang->line('in_time'); ?>
                                        </th>
                                        <th><?php echo $this->lang->line('out_time'); ?>
                                        </th>
                                        <th class="text-right"><?php echo $this->lang->line('action'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (empty($visitor_list)) {
                                        ?>

                                        <?php
                                    } else {
                                        foreach ($visitor_list as $key => $value) {
                                            ?>
                                            <tr>
                                                <td class="mailbox-name"><?php echo $value['purpose']; ?></td>
                                                <td class="mailbox-name"><?php echo $value['name']; ?></td>
                                                <td class="mailbox-name"><?php echo $value['contact']; ?> </td>
                                                <td class="mailbox-name"> <?php echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($value['date'])); ?></td>
                                                <td class="mailbox-name"> <?php echo $value['in_time']; ?></td>
                                                <td class="mailbox-name"> <?php echo $value['out_time']; ?></td>
                                                <td class="mailbox-date pull-right" >
                                                    <a  onclick="getRecord(<?php echo $value['id']; ?>)" class="btn btn-default btn-xs" data-target="#visitordetails" data-toggle="tooltip"  data-original-title="<?php echo $this->lang->line('view'); ?>"><i class="fa fa-reorder"></i></a> 
                                                    <?php if ($value['image'] !== "") { ?>
                                                        <a href="<?php echo base_url(); ?>admin/visitors/download/<?php echo $value['image']; ?>" class="btn btn-default btn-xs" data-toggle="tooltip" title="" data-original-title="<?php echo $this->lang->line('download'); ?>">
                                                            <i class="fa fa-download"></i>
                                                        </a>  <?php } ?> 
                                                    <?php if ($this->rbac->hasPrivilege('visitor_book', 'can_edit')) { ?>
                                                        <a  class="btn btn-default btn-xs" data-toggle="tooltip" title="<?php echo $this->lang->line('edit'); ?>" 
                                                            onclick="get(<?php echo $value['id']; ?>)">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                                                    <?php }
                                                    ?>

                                                    <?php if ($this->rbac->hasPrivilege('visitor_book', 'can_delete')) { ?>
                                                        <?php if ($value['image'] !== "") { ?><a  class="btn btn-default btn-xs" data-toggle="tooltip" title="" onclick="delete_recordById('<?php echo base_url(); ?>admin/visitors/imagedelete/<?php echo $value['id']; ?>/<?php echo $value['image']; ?>', '<?php echo $this->lang->line('delete_message'); ?>')" data-original-title="<?php echo $this->lang->line('delete'); ?>">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                        <?php } else { ?>
                                                            <a 
                                                                class="btn btn-default btn-xs" data-toggle="tooltip" title="" onclick="delete_recordById('<?php echo base_url(); ?>admin/visitors/delete/<?php echo $value['id']; ?>', '<?php echo $this->lang->line('delete_message') ?>');" data-original-title="<?php echo $this->lang->line('delete'); ?>">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
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
            </div><!--/.col (left) col-8 end-->
            <!-- right column -->

        </div>

    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<!-- new END -->
<div id="visitordetails" class="modal fade" role="dialog">
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
<div id="editmyModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="box-title"> <?php echo $this->lang->line('edit'); ?> <?php echo $this->lang->line('visitor'); ?></h4> 
            </div>
            <form id="editformadd" action="<?php echo site_url('admin/visitors/edit') ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data" >  
                <div class="modal-body pt0 pb0">

                    <div class="ptt10">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('purpose'); ?></label><small class="req"> *</small>

                                    <select name="purpose" id="purpose" class="form-control"> 
                                        <option value=""><?php echo $this->lang->line('select'); ?></option>  
                                        <?php foreach ($Purpose as $key => $value) { ?>

                                            <option value="<?php print_r($value['visitors_purpose']); ?>"<?php if (set_value('purpose') == $value['visitors_purpose']) { ?>selected=""<?php } ?>><?php print_r($value['visitors_purpose']); ?></option>
                                        <?php } ?>

                                    </select>
                                    <span class="text-danger"><?php echo form_error('purpose'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pwd"><?php echo $this->lang->line('name'); ?></label>  <small class="req"> *</small>
                                    <input type="text" class="form-control"  name="name"  id="name">
                                    <span class="text-danger"><?php echo form_error('name'); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pwd"><?php echo $this->lang->line('phone'); ?></label>
                                    <input type="text" class="form-control" id="contact"  name="contact">

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pwd"><?php echo $this->lang->line('icard'); ?></label>
                                    <input type="text" class="form-control" name="id_proof"  id="id_proof">

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email"><?php echo $this->lang->line('number_of_person'); ?></label> 
                                    <input type="text" class="form-control" name="pepples" id="pepples">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="pwd"><?php echo $this->lang->line('date'); ?></label><input type="text" id="edate" class="form-control"   name="date" readonly="">
                                        <span class="text-danger"><?php echo form_error('date'); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pwd"><?php echo $this->lang->line('in_time'); ?></label>
                                    <div class="bootstrap-timepicker">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" name="time" class="form-control timepicker" id="in_time" value="<?php echo set_value('time'); ?>">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-clock-o"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <span class="text-danger"><?php echo form_error('time'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pwd"><?php echo $this->lang->line('out_time'); ?></label>
                                    <div class="bootstrap-timepicker">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" name="out_time" class="form-control timepicker" id="out_time" value="<?php echo set_value('out_time'); ?>">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-clock-o"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <span class="text-danger"><?php echo form_error('out_time'); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="hidden" id="editid" name="id">
                            <label for="pwd"><?php echo $this->lang->line('note'); ?></label>
                            <textarea class="form-control"  name="note" id="note" rows="3"><?php echo set_value('note'); ?></textarea>
                            <span class="text-danger"><?php echo form_error('date'); ?></span>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputFile"><?php echo $this->lang->line('attach_document'); ?></label>
                            <div><input class="filestyle form-control" type='file' name='file'  />
                            </div>
                            <span class="text-danger"><?php echo form_error('file'); ?></span></div>

                    </div><!-- /.box-body -->

                </div>
                <div class="box-footer">
                    <button type="submit" data-loading-text="<?php echo $this->lang->line('processing') ?>" 
                            id="editformaddbtn" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
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
                <h4 class="box-title"> <?php echo $this->lang->line('add'); ?> <?php echo $this->lang->line('visitor'); ?></h4> 
            </div>
            <form id="formadd" action="<?php echo site_url('admin/visitors') ?>"   method="post" accept-charset="utf-8" enctype="multipart/form-data" >
                <div class="modal-body pt0 pb0">

                    <div class="ptt10">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('purpose'); ?></label><small class="req"> *</small>

                                    <select name="purpose" class="form-control"> 
                                        <option value=""><?php echo $this->lang->line('select'); ?></option>  
                                        <?php foreach ($Purpose as $key => $value) { ?>

                                            <option value="<?php print_r($value['visitors_purpose']); ?>"<?php if (set_value('purpose') == $value['visitors_purpose']) { ?>selected=""<?php } ?>><?php print_r($value['visitors_purpose']); ?></option>
                                        <?php } ?>

                                    </select>
                                    <span class="text-danger"><?php echo form_error('purpose'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pwd"><?php echo $this->lang->line('name'); ?></label>  <small class="req"> *</small>
                                    <input type="text" class="form-control" value="<?php echo set_value('name'); ?>" name="name">
                                    <span class="text-danger"><?php echo form_error('name'); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pwd"><?php echo $this->lang->line('phone'); ?></label>
                                    <input type="text" class="form-control" value="<?php echo set_value('contact'); ?>" name="contact">

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pwd"><?php echo $this->lang->line('icard'); ?></label>
                                    <input type="text" class="form-control" value="<?php echo set_value('id_proof'); ?>" name="id_proof">

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email"><?php echo $this->lang->line('number_of_person'); ?></label> 
                                    <input type="text" class="form-control" value="<?php echo set_value('pepples'); ?>" name="pepples">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="pwd"><?php echo $this->lang->line('date'); ?></label><input type="text" id="date" class="form-control" value="<?php echo set_value('date', date($this->customlib->getSchoolDateFormat())); ?>"  name="date" readonly="">
                                        <span class="text-danger"><?php echo form_error('date'); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pwd"><?php echo $this->lang->line('in_time'); ?></label>
                                    <div class="bootstrap-timepicker">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" name="time" class="form-control timepicker" id="stime_" value="<?php echo set_value('time'); ?>">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-clock-o"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <span class="text-danger"><?php echo form_error('time'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pwd"><?php echo $this->lang->line('out_time'); ?></label>
                                    <div class="bootstrap-timepicker">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" name="out_time" class="form-control timepicker" id="stime_" value="<?php echo set_value('out_time'); ?>">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-clock-o"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <span class="text-danger"><?php echo form_error('out_time'); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pwd"><?php echo $this->lang->line('note'); ?></label>
                            <textarea class="form-control" id="description" name="note" name="note" rows="3"><?php echo set_value('note'); ?></textarea>
                            <span class="text-danger"><?php echo form_error('date'); ?></span>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputFile"><?php echo $this->lang->line('attach_document'); ?></label>
                            <div><input class="filestyle form-control" type='file' name='file'  />
                            </div>
                            <span class="text-danger"><?php echo form_error('file'); ?></span></div>

                    </div><!-- /.box-body -->

                </div>
                <div class="box-footer">
                    <button type="submit" id="formaddbtn" data-loading-text="<?php echo $this->lang->line('processing') ?>" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                </div>
            </form>



        </div>

    </div>
</div>
<link rel="stylesheet" href="<?php echo base_url(); ?>backend/plugins/timepicker/bootstrap-timepicker.min.css">
<script src="<?php echo base_url(); ?>backend/plugins/timepicker/bootstrap-timepicker.min.js"></script>

<script type="text/javascript">
                                                                    $(document).ready(function () {
                                                                        var date_format = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(), ['d' => 'dd', 'm' => 'mm', 'Y' => 'yyyy',]) ?>';

                                                                        $('#date').datepicker({

                                                                            format: date_format,
                                                                            autoclose: true
                                                                        });

                                                                        $('#edate').datepicker({

                                                                            format: date_format,
                                                                            autoclose: true
                                                                        });

                                                                    });
                                                                    function get(id) {
                                                                        $('#editmyModal').modal('show');
                                                                        $.ajax({
                                                                            dataType: 'json',
                                                                            url: '<?php echo base_url(); ?>admin/visitors/get_visitor/' + id,
                                                                            success: function (result) {
                                                                                $('#purpose').val(result.purpose),
                                                                                        $('#name').val(result.name);
                                                                                $('#contact').val(result.contact);
                                                                                $('#id_proof').val(result.id_proof);
                                                                                $('#pepples').val(result.no_of_pepple);
                                                                                $('#edate').val(result.datedd);
                                                                                $('#in_time').val(result.in_time);
                                                                                $('#out_time').val(result.out_time);
                                                                                $('#note').val(result.note);
                                                                                $('#editid').val(result.id);

                                                                            }


                                                                        });
                                                                    }


                                                                    $(document).ready(function (e) {
                                                                        $("#formadd").on('submit', (function (e) {
                                                                            $("#formaddbtn").button('loading');
                                                                            e.preventDefault();
                                                                            $.ajax({
                                                                                url: '<?php echo base_url(); ?>admin/visitors/add',
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
                                                                                url: '<?php echo base_url(); ?>admin/visitors/edit',
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
                                                                                    //  alert("Fail")
                                                                                }
                                                                            });

                                                                        }));
                                                                    });


                                                                    $(function () {

                                                                        $(".timepicker").timepicker({

                                                                        });
                                                                    });



                                                                    function getRecord(id) {

                                                                        $('#visitordetails').modal('show');
                                                                        $.ajax({
                                                                            url: '<?php echo base_url(); ?>admin/visitors/details/' + id,
                                                                            success: function (result) {
                                                                                //alert(result);
                                                                                $('#getdetails').html(result);
                                                                            }


                                                                        });

                                                                    }

</script>
