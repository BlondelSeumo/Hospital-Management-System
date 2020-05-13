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
                        <h3 class="box-title titlefix"><?php echo $this->lang->line('ambulance_call_list'); ?></h3>
                        <div class="box-tools pull-right">
                            <?php if ($this->rbac->hasPrivilege('ambulance_call', 'can_add')) { ?> 
                                <a data-toggle="modal" onclick="holdModal('myModal')" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> <?php echo $this->lang->line('add') . " " . $this->lang->line('ambulance_call'); ?></a>
                            <?php } ?>
                        </div>
                    </div><!-- /.box-header -->

                    <div class="box-body">
                        <div class="download_label"><?php echo $this->lang->line('ambulance_call_list'); ?>

                        </div>
                        <table class="table table-striped table-bordered table-hover example" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th><?php echo $this->lang->line('ambulance_call') . " " . $this->lang->line('no'); ?></th>
                                    <th><?php echo $this->lang->line('patient') . " " . $this->lang->line('name'); ?></th>
                                    <th><?php echo $this->lang->line('contact') . " " . $this->lang->line('no'); ?></th>
                                    <th><?php echo $this->lang->line('vehicle_no'); ?></th>
                                    <th><?php echo $this->lang->line('vehicle_model'); ?></th>
                                    <th><?php echo $this->lang->line('driver_name'); ?></th>
                                    <th><?php echo $this->lang->line('patient') . " " . $this->lang->line('address'); ?></th>
                                    <th><?php echo $this->lang->line('date'); ?></th>
                                    <th class="text-right"><?php echo $this->lang->line('amount') . " (" . $currency_symbol . ")"; ?>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($listCall)) {
                                    ?>
                                    <?php
                                } else {
                                    $count = 1;
                                    foreach ($listCall as $data) {
                                        ?>
                                        <tr class="">
                                            <td><?php echo $data['bill_no']; ?></td>
                                            <td>
                                                <?php echo $data['patient'] ?>
                                                <div class="rowoptionview">
                                                    <?php
                                                    if ($this->rbac->hasPrivilege('ambulance_call', 'can_edit')) {
                                                        ?>
                                                        <a href="#" onclick="getRecord('<?php echo $data['id'] ?>')" class="btn btn-default btn-xs" data-target="#editModal" data-toggle="tooltip" title="<?php echo $this->lang->line('edit'); ?>">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>     
                                                    <?php } ?>
                                                    <?php if ($this->rbac->hasPrivilege('ambulance_call', 'can_delete')) { ?>
                                                        <a class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('delete'); ?>" onclick="delete_recordById('<?php echo base_url(); ?>admin/vehicle/deletecallambulance/<?php echo $data['id'] ?>', '<?php echo $this->lang->line('delete_message') ?>')">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    <?php } ?>
                                                    <?php
                                                    if ($this->rbac->hasPrivilege('ambulance bill', 'can_view')) {
                                                        ?>
                                                        <a href="#" onclick="viewDetailBill('<?php echo $data['id'] ?>')" class="btn btn-default btn-xs" data-target="#editModal" data-toggle="tooltip" title="<?php echo $this->lang->line('print'); ?>">
                                                            <i class="fa fa-print"></i>
                                                        </a>     
                                                    <?php } ?>
                                                </div>  
                                            </td>
                                            <td><?php echo $data['mobileno'] ?></td>
                                            <td><?php echo $data['vehicle_no'] ?></td>
                                            <td><?php echo $data['vehicle_model']; ?></td>
                                            <td><?php echo $data['driver']; ?></td> 
                                            <td><?php echo $data['address']; ?></td>
                                            <td><?php echo date($this->customlib->getSchoolDateFormat(true, true), strtotime($data['date'])); ?></td>
                                            <td class="text-right"><?php echo $data['amount']; ?></td>
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
</div>
<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close pt4" data-dismiss="modal">&times;</button>
                <div class="row">
                    <div class="col-sm-6 col-xs-8" >
                        <div class="form-group15">
                           <div>
                                <select onchange="get_PatientDetails(this.value)" style="width:100%" class="form-control select2"  name='patient_id' id="addpatient_id" >
                                    <option value=""><?php echo $this->lang->line('select') . " " . $this->lang->line('patient') ?></option>
                                    <?php foreach ($patients as $dkey => $dvalue) {
                                        ?>
                                        <option value="<?php echo $dvalue["id"]; ?>" <?php
                                        if ((isset($patient_select)) && ($patient_select == $dvalue["id"])) {
                                            echo "selected";
                                        }
                                        ?>><?php echo $dvalue["patient_name"] . " (" . $dvalue["patient_unique_id"] . ')' ?></option>   
                                            <?php } ?>
                                </select>
                            </div>
                            <span class="text-danger"><?php echo form_error('refference'); ?></span>
                        </div>
                    </div><!--./col-sm-8-->
                    <div class="col-sm-4 col-xs-3">
                        <div class="form-group15">
                            <?php if ($this->rbac->hasPrivilege('patient', 'can_add')) { ?>
                                <a data-toggle="modal" id="add" onclick="holdModal('myModalpa')" class="modalbtnpatient"><i class="fa fa-plus"></i>  <span><?php echo $this->lang->line('new') . " " . $this->lang->line('patient') ?></span></a> 
                            <?php } ?> 

                        </div>
                    </div><!--./col-sm-4--> 
                </div><!-- ./row -->   
            </div>
            <form  id="formcall" method="post" accept-charset="utf-8">    
                <div class="modal-body pt0 pb0">
                    <div class="ptt10">
                        <div class="row">
                            <input name="patient_name" id="patientid" type="hidden" class="form-control" />
                            <div class="col-sm-12">                     
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('vehicle_model'); ?></label><small class="req"> *</small>
                                    <select name="vehicle_no" id="vehicle_no" class="form-control" onchange="getVehicleDetail(this.value)">
                                        <option value=""><?php echo $this->lang->line('select') ?></option>
                                        <?php foreach ($vehiclelist as $key => $vehicle) {
                                            ?>
                                            <option value="<?php echo $vehicle["id"] ?>"><?php echo $vehicle["vehicle_model"] . " - " . $vehicle["vehicle_no"] ?></option>
                                        <?php } ?>
                                    </select>
                                    <span class="text-danger"><?php echo form_error('vehicle_no'); ?></span>
                                </div>
                            </div>
                            <!-- <div class="col-sm-4">
                              <div class="form-group">
                                  <label for="exampleInputEmail1"><?php echo $this->lang->line('vehicle_model'); ?></label>
                                  <input name="vehicle_model" id="vehicle_model_search" readonly type="text" class="form-control" />
                              </div>
                            </div> -->
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('driver_name'); ?></label>
                                    <input name="driver" id="driver_search"  type="text" class="form-control" />
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('date'); ?></label><small class="req"> *</small>
                                    <input name="date" type="text" class="form-control datetime" />
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('amount') . " (" . $currency_symbol . ")"; ?></label><small class="req"> *</small>
                                    <input name="amount" type="text" class="form-control" />
                                </div>
                            </div>
                            <!-- <div class="col-md-3">
                               <div class="form-group"> 
                               <label><?php echo $this->lang->line('patient'); ?></label><small class="req"> *</small>   
                               <select onchange="get_PatientDetails(this.value)"  style="width: 100%" class="form-control select2" id="" name='' >
                                    <option value=""><?php echo $this->lang->line('select') . " " . $this->lang->line('patient') ?></option> 
                            <?php foreach ($patients as $dkey => $dvalue) { ?>
                                            <option value="<?php echo $dvalue["id"]; ?>" <?php
                                if ((isset($patient_select)) && ($patient_select == $dvalue["id"])) {
                                    echo "selected";
                                }
                                ?>><?php echo $dvalue["patient_name"] . " ( " . $dvalue["patient_unique_id"] . ")" ?></option>   
<?php } ?>
                               </select> 
                                </div>
                           </div>
                           <div class="col-sm-3">
                               <div class="form-group">
                                   <label for="exampleInputEmail1"><?php echo $this->lang->line('patient') . " " . $this->lang->line('name'); ?></label><small class="req"> *</small>
                                   <input  name="patient_name"  id="patientname" type="text" class="form-control"/>
                                   <span class="text-danger"><?php echo form_error('patient_name'); ?></span>
                               </div>
                           </div>-->
                            <!--<div class="col-sm-3">
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('contact') . " " . $this->lang->line('no'); ?></label>
                                    <input name="contact_no"  type="text" class="form-control"  />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('address'); ?></label>
                                    <textarea class="form-control" name="address" row='2' placeholder=""></textarea>
                                </div>
                            </div>-->
                        </div>
                    </div>
                </div>  
                <div class="box-footer">
                    <button type="submit" data-loading-text="<?php echo $this->lang->line('processing') ?>" id="formcallbtn" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                    <div class="pull-right" style="margin-right:10px;">
                        <button type="button"  data-loading-text="<?php echo $this->lang->line('processing') ?>" class="btn btn-info pull-right printsavebtn"><?php echo $this->lang->line('save') . " & " . $this->lang->line('print'); ?></button>
                    </div>
                </div>

            </form>


        </div>    
    </div>
</div>
<div class="modal fade" id="editModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close pt4" data-dismiss="modal">&times;</button>
                <div class="row">
                    <div class="col-sm-8">
                        <div>   
                            <select onchange="get_PatienteditDetails(this.value)"  style="width: 100%" class="form-control select2" id="addpatientid" name='patient_id' >
                                <option value=""><?php echo $this->lang->line('select') . " " . $this->lang->line('patient') ?></option> 
                                <?php foreach ($patients as $dkey => $dvalue) { ?>
                                    <option value="<?php echo $dvalue["id"]; ?>" <?php
                                            if ((isset($patient_select)) && ($patient_select == $dvalue["id"])) {
                                                echo "selected";
                                            }
                                            ?>><?php echo $dvalue["patient_name"] . " ( " . $dvalue["patient_unique_id"] . ")" ?></option>   
                    <?php } ?>
                            </select> 
                        </div>
                    </div><!--./col-sm-9-->  
                    <!--<div class="col-sm-3">
<?php if ($this->rbac->hasPrivilege('patient', 'can_add')) { ?>
                                <a data-toggle="modal" id="add" onclick="holdModal('myModalpa')" class="btn btn-default btn-sm" style="height: 28px;padding-top: 6px"><i class="fa fa-plus"></i>  <?php echo $this->lang->line('new') . " " . $this->lang->line('patient') ?></a> 
<?php } ?> 
                    </div>--><!--./col-sm-3-->


                </div><!--./row-->  
            </div>
            <form  id="formedit" method="post" accept-charset="utf-8">    
                <div class="modal-body pt0 pb0">
                    <div class="ptt10">
                        <div class="row">

                            <input name="patient_name" id="patienteditid" type="hidden" class="form-control" value="<?php echo set_value('patient_name'); ?>"/>
                            <input  name="id" id="id" type="hidden" class="form-control" value="<?php echo set_value('id'); ?>" />
                            <div class="col-sm-12">                     
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('vehicle_no'); ?></label><small class="req"> *</small>
                                    <select name="vehicle_no"  style="width: 100%" id="vehicleno" class="form-control" onchange="getVehicleDetail(this.value, 'vehicle_model', 'driver_name')">
                                        <option value=""><?php echo $this->lang->line('select') ?></option>
<?php foreach ($vehiclelist as $key => $vehicle) {
    ?>
                                            <option value="<?php echo $vehicle["id"] ?>"><?php echo $vehicle["vehicle_model"] . " - " . $vehicle["vehicle_no"] ?></option>
<?php } ?>
                                    </select>

                                    <span class="text-danger"><?php echo form_error('vehicle_model'); ?></span>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('driver_name'); ?></label>
                                    <input name="driver_name" id="driver_name" type="text" class="form-control" value="<?php echo set_value('vehicle_model'); ?>"/>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('date'); ?></label><small class="req"> *</small>
                                    <input name="date" id="edit_date" type="text" class="form-control datetime" value="<?php echo set_value('amount'); ?>"/>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('amount') . " (" . $currency_symbol . ")"; ?> <small class="req"> *</small></label>
                                    <input name="amount" id="amount" type="text" class="form-control" value="<?php echo set_value('amount'); ?>"/>
                                </div>
                            </div>
                            <!--<div class="col-sm-3">
                                <div class="form-group">
                                    <input  name="id" id="id" type="hidden" class="form-control" value="<?php echo set_value('id'); ?>" />
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('patient') . " " . $this->lang->line('name'); ?></label><small class="req"> *</small>
                                    <input  name="patient_name" id="patient_name" type="text" class="form-control" value="<?php echo set_value('patient_name'); ?>"/>
                                    <span class="text-danger"><?php echo form_error('patient_name'); ?></span>
                                </div>
                            </div>-->
                            <!-- <div class="col-sm-3">
                                 <div class="form-group">
                                     <label for="exampleInputEmail1"><?php echo $this->lang->line('contact') . " " . $this->lang->line('no'); ?></label>
                                     <input name="contact_no" id="contact_no" type="text" class="form-control" value="<?php echo set_value('contact_no'); ?>" />
                                 </div>
                             </div>
                             <div class="col-sm-6">
                                 <div class="form-group">
                                     <label for="exampleInputEmail1"><?php echo $this->lang->line('address'); ?></label>
                                     <textarea class="form-control" name="address" id="address" row='2'><?php echo set_value('address'); ?></textarea>
                                 </div>
                             </div>-->

                        </div>
                    </div>
                </div>   
                <div class="box-footer">
                    <button type="submit" data-loading-text="<?php echo $this->lang->line('processing') ?>" id="formeditbtn" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                </div>


            </form> 
        </div>    
    </div>
</div>

<div class="modal fade" id="viewModalBill"  role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-toggle="tooltip" title="<?php echo $this->lang->line('clase'); ?>" data-dismiss="modal">&times;</button>
                <div class="modalicon"> 
                    <div id='edit_deletebill'>
                        <a href="#"  data-target="#edit_prescription"  data-toggle="modal" title="" data-original-title="<?php echo $this->lang->line('edit'); ?>"><i class="fa fa-pencil"></i></a>

                        <a href="#" data-toggle="tooltip" title="" data-original-title="<?php echo $this->lang->line('delete'); ?>"><i class="fa fa-trash"></i></a>
                    </div>
                </div>
                <h4 class="box-title"><?php echo $this->lang->line('bill') . " " . $this->lang->line('details'); ?></h4> 
            </div>
            <div class="modal-body pt0 pb0">
                <div id="reportdata"></div>
            </div>
        </div>
    </div>    
</div>

<script type="text/javascript">
    $(function () {
        $('#easySelectable').easySelectable();
        $('.select2').select2()
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

                $(".printsavebtn").on('click', (function (e) {
                    // $(this).submit();
                    var form = $(this).parents('form').attr('id');
                    var str = $("#" + form).serializeArray();
                    var postData = new FormData();
                    $.each(str, function (i, val) {
                        postData.append(val.name, val.value);
                    });
                    //  $("#"+form).submit();

                    $("#formcallbtn").button('loading');
                    e.preventDefault();
                    $.ajax({
                        url: '<?php echo base_url(); ?>admin/vehicle/addCallAmbulance',
                        type: "POST",
                        data: postData,
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
                                //var insertid = insert_id;
                                //console.log(insert_id);
                                successMsg(data.message);
                                printData(data.id);

                                // window.location.reload(true);
                            }
                            $("#formcallbtn").button('reset');
                        },
                        error: function () {
                            //  alert("Fail")
                        }
                    });


                }));
            });

            function printData(id) {

                var base_url = '<?php echo base_url() ?>';
                $.ajax({
                    url: base_url + 'admin/vehicle/getBillDetails/' + id,
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
                frameDoc.document.write('<body >');
                frameDoc.document.write(data);
                frameDoc.document.write('</body>');
                frameDoc.document.write('</html>');
                frameDoc.document.close();
                setTimeout(function () {
                    window.frames["frame1"].focus();
                    window.frames["frame1"].print();
                    frame1.remove();
                    window.location.reload(true);
                }, 500);


                return true;
            }

            $(document).ready(function (e) {
                $("#formcall").on('submit', (function (e) {
                    $("#formcallbtn").button('loading');
                    e.preventDefault();
                    $.ajax({
                        url: '<?php echo base_url(); ?>admin/vehicle/addCallAmbulance',
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
                            $("#formcallbtn").button('reset');
                        },
                        error: function () {
                            //  alert("Fail")
                        }
                    });
                }));
            });

            function get_PatientDetails(id) {

                $.ajax({
                    url: '<?php echo base_url(); ?>admin/patient/patientDetails',
                    type: "POST",
                    data: {id: id},
                    dataType: 'json',
                    success: function (res) {
                        //console.log(res);
                        if (res) {
                            $('#patientid').val(res.id);
                            //$('#patientname').val(res.patient_name);

                        }
                    }
                });
            }

            function viewDetailBill(id) {
                $.ajax({
                    url: '<?php echo base_url() ?>admin/vehicle/getBillDetails/' + id,
                    type: "GET",
                    data: {id: id},
                    success: function (data) {
                        $('#reportdata').html(data);
                        $('#edit_deletebill').html("<?php if ($this->rbac->hasPrivilege('ambulance bill', 'can_view')) { ?><a href='#' data-toggle='tooltip' onclick='printData(" + id + ")'   data-original-title='<?php echo $this->lang->line('print'); ?>'><i class='fa fa-print'></i></a> <?php } ?><?php if ($this->rbac->hasPrivilege('ambulance bill', 'can_edit')) { ?><a href='#'' onclick='getRecord(" + id + ")' data-toggle='tooltip'  data-original-title='<?php echo $this->lang->line('edit'); ?>'><i class='fa fa-pencil'></i></a><?php } ?><?php if ($this->rbac->hasPrivilege('ambulance bill', 'can_edit')) { ?><a onclick='delete_bill(" + id + ")'  href='#'  data-toggle='tooltip'  data-original-title='<?php echo $this->lang->line('delete'); ?>'><i class='fa fa-trash'></i></a><?php } ?>");
                        holdModal('viewModalBill');
                    },
                });
            }
            function getRecord(id) {

                $.ajax({
                    url: '<?php echo base_url(); ?>admin/vehicle/editCall',
                    type: "POST",
                    data: {id: id},
                    dataType: 'json',
                    success: function (data) {
                        var patientDestroy = $('#addpatientid').select2();
                        var vehicleDestroy = $('#vehicleno').select2();

                        patientDestroy.val(data.patient_name).select2('').select2();
                        vehicleDestroy.val(data.vehicle_no).select2('').select2();
                        $("#id").val(data.id);
                        //$("#vehicle_no").val(data.id);
                        //$("#vehicleno").val(data.vehicle_model);
                        $("#driver_name").val(data.driver);
                        $("#patienteditid").val(data.patient_name);
                        $("#contact_no").val(data.contact_no);
                        $("#edit_date").val(data.date);
                        $("#address").val(data.address);
                        $("#amount").val(data.amount);
                        $("#viewModalBill").modal('hide');
                        $('#editModal').modal('show');
                    },
                });
            }

            function getVehicleDetail(id, vh = 'vehicle_model_search', dr = 'driver_search') {
                $("#" + dr).val("");
                $("#" + vh).val("");
                $.ajax({
                    url: '<?php echo base_url(); ?>admin/vehicle/getVehicleDetail',
                    type: "POST",
                    data: {id: id},
                    dataType: 'json',
                    success: function (data) {
                        //console.log(data)
                        $("#" + dr).val(data.driver_name);
                        $("#" + vh).val(data.vehicle_model);
                    },
                });
            }



            function get_PatienteditDetails(id) {

                $.ajax({
                    url: '<?php echo base_url(); ?>admin/patient/patientDetails',
                    type: "POST",
                    data: {id: id},
                    dataType: 'json',
                    success: function (res) {
                        //console.log(res);

                        if (res) {
                            $('#patienteditid').val(res.id);
                            //console.log(res.id);

                        }
                    }
                });
            }

            $(document).ready(function (e) {
                $("#formedit").on('submit', (function (e) {
                    $("#formeditbtn").button('loading');
                    e.preventDefault();
                    $.ajax({
                        url: '<?php echo base_url(); ?>admin/vehicle/updatecallambulance',
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

            // $(document).ready(function (e) {
            //     var date_format = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(), ['d' => 'DD', 'm' => 'MM', 'Y' => 'YYYY',]) ?>';
            //     $('#report_dayssport_date,#report_date').datetimepicker();
            // });

            function holdModal(modalId) {

                $('#' + modalId).modal({
                    backdrop: 'static',
                    keyboard: false,
                    show: true
                });
            }
            // action="<?php //echo site_url('admin/vehicle/edit/' . $id)     ?>"
</script>
<?php $this->load->view('admin/patient/patientaddmodal') ?>