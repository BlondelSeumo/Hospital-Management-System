<style type="text/css">
    @media print
    {
        .no-print, .no-print *
        {
            display: none !important;
        }
    }
</style>
<?php
$currency_symbol = $this->customlib->getSchoolCurrencyFormat();
?>
<div class="content-wrapper" style="min-height: 946px;">
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo $this->lang->line('transaction_report') ?></h3>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <div class="box-body pb0">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">

                                    <form role="form" action="<?php echo site_url('admin/income/transactionreport') ?>" method="post" class="">
                                        <div class="box-body row">
                                            <?php echo $this->customlib->getCSRF(); ?>
                                            <div class="col-sm-6 col-md-4" >
                                                <div class="form-group">
                                                    <label><?php echo $this->lang->line('search') . " " . $this->lang->line('type'); ?></label>
                                                    <select class="form-control" name="search_type" onchange="showdate(this.value)">
                                                        <option value=""><?php echo $this->lang->line('all') ?></option>
                                                        <?php foreach ($searchlist as $key => $search) {
                                                            ?>
                                                            <option value="<?php echo $key ?>" <?php
                                                            if ((isset($search_type)) && ($search_type == $key)) {
                                                                echo "selected";
                                                            }
                                                            ?>><?php echo $search ?></option>
<?php } ?>
                                                    </select>
                                                    <span class="text-danger"><?php echo form_error('search_type'); ?></span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-4" id="fromdate" style="display: none">
                                                <div class="form-group">
                                                    <label><?php echo $this->lang->line('date_from'); ?></label><small class="req"> *</small>
                                                    <input id="date_from" name="date_from" placeholder="" type="text" class="form-control date" value="<?php echo set_value('date_from', date($this->customlib->getSchoolDateFormat())); ?>"  />
                                                    <span class="text-danger"><?php echo form_error('date_from'); ?></span>
                                                </div>
                                            </div> 
                                            <div class="col-sm-6 col-md-4" id="todate" style="display: none">
                                                <div class="form-group">
                                                    <label><?php echo $this->lang->line('date_to'); ?></label><small class="req"> *</small>
                                                    <input id="date_to" name="date_to" placeholder="" type="text" class="form-control date" value="<?php echo set_value('date_to', date($this->customlib->getSchoolDateFormat())); ?>"  />
                                                    <span class="text-danger"><?php echo form_error('date_to'); ?></span>
                                                </div>
                                            </div> 
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <button type="submit" name="search" value="search_filter" class="btn btn-primary btn-sm checkbox-toggle pull-right"><i class="fa fa-search"></i> <?php echo $this->lang->line('search'); ?></button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>  
                            </div>  </div>

                    </div>

