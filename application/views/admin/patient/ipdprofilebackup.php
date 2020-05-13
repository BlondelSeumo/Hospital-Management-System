
<?php
$currency_symbol = $this->customlib->getSchoolCurrencyFormat();
$genderList = $this->customlib->getGender();
?>
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
                        //  print_r($result);

                        $image = $result['image'];
                        if (!empty($image)) {

                            $file = $result['image'];
                        } else {

                            $file = "no_image.png";
                        }
                        ?>
                        <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url() . "uploads/staff_images/" . $file ?>" alt="User profile picture">
                        <h3 class="profile-username text-center"><?php echo $result['patient_name']; ?>
                            <small>
                                <a href="#" onclick="getEditRecord('<?php echo $result['id'] ?>')"  data-target="#myModaledit" data-toggle="modal" title="<?php echo $this->lang->line('edit') . " " . "Profile" ?>">
                                    <i class="fa fa-pencil"></i>
                                </a>
                            </small>
                        </h3>
                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item listnoback">
                                <b><?php echo "Patient Id --r"; ?></b> <a class="pull-right text-aqua"><?php echo $result['patient_unique_id']; ?></a>
                            </li>
                            <li class="list-group-item listnoback">
                                <b><?php echo $this->lang->line('gender'); ?></b> <a class="pull-right text-aqua"><?php echo $result['gender']; ?></a>
                            </li>
                            <li class="list-group-item listnoback">
                                <b><?php echo $this->lang->line('marital_status'); ?></b> <a class="pull-right text-aqua"><?php echo $result['marital_status']; ?></a>
                            </li>
                            <li class="list-group-item listnoback">
                                <b><?php echo $this->lang->line('phone'); ?></b> <a class="pull-right text-aqua"><?php echo $result['mobileno']; ?></a>
                            </li>
                            <li class="list-group-item listnoback">
                                <b><?php echo $this->lang->line('email'); ?></b> <a class="pull-right text-aqua"><?php echo $result['email']; ?></a>
                            </li>
                            <li class="list-group-item listnoback">
                                <b>Age --r</b> <a class="pull-right text-aqua"><?php echo $result['age'] . " years " . $result['month'] . " months"; ?></a>
                            </li>
                            <li class="list-group-item listnoback">
                                <b><?php echo $this->lang->line('guardian_name'); ?></b> <a class="pull-right text-aqua"><?php echo $result['guardian_name']; ?></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="nav-tabs-custom" id="tabs">
                    <ul class="nav nav-tabs" >
                        <li>
                            <a href="#consultant_register"  data-toggle="tab" aria-expanded="true">Consultant Register --r</a>
                        </li>
                        <li>
                            <a href="#diagnosis" data-toggle="tab" aria-expanded="true">Diagnosis --r</a>
                        </li>
                        <li>
                            <a href="#timeline" data-toggle="tab" aria-expanded="true">Timeline --r</a>
                        </li>
                        <li class="active">
                            <a href="#charges" data-toggle="tab" aria-expanded="true">Charges --r</a>
                        </li>
                        <li>
                            <a href="#payment" data-toggle="tab" aria-expanded="true">Payment --r</a>
                        </li>
                        <li>
                            <a href="#bill" class="bill" data-toggle="tab" aria-expanded="true">Bill --r</a>
                        </li>
                    </ul>   
                    <?php if ($result['status'] != 'paid') { ?>
                        <div class="impbtnview">
                            <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown"><i class="fa fa-plus"></i>Add<span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menuright" role="menu">
                                <li><a href="#" data-target="#add_diagnosis" data-toggle="modal"><?php echo $this->lang->line('add') ?> Diagnosis</a></li>
                                <li><a href="#" data-target="#add_prescription" data-toggle="modal"><?php echo $this->lang->line('add') ?> Prescription</a></li>
                                <li><a href="#" data-target="#myTimelineModal" data-toggle='modal' value="<?php echo $this->lang->line('add') ?>" /> Timeline</a></li>
                                <li><a href="#" data-target="#myChargesModal" data-toggle='modal' value="<?php echo $this->lang->line('add') ?>"/>Add Charges</a></li>
                                <li><a href="#" onclick="addpaymentModal()" data-target="#myPaymentModal" data-toggle='modal' value="<?php echo $this->lang->line('add') ?>"/>Add Payment</a></li>
                            </ul>
                        </div>
                    <?php } ?>
                    <div class="tab-content">
                        <div class="tab-pane" id="activity">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover example" cellspacing="0" width="100%">
                                    <thead>
                                    <th>Consultant --r</th>
                                    <th>Appointment Date --r </th>
                                    <th>Case --r</th>
                                    <th>Symptoms --r</th>
                                    <th>Refference --r</th>
                                    <th class="text-right"><?php echo $this->lang->line('action') ?></th>         
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (!empty($opd_details)) {
                                            foreach ($opd_details as $key => $value) {
                                                ?>  
                                                <tr>
                                                    <td><?php echo $value["name"] . " " . $value["surname"]; ?></td>
                                                    <td><?php echo $value['appointment_date']; ?></td>
                                                    <td><?php echo $value['case_type']; ?></td>
                                                    <td><?php echo $value['symptoms']; ?></td>
                                                    <td><?php echo $value['refference']; ?></td>
                                                    <td class="pull-right">
                                                        <a href="#" onclick="getRecord('<?php echo $result["id"] ?>')" data-target="#viewModal" data-toggle="modal"><i class="fa fa-reorder"></i>
                                                        </a>
                                                        <a href="#" onclick="editRecord('<?php echo $value["patient_id"] ?>', '<?php echo $value["id"] ?>')" data-target="#editModal" data-toggle="modal"><i class="fa fa-pencil"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?> 
                                    </tbody>
                                </table>
                            </div> 
                        </div><!-- -->

                        <!-- Consultant Register -->
                        <div class="tab-pane" id="consultant_register">

                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover example">
                                    <thead>
                                    <th>Date --r</th>
                                    <th>Doctor --r </th>
                                    <th>Instruction --r </th>
                                    <th>Instruction Date --r </th>
                                    <th>Instruction Time --r </th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (!empty($consultant_register)) {
                                            foreach ($consultant_register as $consultant_key => $consultant_value) {
                                                ?>  
                                                <tr>
                                                    <td><?php echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($consultant_value['date'])); ?></td>
                                                    <td><?php echo $consultant_value["name"] ?></td>
                                                    <td><?php echo $consultant_value["instruction"] ?></td>
                                                    <td><?php echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($consultant_value['ins_date'])); ?></td>
                                                    <td><?php echo $consultant_value["ins_time"] ?></td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?> 
                                    </tbody>
                                </table>
                            </div> 
                        </div>  
                        <!-- diagnosis -->
                        <div class="tab-pane" id="diagnosis">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover example">
                                    <thead>
                                    <th>Report Type --r</th>
                                    <th>Description --r </th>
                                    <th class="text-right">Download --r </th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (!empty($diagnosis_detail)) {
                                            foreach ($diagnosis_detail as $diagnosis_key => $diagnosis_value) {
                                                ?>  
                                                <tr>
                                                    <td><?php echo $diagnosis_value["report_type"] ?></td>
                                                    <td><?php echo $diagnosis_value["description"] ?></td>
                                                    <td class="pull-right">
                                                        <?php if (!empty($diagnosis_value["document"])) { ?>
                                                            <a href="<?php echo base_url() . "admin/patient/report_download/" . $diagnosis_value["document"] ?>" ><i class="fa fa-download"></i></a>
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
                        <!-- Timeline -->
                        <div class="tab-pane" id="timeline">

                            <div class="timeline-header no-border">
                                <div id="timeline_list">
                                    <?php if (empty($timeline_list)) { ?>
                                        <br/>
                                        <div class="alert alert-info"><?php echo $this->lang->line('no_record_found'); ?></div>
                                    <?php } else { ?>
                                        <ul class="timeline timeline-inverse">
                                            <?php
                                            foreach ($timeline_list as $key => $value) {
                                                ?>      
                                                <li class="time-label">
                                                    <span class="bg-blue">    
                                                        <?php echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($value['timeline_date'])); ?></span>
                                                </li> 
                                                <li>
                                                    <i class="fa fa-list-alt bg-blue"></i>
                                                    <div class="timeline-item">
                                                        <?php if ($this->rbac->hasPrivilege('staff_timeline', 'can_delete')) { ?>
                                                            <span class="time"><a class="defaults-c text-right" data-toggle="tooltip" title="" onclick="delete_timeline('<?php echo $value['id']; ?>')" data-original-title="Delete"><i class="fa fa-trash"></i></a></span>
                                                        <?php } ?>
                                                        <?php if (!empty($value["document"])) { ?>
                                                            <span class="time"><a class="defaults-c text-right" data-toggle="tooltip" title="" href="<?php echo base_url() . "admin/timeline/download_staff_timeline/" . $value["id"] . "/" . $value["document"] ?>" data-original-title="Download"><i class="fa fa-download"></i></a></span>
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
                        <!--Prescription -->
                        <div class="tab-pane" id="prescription">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <th>OPD Id --r</th>
                                    <th>Appointment Date --r </th>
                                    <th>Note --r </th>
                                    <th class="text-right">Action </th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (!empty($prescription_detail)) {
                                            foreach ($prescription_detail as $prescription_key => $prescription_value) {
                                                ?>  
                                                <tr>
                                                    <td><?php echo $prescription_value["opd_id"] ?></td>
                                                    <td><?php echo $prescription_value["appointment_date"] ?></td>
                                                    <td><?php echo $prescription_value["note"] ?></td>
                                                    <th class="pull-right"><a href="#" data-target="#prescriptionview" data-toggle='modal' onclick="view_prescription('<?php echo $prescription_value["id"] ?>', '<?php echo $prescription_value["opd_id"] ?>')"><i class="fa fa-reorder"></i></a></th>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?> 
                                    </tbody>
                                </table>
                            </div> 
                        </div> 
                        <!--Charges-->
                        <div class="tab-pane active" id="charges">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <th>Date</th>
                                    <th>Charge Type --r</th>
                                    <th>Charge Category --r </th>
                                    <th><?php echo "Standard Charge --r" . '(' . $currency_symbol . ')'; ?> </th>
                                    <th>Organization Charge --r </th>
                                    <th><?php echo "Apply Charge" . '(' . $currency_symbol . ')'; ?></th>
                                    <th><?php echo "Delete Charges" . '(' . $currency_symbol . ')'; ?></th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (!empty($charges)) {
                                            $total = 0;
                                            foreach ($charges as $charge) {

                                                $total += $charge["apply_charge"];
                                                ?>
                                                <tr>
                                                    <td><?php echo date("m/d/Y", strtotime($charge["date"])); ?></td>
                                                    <td><?php echo $charge["charge_type"] ?></td>
                                                    <td><?php echo $charge["charge_category"] ?></td>
                                                    <td><?php echo $charge["standard_charge"] ?></td>
                                                    <td><?php echo $charge["org_charge"] ?></td>
                                                    <td><?php echo $charge["apply_charge"] ?></td>
                                                    <td> <a href="<?php echo base_url(); ?>admin/patient/deleteIpdPatientCharge/<?php echo $charge['patient_id']; ?>/<?php echo $charge['id']; ?>" class="btn btn-default btn-xs" data-toggle="tooltip" title="" onclick="return confirm('<?php echo $this->lang->line('delete_confirm') ?>');" data-original-title="<?php echo $this->lang->line('delete'); ?>">
                                                            <i class="fa fa-trash"></i>
                                                        </a>    </td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>  
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><?php echo 'Total : 
                                   '; ?> <?php echo $total ?><input type="hidden" id="charge_total" name="charge_total" value="<?php echo $total ?>"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div> 
                        </div>

                        <div class="tab-pane" id="bill">
                            <div class="col-md-6">
                                <div class="table-responsive">
                                    <table class="earntable table table-striped table-responsive" >
                                        <tr>
                                            <th width="16%" ><?php echo 'Charges --r' . '(' . $currency_symbol . ')'; ?> </th>
                                            <th width="16%" >Category --r</th>
                                            <th width="19%">Date --r</th> 
                                            <th width="16%" class="pttright reborder"><?php echo 'Amount --r' . '(' . $currency_symbol . ')'; ?> </th>
                                        </tr>
                                        <?php
                                        $j = 0;
                                        $total = 0;
                                        foreach ($charges as $key => $charge) {
                                            ?>
                                            <tr>
                                                <td><?php echo $charge["charge_type"]; ?></td> 
                                                <td><?php echo $charge["charge_category"]; ?></td>
                                                <td><?php echo date("m/d/Y", strtotime($charge["created_at"])); ?></td>
                                                <td class="pttright reborder"><?php echo $charge["apply_charge"]; ?></td>
                                            </tr>


                                            <?php
                                            $total += $charge["apply_charge"];
                                            ?>

                                            <?php
                                            $j++;
                                        }
                                        ?>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td class="text-right"><?php echo "Total : " ?>  <?php echo $total ?></td>

                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="table-responsive">

                                    <table class="earntable table table-striped table-responsive" >
                                        <tr>
                                            <th width="20%" class="pttleft">Payment Mode --r</th>
                                            <th width="16%" class="">Payment Date --r</th>
                                            <th width="16%" class="text-right"><?php echo 'Paid Amount' . '(' . $currency_symbol . ')'; ?> --r</th>

                                        </tr>

                                        <?php
                                        $k = 0;
                                        $total_paid = 0;
                                        foreach ($payment_details as $key => $payment) {
                                            ?>
                                            <tr>
                                                <td class="pttleft"><?php echo $payment["payment_mode"]; ?></td>
                                                <td class=""><?php echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($payment['date'])); ?></td>
                                                <td class="text-right"><?php echo $payment["paid_amount"]; ?></td>
                                            </tr>
                                            <?php
                                            $total_paid += $payment["paid_amount"];
                                        }
                                        ?>
                                        <tr>
                                            <td></td>
                                            <td></td>

                                            <td class="text-right"><?php echo "Total : " ?><?php echo $total_paid ?></td>

                                        </tr>
                                    </table>

                                </div>
                            </div>

                            <table class="earntable table table-striped table-responsive">
                                <form method="post" id="add_bill" enctype="multipart/form-data">
                                    <tr>
                                        <th width="20%"><?php echo $this->lang->line('total') ?></th> 
                                        <td><?php echo $total; ?></td>
                                    </tr>
                                    <tr>
                                        <th width="20%"><?php echo "Total Paid Amount --r"; ?></th> 
                                        <td><?php echo $paid_amount; ?>
                                            <input type="hidden" value="<?php echo $total ?>" id="total_amount" name="total_amount" style="width: 30%" class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="20%"><?php echo "Discount --r"; ?></th> 
                                        <td width="">
                                            <input type="hidden" name="patient_id" value="<?php echo $result["id"] ?>">
                                            <input type="text" id="discount" value="0" name="discount" style="width: 30%" class="form-control"></td>
                                    </tr>
                                    <tr>
                                        <th width="20%"><?php echo "Any Other Charge --r"; ?></th> 
                                        <td width=""><input type="text" id="other_charge" value="0" name="other_charge" style="width: 30%" class="form-control"></td>
                                    </tr>
                                    <tr>
                                        <th width="20%"><?php echo "Gross Total --r"; ?></th> 
                                        <td width=""><input type="text" id="gross_total" value="0" name="gross_total" style="width: 30%" class="form-control"></td>
                                    </tr>
                                    <tr>
                                        <th width="20%"><?php echo "Tax --r"; ?></th> 
                                        <td width=""><input type="text" name="tax" value="0" id="tax" style="width: 30%" class="form-control"></td>
                                    </tr>
                                    <tr>
                                        <th width="20%"><?php echo "Net Amount --r"; ?></th> 
                                        <td width=""><input type="text" name="net_amount" value="0" id="net_amount" style="width: 30%" class="form-control"></td>
                                    </tr>
                            </table>
                            <?php if ($result['status'] != 'paid') { ?> 
                                <input type="button" onclick="calculate()" id="cal_btn"  name="" value="Calculate" class="btn btn-info">
                                <input type="submit" style="display:none" id="save_button" name="" value="Generate Bill & Discharge Patient" class="btn btn-info">
                            <?php } else { ?>
                                <input type="button" onclick="revert('<?php echo $result['id'] ?>', '<?php echo $result['bill_id'] ?>')" id="revert_btn"  name="" value="Revert Generated Bill" class="btn btn-info">

                            <?php } ?> 
                            </form>

                            <a href="#" onclick="print('<?php echo $result["id"] ?>', '<?php echo $result["id"] ?>')">Print Bill</a>
                        </div> 


                        <div class="tab-pane" id="payment">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover example">
                                    <thead>
                                    <th>Date</th>
                                    <th>Note</th>
                                    <th>Payment Mode --r </th>
                                    <th>Paid Amount --r</th>
                                   <!--  <th>Balance Amount --r </th> -->
                                    <th>Attached Document --r</th>
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
                                                    <td><?php echo $payment["payment_mode"] ?></td>
                                                    <td><?php echo $payment["paid_amount"] ?></td>
                                                   <!--  <td><?php echo $payment["balance_amount"] ?></td> -->
                                                    <td>
                                                        <a href="<?php echo base_url(); ?>admin/payment/download/<?php echo $payment["document"]; ?>" class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('download'); ?>">
                                                            <i class="fa fa-download"></i>
                                                        </a>
                                                    </td>

                                                </tr>
                                            <?php } ?> 

                                        </tbody>
                                        <tr>
                                            <td colspan='5' class="text-center"><?php echo $currency_symbol; ?><?php echo "Total : " . $total; ?>
                                            </td>
                                        </tr> 
                                    <?php } ?>
                                </table>
                            </div> 
                        </div>
                        <!-- Bill payment -->  
                    </div>
                </div>
            </div>
    </section>
</div>
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="box-title"> Patient Information --r</h4> 
            </div>
            <div class="modal-body pt0 pb0">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 paddlr">
                        <form id="formedit"   accept-charset="utf-8"  enctype="multipart/form-data" method="post" class="ptt10">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>
                                            Appointment Date --r :</label> 
                                        <input type="text" name="appointment_date" class="form-control" id="appointmentdate" />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label >Case --r :</label> 
                                        <input type="text" class="form-control" name="case" id="edit_case" />

                                    </div> 
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Casualty --r :</label> 
                                        <select name="casualty" class="form-control" id="edit_casualty">
                                            <option value=""><?php echo $this->lang->line('select') ?></option>
                                            <option value="Yes"><?php echo $this->lang->line('yes') ?></option>
                                            <option value="No"><?php echo $this->lang->line('no') ?></option>
                                        </select>

                                    </div> 
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label >Symptoms --r :</label>
                                        <textarea class="form-control" id="edit_symptoms" name="symptoms" ></textarea> 
                                    </div> 
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Any Known Allergies --r :</label> 
                                        <textarea class="form-control" id="edit_knownallergies" name="known_allergies"></textarea>
                                        <input type="hidden" name="opdid" id="edit_opdid">
                                    </div> 
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>BP --r :</label> 
                                        <input type="text" name="bp" class="form-control" id="bp" />  
                                    </div> 
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Consultant Doctor --r :</label> 
                                        <select name="consultant_doctor" class="form-control" id="edit_consdoctor">
                                            <option value=""><?php echo $this->lang->line('select') ?></option>

                                            <?php foreach ($doctors as $dkey => $dvalue) {
                                                ?>
                                                <option value="<?php echo $dvalue["id"] ?>"><?php echo $dvalue["name"] . "" . $dvalue["surname"] ?></option>
                                            <?php } ?>
                                        </select>    


                                    </div> 
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Refference --r :</label> 
                                        <input type="text" name="refference" class="form-control" id="edit_refference" />  
                                    </div> 
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Amount --r :</label> 
                                        <input type="text" name="amount" class="form-control" id="edit_amount" />
                                    </div> 
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Payment Mode --r :</label> 
                                        <select id="edit_paymentmode" name="payment_mode" class="form-control">
                                            <option value=""><?php echo $this->lang->line('select') ?></option>
                                            <?php foreach ($payment_mode as $pkey => $pvalue) {
                                                ?>
                                                <option value="<?php echo $pkey ?>"><?php echo $pvalue ?></option>  
                                            <?php } ?>
                                        </select>
                                        <!--input type="text" name="payment_mode" class="form-control" id="edit_paymentmode" /-->  
                                    </div> 
                                </div>
                            </div>
                            <button type="submit" class="btn btn-info pull-right" >Save</button>
                        </form>
                    </div>
                </div>
            </div>    
        </div></div> </div>
<!-- Add Diagnosis -->
<div class="modal fade" id="add_diagnosis" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="box-title"> Add Diagnosis --r</h4> 
            </div>
            <div class="modal-body pt0 pb0">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 paddlr">
                        <form id="form_diagnosis"   accept-charset="utf-8"  enctype="multipart/form-data" method="post" class="ptt10">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>
                                            Report Type --r :</label> 
                                        <input type="text" name="report_type" class="form-control" id="report_type" />
                                        <input type="hidden" value="<?php echo $id ?>" name="patient" class="form-control" id="patient" />    
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label >Document --r :</label> 
                                        <input type="file" class="form-control filestyle" name="report_document" id="report_document" />
                                    </div> 
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Description --r :</label> 
                                        <textarea name="description" class="form-control" id="description"></textarea>
                                    </div> 
                                </div>
                            </div>
                            <button type="submit" class="btn btn-info pull-right" >Save</button>
                        </form>
                    </div>
                </div>
            </div>    
        </div></div> </div>
<!-- Timeline -->
<div class="modal fade" id="myTimelineModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="box-title"> Add Timeline --r</h4> 
            </div>
            <div class="modal-body pt0 pb0">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 paddlr">
                        <form id="add_timeline"   accept-charset="utf-8"  enctype="multipart/form-data" method="post" class="ptt10">
                            <div class="row">
                                <div class=" col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('title'); ?></label>
                                        <input type="hidden" name="patient_id" id="patient_id" value="<?php echo $id ?>">
                                        <input id="timeline_title" name="timeline_title" placeholder="" type="text" class="form-control"  />
                                        <span class="text-danger"><?php echo form_error('timeline_title'); ?></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('date'); ?></label><small class="req"> *</small>
                                        <input id="timeline_date" name="timeline_date" value="<?php echo set_value('timeline_date', date($this->customlib->getSchoolDateFormat())); ?>" placeholder="" type="text" class="form-control"  />
                                        <span class="text-danger"><?php echo form_error('timeline_date'); ?></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('description'); ?></label>
                                        <textarea id="timeline_desc" name="timeline_desc" placeholder=""  class="form-control"></textarea>
                                        <span class="text-danger"><?php echo form_error('description'); ?></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('attach_document'); ?></label>
                                        <div class="" style="margin-top:-5px; border:0; outline:none;">
                                            <input id="timeline_doc_id" name="timeline_doc" placeholder="" type="file"  class="filestyle form-control" data-height="40"  value="<?php echo set_value('timeline_doc'); ?>" />
                                            <span class="text-danger">
                                                <?php echo form_error('timeline_doc'); ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('visible'); ?></label>
                                        <input id="visible_check" checked="checked" name="visible_check" value="yes" placeholder="" type="checkbox"   />
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-info pull-right" >Save</button>
                        </form>
                    </div>
                </div>
            </div>    
        </div></div> </div>
<!-- Add Prescription -->
<div class="modal fade" id="add_prescription" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="box-title"> Add Prescription --r</h4> 
            </div>
            <div class="modal-body pt0 pb0">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 paddlr">
                        <form id="form_prescription" accept-charset="utf-8"  enctype="multipart/form-data" method="post" class="ptt10">
                            <div class="row">
                                <table id="tableID">
                                    <tr id="row0">
                                        <td>                                
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Medicine --r :</label> 
                                                    <input type="text" name="medicine[]" class="form-control" id="report_type" />
                                                    <input type="hidden" value="<?php echo $id ?>" name="patient" class="form-control" id="patient" />    
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label >Dosage --r :</label> 
                                                    <input type="text" class="form-control" name="dosage[]" id="report_document" />
                                                </div> 
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Instruction --r :</label> 
                                                    <textarea name="description" class="form-control" id="instruction[]"></textarea>
                                                </div> 
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                                <div class="add_row">
                                </div>
                                <div class="col-sm-12">
                                    <a href="#" class="pull-right" onclick="add_more()">Add More --r</a>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>OPD No --r :</label> 
                                        <select name="opd_no" class="form-control" id="opd_no">
                                            <option value=""><?php echo $this->lang->line('select') ?></option>
                                            <?php foreach ($opd_details as $opdkey => $opdvalue) { ?>
                                                <option value="<?php echo $opdvalue["id"] ?>"><?php echo $opdvalue["id"] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div> 
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Note --r :</label> 
                                        <textarea name="note" class="form-control" id="note"></textarea>
                                    </div> 
                                </div>
                            </div>
                            <button type="submit" class="btn btn-info pull-right" >Save</button>
                        </form>
                    </div>
                </div>
            </div>    
        </div></div> </div>
<!-- -->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="box-title"> Patient Information --r</h4> 
            </div>
            <div class="modal-body pt0 pb0">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 paddlr">
                        <form id="formrevisit"   accept-charset="utf-8"  enctype="multipart/form-data" method="post" class="ptt10">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>
                                            Patient ID --r :</label> 
                                        <span class="text-danger" id="patient_id"></span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>
                                            Name :</label> 
                                        <span class="text-danger" id="patient_name"></span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>
                                            Gender :</label> 
                                        <span class="text-danger" id="gender"></span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>
                                            Age :</label> 
                                        <span class="text-danger" id="age"></span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>
                                            Guardian Name :</label> 
                                        <span class="text-danger" id="guardian_name"></span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>
                                            Contact :</label> 
                                        <span class="text-danger" id="contact"></span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>
                                            Email :</label> 
                                        <span class="text-danger" id="email"></span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>
                                            Appointment Date --r :</label> 
                                        <span  id="appointment_date"></span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label >Symptoms --r :</label> 
                                        <span id="symptoms"></span>
                                    </div> 
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label >Any Known Allergies --r :</label> 
                                        <span id="known_allergies"></span>
                                    </div> 
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label >Case --r :</label> 
                                        <span id="case"></span>
                                    </div> 
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Casualty --r :</label> 
                                        <span id="casualty"></span>
                                    </div> 
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Consultant Doctor --r :</label> 
                                        <span id="cons_doctor"></span> 
                                    </div> 
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Refference --r :</label> 
                                        <span id="refference"></span>  
                                    </div> 
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Amount --r :</label> 
                                        <span id="amount"></span>  
                                    </div> 
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Tax --r :</label> 
                                        <span id="tax"></span>  
                                    </div> 
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Payment Mode --r :</label> 
                                        <span id="payment_mode"></span>  
                                    </div> 
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>    
        </div></div> </div>
<!-- -->
<div class="modal fade" id="prescriptionview" tabindex="-1" role="dialog" aria-labelledby="follow_up">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close"  data-dismiss="modal">&times;</button>
                <h4 class="box-title">Prescription</h4>
            </div>
            <div class="modal-body pt0 pb0" id="getdetails_prescription"></div>
        </div>
    </div>
</div>

<!-- -->
<div class="modal fade" id="myPaymentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-mid" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="box-title"> Add Payment --r</h4> 
            </div>
            <div class="modal-body pt0 pb0">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 paddlr">
                        <form id="add_payment" accept-charset="utf-8" method="post" class="ptt10" >
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?php echo "Amount --r"; ?></label><small class="req"> *</small> 
                                        <input type="text" name="amount" id="amount" class="form-control">    
                                        <input type="hidden" name="patient_id" id="payment_patient_id" class="form-control">
                                        <input type="hidden" name="total" id="total" class="form-control">

                                        <span class="text-danger"><?php echo form_error('amount'); ?></span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?php echo "Payment Mode --r"; ?></label><small class="req"> *</small> 
                                        <select class="form-control" name="payment_mode">
                                            <option value=""><?php echo $this->lang->line('select') ?></option>
                                            <?php foreach ($payment_mode as $key => $value) {
                                                ?>
                                                <option value="<?php echo $key ?>"><?php echo $value ?></option>
                                            <?php } ?>
                                        </select>    
                                        <span class="text-danger"><?php echo form_error('apply_charge'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?php echo "Date --r"; ?></label><small class="req"> *</small> 
                                        <input type="text" name="payment_date" id="date" class="form-control">
                                        <span class="text-danger"><?php echo form_error('apply_charge'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?php echo "Note --r"; ?></label> 
                                        <input type="text" name="note" id="note" class="form-control"/>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Attach Document--r</label>
                                        <small class="req"> *</small> 
                                        <input type="file" class="filestyle form-control" data-height="40"  name="document">
                                        <span class="text-danger"><?php echo form_error('document'); ?></span> 
                                    </div>
                                </div> 
                            </div>
                            <button type="submit" class="btn btn-info pull-right" >Save</button>
                        </form>
                    </div>
                </div>
            </div>    
        </div>
    </div> 
</div>
<!-- -->
<!--Add Charges-->
<div class="modal fade" id="myChargesModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="box-title"> Add Charges --r</h4> 
            </div>
            <div class="modal-body pt0 pb0">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 paddlr">
                        <form id="add_charges" accept-charset="utf-8"  method="post" class="ptt10" >
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>Date --r</label>
                                        <input id="charge_date" name="date" placeholder="" type="text" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label><?php echo 'Charge Type --r' ?></label>
                                        <small class="req"> *</small> 
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
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label><?php echo 'Charge Category --r' ?></label>
                                        <small class="req"> *</small> 
                                        <select name="charge_category" id="charge_category" class="form-control" onchange="get_Charges(this.value, '<?php echo $result['organisation'] ?>')">
                                            <option value="">Select</option>
                                        </select>
                                        <span class="text-danger"><?php echo form_error('charge_category'); ?></span>
                                    </div>
                                </div> 
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label><?php echo "Standard Charge --r"; ?></label>
                                        <input type="text" readonly name="standard_charge" id="standard_charge" class="form-control" value="<?php echo set_value('standard_charge'); ?>"> 
                                        <input type="hidden" name="patient_id" value="<?php echo $result["id"] ?>">
                                        <input type="hidden" name="charge_id" id="charge_id">
                                        <input type="hidden" name="org_id" id="org_id">
                                        <span class="text-danger"><?php echo form_error('standard_charge'); ?></span>
                                    </div>
                                </div> 
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label><?php echo "Organization Charge--r"; ?></label>
                                        <input type="text" readonly name="schedule_charge" id="schedule_charge" placeholder="Organization Charge" class="form-control" value="<?php echo set_value('schedule_charge'); ?>">    
                                        <span class="text-danger"><?php echo form_error('schedule_charge'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label><?php echo "Apply Charge --r"; ?></label><small class="req"> *</small> 
                                        <input type="text" name="apply_charge" id="apply_charge" class="form-control">    
                                        <span class="text-danger"><?php echo form_error('apply_charge'); ?></span>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-info pull-right" >Save</button>
                        </form>
                    </div>
                </div>
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
                <h4 class="box-title"> Patient Information --r</h4> 
            </div>

            <div class="modal-body pt0 pb0">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 paddlr">
                        <form id="formeditrecord" accept-charset="utf-8"  enctype="multipart/form-data" method="post"  class="ptt10">
                            <div class="row">

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('name'); ?></label><small class="req"> *</small> 
                                        <input id="patient_names" name="name" placeholder="" type="text" class="form-control"  value="<?php echo set_value('name'); ?>" />
                                        <input type="hidden" id="updateid" name="updateid">
                                        <input type="hidden" id="opdid" name="opdid">
                                        <span class="text-danger"><?php echo form_error('name'); ?></span>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Guardian Name</label>
                                        <input type="text" id="guardian_names" name="guardian_name" value="" class="form-control">

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label> <?php echo $this->lang->line('gender'); ?></label><small class="req"> *</small> 
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
                                                <option value="<?php echo $mkey ?>"><?php echo $mvalue ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div> 
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="pwd"><?php echo $this->lang->line('phone'); ?></label>
                                        <input id="contacts" autocomplete="off" name="contact" placeholder="" type="text" class="form-control"  value="<?php echo set_value('contact'); ?>" />
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="exampleInputFile">
                                            Patient Photo --r</label>
                                        <div><input class="filestyle form-control" type='file' name='file' id="files" size='20' />
                                            <input type="hidden" name="patient_photo" id="patient_photo">
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
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label> <?php echo $this->lang->line('blood_group'); ?></label><small class="req"> *</small> 
                                        <select class="form-control" id="bloodgroups" name="blood_group">
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
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label> Age --r</label>
                                        <!-- <input type="text" id="age" name="age" value="" class="form-control">
                                        <input type="text" id="month" name="month" value="" class="form-control"> -->
                                        <div style="clear: both;overflow: hidden;">
                                            <input type="text" placeholder="Age" name="age" id="ages" class="form-control" value="<?php echo set_value('age'); ?>" style="width: 40%; float: left;">
                                            <input type="text" placeholder="Month" name="month"  id="months" value="<?php echo set_value('month'); ?>" class="form-control" style="width: 56%;float: left; margin-left: 5px;">
                                        </div>
                                    </div>
                                </div>                                   
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="exampleInputFile">
                                            Organisation --r</label>
                                        <div><select class="form-control" name='organisation' id="organisations">
                                                <option value=""><?php echo $this->lang->line('select') ?></option>
                                                <?php foreach ($organisation as $orgkey => $orgvalue) {
                                                    ?>
                                                    <option value="<?php echo $orgvalue["id"]; ?>"><?php echo $orgvalue["organisation_name"] ?></option>   
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('organisation'); ?></span>
                                    </div>
                                </div>
                            </div><!--./row-->   
                            <button type="submit" class="btn btn-info pull-right" >Save</button>
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
    function addpaymentModal() {
        var total = $("#charge_total").val();
        var patient_id = '<?php echo $result["id"] ?>';
        $("#total").val(total);
        $("#payment_patient_id").val(patient_id);
    }
    $(document).ready(function (e) {
        var date_format = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(), ['d' => 'DD', 'm' => 'MM', 'Y' => 'YYYY',]) ?>';
        $('#charge_date').datepicker();
    });

    function getRecord(id) {
        $.ajax({
            url: '<?php echo base_url(); ?>admin/patient/getDetails',
            type: "POST",
            data: {recordid: id},
            dataType: 'json',
            success: function (data) {
                $("#patient_id").html(data.patient_unique_id);
                $("#patient_name").html(data.patient_name);
                $("#contact").html(data.mobileno);
                $("#email").html(data.email);
                $("#age").html(data.age);
                $("#month").html(data.month);
                $("#guardian_name").html(data.guardian_name);
                $("#appointment_date").html(data.appointment_date);
                $("#case").html(data.case_type);
                $("#symptoms").html(data.symptoms);
                $("#known_allergies").html(data.known_allergies);
                $("#refference").html(data.refference);
                $("#cons_doctor").html(data.name);
                $("#amount").html(data.amount);
                $("#tax").html(data.tax);
                $("#payment_mode").html(data.payment_mode);
                $("#opdid").val(data.opdid);
                $("#address").val(data.address);
                $("#note").val(data.note);
                $("#updateid").val(id);
            },
        });
    }
    function getEditRecord(id) {
        $.ajax({
            url: '<?php echo base_url(); ?>admin/patient/getIpdDetails',
            type: "POST",
            data: {recordid: id},
            dataType: 'json',
            success: function (data) {
                $("#patientid").val(data.patient_unique_id);
                $("#patient_names").val(data.patient_name);
                $("#contacts").val(data.mobileno);
                $("#emails").val(data.email);
                $("#ages").val(data.age);
                $("#months").val(data.month);
                $("#bloodgroups").val(data.blood_group);
                $("#guardian_names").val(data.guardian_name);
                $("#updateid").val(id);
                $('select[id="genders"] option[value="' + data.gender + '"]').attr("selected", "selected");
                $('select[id="marital_statuss"] option[value="' + data.marital_status + '"]').attr("selected", "selected");
                $('select[id="organisations"] option[value="' + data.organisation + '"]').attr("selected", "selected");
            },
        });
    }
    $(document).ready(function (e) {
        $("#formeditrecord").on('submit', (function (e) {
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

    function editRecord(id, opdid) {
        $.ajax({
            url: '<?php echo base_url(); ?>admin/patient/opd_details',
            type: "POST",
            data: {recordid: id, opdid: opdid},
            dataType: 'json',
            success: function (data) {
                $("#patientid").val(data.patient_unique_id);
                $("#patientname").val(data.patient_name);
                $("#appointmentdate").val(data.appointment_date);
                $("#edit_case").val(data.case_type);
                $("#edit_symptoms").val(data.symptoms);
                $("#edit_casualty").val(data.casualty);
                $("#edit_knownallergies").val(data.known_allergies);
                $("#edit_refference").val(data.refference);
                $("#edit_consdoctor").val(data.cons_doctor);
                $("#edit_amount").val(data.amount);
                $("#edit_tax").val(data.tax);
                $("#edit_paymentmode").val(data.payment_mode);
                $("#edit_opdid").val(opdid);
            },
        });
    }

    $(document).ready(function (e) {
        $("#add_payment").on('submit', (function (e) {
            e.preventDefault();
            $.ajax({
                url: '<?php echo base_url(); ?>admin/payment/create',
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
                }, error: function () {}
            });
        }));
    });


    $(document).ready(function (e) {
        $("#formedit").on('submit', (function (e) {
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
                }, error: function () {}
            });
        }));
    });
    $(document).ready(function (e) {
        $("#add_charges").on('submit', (function (e) {
            e.preventDefault();
            $.ajax({
                url: '<?php echo base_url(); ?>admin/charges/add_ipdcharges',
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
                error: function () {}
            });
        }));
    });
    $(document).ready(function (e) {
        $("#form_prescription").on('submit', (function (e) {
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
                },
                error: function () {}
            });
        }));
    });
    $(document).ready(function (e) {
        $("#form_diagnosis").on('submit', (function (e) {
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
                        errorMsg(message);
                    } else {
                        successMsg(data.message);
                        window.location.reload(true);
                    }
                },
                error: function () {}
            });
        }));
    });
    function add_more() {
        var div = "<div id=row1><div class=col-sm-4><div class=form-group><label>Medicine --r :</label><input type=text name='medicine[]' class=form-control id=report_type /></div></div><div class=col-sm-4><div class=form-group><label >Dosage --r :</label><input type=text class=form-control name='dosage[]' id=report_document /></div></div><div class=col-sm-4><div class=form-group><label>Instruction --r :</label><textarea name='instruction[]' class=form-control id=description></textarea></div></div></div>";
        var table = document.getElementById("tableID");
        var table_len = (table.rows.length);
        var id = parseInt(table_len);
        var row = table.insertRow(table_len).outerHTML = "<tr id='row" + id + "'><td>" + div + "</td><td><button type='button' onclick='delete_row(" + id + ")' class='closebtn'><i class='fa fa-remove'></i></button></td></tr>";
    }
    function delete_row(id) {
        var table = document.getElementById("tableID");
        var rowCount = table.rows.length;
        $("#row" + id).html("");
        //table.deleteRow(id);
    }
    $(document).ready(function (e) {
        $("#add_timeline").on('submit', (function (e) {
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

                },
                error: function (e) {
                    alert("Fail");
                    console.log(e);
                }
            });
        }));
    });

    $(document).ready(function (e) {
        $("#add_bill").on('submit', (function (e) {
            e.preventDefault();
            $.ajax({
                url: "<?php echo site_url("admin/payment/addbill") ?>",
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
                error: function (e) {
                    alert("Fail");
                    console.log(e);
                }
            });
        }));
    });


    function delete_timeline(id) {
        var patient_id = $("#patient_id").val();
        if (confirm('<?php echo $this->lang->line("delete_confirm") ?>')) {
            $.ajax({
                url: '<?php echo base_url(); ?>admin/timeline/delete_patient_timeline/' + id,
                success: function (res) {
                    $.ajax({
                        url: '<?php echo base_url(); ?>admin/timeline/patient_timeline/' + patient_id,
                        success: function (res) {
                            $('#timeline_list').html(res);
                        },
                        error: function () {
                            alert("Fail")
                        }
                    });
                }, error: function () {
                    alert("Fail")
                }
            });
        }
    }
    $(document).ready(function (e) {

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

        var date_format = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(), ['d' => 'dd', 'm' => 'mm', 'Y' => 'yyyy',]) ?>';
        $('#timeline_date,#date').datepicker({
            format: date_format,
            autoclose: true
        });
    });
    function view_prescription(id, opdid) {
        $.ajax({
            url: '<?php echo base_url(); ?>admin/prescription/getPrescription/' + id + '/' + opdid,
            success: function (res) {
                $("#getdetails_prescription").html(res);
            },
            error: function () {
                alert("Fail")
            }
        });
    }
    function getcharge_category(id) {
        var div_data = "";
        $("#charge_category").html("<option value=''>Select</option>");
        $.ajax({
            url: '<?php echo base_url(); ?>admin/charges/get_charge_category',
            type: "POST",
            data: {charge_type: id},
            dataType: 'json',
            success: function (res) {
                $.each(res, function (i, obj)
                {
                    var sel = "";
                    div_data += "<option value=" + obj.name + ">" + obj.name + "</option>";
                });
                $('#charge_category').append(div_data);
            }
        });
    }
    function get_Charges(charge_category, orgid) {
        $("#standard_charge").html("standard_charge");
        $("#schedule_charge").html("schedule_charge");
        $.ajax({
            url: '<?php echo base_url(); ?>admin/patient/ipdCharge',
            type: "POST",
            data: {charge_category: charge_category, organisation_id: orgid},
            dataType: 'json',
            success: function (res) {
                if (res) {
                    $('#standard_charge').val(res.standard_charge);
                    $('#schedule_charge').val(res.org_charge);
                    $('#charge_id').val(res.id);
                    $('#org_id').val(res.org_charge_id);

                    if (res.org_charge == null) {
                        $('#apply_charge').val(res.standard_charge);
                    } else {
                        $('#apply_charge').val(res.org_charge);
                    }
                } else {
                    $('#standard_charge').val('0');
                    $('#schedule_charge').val('0');
                    $('#charge_id').val('0');
                    $('#org_id').val('0');
                }
            }
        });
    }

    function calculate() {

        var total_amount = $("#total_amount").val();
        var discount = $("#discount").val();
        var other_charge = $("#other_charge").val();
        //var gross_total = $("#gross_total").val();
        var tax = $("#tax").val();
        // var net_amount = $("#net_amount").val();
        var gross_total = parseInt(total_amount) + parseInt(other_charge) + parseInt(tax);
        var net_amount = parseInt(total_amount) + parseInt(other_charge) + parseInt(tax) - parseInt(discount);
        $("#gross_total").val(gross_total);
        $("#net_amount").val(net_amount);
        $("#save_button").show();
    }

    function revert(patient_id, billid) {

        // window.location.reload(true);
        // $( "#tabs" ).tabs({ active: 'charges' });
        $.ajax({
            url: '<?php echo base_url(); ?>admin/patient/revertBill',
            type: "POST",
            data: {patient_id: patient_id, bill_id: billid},
            dataType: 'json',
            success: function (res) {
                if (res.status == "fail") {
                    var message = "";
                    errorMsg(res.message);
                } else {
                    successMsg(res.message);
                    window.location.reload(true);
                }
            }
        });
    }

    // function getCharges(charge_id){
    //     $.ajax({
    //         url: '<?php echo base_url(); ?>admin/patient/ipdCharge',
    //         type: "POST",     
    //         data: {charge_id:id}, 
    //                                                                          //dataType: 'json',
    //         success: function (data) {
    //             $("#std_charge").val(data.standard_charge);
    //             $("#org_charge").val(data.org_charge);
    //         },
    //     });
    // }
</script>
<script type="text/javascript">
    function print(patientid, ipdid) {
        var base_url = '<?php echo base_url() ?>';
        $.ajax({
            url: base_url + 'admin/payment/getBill/',
            type: 'POST',
            data: {patient_id: patientid, ipdid: ipdid},
            success: function (result) {
                $("#testdata").html(result);
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
</script>