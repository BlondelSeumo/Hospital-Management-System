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
                        <h3 class="box-title"><?php echo $this->lang->line('organisation') . " " . $this->lang->line('report'); ?></h3>
                    </div>

                    <form role="form" action="<?php echo site_url('admin/tpamanagement/tpareport') ?>" method="post" class="">
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
                                    <select name="doctor" class="form-control select2"  style="width: 100%">
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
                            <div class="col-sm-6 col-md-3">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('organisation'); ?></label>
                                    <select class="form-control select2"  name="organisation" style="width: 100%">
                                        <option value=""><?php echo $this->lang->line('select') ?></option>
                                        <?php foreach ($organisation as $orgkey => $orgvalue) {
                                            ?>
                                            <option value="<?php echo $orgvalue["id"] ?>" <?php
                                            if ((isset($tpa_select)) && ($tpa_select == $orgvalue["id"])) {
                                                echo "selected";
                                            }
                                            ?> ><?php echo $orgvalue["organisation_name"] ?></option> 
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
                        <div class="box-header ptbnull"></div>
                        <div class="box-body table-responsive">
                            <div class="download_label"><?php echo $this->lang->line('organisation') . " " . $this->lang->line('report'); ?></div>
                            <table class="table table-striped table-bordered table-hover example">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('name'); ?></th>
                                        <th><?php echo $this->lang->line('refference'); ?></th>
                                        <th><?php echo $this->lang->line('consultant'); ?></th>
                                        <th><?php echo $this->lang->line('organisation'); ?></th>
                                        <th><?php echo $this->lang->line('head'); ?></th>
                                        <th><?php echo $this->lang->line('date'); ?></th>
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
                                        $total = 0;
                                        foreach ($resultlist as $key1 => $report) {
                                            foreach ($report as $result) {
                                                # code...
                                                if (isset($result["reff"])) {
                                                    $refference = $result["reff"];
                                                }
                                                $patient_id = "";
                                                if (isset($result["patient_unique_id"])) {
                                                    $patient_id = " (" . $result["patient_unique_id"] . ")";
                                                }

                                                $payment = $result["amount"];
                                                $total += $result["amount"];
                                                ?>

                                                <tr>
                                                    <td><?php echo $result["patient_name"] . " " . $patient_id ?></td>
                                                    <td><?php echo $refference ?></td>
                                                    <td><?php echo $result["name"] . " " . $result["surname"] ?></td>
                                                    <td><?php echo $result["organisation_name"] ?></td>
                                                    <td style="text-transform:capitalize;"><?php echo $key1 ?></td>
                                                    <td><?php echo date($this->customlib->getSchoolDateFormat(), strtotime($result['date'])); ?></td>
                                                    <td class="text-right"><?php echo $payment ?></td>
                                                </tr>  
                                                <?php
                                                $count++;
                                            }
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
        $(".select2").select2();
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