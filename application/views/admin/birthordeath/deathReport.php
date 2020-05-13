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
                        <h3 class="box-title titlefix"><?php echo $this->lang->line('death_record'); ?></h3>
                        <div class="box-tools pull-right">
                            <?php
                            if ($this->rbac->hasPrivilege('death_record', 'can_add')) {
                                ?>
                                <a data-toggle="modal" onclick="holdModal('myModal')" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> <?php echo $this->lang->line('add') . " " . $this->lang->line('death_record'); ?></a> 
                            <?php } ?>
                            <div class="btn-group">
                                <ul class="dropdown-menu multi-level pull-right width300" role="menu" aria-labelledby="dropdownMenu1" id="easySelectable">
                                    <li><a href="#">All</a></li>
                                    <li><a href="#">Not Sent</a></li> 
                                    <li><a href="#">Invoiced</a></li>
                                    <li><a href="#">Not Invoiced</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#">Draft</a></li>
                                    <li class="dropdown-submenu pull-left">
                                        <a href="#">Sale Agent</a> 
                                        <ul class="dropdown-menu dropdown-menu-left">
                                            <li><a href="#">Edward Thomas</a></li>
                                            <li><a href="#">Robin Peterson</a></li>
                                            <li><a href="#">Nicolas Fleming</a></li>
                                            <li><a href="#">Glen Stark</a></li>
                                            <li><a href="#">Simon Peterson</a></li>
                                            <li><a href="#">Brian Kohlar</a></li>
                                            <li><a href="#">Laura Clinton</a></li>
                                            <li><a href="#">David Heart</a></li>
                                            <li><a href="#">Emma Thomas</a></li>
                                            <li><a href="#">Benjamin Gates</a></li>
                                            <li><a href="#">Kriti Singh</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">Sent</a></li>
                                    <li><a href="#">Expired</a></li>
                                    <li><a href="#">Declined</a></li>
                                    <li><a href="#">Accepted</a></li>
                                </ul>
                            </div>     
                        </div>    
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="download_label"><?php echo $this->lang->line('death_record'); ?></div>
                        <table class="table table-striped table-bordered table-hover example" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th><?php echo $this->lang->line('opd') . "/" . $this->lang->line('ipd'); ?></th>
                                    <th><?php echo $this->lang->line('patient') . "" . $this->lang->line('name'); ?></th>
                                    <th><?php echo $this->lang->line('gender'); ?></th>

                                    <th class=""><?php echo $this->lang->line('death_date'); ?></th>
                                    <th class=""><?php echo $this->lang->line('report'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (empty($resultlist)) {
                                    ?>

                                    <?php
                                } else {
                                    $count = 1;
                                    foreach ($resultlist as $death) {
                                        ?>
                                        <tr class="">
                                            <td class=""><?php echo $death['opdipd_no']; ?></td>
                                            <td>
                                                <?php echo $death['patient_name']; ?>  
                                                <div class="rowoptionview">
                                                    <a href="#" 
                                                       onclick="viewDetail('<?php echo $death['id'] ?>')"
                                                       class="btn btn-default btn-xs"  data-toggle="tooltip"
                                                       title="<?php echo $this->lang->line('show'); ?>" >
                                                        <i class="fa fa-reorder"></i>
                                                    </a> 
                                                    <?php
                                                    if ($this->rbac->hasPrivilege('death_record', 'can_edit')) {
                                                        ?>
                                                        <a href="#" onclick="getRecord('<?php echo $death['id'] ?>')" class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('edit'); ?>">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>      
                                                    <?php } if ($this->rbac->hasPrivilege('death_record', 'can_delete')) { ?>
                                                        <a  class="btn btn-default btn-xs" data-toggle="tooltip" title="" onclick="delete_recordById('<?php echo base_url(); ?>admin/birthordeath/deletedeath/<?php echo $death['id']; ?>', '<?php echo $this->lang->line('delete_message'); ?>')" data-original-title="<?php echo $this->lang->line('delete'); ?>">
                                                            <i class="fa fa-trash"></i>
                                                        </a>    
                                                    <?php } ?> 
                                                </div> 
                                            </td>
                                            <td class=""><?php echo $death['gender']; ?></td>
                                            <td class=""><?php echo date($this->customlib->getSchoolDateFormat(true, true), strtotime($death['death_date'])); ?></td>
                                            <td class=""><?php echo $death['death_report']; ?></td>
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
<div class="modal fade" id="myModal"  role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="box-title"><?php echo $this->lang->line('add') . " " . $this->lang->line('death') . " " . $this->lang->line('record'); ?></h4> 
            </div>
            <div class="modal-body pt0 pb0">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 paddlr">
                        <form id="formadd" accept-charset="utf-8" method="post" class="ptt10" >
                            <div class="row">
                                <input type="hidden" id="patient_id" name="patient" value=<?php set_value('id') ?>> 

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="">
                                            <?php echo $this->lang->line('patient') . " " . $this->lang->line('name'); ?>
                                        </label>
                                        <small class="req">*</small>
                                        <div>
                                            <select onchange="get_PatientDetails(this.value)"  style="width: 100%" class="form-control select2"<?php
                                            if ($disable_option == true) {
                                                echo "disabled";
                                            }
                                            ?> id="" name='' >
                                                <option value=""><?php echo $this->lang->line('select') ?></option>
                                                <?php foreach ($patients as $dkey => $dvalue) {
                                                    ?>
                                                    <option value="<?php echo $dvalue["id"]; ?>" <?php
                                                    if ((isset($patient_select)) && ($patient_select == $dvalue["id"])) {
                                                        echo "selected";
                                                    }
                                                    ?>><?php echo $dvalue["patient_name"] . " ( " . $dvalue["patient_unique_id"] . ")" ?></option>   
<?php } ?>
                                            </select>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('ipd') . "/" . $this->lang->line('opd') . " " . $this->lang->line('no');
;
?></label>
                                        <input type="text" name="opdipd_no" id="opdipd_no" class="form-control">    
                                        <span class="text-danger"><?php echo form_error('opdipd_no'); ?></span>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('death_date'); ?></label>
                                        <small class="req">*</small>
                                        <input id="death_date" name="death_date" placeholder="" type="text" class="form-control datetime"   />
                                        <span class="text-danger"><?php echo form_error('death_date'); ?></span>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('guardian') . " " . $this->lang->line('name'); ?></label><small class="req"> *</small> 
                                        <input type="text" name="guardian_name" id="guardian_name" class="form-control">    
                                        <span class="text-danger"><?php echo form_error('guardian_name'); ?></span>
                                    </div>
                                </div>



                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="email"><?php echo $this->lang->line('report'); ?></label> 
                                        <textarea name="death_report" id="death_report" class="form-control" ><?php echo set_value('death_report'); ?></textarea>
                                    </div> 
                                </div>
                                <div class="">
<?php
echo display_custom_fields('death_report');
?>
                                </div>

                            </div><!--./row-->  

                    </div><!--./col-md-12-->  
                    <div class="box-footer" style="clear: both;">
                        <div class="pull-right">
                            <button type="submit" id="formaddbtn" data-loading-text="<?php echo $this->lang->line('processing') ?>" class="btn btn-info"><?php echo $this->lang->line('save'); ?></button>
                        </div>
                    </div>       
                    </form>     
                </div><!--./row--> 
            </div>
        </div>
    </div>    
</div>
<!-- dd -->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class="modalicon"> 
                    <div id='edit_delete'>
                       

                    </div>
                </div>
                <h4 class="box-title"><?php echo $this->lang->line('death_record') . " " . $this->lang->line('information'); ?></h4> 
            </div>
            <div class="modal-body pt0 pb0">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <form id="view" accept-charset="utf-8" method="get" class="">
                            <div class="table-responsive">
                                <table class="table mb0 table-striped table-bordered examples tablelr0space">
                                    <tr>
                                        <th><?php echo $this->lang->line('opd_ipd_no') ?></th>
                                        <td><span id='vopdipd_no'></span></td>
                                        <th><?php echo $this->lang->line('patient') . " " . $this->lang->line('name'); ?></th>
                                        <td><span id='vpatient'></span></td>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><?php echo $this->lang->line('gender'); ?></th>
                                        <td><span id="vgender"></span>
                                        </td>
                                        <th><?php echo $this->lang->line('death_date'); ?></th>
                                        <td><span id='vdeath_date'></span></td>
                                    </tr>
                                    <tr>
                                        <th><?php echo $this->lang->line('address'); ?></th>
                                        <td><span id="vaddress"></span>
                                        </td>
                                        <th><?php echo $this->lang->line('death_report'); ?></th>
                                        <td><span id="vdeath_report"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><?php echo $this->lang->line('guardian_name'); ?></th>
                                        <td><span id="vguardian_name"></span>

                                    </tr>
                                    <tr id="field_data">
                                        <th><span id="vcustom_name"></span></th>
                                        <td><span id="vcustom_value"></span>
                                        </td>
                                    </tr>

                                </table>
                            </div>
                        </form>                       
                    </div><!--./col-md-12-->       
                </div><!--./row--> 
                <div id="tabledata"></div>
            </div>


        </div>
    </div>
</div>    
</div>

<div class="modal fade" id="myModaledit"  role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="box-title"><?php echo $this->lang->line('edit') . " " . $this->lang->line('death') . " " . $this->lang->line('record'); ?></h4> 
            </div>
            <div class="modal-body pt0 pb0">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 paddlr">
                        <form id="formedit" accept-charset="utf-8" method="post" class="ptt10">
                            <div class="row">
                                <input type="hidden" name="id" id="eid" value="<?php echo set_value('id'); ?>">

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="">
<?php echo $this->lang->line('patient') . " " . $this->lang->line('name'); ?>
                                        </label>
                                        <small class="req">*</small>
                                        <div>
                                            <select onchange="get_PatientDetails(this.value)"  style="width: 100%" class="form-control select2" id="epatient_name" name='patient' >
                                                <option value="<?php echo set_value('patient'); ?>"><?php echo $this->lang->line('select') ?></option>
                                                <?php foreach ($patients as $dkey => $dvalue) {
                                                    ?>
                                                    <option value="<?php echo $dvalue["id"]; ?>" ><?php echo $dvalue["patient_name"] . " ( " . $dvalue["patient_unique_id"] . ")" ?></option>   
<?php } ?>
                                            </select>
                                        </div>

                                    </div>
                                </div>


                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('ipd') . "/" . $this->lang->line('opd') . " " . $this->lang->line('no');
;
?></label>
                                        <input type="text" name="opdipd_no" value="<?php echo set_value('opdipd_no'); ?>" id="eopdipd_no" class="form-control">    
                                        <span class="text-danger"><?php echo form_error('opdipd_no'); ?></span>
                                    </div>
                                </div>



                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('death_date'); ?></label>
                                        <small class="req">*</small>
                                        <input id="edeath_date" value="<?php echo set_value('death_date'); ?>" name="death_date" placeholder="" type="text" class="form-control datetime"   />
                                        <span class="text-danger"><?php echo form_error('death_date'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('guardian') . " " . $this->lang->line('name'); ?></label><small class="req"> *</small> 
                                        <input type="text" value="<?php echo set_value('guardian_name'); ?>" name="guardian_name" id="eguardian_name" class="form-control">    
                                        <span class="text-danger"><?php echo form_error('guardian_name'); ?></span>
                                    </div>
                                </div>


                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="email"><?php echo $this->lang->line('report'); ?></label> 
                                        <textarea name="death_report" id="edeath_report" class="form-control" ><?php echo set_value('death_report'); ?></textarea>
                                    </div> 
                                </div>
                                <div class="col-sm-12" id="customdata">
                                </div>

                            </div>



                    </div><!--./col-md-12--> 
                    <div class="box-footer" style="clear: both;">

                        <button type="submit" id="formeditbtn" data-loading-text="<?php echo $this->lang->line('processing') ?>" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                    </div>      
                </div><!--./row--> 
            </div> </form>

        </div>
    </div>    
</div>


<script type="text/javascript">




    $('#myModal').on('hidden.bs.modal', function (e) {
        $(this).find('#formadd')[0].reset();
    });

    $(function () {
        $('#easySelectable').easySelectable();
        $('.select2').select2()
//stopPropagation();
    })

    function apply_to_all() {

        var standard_charge = $("#standard_charge").val();


        $('input name=schedule_charge_id').val(standard_charge);
    }

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
    function getChargeCategory(charge_type, charge_category) {

        $('#edit_charge_category').html("<option value=''><?php echo $this->lang->line('loading') ?></option>");
        var base_url = '<?php echo base_url() ?>';
        var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>admin/charges/get_charge_category',
            data: {'charge_type': charge_type},
            dataType: "json",
            success: function (data) {
                $.each(data, function (i, obj) {
                    var sel = "";
                    if (charge_category == obj.name) {
                        sel = "selected";
                    }
                    div_data += "<option value='" + obj.name + "'  " + sel + ">" + obj.name + "</option>";
                });
                $('#edit_charge_category').append(div_data);
            }
        });
    }
    function getcharge_category(id, htmlid) {
        var div_data = "";
        $("#" + htmlid).html("<option value='l'><?php echo $this->lang->line('loading') ?></option>");
        $.ajax({
            url: '<?php echo base_url(); ?>admin/charges/get_charge_category',
            type: "POST",
            data: {charge_type: id},
            dataType: 'json',
            success: function (res) {
                $.each(res, function (i, obj)
                {
                    var sel = "";
                    div_data += "<option value='" + obj.name + "'>" + obj.name + "</option>";
                });
                $("#" + htmlid).html("<option value=''>Select</option>");
                $('#' + htmlid).append(div_data);
            }
        });
    }


    $(document).ready(function (e) {
        $("#formadd").on('submit', (function (e) {
            $("#formaddbtn").button('loading');
            e.preventDefault();
            $.ajax({
                url: '<?php echo base_url(); ?>admin/birthordeath/addDeathdata',
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
        $("#formedit").on('submit', (function (e) {
            $("#formeditbtn").button('loading');
            e.preventDefault();
            $.ajax({
                url: '<?php echo base_url(); ?>admin/birthordeath/update_death',
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

                }
            });
        }));
    });
    $(document).ready(function (e) {
        var date_format = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(), ['d' => 'DD', 'm' => 'MM', 'Y' => 'YYYY',]) ?>';



        $('#dates_of_birth , #date_of_birth').datepicker();
    });

    function viewDetail(id) {
        $('#viewModal').modal('show');
        $.ajax({
            url: '<?php echo base_url(); ?>admin/birthordeath/getDeathdata',
            type: "POST",
            data: {id: id},
            dataType: 'json',
            success: function (data) {
                $("#vid").html(data.id);
                $("#vopdipd_no").html(data.opdipd_no);
                //console.log(data.child_name);
                $("#vpatient").html(data.patient_name);
                $("#vgender").html(data.gender);
                $("#vimage").html(data.image);
                $("#vdeath_date").html(data.death_date);
                $("#vguardian_name").html(data.guardian_name);
                $("#vcontact").html(data.contact);
                $("#vaddress").html(data.address);
                $("#vdeath_report").html(data.death_report);
                var table_html = '';

                $.each(data.field_data, function (i, obj)
                {
                    if (obj.field_value == null) {
                        var field_value = "";
                    } else {
                        var field_value = obj.field_value;
                    }
                    table_html += "<th><span id='vcustom_name'>" + obj.name + "</span></th><td><span id='vcustom_value'>" + field_value + "</span></td>";
                });

                $("#field_data").html(table_html);
                $('#edit_delete').html("<?php if ($this->rbac->hasPrivilege('death_record', 'can_view')) { ?><a href='#' data-toggle='tooltip' onclick='printData(" + id + ")'   data-original-title='<?php echo $this->lang->line('print'); ?>'><i class='fa fa-print'></i></a> <?php } ?><?php if ($this->rbac->hasPrivilege('death_record', 'can_edit')) { ?><a href='#'' onclick='getRecord(" + id + ")' data-toggle='tooltip'  data-original-title='<?php echo $this->lang->line('edit'); ?>'><i class='fa fa-pencil'></i></a><?php } ?><?php if ($this->rbac->hasPrivilege('death_record', 'can_delete')) { ?><a onclick='delete_bill(" + id + ")'  href='#'  data-toggle='tooltip'  data-original-title='<?php echo $this->lang->line('delete'); ?>'><i class='fa fa-trash'></i></a><?php } ?>");
            },
        });
    }


    function get_PatientDetails(id) {
        //$("#patient_name").html("patient_name");
        //$("#schedule_charge").html("schedule_charge");

        $.ajax({
            url: '<?php echo base_url(); ?>admin/pharmacy/patientDetails',
            type: "POST",
            data: {id: id},
            dataType: 'json',
            success: function (res) {

                if (res) {
                    $('#patient_name').val(res.patient_name);
                    $('#patient_id').val(res.id);
                } else {
                    $('#patient_name').val('Null');

                }
            }
        });
    }
    function getRecord(id) {
        $('#myModaledit').modal('show');
        $.ajax({
            url: '<?php echo base_url(); ?>admin/birthordeath/editDeath',
            type: "POST",
            data: {id: id},
            dataType: 'json',
            success: function (data) {
                $("#eid").val(data.id);
                $("#eopdipd_no").val(data.opdipd_no);
                var $exampleDestroy = $('#epatient_name').select2();
                var table_html = '';
                $.each(data.field_data, function (i, obj)
                {
                    if (obj.field_value == null) {
                        var field_value = "";
                    } else {
                        var field_value = obj.field_value;
                    }
                    table_html += "<div class='form-group'><label for='exampleInputFile'>" + obj.name + "</label><div><input class='form-control' type='text' name='custom_field_value[]'  value='" + field_value + "'  size='20' data-height='26' /></div><span class='text-danger'></span><input type='hidden' name='custom_field_id[]' value='" + obj.cid + "'><input type='hidden' name='custom_field[]' value='" + obj.name + "'><input type='hidden' name='belong_table_id' value='" + obj.belong_table_id + "'></div>";

                });

                $("#customdata").html(table_html);




                $("#edeath_date").val(data.death_date);
                $("#eguardian_name").val(data.guardian_name);
                //$("#econtact").val(data.contact);
                // $("#eaddress").val(data.address);
                $("#edeath_report").val(data.death_report);
                $exampleDestroy.val(data.patient).select2('').select2();


            },
        });
    }

    function delete_bill(id) {
        if (confirm('<?php echo $this->lang->line('delete_conform') ?>')) {
            $.ajax({
                url: '<?php echo base_url(); ?>admin/birthordeath/deletedeath/' + id,

                success: function (res) {
                    successMsg('<?php echo $this->lang->line('delete_message'); ?>');
                    window.location.reload(true);
                },
                error: function () {
                    alert("Fail")
                }
            });
        }
    }

    function printData(id) {

        var base_url = '<?php echo base_url() ?>';
        $.ajax({
            url: base_url + 'admin/birthordeath/getDeathprintDetails/' + id,
            type: 'POST',
            data: {id: id, print: 'yes'},
            success: function (result) {
                // $("#testdata").html(result);
                popup(result);

            }
        });
    }

    function popup(data)
    {
        var base_url = '<?php echo base_url() ?>';
        var frame1 = $('<iframe />');
        frame1[0].name = "frame1";
        frame1.css({"position": "absolute", "top": "-1000000px"});
        $("body").append(frame1);
        var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
        frameDoc.document.open();
        //Create a new HTML document.
        frameDoc.document.write('<html>');
        frameDoc.document.write('<head>');
        frameDoc.document.write('<title></title>');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/bootstrap/css/bootstrap.min.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/dist/css/font-awesome.min.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/dist/css/ionicons.min.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/dist/css/AdminLTE.min.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/dist/css/skins/_all-skins.min.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/plugins/iCheck/flat/blue.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/plugins/morris/morris.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/plugins/jvectormap/jquery-jvectormap-1.2.2.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/plugins/datepicker/datepicker3.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/plugins/daterangepicker/daterangepicker-bs3.css">');
        frameDoc.document.write('</head>');
        frameDoc.document.write('<body>');
        frameDoc.document.write(data);
        frameDoc.document.write('</body>');
        frameDoc.document.write('</html>');
        frameDoc.document.close();
        setTimeout(function () {
            window.frames["frame1"].focus();
            window.frames["frame1"].print();
            frame1.remove();
        }, 500);
        return true;
    }
    function apply_to_all() {
        var total = 0;
        var standard_charge = $("#standard_charge").val();
        var schedule_charge = document.getElementsByName('schedule_charge[]');
        for (var i = 0; i < schedule_charge.length; i++) {
            var inp = schedule_charge[i];
            inp.value = standard_charge;
        }
    }
    function holdModal(modalId) {
        $('#' + modalId).modal({
            backdrop: 'static',
            keyboard: false,
            show: true
        });
    }
</script>