<?php if (isset($parameter)) {
    ?>
                        <div class="tabsborderbg"></div>
                        <div class="nav-tabs-custom border0">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#all" data-toggle="tab" aria-expanded="true"><?php echo $this->lang->line('all') ?></a></li>
                                <?php
                                $j = 0;
                                $language_module = array(
                                    'opd_patient' => 'opd_patient',
                                    'ipd_patient' => 'ipd_patient',
                                    'pharmacy bill' => 'pharmacy_bill',
                                    'pathology test' => 'pathology_test',
                                    'radiology test' => 'radiology_test',
                                    'ot_patient' => 'ot_patient',
                                    'ambulance_call' => 'blood_issue',
                                    'blood_issue' => 'ambulance_call',
                                    'income' => 'income',
                                    'expense' => 'expense',
                                    'payroll_report' => 'payroll_report'
                                );
                                $permission_array = array('opd_patient', 'ipd_patient', 'pharmacy bill', 'pathology test', 'radiology test', 'ot_patient', 'ambulance_call', 'blood_issue', 'income', 'expense', 'payroll_report');
                                $report_module = array('opd_report', 'ipd_report', 'pharmacy_bill_report', 'pathology_patient_report', 'radiology_patient_report', 'ot_report', 'ambulance_call', 'blood_donor_report', 'income', 'expense', 'payroll_report');
                                foreach ($parameter as $ckey => $value) {
                                    if (($this->rbac->hasPrivilege($permission_array[$j], 'can_view')) || ($this->rbac->hasPrivilege($report_module[$j], 'can_view'))) {
                                        ?>
                                        <li class="<?php //if($j == 0){ echo "active" ;} ?>"><a href="#<?php echo $ckey ?>" data-toggle="tab" aria-expanded="true"><font ><?php echo $this->lang->line($language_module[$permission_array[$j]]); ?></font></a></li>
                                    <?php
                                    }
                                    $j++;
                                }
                                ?>

                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane active" id="all">
                                    <div class="download_label"><?php echo $this->lang->line('transaction_report'); ?></div>
                                    <div class="">
                                        <table class="table table-striped table-bordered table-hover example" cellspacing="0" width="100%">
                                            <thead>
                                            <th><?php echo $this->lang->line('name'); ?></th>
                                            <th><?php echo $this->lang->line('refference'); ?></th>
                                            <th><?php echo $this->lang->line('head'); ?></th>
                                            <th><?php echo $this->lang->line('date'); ?></th>
                                            <th class="text-right"><?php echo $this->lang->line('amount') . " (" . $currency_symbol . ")"; ?></th>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $j = 0;
                                                $total = 0;
                                                $class = "";
                                                $refference = "";
                                                $prefix = "";
                                                foreach ($resultlist as $key1 => $result2) {

                                                    foreach ($result2 as $key4 => $result) {    
                                                        $surname = "";
                                                        //print_r($result);
                                                        //echo   $patient_type = $result['patient_type'];
                                                        if (!empty($result["amount"])) {
                                                            $payment = $result["amount"];

                                                            if (($key1 == 'Payroll')) {
                                                                $surname = $result["surname"];
                                                            }
                                                            if (($key1 == 'Payroll') || ($key1 == 'Expenses')) {
                                                                $class = "text-danger";
                                                                $prefix = "-";
                                                                $total -= $payment;
                                                            } else {
                                                                $total += $payment;
                                                            }
                                                        }
                                                        $patient_id = "";
                                                        if (isset($result["patient_unique_id"])) {
                                                            $patient_id = " (" . $result["patient_unique_id"] . ")";
                                                        }
                                                        if (isset($result["reff"])) {
                                                            $refference = $result["reff"];
                                                        }

                                                        if (!($this->rbac->hasPrivilege('opd_patient', 'can_view') || $this->rbac->hasPrivilege('opd_report', 'can_view')) && ($key1 == "OPD")) {
                                                            
                                                        } elseif (!($this->rbac->hasPrivilege('ipd_patient', 'can_view') || $this->rbac->hasPrivilege('ipd_report', 'can_view')) && ($key1 == "IPD")) {
                                                            # code...
                                                        } elseif (!($this->rbac->hasPrivilege('ot_patient', 'can_view') || $this->rbac->hasPrivilege('ot_report', 'can_view')) && ($key1 == "Operation Theatre")) {
                                                            # code...
                                                        } elseif (!($this->rbac->hasPrivilege('pharmacy bill', 'can_view') || $this->rbac->hasPrivilege('pharmacy_bill_report', 'can_view')) && ($key1 == "Pharmacy")) {
                                                            # code...
                                                        } elseif (!($this->rbac->hasPrivilege('pathology test', 'can_view') || $this->rbac->hasPrivilege('pathology_patient_report', 'can_view')) && ($key1 == "Pathology")) {
                                                            # code...
                                                        } elseif (!($this->rbac->hasPrivilege('radiology test', 'can_view') || $this->rbac->hasPrivilege('radiology_patient_report', 'can_view')) && ($key1 == "Radiology")) {
                                                            # code...
                                                        } elseif (!($this->rbac->hasPrivilege('blood_issue', 'can_view') || $this->rbac->hasPrivilege('blood_donor_report', 'can_view')) && ($key1 == "Blood Bank")) {
                                                            # code...
                                                        } elseif (!($this->rbac->hasPrivilege('income', 'can_view')) && ($key1 == "General Income")) {
                                                            # code...
                                                        } elseif (!($this->rbac->hasPrivilege('expense', 'can_view')) && ($key1 == "Expenses")) {
                                                            # code...
                                                        } elseif (!($this->rbac->hasPrivilege('payroll_report', 'can_view')) && ($key1 == "Payroll")) {
                                                            # code...
                                                        } elseif (!($this->rbac->hasPrivilege('ambulance_call', 'can_view')) && ($key1 == "Ambulance")) {
                                                            # code...
                                                        } else {
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $result["patient_name"] . " " . $surname . $patient_id ?></td>
                                                                <td><?php echo $refference ?></td>
                                                                <td style="text-transform:capitalize;"><?php echo $key1 ?></td>
                                                                <td><?php echo date($this->customlib->getSchoolDateFormat(), strtotime($result['date'])); ?></td>
                                                                <td class="text-right <?php echo $class ?>"><?php echo $prefix . $payment ?></td>
                                                            </tr>  
                                                        <?php
                                                        }
                                                    }
                                                    $j++;
                                                }
                                                ?>
                                            </tbody>

                                            <tr class="box box-solid total-bg">
                                                <td class="text-right" colspan='14'><?php echo $this->lang->line('total') . " : " . $currency_symbol . $total; ?>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <?php
                                $i = 0;
                                $reff = 0;

                                foreach ($parameter as $key => $value) {
                                    ?>
                                    <div class="tab-pane <?php //if($i == 0){ echo "active" ;}   ?>" id="<?php echo $key ?>">
                                        <div class="download_label"><?php echo $this->lang->line('transaction_report'); ?></div>
                                        <div class="box-body table-responsive">
                                            <table class="table table-striped table-bordered table-hover example" cellspacing="0" width="100%">
                                                <thead>
                                                <th><?php echo $this->lang->line('name'); ?></th>
                                                <th><?php echo $this->lang->line('refference'); ?></th>
                                                <th><?php echo $this->lang->line('head'); ?></th>
                                                <th><?php echo $this->lang->line('date'); ?></th>
                                                <th class="text-right"><?php echo $this->lang->line('amount') . " (" . $currency_symbol . ")"; ?></th>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $tot[$value["label"]] = 0;
                                                    foreach ($value["resultList"] as $key2 => $transaction) {
                                                        # code...
                                                        $tabsurname = "";
                                                        if ($value["label"] == "Payroll") {
                                                            $surname = $transaction["surname"];
                                                        }
                                                        if (!empty($transaction["amount"])) {

                                                            $payment = $transaction["amount"];
                                                            $tot[$value["label"]] += $payment;
                                                        }
                                                        $patient_id = "";
                                                        if (isset($transaction["patient_unique_id"])) {
                                                            $patient_id = " (" . $transaction["patient_unique_id"] . ")";
                                                        }

                                                        if (isset($transaction["reff"])) {
                                                            $reff = $transaction["reff"];
                                                        }
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $transaction["patient_name"] . " " . $surname . $patient_id ?></td>
                                                            <td><?php echo $reff; ?></td>
                                                            <td style="text-transform: capitalize;"><?php echo $value["label"] ?></td>
                                                            <td><?php echo date($this->customlib->getSchoolDateFormat(), strtotime($transaction['date'])); ?></td>
                                                            <td class="text-right"><?php echo $payment ?></td>
                                                        </tr> 
        <?php } ?>

                                                </tbody>
                                                <tr class="box box-solid total-bg">
                                                    <td class="text-right" colspan='14'><?php echo $this->lang->line('total') . " : " . $currency_symbol . $tot[$value["label"]]; ?>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div> 
                                    </div>
        <?php $i++;
    }
    ?>
                            </div>
                        </div>

                    </div>
    <?php
}
?>

            </div>      

        </div>   <!-- /.row -->

    </section><!-- /.content -->
</div>
<script type="text/javascript">
    $(document).ready(function () {
        var date_format = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(), ['d' => 'dd', 'm' => 'mm', 'Y' => 'yyyy',]) ?>';

        // var capital_date_format=date_format.toUpperCase();      
        //        $.fn.dataTable.moment(capital_date_format);
        $(".date").datepicker({
            // format: "dd-mm-yyyy",
            format: date_format,
            autoclose: true,
            todayHighlight: true

        });
    });
</script>
<script type="text/javascript">

    $(document).ready(function () {
        $.extend($.fn.dataTable.defaults, {
            ordering: true,
            paging: false,
            bSort: true,
            info: true,
        });
    });

</script>
<script type="text/javascript">

    var base_url = '<?php echo base_url() ?>';

    function printDiv(elem) {
        Popup(jQuery(elem).html());
    }

    function Popup(data)
    {

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


<script type="text/javascript">


    $(document).ready(function (e) {

        showdate('<?php echo $search_type; ?>');
    });

    function showdate(value) {

        if (value == 'period') {
            $('#fromdate').show();
            $('#todate').show();
        } else {
            $('#fromdate').hide();
            $('#todate').hide();
        }
    }
</script>
