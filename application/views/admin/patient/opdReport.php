<?php
$currency_symbol = $this->customlib->getSchoolCurrencyFormat();
?>
<style type="text/css">
    /*REQUIRED*/
    .carousel-row {
        margin-bottom: 10px;
    }
    .slide-row {
        padding: 0;
        background-color: #ffffff;
        min-height: 150px;
        border: 1px solid #e7e7e7;
        overflow: hidden;
        height: auto;
        position: relative;
    }
    .slide-carousel {
        width: 20%;
        float: left;
        display: inline-block;
    }
    .slide-carousel .carousel-indicators {
        margin-bottom: 0;
        bottom: 0;
        background: rgba(0, 0, 0, .5);
    }
    .slide-carousel .carousel-indicators li {
        border-radius: 0;
        width: 20px;
        height: 6px;
    }
    .slide-carousel .carousel-indicators .active {
        margin: 1px;
    }
    .slide-content {
        position: absolute;
        top: 0;
        left: 20%;
        display: block;
        float: left;
        width: 80%;
        max-height: 76%;
        padding: 1.5% 2% 2% 2%;
        overflow-y: auto;
    }
    .slide-content h4 {
        margin-bottom: 3px;
        margin-top: 0;
    }
    .slide-footer {
        position: absolute;
        bottom: 0;
        left: 20%;
        width: 78%;
        height: 20%;
        margin: 1%;
    }
    /* Scrollbars */
    .slide-content::-webkit-scrollbar {
        width: 5px;
    }
    .slide-content::-webkit-scrollbar-thumb:vertical {
        margin: 5px;
        background-color: #999;
        -webkit-border-radius: 5px;
    }
    .slide-content::-webkit-scrollbar-button:start:decrement,
    .slide-content::-webkit-scrollbar-button:end:increment {
        height: 5px;
        display: block;
    }
</style>

