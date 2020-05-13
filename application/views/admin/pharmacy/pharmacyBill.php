<?php
$currency_symbol = $this->customlib->getSchoolCurrencyFormat();
$genderList = $this->customlib->getGender();
?>
<style type="text/css">
    #easySelectable {/*display: flex; flex-wrap: wrap;*/}
    #easySelectable li {}
    #easySelectable li.es-selected {background: #2196F3; color: #fff;}
    .easySelectable {-webkit-user-select:none; -moz-user-select:none; -ms-user-select: none;}
    .printablea4{width: 100%;}
    /*.printablea4 p{margin-bottom: 0;}*/
    .printablea4>tbody>tr>th,
    .printablea4>tbody>tr>td{padding:2px 0; line-height: 1.42857143;vertical-align: top; font-size: 12px;}
</style>
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title titlefix"> <?php echo $this->lang->line('pharmacy') . " " . $this->lang->line('bill'); ?></h3>
                        <div class="box-tools pull-right">
                            <?php if ($this->rbac->hasPrivilege('pharmacy bill', 'can_add')) { ?>                
                                <a data-toggle="modal" onclick="holdModal('myModal')" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> <?php echo $this->lang->line('generate') . " " . $this->lang->line('bill'); ?></a>
                            <?php } ?>
                            <?php if ($this->rbac->hasPrivilege('medicine', 'can_view')) { ?>
                                <a href="<?php echo base_url(); ?>admin/pharmacy/search" class="btn btn-primary btn-sm"><i class="fa fa-reorder"></i> <?php echo $this->lang->line('medicines'); ?></a>
                            <?php } ?>
                        </div> 
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="download_label"><?php echo $this->lang->line('pharmacy') . " " . $this->lang->line('bill'); ?></div>
                        <table class="table table-striped table-bordered table-hover example" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th><?php echo $this->lang->line('bill') . " " . $this->lang->line('no'); ?></th>
                                    <th><?php echo $this->lang->line('date'); ?></th>
                                    <th><?php echo $this->lang->line('customer') . " " . $this->lang->line('name'); ?></th>
                                    <!--<th><?php echo $this->lang->line('customer') . " " . $this->lang->line('type'); ?></th>-->
                                    <th><?php echo $this->lang->line('doctor') . " " . $this->lang->line('name'); ?></th>
                                    <th class="text-right"><?php echo $this->lang->line('total') . " " . '(' . $currency_symbol . ')'; ?></th>
                                    <th class="text-right"><?php echo $this->lang->line('action'); ?></th>
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
                                    foreach ($resultlist as $bill) {
                                        ?>
                                        <tr class="">
                                            <td ><?php echo $bill['bill_no']; ?></td>
                                            <td><?php echo date($this->customlib->getSchoolDateFormat(true, true), strtotime($bill['date'])) ?></td> 
                                            <td><?php echo $bill['patient_name']; ?></td>
                                           <!-- <td><?php echo $this->lang->line($bill['customer_type']); ?></td>-->
                                            <td><?php echo $bill['doctor_name']; ?></td>
                                            <td class="text-right"><?php echo $bill['net_amount']; ?></td>
                                            <td class="pull-right">

                                                <a href="#" 
                                                   onclick="viewDetail(<?php echo $bill['id'] ?>,<?php echo $bill['bill_no'] ?>,<?php echo $bill['patient_id'] ?>)"
                                                   class="btn btn-default btn-xs"  data-toggle="tooltip"
                                                   title="<?php echo $this->lang->line('show'); ?>" >
                                                    <i class="fa fa-reorder"></i>
                                                </a> 

                                                <a href="#" 
                                                   onclick="viewDetail(<?php echo $bill['id'] ?>,<?php echo $bill['bill_no'] ?>,<?php echo $bill['patient_id'] ?>)"
                                                   class="btn btn-default btn-xs"  data-toggle="tooltip"
                                                   title="<?php echo $this->lang->line('print'); ?>" >
                                                    <i class="fa fa-print"></i>
                                                </a> 
                                            </td>
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

<div class="modal fade" id="myModal"  aria-hidden="true" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog pup100" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <div class="row modalbillform">
                    <div class="col-lg-5 col-sm-5">
                        <div class="row">
                            <div class="col-sm-9">   
                                <select onchange="get_PatientDetails(this.value)"  style="width: 100%" class="form-control select2" id="addpatient_id" name='' >
                                    <option value=""><?php echo $this->lang->line('select') . " " . $this->lang->line('patient') ?></option>
                                    <?php foreach ($patients as $dkey => $dvalue) {
                                        ?>
                                        <option value="<?php echo $dvalue["id"]; ?>" <?php
                                        if ((isset($patient_select)) && ($patient_select == $dvalue["id"])) {
                                            echo "selected";
                                        }
                                        ?>><?php echo $dvalue["patient_name"] . " (" . $dvalue["patient_unique_id"] . ")" ?></option>   
                                            <?php } ?>
                                </select> 
                            </div><!--./col-sm-3-->  
                            <div class="col-sm-3">
                                <?php if ($this->rbac->hasPrivilege('patient', 'can_add')) { ?>
                                    <a data-toggle="modal" id="add" onclick="holdModal('myModalpa')" class="modalbtnpatient"><i class="fa fa-plus"></i>  <?php echo $this->lang->line('new') . " " . $this->lang->line('patient') ?></a> 
                                <?php } ?> 
                            </div><!--./col-sm-3-->
                        </div><!--./row-->  
                    </div><!--./col-sm-6-->
                    <div class="col-lg-6 col-sm-6">
                        <div class="row">        
                            <div class="col-lg-2 col-sm-3 col-xs-3">
                                 <label><?php echo $this->lang->line('bill') . " " . $this->lang->line('no'); ?></label><!-- <small class="req" style="color:red;"> *</small> --> 
                            </div> 
                            <div class="col-lg-2 col-sm-3 col-xs-9">
                                <input readonly name="bill_no" id="billno" type="text" class="form-control"/>
                                <span class="text-danger"><?php echo form_error('bill_no'); ?></span>
                            </div> 
                            <div class="mdclear"></div>
                            <div class="col-lg-2 col-sm-3 col-xs-3">
                                <label><?php echo $this->lang->line('date'); ?></label>
                            </div> 
                            <div class="col-lg-5 col-sm-3 col-xs-9">
                                <input name="date" id="date_pharmacy" type="text" value="<?php echo date($this->customlib->getSchoolDateFormat(true, true)) ?>" class="form-control datetime"/>
                            </div>  
                        </div><!--./row-->  
                    </div><!--./col-sm-6-->    

                    <div class="col-sm-1 pull-right">
                        <button type="button" data-toggle="tooltip" title="<?php echo $this->lang->line('close'); ?>" class="close " data-dismiss="modal">&times;</button>
                      <!-- <h4 class="box-title"><?php echo $this->lang->line('generate') . " " . $this->lang->line('bill'); ?></h4>  -->
                    </div><!--./col-sm-1--> 
                </div><!--./row-->     
            </div><!--./modal-header-->
            <form id="bill" accept-charset="utf-8" method="post" class="ptt10">   
                <div class="modal-body pt0 pb0">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">

                            <input name="customer_name" id="patient_name" type="hidden" class="form-control"/>
                            <input name="date" id="date_result" type="hidden" class="form-control"/>
                            <input name="patient_id" id="patient_id" type="hidden" class="form-control"/>
                            <input name="bill_no" id="billnoform" type="hidden" class="form-control"/>
                            <div class="row">
                                <!-- <div class="col-sm-1">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('bill') . " " . $this->lang->line('no'); ?></label>
                                        <small class="req" style="color:red;"> *</small> 
                                        <input readonly name="bill_no" id="billno" type="text" class="form-control"/>
                                        <span class="text-danger"><?php echo form_error('bill_no'); ?></span>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('date'); ?></label>
                                        <input name="date"  type="text" value="<?php echo date($this->customlib->getSchoolDateFormat(true, true)) ?>" class="form-control datetime"/>
                                    </div>
                                </div> -->






                                <div class="col-md-12" style="clear:both;">
                                    <div class="">
                                        <table class="table table-striped table-bordered table-hover" id="tableID">
                                            <thead>
                                                <tr style="font-size: 13px">

                                                    <th><?php echo $this->lang->line('medicine') . " " . $this->lang->line('category'); ?><small class="req" style="color:red;"> *</small></th>
                                                    <th><?php echo $this->lang->line('medicine') . " " . $this->lang->line('name'); ?><small class="req" style="color:red;"> *</small></th>
                                                    <th><?php echo $this->lang->line('batch') . " " . $this->lang->line('no'); ?> <small class="req" style="color:red;">*</small></th>
                                                    <th><?php echo $this->lang->line('expire') . " " . $this->lang->line('date'); ?><small class="req" style="color:red;"> *</small></th>
                                                    <th class="text-right"><?php echo $this->lang->line('quantity'); ?><small class="req" style="color:red;"> *</small> <?php echo " | " . $this->lang->line('available') . " " . $this->lang->line('qty'); ?></th>
                                                    <th class="text-right"><?php echo $this->lang->line('sale_price') . ' (' . $currency_symbol . ')'; ?><small class="req" style="color:red;"> *</small></th>
                                                    <th class="text-right"><?php echo $this->lang->line('amount') . " (" . $currency_symbol . ")"; ?><small class="req" style="color:red;"> *</small></th>
                                                </tr>
                                            </thead>
                                            <tr id="row0">
                                                <td width="16%">      
                                                    <select class="form-control" name='medicine_category_id[]'  onchange="getmedicine_name(this.value, '0')">
                                                        <option value="<?php echo set_value('medicine_category_id'); ?>"><?php echo $this->lang->line('select') ?>
                                                        </option>
                                                        <?php foreach ($medicineCategory as $dkey => $dvalue) {
                                                            ?>
                                                            <option value="<?php echo $dvalue["id"]; ?>"><?php echo $dvalue["medicine_category"] ?>
                                                            </option>   
                                                        <?php } ?>
                                                    </select>
                                                    <span class="text-danger"><?php echo form_error('medicine_category_id[]'); ?>
                                                    </span>
                                                </td>
                                                <td width="24%">
                                                    <select class="form-control select2" style="width:100%" onchange="getbatchnolist(this.value, 0)" id="medicine_name0" name='medicine_name[]'>
                                                        <option value=""><?php echo $this->lang->line('select') ?>
                                                        </option>
                                                    </select>
                                                    <span class="text-danger"><?php echo form_error('medicine_name[]'); ?></span>

                                                </td>
                                                <td width="16%"> 
                                                 <!-- <input type="text" name="batch_no[]" onchange="getExpire(0)" placeholder="" class="form-control" id="batch_no0" > -->
                                                    <select class="form-control" id="batch_no0" name="batch_no[]" onchange="getExpire(0)">
                                                        <option value=""><?php echo $this->lang->line('select') ?></option>
                                                    </select>
                                                    <span class="text-danger"><?php echo form_error('batch_no[]'); ?></span>
                                                </td>
                                                <td width="8%">
                                                    <input type="text" readonly="" name="expire_date[]"  id="expire_date0" class="form-control">

                                                </td>

                                                <td>
                                                 <!--  <input type="text" name="quantity[]" placeholder="" class="form-control text-right" id="quantity0" onchange="multiply(0)" onfocus="getQuantity(0)">
                                                  <span id="totalqty0" class="text-danger"><?php echo form_error('quantity[]'); ?></span> -->
                                                    <div class="input-group">
                                                        <input type="text" name="quantity[]" onchange="multiply(0)" onfocus="getQuantity(0)" id="quantity0" class="form-control text-right">
                                                        <span class="input-group-addon text-danger" style="font-size: 10pt"  id="totalqty0">&nbsp;&nbsp;</span>
                                                    </div>
                                                    <input type="hidden" name="available_quantity[]" id="available_quantity0">
                                                    <input type="hidden" name="id[]" id="id0">
                                                </td>
                                                <td class="text-right">

                                                    <input type="text" name="sale_price[]" onchange="multiply(0)" id="sale_price0" placeholder="" class="form-control text-right">
                                                    <span class="text-danger"><?php echo form_error('sale_price[]'); ?></span>
                                                </td>

                                                <td class="text-right">
                                                    <input type="text" name="amount[]" id="amount0" placeholder="" class="form-control text-right">
                                                    <span class="text-danger"><?php echo form_error('net_amount[]'); ?></span>
                                                </td>
                                                <td><button type="button" onclick="addMore()" style="color: #2196f3" class="closebtn"><i class="fa fa-plus"></i></button></td>
                                            </tr>
                                        </table>
                                    </div>  
                                    <div class="divider"></div>    
                                    <!--    <div class="col-sm-8">
                                     <div class="form-group">
                                       <input type="button" onclick="addTotal()" value="Calculate" class="btn btn-info pull-right"/>
                                     </div>
                                   </div> -->
                                    <div class="row">  
                                        <div class="col-sm-6">
                                            <div class="row">
                                                <div class="col-sm-12">  
                                                    <div class="row"> 
                                                        <div class="col-sm-6">
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
                                                        <div class="col-sm-6">    
                                                            <div class="form-group">
                                                                <label><?php echo $this->lang->line('doctor') . " " . $this->lang->line('name'); ?></label>
                                                                <input name="doctor_name" id="doctname" type="text" class="form-control"/>
                                                                <span class="text-danger"><?php echo form_error('doctor_name'); ?></span>
                                                            </div>
                                                        </div> 
                                                    </div>  
                                                </div>  
                                                <div class="col-sm-12">
                                                    <div class="form-group">   
                                                        <label><?php echo $this->lang->line('note'); ?></label>
                                                        <textarea name="note" rows="3" id="note" class="form-control"></textarea>
                                                    </div> 
                                                </div>  
                                            </div> 
                                        </div><!--./col-sm-6-->


                                        <div class="col-sm-6">
                                            <table class="printablea4">
                                                <tr>
                                                    <th width="50%"><?php echo $this->lang->line('total') . " (" . $currency_symbol . ")"; ?></th>
                                                    <td width="40%" colspan="2" class="text-right ipdbilltable"><input type="text" placeholder="Total" value="0" name="total" id="total" style="width: 30%; float: right" class="form-control"/></td>
                                                </tr>

                                                <tr>
                                                    <th><?php echo $this->lang->line('discount') . " (" . $currency_symbol . ")"; ?></th>
                                                    <td class="text-right ipdbilltable"><h4 style="float: right;font-size: 12px; padding-left: 5px;"> %</h4><input type="text" placeholder="Discount" value="" name="discount_percent" id="discount_percent" style="width: 50%; float: right;font-size: 12px;" class="form-control"/></td>

                                                    <td class="text-right ipdbilltable"><input type="text" placeholder="Discount" value="0" name="discount" id="discount" style="width: 50%; float: right" class="form-control"/></td>
                                                </tr>
                                                <!--<tr>
                                                    <th><?php echo $this->lang->line('discount') . " (" . $currency_symbol . ")"; ?></th>
                                                    <td class="text-right ipdbilltable"><input type="text" placeholder="Discount" value="0" name="discount" id="discount" style="width: 30%; float: right" class="form-control"/></td>
                                                </tr>-->
                                                <tr>
                                                    <th><?php echo $this->lang->line('tax') . " (" . $currency_symbol . ")"; ?></th>
                                                    <td class="text-right ipdbilltable">
                                                        <h4 style="float: right;font-size: 12px;     padding-left: 5px;"> %</h4><input type="text" placeholder="Tax" name="tax_percent" value="" id="tax_percent" style="width: 50%; float: right;font-size: 12px;" class="form-control"/>

                                                    </td>

                                                    <td class="text-right ipdbilltable">
                                                        <input type="text" placeholder="Tax" name="tax" value="0" id="tax" style="width: 50%; float: right" class="form-control"/>

                                                    </td>
                                                </tr>

                                                <!--  </tr>
                                                                                                  <tr>
                                                      <th><?php echo $this->lang->line('tax'); ?></th>
                                                      <td class="text-right ipdbilltable">
                                                          <input type="text" placeholder="Tax" name="tax_percent" value="0" id="tax_percent" style="width: 30%; float: right" class="form-control"/>
  
                                                      </td>
  
                                                  </tr>-->
                                                <tr>
                                                    <th><?php echo $this->lang->line('net_amount') . " (" . $currency_symbol . ")"; ?></th>
                                                    <td colspan="2" class="text-right ipdbilltable">
                                                        <input type="text" placeholder="Net Amount" value="0" name="net_amount" id="net_amount" style="width: 30%; float: right" class="form-control"/></td>
                                                </tr>
                                            </table>

                                            <!-- <div class="form-group">
                                             <label>Discount</label>
                                              <input type="text" placeholder="Total" name="total" id="total" class="form-control"/>
                                            </div>
                                            <div class="form-group">
                                             <label>Tax</label>
                                              <input type="text" placeholder="Total" name="total" id="total" class="form-control"/>
                                            </div> -->
                                        </div>

                                    </div><!--./row-->  
                                </div><!--./col-md-12-->
                                <!--  <div class="col-sm-offset-9 ">
                                   <label>Total</label>
                                   <input type="text" name="total" placeholder="Total">
                                 </div> -->

                            </div><!--./row-->  
                        </div><!--./box-footer-->
                    </div><!--./col-md-12-->    
                </div><!--./row-->  

                <div class="box-footer" style="clear: both;">
                    <div class="pull-right">
                        <input type="button" onclick="addTotal()" value="<?php echo $this->lang->line('calculate'); ?>" class="btn btn-info"/>&nbsp;
                        <button type="submit" data-loading-text="<?php echo $this->lang->line('processing') ?>" style="display: none" id="billsave" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                        <button type="button" style="display: none; margin-right:2px;" data-loading-text="<?php echo $this->lang->line('processing') ?>" class="btn btn-info pull-right printsavebtn"><?php echo $this->lang->line('save') . " & " . $this->lang->line('print'); ?>
                        </button>
                    </div>

                </div>
            </form>

        </div><!--./modal-body-->


    </div>
</div> 

<div class="modal fade" id="edit_bill" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog pup100" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <div class="row modalbillform">
                    <div class="col-lg-5 col-sm-5">
                        <div class="row">
                            <div class="col-sm-9">   
                                <select onchange="get_PatienteditDetails(this.value)"  style="width: 100%" class="form-control select2" id="addeditpatient_id" name='patientid' >
                                    <option value=""><?php echo $this->lang->line('select') . " " . $this->lang->line('patient') ?></option>
                                    <?php foreach ($patients as $dkey => $dvalue) {
                                        ?>
                                        <option value="<?php echo $dvalue["id"]; ?>" <?php
                                        if ((isset($patient_select)) && ($patient_select == $dvalue["id"])) {
                                            echo "selected";
                                        }
                                        ?>><?php echo $dvalue["patient_name"] . " (" . $dvalue["patient_unique_id"] . ")" ?></option>   
<?php } ?>
                                </select> 
                                <input name="patient_id"  id="patienteditid" type="hidden" class="form-control" value="" />
                                <input name="customer_name"  id="patienteditname" type="hidden" class="form-control" value="" />
                            </div><!--./col-sm-3-->  
                            <!--<div class="col-sm-3">
                            <?php if ($this->rbac->hasPrivilege('patient', 'can_add')) { ?>
                                        <a data-toggle="modal" id="add" onclick="holdModal('myModalpa')" class="modalbtnpatient"><i class="fa fa-plus"></i>  <?php echo $this->lang->line('new') . " " . $this->lang->line('patient') ?></a> 
<?php } ?> 
                        </div>--><!--./col-sm-3-->
                        </div><!--./row-->  
                    </div><!--./col-sm-6-->
                    <div class="col-lg-6 col-sm-6">
                        <div class="row">        
                            <div class="col-lg-2 col-sm-3 col-xs-3">
                                 <label><?php echo $this->lang->line('bill') . " " . $this->lang->line('no'); ?></label><!-- <small class="req" style="color:red;"> *</small> --> 
                            </div> 
                            <div class="col-lg-2 col-sm-3 col-xs-9">
                                <input readonly name="bill_no" id="editbillno" type="text" class="form-control"/>
                                <span class="text-danger"><?php echo form_error('bill_no'); ?></span>
                            </div> 
                            <div class="mdclear"></div>
                            <div class="col-lg-2 col-sm-3 col-xs-3">
                                <label><?php echo $this->lang->line('date'); ?></label>
                            </div> 
                            <div class="col-lg-5 col-sm-3 col-xs-9">
                                <input name="edit_date" id="editdate" type="text" value="" class="form-control datetime"/>
                            </div>  
                        </div><!--./row-->  
                    </div><!--./col-sm-6-->    

                    <div class="col-sm-1 pull-right">
                        <button type="button" data-toggle="tooltip" title="<?php echo $this->lang->line('close'); ?>" class="close " data-dismiss="modal">&times;</button>
                      <!-- <h4 class="box-title"><?php echo $this->lang->line('generate') . " " . $this->lang->line('bill'); ?></h4>  -->
                    </div><!--./col-sm-1--> 
                </div><!--./row--> 

            </div>

            <div class="modal-body pt0 pb0" id="edit_bill_details">
            </div>    

        </div>
    </div> 
</div>

<div class="modal fade" id="viewModal"  role="dialog" aria-labelledby="myModalLabel">
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
        //Initialize Select2 Elements
        $('.select2').select2()

    });

      function edit_bill(id, bill_no, patient_id) {
            $.ajax({
            url: '<?php echo base_url(); ?>admin/pharmacy/getdate',
            type: "POST",
            data: {id: id},
            dataType: 'json',
            success: function (data) {
            var date_format = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(true, true), ['d' => 'dd', 'm' => 'MM', 'Y' => 'yyyy',]) ?>';
            var date = new Date(data.date).toString(date_format);
            $('#editdate').val(date);
            $("#editbillno").val(bill_no);
            $("#addeditpatient_id").val(patient_id);
               $.ajax({
                     url: '<?php echo base_url(); ?>admin/pharmacy/editPharmacyBill/' + id,
                    success: function (res) {
                        $('#viewModal').modal('hide');
                        $("#edit_bill_details").html(res);
                        holdModal('edit_bill');
                    },
                    error: function () {
                        alert("Fail")
                    }
                });

             }
           
        });
                
        } 

    // function edit_bill(id, bill_no, patient_id) {
    //     // var billno = bill_no;
    //     // console.log(billno);
    //     $.ajax({
    //         url: '<?php echo base_url(); ?>admin/pharmacy/editPharmacyBill/' + id,
    //         success: function (res) {
    //         // var date_format = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(true, false), ['d' => 'dd', 'm' => 'MM', 'Y' => 'yyyy',]) ?>';
    //         // ///new Date().toLocaleTimeString();
    //         // var date = new Date(data.date).toString(date_format);
    //             //$('#editdate').val(date);
    //             $('#viewModal').modal('hide');
    //             $("#editbillno").val(bill_no);
    //             $("#addeditpatient_id").val(patient_id);
    //             // $("#editdate").val(date);
    //             $("#edit_bill_details").html(res);

    //             holdModal('edit_bill');
    //         },
    //         error: function () {
    //             alert("Fail")
    //         }
    //     });
    // }

    function get_PatientDetails(id) {
        //$("#patient_name").html("patient_name");
        //$("#schedule_charge").html("schedule_charge");

        $.ajax({
            url: '<?php echo base_url(); ?>admin/pharmacy/patientDetails',
            type: "POST",
            data: {id: id},
            dataType: 'json',
            success: function (res) {
                // console.log(res);
                if (res) {
                    $('#patient_name').val(res.patient_name);
                    $('#patient_id').val(res.id);
                } else {
                    $('#patient_name').val('Null');

                }
            }
        });
    }

    function get_PatienteditDetails(id) {
        $.ajax({
            url: '<?php echo base_url(); ?>admin/pharmacy/patientDetails',
            type: "POST",
            data: {id: id},
            dataType: 'json',
            success: function (res) {
                // console.log(res);
                if (res) {
                    //$('#patient_name').val(res.patient_name);
                    $('#patienteditid').val(res.id);
                    $('#patienteditname').val(res.patient_name);
                    // console.log(res.patient_name)

                }
            }
        });
    }

    function getmedicine_name(id, rowid) {
        var div_data = "";

        //$("#medicine_name" + rowid).prepend($('<option></option>').html('Loading...'));
        $("#medicine_name" + rowid).html("<option value='l'><?php echo $this->lang->line('loading') ?></option>");
        $('#medicine_name' + rowid).select2("val", 'l');
        $.ajax({
            url: '<?php echo base_url(); ?>admin/pharmacy/get_medicine_name',
            type: "POST",
            data: {medicine_category_id: id},
            dataType: 'json',
            success: function (res) {
                $.each(res, function (i, obj)
                {
                    var sel = "";
                    div_data += "<option value=" + obj.id + ">" + obj.medicine_name + "</option>";
                });
                $("#medicine_name" + rowid).html("<option value=''>Select</option>");
                $('#medicine_name' + rowid).append(div_data);
                $('#medicine_name' + rowid).select2("val", '');
                //$('#medicine_name'+rowid).select2();
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

            $("#billsave").button('loading');
            e.preventDefault();
            $.ajax({
                url: '<?php echo base_url(); ?>admin/pharmacy/addBill',
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
                        printData(data.insert_id);

                        // window.location.reload(true);
                    }
                    $("#billsave").button('reset');
                },
                error: function () {
                    //  alert("Fail")
                }
            });


        }));
    });

    function printData(insert_id, id) {
        alert(insert_id);

        var base_url = '<?php echo base_url() ?>';
        $.ajax({
            url: base_url + 'admin/pharmacy/getBillDetails/' + insert_id,
            type: 'POST',
            data: {id: insert_id, print: 'yes'},
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


    function addMore() {
        var table = document.getElementById("tableID");
        var table_len = (table.rows.length);
        var id = parseInt(table_len - 1);
        var div = "<td><select class='form-control' name='medicine_category_id[]' onchange='getmedicine_name(this.value," + id + ")'><option value='<?php echo set_value('medicine_category_id'); ?>'><?php echo $this->lang->line('select') ?></option><?php foreach ($medicineCategory as $dkey => $dvalue) { ?><option value='<?php echo $dvalue["id"]; ?>'><?php echo $dvalue["medicine_category"] ?></option><?php } ?></select></td><td><select class='form-control select2' style='width:100%' name='medicine_name[]' onchange='getbatchnolist(this.value," + id + ")' id='medicine_name" + id + "' ><option value='<?php echo set_value('medicine_name'); ?>'><?php echo $this->lang->line('select') ?></option></select></td><td><select name='batch_no[]' id='batch_no" + id + "' onchange='getExpire(" + id + ")' class='form-control'><option value='<?php echo set_value('batch_no'); ?>'><?php echo $this->lang->line('select') ?></option></select></td><td><input type='text' name='expire_date[]' readonly id='expire_date" + id + "' class='form-control'></td><td><div class='input-group'><input type='text' name='quantity[]' onchange='multiply(" + id + ")' onfocus='getQuantity(" + id + ")' id='quantity" + id + "' class='form-control text-right'><span class='input-group-addon text-danger' style='font-size:10pt'  id='totalqty" + id + "'>&nbsp;&nbsp;</span></div><input type='hidden' name='available_quantity[]' id='available_quantity" + id + "'><input type='hidden' name='id[]' id='id" + id + "'></td><td> <input type='text' onchange='multiply(" + id + ")' name='sale_price[]' id='sale_price" + id + "'  class='form-control text-right'></td><td><input type='text' name='amount[]' id='amount" + id + "'  class='form-control text-right'></td>";

        var row = table.insertRow(table_len).outerHTML = "<tr id='row" + id + "'>" + div + "<td><button type='button' onclick='delete_row(" + id + ")' class='closebtn'><i class='fa fa-remove'></i></button></td></tr>";
        $('.select2').select2();

        var expire_date = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(), ['d' => 'DD', 'm' => 'MM', 'Y' => 'YYYY',]) ?>';
        $('.expire_date').datepicker({
            format: "M/yyyy",
            viewMode: "months",
            minViewMode: "months",
            autoclose: true
        });
        generateBillNo()
    }

    function addTotal() {
        var total = 0;
        var sale_price = document.getElementsByName('amount[]');
        for (var i = 0; i < sale_price.length; i++) {
            var inp = sale_price[i];
            if (inp.value == '') {
                var inpvalue = 0;
            } else {
                var inpvalue = inp.value;
            }
            total += parseFloat(inpvalue);
        }
        var discount_percent = $("#discount_percent").val();
        var tax_percent = $("#tax_percent").val();
        // var discount_amnt = $("#discount").val();
        //var tax_amnt = $("#tax").val();

        if (discount_percent != '') {
            var discount = (total * discount_percent) / 100;
            $("#discount").val(discount.toFixed(2));
        } else {
            var discount = $("#discount").val();
            //var discount = 0; 
        }

        if (tax_percent != '') {
            var tax = ((total - discount) * tax_percent) / 100;
            $("#tax").val(tax.toFixed(2));
        } else {
            var tax = $("#tax").val();
            // var tax = 0; 
        }


        //   var tax = $("#tax").val();
        //  var discount = $("#discount").val();
        $("#total").val(total.toFixed(2));

        var net_amount = parseFloat(total) + parseFloat(tax) - parseFloat(discount);
        // var net_amount = (total)+(tax) - (discount);
        //  alert(net_amount);
        var cnet_amount = net_amount.toFixed(2)
        $("#net_amount").val(cnet_amount);
        var editdate = $("#date_pharmacy").val();
        $("#date_result").val(editdate);
        $("#billsave").show();
        $(".printsavebtn").show();
    }

    function delete_row(id) {
        var table = document.getElementById("tableID");
        var rowCount = table.rows.length;
        $("#row" + id).remove();
    }


    $(document).ready(function (e) {
        $("#bill").on('submit', (function (e) {
            e.preventDefault();
            var btn = $("#billsave");
            btn.button('loading');
            var table = document.getElementById("tableID");
            var rowCount = table.rows.length;

            for (var k = 0; k < rowCount; k++) {
                var quantityk = $('#quantity' + k).val();
                var availquantityk = $('#available_quantity' + k).val();
                if (parseInt(quantityk) > parseInt(availquantityk)) {
                    errorMsg('Order quantity should not be greater than available quantity');
                    return false;
                } else {
                }
            }
            $.ajax({
                url: '<?php echo base_url(); ?>admin/pharmacy/addBill',
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
                    $("#billsave").button('reset');
                },
                error: function () {}
            });   //alert(parseInt(quantity));

        }));
    });


    function viewDetail(id, bill_no, patient_id) {
        // var billno = bill_no;
        //var patientid = patient_id;
        //var dateedit = date;

        // console.log(patient_id);
        $.ajax({
            url: '<?php echo base_url() ?>admin/pharmacy/getBillDetails/' + id,
            type: "GET",
            data: {id: id},
            success: function (data) {
                $('#reportdata').html(data);
                $('#edit_deletebill').html("<?php if ($this->rbac->hasPrivilege('pharmacy bill', 'can_view')) { ?><a href='#' data-toggle='tooltip' onclick='printData(" + id + ")'   data-original-title='<?php echo $this->lang->line('print'); ?>'><i class='fa fa-print'></i></a> <?php } ?><?php if ($this->rbac->hasPrivilege('pharmacy bill', 'can_edit')) { ?><a href='#'' onclick='edit_bill(" + id + "," + bill_no + "," + patient_id + ")' data-toggle='tooltip'  data-original-title='<?php echo $this->lang->line('edit'); ?>'><i class='fa fa-pencil'></i></a><?php } ?><?php if ($this->rbac->hasPrivilege('pharmacy bill', 'can_edit')) { ?><a onclick='delete_bill(" + id + ")'  href='#'  data-toggle='tooltip'  data-original-title='<?php echo $this->lang->line('delete'); ?>'><i class='fa fa-trash'></i></a><?php } ?>");
                holdModal('viewModal');
            },
        });
    }

    function getQuantity(id) {
        var batch_no = $('#batch_no' + id).val();
        var medicine = $("#medicine_name" + id).val();
        if (batch_no != "") {
            $('#quantity').html("");
            $.ajax({
                type: "GET",
                url: base_url + "admin/pharmacy/getQuantity",
                data: {'batch_no': batch_no , 'med_id': medicine },
                dataType: 'json',
                success: function (data) {
                    $('#id' + id).val(data.id);
                    //$('#quantity').html(data.available_quantity);
                    $('#totalqty' + id).html(data.available_quantity);
                    $('#available_quantity' + id).val(data.available_quantity);
                    $('#sale_price' + id).val(data.sale_rate);
                }
            });
        }
    }

    function getExpire(id) {
        var medicine = $("#medicine_name" + id).val();
        var batch_no = $("#batch_no" + id).val();
        $.ajax({
            type: "POST",
            url: base_url + "admin/pharmacy/getExpiryDate",
            data: {'batch_no': batch_no ,'med_id': medicine},
            dataType: 'json',
            success: function (res) {
                if (res != null) {
                    $('#expire_date' + id).val(res.expiry_date);
                    getQuantity(id);
                }
            }
        });
    }

    function getbatchnolist(id, rowid) {
//alert(id)
        // var batch_no = $("#batch_no"+id).val();
        //$('#medicine_name'+rowid).select2("val", '');
        var div_data = "";
        //$('#quantity').html(data.available_quantity);
        $('#totalqty' + rowid).html("<span class='input-group-addon text-danger' style='font-size:10pt'  id='totalqty" + rowid + "'></span>");
        $('#available_quantity' + rowid).val('');
        $('#sale_price' + rowid).val('');
        $('#expire_date' + rowid).val('');
        $('#amount' + rowid).val('');
        $('#quantity' + rowid).val('');
        //      $("#batch_no" + rowid).html("<option value=''>Select</option>");
        $("#batch_no" + rowid).html("<option value='l'><?php echo $this->lang->line('loading') ?></option>");
        //  $('#batch_no' + rowid).select2("val", 'l');
        $.ajax({
            type: "POST",
            url: base_url + "admin/pharmacy/getBatchNoList",
            data: {'medicine': id},
            dataType: 'json',
            success: function (res) {
                //console.log(res);
                $.each(res, function (i, obj)
                {
                    var sel = "";
                    div_data += "<option value='" + obj.batch_no + "'>" + obj.batch_no + "</option>";
                });
                $("#batch_no" + rowid).html("<option value=''>Select</option>");
//       $('#batch_no' + rowid).select2("val", 'l');

                $('#batch_no' + rowid).append(div_data);
            }
        });
    }

    function get_Docname(id) {
        $("#standard_charge").html("standard_charge");
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

    function multiply(id) {

        var quantity = $('#quantity' + id).val();
        var availquantity = $('#available_quantity' + id).val();
        if (parseInt(quantity) > parseInt(availquantity)) {
            errorMsg('Order quantity should not be greater than available quantity');
        } else {
            //alert(parseInt(quantity));
        }
        var sale_price = $('#sale_price' + id).val();
        var amount = quantity * sale_price;
        $('#amount' + id).val(amount);
    }

    function generateBillNo() {
        $.ajax({
            url: '<?php echo base_url(); ?>admin/pharmacy/getBillNo',
            type: "POST",
            dataType: 'json',
            data: {id: 1},
            success: function (data) {
                //alert(data);
                $('#billno').val(data);
                $('#billnoform').val(data);
            }
        });

    }

    /* function getPatientIdName(opd_ipd_no) {
     //var opd_ipd_patient_type = $('select[name=customer_type]:selected').val();
     //alert(opd_ipd_patient_type);
     //alert($("#customer_type").val());
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
     $('#doctor_name').val(data.doctorname + ' ' + data.surname);
     }
     });
     }*/
// function add_instruction(id){
//     $('#ins_patient_id').val(id);
// }

    function holdModal(modalId) {
        $('#' + modalId).modal({
            backdrop: 'static',
            keyboard: false,
            show: true
        });
        //$('#tableID').html('');
        /* var table = document.getElementById("tableID");
         var table_len = (table.rows.length);
         var id = parseInt(table_len - 1);
         var div = "<td><select class='form-control' name='medicine_category_id[]' onchange='getmedicine_name(this.value," + id + ")'><option value='<?php echo set_value('medicine_category_id'); ?>'><?php echo $this->lang->line('select') ?></option><?php foreach ($medicineCategory as $dkey => $dvalue) { ?><option value='<?php echo $dvalue["id"]; ?>'><?php echo $dvalue["medicine_category"] ?></option><?php } ?></select></td><td><select class='form-control select2' style='width:100%' name='medicine_name[]' onchange='getbatchnolist(this.value," + id + ")' id='medicine_name" + id + "' ><option value='<?php echo set_value('medicine_name'); ?>'><?php echo $this->lang->line('select') ?></option></select></td><td><select name='batch_no[]' id='batch_no" + id + "' onchange='getExpire(" + id + ")' class='form-control'><option value='<?php echo set_value('batch_no'); ?>'><?php echo $this->lang->line('select') ?></option></select></td><td><input type='text' name='expire_date[]' readonly id='expire_date" + id + "' class='form-control expire_date'></td><td><div class='input-group'><input type='text' name='quantity[]' onchange='multiply(" + id + ")' onfocus='getQuantity(" + id + ")' id='quantity" + id + "' class='form-control text-right'><span class='input-group-addon text-danger' style='font-size:10pt'  id='totalqty" + id + "'>&nbsp;&nbsp;</span></div><input type='hidden' name='available_quantity[]' id='available_quantity" + id + "'><input type='hidden' name='id[]' id='id" + id + "'></td><td> <input type='text' onchange='multiply(" + id + ")' name='sale_price[]' id='sale_price" + id + "'  class='form-control text-right'></td><td><input type='text' name='amount[]' id='amount" + id + "'  class='form-control text-right'></td>";
         
         var row = table.insertRow(table_len).outerHTML = "<tr id='row" + id + "'>" + div + "<td><button type='button' onclick='addMore()'style='color: #2196f3' class='closebtn'><i class='fa fa-plus'></i></button></td></tr>"; */
        $('.select2').select2();

        var expire_date = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(), ['d' => 'DD', 'm' => 'MM', 'Y' => 'YYYY',]) ?>';
        $('.expire_date').datepicker({
            format: "m/yyyy",
            viewMode: "months",
            minViewMode: "months",
            autoclose: true
        });
        generateBillNo()
    }
</script>
<script type="text/javascript">
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

            function showtextbox(value) {
                if (value != 'direct') {
                    $("#opd_ipd_no").show();
                } else {
                    $("#opd_ipd_no").hide();
                }
            }
</script>
<?php $this->load->view('admin/patient/patientaddmodal') ?>