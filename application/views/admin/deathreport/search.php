<?php
$currency_symbol = $this->customlib->getSchoolCurrencyFormat();
$genderList = $this->customlib->getGender();
?>
<style type="text/css">
    #easySelectable {/*display: flex; flex-wrap: wrap;*/}
    #easySelectable li {}
    #easySelectable li.es-selected {background: #2196F3; color: #fff;}
    .easySelectable {-webkit-user-select:none; -moz-user-select:none; -ms-user-select: none;}
</style>
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title titlefix"><?php echo $this->lang->line('ambulance_list'); ?></h3>
                        <div class="box-tools pull-right">
                            <?php if ($this->rbac->hasPrivilege('ambulance', 'can_add')) { ?>  
                                <a data-toggle="modal" onclick="holdModal('myModal')" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> <?php echo $this->lang->line('add_ambulance'); ?></a>
                            <?php } ?> 
                            <?php if ($this->rbac->hasPrivilege('ambulance_call', 'can_view')) { ?> 
                                <a href="<?php echo base_url(); ?>admin/vehicle/getcallambulance" class="btn btn-primary btn-sm"><i class="fa fa-reorder"></i> <?php echo $this->lang->line('ambulance_call'); ?></a> 
                            <?php } ?> 
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="download_label"><?php echo $this->lang->line('ambulance_list'); ?></div>
                        <table class="table table-striped table-bordered table-hover example" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th><?php echo $this->lang->line('vehicle_no'); ?></th>
                                    <th><?php echo $this->lang->line('vehicle_model'); ?></th>
                                    <th><?php echo $this->lang->line('year_made'); ?></th>
                                    <th><?php echo $this->lang->line('driver_name'); ?></th>
                                    <th><?php echo $this->lang->line('driver_license'); ?></th>
                                    <th><?php echo $this->lang->line('driver_contact'); ?></th>
                                    <th><?php echo $this->lang->line('vehicle') . " " . $this->lang->line('type'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($listVehicle)) {
                                    ?>
                                    <?php
                                } else {
                                    $count = 1;
                                    foreach ($listVehicle as $data) {
                                        ?>
                                        <tr class="">
                                            <td>
                                                <a href="#" data-toggle="popover" class="detail_popover" ><?php echo $data['vehicle_no'] ?></a>
                                                <div class="fee_detail_popover" style="display: none">
                                                    <?php
                                                    if ($data['note'] == "") {
                                                        ?>
                                                        <p class="text text-danger"><?php echo $this->lang->line('no_description'); ?></p>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <p class="text text-info"><?php echo $data['note']; ?></p>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                                <div class="rowoptionview">
                                                    <?php
                                                    if ($this->rbac->hasPrivilege('ambulance', 'can_edit')) {
                                                        ?>
                                                        <a href="#" onclick="getRecord('<?php echo $data['id'] ?>')" class="btn btn-default btn-xs" data-target="#myModaledit" data-toggle="tooltip" title="<?php echo $this->lang->line('edit'); ?>">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>     
                                                    <?php } ?>
                                                    <?php if ($this->rbac->hasPrivilege('ambulance', 'can_delete')) { ?>
                                                        <a class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('delete'); ?>" onclick="delete_recordById('<?php echo base_url(); ?>admin/vehicle/delete/<?php echo $data['id'] ?>', '<?php echo $this->lang->line('delete_message') ?>')">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    <?php } ?>
                                                </div>  
                                            </td>
                                            <td><?php echo $data['vehicle_model'] ?></td>
                                            <td><?php echo $data['manufacture_year'] ?></td>
                                            <td><?php echo $data['driver_name']; ?></td>
                                            <td><?php echo $data['driver_licence']; ?></td>
                                            <td><?php echo $data['driver_contact']; ?></td>
                                            <td style="text-transform: capitalize;"><?php echo $data['vehicle_type']; ?></td>
                                        </tr>
                                        <?php
                                        $count++;
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>                                                    
            </div>                                                                                                                                          
        </div>  
    </section>
</div>
<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="box-title"><?php echo $this->lang->line('add_ambulance'); ?></h4> 
            </div>
            <div class="modal-body pt0 pb0">
                <div class="row">
                    <form  id="formadd" method="post" accept-charset="utf-8">
                        <div class="paddlr col-md-12">

                            <div class="row">
                                <div class="col-sm-4">                     
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('vehicle_no'); ?></label><small class="req"> *</small>
                                        <input autofocus="" name="vehicle_no" placeholder="" type="text" class="form-control" />
                                        <span class="text-danger"><?php echo form_error('vehicle_no'); ?></span>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('vehicle_model'); ?></label><small class="req"> *</small>
                                        <input name="vehicle_model" placeholder="" type="text" class="form-control" />

                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('year_made'); ?> </label>
                                        <input  name="manufacture_year" placeholder="" type="text" class="form-control" value="<?php echo set_value('manufacture_year'); ?>" />

                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('driver_name'); ?></label>
                                        <input name="driver_name" placeholder="" type="text" class="form-control"  value="<?php echo set_value('driver_name'); ?>" />

                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('driver_license'); ?></label>
                                        <input name="driver_licence" placeholder="" type="text" class="form-control" " />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('driver_contact'); ?></label>
                                        <input name="driver_contact" placeholder="" type="text" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('vehicle') . " " . $this->lang->line('type'); ?></label><small class="req"> *</small>
                                        <select name="vehicle_type" class="form-control">
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                            <option value="<?php echo $this->lang->line("owned") ?>"><?php echo $this->lang->line("owned") ?></option>
                                            <option value="<?php echo $this->lang->line("contractual") ?>"><?php echo $this->lang->line("contractual") ?></option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('note'); ?></label>
                                        <textarea class="form-control" name="note" placeholder=""><?php echo set_value('note'); ?></textarea>
                                    </div>
                                </div>
                            </div>


                        </div>

                        <div class="box-footer clear">
                            <button type="submit" data-loading-text="<?php echo $this->lang->line('processing') ?>" id="formaddbtn" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                        </div>
                    </form>
                </div>

            </div>
        </div>    
    </div>
</div>
<!-- dd -->
<div class="modal fade" id="myModaledit" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="box-title"><?php echo $this->lang->line('edit_ambulance'); ?></h4> 
            </div>
            <div class="modal-body pt0 pb0">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 paddlr">
                        <form id="formedit" accept-charset="utf-8">
                            <div class="row">
                                <input type="hidden" name="id" id="ids" value="<?php echo set_value('id'); ?>" >
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('vehicle_no'); ?></label><small class="req"> *</small>
                                        <input id="vehicle_nos" name="vehicle_no" type="text" class="form-control"  value="<?php echo set_value('vehicle_no'); ?>" />
                                        <span class="text-danger"><?php echo form_error('vehicle_no'); ?></span>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('vehicle_model'); ?></label><small class="req"> *</small>
                                        <input id="vehicle_models" name="vehicle_model"  type="text" class="form-control" value="<?php echo set_value('vehicle_model'); ?>" />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('year_made'); ?> </label>
                                        <input id="manufacture_years" name="manufacture_year" type="text" class="form-control"  value="<?php echo set_value('manufacture_year'); ?>" />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('driver_name'); ?></label>
                                        <input id="driver_names" name="driver_name" type="text" class="form-control"  value="<?php echo set_value('driver_name'); ?>" />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('driver_license'); ?></label>
                                        <input id="driver_licences" name="driver_licence" type="text" class="form-control"  value="<?php echo set_value('driver_licence'); ?>" />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('driver_contact'); ?></label>
                                        <input id="driver_contacts" name="driver_contact" type="text" class="form-control"  value="<?php echo set_value('driver_contact'); ?>" />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('vehicle') . " " . $this->lang->line('type'); ?></label><small class="req"> *</small>
                                        <select name="vehicle_type" id="vehicle_type" class="form-control">
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                            <option value="<?php echo $this->lang->line("owned") ?>"><?php echo $this->lang->line("owned") ?></option>
                                            <option value="<?php echo $this->lang->line("contractual") ?>"><?php echo $this->lang->line("contractual") ?></option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('note'); ?></label>
                                        <textarea class="form-control" id="note" name="note" placeholder=""><?php echo set_value('note'); ?></textarea>
                                    </div>
                                </div>
                            </div><!--./row-->   

                    </div><!--./col-md-12--> 
                    <div class="box-footer clear">
                        <div class="pull-right">
                            <button type="submit" id="formeditbtn"  data-loading-text="<?php echo $this->lang->line('processing') ?>" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                        </div>
                    </div> 
                    </form>      
                </div><!--./row--> 
            </div>

        </div>
    </div>    
</div>
<script type="text/javascript">

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
        $('#easySelectable').easySelectable();
//stopPropagation();
    })
</script>
<script type="text/javascript">
            /*
             Author: mee4dy@gmail.com
             */
                    (function ($) {
                        //selectable html elements
                        $.fn.easySelectable = function (options) {
                            var el = $(this);
                            var options = $.extend({
                                'item': 'li',
                                'state': true,
                                onSelecting: function (el) {

                                },
                                onSelected: function (el) {

                                },
                                onUnSelected: function (el) {

                                }
                            }, options);
                            el.on('dragstart', function (event) {
                                event.preventDefault();
                            });
                            el.off('mouseover');
                            el.addClass('easySelectable');
                            if (options.state) {
                                el.find(options.item).addClass('es-selectable');
                                el.on('mousedown', options.item, function (e) {
                                    $(this).trigger('start_select');
                                    var offset = $(this).offset();
                                    var hasClass = $(this).hasClass('es-selected');
                                    var prev_el = false;
                                    el.on('mouseover', options.item, function (e) {
                                        if (prev_el == $(this).index())
                                            return true;
                                        prev_el = $(this).index();
                                        var hasClass2 = $(this).hasClass('es-selected');
                                        if (!hasClass2) {
                                            $(this).addClass('es-selected').trigger('selected');
                                            el.trigger('selected');
                                            options.onSelecting($(this));
                                            options.onSelected($(this));
                                        } else {
                                            $(this).removeClass('es-selected').trigger('unselected');
                                            el.trigger('unselected');
                                            options.onSelecting($(this))
                                            options.onUnSelected($(this));
                                        }
                                    });
                                    if (!hasClass) {
                                        $(this).addClass('es-selected').trigger('selected');
                                        el.trigger('selected');
                                        options.onSelecting($(this));
                                        options.onSelected($(this));
                                    } else {
                                        $(this).removeClass('es-selected').trigger('unselected');
                                        el.trigger('unselected');
                                        options.onSelecting($(this));
                                        options.onUnSelected($(this));
                                    }
                                    var relativeX = (e.pageX - offset.left);
                                    var relativeY = (e.pageY - offset.top);
                                });
                                $(document).on('mouseup', function () {
                                    el.off('mouseover');
                                });
                            } else {
                                el.off('mousedown');
                            }
                        };
                    })(jQuery);
</script>
<script type="text/javascript">
            $(document).ready(function (e) {
                $("#formadd").on('submit', (function (e) {
                    $("#formaddbtn").button('loading');
                    e.preventDefault();
                    $.ajax({
                        url: '<?php echo base_url(); ?>admin/vehicle/add',
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
                            //  alert("Fail")
                        }
                    });
                }));
            });
            $(document).ready(function (e) {
                $("#formedit").on('submit', (function (e) {
                    $("#formeditbtn").button('loading');

                    e.preventDefault();
                    $.ajax({
                        url: '<?php echo base_url(); ?>admin/vehicle/update',
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
                            $("#formeditbtn").button('reset');
                        },
                        error: function () {
                            //  alert("Fail")
                        }
                    });
                }));
            });
            function getRecord(id) {
                $('#myModaledit').modal('show');
                $.ajax({
                    url: '<?php echo base_url(); ?>admin/vehicle/edit',
                    type: "POST",
                    data: {id: id},
                    dataType: 'json',
                    success: function (data) {
                        $("#ids").val(data.id);
                        $("#vehicle_nos").val(data.vehicle_no);
                        $("#vehicle_models").val(data.vehicle_model);
                        $("#manufacture_years").val(data.manufacture_year);
                        $("#driver_names").val(data.driver_name);
                        $("#driver_licences").val(data.driver_licence);
                        $("#driver_contacts").val(data.driver_contact);
                        $("#vehicle_type").val(data.vehicle_type);
                        $("#note").text(data.note);
                    },
                });
            }
            function holdModal(modalId) {
                $('#' + modalId).modal({
                    backdrop: 'static',
                    keyboard: false,
                    show: true
                });
            }

</script>