<div class="content-wrapper" style="min-height: 946px;">
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo $this->lang->line('opd') . " " . $this->lang->line('report'); ?></h3>
                    </div>

                    <form role="form" action="<?php echo site_url('admin/patient/opd_report') ?>" method="post" class="">

                        <div class="box-body row">

                            <?php echo $this->customlib->getCSRF(); ?>

                            <div class="col-sm-6 col-md-3" >
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
                            <div class="col-sm-6 col-md-3"  >
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('doctor'); ?></label>
                                    <select class="form-control select2" <?php
                                    if ($disable_option == true) {
                                        echo "disabled";
                                    }
                                    ?> name="doctor" style="width: 100%">
                                        <option value=""><?php echo $this->lang->line('select') ?></option>
                                        <?php foreach ($doctorlist as $dkey => $value) {
                                            ?>
                                            <option value="<?php echo $value["id"] ?>" <?php
                                            if ((isset($doctor_select)) && ($doctor_select == $value["id"])) {
                                                echo "selected";
                                            }
                                            ?> ><?php echo $value["name"] . " " . $value["surname"] ?></option> 
<?php } ?>
                                    </select>
                                    <span class="text-danger"><?php echo form_error('doctor'); ?></span>
                                </div>
                            </div> 
                            <div class="col-sm-6 col-md-3" id="fromdate" style="display: none">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('date_from'); ?></label><small class="req"> *</small>
                                    <input id="date_from" name="date_from" placeholder="" type="text" class="form-control date" value="<?php echo set_value('date_from', date($this->customlib->getSchoolDateFormat())); ?>"  />
                                    <span class="text-danger"><?php echo form_error('date_from'); ?></span>
                                </div>
                            </div> 
                            <div class="col-sm-6 col-md-3" id="todate" style="display: none">
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

                    </form>
                    <div class="box border0 clear">
                        <div class="box-header ptbnull">

                        </div>
                        <div class="box-body table-responsive">
                            <div class="download_label"><?php echo $this->lang->line('opd') . " " . $this->lang->line('report'); ?></div>
                            <table class="table table-striped table-bordered table-hover example">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('appointment') . " " . $this->lang->line('date'); ?></th>
                                        <th><?php echo $this->lang->line('opd') . " " . $this->lang->line('no'); ?></th>
                                        <th><?php echo $this->lang->line('patient') . " " . $this->lang->line('id'); ?></th>
                                        <th><?php echo $this->lang->line('patient') . " " . $this->lang->line('name'); ?></th>
                                        <th><?php echo $this->lang->line('age'); ?></th>
                                        <th><?php echo $this->lang->line('gender'); ?></th>
                                        <th><?php echo $this->lang->line('mobile_no'); ?></th>
                                        <th><?php echo $this->lang->line('guardian_name'); ?></th>
                                        <th><?php echo $this->lang->line('address'); ?></th>
                                        <th><?php echo $this->lang->line('casualty'); ?></th>
                                        <th><?php echo $this->lang->line('refference'); ?></th>
                                        <th><?php echo $this->lang->line('consultant') . " " . $this->lang->line('doctor'); ?></th>
                                        <th><?php echo $this->lang->line('charges') ; ?></th>
                                        <th><?php echo $this->lang->line('payment') . " " . $this->lang->line('mode'); ?></th>
                                        <th class="text-right"><?php echo $this->lang->line('amount') . '(' . $currency_symbol . ')'; ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (empty($resultlist)) {
                                        ?>
                                                        <!-- <tr>
                                                            <td colspan="12" class="text-danger text-center"><?php echo $this->lang->line('no_record_found'); ?>
                                                            </td>
                                                        </tr>  -->
                                        <?php
                                    } else {
                                        $count = 1;
                                        $total = 0;
                                        foreach ($resultlist as $report) {
                                            if (!empty($report['amount'])) {
                                                $total += $report['amount'];
                                            }
                                            ?>      
                                            <tr>
                                                <td><?php echo date($this->customlib->getSchoolDateFormat(true, true), strtotime($report['appointment_date'])) ?></td>
                                                <td><?php echo $report['opd_no']; ?></td>
                                                <!-- <td>
                                                    <a href="<?php echo base_url(); ?>student/view/<?php echo $student['id']; ?>"><?php echo $student['firstname'] . " " . $student['lastname']; ?>
                                                    </a>
                                                </td> -->
                                                <td><?php echo $report['patient_unique_id']; ?></td>
                                                <td>
                                                    <a href="<?php echo base_url(); ?>admin/patient/profile/<?php echo $report['pid']; ?>"><?php echo $report['patient_name'] ?>
                                                    </a>
                                                </td>
                                                <td><?php if(!empty($report['age'])){ echo $report['age']." ".$this->lang->line("years")." "; } if(!empty($report['month'])){ echo $report['month']." ".$this->lang->line("month"); } ?></td>
                                                <td><?php echo $report['gender']; ?></td>
                                                <td><?php echo $report['mobileno']; ?></td>
                                                <td><?php echo $report['guardian_name']; ?></td>
                                                <td><?php echo $report['address']; ?></td>
                                                <td><?php echo $report['casualty']; ?></td>
                                                <td><?php echo $report['refference']; ?></td>
                                                <td><?php echo $report['name'] . " " . $report['surname']; ?></td>
                                                <td><?php if(isset($report["charges"])){ echo $report["charges"]; } ?></td>
                                                <td><?php echo $report['payment_mode']; ?>
                                                <td class="text-right"><?php echo $report['amount']; ?></td>
                                                </td>
                                            </tr>
                                            <?php
                                            $count++;
                                        }
                                        ?>
                                    </tbody>
                                    <tr class="box box-solid total-bg">
                                        <td class="text-right" colspan='15'><?php echo $this->lang->line('total') . " :" . $currency_symbol . $total; ?>
                                        </td>
                                    </tr>
<?php } ?>
                            </table>

                        </div>
                    </div>
                </div>
            </div>


        </div>   
</div>  
</section>
</div>


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