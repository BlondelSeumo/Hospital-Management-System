<?php
$currency_symbol = $this->customlib->getSchoolCurrencyFormat();
$genderList = $this->customlib->getGender();
?>
<div class="content-wrapper">
    <section class="content">
        <div class="box box-primary">
            <div class="row">
                <div class="box-body pb0">
                    <?php
                    if (!isset($result)) {
                        echo "<center><h4>" . $this->lang->line("no_record_found") . "</h4></center>";
                    } else {
                        ?>
                        <div class="box-tools pull-right" style="margin-right: 10px;">

                            <a  href="<?php echo base_url() ?>patient/dashboard/patientipddetails" class="btn btn-primary btn-sm"><i class="fa fa-reorder"></i> <?php echo $this->lang->line('discharged') . " " . $this->lang->line('details'); ?></a> 
                        </div>    
                        <div class="col-lg-2 col-md-2 col-sm-3 text-center">
                            <?php
                            $image = $result['image'];
                            if (!empty($image)) {
                                $file = $result['image'];
                            } else {
                                $file = "uploads/patient_images/no_image.png";
                            }
                            ?>
                            <img width="115" height="115" class="" src="<?php echo base_url() . $file ?>" alt="No Image">
                            <div class="editviewdelete-icon pt8">
                                <a class="" href="#" onclick="getRecord('<?php echo $result['id'] ?>', '<?php echo $ipdid ?>')"   data-toggle="tooltip" title="<?php echo $this->lang->line('profile'); ?>"><i class="fa fa-reorder"></i>
                                </a>
                            </div> 
                        </div>

                        <div class="col-md-10">
                            <table class="table table-striped mb0 font13">
                                <tbody>
                                    <tr>
                                        <th class="bozerotop"><?php echo $this->lang->line('name'); ?></th>
                                        <td class="bozerotop"><?php echo $result['patient_name']; ?></td>
                                        <th class="bozerotop"><?php echo $this->lang->line('guardian_name'); ?></th>
                                        <td class="bozerotop"><?php echo $result['guardian_name']; ?></td>
                                    </tr>
                                    <tr>
                                        <th class="bozerotop"><?php echo $this->lang->line('gender'); ?></th>
                                        <td class="bozerotop"><?php echo $result['gender']; ?></td>
                                        <th class="bozerotop"><?php echo $this->lang->line('age'); ?></th>
                                        <td class="bozerotop">
                                            <?php
                                            if (!empty($result['age'])) {
                                                echo $result['age'] . " " . $this->lang->line('year') . " ";
                                            } if (!empty($result['month'])) {
                                                echo $result['month'] . " " . $this->lang->line('month');
                                            }
                                            ?>   
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bozerotop"><?php echo $this->lang->line('phone'); ?></th>
                                        <td class="bozerotop"><?php echo $result['mobileno']; ?></td>
                                        <th class="bozerotop"><?php echo $this->lang->line('credit_limit') . " (" . $currency_symbol . ")";
                                            ?></th>
                                        <td class="bozerotop"><?php echo $result['ipdcredit_limit']; ?>
                                        </td>

                                    </tr>
                                    <tr>
                                        <th class="bozerotop"><?php echo $this->lang->line('patient') . " " . $this->lang->line('id'); ?></th>
                                        <td class="bozerotop"><?php echo $result['patient_unique_id']; ?></td>
                                        <th class="bozerotop"><?php echo $this->lang->line('ipd_no'); ?></th>
                                        <td class="bozerotop">
                                            <?php
                                            echo $result['ipd_no'];
                                            if ($result['ipd_discharge'] == 'yes') {
                                                echo " <span class='label label-warning'>" . $this->lang->line("discharged") . "</span>";
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bozerotop"><?php echo $this->lang->line('admission_date');
                                            ?></th>
                                        <td class="bozerotop"><?php echo date($this->customlib->getSchoolDateFormat(true, true), strtotime($result['date'])); ?>
                                        </td>
                                        <th class="bozerotop"><?php echo $this->lang->line('bed');
                                            ?></th>
                                        <td class="bozerotop"><?php echo $result['bed_name'] . " - " . $result['bedgroup_name'] . " - " . $result['floor_name']; ?>
                                        </td>

                                    </tr>   
                                    <?php if ($result["ipd_discharge"] != "no") { ?>
                                        <tr>
                                            <th class="bozerotop"><?php echo $this->lang->line('discharged') . " " . $this->lang->line('date');
                                        ?></th>
                                            <td class="bozerotop"><?php echo date($this->customlib->getSchoolDateFormat($result['discharge_date'])); ?>
                                            </td>     
                                        </tr>    
                                    <?php } ?>          
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>



                <div>

                    <div class="box border0">

                        <div style="background: #dadada; height: 1px; width: 100%; clear: both; margin-top:5px;"></div>
                        <div class="nav-tabs-custom border0" id="tabs">
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#consultant_register"  data-toggle="tab" aria-expanded="true"><i class="fas fa-file-prescription"></i> <?php echo $this->lang->line('consultant') . " " . $this->lang->line('register'); ?></a>
                                </li>
                                <li>
                                    <a href="#diagnosis" data-toggle="tab" aria-expanded="true"><i class="fas fa-diagnoses"></i> <?php echo $this->lang->line('diagnosis'); ?></a>
                                </li>
                                <li>
                                    <a href="#timeline" data-toggle="tab" aria-expanded="true"><i class="far fa-calendar-check"></i> <?php echo $this->lang->line('timeline'); ?></a>
                                </li>
                                <li>
                                    <a href="#prescription" data-toggle="tab" aria-expanded="true"><i class="far fa-calendar-check"></i> <?php echo $this->lang->line('prescription'); ?></a>
                                </li>
                                <li>
                                    <a href="#charges" data-toggle="tab" aria-expanded="true"><i class="fas fa-donate"></i> <?php echo $this->lang->line('charges'); ?></a>
                                </li>
                                <li>
                                    <a href="#payment" data-toggle="tab" aria-expanded="true"><i class="fas fa-hand-holding-usd"></i> <?php echo $this->lang->line('payment'); ?></a>
                                </li>
                                <li>
                                    <a href="#bill" class="bill" data-toggle="tab" aria-expanded="true"><i class="fas fa-file-invoice-dollar"></i> <?php echo $this->lang->line('bill'); ?></a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <?php
                                $charge_total = 0;
                                $bill_amount = 0;
                                foreach ($charges as $charge) {
                                    $charge_total += $charge["apply_charge"];
                                    $bill_amount = $charge_total - $paid_amount;
                                }
                                ?>   <?php if (($bill_amount != 0) && ($bill_amount >= $result["ipdcredit_limit"])) { ?>
                                    <div class="alert alert-info"><?php echo $this->lang->line('patient_bill_amount_limit'); ?></div>
                                <?php } ?>
                                <div class="tab-pane" id="activity">
                                    <div class="download_label"><?php echo $this->lang->line('consultant') . " " . $this->lang->line('register'); ?></div>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover example " cellspacing="0" width="100%">
                                            <thead>
                                            <th><?php echo $this->lang->line('consultant'); ?></th>
                                            <th><?php echo $this->lang->line('appointment') . " " . $this->lang->line('date'); ?></th>
                                            <th><?php echo $this->lang->line('case'); ?></th>
                                            <th><?php echo $this->lang->line('symptoms'); ?></th>
                                            <th><?php echo $this->lang->line('refference'); ?></th>
                                            <th class="text-right"><?php echo $this->lang->line('action') ?></th>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (!empty($opd_details)) {
                                                    foreach ($opd_details as $key => $value) {
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $value["name"] . " " . $value["surname"]; ?></td>
                                                            <td><?php echo date($this->customlib->getSchoolDateFormat(true, true), strtotime($value['appointment_date'])); ?></td>
                                                            <td><?php echo $value['case_type']; ?></td>
                                                            <td><?php echo $value['symptoms']; ?></td>
                                                            <td><?php echo $value['refference']; ?></td>
                                                            <td class="pull-right">
                                                                <a href="#" onclick="getRecord('<?php echo $result["id"]; ?>')" data-toggle="modal"><i class="fa fa-reorder"></i>
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
                                <div class="tab-pane active" id="consultant_register">
                                    <div class="download_label"><?php echo $this->lang->line('diagnosis'); ?></div>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover example ">
                                            <thead>
                                            <th><?php echo $this->lang->line('date'); ?></th>
                                            <th><?php echo $this->lang->line('doctor'); ?></th>
                                            <th><?php echo $this->lang->line('instruction'); ?></th>
                                            <th><?php echo $this->lang->line('instruction') . " " . $this->lang->line('date'); ?></th>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (!empty($consultant_register)) {
                                                    foreach ($consultant_register as $consultant_key => $consultant_value) {
                                                        ?>
                                                        <tr>
                                                            <td><?php echo date($this->customlib->getSchoolDateFormat(true, true), strtotime($consultant_value["date"])); ?></td>
                                                            <td><?php echo $consultant_value["name"]; ?></td>
                                                            <td><?php echo $consultant_value["instruction"]; ?></td>
                                                            <td><?php echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($consultant_value['ins_date'])); ?></td>
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
                                        <table class="table table-striped table-bordered table-hover ">
                                            <thead>
                                            <th><?php echo $this->lang->line('report') . " " . $this->lang->line('type'); ?></th>
                                            <th><?php echo $this->lang->line('report') . " " . $this->lang->line('date'); ?></th>
                                            <th><?php echo $this->lang->line('description'); ?></th>
                                            <th><?php echo $this->lang->line('action'); ?></th>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (!empty($diagnosis_detail)) {
                                                    foreach ($diagnosis_detail as $diagnosis_key => $diagnosis_value) {
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $diagnosis_value["report_type"]; ?></td>
                                                            <td><?php echo date($this->customlib->getSchoolDateFormat(), strtotime($diagnosis_value['report_date'])); ?></td>
                                                            <td><?php echo $diagnosis_value["description"]; ?></td>
                                                            <td>
                                                                <?php if (!empty($diagnosis_value["document"])) { ?>
                                                                    <a class="btn btn-default btn-xs" href="<?php echo base_url() . "patient/dashboard/report_download/" . $diagnosis_value["document"] ?>" ><i class="fa fa-download"></i></a>
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
                                                                ?>
                                                            </span>
                                                        </li>
                                                        <li>
                                                            <i class="fa fa-list-alt bg-blue"></i>
                                                            <div class="timeline-item">

                                                                <?php if (!empty($value["document"])) { ?>
                                                                    <span class="time"><a class="defaults-c text-right" data-toggle="tooltip" title="" href="<?php echo base_url() . "patient/dashboard/report_download/" . $value["id"] . "/" . $value["document"] ?>" data-original-title="Download"><i class="fa fa-download"></i></a></span>
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
                                            <th><?php echo $this->lang->line('ipd_no') ; ?></th>
                                            <th><?php echo $this->lang->line('date'); ?></th>
                                            
                                            <th class="text-right"><?php echo $this->lang->line('action'); ?></th>
                                            </thead>
                                            <tbody>
                                                 <?php
                                                if (!empty($prescription_detail)) {
                                                    foreach ($prescription_detail as $prescription_key => $prescription_value) {
                                                        ?>  
                                                        <tr>
                                                            <td><?php echo $result["ipd_no"] ?></td>
                                                            <td><?php echo date($this->customlib->getSchoolDateFormat(), strtotime($prescription_value['date'])) ?></td>

                                                            <td class="text-right">
                                                                <a href="#prescription" class="btn btn-default btn-xs" onclick="view_prescription('<?php echo $prescription_value["id"] ?>', '<?php echo $prescription_value["id"] ?>', '<?php echo "yes" ?>')"   data-toggle="tooltip" title="<?php echo $this->lang->line('view') . " " . $this->lang->line('prescription'); ?>">
                                                                    <i class="fas fa-file-prescription"></i>
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
                                </div>
                                <!--Charges-->
                                <div class="tab-pane" id="charges">
                                    <div class="download_label"><?php echo $this->lang->line('charges'); ?></div>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover example ">
                                            <thead>
                                            <th><?php echo $this->lang->line('date'); ?></th>
                                            <th><?php echo $this->lang->line('charge_type'); ?></th>
                                            <th><?php echo $this->lang->line('charge_category'); ?></th>
                                            <th><?php echo $this->lang->line('standard') . " " . $this->lang->line('charge') . ' (' . $currency_symbol . ')'; ?> </th>
                                            <th><?php echo $this->lang->line('organisation') . " " . $this->lang->line('charge') . ' (' . $currency_symbol . ')'; ?> </th>
                                            <th class="text-right"><?php echo $this->lang->line('apply') . " " . $this->lang->line('charge') . ' (' . $currency_symbol . ')'; ?> </th>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $total = 0;
                                                if (!empty($charges)) {

                                                    foreach ($charges as $charge) {

                                                        $total += $charge["apply_charge"];
                                                        ?>
                                                        <tr>
                                                            <td><?php echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($charge["date"])); ?></td>
                                                            <td><?php echo $charge["charge_type"]; ?></td>
                                                            <td><?php echo $charge["charge_category"]; ?></td>
                                                            <td><?php echo $charge["standard_charge"]; ?></td>
                                                            <td><?php echo $charge["org_charge"] ?></td>
                                                            <td class="text-right"><?php echo $charge["apply_charge"] ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                <?php } ?>
                                            </tbody>
                                            <tr class="box box-solid total-bg">
                                                <td colspan='6' class="text-right"><?php echo $this->lang->line('total') . " : " . $total; ?><input type="hidden" id="charge_total" name="charge_total" value="<?php echo $total ?>">
                                                </td>
                                            </tr>
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
                                                        <th width="16%" ><?php echo $this->lang->line('category'); ?></th>
                                                        <th width="19%"><?php echo $this->lang->line('date'); ?></th>
                                                        <th width="16%" class="pttright reborder"><?php echo $this->lang->line('amount') . ' (' . $currency_symbol . ')'; ?> </th>
                                                    </tr>
                                                    <?php
                                                    $j = 0;
                                                    $total = 0;
                                                    foreach ($charges as $key => $charge) {
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $charge["charge_type"]; ?></td>
                                                            <td><?php echo $charge["charge_category"]; ?></td>
                                                            <td><?php echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($charge["created_at"])); ?></td>
                                                            <td class="pttright reborder"><?php echo $charge["apply_charge"]; ?></td>
                                                        </tr>


                                                        <?php
                                                        $total += $charge["apply_charge"];
                                                        ?>

                                                        <?php
                                                        $j++;
                                                    }
                                                    ?>
                                                    <tr class="box box-solid total-bg">
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td class="text-right"><?php echo $this->lang->line('total') . " : "; ?><?php echo $total; ?></td>

                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <h4 class="box-title mt0"><?php echo $this->lang->line('payment'); ?></h4>
                                            <div class="table-responsive" style="border: 1px solid #dadada;border-radius: 2px; padding: 10px;">
                                                <table class="earntable table table-striped table-responsive" >
                                                    <tr>
                                                        <th width="20%" class="pttleft bozerotop"><?php echo $this->lang->line('payment') . " " . $this->lang->line('mode'); ?></th>
                                                        <th width="16%" class="bozerotop"><?php echo $this->lang->line('payment') . " " . $this->lang->line('date'); ?></th>
                                                        <th width="16%" class="text-right bozerotop"><?php echo $this->lang->line('paid') . " " . $this->lang->line('amount') . ' (' . $currency_symbol . ')'; ?> </th>
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
                                                    <tr class="box box-solid total-bg">
                                                        <td></td>
                                                        <td></td>
                                                        <td class="text-right"><?php echo $this->lang->line('total') . " : "; ?><?php echo $total_paid; ?></td>

                                                    </tr>
                                                </table>

                                            </div>

                                            <h4 class="box-title ptt10"><?php echo $this->lang->line('bill') . " " . $this->lang->line('summary'); ?></h4> 
                                            <div class="table-responsive" style="border: 1px solid #dadada;border-radius: 2px; padding: 10px;">  
                                                <table class="nobordertable table table-striped table-responsive">
                                                    <form method="post" id="add_bill"  enctype="multipart/form-data">
                                                        <?php //if ($result['status'] != 'paid') {    ?>
                                                        <tr>
                                                            <th><?php echo $this->lang->line('total') . " " . $this->lang->line('charges') . " (" . $currency_symbol . ")" ?></th>
                                                            <td class="text-right fontbold20"><?php echo $total; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th><?php echo $this->lang->line('total') . " " . $this->lang->line('payment') . " (" . $currency_symbol . ")"; ?></th> 
                                                            <td class="text-right fontbold20"><?php echo $paid_amount; ?>
                                                                <input type="hidden" value="<?php echo $total ?>" id="total_amount" name="total_amount" style="width: 30%" class="form-control">
                                                                <input type="hidden" value="<?php echo $result['bed'] ?>" id="bed_no" name="bed_no" style="width: 30%; float: right" class="form-control">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th><?php echo $this->lang->line('gross') . " " . $this->lang->line('total') . " (" . $this->lang->line('balance') . " " . $this->lang->line('amount') . ")" . " (" . $currency_symbol . ")"; ?></th>
                                                            <td class="text-right fontbold20"><?php echo $total - $paid_amount; ?>
                                                                <input type="hidden"  id="gross_total" value="<?php echo $total - $paid_amount ?>" name="gross_total" style="width: 30%; float: right" class="form-control">
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <th><?php echo $this->lang->line('discount'); ?></th>
                                                            <td class="text-right ipdbilltable fontbold20">
                                                                <input type="hidden" name="patient_id" value="<?php echo $result["id"] ?>">
                                                                <span><?php
                                                                    if (!empty($result["discount"])) {
                                                                        echo $result["discount"];
                                                                    } else {
                                                                        echo "0";
                                                                    }
                                                                    ?> </span>
                                                                <input type="hidden" id="discount" value="<?php
                                                                if (!empty($result["discount"])) {
                                                                    echo $result["discount"];
                                                                } else {
                                                                    echo "0";
                                                                }
                                                                ?>" name="discount" style="width: 30%; float: right;" class="form-control"></td>
                                                        </tr>
                                                        <tr>
                                                         <th><?php echo $this->lang->line('any_other_charges'); ?></th>
                                                            <td class="text-right ipdbilltable fontbold20"><input type="hidden"   id="other_charge" value="<?php
                                                                if (!empty($result["other_charge"])) {
                                                                    echo $result["other_charge"];
                                                                } else {
                                                                    echo "0";
                                                                }
                                                                ?>" name="other_charge" style="width: 30%; float: right;" class="form-control"><span><?php
                                                                                                                  if (!empty($result["other_charge"])) {
                                                                                                                      echo $result["other_charge"];
                                                                                                                  } else {
                                                                                                                      echo "0";
                                                                                                                  }
                                                                                                                  ?> <td>
                                                        </tr>
                                                        <tr><th><?php echo $this->lang->line('tax'); ?></th>
                                                            <td class="text-right ipdbilltable fontbold20"><input type="hidden"  name="tax" value="<?php
                                                                                                                  if (!empty($result["tax"])) {
                                                                                                                      echo $result["tax"];
                                                                                                                  } else {
                                                                                                                      echo "0";
                                                                                                                  }
                                                                                                                  ?>" id="tax" style="width: 30%;float: right" class="form-control"><span><?php
                                                                                                                  if (!empty($result["tax"])) {
                                                                                                                      echo $result["tax"];
                                                                                                                  } else {
                                                                                                                      echo "0";
                                                                                                                  }
                                                                                                                  ?></span>   
                                                            </td>
                                                        </tr>
                           <tr>
                        <th><?php echo $this->lang->line('net_amount'); ?></th>
                        <td class="text-right ipdbilltable fontbold20"><input type="hidden" readonly name="net_amount" value="<?php
  if (!empty($result["net_amount"])) {
                                          echo $result["net_amount"];
                                      } else {
                                          echo $total - $paid_amount;
                                      }
                                      ?>" id="net_amount" style="width: 30%;float: right" class="form-control"><span>
                                        <?php
                                                if (!empty($result["net_amount"])) {
                                                    echo $result["net_amount"];
                                                } else {
                                                    echo $total - $paid_amount;
                                                }
                                                ?></span>
                                                            </td>
                                                        </tr>
    <?php //}    ?>
                                                </table>
                                                <a href="#" class="btn btn-info" onclick="print('<?php echo $result["id"] ?>', '<?php echo $ipdid ?>')"><?php echo $this->lang->line('print') . " " . $this->lang->line('bill'); ?></a>
                                        <?php if ($result['status'] != 'paid') { ?>
                                        <?php } ?>
                                            </div>   
                                        </div>
                                    </div><!--./row--> 
                                    </form>
                                </div>

                                <div class="tab-pane" id="payment">
                                    <div class="download_label"><?php echo $this->lang->line('payment'); ?></div>
                                    <div class="impbtnview">
    <?php
    if (!empty($payment_method) && $result['status'] != 'paid' ) {
        ?>
        <?php if ($result["is_active"] == 'yes') { ?>
                                                <button type="button" class="btn btn-info" data-result_id="<?php echo $result['ipdid'] ?>" data-toggle="modal" data-target="#payMoney"><i class="fa fa-plus"></i> <?php echo $this->lang->line('make_payment'); ?></button>
        <?php } ?>
        <?php
    }
    ?>

                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover example">
                                            <thead>
                                            <th><?php echo $this->lang->line('date'); ?></th>
                                            <th><?php echo $this->lang->line('note'); ?></th>
                                            <th><?php echo $this->lang->line('payment') . " " . $this->lang->line('mode'); ?></th>
                                            <th class="text-right"><?php echo $this->lang->line('paid') . " " . $this->lang->line('amount') . " (" . $currency_symbol . ")"; ?></th>
                                           <!--  <th>Balance Amount --r </th> -->

                                       <!--  <th><?php echo $this->lang->line('action') ?></th> -->
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
                                                            <td class="text-right"><?php echo $payment["paid_amount"] ?></td>

                                                        </tr>
                                                <?php } ?>
                                                    <tr class="box box-solid total-bg">

                                                        <td></td>
                                                        <td></td>
                                                        <td></td>

                                                        <td  class="text-right"><?php echo $this->lang->line('total') . " : " . $total; ?>
                                                        </td>
                                                    </tr>
                                                </tbody>

    <?php } ?>
                                        </table>
                                    </div>
                                </div>
                                <!-- Bill payment -->
                            </div>
                        </div>
<?php } ?>
                </div>
            </div> <!-- /.box-body -->
        </div><!--./box box-primary-->

    </section>
</div>

<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="box-title"><?php echo $this->lang->line('patient') . " " . $this->lang->line('information'); ?></h4> 
            </div>
            <div class="modal-body pt0 pb0">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 paddlr">
                        <form id="formrevisit"   accept-charset="utf-8"  enctype="multipart/form-data" method="post" class="ptt10">
                            <div class="row">
                                <table class="table mb0 table-striped table-bordered ">
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
                                        <th width="15%"><?php echo $this->lang->line('admission') . " " . $this->lang->line('date'); ?></th>
                                        <td width="35%"><span id="admission_date"></span>
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
                                        <th width="15%"><?php echo $this->lang->line('bed') . " " . $this->lang->line('group'); ?></th>
                                        <td width="35%"><span id="bed_group"></span>
                                        </td>
                                        <th width="15%"><?php echo $this->lang->line('bed') . " " . $this->lang->line('number'); ?></th>
                                        <td width="35%"><span id='bed_name'></span></td>
                                    </tr>

                                </table>
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
                <h4 class="box-title"><?php echo $this->lang->line('prescription'); ?></h4>
            </div>
            <div class="modal-body pt0 pb0" id="getdetails_prescription"></div>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="payMoney" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('make_payment') ?></h4>
            </div>
            <form class="form-horizontal modal_payment" action="<?php echo site_url('patient/pay'); ?>" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="record_id" value="0" id="record_id">
                    <input type="hidden" name="record_ipdid" value="0" id="record_ipdid">
                    <div class="form-group">
                        <label for="amount" class="col-sm-3 control-label"><?php echo $this->lang->line('payment') . " " . $this->lang->line('amount') ?></label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" name="deposit_amount" id="amount_total_paid" >
                            <span id="deposit_amount_error" class="text text-danger"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info pull-right"><?php echo $this->lang->line('add') ?></button>
                </div>
            </form>
        </div>

    </div>
</div>

<script type="text/javascript">
    function getRecord(id, ipdid) {

        var active = '<?php echo $result["is_active"] ?>';
        $.ajax({
            url: '<?php echo base_url(); ?>patient/dashboard/getIpdDetails',
            type: "POST",
            data: {recordid: id, ipdid: ipdid, active: active},
            dataType: 'json',
            success: function (data) {

                $("#patients_id").html(data.patient_unique_id);
                $("#patient_name").html(data.patient_name);
                $("#contact").html(data.mobileno);
                $("#email").html(data.email);
                var age = '';
                var month = '';
                if (data.age != '') {
                    age = data.age + ' Year ';
                }

                if (data.month != '') {
                    month = data.month + ' Month ';
                }
                $("#age").html(age + month);
                $("#gen").html(data.gender);

                $("#guardian_name").html(data.guardian_name);
                $("#admission_date").html(data.date);
                $("#case").html(data.case_type);
                $("#casualty").html(data.casualty);
                $("#symptoms").html(data.symptoms);
                $("#known_allergies").html(data.known_allergies);
                $("#refference").html(data.refference);
                $("#doc").html(data.name + ' ' + data.surname);
                $("#amount").html(data.amount);
                $("#tax").html(data.tax);
                $("#height").html(data.height);
                $("#weight").html(data.weight);
                $("#patient_bp").html(data.bp);
                $("#blood_group").html(data.blood_group);
                $("#old_patient").html(data.old_patient);
                $("#payment_mode").html(data.payment_mode);
                $("#organisation").html(data.organisation_name);
                $("#opdid").val(data.opdid);
                $("#patient_address").html(data.address);
                $("#marital_status").html(data.marital_status);
                $("#note").val(data.note);
                $("#bed_group").html(data.bedgroup_name + '-' + data.floor_name);
                $("#bed_name").html(data.bed_name);
                $("#updateid").val(id);
                holdModal('viewModal');
            },
        });
    }


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

    function view_prescription(id, ipdid) {
        $.ajax({
            url: '<?php echo base_url(); ?>patient/prescription/getIPDPrescription/' + id + '/' + ipdid,
            success: function (res) {
                $("#getdetails_prescription").html(res);
            },
            error: function () {
                alert("Fail")
            }
        });
        holdModal('prescriptionview');
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
</script>
<script type="text/javascript">
    function print(patientid, ipdid) {
        var total_amount = $("#total_amount").val();
        var discount = $("#discount").val();
        var other_charge = $("#other_charge").val();
        var gross_total = $("#gross_total").val();
        var tax = $("#tax").val();
        var net_amount = $("#net_amount").val();
        var base_url = '<?php echo base_url() ?>';
        $.ajax({
            url: base_url + 'patient/dashboard/ipdBill/',
            type: 'POST',
            data: {patient_id: patientid, ipdid: ipdid, total_amount: total_amount, discount: discount, other_charge: other_charge, gross_total: gross_total, tax: tax, net_amount: net_amount},
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
    function holdModal(modalId) {
        $('#' + modalId).modal({
            backdrop: 'static',
            keyboard: false,
            show: true
        });
    }
    ;


        // $('#payMoney').on('show.bs.modal', function (e)  {
        //     alert("Helloooo");
        //      $("form.modal_payment").trigger("reset");
        //     $("span[id$='_error']").text("");
        //     var ipdid = $(e.relatedTarget).data('result_id');
        //     $("form.modal_payment input[id='record_id']").val(ipdid);
        
        //     $.ajax({
        //     url: '<?php echo base_url(); ?>patient/dashboard/getpatientidbyipd',
        //     type: "POST",
        //     data: {'ipdid': ipdid},
        //     dataType: 'json',
        //     success: function (data) {
        //     var patientid = data.id
        //     $.ajax({
        //             url: baseurl + 'patient/pay/calculate',
        //             type: 'POST',
        //             data: {'id': patientid},
        //             dataType: 'JSON',
        //             success: function (result) {

        //                 $('#amount_total_paid').val(result.amount);
        //             }
        //         });

        //      }
           
        // });
                
        // } 

    $('#payMoney').on('show.bs.modal', function (e) {
        $("form.modal_payment").trigger("reset");
        $("span[id$='_error']").text("");
        var id = $(e.relatedTarget).data('result_id');
        //alert(id)
        $("form.modal_payment input[id='record_id']").val(id);
        // $("form.modal_payment input[id='record_ipdid']").val(ipdid);
        $.ajax({
            url: baseurl + 'patient/pay/calculate',
            type: 'POST',
            data: {'ipdid': id},
            dataType: 'JSON',
            success: function (result) {

                $('#amount_total_paid').val(result.amount);
            }
        });

    });


    // this is the id of the form
    $("form.modal_payment").submit(function (e) {


        var form = $(this);
        var url = form.attr('action');

        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(), // serializes the form's elements.
            dataType: 'JSON',
            success: function (data)
            {
                if (data.status == 0) {

                    $.each(data.error, function (key, val) {

                        $("#" + key + "_error").text(val);
                    });
                }
                if (data.status == 1) {
                    window.location.href = baseurl + "patient/pay/billpayment";
                }
            }
        });

        e.preventDefault(); // avoid to execute the actual submit of the form.
    });
</script>





