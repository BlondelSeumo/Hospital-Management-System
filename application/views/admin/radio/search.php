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
                        <h3 class="box-title titlefix"><?php echo $this->lang->line('radiology') . " " . $this->lang->line('test'); ?></h3>
                        <div class="box-tools pull-right">
                            <?php if ($this->rbac->hasPrivilege('radiology test', 'can_add')) { ?>   
                                <a data-toggle="modal" onclick="holdModal('addTestReportModal')" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> <?php echo $this->lang->line('add') . " " . $this->lang->line('radiology') . " " . $this->lang->line('test'); ?></a> 
                            <?php } ?>
                            <?php if ($this->rbac->hasPrivilege('add_radio_patient_test_reprt', 'can_view')) { ?>  
                                <a href="<?php echo base_url(); ?>admin/radio/getTestReportBatch" class="btn btn-primary btn-sm"><i class="fa fa-reorder"></i> <?php echo $this->lang->line('test') . " " . $this->lang->line('report'); ?></a> 
                            <?php } ?>
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="download_label"><?php echo $this->lang->line('radiology') . " " . $this->lang->line('test'); ?></div>
                        <table class="table table-striped table-bordered table-hover example" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th><?php echo $this->lang->line('test') . " " . $this->lang->line('name'); ?></th>
                                    <th><?php echo $this->lang->line('short') . " " . $this->lang->line('name'); ?></th>
                                    <th><?php echo $this->lang->line('test') . " " . $this->lang->line('type'); ?></th>
                                    <th><?php echo $this->lang->line('category'); ?></th>
                                    <th><?php echo $this->lang->line('sub') . " " . $this->lang->line('category'); ?></th>
                                    <th><?php echo $this->lang->line('report') . " " . $this->lang->line('days'); ?></th>
                                    <th class="text-right"><?php echo $this->lang->line('charge') . " (" . $currency_symbol . ")"; ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (empty($resultlist)) {
                                    ?>
                                              <!-- <tr>
                                                <td colspan="12" class="text-danger text-center"><?php //echo $this->lang->line('no_record_found');     ?></td>
                                              </tr> -->
                                    <?php
                                } else {
                                    $count = 1;
                                    foreach ($resultlist as $student) {
                                        ?>
                                        <tr class="">
                                            <td>
                                                <a  href="#" 
                                                    onclick="viewDetail('<?php echo $student['id'] ?>')"><?php echo $student['test_name']; ?></a> 
                                                <div class="rowoptionview">
                                                    <?php if ($this->rbac->hasPrivilege('add_radio_patient_test_reprt', 'can_add')) { ?>
                                                        <a href="#" onclick="addTestReport('<?php echo $student['id'] ?>')" class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('add_patient_report'); ?>">
                                                            <i class="fa fa-plus-square" aria-hidden="true"></i>
                                                        </a>  
                                                    <?php } ?>
                                                    <?php if ($this->rbac->hasPrivilege('radiology test', 'can_view')) { ?> 
                                                        <a href="#" 
                                                           onclick="viewDetail('<?php echo $student['id'] ?>')"
                                                           class="btn btn-default btn-xs"  data-toggle="tooltip"
                                                           title="<?php echo $this->lang->line('show'); ?>" >
                                                            <i class="fa fa-reorder"></i>
                                                        </a> 
                                                    <?php } ?>
                                                </div>  
                                            </td>
                                            <td><?php echo $student['short_name']; ?></td>
                                            <td><?php echo $student['test_type']; ?></td>
                                            <td><?php echo $student['lab_name']; ?></td>
                                            <td><?php echo $student['sub_category']; ?></td>
                                            <td><?php echo $student['report_days']; ?></td>
                                            <td class="text-right"><?php echo $student['standard_charge']; ?></td>
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
<div class="modal fade" id="addTestReportModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="box-title"><?php echo $this->lang->line('add') . " " . $this->lang->line('test') . " " . $this->lang->line('details'); ?></h4> 
            </div>
            <div class="modal-body pt0 pb0">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <form id="formadd" accept-charset="utf-8"  method="post" class="ptt10" >
                            <div class="row">

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('test') . " " . $this->lang->line('name'); ?></label>
                                        <small class="req"> *</small> 
                                        <input type="text" name="test_name" class="form-control">
                                        <span class="text-danger"><?php echo form_error('test_name'); ?></span>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('short') . " " . $this->lang->line('name'); ?></label>
                                        <small class="req"> *</small> 
                                        <input type="text" name="short_name" class="form-control">
                                        <span class="text-danger"><?php echo form_error('short_name'); ?></span>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('test') . " " . $this->lang->line('type'); ?></label>
                                        <small class="req"> *</small> 
                                        <input type="text" name="test_type" class="form-control">
                                        <span class="text-danger"><?php echo form_error('test_type'); ?></span>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="exampleInputFile">
                                            <?php echo $this->lang->line('category') . " " . $this->lang->line('name'); ?></label>
                                        <small class="req"> *</small> 
                                        <div>
                                            <select class="form-control select2" style="width: 100%" name='radiology_category_id' >
                                                <option value="<?php echo set_value('radio_category_id'); ?>"><?php echo $this->lang->line('select') ?></option>
                                                <?php foreach ($categoryName as $dkey => $dvalue) {
                                                    ?>
                                                    <option value="<?php echo $dvalue["id"]; ?>"><?php echo $dvalue["lab_name"] ?></option>   
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('radio_category_id'); ?></span>
                                    </div>
                                </div>  
                            </div>
                            <div class="row">    
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('sub') . " " . $this->lang->line('category'); ?></label>
                                        <input type="text" name="sub_category" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('report') . " " . $this->lang->line('days'); ?></label>
                                        <input type="text" name="report_days" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="exampleInputFile"><?php echo $this->lang->line('charge') . " " . $this->lang->line('category'); ?></label>
                                        <small class="req">*</small> 
                                        <div>
                                            <select class="form-control" onchange="getchargecode(this.value)" name='charge_category_id' >
                                                <option value="<?php echo set_value('charge_category_id'); ?>"><?php echo $this->lang->line('select') ?></option>
                                                <?php foreach ($charge_category as $dkey => $dvalue) {
                                                    ?>
                                                    <option value="<?php echo $dvalue["name"]; ?>"><?php echo $dvalue["name"] ?></option>   
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('charge_category_id'); ?></span>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="exampleInputFile"><?php echo $this->lang->line('code'); ?></label>
                                        <small class="req">*</small> 
                                        <div>
                                            <select class="form-control select2" name='code' style="width: 100%" onchange="getchargeDetails(this.value)" id="code" >
                                                <option value=""><?php echo $this->lang->line('select') ?></option>
                                            </select>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('code'); ?></span>
                                    </div>
                                </div> 

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="exampleInputFile"><?php echo $this->lang->line('standard') . " " . $this->lang->line('charge'); ?></label><?php echo ' (' . $currency_symbol . ')'; ?>
                                        <small class="req">*</small> 
                                        <div>
                                            <input class="form-control" name='standard_charge' id="standard_charge" readonly="true">

                                        </div>
                                        <span class="text-danger"><?php echo form_error('code'); ?></span>
                                    </div>
                                </div> 


                            </div><!--./row-->   

                    </div><!--./col-md-12-->       
                </div><!--./row--> 
            </div>
            <div class="box-footer">
                <div class="pull-right">
                    <button type="submit" data-loading-text="<?php echo $this->lang->line('processing') ?>" id="formaddbtn" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
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
                <h4 class="box-title"><?php echo $this->lang->line('edit') . " " . $this->lang->line('test') . " " . $this->lang->line('information'); ?></h4> 
            </div>
            <form  id="formedit" accept-charset="utf-8"  method="post" class="">    
                <div class="modal-body pt0 pb0">
                    <div class="ptt10">


                        <div class="row">
                            <input type="hidden" name="id" id="id" value="<?php echo set_value('id'); ?>">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('test') . " " . $this->lang->line('name'); ?></label>
                                    <small class="req"> *</small> 
                                    <input type="text" name="test_name" id="test_name" class="form-control" value="<?php echo set_value('test_name'); ?>">
                                    <span class="text-danger"><?php echo form_error('test_name'); ?></span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('short') . " " . $this->lang->line('name'); ?></label>
                                    <small class="req"> *</small> 
                                    <input type="text" name="short_name" id="short_name" class="form-control" value="<?php echo set_value('short_name'); ?>">
                                    <span class="text-danger"><?php echo form_error('short_name'); ?></span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('test') . " " . $this->lang->line('type') ?></label>
                                    <small class="req"> *</small> 
                                    <input type="text" name="test_type" id="test_type" class="form-control" value="<?php echo set_value('test_type'); ?>">
                                    <span class="text-danger"><?php echo form_error('test_type'); ?></span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="exampleInputFile">
                                        <?php echo $this->lang->line('category') . " " . $this->lang->line('name') ?></label>
                                    <small class="req"> *</small> 
                                    <div>
                                        <select class="form-control select2" style="width: 100%" name='radiology_category_id' id="radiology_category_id">
                                            <option value="<?php echo set_value('radiology_category_id'); ?>"><?php echo $this->lang->line('select') ?></option>
                                            <?php foreach ($categoryName as $dkey => $dvalue) {
                                                ?>
                                                <option value="<?php echo $dvalue["id"]; ?>"><?php echo $dvalue["lab_name"] ?></option>   
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>      
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('sub') . " " . $this->lang->line('category') ?></label>
                                    <input type="text" name="sub_category" id="sub_category" class="form-control" value="<?php echo set_value('sub_category'); ?>">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('report') . " " . $this->lang->line('days') ?></label>
                                    <input type="text" name="report_days" id="report_days" class="form-control" value="<?php echo set_value('report_days'); ?>">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="exampleInputFile"><?php echo $this->lang->line('charge') . " " . $this->lang->line('category') ?></label>
                                    <small class="req">*</small> 
                                    <div>
                                        <select class="form-control" name='charge_category_id' id="edit_charge_category" onchange="editchargecode(this.value)" >
                                            <option value="<?php echo set_value('charge_category_id'); ?>"><?php echo $this->lang->line('select') ?></option>
                                            <?php foreach ($charge_category as $dkey => $dvalue) {
                                                ?>
                                                <option value="<?php echo $dvalue["name"]; ?>"><?php echo $dvalue["name"] ?></option>   
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <span class="text-danger"><?php echo form_error('charge_category_id'); ?></span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="exampleInputFile"><?php echo $this->lang->line('code') ?></label>
                                    <small class="req">*</small> 
                                    <div>
                                        <select class="form-control select2" style="width: 100%" name='charge_category_id' id="edit_code" >
                                            <option value="<?php echo set_value('charge_category_id'); ?>"><?php echo $this->lang->line('select') ?></option>
                                        </select>
                                    </div>
                                    <span class="text-danger"><?php echo form_error('charge_category_id'); ?></span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="exampleInputFile"><?php echo $this->lang->line('standard') . " " . $this->lang->line('charge'); ?></label><?php echo ' (' . $currency_symbol . ')'; ?>
                                    <small class="req">*</small> 
                                    <div>
                                        <input class="form-control" name='standard_charge' id="edit_standard_charge" readonly="true">

                                    </div>
                                    <span class="text-danger"><?php echo form_error('code'); ?></span>
                                </div>
                            </div> 

                        </div><!--./row-->   


                    </div><!--./row--> 
                </div> 
                <div class="box-footer">
                    <div class="pull-right ">
                        <button type="submit" data-loading-text="<?php echo $this->lang->line('processing') ?>" id="formeditbtn" class="btn btn-info pull-right" ><?php echo $this->lang->line('save') ?></button>

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
                        <a href="#"  data-target="#editModal" data-toggle="modal" title="" data-original-title="Edit"><i class="fa fa-pencil"></i></a>

                        <a href="#" data-toggle="tooltip" title="" data-original-title="Delete"><i class="fa fa-trash"></i></a>
                    </div>
                </div>
                <h4 class="box-title"><?php echo $this->lang->line('test') . " " . $this->lang->line('information') ?></h4> 
            </div>
            <form id="view" accept-charset="utf-8" method="get" class="">    
                <div class="modal-body pt0 pb0">
                    <div class="ptt10">


                        <div class="table-responsive">
                            <table class="table mb0 table-striped table-bordered examples ">
                                <tr>
                                    <th width="25%"><?php echo $this->lang->line('test') . " " . $this->lang->line('name'); ?></th>
                                    <td width="25%"><span id='test_names'></span></td>
                                    <th width="25%"><?php echo $this->lang->line('short') . " " . $this->lang->line('name'); ?></th>
                                    <td width="25%"><span id="short_names"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <th width="25%"><?php echo $this->lang->line('test') . " " . $this->lang->line('type'); ?></th>
                                    <td width="25%"><span id='test_types'></span></td>
                                    <th width="25%"><?php echo $this->lang->line('category') . " " . $this->lang->line('name'); ?></th>
                                    <td width="25%"><span id="radiology_category_ids"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <th width="25%"><?php echo $this->lang->line('sub') . " " . $this->lang->line('category'); ?></th>
                                    <td width="25%"><span id="sub_categorys"></span>
                                    <th width="25%"><?php echo $this->lang->line('report') . " " . $this->lang->line('days'); ?></th>
                                    <td width="25%"><span id='report_dayss'></span></td>
                                </tr>
                                <tr>
                                    <th width="25%"><?php echo $this->lang->line('charge') . " " . $this->lang->line('category'); ?></th>
                                    <td width="25%"><span id='charge_categorys'></span></td>
                                    <th width="25%"><?php echo $this->lang->line('code'); ?></th>
                                    <td width="25%"><span id="codes"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo $this->lang->line('standard') . " " . $this->lang->line('charge') . ' (' . $currency_symbol . ')'; ?></th>
                                    <td><span id='stdcharge'></span></td>
                                    </td>
                                </tr>
                            </table>

                        </div>

                    </div><!--./row--> 
                </div>
            </form>  

        </div>
    </div>    
</div>

<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close pt4" data-dismiss="modal">&times;</button>
                <div class="row">
                    <div class="col-sm-6 col-xs-8">
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
            <form id="formbatch" accept-charset="utf-8" action="" enctype="multipart/form-data" method="post">   
                <div class="modal-body pt0 pb0">
                    <div class="">


                        <div class="row row-eq">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div id="ajax_load"></div>
                                <div class="row ptt10" id="patientDetails" style="display:none">
                                    <input type="hidden" name="radiology_id" id="radio_id" >
                                    <input type="hidden" name="patient_id" id="radio_patientid" >
                                    <div class="col-md-9 col-sm-9 col-xs-9">

                                        <ul class="singlelist">
                                            <li class="singlelist24bold">
                                                <span id="listname"></span></li>
                                            <li>
                                                <i class="fas fa-user-secret" data-toggle="tooltip" data-placement="top" title="Guardian"></i>
                                                <span id="guardian"></span>
                                            </li>
                                        </ul>   
                                        <ul class="multilinelist">   
                                            <li>
                                                <i class="fas fa-venus-mars" data-toggle="tooltip" data-placement="top" title="Gender"></i>
                                                <span id="genders" ></span>
                                            </li>
                                            <li>
                                                <i class="fas fa-tint" data-toggle="tooltip" data-placement="top" title="Blood Group"></i>
                                                <span id="blood_group"></span>
                                            </li>
                                            <li>
                                                <i class="fas fa-ring" data-toggle="tooltip" data-placement="top" title="Marital Status"></i>
                                                <span id="marital_status"></span>
                                            </li> 
                                        </ul>  
                                        <ul class="singlelist">  
                                            <li>
                                                <i class="fas fa-hourglass-half" data-toggle="tooltip" data-placement="top" title="Age"></i>
                                                <span id="age"></span>
                                            </li>    

                                            <li>
                                                <i class="fa fa-phone-square" data-toggle="tooltip" data-placement="top" title="Phone"></i> 
                                                <span id="listnumber"></span>
                                            </li>
                                            <li>
                                                <i class="fa fa-envelope" data-toggle="tooltip" data-placement="top" title="Email"></i>
                                                <span id="email"></span>
                                            </li>
                                            <li>
                                                <i class="fas fa-street-view" data-toggle="tooltip" data-placement="top" title="Address"></i>
                                                <span id="address" ></span>
                                            </li>

                                            <li>
                                                <b><?php echo $this->lang->line('any_known_allergies') ?> </b> 
                                                <span id="allergies" ></span>
                                            </li>
                                            <li>
                                                <b><?php echo $this->lang->line('remarks') ?> </b> 
                                                <span id="note"></span>
                                            </li>    
                                        </ul>                               
                                    </div><!-- ./col-md-9 -->
                                    <div class="col-md-3 col-sm-3 col-xs-3"> 
                                        <div class="pull-right">  
                                          <!--<b><?php echo $this->lang->line('patient') . " " . $this->lang->line('photo') ?> </b>-->
                                                    <!--<span id="image"></span>-->
                                            <?php
                                            $file = "uploads/patient_images/no_image.png";
                                            ?>        
                                            <img class="modal-profile-user-img img-responsive" src="<?php echo base_url() . $file ?>" id="image" alt="User profile picture">
                                        </div>           
                                    </div><!-- ./col-md-3 --> 
                                </div>
                            </div><!--./col-md-8--> 

                            <div class="col-lg-6 col-md-6 col-sm-6 col-eq ptt10">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line('reporting') . " " . $this->lang->line('date'); ?></label><small class="req"> *</small>
                                            <input type="text" id="report_date" name="reporting_date" class="form-control date">
                                            <span class="text-danger"><?php echo form_error('reporting_date'); ?></span>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="description"><?php echo $this->lang->line('description'); ?></label> 

                                            <textarea name="description" class="form-control" ></textarea>
                                            <span class="text-danger"><?php echo form_error('description'); ?>
                                            </span>
                                        </div> 
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line('test') . " " . $this->lang->line('report'); ?></label>
                                            <input type="file" class="filestyle form-control" data-height="40" 
                                                   name="radiology_report">
                                            <span class="text-danger"><?php echo form_error('radiology_report'); ?></span>
                                        </div>
                                    </div> 

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="exampleInputFile">
                                                <?php echo $this->lang->line('refferal') . " " . $this->lang->line('doctor'); ?>
                                            </label>
                                            <div>
                                                <select class="form-control select2" style="width:100%" name='consultant_doctor' id="consultant_doctor">
                                                    <option value="<?php echo set_value('consultant_doctor'); ?>"><?php echo $this->lang->line('select') ?></option>
                                                    <?php foreach ($doctors as $dkey => $dvalue) {
                                                        ?>
                                                        <option value="<?php echo $dvalue["id"]; ?>"><?php echo $dvalue["name"] . " " . $dvalue["surname"] ?></option>   
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <span class="text-danger"><?php echo form_error('consultant_doctor'); ?></span>
                                        </div>
                                    </div> 

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line('charge') . " " . $this->lang->line('category'); ?></label>
                                            <input type="text" id="charge_category_html" class="form-control" readonly>

                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line('code'); ?></label>

                                            <input type="text" id="code_html" class="form-control" readonly>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line('standard') . " " . $this->lang->line('charge') . ' (' . $currency_symbol . ')'; ?></label>

                                            <input type="text" id="charge_html" class="form-control" readonly>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line('applied') . " " . $this->lang->line('charge') . ' (' . $currency_symbol . ')'; ?>
                                                <small class="req"> *</small>
                                            </label>
                                            <input type="text" name="apply_charge" id="apply_charge" class="form-control" >
                                        </div>
                                    </div> 

                                </div><!--./row-->    
                            </div><!--./col-md-4-->

                        </div><!--./row--> 
                    </div><!--./row--> 
                </div>  
                <div class="box-footer">
                    <div class="pull-right">
                        <button type="submit" id="formbatchbtn" data-loading-text="<?php echo $this->lang->line('processing') ?>" class="btn btn-info pull-right" ><?php echo $this->lang->line('save'); ?>

                        </button>
                    </div>
                    <div class="pull-right" style="margin-right:10px;">
                        <button type="button"  data-loading-text="<?php echo $this->lang->line('processing') ?>" class="btn btn-info pull-right printsavebtn"><?php echo $this->lang->line('save') . " & " . $this->lang->line('print'); ?></button>
                    </div>
                </div>
            </form> 


        </div>
    </div>    
</div>


<script type="text/javascript">
    $(function () {
        $('#easySelectable').easySelectable();
//stopPropagation();
    })
// $('#easySelectable').bind('click', function (e) { e.stopPropagation() })






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

                    $("#formbatchbtn").button('loading');
                    e.preventDefault();
                    $.ajax({
                        url: '<?php echo base_url(); ?>admin/radio/testReportBatch',
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
                            $("#formbatchbtn").button('reset');
                        },
                        error: function () {
                            //  alert("Fail")
                        }
                    });


                }));
            });

            function printData(id) {
                //alert(id);
                var base_url = '<?php echo base_url() ?>';
                $.ajax({
                    url: base_url + 'admin/radio/getBillDetails/' + id,
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

            function get_PatientDetails(id) {
                // $("#patientDetails").html("<?php echo $this->lang->line('loading') ?>");
                var base_url = "<?php echo base_url(); ?>backend/images/loading.gif";
                $("#ajax_load").html("<center><img src='" + base_url + "'/>");
                $.ajax({
                    url: '<?php echo base_url(); ?>admin/patient/patientDetails',
                    type: "POST",
                    data: {id: id},
                    dataType: 'json',
                    success: function (res) {
                        //console.log(res);
                        if (res) {
                            $("#ajax_load").html("");
                            $("#patientDetails").show();
                            //  $("#patientDetails").html("<center><img src='"+base_url+"'backend/images/loading.gif/></center>");
                            $('#patient_unique_id').html(res.patient_unique_id);
                            $('#radio_patientid').val(res.id);

                            $('#listname').html(res.patient_name);
                            $('#guardian').html(res.guardian_name);
                            $('#listnumber').html(res.mobileno);
                            $('#email').html(res.email);
                            if (res.age == "") {
                                $("#age").html("");
                            } else {
                                if (res.age) {
                                    var age = res.age + " " + "Years";
                                } else {
                                    var age = '';
                                }
                                if (res.month) {
                                    var month = res.month + " " + "Month";
                                } else {
                                    var month = '';
                                }
                                if (res.dob) {
                                    var dob = "(" + res.dob + ")";
                                } else {
                                    var dob = '';
                                }

                                $("#age").html(age + "," + month + " " + dob);
                                // console.log(data.dob);
                            }

                            $('#doctname').val(res.name + " " + res.surname);
                            //$("#dob").html(res.dob);
                            $("#bp").html(res.bp);
                            //$("#month").html(res.month);
                            $("#symptoms").html(res.symptoms);
                            //$("#known_allergies").html(res.known_allergies);
                            $("#address").html(res.address);
                            $("#note").html(res.note);
                            $("#height").html(res.height);
                            $("#weight").html(res.weight);
                            $("#genders").html(res.gender);
                            $("#marital_status").html(res.marital_status);
                            $("#blood_group").html(res.blood_group);
                            $("#allergies").html(res.known_allergies);
                            //$("#image").attr("src",res.image);
                            $("#image").attr("src", '<?php echo base_url() ?>' + res.image);
                            //console.log(res.image);
                            //$('select[id="genders"] option[value="' + res.gender + '"]').attr("selected", "selected");
                            //$('select[id="marital_status"] option[value="' + res.marital_status + '"]').attr("selected", "selected");
                            // $('select[id="blood_group"] option[value="' + res.blood_group + '"]').attr("selected", "selected");
                        } else {
                            $("#ajax_load").html("");
                            $("#patientDetails").hide();
                        }
                    }
                });
            }


            $(document).ready(function (e) {
                $("#formadd").on('submit', (function (e) {
                    $("#formaddbtn").button('loading');
                    e.preventDefault();
                    $.ajax({
                        url: '<?php echo base_url(); ?>admin/radio/add',
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

            function getchargeDetails(id) {

                $('#standard_charge').val("");
                $.ajax({
                    url: '<?php echo base_url(); ?>admin/charges/getDetails',
                    type: "POST",
                    data: {charges_id: id},
                    dataType: 'json',
                    success: function (res)
                    {
                        $('#standard_charge').val(res.standard_charge);
                    }
                })
            }

            /*  function getPatientIdName(opd_ipd_no) {
             $('#patient_id').val("");
             $('#patient_name').val("");
             var opd_ipd_patient_type = $("#customer_type").val();
             $.ajax({
             url: '<?php echo base_url(); ?>admin/patient/getPatientType',
             type: "POST",
             data: {opd_ipd_patient_type: opd_ipd_patient_type, opd_ipd_no: opd_ipd_no},
             dataType: 'json',
             success: function (data) {
             $('#patient_id').val(data.patient_id);
             $('#patient_name').val(data.patient_name);
             //$('#consultant_doctor').val(data.doctorname + ' ' +data.surname);
             }
             });
             }
             */

            $(document).ready(function (e) {
                $("#formedit").on('submit', (function (e) {
                    $("#formeditbtn").button('loading');
                    e.preventDefault();
                    $.ajax({
                        url: '<?php echo base_url(); ?>admin/radio/update',
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
                // $('#myModaledit').modal('show');
                $.ajax({
                    url: '<?php echo base_url(); ?>admin/radio/getDetails',
                    type: "POST",
                    data: {radiology_id: id},
                    dataType: 'json',
                    success: function (data) {
                        $("#id").val(data.id);
                        $("#test_name").val(data.test_name);
                        $("#short_name").val(data.short_name);
                        $("#test_type").val(data.test_type);
                        $("#sub_category").val(data.sub_category);
                        $("#report_days").val(data.report_days);
                        $("#edit_charge_category").val(data.charge_category);
                        $("#edit_standard_charge").val(data.standard_charge);
                        editchargecode(data.charge_category, data.charge_id);
                        $("#updateid").val(id);
                        console.log(data);
                        $('select[id="radiology_category_id"] option[value="' + data.radiology_category_id + '"]').attr("selected", "selected");
                        $('select[id="charge_category_id"] option[value="' + data.charge_category_id + '"]').attr("selected", "selected");
                        $("#viewModal").modal('hide');
                        $("#radiology_category_id").select2().select2('val', data.radiology_category_id);
                        //$("#edit_code").select2().select2('val',2);
                        holdModal('myModaledit');
                    },
                })
            }

            $(function () {
                //Initialize Select2 Elements
                $('.select2').select2();
            });
            function delete_record(id) {
                if (confirm('<?php echo $this->lang->line('delete_conform'); ?>')) {
                    $.ajax({
                        url: '<?php echo base_url(); ?>admin/radio/delete/' + id,
                        type: "POST",
                        data: {opdid: ''},
                        dataType: 'json',
                        success: function (data) {
                            successMsg('<?php echo $this->lang->line('delete_message'); ?>');

                            window.location.reload(true);
                        }
                    })
                }
            }

            function editchargecode(charge_category, charge_id) {
                var div_data = "";

                $('#edit_code').html("<option value='l'><?php echo $this->lang->line('loading') ?></option>");
                $('#edit_code').select2("val", 'l');
                $.ajax({
                    url: '<?php echo base_url(); ?>admin/charges/getchargeDetails',
                    type: "POST",
                    data: {charge_category: charge_category},
                    dataType: 'json',
                    success: function (res) {
                        //alert(res)
                        $.each(res, function (i, obj)
                        {
                            var sel = "";
                            if (charge_id == obj.id) {
                                //  sel = "selected";
                            }
                            div_data += "<option value='" + obj.id + "' " + sel + ">" + obj.code + " - " + obj.description + "</option>";
                        });
                        $('#edit_code').html("<option value=''>Select</option>");
                        $('#edit_code').append(div_data);
                        $("#edit_code").select2().select2('val', charge_id);
                    }
                });
            }

            function getchargecode(charge_category) {
                var div_data = "";

                $('#code').html("<option value='l'><?php echo $this->lang->line('loading') ?></option>");
                $('#code').select2("val", 'l');
                $.ajax({
                    url: '<?php echo base_url(); ?>admin/charges/getchargeDetails',
                    type: "POST",
                    data: {charge_category: charge_category},
                    dataType: 'json',
                    success: function (res) {
                        //alert(res)
                        $.each(res, function (i, obj)
                        {
                            var sel = "";
                            div_data += "<option value='" + obj.id + "'>" + obj.code + " - " + obj.description + "</option>";

                        });
                        $('#code').html("<option value=''>Select</option>");
                        $('#code').append(div_data);
                        $('#code').select2("val", '');
                    }
                });
            }


            function viewDetail(id) {
                $.ajax({
                    url: '<?php echo base_url(); ?>admin/radio/getDetails',
                    type: "POST",
                    data: {radiology_id: id},
                    dataType: 'json',
                    success: function (data) {
                        $("#test_names").html(data.test_name);
                        $("#short_names").html(data.short_name);
                        $("#test_types").html(data.test_type);
                        $("#radiology_category_ids").html(data.lab_name);
                        $("#sub_categorys").html(data.sub_category);
                        $("#report_dayss").html(data.report_days);
                        $("#charge_categorys").html(data.charge_category);
                        $("#codes").html(data.code);
                        $("#description").html("(" + data.description + ")");
                        $("#stdcharge").html(data.standard_charge);
                        $('#edit_delete').html("<?php if ($this->rbac->hasPrivilege('radiology test', 'can_edit')) { ?><a href='#'' onclick='getRecord(" + id + ")'  data-toggle='tooltip'  data-original-title='<?php echo $this->lang->line('edit'); ?>'><i class='fa fa-pencil'></i></a><?php } if ($this->rbac->hasPrivilege('radiology test', 'can_delete')) { ?><a onclick='delete_record(" + id + ")'  href='#'  data-toggle='tooltip'  data-original-title='<?php echo $this->lang->line('delete'); ?>'><i class='fa fa-trash'></i></a><?php } ?>");
                        holdModal('viewModal');
                    },
                });
            }
            function addTestReport(id) {
                $.ajax({
                    url: '<?php echo base_url(); ?>admin/radio/getRadiology',
                    type: "POST",
                    data: {radiology_id: id},
                    dataType: 'json',
                    success: function (data) {
                        $("#radio_id").val(id);
                        $("#charge_category_html").val(data.charge_category);
                        $("#code_html").val(data.code);
                        $("#charge_html").val(data.standard_charge);
                        $("#apply_charge").val(data.standard_charge);
                        holdModal('myModal');
                    },
                })
            }

            $(document).ready(function (e) {
                $("#formbatch").on('submit', (function (e) {
                    $("#formbatchbtn").button('loading');
                    e.preventDefault();
                    $.ajax({
                        url: '<?php echo base_url(); ?>admin/radio/testReportBatch',
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
                            $("#formbatchbtn").button('reset');
                        },
                        error: function () {

                        }
                    });
                }));
            });

            function holdModal(modalId) {
                $('#' + modalId).modal({
                    backdrop: 'static',
                    keyboard: false,
                    show: true
                });
            }
            function showtextbox(value) {
                if (value != 'direct') {
                    $("#opd_ipd_no").show();
                } else {
                    $("#opd_ipd_no").hide();
                }
            }
</script>

<?php $this->load->view('admin/patient/patientaddmodal') ?>