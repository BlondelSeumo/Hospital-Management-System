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
                        <h3 class="box-title titlefix"><?php echo $this->lang->line('blood_issue') . " " . $this->lang->line('details'); ?></h3>
                        <div class="box-tools pull-right">
                            <?php if ($this->rbac->hasPrivilege('blood_issue', 'can_add')) { ?> 
                                <a data-toggle="modal"  onclick="holdModal('myModal')" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> <?php echo $this->lang->line('issue_blood'); ?></a> 
                            <?php } ?>
                        </div> 
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="download_label"><?php echo $this->lang->line('blood_issue') . " " . $this->lang->line('details'); ?></div>
                        <table class="table table-striped table-bordered table-hover example" cellspacing="0" width="100%">
                            <thead>
                                <tr> 
                                    <th><?php echo $this->lang->line('bill') . " " . $this->lang->line('no'); ?></th>
                                    <th><?php echo $this->lang->line('issue_date'); ?></th>
                                    <th><?php echo $this->lang->line('recieved_to'); ?></th>
                                    <th><?php echo $this->lang->line('blood_group'); ?></th>
                                    <th><?php echo $this->lang->line('gender'); ?></th>
                                    <th><?php echo $this->lang->line('donor') . " " . $this->lang->line('name'); ?></th>
                                    <th><?php echo $this->lang->line('bag_no'); ?></th>
                                    <th class="text-right"><?php echo $this->lang->line('amount') . " (" . $currency_symbol . ")"; ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (empty($resultlist)) {
                                    ?>

                                    <?php
                                } else {
                                    $count = 1;
                                    foreach ($resultlist as $blood) {
                                        ?>
                                        <tr class="">
                                            <td><?php echo $blood['bill_no']; ?></a></td>
                                            <td><?php echo date($this->customlib->getSchoolDateFormat(true, true), strtotime($blood['date_of_issue'])) ?> 
                                            </td>
                                            <td>
                                                <a><?php echo $blood['patient_name']; ?></a> 
                                                <div class="rowoptionview">
                                                    <a href="#" 
                                                       onclick="viewDetail('<?php echo $blood['id'] ?>')"
                                                       class="btn btn-default btn-xs"  data-toggle="modal"
                                                       title="<?php echo $this->lang->line('show'); ?>" >
                                                        <i class="fa fa-reorder"></i>
                                                    </a> 
                                                    <a href="#" 
                                                       onclick="viewDetailBill('<?php echo $blood['id'] ?>')"
                                                       class="btn btn-default btn-xs"  data-toggle="modal"
                                                       title="<?php echo $this->lang->line('print'); ?>" >
                                                        <i class="fa fa-print"></i>
                                                    </a> 
                                                </div>  
                                            </td>
                                            <td><?php echo $blood['blood_group']; ?></td>
                                            <td><?php echo $blood['gender']; ?></td>
                                            <td><?php echo $blood['donor_name']; ?></td>
                                            <td><?php echo $blood['bag_no']; ?></td>
                                            <td class="text-right"><?php echo $blood['amount']; ?></td>
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
                <button type="button" class="close pt4" data-dismiss="modal">&times;</button>
                <div class="row">
                    <div class="col-sm-6 col-xs-5">
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
                    <div class="col-sm-4 col-xs-6">
                        <div class="form-group15">
                            <?php if ($this->rbac->hasPrivilege('patient', 'can_add')) { ?>
                                <a data-toggle="modal" id="add" onclick="holdModal('myModalpa')" class="modalbtnpatient"><i class="fa fa-plus"></i>  <span><?php echo $this->lang->line('new') . " " . $this->lang->line('patient') ?></span></a> 
                            <?php } ?> 

                        </div>
                    </div><!--./col-sm-4--> 
                </div><!-- ./row -->   
            </div>


            <form id="formadd" accept-charset="utf-8" method="post" class="ptt10" >
                <div class="modal-body pt0 pb0">
                    <input type="hidden" name="recieve_to" id="patientid" class="form-control datetime">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('issue') . " " . $this->lang->line('date'); ?></label>
                                <small class="req"> *</small> 
                                <input type="text" name="date_of_issue" id="dates_of_issue" class="form-control datetime">
                                <span class="text-danger"><?php echo form_error('date_of_issue'); ?></span>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="exampleInputFile">
                                    <?php echo $this->lang->line('hospital') . " " . $this->lang->line('doctor'); ?></label>
                                <div><select name='consultant_doctor' style="width:100%;" id="consultant_doctor" onchange="get_Docname(this.value)" class="form-control select2" <?php
                                    if ($disable_option == true) {
                                        echo "disabled";
                                    }
                                    ?> style="width:100%"  >
                                        <option value=""><?php echo $this->lang->line('select') ?></option>
                                        <?php foreach ($doctors as $dkey => $dvalue) {
                                            ?>
                                            <option value="<?php echo $dvalue["id"]; ?>" <?php
                                            if ((isset($doctor_select)) && ($doctor_select == $dvalue["id"])) {
                                                echo "selected";
                                            }
                                            ?>><?php echo $dvalue["name"] . " " . $dvalue["surname"] ?></option>   
<?php } ?>
                                    </select>

                                </div>
                                <span class="text-danger"><?php echo form_error('refference'); ?></span>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label> <?php echo $this->lang->line('doctor') . " " . $this->lang->line('name'); ?></label>
                                <small class="req">*</small> 
                                <input type="text" id="doctname" name="doctor" class="form-control">
                                <span class="text-danger"><?php echo form_error('doctor'); ?></span>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label> <?php echo $this->lang->line('technician'); ?></label>
                                <input type="text" name="technician" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group"> 
                                <label><?php echo $this->lang->line('donor') . " " . $this->lang->line('name'); ?></label><small class="req"> *</small>   
                                <select  style="width: 100%" class="form-control select2" id="" name='donor_name' onchange="getBloodGroup(this.value, 'blood_group_field')" >
                                    <option value=""><?php echo $this->lang->line('select') . " " . $this->lang->line('donor') ?></option> 
                                    <?php foreach ($blooddonar as $dkey => $dvalue) { ?>
                                        <option value="<?php echo $dvalue["id"]; ?>" <?php
                                                if ((isset($blooddonar_select)) && ($blooddonar_select == $dvalue["id"])) {
                                                    echo "selected";
                                                }
                                                ?>><?php echo $dvalue["donor_name"]; ?></option>   
<?php } ?>
                                </select> 
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label> <?php echo $this->lang->line('blood_group'); ?></label>
                                <input type="text" id="blood_group_field" readonly="" name="blood_group" class="form-control">
                            </div>
                        </div>


                        <div class="col-sm-3">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('lot'); ?></label>
                                <input type="text" name="lot" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('bag_no'); ?></label>
                                <input type="text" name="bag_no" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="amount"><?php echo $this->lang->line('amount') . " (" . $currency_symbol . ")"; ?></label>
                                <small class="req"> *</small> 
                                <input name="amount" type="text" class="form-control" />
                                <span class="text-danger"><?php echo form_error('amount'); ?></span>
                            </div>
                        </div>

                        <div class="col-sm-9">
                            <div class="form-group">
                                <label for="remark"><?php echo $this->lang->line('remarks'); ?></label> 
                                <textarea name="remark" class="form-control" ></textarea>

                            </div> 
                        </div>
                    </div><!--./row-->   
                </div><!--./modal-body-->      
                <div class="box-footer">
                    <div class="pull-right">
                        <button type="submit" data-loading-text="<?php echo $this->lang->line('processing') ?>" id="formaddbtn" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>

                    </div>
                    <div class="pull-right" style="margin-right:10px;">
                        <button type="button"  data-loading-text="<?php echo $this->lang->line('processing') ?>" class="btn btn-info pull-right printsavebtn"><?php echo $this->lang->line('save') . " & " . $this->lang->line('print'); ?></button>
                    </div>
                </div>
            </form> 



        </div>
    </div>    
</div>

<!-- dd -->
<div class="modal fade" id="myModaledit"  role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close pt4" data-dismiss="modal">&times;</button>
                <div class="row">
                    <div class="col-sm-4">
                        <div>   
                            <select onchange="get_PatienteditDetails(this.value)"  style="width: 100%" class="form-control select2" id="erecieve_to" name='patient_id' >
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



                </div><!--./row-->  
            </div>


            <form  id="formedit" accept-charset="utf-8"  method="post" class="">
                <div class="modal-body pt0 pb0">
                    <div class="row ptt10">
                        <input type="hidden" name="id" id="id" value="<?php echo set_value('id'); ?>">
                        <input type="hidden" name="recieve_to" id="patienteditid" value="<?php echo set_value('id'); ?>">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('issue') . " " . $this->lang->line('date'); ?></label>
                                <small class="req"> *</small> 
                                <input type="text" name="date_of_issue" id="date_of_issue" value="" class="form-control datetime">
                                <span class="text-danger"><?php echo form_error('date_of_issue'); ?></span>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="exampleInputFile">
                                        <?php echo $this->lang->line('hospital') . " " . $this->lang->line('doctor'); ?></label>
                                <div>
                                    <select class="form-control select2" onchange="get_docEditname(this.value)" style="width: 100%" name='consultant_doctor' id="edit_consultant_doctor">
                                        <option value="<?php echo set_value('consultant_doctor'); ?>"><?php echo $this->lang->line('select') ?></option>
<?php foreach ($doctors as $dkey => $dvalue) {
    ?>
                                            <option value="<?php echo $dvalue["id"]; ?>"><?php echo $dvalue["name"] . " " . $dvalue["surname"] ?></option>   
<?php } ?>
                                    </select>
                                </div>

                                <span class="text-danger"><?php echo form_error('refference'); ?></span>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('doctor') . " " . $this->lang->line('name'); ?></label><small class="req"> *</small> 
                                <input type="text" name="doctor" id="doctor" value="<?php echo set_value('doctor'); ?>" class="form-control">
                            </div>
                            <span class="text-danger"><?php echo form_error('doctor'); ?></span>
                        </div> 
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('technician'); ?></label>
                                <input type="text" name="technician" id="technician" value="<?php echo set_value('recieve_to'); ?>" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group"> 
                                <label><?php echo $this->lang->line('donor') . " " . $this->lang->line('name'); ?></label><small class="req"> *</small>   
                                <select  style="width: 100%" class="form-control select2" onchange="getBloodGroup(this.value, 'blood_groupedit')" id="donorname" name='donor_name' >
                                    <option value=""><?php echo $this->lang->line('select') . " " . $this->lang->line('donor') ?>
                                    </option> 
<?php foreach ($blooddonar as $dkey => $dvalue) { ?>
                                        <option value="<?php echo $dvalue["id"]; ?>" <?php
    if ((isset($blooddonar_select)) && ($blooddonar_select == $dvalue["id"])) {
        echo "selected";
    }
    ?>><?php echo $dvalue["donor_name"]; ?></option>   
<?php } ?>
                                </select> 
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('blood_group'); ?></label>
                                <input type="text" name="blood_group" id="blood_groupedit" readonly="" class="form-control">
                            </div>
                        </div>





                        <div class="col-sm-3">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('lot'); ?></label>
                                <input type="text" name="lot" class="form-control" id="lot" value="<?php echo set_value('lot'); ?>">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('bag_no'); ?></label>
                                <input type="text" name="bag_no" class="form-control" id="bag_no" value="<?php echo set_value('bag_no'); ?>">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="amount"><?php echo $this->lang->line('amount') . " (" . $currency_symbol . ")"; ?></label>
                                <small class="req"> *</small> 
                                <input name="amount" type="text" id="amount" value="<?php echo set_value('amount'); ?>" class="form-control" />
                                <span class="text-danger"><?php echo form_error('amount'); ?></span>
                            </div>
                        </div>
                        <div class="col-sm-9">
                            <div class="form-group">
                                <label for="remark"><?php echo $this->lang->line('remarks'); ?></label> 
                                <textarea name="remark" id="remark" value="<?php echo set_value('remark'); ?>" class="form-control" ></textarea>
                            </div> 
                        </div>
                    </div><!--./row--> 
                </div>    
                <div class="box-footer">
                    <div class="pull-right ">
                        <button type="submit" data-loading-text="<?php echo $this->lang->line('processing') ?>" id="formeditbtn" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>

                    </div>
                </div>  
            </form>



        </div>
    </div>    
</div>

<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class="modalicon"> 
                    <div id='edit_delete'>

                    </div>
                </div>
                <h4 class="box-title"><?php echo $this->lang->line('blood_issue') . " " . $this->lang->line('information'); ?></h4> 
            </div>
            <div class="modal-body pt0 pb0">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">

                        <div class="">
                            <table class="table mb0 table-striped table-bordered">
                                <tr>
                                    <th width="15%"><?php echo $this->lang->line('issue') . " " . $this->lang->line('date'); ?></th>
                                    <td width="35%"><span id='issue_date_html'></span></td>
                                    <th width="15%"><?php echo $this->lang->line('recieved_to'); ?></th>
                                    <td width="35%"><span id="recieve_to_html"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <th width="15%"><?php echo $this->lang->line('doctor'); ?></th>
                                    <td width="35%"><span id='doctor_name'></span></td>
                                    <th width="15%"><?php echo $this->lang->line('donor') . " " . $this->lang->line('name'); ?></th>
                                    <td width="35%"><span id='donor_names'></span></td>
                                    <!--<th width="15%"><?php echo $this->lang->line('institution'); ?></th>
                                    <td width="35%"><span id='institutions'></span></td>-->
                                </tr>

                                <tr>
                                    <th width="15%"><?php echo $this->lang->line('blood_group'); ?></th>
                                    <td width="35%"><span id='blood_groups'></span></td>
                                    <th width="15%"><?php echo $this->lang->line('gender'); ?></th>
                                    <td width="35%"><span id="genders"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <th width="15%"><?php echo $this->lang->line('lot'); ?></th>
                                    <td width="35%"><span id="lots"></span>
                                    </td>
                                    <th width="15%"><span><?php echo $this->lang->line('bag_no'); ?></span></th>
                                    <td width="35%"><span id='bag_nos'></span></td>
                                </tr>
                                <tr>
                                    <th width="15%"><?php echo $this->lang->line('technician'); ?></th>
                                    <td width="35%"><span id="technician_html"></span>
                                    </td>
                                    <th width="15%"><?php echo $this->lang->line('amount'); ?></th>
                                    <td width="35%"><span id="amount_html"></span>
                                    </td>

                                </tr>
                                <tr>

                                    <th width="15%"><?php echo $this->lang->line('remarks'); ?></th>
                                    <td width="35%"><span id="remark_html"></span>
                                    </td>

                                </tr>
                            </table>
                        </div>

                    </div><!--./col-md-12-->       
                </div><!--./row--> 
            </div>


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
        // $('#easySelectable').easySelectable();
        $('.select2').select2();
//stopPropagation();
    })
