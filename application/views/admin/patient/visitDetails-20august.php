<?php
$currency_symbol = $this->customlib->getSchoolCurrencyFormat();
$genderList = $this->customlib->getGender();
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>backend/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
<script src="<?php echo base_url(); ?>backend/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<style type="text/css">
    span{
        text-transform: capitalize;
    }
</style>
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-3">                
                <div class="box box-primary" <?php
                // if ($result["is_active"] == 0) {
                //     echo "style='background-color:#f0dddd;'";
                // }
                ?>>
                    <div class="box-body box-profile">
                        <?php
                        $image = $result['image'];
                        if (!empty($image)) {

                            $file = $result['image'];
                        } else {

                            $file = "uploads/patient_images/no_image.png";
                        }
                        ?>        
                        <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url() . $file ?>" alt="User profile picture">
                        <h3 class="profile-username text-center"><?php echo $result['patient_name']; ?></h3> 
                        <div class="editviewdelete-icon pt8 text-center">
                            <?php if ($this->rbac->hasPrivilege('opd_patient', 'can_edit')) { ?>
                                <a class="" href="#" onclick="getEditRecord('<?php echo $result['id'] ?>')"   data-toggle="tooltip" title="<?php echo $this->lang->line('edit') . " " . $this->lang->line('profile') ?>">
                                    <i class="fa fa-pencil"></i>
                                </a>
                            <?php } ?>
                            <?php if ($this->rbac->hasPrivilege('opd_patient', 'can_delete')) { ?>
                                <a class="" href="#" onclick="delete_patient('<?php echo $result['id'] ?>')"   data-toggle="tooltip" title="<?php echo $this->lang->line('delete') . " " . $this->lang->line('patient') ?>">
                                    <i class="fa fa-trash"></i>
                                </a>
                            <?php } ?>
                        </div>
                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item listnoback">
                                <b><?php echo $this->lang->line('patient') . " " . $this->lang->line('id') ?></b> <a class="pull-right text-aqua"><?php echo $result['patient_unique_id']; ?></a>
                            </li>

                            <li class="list-group-item listnoback">
                                <b><?php echo $this->lang->line('phone'); ?></b> <a class="pull-right text-aqua"><?php echo $result['mobileno']; ?></a>
                            </li>
                            <li class="list-group-item listnoback">
                                <b><?php echo $this->lang->line('email'); ?></b> <a class="pull-right text-aqua"><?php echo $result['email']; ?></a>
                            </li>
                            <li class="list-group-item listnoback">
                                <b><?php echo $this->lang->line('blood_group'); ?></b> <a class="pull-right text-aqua"><?php echo $result['blood_group']; ?></a>
                            </li>
                            <li class="list-group-item listnoback">
                                <b><?php echo $this->lang->line('opd_no'); ?></b> <a class="pull-right text-aqua"><?php echo $visit_details['opd_no']; ?></a>
                            </li>
                            <li class="list-group-item listnoback">
                                <b><?php echo $this->lang->line('appointment') . " " . $this->lang->line('date'); ?></b> <a class="pull-right text-aqua"><?php echo date($this->customlib->getSchoolDateFormat(true, true), strtotime($visit_details['appointment_date'])) ?></a>

                            </li>
                            <li class="list-group-item listnoback">
                                <b><?php echo $this->lang->line('consultant'); ?></b> <a class="pull-right text-aqua"><?php echo $visit_details['name'] . "" . $visit_details["surname"]; ?></a>
                            </li>
                            <li class="list-group-item listnoback">
                                <b><?php echo $this->lang->line('symptoms'); ?></b> <a class="pull-right text-aqua"><?php echo $visit_details['symptoms']; ?></a>
                            </li>
                            <li class="list-group-item listnoback">
                                <b><?php echo $this->lang->line('case'); ?></b> <a class="pull-right text-aqua"><?php echo $visit_details['case_type']; ?></a>
                            </li>
                        </ul>
                    </div>

                </div>

            </div>

            <div class="col-md-9">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <?php if ($this->rbac->hasPrivilege('revisit', 'can_view')) { ?>
                            <li class="active"><a href="#activity" data-toggle="tab" aria-expanded="true"><i class="far fa-caret-square-down"></i> <?php echo $this->lang->line('visits'); ?></a></li>
                            <li><a href="#charges" data-toggle="tab" aria-expanded="true"><i class="far fa-calendar-check"></i> <?php echo $this->lang->line('charges'); ?></a></li>
                            <li><a href="#payment" data-toggle="tab" aria-expanded="true"><i class="far fa-calendar-check"></i> <?php echo $this->lang->line('payment'); ?></a></li>
                            <li><a href="#bill" data-toggle="tab" aria-expanded="true"><i class="far fa-calendar-check"></i> <?php echo $this->lang->line('bill'); ?></a></li>
                        <?php } if ($this->rbac->hasPrivilege('opd diagnosis', 'can_view')) { ?>

                            <li><a href="#diagnosis" data-toggle="tab" aria-expanded="true"><i class="fas fa-diagnoses"></i> <?php echo $this->lang->line('diagnosis'); ?></a></li>
                        <?php } ?>
                        <?php if ($this->rbac->hasPrivilege('opd timeline', 'can_view')) { ?>
                            <li><a href="#timeline" data-toggle="tab" aria-expanded="true"><i class="far fa-calendar-check"></i> <?php echo $this->lang->line('timeline'); ?></a></li>
                        <?php } ?>

                    </ul>
                    <div class="tab-content">
                        <?php if ($this->rbac->hasPrivilege('revisit', 'can_view')) { ?>
                            <div class="tab-pane active" id="activity">
                                <div class="impbtnview20">
                                    <?php if ($this->rbac->hasPrivilege('revisit', 'can_add')) { ?>

                                        <a href="#"  onclick="getRevisitRecord('<?php echo $result['id'] ?>')" class="btn btn-primary btn-sm"  data-toggle="modal" title=""><i class="fas fa-exchange-alt"></i> <?php echo $this->lang->line('revisit'); ?>
                                        </a>
                                    <?php } ?>
                                </div><!--./impbtnview20-->
                                <div class="download_label"><?php echo $result['patient_name'] . " " . $this->lang->line('opd') . " " . $this->lang->line('details'); ?></div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover example" cellspacing="0" width="100%">
                                        <thead>
                                        <th><?php echo $this->lang->line('opd_no'); ?></th>
                                        <th><?php echo $this->lang->line('appointment') . " " . $this->lang->line('date'); ?></th>
                                        <th><?php echo $this->lang->line('consultant'); ?></th>
                                        <th><?php echo $this->lang->line('refference'); ?></th>
                                        <th><?php echo $this->lang->line('symptoms'); ?></th>
                                        <th class="text-right"><?php echo $this->lang->line('action') ?></th>         
                                        </thead>
                                        <tbody>
                                            <?php
                                            $visit_charge = 0;
                                            if (!empty($opd_details)) {
                                                foreach ($opd_details as $key => $value) {
                                                    if ($value["id"] == $visit_id) {
                                                        $visit_charge += $value['amount'];
                                                        ?>  
                                                        <tr>
                                                            <td><?php echo $value['opd_no']; ?></td>
                                                            <td><?php echo date($this->customlib->getSchoolDateFormat(true, true), strtotime($value['appointment_date'])) ?></td>
                                                            <td><?php echo $value["name"] . " " . $value["surname"]; ?></td>
                                                            <td><?php echo $value['refference']; ?></td>
                                                            <td><?php echo $value['symptoms']; ?></td>
                                                            <td class="pull-right">
                                                                <?php
                                                                if ($this->rbac->hasPrivilege('prescription', 'can_add')) {
                                                                    if ($value["prescription"] == 'no') {
                                                                        ?>
                                                                        <a href="#" class="btn btn-default btn-xs" data-toggle="tooltip" title="<?php echo $this->lang->line('add_prescription'); ?>" onclick="getRecord_id('<?php echo $value["id"]; ?>')"><i class="fas fa-prescription"></i></a>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                                <?php
                                                                if ($value["prescription"] == 'yes') {

                                                                    $userdata = $this->customlib->getUserData();
                                                                    $prescription = "yes";
                                                                    $doctor_restriction = $this->session->userdata['hospitaladmin']['doctor_restriction'];
                                                                    if ($doctor_restriction == 'enabled') {
                                                                        if ($userdata["role_id"] == 3) {
                                                                            if ($userdata["id"] == $result["staff_id"]) {
                                                                                
                                                                            } else {
                                                                                $prescription = 'not_applicable';
                                                                            }
                                                                        }
                                                                    }
                                                                    ?>
                                                                    <a href="#" class="btn btn-default btn-xs" onclick="view_prescription('<?php echo $value["id"] ?>', '<?php echo $value["id"] ?>', '', '<?php echo $prescription ?>')"   data-toggle="tooltip" title="<?php echo $this->lang->line('view') . " " . $this->lang->line('prescription'); ?>">
                                                                        <i class="fas fa-file-prescription"></i>
                                                                    </a>
                                                                <?php } ?>
                                                                <a href="#"  class="btn btn-default btn-xs" data-toggle="tooltip" title="<?php echo $this->lang->line('show'); ?>" onclick="getRecord('<?php echo $result["id"]; ?>', '<?php echo $value["id"]; ?>')" >
                                                                    <i class="fa fa-reorder"></i>
                                                                </a>

                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                            }
                                            ?> 

                                            <?php
                                            $revisit_charge = 0;
                                            if (!empty($revisit_details)) {

                                                foreach ($revisit_details as $key => $revisit) {
                                                    $revisit_charge += $revisit['amount'];
                                                    ?>

                                                    <tr>
                                                        <td><?php echo $revisit['opd_no']; ?></td>
                                                        <td><?php echo date($this->customlib->getSchoolDateFormat(true, true), strtotime($revisit['appointment_date'])) ?></td>
                                                        <td><?php echo $revisit["name"] . " " . $revisit["surname"]; ?></td>
                                                        <td><?php echo $revisit['refference']; ?></td>
                                                        <td><?php echo $revisit['symptoms']; ?></td>
                                                        <td class="pull-right">
                                                            <?php
                                                            if ($this->rbac->hasPrivilege('prescription', 'can_add')) {
                                                                if ($revisit["prescription"] == 'no') {
                                                                    ?>
                                                                    <a href="#" class="btn btn-default btn-xs" data-toggle="tooltip" title="<?php echo $this->lang->line('add_prescription'); ?>" onclick="getRecord_id('<?php echo $revisit["id"]; ?>')"><i class="fas fa-prescription"></i></a>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                            <?php
                                                            if ($revisit["prescription"] == 'yes') {

                                                                $userdata = $this->customlib->getUserData();
                                                                $prescription = "yes";
                                                                $doctor_restriction = $this->session->userdata['hospitaladmin']['doctor_restriction'];
                                                                if ($doctor_restriction == 'enabled') {
                                                                    if ($userdata["role_id"] == 3) {
                                                                        if ($userdata["id"] == $result["staff_id"]) {
                                                                            
                                                                        } else {
                                                                            $prescription = 'not_applicable';
                                                                        }
                                                                    }
                                                                }
                                                                ?>
                                                                <a href="#" class="btn btn-default btn-xs" onclick="view_prescription('<?php echo $revisit["opd_id"] ?>', '<?php echo $revisit["opd_id"] ?>', '<?php echo $revisit["id"] ?>', '<?php echo $prescription ?>')"   data-toggle="tooltip" title="<?php echo $this->lang->line('view') . " " . $this->lang->line('prescription'); ?>">
                                                                    <i class="fas fa-file-prescription"></i>
                                                                </a>
                                                            <?php } ?>
                                                            <a href="#"  class="btn btn-default btn-xs" data-toggle="tooltip" title="<?php echo $this->lang->line('show'); ?>" onclick="getRecord('<?php echo $revisit["id"]; ?>', '<?php echo $revisit["id"]; ?>')" >
                                                                <i class="fa fa-reorder"></i>
                                                            </a>

                                                        </td>
                                                    </tr>
                                                <?php }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div> 
                            </div>
<?php } ?>

                        <!-- -->
                        <div class="tab-pane" id="diagnosis">
                            <div class="impbtnview20">
                                <?php
                                if ($this->rbac->hasPrivilege('opd diagnosis', 'can_add')) {
                                    $userdata = $this->customlib->getUserData();
                                    $diagnosis = "yes";
                                    $doctor_restriction = $this->session->userdata['hospitaladmin']['doctor_restriction'];
                                    if ($doctor_restriction == 'enabled') {
                                        if ($userdata["role_id"] == 3) {
                                            if ($userdata["id"] == $result["staff_id"]) {
                                                
                                            } else {
                                                $diagnosis = 'not_applicable';
                                            }
                                        }
                                    }
                                    if ($diagnosis == 'yes') {
                                        ?> 

                                        <a data-toggle="modal" onclick="holdModal('add_diagnosis')" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> <?php echo $this->lang->line('add') ?> <?php echo $this->lang->line('diagnosis'); ?></a>
                                    <?php }
                                }
                                ?>
                            </div>
                            <div class="download_label"><?php echo $result['patient_name'] . " " . $this->lang->line('opd') . " " . $this->lang->line('details'); ?></div>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover example">
                                    <thead>
                                    <th><?php echo $this->lang->line('report') . " " . $this->lang->line('type'); ?></th>
                                    <th><?php echo $this->lang->line('report') . " " . $this->lang->line('date'); ?></th>
                                    <th><?php echo $this->lang->line('description'); ?></th>
                                    <th class="text-right"><?php echo $this->lang->line('action'); ?></th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (!empty($diagnosis_detail)) {
                                            foreach ($diagnosis_detail as $diagnosis_key => $diagnosis_value) {

                                                //print_r($value);
                                                ?>  
                                                <tr>
                                                    <td><?php echo $diagnosis_value["report_type"] ?></td>
                                                    <td><?php echo date($this->customlib->getSchoolDateFormat(), strtotime($diagnosis_value['report_date'])) ?></td>
                                                    <td><?php echo $diagnosis_value["description"] ?></td>
                                                    <td class="text-right">
                                                        <?php if (!empty($diagnosis_value["document"])) { ?>
                                                            <a href="<?php echo base_url() . "admin/patient/report_download/" . $diagnosis_value["document"] ?>" data-toggle="tooltip" class="btn btn-default btn-xs" data-original-title="<?php echo $this->lang->line('download'); ?>" title="<?php echo $this->lang->line('download_'); ?>" ><i class="fa fa-download"></i></a>
        <?php } ?>
        <?php if ($this->rbac->hasPrivilege('opd diagnosis', 'can_delete')) { ?>
                                                            <a 
                                                                onclick="deleteOpdPatientDiagnosis('<?php echo $diagnosis_value['patient_id']; ?>', '<?php echo $diagnosis_value['id']; ?>')" class="btn btn-default btn-xs" data-toggle="tooltip" title=""  data-original-title="<?php echo $this->lang->line('delete'); ?>">
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
                                </table>
                            </div> 
                        </div>     

                        <!-- Charges -->
                        <div class="tab-pane" id="charges">
                            <div class="impbtnview20">

                                <a data-toggle="modal" onclick="holdModal('add_chargeModal')" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> <?php echo $this->lang->line('add') ?> <?php echo $this->lang->line('charges'); ?></a>
                            </div>
                            <div class="download_label"><?php echo $result['patient_name'] . " " . $this->lang->line('opd') . " " . $this->lang->line('details'); ?></div>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover example">
                                    <thead>
                                    <th><?php echo $this->lang->line('date'); ?></th>
                                    <th><?php echo $this->lang->line('charge') . " " . $this->lang->line('type'); ?></th>
                                    <th><?php echo $this->lang->line('charge') . " " . $this->lang->line('category'); ?></th>
                                    <th class="text-right"><?php echo $this->lang->line('standard') . " " . $this->lang->line('charge') . ' (' . $currency_symbol . ')'; ?> </th>
                                    <th class="text-right"><?php
                                        echo $this->lang->line('organisation') . " " . $this->lang->line('charge') . ' (' . $currency_symbol . ')';
                                        ;
                                        ?></th>
                                    <th class="text-right"><?php echo $this->lang->line('applied') . " " . $this->lang->line('charge') . ' (' . $currency_symbol . ')'; ?></th>
                                    <th class="text-right"><?php echo $this->lang->line('action') ?></th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $total = 0;
                                        if (!empty($charges_detail)) {
                                            foreach ($charges_detail as $charges_key => $charges_value) {

                                                $total += $charges_value["apply_charge"];
                                                //print_r($value);
                                                ?>  
                                                <tr>
                                                    <td><?php echo date($this->customlib->getSchoolDateFormat(), strtotime($charges_value['date'])); ?></td>
                                                    <td style="text-transform: capitalize;"><?php echo $charges_value["charge_type"] ?></td>
                                                    <td style="text-transform: capitalize;"><?php echo $charges_value["charge_category"] ?></td>
                                                    <td class="text-right"><?php echo $charges_value["standard_charge"] ?></td>
                                                    <td class="text-right"><?php echo $charges_value["org_charge"] ?></td>
                                                    <td class="text-right"><?php echo $charges_value["apply_charge"] ?></td>
                                                    <td class="text-right"> 
        <?php if ($this->rbac->hasPrivilege('charges', 'can_delete')) { ?>
                                                            <a onclick="delete_record('<?php echo base_url(); ?>admin/patient/deleteOpdPatientCharge/<?php echo $charges_value['patient_id']; ?>/<?php echo $charges_value['id']; ?>/<?php echo $visit_id; ?>', '<?php echo $this->lang->line('delete_message') ?>')" class="btn btn-default btn-xs" data-toggle="tooltip" title="" data-original-title="<?php echo $this->lang->line('delete'); ?>">
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

                                    <tr class="box box-solid total-bg">
                                        <td colspan='6' class="text-right"><?php echo $this->lang->line('total') . " : " . $currency_symbol . "" . $total ?> <input type="hidden" id="charge_total" name="charge_total" value="<?php echo $total ?>">
                                        </td><td></td>
                                    </tr>
                                </table>
                            </div> 
                        </div>    
                        <!-- -->  
                        <!--payment -->
                        <div class="tab-pane" id="payment">
                            <?php
                            if ($this->rbac->hasPrivilege('payment', 'can_add')) {
                                // if ($result['status'] != 'paid') {
                                ?>

                                <div class="impbtnview">
                                    <a href="#" class="btn btn-sm btn-primary dropdown-toggle" onclick="addpaymentModal()" data-toggle='modal'><i class="fa fa-plus"></i> <?php echo $this->lang->line('add') . " " . $this->lang->line('payment'); ?></a>
                                </div><!--./impbtnview-->
                                <?php
                                //}
                            }
                            ?>
                            <div class="download_label"><?php echo $this->lang->line('payment'); ?></div>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover example">
                                    <thead>
                                    <th><?php echo $this->lang->line('date'); ?></th>
                                    <th><?php echo $this->lang->line('note'); ?></th>
                                    <th><?php echo $this->lang->line('payment') . " " . $this->lang->line('mode'); ?></th>
                                    <th class="text-right"><?php echo $this->lang->line('paid') . " " . $this->lang->line('amount') . " (" . $currency_symbol . ")"; ?></th>

                                    <th class="text-right"><?php echo $this->lang->line('action') ?></th>
                                    </thead>
                                    <tbody>

                                        <?php
                                        if (!empty($payment_details)) {
                                            $total = 0;
                                            foreach ($payment_details as $payment) {
                                                if (!empty($payment['paid_amount'])) {
                                                    $total += $payment['paid_amount'];
                                                }
                                                ?>
                                                <tr>
                                                    <td><?php echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($payment['date'])); ?></td>
                                                    <td><?php echo $payment["note"] ?></td>
                                                    <td style="text-transform: capitalize;"><?php echo $payment["payment_mode"] ?></td>
                                                    <td class="text-right"><?php echo $payment["paid_amount"] ?></td>
                                                   <!--  <td><?php echo $payment["balance_amount"] ?></td> -->
                                                    <td class="text-right">
        <?php if (!empty($payment["document"])) { ?>
                                                            <a onclick="delte_record('<?php echo base_url(); ?>admin/payment/download/<?php echo $payment["document"]; ?>', '<?php echo $this->lang->line('delete_message'); ?>')"  class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('download'); ?>">
                                                                <i class="fa fa-download"></i>
                                                            </a>
        <?php } ?>
        <?php if ($this->rbac->hasPrivilege('payment', 'can_delete')) { ?>
                                                            <a href="<?php echo base_url(); ?>admin/patient/deleteIpdPatientPayment/<?php echo $payment['patient_id']; ?>/<?php echo $payment['id']; ?>" class="btn btn-default btn-xs" data-toggle="tooltip" title="" onclick="return confirm('<?php echo $this->lang->line('delete_conform') ?>');" data-original-title="<?php echo $this->lang->line('delete'); ?>">
                                                                <i class="fa fa-trash"></i>
                                                            </a>   
        <?php } ?>
                                                    </td>
                                                </tr>

    <?php } ?> 
                                            <tr class="box box-solid total-bg">

                                                <td></td>
                                                <td></td>
                                                <td></td> <td  class="text-right"><?php echo $this->lang->line('total') . " : " . $currency_symbol . "" . $total; ?>
                                                </td><td></td> 
                                            </tr>

                                        </tbody>

<?php } ?>

                                </table>
                            </div> 
                        </div> 
                        <!-- -->
                        <div class="tab-pane" id="timeline">
                            <div class="impbtnview20"> 
                                <?php if ($this->rbac->hasPrivilege('opd timeline', 'can_add')) { ?>
                                    <a data-toggle="modal" onclick="holdModal('myTimelineModal')" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>  <?php echo $this->lang->line('add') ?> <?php echo $this->lang->line('timeline'); ?></a> 
<?php } ?>
                            </div>
                            <div class="timeline-header no-border">

                                <div id="timeline_list">
                                    <?php
                                    if (empty($timeline_list)) {
                                        ?>
                                        <br/>
                                        <div class="alert alert-info"><?php echo $this->lang->line('no_record_found'); ?></div>
<?php } else {
    ?>
                                        <ul class="timeline timeline-inverse">

                                            <?php
                                            foreach ($timeline_list as $key => $value) {
                                                ?>      
                                                <li class="time-label">
                                                    <span class="bg-blue">    <?php
                                                echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($value['timeline_date']));
                                                ?></span>
                                                </li> 
                                                <li>
                                                    <i class="fa fa-list-alt bg-blue"></i>
                                                    <div class="timeline-item">
                                                        <?php if ($this->rbac->hasPrivilege('opd timeline', 'can_delete')) { ?>
                                                            <span class="time"><a class="defaults-c text-right" data-toggle="tooltip" title="" onclick="delete_timeline('<?php echo $value['id']; ?>')" data-original-title="<?php echo $this->lang->line('delete'); ?>"><i class="fa fa-trash"></i></a></span>
                                                        <?php } ?>
                                                        <?php if (!empty($value["document"])) { ?>
                                                            <span class="time"><a class="defaults-c text-right" data-toggle="tooltip" title="" href="<?php echo base_url() . "admin/timeline/download_patient_timeline/" . $value["id"] . "/" . $value["document"] ?>" data-original-title="<?php echo $this->lang->line('download'); ?>"><i class="fa fa-download"></i></a></span>
                                                            <?php } ?>
                                                        <h3 class="timeline-header text-aqua"> <?php echo $value['title']; ?> </h3>
                                                        <div class="timeline-body">
        <?php echo $value['description']; ?> 

                                                        </div>

                                                    </div>
                                                </li>
                                            <?php } ?> 
                                            <li><i class="fa fa-clock-o bg-gray"></i></li> 
<?php } ?>  

                                    </ul>
                                </div>




                            </div>

                        </div>  
                        <!-- -->
                        <div class="tab-pane" id="prescription">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover example">                       
                                    <thead>
                                    <th><?php echo $this->lang->line('opd') . " " . $this->lang->line('id'); ?></th>
                                    <th><?php echo $this->lang->line('appointment') . " " . $this->lang->line('date'); ?></th>
                                    <th><?php echo $this->lang->line('note'); ?></th>
                                    <th class="text-right"><?php echo $this->lang->line('action'); ?></th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (!empty($prescription_detail)) {
                                            foreach ($prescription_detail as $prescription_key => $prescription_value) {

                                                //print_r($value);
                                                ?>  
                                                <tr>
                                                    <td><?php echo $prescription_value["opd_id"] ?></td>
                                                    <td><?php echo $prescription_value["appointment_date"] ?></td>
                                                    <td><?php echo $prescription_value["note"] ?></td>
                                                    <th class="pull-right"><a href="#" data-toggle='tooltip' title="<?php echo $this->lang->line('test_report_detail'); ?>" onclick="view_prescription('<?php echo $prescription_value["id"] ?>', '<?php echo $prescription_value["opd_id"] ?>')"><i class="fa fa-reorder"></i></a></th>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?> 
                                    </tbody>
                                </table>
                            </div> 


                        </div>           
                        <div class="tab-pane" id="bill">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="box-title mt0"><?php echo $this->lang->line('charges'); ?></h4>
                                    <div class="table-responsive" style="border: 1px solid #dadada;border-radius: 2px; padding: 10px;">

                                        <table class="nobordertable table table-striped">
                                            <tr>
                                                <th width="16%" ><?php echo $this->lang->line('charges'); ?> </th>
                                                <th width="16%" ><?php echo $this->lang->line('category') ?></th>
                                                <th width="19%"><?php echo $this->lang->line('date') ?></th> 
                                                <th width="16%" class="pttright reborder"><?php echo $this->lang->line('amount') . ' (' . $currency_symbol . ')'; ?> </th>
                                            </tr>
                                            <?php
                                            $j = 0;
                                            $total = 0;
                                            if (!empty($charges_detail)) {
                                                foreach ($charges_detail as $key => $charge) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $charge["charge_type"]; ?></td> 
                                                        <td><?php echo $charge["charge_category"]; ?></td>
                                                        <td><?php echo date($this->customlib->getSchoolDateFormat(), strtotime($charge['created_at'])) ?></td>
                                                        <td class="pttright reborder"><?php echo $charge["apply_charge"]; ?></td>
                                                    </tr>


                                                    <?php
                                                    $total += $charge["apply_charge"];
                                                    ?>

                                                    <?php
                                                    $j++;
                                                }
                                            }
                                            ?>
                                            <tr class="box box-solid total-bg">
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td class="text-right"><?php echo $this->lang->line('total') . " : "; ?>  <?php echo $currency_symbol . $total ?></td>

                                            </tr>
                                        </table>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <h4 class="box-title mt0"><?php echo $this->lang->line('payment'); ?></h4>
                                    <div class="table-responsive" style="border: 1px solid #dadada;border-radius: 2px; padding: 10px;">

                                        <table class="nobordertable table table-striped">
                                            <tr>
                                                <th width="20%" class=""><?php echo $this->lang->line('payment') . " " . $this->lang->line('mode'); ?></th>
                                                <th width="16%" class=""><?php echo $this->lang->line('payment') . " " . $this->lang->line('date'); ?></th>
                                                <th width="16%" class="text-right"><?php echo $this->lang->line('paid') . " " . $this->lang->line('amount') . ' (' . $currency_symbol . ')'; ?> </th>
                                            </tr>

                                            <?php
                                            $k = 0;
                                            $total_paid = 0;
                                            if (!empty($payment_details)) {
                                                foreach ($payment_details as $key => $payment) {
                                                    ?>
                                                    <tr>
                                                        <td class="pttleft" style="text-transform: capitalize;"><?php echo $payment["payment_mode"]; ?></td>
                                                        <td class=""><?php echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($payment['date'])); ?></td>
                                                        <td class="text-right"><?php echo $payment["paid_amount"]; ?></td>

                                                    </tr>
                                                    <?php
                                                    $total_paid += $payment["paid_amount"];
                                                }
                                            }
                                            ?>
                                            <tr class="box box-solid total-bg">
                                                <td></td>
                                                <td></td>

                                                <td class="text-right"><?php echo $this->lang->line('total') . "  : " ?>  <?php echo $currency_symbol . $total_paid ?></td>

                                            </tr>
                                        </table>

                                    </div><!--./table-responsive-->
                                    <h4 class="box-title ptt10"><?php echo $this->lang->line('bill') . " " . $this->lang->line('summary'); ?></h4>                    
                                    <div class="table-responsive" style="border: 1px solid #dadada;border-radius: 2px; padding: 10px;">
                                        <table class="nobordertable table table-striped table-responsive">
                                            <form class="" method="post" id="add_bill" action="#"  enctype="multipart/form-data">
                                                <input type="hidden" name="status" id="status" value="<?php echo $result["is_active"] ?>">
<?php if ($paid_amount <= ($total + $visit_charge + $revisit_charge)) { ?> 
                                                    <tr>
                                                        <th><?php echo $this->lang->line('total') . " " . $this->lang->line('charges') . " (" . $currency_symbol . ")"; ?></th> 
                                                        <td class="text-right fontbold20"><?php echo $total + $visit_charge + $revisit_charge; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th><?php echo $this->lang->line('total') . " " . $this->lang->line('payment') . " (" . $currency_symbol . ")"; ?></th> 
                                                        <td class="text-right fontbold20">
                                                            <?php
                                                            if (!empty($paid_amount)) {
                                                                echo $paid_amount;
                                                            } else {
                                                                echo "0";
                                                            }
                                                            ?>                                                          <input type="hidden" value="<?php echo $total + $visit_charge + $revisit_charge - $paid_amount ?>" id="total_amount" name="total_amount" style="width: 30%" class="form-control">
                                                          <!--   <input type="hidden" value="<?php echo $result['bed'] ?>" id="bed_no" name="bed_no" style="width: 30%; float: right" class="form-control"> -->

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th><?php echo $this->lang->line('gross') . " " . $this->lang->line('total') . " (" . $this->lang->line('balance') . " " . $this->lang->line('amount') . ")" . " (" . $currency_symbol . ")"; ?></th> 
                                                        <td class="text-right fontbold20"><?php echo $total + $visit_charge + $revisit_charge - $paid_amount ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2"><input type="hidden" id="gross_total" value="<?php echo $total + $visit_charge + $revisit_charge - $paid_amount ?>" name="gross_total" style="width: 30%; float: right" class="form-control"></td>
                                                    </tr>
                                                    <tr>
                                                        <th><?php echo $this->lang->line('discount') . "(%)"; ?></th> 
                                                        <td class="text-right ipdbilltable">
                                                            <input type="text" id="discount_percent"  name="discount_percent" style="width: 30%; float: right" class="form-control">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th><?php echo $this->lang->line('discount') . " (" . $currency_symbol . ")"; ?></th> 
                                                        <td class="text-right ipdbilltable">
                                                            <input type="hidden" name="patient_id" value="<?php echo $result["id"] ?>">
                                                            <input type="hidden" name="opd_id" value="<?php echo $visit_id ?>">
                                                            <input type="text" id="discount" value="<?php
                                                            if (!empty($result["discount"])) {
                                                                echo $result["discount"];
                                                            } else {
                                                                echo "0";
                                                            }
                                                            ?>" name="discount" style="width: 30%; float: right" class="form-control"></td>
                                                    </tr>
                                                    <tr>
                                                        <th><?php echo $this->lang->line('any_other_charges') . " (" . $currency_symbol . ")"; ?></th> 
                                                        <td class="text-right ipdbilltable"><input type="text" id="other_charge" value="<?php
                                                            if (!empty($result["other_charge"])) {
                                                                echo $result["other_charge"];
                                                            } else {
                                                                echo "0";
                                                            }
                                                            ?>" name="other_charge" style="width: 30%; float: right" class="form-control"></td>
                                                    </tr>
                                                    <tr>
                                                        <th><?php echo $this->lang->line('tax') . "(%)"; ?></th> 
                                                        <td class="text-right ipdbilltable">
                                                            <input type="text" id="tax_percent" name="tax_percent" style="width: 30%; float: right" class="form-control">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th><?php echo $this->lang->line('tax') . " (" . $currency_symbol . ")"; ?></th> 
                                                        <td class="text-right ipdbilltable"><input type="text" name="tax" value="<?php
                                                            if (!empty($result["tax"])) {
                                                                echo $result["tax"];
                                                            } else {
                                                                echo "0";
                                                            }
                                                            ?>" id="tax" style="width: 30%; float: right" class="form-control"></td>
                                                    </tr>
                                                    <tr>
                                                        <th><?php echo $this->lang->line('net_payable') . " " . $this->lang->line('amount') . " (" . $currency_symbol . ")"; ?></th> 
                                                        <td class="text-right fontbold20">

                                                            <span id="net_amount_span" class="">0</span><input type="hidden" name="net_amount" value="<?php
                                                            if (!empty($result["net_amount"])) {
                                                                echo $result["net_amount"];
                                                            } else {
                                                                echo "0";
                                                            }
                                                            ?>" id="net_amount" style="width: 30%; float: right" class="form-control"></td>
                                                    </tr>
<?php } else { ?> 
                                                    <tr>
                                                        <th><?php echo $this->lang->line('total') . " " . $this->lang->line('charges') . " (" . $currency_symbol . ")"; ?></th> 
                                                        <td class="text-right fontbold20"><?php echo $total + $visit_charge + $revisit_charge; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th><?php echo $this->lang->line('total') . " " . $this->lang->line('payment') . " (" . $currency_symbol . ")"; ?></th> 
                                                        <td class="text-right fontbold20"><?php echo $paid_amount; ?>


                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th><?php echo $this->lang->line('gross') . " " . $this->lang->line('total') . " (" . $this->lang->line('balance') . " " . $this->lang->line('amount') . ")" . " (" . $currency_symbol . ")"; ?></th> 
                                                        <td class="text-right fontbold20"><?php echo $total - $paid_amount ?></td>
                                                    </tr>

                                                    <tr>
                                                        <th><?php echo $this->lang->line('discount') . " (" . $currency_symbol . ")"; ?></th> 
                                                        <td class="text-right fontbold20"><?php
                                                        if (!empty($paid_amount)) {
                                                            echo $result['discount'];
                                                        }
                                                        ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th><?php echo $this->lang->line('any_other_charges') . " (" . $currency_symbol . ")"; ?></th> 
                                                        <td class="text-right fontbold20"><?php echo $result['other_charge'] ?></td>
                                                    </tr>

                                                    <tr>
                                                        <th><?php echo $this->lang->line('tax') . " (" . $currency_symbol . ")"; ?></th> 
                                                        <td class="text-right fontbold20"><?php echo $result['tax'] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th><?php echo $this->lang->line('net_payable') . " " . $this->lang->line('amount') . " (" . $this->lang->line('paid') . ") (" . $currency_symbol . ")"; ?></th> 
                                                        <td class="text-right fontbold20">
    <?php if (!empty($paid_amount)) { ?> 
                                                        <?php echo $result['net_amount'] ?>
                                                    <?php } ?>
                                                        </td>
                                                    </tr>

                                        <?php } ?>

                                        </table>

                                        <?php
                                        if ($paid_amount <= ($total + $visit_charge + $revisit_charge)) {
                                            ?> 
                                            <?php if ($this->rbac->hasPrivilege('calculate_bill', 'can_view')) { ?>
                                                <input type="button" onclick="calculate()" id="cal_btn"  name="" value="<?php echo $this->lang->line('calculate'); ?>" class="btn btn-sm btn-info">
                                            <?php } if ($this->rbac->hasPrivilege('generate_bill_discharge_patient', 'can_view')) { ?>
                                                <input data-loading-text="<?php echo $this->lang->line('processing') ?>" type="submit" style="display:none" id="save_button" name="" value="<?php echo $this->lang->line('generate') ?>" class="btn btn-sm btn-info"/>
                                            <?php } ?>
                                            <a href="#" style="display:none" class="btn btn-sm btn-info" id="printBill" onclick="printBill('<?php echo $result["id"] ?>', '<?php echo $result["id"] ?>')"><?php echo $this->lang->line('print') . " " . $this->lang->line('bill') ?></a>
                                        <?php } else { ?>
                                            <span class="pull-right"><?php echo $this->lang->line('bill_generated_by') . " : " . $bill_info["name"] . " " . $bill_info["surname"] . " (" . $bill_info["employee_id"] . ")"; ?></span>
                                            <?php if ($this->rbac->hasPrivilege('revert_generated_bill', 'can_view')) { ?>
                                                       <!--  <input type="button" onclick="checkbed('<?php echo $result['id'] ?>', '<?php echo $result['bill_id'] ?>', '<?php echo $result['bed_id'] ?>')" id="revert_btn"  name="" value="<?php echo $this->lang->line('revert') . " " . $this->lang->line('generated') . " " . $this->lang->line('bill'); ?>" class="btn btn-sm btn-info"> -->
    <?php } ?>
                                            <a href="#"  class="btn btn-sm btn-info" onclick="printBill('<?php echo $result["id"] ?>', '<?php echo $result["id"] ?>')"><?php echo $this->lang->line('print') . " " . $this->lang->line('bill') ?></a>

<?php } ?> 

                                    </div>
                                </div>               

                            </div>
                        </div>
                        <!-- -->
                    </div>

                </div>


            </div>
    </section>
</div> 

<div class="modal fade" id="editModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-mid" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>

                <h4 class="box-title"> <?php echo $this->lang->line('edit') . " " . $this->lang->line('visit') . " " . $this->lang->line('information'); ?></h4> 
            </div>

            <div class="modal-body pt0 pb0">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 paddlr">
                        <form id="formedit"  accept-charset="utf-8"  enctype="multipart/form-data" method="post" class="ptt10">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>
<?php echo $this->lang->line('appointment') . " " . $this->lang->line('date'); ?></label><small class="req"> *</small> 
                                        <input type="text" name="appointment_date" class="form-control datetime" id="appointmentdate" />
                                    </div>

                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label ><?php echo $this->lang->line('case'); ?></label> 
                                        <input type="text" class="form-control" name="case" id="edit_case" />

                                    </div> 
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('casualty'); ?></label> 
                                        <select name="casualty" class="form-control" id="edit_casualty">
                                            <option value="<?php echo $this->lang->line('yes') ?>"><?php echo $this->lang->line('yes') ?></option>
                                            <option value="<?php echo $this->lang->line('no') ?>" selected><?php echo $this->lang->line('no') ?></option>
                                        </select>

                                    </div> 
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('old') . " " . $this->lang->line('patient'); ?></label> 
                                        <select name="old_patient" class="form-control" id="edit_oldpatient">
                                            <option value="<?php echo $this->lang->line('yes') ?>"><?php echo $this->lang->line('yes') ?></option>
                                            <option value="<?php echo $this->lang->line('no') ?>" selected><?php echo $this->lang->line('no') ?></option>
                                        </select>

                                    </div> 
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('height'); ?></label> 
                                        <input type="text" id="edit_height" name="height" class="form-control">
                                    </div> 
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('weight'); ?></label> 
                                        <input type="text" id="edit_weight" name="weight" class="form-control">
                                    </div> 
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('symptoms'); ?></label>
                                        <textarea class="form-control" id="edit_symptoms" name="symptoms" ></textarea> 
                                    </div> 
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('any_known_allergies'); ?></label> 
                                        <textarea class="form-control" id="edit_knownallergies" name="known_allergies"></textarea>
                                        <input type="hidden" name="opdid" id="edit_opdid">
                                    </div> 
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('bp'); ?></label> 
                                        <input type="text" name="bp" class="form-control" id="edit_bp" />  
                                    </div> 
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('organisation'); ?></label> 
                                        <select name="organisation" style="width:100%" class="form-control" id="edit_organisation">
                                            <option value=""><?php echo $this->lang->line('select') ?></option>
<?php foreach ($organisation as $orgkey => $orgvalue) {
    ?>
                                                <option value="<?php echo $orgvalue["id"]; ?>"><?php echo $orgvalue["organisation_name"] ?></option>   
<?php } ?>
                                        </select>    
                                    </div> 
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('consultant') . " " . $this->lang->line('doctor'); ?></label><small class="req"> *</small> 
                                        <select  onchange="get_Charges(this.value)" name="consultant_doctor" <?php
                                            if ($disable_option == true) {
                                                echo "disabled";
                                            }
                                            ?> style="width:100%" class="form-control select2" id="edit_consdoctor">
                                            <option value=""><?php echo $this->lang->line('select') ?></option>

<?php foreach ($doctors as $dkey => $dvvalue) {
    ?>
                                                <option value="<?php echo $dvvalue["id"] ?>"><?php echo $dvvalue["name"] . " " . $dvvalue["surname"] ?></option>
<?php } ?>
                                        </select>    


                                    </div> 
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('standard') . " " . $this->lang->line('charge') . " (" . $currency_symbol . ")" ?></label>
                                        <input type="text" readonly name="standard_charge" id="standard_charge" class="form-control" value="<?php echo set_value('standard_charge'); ?>"> 

                                        <span class="text-danger"><?php echo form_error('standard_charge'); ?></span>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('amount') . " (" . $currency_symbol . ")"; ?></label> 
                                        <input type="text" name="amount" class="form-control" id="edit_amount" />
                                        <input type="hidden" name="patientid" class="form-control" id="patientid" />
                                    </div> 
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('refference'); ?></label> 
                                        <input type="text" name="refference" class="form-control" id="edit_refference" />  
                                    </div> 
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('payment') . " " . $this->lang->line('mode'); ?></label> 
                                        <select id="edit_paymentmode" name="payment_mode" class="form-control">

                                                    <?php foreach ($payment_mode as $pkey => $pvalue) {
                                                        ?>
                                                <option value="<?php echo $pkey ?>" <?php
                                                    if ($pkey == 'Cash') {
                                                        echo "selected";
                                                    }
                                                    ?>><?php echo $pvalue; ?></option>  
<?php } ?>
                                        </select>
                                        <!--input type="text" name="payment_mode" class="form-control" id="edit_paymentmode" /-->  
                                    </div> 
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('note'); ?></label> 
                                        <textarea class="form-control"  id="revisit_note" name="revisit_note"></textarea>

                                    </div> 
                                </div>
                            </div>


                            <button type="submit" id="formeditbtn" data-loading-text="<?php echo $this->lang->line('processing') ?>" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>

                        </form>
                    </div>
                </div>
            </div>    

        </div></div> </div>

<!-- Add Charges -->
<div class="modal fade" id="add_chargeModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="box-title"><?php echo $this->lang->line('add') . " " . $this->lang->line('charges') ?></h4> 
            </div>
            <div class="modal-body pt0 pb0">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 paddlr">
                        <form id="add_charges" accept-charset="utf-8"  method="post" class="ptt10" >
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('date'); ?></label> <small class="req"> *</small> 
                                        <input id="charge_date" name="date" placeholder="" type="text" class="form-control date" />
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('charge') . " " . $this->lang->line('type') ?></label><small class="req"> *</small> 

                                        <select name="charge_type" onchange="getcharge_category(this.value)" class="form-control">
                                            <option value="">Select</option>
<?php foreach ($charge_type as $key => $value) {
    ?>
                                                <option value="<?php echo $key ?>">
    <?php echo $value ?>
                                                </option>
<?php } ?>
                                        </select>
                                        <span class="text-danger"><?php echo form_error('charge_type'); ?></span>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('charge') . " " . $this->lang->line('category') ?></label><small class="req"> *</small> 

                                        <select name="charge_category" id="charge_category" style="width: 100%" class="form-control select2" onchange="getchargecode(this.value)">
                                            <option value="">Select</option>
                                        </select>
                                        <span class="text-danger"><?php echo form_error('charge_category'); ?></span>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('code') ?></label><small class="req"> *</small> 

                                        <select name="code" id="code" style="width: 100%" class="form-control select2" onchange="get_Charges(this.value, '<?php echo $result['organisation'] ?>')">
                                            <option value="">Select</option>
                                        </select>
                                        <span class="text-danger"><?php echo form_error('code'); ?></span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('standard') . " " . $this->lang->line('charge') . " (" . $currency_symbol . ")" ?></label>
                                        <input type="text" readonly name="standard_charge" id="addstandard_charge" class="form-control" value="<?php echo set_value('standard_charge'); ?>"> 
                                        <input type="hidden" name="patient_id" value="<?php echo $result["id"] ?>">
                                        <input type="hidden" name="charge_id" id="charge_id">
                                        <input type="hidden" name="org_id" id="org_id">
                                        <input type="hidden" name="opd_id" value="<?php echo $visit_details['id'] ?>" >
                                        <span class="text-danger"><?php echo form_error('standard_charge'); ?></span>
                                    </div>
                                </div> 
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('organisation') . " " . $this->lang->line('charge') . " (" . $currency_symbol . ")" ?></label>
                                        <input type="text" readonly name="schedule_charge" id="schedule_charge" placeholder="" class="form-control" value="<?php echo set_value('schedule_charge'); ?>">    
                                        <span class="text-danger"><?php echo form_error('schedule_charge'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('applied') . " " . $this->lang->line('charge') . " (" . $currency_symbol . ")" ?></label><small class="req"> *</small><input type="text" name="apply_charge" id="apply_charge" class="form-control">    
                                        <span class="text-danger"><?php echo form_error('apply_charge'); ?></span>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" id="add_chargesbtn" data-loading-text="<?php echo $this->lang->line('processing') ?>" class="btn btn-info pull-right"><?php echo $this->lang->line('save') ?></button>
                        </form>
                    </div>
                </div>
            </div>    
        </div>
    </div> 
</div>
<!-- -->
<!-- Add Diagnosis -->
<div class="modal fade" id="add_diagnosis" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-mid" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="box-title"> <?php echo $this->lang->line('add') . " " . $this->lang->line('diagnosis'); ?></h4> 
            </div>

            <div class="modal-body pt0 pb0">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 paddlr">
                        <form id="form_diagnosis"   accept-charset="utf-8"  enctype="multipart/form-data" method="post" class="ptt10">
                            <div class="row">


                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>
<?php echo $this->lang->line('report') . " " . $this->lang->line('type'); ?></label><small class="req"> *</small> 
                                        <input type="text" name="report_type" class="form-control" id="report_type" />
                                        <input type="hidden" value="<?php echo $id ?>" name="patient" class="form-control" id="patient" />    


                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>
<?php echo $this->lang->line('report') . " " . $this->lang->line('date'); ?></label> 
                                        <input type="text" name="report_date" class="form-control date" id="report_date"/>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('document'); ?></label> <input type="file" class="form-control filestyle" name="report_document" id="report_document" />
                                    </div> 
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('description'); ?></label> 
                                        <textarea name="description" class="form-control" id="description"></textarea>

                                    </div> 
                                </div>
                            </div>
                            <div class="box-footer">
                                <div class="pull-right">
                                    <button type="submit" id="form_diagnosisbtn" data-loading-text="<?php echo $this->lang->line('processing') ?>" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                                    </form>
                                </div>
                            </div>
                    </div>
                </div>
            </div>    

        </div></div> </div>

<!-- -->
<!-- Timeline -->
<div class="modal fade" id="myTimelineModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-mid" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="box-title"> <?php echo $this->lang->line('add') . " " . $this->lang->line('timeline'); ?></h4> 
            </div>

            <div class="modal-body pt0 pb0">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 paddlr">
                        <form id="add_timeline"   accept-charset="utf-8"  enctype="multipart/form-data" method="post" class="ptt10">
                            <div class="row">


                                <div class=" col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('title'); ?></label><small class="req"> *</small>
                                        <input type="hidden" name="patient_id" id="patient_id" value="<?php echo $id ?>">
                                        <input id="timeline_title" name="timeline_title" placeholder="" type="text" class="form-control"  />
                                        <span class="text-danger"><?php echo form_error('timeline_title'); ?></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('date'); ?></label><small class="req"> *</small>
                                        <input id="timeline_date" name="timeline_date" value="<?php echo set_value('timeline_date', date($this->customlib->getSchoolDateFormat())); ?>" placeholder="" type="text" class="form-control date"  />
                                        <span class="text-danger"><?php echo form_error('timeline_date'); ?></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('description'); ?></label>
                                        <textarea id="timeline_desc" name="timeline_desc" placeholder=""  class="form-control"></textarea>
                                        <span class="text-danger"><?php echo form_error('description'); ?></span>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('attach_document'); ?></label>
                                        <div class="" style="margin-top:-5px; border:0; outline:none;"><input id="timeline_doc_id" name="timeline_doc" placeholder="" type="file"  class="filestyle form-control" data-height="40"  value="<?php echo set_value('timeline_doc'); ?>" />
                                            <span class="text-danger"><?php echo form_error('timeline_doc'); ?></span></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('visible'); ?></label>
                                        <input id="visible_check" checked="checked" name="visible_check" value="yes" placeholder="" type="checkbox"   />

                                    </div>
                                </div>


                            </div>


                            <div class="box-footer">
                                <div class="pull-right">
                                    <button type="submit" data-loading-text="<?php echo $this->lang->line('processing') ?>" id="add_timelinebtn" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                                    </form>
                                </div>
                            </div>
                    </div>
                </div>
            </div>    

        </div></div> </div>

<!-- -->
<div class="modal fade" id="addBillModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-mid" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="box-title"> <?php echo $this->lang->line('add') . " " . $this->lang->line('bill'); ?></h4> 
            </div>

            <div class="modal-body pt0 pb0">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 paddlr">
                        <form id="add_billform"   accept-charset="utf-8"  enctype="multipart/form-data" method="post" class="ptt10">
                            <div class="row">


                                <div class=" col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('total') . " " . $this->lang->line('charges'); ?></label><small class="req"> *</small>
                                        <input type="hidden" name="patient_id" id="patient_id" value="<?php echo $id ?>">
                                        <input  name="total_charges" id="totalopdcharges" placeholder="" type="text" class="form-control"  />
                                        <span class="text-danger"><?php echo form_error('total_amount'); ?></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('total') . " " . $this->lang->line('payment'); ?></label><small class="req"> *</small>
                                        <input  name="total_payment" id="total_payment"  placeholder="" type="text" class="form-control "  />
                                        <input  name="opdidhide" id="opdidhide" value="" placeholder="" type="hidden" class="form-control "  />
                                        <span class="text-danger"><?php echo form_error('total_payment'); ?></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('gross') . " " . $this->lang->line('total'); ?></label>
                                        <input type="text" name="gross_total" id="gross_total" placeholder=""  class="form-control"/>
                                        <span class="text-danger"><?php echo form_error('gross_total'); ?></span>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('discount'); ?></label>
                                        <div class="" style="margin-top:-5px; border:0; outline:none;"><input  name="discount" id="discount" placeholder="" type="text"  class="form-control"   />
                                            <span class="text-danger"><?php echo form_error('discount'); ?></span></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('other') . " " . $this->lang->line('charge'); ?></label>
                                        <input   name="other_charge" id="other_charge" placeholder="" type="text" class="form-control"  />

                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('tax'); ?></label>
                                        <input   name="tax" id="tax"  placeholder="" type="text" class="form-control"  />

                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('net_amount'); ?></label>
                                        <input   name="net_amount" id="net_amount"   placeholder="" type="text" class="form-control"  />

                                    </div>
                                </div>


                            </div>


                            <div class="box-footer">
                                <div class="pull-right">
                                    <button type="button" onclick="calculate()"   class="btn btn-info pull-right"><?php echo $this->lang->line('calculate'); ?></button>
                                    <button type="submit" data-loading-text="<?php echo $this->lang->line('processing') ?>" id="add_billbtn" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                                    </form>
                                </div>
                            </div>
                    </div>
                </div>
            </div>    

        </div></div> </div>

<!-- -->
<div class="modal fade" id="edit_prescription"  role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="box-title"> <?php echo $this->lang->line('edit') . " " . $this->lang->line('prescription'); ?></h4> 
            </div>

            <div class="modal-body pt0 pb0" id="editdetails_prescription">
            </div>    

        </div></div> </div>

<!-- -->
<!-- Add Prescription -->
<div class="modal fade" id="add_prescription" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="box-title"> <?php echo $this->lang->line('add') . " " . $this->lang->line('prescription'); ?></h4> 
            </div>

            <div class="modal-body pt0 pb0">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 paddlr">
                        <form id="form_prescription" accept-charset="utf-8"  enctype="multipart/form-data" method="post" class="ptt10">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('header_note'); ?></label> 
                                        <textarea style="height:50px"  name="header_note" class="form-control" id="compose-textareanew" ></textarea>
                                    </div> 
                                    <hr/>
                                </div>

                                <table style="width: 100%" id="tableID">
                                    <tr id="row0">
                                        <td>           
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label>
<?php echo $this->lang->line('medicine') . "" . $this->lang->line("category"); ?></label> <small class="req"> *</small>
                                                    <select class="form-control select2" style="width: 100%" name='medicine_cat[]' onchange="getMedicineName(0)"  id="medicine_cat0">
                                                        <option value="<?php echo set_value('medicine_category_id'); ?>"><?php echo $this->lang->line('select') ?>
                                                        </option>
<?php foreach ($medicineCategory as $dkey => $dvalue) {
    ?>
                                                            <option value="<?php echo $dvalue["id"]; ?>"><?php echo $dvalue["medicine_category"] ?>
                                                            </option>   
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>                     
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label>
<?php echo $this->lang->line('medicine'); ?></label> <small class="req"> *</small>
<!--                                                     <input type="text" name="medicine[]" class="form-control" id="report_type" /> -->
                                                    <select class="form-control select2" style="width: 100%"  name="medicine[]" id="search-query0">
                                                        <option value="l"><?php echo $this->lang->line('select') ?></option>
                                                    </select>

                                                    <div id="suggesstion-box0"></div>

                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label><?php echo $this->lang->line('dosage'); ?></label> 
                                                   <!--  <input type="text" class="form-control" name="dosage[]" id="report_document" /> -->
                                                    <select class="form-control" name="dosage[]" id="dosagelist0">
                                                        <option value=""><?php echo $this->lang->line('select') ?></option>
<?php foreach ($dosage as $key => $dosagevalue) {
    ?>
                                                            <option value="<?php echo $dosagevalue['dosage'] ?>"><?php echo $dosagevalue['dosage'] ?></option>
<?php } ?>
                                                    </select>
                                                </div> 
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label><?php echo $this->lang->line('instruction'); ?></label> 
                                                    <textarea name="instruction[]" style="height: 28px;" class="form-control" ></textarea>
                                                </div> 
                                            </div>
                                        </td>
                                        <td><button type="button" onclick="add_more()" style="color: #2196f3" class="modaltableclosebtn"><i class="fa fa-plus"></i></button></a></td>
                                    </tr>
                                </table>
                                <div class="add_row">

                                </div>
                                <!--div class="col-sm-12">
                                   <a href="#" class="pull-right" onclick="add_more()"><?php //echo $this->lang->line('add_more');    ?></a>
                                </div-->




                                <input type="hidden" id="prescription_id" name="opd_no">
                                <input type="hidden" id="visit_id" name="visit_id">

                                <hr/>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('footer_note'); ?></label> 
                                        <textarea style="height:50px" rows="1" name="footer_note" class="form-control" id="compose-textareas"></textarea>
                                    </div> 
                                </div>
                            </div>
                            <div class="box-footer">
                                <div class="pull-right">
                                    <button type="submit" id="form_prescriptionbtn" data-loading-text="<?php echo $this->lang->line('processing') ?>" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                                    </form>
                                </div>
                            </div>
                    </div>
                </div>
            </div>    

        </div></div> </div>

<!-- -->
<div class="modal fade" id="viewModal" role="dialog">
    <div class="modal-dialog modal-dialog2 modal-lg" role="document">
        <div class="modal-content ">
            <div class="modal-header">

                <button type="button" data-toggle="tooltip" title="" data-original-title="<?php echo $this->lang->line('close'); ?>" class="close" data-dismiss="modal">&times;</button>
                <div class="modalicon"> 
                    <div id='edit_delete'>
                        <?php if ($this->rbac->hasPrivilege('revisit', 'can_edit')) { ?>

                            <a href="#"  data-toggle="tooltip" title="<?php echo $this->lang->line('edit'); ?>" ><i class="fa fa-pencil"></i></a>
                            <?php
                        }

                        if ($this->rbac->hasPrivilege('revisit', 'can_delete')) {
                            ?>
                            <a href="#" data-toggle="tooltip" title="" data-original-title="<?php echo $this->lang->line('delete'); ?>"><i class="fa fa-trash"></i></a>
<?php } ?>
                    </div>
                </div>
                <h4 class="box-title"> <?php echo $this->lang->line('visit') . " " . $this->lang->line('information'); ?></h4> 
            </div>

            <div class="modal-body">
                <div class="row">

                    <form id="" accept-charset="utf-8"  enctype="multipart/form-data" method="post" >
                        <div class="col-lg-12 col-md-12 col-sm-12 table-responsive">
                            <table class="table mb0 table-striped table-bordered examples">
                                <tr>
                                    <th width="15%"><?php echo $this->lang->line('opd_no'); ?></th>
                                    <td width="35%"><span id="opd_no"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <th width="15%"><?php echo $this->lang->line('patient') . " " . $this->lang->line('name'); ?></th>
                                    <td width="35%"><span id="patient_name"></span>
                                    </td>
                                    <th width="15%"><?php echo $this->lang->line('patient') . " " . $this->lang->line('id'); ?></th>
                                    <td width="35%"><span id='patients_id'></span></td>
                                </tr>
                                <tr>
                                    <th width="15%"><?php echo $this->lang->line('guardian_name'); ?></th>
                                    <td width="35%"><span id='guardian_name'></span></td>
                                    <th width="15%"><?php echo $this->lang->line('gender'); ?></th>
                                    <td width="35%"><span id='gen'></span></td>
                                </tr>
                                <tr>
                                    <th width="15%"><?php echo $this->lang->line('marital_status'); ?></th>
                                    <td width="35%"><span id="marital_status"></span>
                                    </td>
                                    <th width="15%"><?php echo $this->lang->line('phone'); ?></th>
                                    <td width="35%"><span id="contact"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <th width="15%"><?php echo $this->lang->line('email'); ?></th>
                                    <td width="35%"><span id='email' style="text-transform: none"></span></td>
                                    <th width="15%"><?php echo $this->lang->line('address'); ?></th>
                                    <td width="35%"><span id='patient_address'></span></td>
                                </tr>
                                <tr>  
                                    <th width="15%"><?php echo $this->lang->line('age'); ?></th>
                                    <td width="35%"><span id="age"></span>
                                    </td>
                                    <th width="15%"><?php echo $this->lang->line('blood_group'); ?></th>
                                    <td width="35%"><span id="blood_group"></span>
                                    </td>

                                </tr>
                                <tr>
                                    <th width="15%"><?php echo $this->lang->line('height'); ?></th>
                                    <td width="35%"><span id='height'></span></td>
                                    <th width="15%"><?php echo $this->lang->line('weight'); ?></th>
                                    <td width="35%"><span id="weight"></span>
                                    </td>

                                </tr>

                                <tr>
                                    <th width="15%"><?php echo $this->lang->line('bp'); ?></th>
                                    <td width="35%"><span id='patient_bp'></span></td>
                                    <th width="15%"><?php echo $this->lang->line('symptoms'); ?></th>
                                    <td width="35%"><span id='symptoms'></span></td>
                                </tr>
                                <tr>
                                    <th width="15%"><?php echo $this->lang->line('known_allergies'); ?></th>
                                    <td width="35%"><span id="known_allergies"></span>
                                    </td>
                                    <th width="15%"><?php echo $this->lang->line('appointment') . " " . $this->lang->line('date'); ?></th>
                                    <td width="35%"><span id="appointment_date"></span>
                                    </td> 
                                </tr>
                                <tr>
                                    <th width="15%"><?php echo $this->lang->line('case'); ?></th>
                                    <td width="35%"><span id='case'></span></td>
                                    <th width="15%"><?php echo $this->lang->line('casualty'); ?></th>
                                    <td width="35%"><span id="casualty"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <th width="15%"><?php echo $this->lang->line('old') . " " . $this->lang->line('patient'); ?></th>
                                    <td width="35%"><span id='old_patient'></span></td>
                                    <th width="15%"><?php echo $this->lang->line('organisation'); ?></th>
                                    <td width="35%"><span id="organisation"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <th width="15%"><?php echo $this->lang->line('refference'); ?></th>
                                    <td width="35%"><span id="refference"></span>
                                    </td>
                                    <th width="15%"><?php echo $this->lang->line('consultant') . " " . $this->lang->line('doctor'); ?></th>
                                    <td width="35%"><span id='doc'></span></td>
                                </tr>

                                <tr>
                                    <th width="15%"><?php echo $this->lang->line('amount'); ?></th>
                                    <td width="35%"><?php echo $currency_symbol ?><span id='amount'></span></td>

                                    <th width="15%"><?php echo $this->lang->line('payment') . " " . $this->lang->line('mode'); ?></th>
                                    <td width="35%"><span id='payment_mode' style="text-transform: capitalize;"></span></td>

                                </tr>
                                <tr>
                                    <th width="15%"><?php echo $this->lang->line('note'); ?></th>
                                    <td width="35%"><span id='note'></span></td>


                                </tr>

                            </table>

                        </div>
                    </form>
                </div>
            </div>    

        </div></div> </div>

<!--bill -->

<!-- bill end-->
<!-- -->
<div class="modal fade" id="prescriptionview" tabindex="-1" role="dialog" aria-labelledby="follow_up">   
    <div class="modal-dialog modal-mid modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close"  data-dismiss="modal">&times;</button>
                <div class="modalicon"> 
                    <div id='edit_deleteprescription'>
                   <!--      <a href="#" data-target="#edit_prescription" data-toggle="modal" ><i class="fa fa-pencil"></i></a>

                        <a href="#" data-toggle="tooltip" title="" data-original-title="<?php echo $this->lang->line('delete'); ?>"><i class="fa fa-trash"></i></a> -->
                    </div>
                </div>
                <h4 class="box-title"><?php echo $this->lang->line('prescription'); ?></h4>
            </div>
            <div class="modal-body pt0 pb0" id="getdetails_prescription">

            </div>
        </div>
    </div>
</div>

<!-- -->
<div class="modal fade" id="myModaledit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="box-title"> <?php echo $this->lang->line('patient') . " " . $this->lang->line('information'); ?></h4> 
            </div>
            <div class="modal-body pt0 pb0">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 paddlr">
                        <form id="formeditrecord" accept-charset="utf-8" enctype="multipart/form-data" method="post"  class="ptt10">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('name'); ?></label><small class="req"> *</small> 
                                        <input id="patient_names" name="name" placeholder="" type="text" class="form-control"  value="<?php echo set_value('name'); ?>" />
                                        <input type="hidden" id="updateids" name="updateid">
                                        <input type="hidden" id="opdid" name="opdid">
                                        <span class="text-danger"><?php echo form_error('name'); ?></span>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('guardian_name'); ?></label>
                                        <input type="text" id="guardian_names" name="guardian_name" value="<?php echo set_value('guardian_name'); ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('gender'); ?></label>
                                        <select class="form-control" id="genders" name="gender">
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
                                        <select name="marital_status" id="marital_statuss" class="form-control">
                                            <option value=""><?php echo $this->lang->line('select') ?></option>
<?php foreach ($marital_status as $mkey => $mvalue) {
    ?>
                                                <option value="<?php echo $mkey ?>"><?php echo $mvalue; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="exampleInputFile">
<?php echo $this->lang->line('patient') . " " . $this->lang->line('photo'); ?></label>
                                        <div><input class="filestyle form-control" type='file' name='file' id="file" size='20' />
                                            <input type="hidden" name="patient_photo" id="patient_photos">
                                        </div>
                                        <span class="text-danger"><?php echo form_error('file'); ?></span>
                                    </div>
                                </div>  
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('email'); ?></label>
                                        <input type="text" id="emails" value="<?php echo set_value('email'); ?>" name="email" class="form-control">
                                    </div>
                                </div> 
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="pwd"><?php echo $this->lang->line('phone'); ?></label>
                                        <input id="contacts" autocomplete="off" name="contact" placeholder="" type="text" class="form-control"  value="<?php echo set_value('contact'); ?>" />
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label> <?php echo $this->lang->line('blood_group'); ?></label>
                                        <select class="form-control" id="blood_groups" name="blood_group">
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
                                            <input type="text" placeholder="<?php echo $this->lang->line('age'); ?>" id="ages" name="age" value="<?php echo set_value('age'); ?>" class="form-control" style="width: 40%; float: left;">
                                            <input type="text" placeholder="<?php echo $this->lang->line('month'); ?>" id="months" name="month" value="<?php echo set_value('month'); ?>" class="form-control" style="width: 56%;float: left; margin-left: 5px;">
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('address'); ?></label>
                                        <textarea class="form-control" name="address" id="address"></textarea>

                                    </div>
                                </div> 
                            </div><!--./row-->   

                    </div><!--./col-md-12-->       
                </div><!--./row--> 
            </div>
            <div class="box-footer">
                <div class="pull-right">
                    <button type="submit" data-loading-text="<?php echo $this->lang->line('processing') ?>" id="formeditrecordbtn" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                    </form>    
                </div>
            </div>
        </div>
    </div>    
</div>

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
                        <form id="formrevisit"   accept-charset="utf-8"  enctype="multipart/form-data" method="post" >
                            <div class="row row-eq">
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                    <div class="row ptt10">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('patient') . " " . $this->lang->line('id'); ?></label> 
                                                <input id="revisit_id" disabled name="patient_id" placeholder="" type="text" class="form-control"  value="<?php echo set_value('roll_no'); ?>" />
                                                <span class="text-danger"><?php echo form_error('patient_id'); ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('name'); ?></label><small class="req"> *</small> 
                                                <input id="revisit_name" name="name" placeholder="" type="text" class="form-control"  value="<?php echo set_value('name'); ?>" />
                                                <input type="hidden" name="id" id="pid">
                                                <input type="hidden" name="opd_no" id="revisit_opd_no">
                                                <input type="hidden" name="opd_id" id="revisit_opd_id">
                                                <span class="text-danger"><?php echo form_error('name'); ?></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('guardian_name'); ?></label>
                                                <input type="text" name="guardian_name" value="<?php echo set_value('guardian_name'); ?>" class="form-control" id="revisit_guardian">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label> <?php echo $this->lang->line('gender'); ?></label>
                                                <select class="form-control" name="gender" id="revisit_gender">
                                                    <option value=""><?php echo $this->lang->line('select'); ?></option>
                                                    <?php
                                                    foreach ($genderList as $key => $value) {
                                                        ?>
                                                        <option value="<?php echo $key; ?>" <?php if (set_value('gender') == $key) echo "selected"; ?>><?php echo $value; ?></option>
    <?php
}
?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="pwd"><?php echo $this->lang->line('marital_status'); ?></label>
                                                <select name="marital_status" class="form-control" id="revisit_marital_status">
                                                    <option value=""><?php echo $this->lang->line('select') ?></option>
<?php foreach ($marital_status as $mkey => $mvalue) {
    ?>
                                                        <option value="<?php echo $mkey ?>"><?php echo $mvalue; ?></option>
<?php } ?>
                                                </select>
                                            </div>
                                        </div> 
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="pwd"><?php echo $this->lang->line('phone'); ?></label>
                                                <input id="revisit_contact" autocomplete="off" name="contact" placeholder="" type="text" class="form-control"  value="<?php echo set_value('contact'); ?>" />
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('email'); ?></label>
                                                <input type="text" id="revisit_email" value="<?php echo set_value('email'); ?>" name="email" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="form-group">
                                                <label for="email"><?php echo $this->lang->line('address'); ?></label> 
                                                <input type="text" id="revisit_address" value="<?php echo set_value('address'); ?>" name="address" class="form-control">
                                            </div> 
                                        </div> 
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('age'); ?></label>
                                                <div style="clear: both;overflow: hidden;">
                                                    <input type="text" placeholder="Year" name="age" value="<?php echo set_value('age'); ?>" 
                                                           id="revisit_age" class="form-control" style="width: 43%; float: left;">
                                                    <input type="text" placeholder="Month" name="month" id="revisit_month" value="<?php echo set_value('month'); ?>" class="form-control" style="width: 53%;float: left; margin-left: 4px;">
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('blood_group'); ?></label>
                                                <select name="blood_group" id="revisit_blood_group" class="form-control" >
                                                    <option value=""><?php echo $this->lang->line('select') ?></option>
                                                    <?php
                                                    foreach ($bloodgroup as $key => $value) {
                                                        ?>
                                                        <option value="<?php echo $value; ?>" <?php if (set_value('blood_group') == $key) echo "selected"; ?>><?php echo $value; ?></option>
    <?php
}
?>
                                                </select>   
                                            </div>
                                        </div>
                                        <div class="col-sm-2 col-xs-4">
                                            <div class="form-group">
                                                <label for="pwd"><?php echo $this->lang->line('height'); ?></label> 
                                                <input name="height" id="revisit_height" type="text" class="form-control"  value="<?php echo set_value('height'); ?>" />
                                            </div>
                                        </div>
                                        <div class="col-sm-2 col-xs-4">
                                            <div class="form-group">
                                                <label for="pwd"><?php echo $this->lang->line('weight'); ?></label> 
                                                <input name="weight" id="revisit_weight" type="text" class="form-control"  value="<?php echo set_value('weight'); ?>" />
                                            </div>
                                        </div>
                                        <div class="col-sm-2 col-xs-4">
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
                                                <div><select class="form-control" name='organisation_name' id="revisit_organisation" >
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
                                                        <?php echo $this->lang->line('consultant') . " " . $this->lang->line('doctor'); ?></label>
                                                <div><select  onchange="get_Chargesvisit(this.value)" class="form-control" style="width: 100%"  <?php
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
                                                </div>
                                                <span class="text-danger"><?php echo form_error('refference'); ?></span>
                                            </div>
                                        </div> 

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('standard') . " " . $this->lang->line('charge') . " (" . $currency_symbol . ")" ?></label>
                                                <input type="text" readonly name="standard_charge" id="standard_chargevisit" class="form-control" value="<?php echo set_value('standard_charge'); ?>"> 

                                                <span class="text-danger"><?php echo form_error('standard_charge'); ?></span>
                                            </div>
                                        </div> 

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="pwd"><?php echo $this->lang->line('amount'); ?> <?php echo '(' . $currency_symbol . ')'; ?></label><small class="req"> *</small> 
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
                                    <div class="pull-right">
                                        <button type="submit" id="formrevisitbtn"  data-loading-text="Processing..." class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
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

<!-- -->
<div class="modal fade" id="myPaymentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-mid" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="box-title"><?php echo $this->lang->line('add') . " " . $this->lang->line('payment'); ?></h4> 
            </div>
            <div class="modal-body pt0 pb0">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 paddlr">
                        <form id="add_payment" accept-charset="utf-8" method="post" class="ptt10" >
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('amount') . " (" . $currency_symbol . ")"; ?></label><small class="req"> *</small> 
                                        <input type="text" name="amount" id="amount" class="form-control">    
                                        <input type="hidden" name="patient_id" id="payment_patient_id" class="form-control">
                                        <input type="hidden" name="opd_id" id="payment_opd_id" class="form-control">
                                        <input type="hidden" name="total" id="total" class="form-control">
                                        <span class="text-danger"><?php echo form_error('amount'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('payment') . " " . $this->lang->line('mode'); ?></label> 
                                        <select class="form-control" name="payment_mode">

<?php foreach ($payment_mode as $key => $value) {
    ?>
                                                <option value="<?php echo $key ?>" <?php
    if ($key == 'cash') {
        echo "selected";
    }
    ?>><?php echo $value ?></option>
<?php } ?>
                                        </select>    
                                        <span class="text-danger"><?php echo form_error('apply_charge'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('date'); ?></label><small class="req"> *</small> 
                                        <input type="text" name="payment_date" id="date" class="form-control date">
                                        <span class="text-danger"><?php echo form_error('apply_charge'); ?></span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('attach_document'); ?></label>
                                        <input type="file" class="filestyle form-control"   name="document">
                                        <span class="text-danger"><?php echo form_error('document'); ?></span> 
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('note'); ?></label> 
                                        <input type="text" name="note" id="note" class="form-control"/>
                                    </div>
                                </div>

                            </div>
                            <button type="submit" id="add_paymentbtn" data-loading-text="<?php echo $this->lang->line('processing') ?>" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                        </form>
                    </div>
                </div>
            </div>    
        </div>
    </div> 
</div>
<!-- -->
<script type="text/javascript">
    $(function () {
        //Initialize Select2 Elements

        $(function () {
            var hash = window.location.hash;
            hash && $('ul.nav-tabs a[href="' + hash + '"]').tab('show');

            $('.nav-tabs a').click(function (e) {
                $(this).tab('show');
                var scrollmem = $('body').scrollTop();
                window.location.hash = this.hash;
                $('html,body').scrollTop(scrollmem);
            });
        });

    });
    $(function () {
        $("#compose-textareas,#compose-textareanew").wysihtml5();
    });
    function edit_prescription(id, opdid, visitid) {

        $.ajax({
            url: '<?php echo base_url(); ?>admin/prescription/editPrescription/' + id + '/' + opdid + '/' + visitid,
            success: function (res) {
                $('#prescriptionview').modal('hide');
                $("#editdetails_prescription").html(res);
            },
            error: function () {
                alert("Fail")
            }
        });
    }

    function get_Charges(id) {
        $("#standard_charge").html("standard_charge");
        //$("#schedule_charge").html("schedule_charge");

        $.ajax({
            url: '<?php echo base_url(); ?>admin/patient/doctCharge',
            type: "POST",
            data: {doctor: id},
            dataType: 'json',
            success: function (res) {
                console.log(res);
                if (res) {

                    $('#standard_charge').val(res.standard_charge);
                    $('#edit_amount').val(res.standard_charge);

                } else {
                    $('#standard_charge').val('0');
                    $('#edit_amount').val('0');
                }
            }
        });
    }

    function get_Chargesvisit(id) {
        $("#standard_charge").html("standard_charge");
        //$("#schedule_charge").html("schedule_charge");

        $.ajax({
            url: '<?php echo base_url(); ?>admin/patient/doctCharge',
            type: "POST",
            data: {doctor: id},
            dataType: 'json',
            success: function (res) {
                console.log(res);
                if (res) {

                    $('#standard_chargevisit').val(res.standard_charge);
                    $('#revisit_amount').val(res.standard_charge);

                } else {
                    $('#standard_chargevisit').val('0');
                    $('#revisit_amount').val('0');
                }
            }
        });
    }

    function getchargecode(charge_category) {
        var div_data = "";
        $('#code').html("<option value='l'><?php echo $this->lang->line('loading') ?></option>");
        $("#code").select2("val", 'l');


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
                $("#code").select2("val", '');

                $('#standard_charge').val('');
                $('#apply_charge').val('');
            }
        });
    }

    function getRecord(id, opdid) {
        $.ajax({
            url: '<?php echo base_url(); ?>admin/patient/getDetails',
            type: "POST",
            data: {patient_id: id, opd_id: opdid},
            dataType: 'json',
            success: function (data) {
                $("#patient_name").html(data.patient_name);
                $("#patients_id").html(data.patient_unique_id);
                $("#guardian_name").html(data.guardian_name);
                $("#gen").html(data.gender);
                $("#marital_status").html(data.marital_status);
                $("#contact").html(data.mobileno);
                $("#email").html(data.email);
                $("#patient_address").html(data.address);
                var age = '';
                var month = '';
                if (data.age != '') {
                    age = data.age + ' Year ';
                }

                if (data.month != '') {
                    month = data.month + ' Month ';
                }
                $("#age").html(age + month);
                $("#blood_group").html(data.blood_group);
                $("#height").html(data.height);
                $("#weight").html(data.weight);
                $('#patient_bp').html(data.bp);
                $("#symptoms").html(data.symptoms);
                $("#known_allergies").html(data.known_allergies);
                $("#appointment_date").html(data.appointment_date);
                $("#case").html(data.case_type);
                $("#casualty").html(data.casualty);
                $("#old_patient").html(data.old_patient);
                $("#doc").html(data.name + " " + data.surname);
                $("#organisation").html(data.organisation_name);
                $("#refference").html(data.refference);
                $("#amount").html(data.amount);
                $("#payment_mode").html(data.payment_mode);
                $("#opdid").val(data.opdid);
                $("#opd_no").html(data.opd_no);
                $("#note").html(data.note_remark);
                var patient_id = "<?php echo $result["id"] ?>";
                $('#edit_delete').html("<?php if ($this->rbac->hasPrivilege('revisit', 'can_edit')) { ?><a href='#'' onclick='editRecord(" + id + "," + opdid + ")' data-target='#editModal' data-toggle='tooltip'  data-original-title='<?php echo $this->lang->line('edit'); ?>'><i class='fa fa-pencil'></i></a><?php } ?><?php if ($this->rbac->hasPrivilege('revisit', 'can_delete')) { ?><a href='#' data-toggle='tooltip'  onclick='delete_record(" + id + ")' data-original-title='<?php echo $this->lang->line('delete'); ?>'><i class='fa fa-trash'></i></a><?php } ?>");
                holdModal('viewModal');

            },
        });
    }

    function delete_record(opdid) {
        if (confirm(<?php echo "'" . $this->lang->line('delete_conform') . "'"; ?>)) {
            $.ajax({
                url: '<?php echo base_url(); ?>admin/patient/deleteVisit/' + opdid,
                type: "POST",
                data: {opdid: opdid},
                dataType: 'json',
                success: function (data) {
                    successMsg(<?php echo "'" . $this->lang->line('delete_message') . "'"; ?>);
                    window.location.reload(true);
                }
            })
        }
    }

    function delete_patient(id) {
        if (confirm(<?php echo "'" . $this->lang->line('delete_conform') . "'"; ?>)) {
            $.ajax({
                url: '<?php echo base_url(); ?>admin/patient/deleteOPDPatient',
                type: "POST",
                data: {id: id},
                dataType: 'json',
                success: function (data) {
                    successMsg(<?php echo "'" . $this->lang->line('delete_message') . "'"; ?>);
                    window.location.href = '<?php echo base_url() ?>admin/patient/search';
                }
            })
        }
    }

    function getEditRecord(id) {
        $.ajax({
            url: '<?php echo base_url(); ?>admin/patient/getDetails',
            type: "POST",
            data: {patient_id: id},
            dataType: 'json',
            success: function (data) {
                //alert('Hiiii');

                $("#patientids").val(data.patient_unique_id);
                $("#patient_names").val(data.patient_name);
                $("#contacts").val(data.mobileno);
                $("#emails").val(data.email);
                $("#ages").val(data.age);
                $("#address").text(data.address);
                $("#months").val(data.month);
                $("#guardian_names").val(data.guardian_name);
                $("#amounts").val(data.amount);
                $("#updateids").val(id);
                $('select[id="blood_groups"] option[value="' + data.blood_group + '"]').attr("selected", "selected");
                $('select[id="genders"] option[value="' + data.gender + '"]').attr("selected", "selected");
                $('select[id="marital_statuss"] option[value="' + data.marital_status + '"]').attr("selected", "selected");
                $('select[id="consultant_doctors"] option[value="' + data.cons_doctor + '"]').attr("selected", "selected");
                holdModal('myModaledit');

            },
        });
    }


    $(document).ready(function (e) {
        $("#formeditrecord").on('submit', (function (e) {
            $("#formeditrecordbtn").button('loading');
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
                    $("#formeditrecordbtn").button('reset');
                },
                error: function () {
                    //  alert("Fail")
                }
            });
        }));
    });
    function getRecord_id(id) {
        var pres_id = '<?php echo $visit_id ?>';
        if (pres_id == id) {
            $('#visit_id').val('0');
        } else {
            $('#visit_id').val(id);
        }
        // $('#visit_id').val(id);
        $('#pres_patient_id').val(id);
        $('#prescription_id').val('<?php echo $visit_id ?>');
        holdModal('add_prescription');
    }


    function editRecord(id, opdid) {
        var $exampleDestroy = $('#edit_consdoctor').select2();
        $.ajax({
            url: '<?php echo base_url(); ?>admin/patient/opd_details',
            type: "POST",
            data: {recordid: id, opdid: opdid},
            dataType: 'json',
            success: function (data) {

                $("#patientid").val(data.patient_id);
                $("#patientname").val(data.patient_name);
                $exampleDestroy.val(data.cons_doctor).select2('destroy').select2()
// $("#edit_consdoctor").select2().select2('val','3');
                $("#appointmentdate").val(data.appointment_date);
                $("#edit_case").val(data.case_type);
                $("#edit_symptoms").val(data.symptoms);
                $("#edit_casualty").val(data.casualty);
                $("#edit_knownallergies").val(data.known_allergies);
                $("#edit_refference").val(data.refference);
                $("#revisit_note").html(data.note_remark);
                $("#edit_amount").val(data.amount);
                $("#standard_charge").val(data.standard_charge);
                $("#edit_oldpatient").val(data.old_patient);
                $("#edit_organisation").val(data.organisation);
                $("#edit_height").val(data.height);
                $("#edit_weight").val(data.weight);
                $("#edit_bp").val(data.bp);
                $("#edit_paymentmode").val(data.payment_mode);
                $("#edit_opdid").val(opdid);
                $("#viewModal").modal('hide');
                holdModal('editModal');


                // thiss.select2("val", data.cons_doctor);
                console.log(data);
            },
        });
    }
    $(document).ready(function (e) {
        $("#formedit").on('submit', (function (e) {
            $("#formeditbtn").button("loading");
            e.preventDefault();
            $.ajax({
                url: '<?php echo base_url(); ?>admin/patient/opd_detail_update',
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
                    $("#formeditbtn").button("reset");
                },
                error: function () {
                    //  alert("Fail")
                }
            });
        }));
    });
    $(document).ready(function (e) {
        $("#form_prescription").on('submit', (function (e) {
            $("#form_prescriptionbtn").button('loading');
            //var student_id = $("#student_id").val();
            //alert("hii");
            e.preventDefault();
            $.ajax({
                url: '<?php echo base_url(); ?>admin/patient/add_prescription',
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
                    $("#form_prescriptionbtn").button('reset');
                },
                error: function () {
                    //alert("Fail")
                }
            });
        }));
    });

    $(document).ready(function (e) {
        $("#form_diagnosis").on('submit', (function (e) {
            //var student_id = $("#student_id").val();
            //alert("hii");
            $("#form_diagnosisbtn").button('loading');
            e.preventDefault();
            $.ajax({
                url: '<?php echo base_url(); ?>admin/patient/add_diagnosis',
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
                        //toastr.error(message);
                        //toastr.info('Page Loaded!');
                        errorMsg(message);
                    } else {
                        successMsg(data.message);
                        window.location.reload(true);
                    }
                    $("#form_diagnosisbtn").button('reset');
                },
                error: function () {
                    //  alert("Fail")
                }
            });
        }));
    });
    function add_more() {


        var div = "<div id=row1><div class=col-sm-3><select class='form-control select2' onchange='getMedicineName(1)' name='medicine_cat[]'  id='medicine_cat1'><option value='<?php echo set_value('medicine_category_id'); ?>'><?php echo $this->lang->line('select') ?></option><?php foreach ($medicineCategory as $dkey => $dvalue) { ?><option value='<?php echo $dvalue["id"]; ?>'><?php echo $dvalue["medicine_category"] ?></option><?php } ?></select></div><div class=col-sm-3><div class=form-group><select class='form-control select2'  name='medicine[]' id='search-query1'><option value='l'><?php echo $this->lang->line('select') ?></option></select></div></div><div class=col-sm-3><div class=form-group><select type=text class=form-control name='dosage[]' id='dosagelist1'><option value='l'><?php echo $this->lang->line('select') ?></option><?php foreach ($dosage as $dkey => $dosagevalue) { ?><option value='<?php echo $dosagevalue["dosage"]; ?>'><?php echo $dosagevalue["dosage"] ?></option><?php } ?></select></div></div><div class=col-sm-3><div class=form-group><textarea style='height:28px' name='instruction[]' class=form-control id=description></textarea></div></div></div>";

        var table = document.getElementById("tableID");
        var table_len = (table.rows.length);
        var id = parseInt(table_len);
        var row = table.insertRow(table_len).outerHTML = "<tr id='row" + id + "'><td>" + div + "</td><td><button type='button' onclick='delete_row(" + id + ")' class='modaltableclosebtn sss'><i class='fa fa-remove'></i></button></td></tr>";
        $('.select2').select2();
    }

    function delete_row(id) {
        var table = document.getElementById("tableID");
        var rowCount = table.rows.length;
        $("#row" + id).html("");
        //table.deleteRow(id);
    }
    $(document).ready(function (e) {
        $("#add_timeline").on('submit', (function (e) {
            $("#add_timelinebtn").button('loading');
            var patient_id = $("#patient_id").val();
            e.preventDefault();
            $.ajax({
                url: "<?php echo site_url("admin/timeline/add_patient_timeline") ?>",
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
                        $.ajax({
                            url: '<?php echo base_url(); ?>admin/timeline/patient_timeline/' + patient_id,
                            success: function (res) {
                                $('#timeline_list').html(res);
                                $('#myTimelineModal').modal('toggle');
                            },
                            error: function () {
                                alert("Fail")
                            }
                        });
                        //window.location.reload(true);
                    }
                    $("#add_timelinebtn").button('reset');
                },
                error: function (e) {
                    alert("Fail");
                    console.log(e);
                }
            });
        }));
    });
    function delete_timeline(id) {
        var patient_id = $("#patient_id").val();
        if (confirm('<?php echo $this->lang->line("delete_conform") ?>')) {
            $.ajax({
                url: '<?php echo base_url(); ?>admin/timeline/delete_patient_timeline/' + id,
                success: function (res) {
                    $.ajax({
                        url: '<?php echo base_url(); ?>admin/timeline/patient_timeline/' + patient_id,
                        success: function (res) {

                            $('#timeline_list').html(res);
                            successMsg('<?php echo $this->lang->line('delete_message') ?>');
                        },
                        error: function () {
                            alert("Fail")
                        }
                    });
                },
                error: function () {
                    alert("Fail")
                }
            });
        }
    }

    function view_prescription(id, opdid, visitid, prescription = 'yes') {
        $.ajax({
            url: '<?php echo base_url(); ?>admin/prescription/getPrescription/' + id + '/' + opdid + '/' + visitid,
            success: function (res) {
                $("#getdetails_prescription").html(res);
            },
            error: function () {
                alert("Fail")
            }
        });
        if (prescription == 'yes') {

            $('#edit_deleteprescription').html("<?php if ($this->rbac->hasPrivilege('prescription', 'can_view')) { ?><a href='#'' onclick='printprescription(" + id + "," + opdid + ")'   data-original-title='<?php echo $this->lang->line('print'); ?>'><i class='fa fa-print'></i></a><?php } ?><?php if ($this->rbac->hasPrivilege('prescription', 'can_edit')) { ?><a href='#'' onclick='edit_prescription(" + id + "," + opdid + "," + visitid + ")' data-target='#edit_prescription' data-toggle='modal'  data-original-title='<?php echo $this->lang->line('edit'); ?>'><i class='fa fa-pencil'></i></a><?php } if ($this->rbac->hasPrivilege('prescription', 'can_delete')) { ?><a onclick='delete_prescription(" + id + "," + opdid + ")'  href='#'  data-toggle='tooltip'  data-original-title='<?php echo $this->lang->line('delete'); ?>'><i class='fa fa-trash'></i></a><?php } ?>");
        }

        holdModal('prescriptionview');
    }
</script>

<script type="text/javascript">

    $(document).ready(function (e) {
        $('.select2').select2();
    });

    $(document).ready(function (e) {
        $("#formrevisit").on('submit', (function (e) {
            $("#formrevisitbtn").button('loading');
            e.preventDefault();
            $.ajax({
                url: '<?php echo base_url(); ?>admin/patient/addvisitDetails',
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
                $("#standard_chargevisit").val(data.standard_charge);
                $("#revisit_symptoms").val(data.symptoms);
                $("#revisit_age").val(data.age);
                $("#revisit_month").val(data.month);
                $("#revisit_height").val(data.height);
                $("#revisit_opd_no").val('<?php echo $visit_details['opd_no'] ?>');
                $("#revisit_opd_id").val('<?php echo $visit_details['id'] ?>');
                // $("#revisit_weight").val(data.weight);
                // $("#revisit_bp").val(data.bp);
                $("#revisit_blood_group").val(data.blood_group);
                $("#revisi_tax").val(data.tax);
                $("#revisit_address").val(data.address);
                //$("#revisit_note").val(data.note_remark);
                // $("#revisit_casualty").val(data.casualty);
                $('select[id="revisit_old_patient"] option[value="' + data.old_patient + '"]').attr("selected", "selected");
                $('select[id="revisit_doctor"] option[value="' + data.cons_doctor + '"]').attr("selected", "selected");
                // $('select[id="revisit_payment"] option[value="' + data.payment_mode + '"]').attr("selected", "selected");
                $('select[id="revisit_gender"] option[value="' + data.gender + '"]').attr("selected", "selected");
                $('select[id="revisit_marital_status"] option[value="' + data.marital_status + '"]').attr("selected", "selected");
                holdModal('revisitModal');
            },

        })

    }

    function printprescription(id, opdid) {
        var base_url = '<?php echo base_url() ?>';
        $.ajax({
            url: base_url + 'admin/prescription/getPrescription/' + id + '/' + opdid,
            type: 'POST',
            data: {payslipid: id, print: 'yes'},
            //dataType: "json",
            success: function (result) {
                $("#testdata").html(result);
                popup(result);
            }
        });
    }
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
        }, 500);
        return true;
    }
    function holdModal(modalId) {
        $('#' + modalId).modal({
            backdrop: 'static',
            keyboard: false,
            show: true
        });
    }


    function deleteOpdPatientDiagnosis(patient_id, id) {
        if (confirm(<?php echo "'" . $this->lang->line('delete_conform') . "'"; ?>)) {
            $.ajax({
                url: '<?php echo base_url(); ?>admin/patient/deleteOpdPatientDiagnosis/' + patient_id + '/' + id,
                success: function (res) {
                    successMsg(<?php echo "'" . $this->lang->line('delete_message') . "'"; ?>);
                    window.location.reload(true);
                }
            })
        }
    }

    function deleteOpdPatientDiagnosis1(url, Msg) {
        if (confirm(<?php echo "'" . $this->lang->line('delete_conform') . "'"; ?>)) {
            $.ajax({
                url: url,
                success: function (res) {
                    successMsg(Msg);
                    window.location.reload(true);
                }
            })
        }
    }


    var attr = {};

    function getMedicineName(id) {
        // var table = document.getElementById("tableID");
        //     var table_len = (table.rows.length);
        //     var id = parseInt(table_len)-1;
        console.log(id);

        var category_selected = $("#medicine_cat" + id).val();
        var arr = category_selected.split('-');
        var category_set = arr[0];
        div_data = '';
        $("#search-query" + id).html("<option value='l'><?php echo $this->lang->line('loading') ?></option>");
        $('#search-query' + id).select2("val", 'l');
        $.ajax({
            type: "POST",
            url: base_url + "admin/pharmacy/get_medicine_name",
            data: {'medicine_category_id': category_selected},
            dataType: 'json',
            success: function (res) {
                console.log(res);
                $.each(res, function (i, obj)
                {
                    var sel = "";
                    div_data += "<option value='" + obj.medicine_name + "'>" + obj.medicine_name + "</option>";
                });
                $("#search-query" + id).html("<option value=''>Select</option>");
                $('#search-query' + id).append(div_data);
                $('#search-query' + id).select2("val", '');

            }
        });

    }
    ;

    function getcharge_category(id) {
        var div_data = "";
        //   $("#charge_category").select2().select2('val', '');
        // $("#charge_category").html("<option value=''>Select</option>");
        $('#charge_category').html("<option value='l'><?php echo $this->lang->line('loading') ?></option>");
        $("#charge_category").select2("val", 'l');

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
                $('#charge_category').html("<option value=''>Select</option>");
                $('#charge_category').append(div_data);
                $("#charge_category").select2("val", '');
            }
        });
    }

    function get_Charges(code, orgid) {
        $("#standard_charge").html("standard_charge");
        $("#schedule_charge").html("schedule_charge");

        $.ajax({
            url: '<?php echo base_url(); ?>admin/patient/ipdCharge',
            type: "POST",
            data: {code: code, organisation_id: orgid},
            dataType: 'json',
            success: function (res) {
                console.log(res);

                if (res) {
                    $('#addstandard_charge').val(res.standard_charge);
                    $('#schedule_charge').val(res.org_charge);
                    $('#charge_id').val(res.id);
                    $('#org_id').val(res.org_charge_id);

                    if (res.org_charge == null) {
                        $('#apply_charge').val(res.standard_charge);
                    } else {
                        $('#apply_charge').val(res.org_charge);
                    }
                } else {
                    // $('#standard_charge').val('0');
                    // $('#schedule_charge').val('0');
                    // $('#charge_id').val('0');
                    // $('#org_id').val('0');
                }
            }
        });
    }

    $(document).ready(function (e) {
        $("#add_bill").on('submit', (function (e) {
            if (confirm('Are you sure?')) {
                $("#save_button").button('loading');
                e.preventDefault();
                $.ajax({
                    url: "<?php echo site_url("admin/payment/addopdbill") ?>",
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
                            window.location.reload = true;
                        }
                        $("#save_button").button('reset');

                    },
                    error: function (e) {
                        alert("Fail");
                        console.log(e);
                    }
                });
            } else {
                return false;
            }

        }));
    });

    $(document).ready(function (e) {
        $("#add_charges").on('submit', (function (e) {
            e.preventDefault();
            $("#add_chargesbtn").button('loading');
            $.ajax({
                url: '<?php echo base_url(); ?>admin/charges/add_opdcharges',
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
                    $("#add_chargesbtn").button('reset');
                },
                error: function () {}
            });
        }));
    });


    function addpaymentModal() {
        var total = $("#charge_total").val();
        var patient_id = '<?php echo $result["id"] ?>';
        var opd_id = '<?php echo $visit_id ?>';
        $("#total").val(total);
        $("#payment_opd_id").val(opd_id);
        $("#payment_patient_id").val(patient_id);
        holdModal('myPaymentModal');
    }

    $(document).ready(function (e) {
        $("#add_payment").on('submit', (function (e) {
            e.preventDefault();
            $("#add_paymentbtn").button("loading");
            $.ajax({
                url: '<?php echo base_url(); ?>admin/payment/addOPDPayment',
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
                    $("#add_paymentbtn").button("reset");
                }, error: function () {}
            });
        }));
    });

    function calculate() {

        var discount_percent = $("#discount_percent").val();
        var tax_percent = $("#tax_percent").val();

        var total_amount = $("#total_amount").val();
        if (discount_percent != '') {
            var discount = (total_amount * discount_percent) / 100;
            $("#discount").val(discount);
        } else {
            var discount = $("#discount").val();

        }

        if (tax_percent != '') {
            var tax = (total_amount * tax_percent) / 100;
            $("#tax").val(tax);
        } else {
            var tax = $("#tax").val();

        }
        // var discount = $("#discount").val();
        var other_charge = $("#other_charge").val();
        //var gross_total = $("#gross_total").val();
        //   var tax = $("#tax").val();
        // var net_amount = $("#net_amount").val();
        var gross_total = parseInt(total_amount) + parseInt(other_charge) + parseInt(tax);
        var net_amount = parseInt(total_amount) + parseInt(other_charge) + parseInt(tax) - parseInt(discount);
        $("#gross_total").val(gross_total);
        $("#net_amount").val(net_amount);
        $("#net_amount_span").html(net_amount);
        $("#save_button").show();
        $("#printBill").show();
    }

    function printBill(patientid, ipdid) {
        var total_amount = $("#total_amount").val();
        var discount = $("#discount").val();
        var other_charge = $("#other_charge").val();
        var gross_total = $("#gross_total").val();
        var tax = $("#tax").val();
        var net_amount = $("#net_amount").val();
        var status = $("#status").val();
        var base_url = '<?php echo base_url() ?>';
        $.ajax({
            url: base_url + 'admin/payment/getOPDBill/',
            type: 'POST',
            data: {patient_id: patientid, ipdid: ipdid, total_amount: total_amount, discount: discount, other_charge: other_charge, gross_total: gross_total, tax: tax, net_amount: net_amount, status: status},
            success: function (result) {
                $("#testdata").html(result);
                popup(result);
            }
        });
    }

    function generateBill(id, amount) {
        $("#opdidhide").val(id);
        $("#totalopdcharges").val(amount);
        $("#addBillModal").modal('show');
    }

</script>