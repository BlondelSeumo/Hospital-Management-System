<?php
$currency_symbol = $this->customlib->getSchoolCurrencyFormat();
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
                        <?php if ($title == 'old_patient') { ?>
                            <h3 class="box-title titlefix"><?php echo $this->lang->line('opd') . " " . $this->lang->line('old') . " " . $this->lang->line('patient') ?></h3>
                        <?php } else { ?>
                            <h3 class="box-title titlefix"><?php echo $this->lang->line('opd') . " " . $this->lang->line('patient') ?></h3>

                        <?php } ?>
                        <div class="box-tools pull-right">
                            <?php if ($this->rbac->hasPrivilege($title, 'can_add')) { ?>                
                                <a data-toggle="modal" id="add" onclick="holdModal('myModal')" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>  <?php echo $this->lang->line('add') . " " . $this->lang->line('patient') ?></a> 
                            <?php } ?> 
                            <?php if ($title !== 'old_patient') { ?>
                                <?php //if ($this->rbac->hasPrivilege('old_patient', 'can_view')) { ?>
                                   <!--  <a href="<?php //echo base_url('admin/patient/getoldpatient');  ?>" class="btn btn-primary btn-sm"><i class="fa fa-reorder"></i>  <?php //echo $this->lang->line('old') . " " . $this->lang->line('patient')  ?></a>  -->
                                <?php
                                //}
                            }
                            ?>

                        </div>    
                    </div><!-- /.box-header -->

                    <?php
                    if (isset($resultlist)) {
                        ?>
                        <div class="box-body">
                            <div class="download_label"><?php
                                if ($title == 'old_patient') {
                                    echo $this->lang->line('opd') . " " . $this->lang->line('old') . " " . $this->lang->line('patient')
                                    ?>
                                    <?php
                                } else {
                                    echo $this->lang->line('opd') . " " . $this->lang->line('patient')
                                    ?>

                                <?php } ?></div>
                            <table class="table table-striped table-bordered table-hover example" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('name') ?></th>
                                        <th><?php echo $this->lang->line('patient') . " " . $this->lang->line('id'); ?></th>

                                        <th><?php echo $this->lang->line('guardian_name') ?></th>
                                        <th><?php echo $this->lang->line('gender'); ?></th>
                                        <th><?php echo $this->lang->line('phone'); ?></th>
                                        <th><?php echo $this->lang->line('consultant'); ?></th>
                                        <th><?php echo $this->lang->line('last') . " " . $this->lang->line('visit'); ?></th>
                                       <!-- <th><?php echo $this->lang->line('opd') . " " . $this->lang->line('no'); ?></th> -->
                                        <th><?php echo $this->lang->line('total') . " " . $this->lang->line('visit'); ?></th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (empty($resultlist)) {
                                        ?>
                                        <?php
                                    } else {
                                        $count = 1;
                                        foreach ($resultlist as $student) {
                                            if (!empty($student["name"])) {
                                                ?>
                                                <tr class="">

                                                    <td>
                                                        <a href="<?php echo base_url(); ?>admin/patient/profile/<?php echo $student['pid']; ?>"><?php echo $student['patient_name']; ?>
                                                        </a>
                                                        <div class="rowoptionview"> 
                                                            <?php if ($this->rbac->hasPrivilege('revisit', 'can_add')) { ?>
                                                                <a href="#" onclick="getRevisitRecord('<?php echo $student['pid'] ?>')" class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('revisit'); ?>">
                                                                    <i class="fas fa-exchange-alt"></i>
                                                                </a>
                                                            <?php } ?> 
                                                            <?php if ($this->rbac->hasPrivilege($title, 'can_view')) { ?>
                                                                <a href="<?php echo base_url(); ?>admin/patient/profile/<?php echo $student['pid'] ?>" class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('show'); ?>" >
                                                                    <i class="fa fa-reorder"></i>
                                                                </a>
                                                            <?php } ?>
                                                            <?php
                                                            if ($student['is_ipd'] != 'yes') {
                                                                if ($this->rbac->hasPrivilege('opd_move _patient_in_ipd', 'can_view')) {
                                                                    ?>
                                                                    <a href="<?php echo base_url(); ?>admin/patient/moveipd/<?php echo $student['pid']; ?>" class="btn btn-default btn-xs" data-toggle="tooltip" title="" onclick="return confirm('<?php echo $this->lang->line('move') . " " . $this->lang->line('patient') . " " . $this->lang->line('in') . " " . $this->lang->line('ipd'); ?>');" data-original-title="<?php echo $this->lang->line('move') . " " . $this->lang->line('patient') . " " . $this->lang->line('in') . " " . $this->lang->line('ipd'); ?>">

                                                                        <i class="fas fa-share-square" aria-hidden="true"></i>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                        </div>  
                                                    </td>
                                                    <td><?php echo $student["patient_unique_id"] ?></td>
                                                    <td><?php echo $student['guardian_name']; ?></td>
                                                    <td><?php echo $student['gender']; ?></td>
                                                    <td><?php echo $student['mobileno']; ?></td>
                                                    <td><?php echo $student['name'] . " " . $student['surname']; ?></td>
                                                    <td><?php echo date($this->customlib->getSchoolDateFormat(true, true), strtotime($student['last_visit'])) ?>
                                                    </td>
                                                   <!--- <td><?php echo $student['opdno']; ?></td>-->
                                                    <td><?php echo $student['total_visit']; ?></td>


                                                </tr>
                                                <?php
                                                $count++;
                                            }
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <?php
                    }
                    ?>
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
                    <div class="col-sm-6 col-xs-6">
                        <div class="form-group15">
                            <div>
                                <select onchange="get_PatientDetails(this.value)"  class="form-control select2" <?php
                                if ($disable_option == true) {
                                    //echo "disabled";
                                }
                                ?> style="width:100%" name='' id="addpatient_id" >
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
                    <div class="col-sm-4 col-xs-5">
                        <div class="form-group15">
                            <?php if ($this->rbac->hasPrivilege('patient', 'can_add')) { ?>
                                <a data-toggle="modal" id="add" onclick="holdModal('myModalpa')" class="modalbtnpatient"><i class="fa fa-plus"></i>  <span><?php echo $this->lang->line('new') . " " . $this->lang->line('patient') ?></span></a> 
<?php } ?> 

                        </div>
                    </div><!--./col-sm-4--> 
                </div><!-- ./row -->                
            </div><!--./modal-header-->

            <div class="modal-body pt0 pb0">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <form id="formadd" accept-charset="utf-8" action="<?php echo base_url() . "admin/patient" ?>" enctype="multipart/form-data" method="post">
                            <input name="patient_id" id="patient_id" type="hidden" class="form-control" />
                            <input name="email" id="pemail" type="hidden" class="form-control" />
                            <input name="mobileno" id="mobnumber" type="hidden" class="form-control" />
                            <input name="patient_name" id="patientname" type="hidden" class="form-control" />
                            
                            <div class="row row-eq">
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                    <div id="ajax_load"></div>
                                    <div class="row ptt10" id="patientDetails" style="display:none">

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

                                    <div class="row">
                                        <div class="col-md-12">	


                                            <div class="dividerhr"></div>
                                        </div><!--./col-md-12-->
                                        <div class="col-sm-2 col-xs-4">
                                            <div class="form-group">
                                                <label for="pwd"><?php echo $this->lang->line('height'); ?></label> 
                                                <input name="height" type="text" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="col-sm-2 col-xs-4">
                                            <div class="form-group">
                                                <label for="pwd"><?php echo $this->lang->line('weight'); ?></label> 
                                                <input name="weight" type="text" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="col-sm-2 col-xs-4">
                                            <div class="form-group">
                                                <label for="pwd"><?php echo $this->lang->line('bp'); ?></label> 
                                                <input name="bp" type="text" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="email"><?php echo $this->lang->line('symtoms'); ?></label> 
                                                <textarea style="height: 28px;" name="symptoms" class="form-control" ><?php echo set_value('address'); ?></textarea>
                                            </div> 
                                        </div>
                                        <!--<div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="email"><?php echo $this->lang->line('any_known_allergies'); ?></label> 
                                                <textarea name="known_allergies" class="form-control" ><?php echo set_value('address'); ?></textarea>
                                            </div> 
                                        </div>-->
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="pwd"><?php echo $this->lang->line('note'); ?></label> 
                                                <textarea name="note" rows="3" class="form-control" ><?php echo set_value('note'); ?></textarea>
                                            </div>
                                        </div>     
                                    </div><!--./row--> 
                                </div><!--./col-md-8--> 
                                <div class="col-lg-4 col-md-4 col-sm-4 col-eq ptt10">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('appointment') . " " . $this->lang->line('date'); ?></label>
                                                <small class="req"> *</small>
                                                <input id="admission_date" name="appointment_date" placeholder="" type="text" class="form-control datetime" />
                                                <span class="text-danger"><?php echo form_error('appointment_date'); ?></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="exampleInputFile">
<?php echo $this->lang->line('case'); ?></label>
                                                <div><input class="form-control" type='text' name='case' />
                                                </div>
                                                <span class="text-danger"><?php echo form_error('case'); ?></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="exampleInputFile">
<?php echo $this->lang->line('casualty'); ?></label>
                                                <div>
                                                    <select name="casualty" id="casualty" class="form-control">

                                                        <option value="<?php echo $this->lang->line('yes') ?>"><?php echo $this->lang->line('yes') ?></option>
                                                        <option value="<?php echo $this->lang->line('no') ?>" selected><?php echo $this->lang->line('no') ?></option>
                                                    </select>
                                                </div>
                                                <span class="text-danger"><?php echo form_error('case'); ?></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="exampleInputFile">
<?php echo $this->lang->line('old') . " " . $this->lang->line('patient'); ?></label>
                                                <div>
                                                    <select name="old_patient" class="form-control">

                                                        <option value="<?php echo $this->lang->line('yes') ?>" ><?php echo $this->lang->line('yes') ?></option>
                                                        <option value="<?php echo $this->lang->line('no') ?>" selected><?php echo $this->lang->line('no') ?></option>
                                                    </select>
                                                </div>
                                                <span class="text-danger"><?php echo form_error('case'); ?></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="exampleInputFile">
                                                        <?php echo $this->lang->line('organisation'); ?></label>
                                                <div><select class="form-control" onchange="get_Charges('')" id="organisation" name='organisation' >
                                                        <option value=""><?php echo $this->lang->line('select') ?></option>
                                                        <?php foreach ($organisation as $orgkey => $orgvalue) {
                                                            ?>
                                                            <option value="<?php echo $orgvalue["id"]; ?>"><?php echo $orgvalue["organisation_name"] ?></option>   
<?php } ?>
                                                    </select>
                                                </div>
                                                <span class="text-danger"><?php echo form_error('refference'); ?></span>
                                            </div>
                                        </div>  

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="exampleInputFile">
<?php echo $this->lang->line('refference'); ?></label>
                                                <div><input class="form-control" type='text' name='refference' />
                                                </div>
                                                <span class="text-danger"><?php echo form_error('refference'); ?></span>
                                            </div>
                                        </div>


                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="exampleInputFile">
                                                    <?php echo $this->lang->line('consultant') . " " . $this->lang->line('doctor'); ?></label><small class="req"> *</small>
                                                <div><select name='consultant_doctor' id="consultant_doctor" onchange="get_Charges(this.value)" class="form-control select2" <?php
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
<?php if ($disable_option == true) { ?>
                                                        <input type="hidden" name="consultant_doctor" value="<?php echo $doctor_select ?>">
<?php } ?>
                                                </div>
                                                <span class="text-danger"><?php echo form_error('refference'); ?></span>
                                            </div>
                                        </div>




                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('standard') . " " . $this->lang->line('charge') . " (" . $currency_symbol . ")" ?></label>
                                                <input type="text" readonly name="standard_charge" id="standard_charge" class="form-control" value="<?php echo set_value('standard_charge'); ?>"> 

                                                <span class="text-danger"><?php echo form_error('standard_charge'); ?></span>
                                            </div>
                                        </div> 

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('applied') . " " . $this->lang->line('charge') . " (" . $currency_symbol . ")" ?></label><small class="req"> *</small><input type="text" name="amount" id="apply_charge" class="form-control">    
                                                <span class="text-danger"><?php echo form_error('apply_charge'); ?></span>
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="pwd"><?php echo $this->lang->line('payment') . " " . $this->lang->line('mode'); ?></label> 
                                                <select name="payment_mode" class="form-control">
                                                    <?php foreach ($payment_mode as $payment_key => $payment_value) {
                                                        ?>
                                                        <option value="<?php echo $payment_key ?>" <?php
                                                                if ($payment_key == 'cash') {
                                                                    echo "selected";
                                                                }
                                                                ?> ><?php echo $payment_value ?></option>
<?php } ?>
                                                </select>
                                            </div>
                                        </div> 

                                    </div><!--./row-->    
                                </div><!--./col-md-4-->
                            </div><!--./row--> 

                            <div class="row">            
                                <div class="box-footer">

                                    <div class="pull-right mrminus8">
                                        <button type="submit" id="formaddbtn" data-loading-text="<?php echo $this->lang->line('processing') ?>" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                                    </div>

                                    <div class="pull-right" style="margin-right: 10px; ">
                                        <button type="button"  data-loading-text="<?php echo $this->lang->line('processing') ?>" class="btn btn-info pull-right printsavebtn"><?php echo $this->lang->line('save') . " & " . $this->lang->line("print"); ?></button>
                                    </div>
                                </div>
                            </div><!--./row-->  
                        </form>                       
                    </div><!--./col-md-12-->       
                </div><!--./row--> 
            </div>
        </div>
    </div>    
</div>


<!-- revisit -->
<div class="modal fade" id="revisitModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="box-title"> <?php echo $this->lang->line('patient') . " " . $this->lang->line('information'); ?></h4> 
            </div>

            <div class="modal-body pt0 pb0">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 ">
                        <form id="formrevisit" accept-charset="utf-8" enctype="multipart/form-data" method="post" >
                            <div class="row row-eq">
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <ul class="singlelist">
                                                <li class="singlelist24bold">
                                                    <span id="rrlistname"></span></li>
                                                <li>
                                                    <i class="fas fa-user-secret" data-toggle="tooltip" data-placement="top" title="Guardian"></i>
                                                    <span id="rrguardian"></span>
                                                </li>
                                            </ul>   
                                            <ul class="multilinelist">   
                                                <li>
                                                    <i class="fas fa-venus-mars" data-toggle="tooltip" data-placement="top" title="Gender"></i>
                                                    <span id="rrgender" ></span>
                                                </li>
                                                <li>
                                                    <i class="fas fa-tint" data-toggle="tooltip" data-placement="top" title="Blood Group"></i>
                                                    <span id="rrblood_group"></span>
                                                </li>
                                                <li>
                                                    <i class="fas fa-ring" data-toggle="tooltip" data-placement="top" title="Marital Status"></i>
                                                    <span id="rrmarital_status"></span>
                                                </li> 
                                            </ul>  
                                            <ul class="singlelist">  
                                                <li>
                                                    <i class="fas fa-hourglass-half" data-toggle="tooltip" data-placement="top" title="Age"></i>
                                                    <span id="rrage"></span>
                                                </li>    

                                                <li>
                                                    <i class="fa fa-phone-square" data-toggle="tooltip" data-placement="top" title="Phone"></i> 
                                                    <span id="rrlistnumber"></span>
                                                </li>
                                                <li>
                                                    <i class="fa fa-envelope" data-toggle="tooltip" data-placement="top" title="Email"></i>
                                                    <span id="rremail"></span>
                                                </li>
                                                <li>
                                                    <i class="fas fa-street-view" data-toggle="tooltip" data-placement="top" title="Address"></i>
                                                    <span id="rraddress" ></span>
                                                </li>

                                            </ul> 

                                        </div>    
                                        <input type="hidden" name="id" id="pid">
                                        
                                        <input name="email" id="revisit_email" type="hidden" class="form-control" />
                                        <input name="mobileno" id="revisit_contact" type="hidden" class="form-control" />
                                        <input name="patient_name" id="revisit_name" type="hidden" class="form-control" />

                                        <div class="col-sm-4 col-xs-4">
                                            <div class="form-group">
                                                <label for="pwd"><?php echo $this->lang->line('height'); ?></label> 
                                                <input name="height" id="revisit_height" type="text" class="form-control"  value="<?php echo set_value('height'); ?>" />
                                            </div>
                                        </div>
                                        <div class="col-sm-4 col-xs-4">
                                            <div class="form-group">
                                                <label for="pwd"><?php echo $this->lang->line('weight'); ?></label> 
                                                <input name="weight" id="revisit_weight" type="text" class="form-control"  value="<?php echo set_value('weight'); ?>" />
                                            </div>
                                        </div>
                                        <div class="col-sm-4 col-xs-4">
                                            <div class="form-group">
                                                <label for="pwd"><?php echo $this->lang->line('bp'); ?></label> 
                                                <input name="bp" type="text" id="revisit_bp" class="form-control"  value="<?php echo set_value('bp'); ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="email"><?php echo $this->lang->line('symptoms'); ?></label> 
                                                <textarea name="symptoms" id="revisit_symptoms" class="form-control" ><?php echo set_value('address'); ?></textarea>
                                            </div> 
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="email"><?php echo $this->lang->line('any_known_allergies'); ?></label> <textarea name="known_allergies" id="revisit_allergies" class="form-control" ><?php echo set_value('address'); ?></textarea>
                                            </div> 
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="pwd"><?php echo $this->lang->line('note'); ?></label> 
                                                <textarea name="note_remark" id="revisit_note" class="form-control" ><?php echo set_value('note_remark'); ?></textarea>
                                            </div>
                                        </div>   
                                    </div><!--./row--> 
                                </div><!--./col-md-8--> 
                                <div class="col-lg-4 col-md-4 col-sm-4 col-eq ptt10">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('appointment') . " " . $this->lang->line('date'); ?></label>
                                                <small class="req">*</small>
                                                <input id="revisit_date" name="appointment_date" placeholder="" type="text" class="form-control datetime"   />
                                                <span class="text-danger"><?php echo form_error('appointment_date'); ?></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="exampleInputFile">
<?php echo $this->lang->line('case'); ?></label>
                                                <div><input class="form-control" type='text' id="revisit_case" name='revisit_case' />
                                                </div>
                                                <span class="text-danger"><?php echo form_error('case'); ?></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="exampleInputFile">
<?php echo $this->lang->line('casualty'); ?></label>
                                                <div>
                                                    <select name="casualty" id="revisit_casualty" class="form-control">
                                                        <option value="<?php echo $this->lang->line('yes') ?>"><?php echo $this->lang->line('yes') ?></option>
                                                        <option value="<?php echo $this->lang->line('no') ?>" selected><?php echo $this->lang->line('no') ?></option>
                                                    </select>
                                                </div>
                                                <span class="text-danger"><?php echo form_error('casualty'); ?></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="exampleInputFile">
<?php echo $this->lang->line('old') . " " . $this->lang->line('patient'); ?></label>
                                                <div>
                                                    <select name="old_patient" id="revisit_old_patient" class="form-control">
                                                        <option value="<?php echo $this->lang->line('yes') ?>"><?php echo $this->lang->line('yes') ?></option>
                                                        <option value="<?php echo $this->lang->line('no') ?>" selected><?php echo $this->lang->line('no') ?></option>
                                                    </select>
                                                </div>
                                                <span class="text-danger"><?php echo form_error('old_patient'); ?></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="exampleInputFile">
                                                        <?php echo $this->lang->line('organisation'); ?></label>
                                                <div><select class="form-control"  name='organisation_name' onchange="get_Chargesrevisit('')" id="revisit_organisation" >
                                                        <option value=""><?php echo $this->lang->line('select') ?></option>
<?php foreach ($organisation as $orgkey => $orgvalue) {
    ?>
                                                            <option value="<?php echo $orgvalue["id"]; ?>"><?php echo $orgvalue["organisation_name"] ?></option>   
<?php } ?>
                                                    </select>
                                                </div>
                                                <span class="text-danger"><?php echo form_error('organisation_name'); ?></span>
                                            </div>
                                        </div> 
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="exampleInputFile">
<?php echo $this->lang->line('refference'); ?></label>
                                                <div><input class="form-control" id="revisit_refference" type='text' name='refference' />
                                                </div>
                                                <span class="text-danger"><?php echo form_error('refference'); ?></span>
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="exampleInputFile">
                                                    <?php echo $this->lang->line('consultant') . " " . $this->lang->line('doctor'); ?>
                                                </label> <small class="req">*</small>
                                                <div>
                                                    <select onchange="get_Chargesrevisit(this.value)" class="form-control" <?php
                                                        if ($disable_option == true) {
                                                            echo "disabled";
                                                        }
                                                        ?> name='consultant_doctor' id="revisit_doctor">
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
<?php if ($disable_option == true) { ?>
                                                        <input type="hidden" name="consultant_doctor" value="<?php echo $doctor_select ?>">
<?php } ?>
                                                </div>
                                                <span class="text-danger"><?php echo form_error('refference'); ?></span>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('standard') . " " . $this->lang->line('charge') . " (" . $currency_symbol . ")" ?></label>
                                                <input type="text" readonly name="standard_charge" id="standard_chargerevisit" class="form-control" value="<?php echo set_value('standard_charge'); ?>"> 

                                                <span class="text-danger"><?php echo form_error('standard_charge'); ?></span>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="pwd"><?php echo $this->lang->line('amount'); ?> <?php echo '(' . $currency_symbol . ')'; ?></label> <small class="req">*</small>
                                                <input name="amount" type="text" class="form-control" id="revisit_amount" />
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="pwd"><?php echo $this->lang->line('payment') . " " . $this->lang->line('mode'); ?></label> 
                                                <select name="payment_mode" id="revisit_payment" class="form-control">

                                                            <?php foreach ($payment_mode as $payment_key => $payment_value) {
                                                                ?>
                                                        <option value="<?php echo $payment_key ?>" <?php
                                                            if ($payment_key == 'cash') {
                                                                echo "selected";
                                                            }
                                                            ?> ><?php echo $payment_value ?></option>
<?php } ?>
                                                </select>
                                            </div>
                                        </div>  
                                    </div>
                                </div>
                            </div><!--./row-->   
                            <div class="row">            
                                <div class="box-footer">
                                    <div class="pull-right mrminus8">
                                        <button type="submit" id="formrevisitbtn" data-loading-text="<?php echo $this->lang->line('processing') ?>" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                                    </div>
                                    <div class="pull-right" style="margin-right: 10px;">
                                        <button type="button"  data-loading-text="<?php echo $this->lang->line('processing') ?>" class="btn btn-info pull-right printsavedata"><?php echo $this->lang->line('save') . " & " . $this->lang->line("print"); ?></button>
                                    </div>
                                </div>
                            </div><!--./row-->  
                        </form>                       
                    </div><!--./col-md-12-->       

                </div><!--./row--> 

            </div>

        </div>
    </div>    
</div>
<!-- dd -->
<div class="modal fade" id="myModaledit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="box-title">  <?php echo $this->lang->line('patient') . " " . $this->lang->line('information'); ?></h4> 
            </div>

            <div class="modal-body pt0 pb0">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 paddlr">
                        <form id="formedit" accept-charset="utf-8"  enctype="multipart/form-data" method="post"  class="ptt10">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('name'); ?></label><small class="req"> *</small> 
                                        <input id="patient_name" name="name" placeholder="" type="text" class="form-control"  value="<?php echo set_value('name'); ?>" />
                                        <input type="hidden" id="updateid" name="updateid">
                                        <input type="hidden" id="opdid" name="opdid">
                                        <span class="text-danger"><?php echo form_error('name'); ?></span>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('guardian_name'); ?></label>
                                        <input type="text" id="guardian_name" name="guardian_name" value="<?php echo set_value('guardian_name'); ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('gender'); ?></label><small class="req"> *</small> 
                                        <select class="form-control" id="gender" name="gender">
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                            <?php
                                            foreach ($genderList as $key => $value) {
                                                ?>
                                                <option value="<?php echo $key; ?>" <?php if (set_value('gender') == $key) echo "selected"; ?>><?php echo $value; ?></option>
    <?php
}
?>
                                        </select>
                                        <span class="text-danger"><?php echo form_error('gender'); ?></span>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="pwd"><?php echo $this->lang->line('marital_status'); ?></label>
                                        <select name="marital_status" id="marital_status" class="form-control">
                                            <option value=""><?php echo $this->lang->line('select') ?></option>
<?php foreach ($marital_status as $mkey => $mvalue) {
    ?>
                                                <option value="<?php echo $mkey ?>"><?php echo $mvalue ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="exampleInputFile">
<?php echo $this->lang->line('patient') . " " . $this->lang->line('photo'); ?></label>
                                        <div><input class="filestyle form-control" type='file' name='file' id="file" size='20' />
                                            <input type="hidden" name="patient_photo" id="patient_photo">
                                        </div>
                                        <span class="text-danger"><?php echo form_error('file'); ?></span>
                                    </div>
                                </div>  
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('email'); ?></label>
                                        <input type="text" id="email" value="<?php echo set_value('email'); ?>" name="email" class="form-control">
                                    </div>
                                </div> 
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="pwd"><?php echo $this->lang->line('phone'); ?></label>
                                        <input id="contact" autocomplete="off" name="contact" placeholder="" type="text" class="form-control"  value="<?php echo set_value('contact'); ?>" />
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label> <?php echo $this->lang->line('blood_group'); ?></label><small class="req"> *</small> 
                                        <select class="form-control" id="blood_group" name="blood_group">
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                            <?php
                                            foreach ($bloodgroup as $key => $value) {
                                                ?>
                                                <option value="<?php echo $value; ?>" <?php if (set_value('blood_group') == $key) echo "selected"; ?>><?php echo $value; ?></option>
    <?php
}
?>
                                        </select>
                                        <span class="text-danger"><?php echo form_error('blood_group'); ?></span>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('age'); ?></label>
                                        <div style="clear: both;overflow: hidden;">
                                            <input type="text" placeholder="Age" id="age" name="age" value="<?php echo set_value('age'); ?>" class="form-control" style="width: 40%; float: left;">
                                            <input type="text" placeholder="Month" id="month" name="month" value="<?php echo set_value('month'); ?>" class="form-control" style="width: 56%;float: left; margin-left: 5px;">

                                        </div>
                                    </div>
                                </div> 

                            </div><!--./row-->   
                            <button type="submit" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                        </form>                       
                    </div><!--./col-md-12-->       
                </div><!--./row--> 
            </div>
            <div class="box-footer">
                <div class="pull-right paddA10">

                       <!--  <a  onclick="saveEnquiry()" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></a> -->
                </div>
            </div>
        </div>
    </div>    
</div>



<script type="text/javascript">



    $('#myModal').on('hidden.bs.modal', function (e) {
        $(this).find('#formadd')[0].reset();
    });

    $('#myModalpa').on('hidden.bs.modal', function (e) {
        $(this).find('#formaddpa')[0].reset();
    });

    $(function () {
        $('#easySelectable').easySelectable();
        $('.select2').select2()
//stopPropagation();
    })

    // var capital_date_format=date_format.toUpperCase();      
    //         $.fn.dataTable.moment(capital_date_format);

    function get_PatientDetails(id) {
        //$("#schedule_charge").html("schedule_charge");
        var base_url = "<?php echo base_url(); ?>backend/images/loading.gif";
        $("#ajax_load").html("<center><img src='" + base_url + "'/>");

        //$('#guardian_name').html("Null");
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
                    $('#patient_unique_id').html(res.patient_unique_id);
                    $('#patient_id').val(res.id);
                    $('#listname').html(res.patient_name);
                    $('#guardian').html(res.guardian_name);
                    $('#listnumber').html(res.mobileno);
                    $('#email').html(res.email);
                    $('#mobnumber').val(res.mobileno);
                    $('#pemail').val(res.email);
                    $('#patientname').val(res.patient_name);
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
                    //var patientage = $("#age").val(res.age);


                    $('#doctname').val(res.name + " " + res.surname);
                    //$("#dob").html(res.dob);
                    $("#bp").html(res.bp);
                    //$("#month").html(res.month);
                    $("#symptoms").html(res.symptoms);
                    $("#known_allergies").html(res.known_allergies);
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


    function get_Charges(id) {

        var orgid = $("#organisation").val();
        if (id == '') {
            id = $("#consultant_doctor").val();
        }
        $.ajax({
            url: '<?php echo base_url(); ?>admin/patient/doctortpaCharge',
            type: "POST",
            data: {doctor: id, organisation: orgid},
            dataType: 'json',
            success: function (res) {
                if (res) {

                    if (orgid) {
                        $('#apply_charge').val(res.org_charge);
                        $('#standard_charge').val(res.standard_charge);
                    } else {
                        $('#standard_charge').val(res.standard_charge);
                        $('#apply_charge').val(res.standard_charge);
                    }
                } else {
                    $('#standard_charge').val('0');
                    $('#apply_charge').val('0');
                }
            }
        });
    }



    function get_Chargesrevisit(id) {
        $("#standard_chargerevisit").html("standard_charge");
        var orgid = $("#revisit_organisation").val();
        //$("#schedule_charge").html("schedule_charge");
        if (id == '') {
            id = $("#revisit_doctor").val();
        }

        $.ajax({
            url: '<?php echo base_url(); ?>admin/patient/doctCharge',
            type: "POST",
            data: {doctor: id, organisation: orgid},
            dataType: 'json',
            success: function (res) {
                console.log(res);
                if (res) {
                    if (orgid) {
                        $('#revisit_amount').val(res.org_charge);
                        $('#standard_chargerevisit').val(res.standard_charge);
                    } else {
                        $('#standard_chargerevisit').val(res.standard_charge);
                        $('#revisit_amount').val(res.standard_charge);
                    }
                    //   $('#standard_chargerevisit').val(res.standard_charge);
                    //$('#revisit_amount').val(res.standard_charge);

                } else {
                    $('#standard_chargerevisit').val('0');
                    $('#revisit_amount').val('0');
                }
            }
        });
    }

    function getcharge_category(id, htmlid) {
        var div_data = "";
        $("#" + htmlid).html("<option value='l'><?php echo $this->lang->line('loading') ?></option>");
        $.ajax({
            url: '<?php echo base_url(); ?>admin/charges/get_charge_doctor',
            type: "POST",
            data: {doctor: id},
            dataType: 'json',
            success: function (res) {
                $.each(res, function (i, obj)
                {
                    var sel = "";
                    div_data += "<option value='" + obj.standard_charge + "'>" + obj.standard_charge + "</option>";
                });
                $("#" + htmlid).html("<option value=''>Select</option>");
                $('#' + htmlid).append(div_data);
            }
        });
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
    $(document).ready(function (e) {
        $("#formadd").on('submit', (function (e) {
            $("#formaddbtn").button('loading');
            e.preventDefault();
            $.ajax({
                url: '<?php echo base_url(); ?>admin/patient',
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
                        //alert(data.message);

                        //window.location.href = "#myModal";
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

    function popup(data) {
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
            window.location.reload(true);
        }, 500);

        return true;

    }
    $(document).ready(function (e) {

        $(".printsavebtn").on('click', (function (e) {
            // $(this).submit();
            var form = $(this).parents('form').attr('id');

            //   $("#"+form).submit();
            var str = $("#" + form).serializeArray();
            var postData = new FormData();
            $.each(str, function (i, val) {
                postData.append(val.name, val.value);
            });

            $.ajax({
                url: '<?php echo base_url(); ?>admin/patient',
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
                        patientid = $("#addpatient_id").val();
                        printVisitBill(patientid,data.opd_id)
                        //window.location.href = "#myModal";
                        //   window.location.reload(true);
                    }
                    $("#formaddbtn").button('reset');
                },
                error: function () {
                    //  alert("Fail")
                }
            });
            // patientid = $("#addpatient_id").val();
            //  printVisitBill(patientid);
        }));
    });

    $(document).ready(function (e) {

        $(".printsavedata").on('click', (function (e) {
            // $(this).submit();
            var form = $(this).parents('form').attr('id');
            var str = $("#" + form).serializeArray();
            var postData = new FormData();
            $.each(str, function (i, val) {
                postData.append(val.name, val.value);
            });
            //        $("#"+form).submit();

            $.ajax({
                url: '<?php echo base_url(); ?>admin/patient/add_revisit',
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
                        patientid = $("#pid").val();
                        printVisitBill(patientid, data.id);
                        //window.location.reload(true);
                    }
                    $("#formrevisitbtn").button('reset');
                },
                error: function () {
                    //  alert("Fail")
                }
            });
            // patientid = $("#pid").val();
            //  printVisitBill(patientid);
        }));
    });

    function printVisitBill(patientid = '',opdid) {

        var base_url = '<?php echo base_url() ?>';
        $.ajax({
            url: base_url + 'admin/payment/getVisitBill/',
            type: 'POST',
            data: {patient_id: patientid,visit_id:opdid},
            success: function (result) {
                $("#testdata").html(result);
                popup(result);
            }
        });
    }

    $(document).ready(function (e) {
        $("#formrevisit").on('submit', (function (e) {
            $("#formrevisitbtn").button('loading');
            e.preventDefault();
            $.ajax({
                url: '<?php echo base_url(); ?>admin/patient/add_revisit',
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
                    $("#formrevisitbtn").button('reset');
                },
                error: function () {
                    //  alert("Fail")
                }
            });


        }));
    });
    /**/

    $(document).ready(function (e) {
        $("#formedit").on('submit', (function (e) {
            e.preventDefault();
            $.ajax({
                url: '<?php echo base_url(); ?>admin/patient/update',
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
                },
                error: function () {
                    //  alert("Fail")
                }
            });
        }));
    });


    /**/


    function getRecord(id) {

        $.ajax({
            url: '<?php echo base_url(); ?>admin/patient/getDetails',
            type: "POST",
            data: {recordid: id},
//
            dataType: 'json',
            success: function (data) {

                $("#patientid").val(data.patient_unique_id);
                $("#patient_name").val(data.patient_name);
                $("#contact").val(data.mobileno);
                $("#email").val(data.email);
                $("#age").val(data.age);
                $("#bp").val(data.bp);
                $("#month").val(data.month);
                $("#guardian_name").val(data.guardian_name);
                $("#appointment_date").val(data.appointment_date);
                $("#case").val(data.case_type);
                $("#symptoms").val(data.symptoms);
                $("#known_allergies").val(data.known_allergies);
                $("#refference").val(data.refference);
                $("#amount").val(data.amount);
                $("#tax").val(data.tax);
                $("#opdid").val(data.opdid);
                $("#address").val(data.address);
                $("#note").val(data.note);
                $("#height").val(data.height);
                $("#weight").val(data.weight);
                $("#updateid").val(id);
                $('select[id="blood_group"] option[value="' + data.blood_group + '"]').attr("selected", "selected");
                $('select[id="gender"] option[value="' + data.gender + '"]').attr("selected", "selected");
                $('select[id="marital_status"] option[value="' + data.marital_status + '"]').attr("selected", "selected");
                $('select[id="consultant_doctor"] option[value="' + data.cons_doctor + '"]').attr("selected", "selected");
                $('select[id="payment_mode"] option[value="' + data.payment_mode + '"]').attr("selected", "selected");
                $('select[id="casualty"] option[value="' + data.casualty + '"]').attr("selected", "selected");
            },

        })

    }

    function getRevisitRecord(id) {

        $.ajax({
            url: '<?php echo base_url(); ?>admin/patient/getDetails',
            type: "POST",
            data: {patient_id: id},
            dataType: 'json',
            success: function (data) {
                $("#revisit_id").val(data.patient_unique_id);
                $("#revisit_name").val(data.patient_name);
                $('#revisit_guardian').val(data.guardian_name);
                $("#revisit_contact").val(data.mobileno);
                // $("#revisit_date").val(data.appointment_date);
                $("#revisit_case").val(data.case_type);
                $("#revisit_organisation").val(data.orgid);
                $("#pid").val(id);
                $("#revisit_allergies").val(data.known_allergies);
                $("#revisit_refference").val(data.refference);
                $("#revisit_email").val(data.email);
                $("#revisit_amount").val(data.amount);
                $("#revisit_symptoms").val(data.symptoms);
                $("#revisit_age").val(data.age);
                $("#revisit_month").val(data.month);
                $("#revisit_height").val(data.height);
                // $("#revisit_weight").val(data.weight);
                // $("#revisit_bp").val(data.bp);
                $("#revisit_blood_group").val(data.blood_group);
                $("#revisi_tax").val(data.tax);
                $("#revisit_address").val(data.address);
                $("#revisit_note").val(data.note_remark);
                $("#standard_chargerevisit").val(data.standard_charge);
                $("#revisit_amount").val(data.standard_charge);
                if (data.age == "") {
                    $("#rrage").html("");
                } else {
                    $("#rrage").html(data.age + " Years " + data.month + " Month (" + data.dob + ")");
                }
                $('#rrguardian').html(data.guardian_name);
                $('#rrgender').html(data.gender);
                $("#rremail").html(data.email);
                $("#rrblood_group").html(data.blood_group);
                $("#rrlistnumber").html(data.mobileno);
                $("#rrlistname").html(data.patient_name);
                $("#rraddress").html(data.address);
                //$("#revisit_casualty").val(data.casualty);
                $('select[id="revisit_old_patient"] option[value="' + data.old_patient + '"]').attr("selected", "selected");
                $('select[id="revisit_doctor"] option[value="' + data.cons_doctor + '"]').attr("selected", "selected");
                // $('select[id="revisit_payment"] option[value="' + data.payment_mode + '"]').attr("selected", "selected");
                $('select[id="revisit_gender"] option[value="' + data.gender + '"]').attr("selected", "selected");
                $('select[id="revisit_marital_status"] option[value="' + data.marital_status + '"]').attr("selected", "selected");
                holdModal('revisitModal');
            },

        })

    }



    function holdModal(modalId) {

        $('#' + modalId).modal({
            backdrop: 'static',
            keyboard: false,
            show: true
        });
    }


</script>
<?php $this->load->view('admin/patient/patientaddmodal') ?>