</script>

<script type="text/javascript">

    function getSectionByClass(class_id, section_id) {
        if (class_id != "" && section_id != "") {
            $('#section_id').html("");
            var base_url = '<?php echo base_url() ?>';
            var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
            $.ajax({
                type: "GET",
                url: base_url + "sections/getByClass",
                data: {'class_id': class_id},
                dataType: "json",
                success: function (data) {
                    $.each(data, function (i, obj)
                    {
                        var sel = "";
                        if (section_id == obj.section_id) {
                            sel = "selected";
                        }
                        div_data += "<option value=" + obj.section_id + " " + sel + ">" + obj.section + "</option>";
                    });
                    $('#section_id').append(div_data);
                }
            });
        }
    }

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

                }
            }
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
                    console.log(res.id);

                }
            }
        });
    }

    function get_Docname(id) {
        //$("#standard_charge").html("standard_charge");
        //$("#schedule_charge").html("schedule_charge");

        $.ajax({
            url: '<?php echo base_url(); ?>admin/patient/doctName',
            type: "POST",
            data: {doctor: id},
            dataType: 'json',
            success: function (res) {
                //alert(res);
                if (res) {
                    $('#doctname').val(res.name + " " + res.surname);
                    //$('#surname').val(res.surname);

                } else {

                }
            }
        });
    }

    function get_docEditname(id) {
        //$("#standard_charge").html("standard_charge");
        //$("#schedule_charge").html("schedule_charge");

        $.ajax({
            url: '<?php echo base_url(); ?>admin/patient/doctName',
            type: "POST",
            data: {doctor: id},
            dataType: 'json',
            success: function (res) {
                //alert(res);
                if (res) {
                    $('#doctor').val(res.name + " " + res.surname);
                    //$('#surname').val(res.surname);

                } else {

                }
            }
        });
    }

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

            $("#formaddbtn").button('loading');
            e.preventDefault();
            $.ajax({
                url: '<?php echo base_url(); ?>admin/bloodbank/addIssue',
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

                        successMsg(data.message);
                        printData(data.id);

                        // window.location.reload(true);
                    }
                    $("#formaddbtn").button('reset');
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
            url: base_url + 'admin/bloodbank/getBillDetails/' + id,
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
        $("#formadd").on('submit', (function (e) {
            $("#formaddbtn").button('loading');
            e.preventDefault();
            $.ajax({
                url: '<?php echo base_url(); ?>admin/bloodbank/addIssue',
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
                url: '<?php echo base_url(); ?>admin/bloodbank/updateIssue',
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

    function getRecord(id) {

        $.ajax({
            url: '<?php echo base_url(); ?>admin/bloodbank/getIssueDetails',
            type: "POST",
            data: {bloodissue_id: id},
            dataType: 'json',
            success: function (data) {

                $("#id").val(data.id);
                $("#date_of_issue").val(data.date_of_issue);
                $("#patienteditid").val(data.recieve_to);
                $("#doctor").val(data.doctor);
                $("#technician").val(data.technician);
                $("#amount").val(data.amount);
                $("#lot").val(data.lot);
                $("#bag_no").val(data.bag_no);
                $("#remark").val(data.remark);
                $("#blood_groupedit").val(data.blood_group);
                $("#erecieve_to").select2().select2('val', data.recieve_to);
                $("#donorname").select2().select2('val', data.donor_name);
                $('select[id="edit_consultant_doctor"] option[value="' + data.consultant_doctor + '"]').attr("selected", "selected");
                $("#viewModal").modal('hide');
                $("#viewModalBill").modal('hide');
                holdModal('myModaledit');
            },
        })
    }

    function viewDetailBill(id) {
        $.ajax({
            url: '<?php echo base_url() ?>admin/bloodbank/getBillDetails/' + id,
            type: "GET",
            data: {id: id},
            success: function (data) {
                $('#reportdata').html(data);
                $('#edit_deletebill').html("<?php if ($this->rbac->hasPrivilege('bloodissue bill', 'can_view')) { ?><a href='#' data-toggle='tooltip' onclick='printData(" + id + ")'   data-original-title='<?php echo $this->lang->line('print'); ?>'><i class='fa fa-print'></i></a> <?php } ?><?php if ($this->rbac->hasPrivilege('bloodissue bill', 'can_edit')) { ?><a href='#'' onclick='getRecord(" + id + ")' data-toggle='tooltip'  data-original-title='<?php echo $this->lang->line('edit'); ?>'><i class='fa fa-pencil'></i></a><?php } ?><?php if ($this->rbac->hasPrivilege('bloodissue bill', 'can_edit')) { ?><a onclick='delete_bill(" + id + ")'  href='#'  data-toggle='tooltip'  data-original-title='<?php echo $this->lang->line('delete'); ?>'><i class='fa fa-trash'></i></a><?php } ?>");
                holdModal('viewModalBill');
            },
        });
    }


    function viewDetail(id) {

        $.ajax({
            url: '<?php echo base_url(); ?>admin/bloodbank/getIssueDetails',
            type: "POST",
            data: {bloodissue_id: id},
            dataType: 'json',
            success: function (data) {
                console.log(data);
                $("#issue_date_html").html(data.date_of_issue);
                $("#recieve_to_html").html(data.patient_name);
                $("#blood_groups").html(data.blood_group);
                $("#bag_nos").html(data.bag_no);
                $("#genders").html(data.gender);
                $("#doctor_name").html(data.doctor);
                $("#institutions").html(data.institution);
                $("#technician_html").html(data.technician);
                $("#amount_html").html(data.amount);
                $("#lots").html(data.lot);
                $("#donor_names").html(data.donor);
                $("#blood_bank_nos").html(data.blood_bank_no);
                $("#remark_html").html(data.remark);
                $("#edit_delete").html("<a href='#' onclick='getRecord(" + id + ")' data-toggle='tooltip' title='' data-original-title='Edit'><i class='fa fa-pencil'></i></a><a onclick='deleterecord(" + id + ")'  href='#'  data-toggle='tooltip'  data-original-title='Delete'><i class='fa fa-trash'></i></a>");
                holdModal('viewModal');
            },
        });
    }

    function deleterecord(id) {
        var url = '<?php echo base_url() ?>admin/bloodbank/deleteIssue/' + id;
        var msg = "<?php echo $this->lang->line('delete_message') ?>";
        delete_recordById(url, msg)
    }

    function holdModal(modalId) {
        $('#' + modalId).modal({
            backdrop: 'static',
            keyboard: false,
            show: true
        });
    }

    function getBloodGroup(donorid, htmlid) {
        $.ajax({
            url: '<?php echo base_url(); ?>admin/bloodbank/getDonorBloodgroup',
            type: "POST",
            data: {donor_id: donorid},
            dataType: 'json',
            success: function (data) {

                $("#" + htmlid).val(data.blood_group);
            }
        });
    }

</script>
<?php $this->load->view('admin/patient/patientaddmodal') ?>