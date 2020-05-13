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
                        <h3 class="box-title"> <?php echo $this->lang->line('payroll') . " " . $this->lang->line('report'); ?></h3>
                    </div>

                    <form role="form" action="<?php echo site_url('admin/payroll/payrollsearch') ?>" method="post" class="">
                        <div class="box-body">
                            <div class="row">
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
                                        <label><?php echo "Date From" ?></label><small class="req"> *</small>
                                        <input id="date_from" name="date_from" placeholder="" type="text" class="form-control date" value="<?php echo set_value('date_from', date($this->customlib->getSchoolDateFormat())); ?>"  />
                                        <span class="text-danger"><?php echo form_error('date_from'); ?></span>
                                    </div>
                                </div> 
                                <div class="col-sm-6 col-md-4" id="todate" style="display: none">
                                    <div class="form-group">
                                        <label><?php echo "Date To" ?></label><small class="req"> *</small>
                                        <input id="date_to" name="date_to" placeholder="" type="text" class="form-control date" value="<?php echo set_value('date_to', date($this->customlib->getSchoolDateFormat())); ?>"  />
                                        <span class="text-danger"><?php echo form_error('date_to'); ?></span>
                                    </div>
                                </div> 
                            </div>        
                        </div>
                        <div class="box-footer">
                            <button type="submit" name="search" value="search_filter" class="btn btn-primary btn-sm checkbox-toggle pull-right"><i class="fa fa-search"></i> <?php echo $this->lang->line('search'); ?></button>
                        </div>    
                    </form>

                    <div class="box border0 clear"></div>
                    <div class=" box-header ptbnull ptbnull">
                        <div class="box-body table-responsive">
                            <div class="download_label"><?php echo $this->lang->line('payroll') . " " . $this->lang->line('report'); ?></div>
                            <table class="table table-striped table-bordered table-hover example">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('name'); ?></th>
                                        <th><?php echo $this->lang->line('role'); ?></th>
                                        <th><?php echo $this->lang->line('designation'); ?></th>
                                        <th><?php echo $this->lang->line('month'); ?> - <?php echo $this->lang->line('year') ?></th>
                                        <th><?php echo $this->lang->line('payment') . " " . $this->lang->line('date'); ?> </th>

                                        <th><?php echo $this->lang->line('payslip'); ?> #</th>
                                        <th class="text text-right"><?php echo $this->lang->line('basic_salary'); ?> <span><?php echo "(" . $currency_symbol . ")"; ?></span></th>
                                        <th class="text text-right"><?php echo $this->lang->line('earning'); ?> <span><?php echo "(" . $currency_symbol . ")"; ?></span></th>
                                        <th class="text text-right"><?php echo $this->lang->line('deduction'); ?> <span><?php echo "(" . $currency_symbol . ")"; ?></span></th>
                                        <th class="text text-right"><?php echo $this->lang->line('gross_salary'); ?> <span><?php echo "(" . $currency_symbol . ")"; ?></span></th>
                                        <th class="text text-right"><?php echo $this->lang->line('tax'); ?> <span><?php echo "(" . $currency_symbol . ")"; ?></span></th>
                                        <th class="text text-right"><?php echo $this->lang->line('net_salary'); ?> <span><?php echo "(" . $currency_symbol . ")"; ?></span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $basic = 0;
                                    $gross = 0;
                                    $net = 0;
                                    $earnings = 0;
                                    $deduction = 0;
                                    $tax = 0;

                                    if (empty($resultlist)) {
                                        ?>

                                        <?php
                                    } else {
                                        $count = 1;

                                        foreach ($resultlist as $key => $value) {


                                            $basic += $value["basic"];
                                            $gross += $value["basic"] + $value["total_allowance"];
                                            $net += $value["net_salary"];
                                            $earnings += $value["total_allowance"];
                                            $deduction += $value["total_deduction"];
                                            $tax += $value["tax"];
                                            $total = 0;
                                            $grd_total = 0;
                                            ?>
                                            <tr>


                                                <td style="text-transform: capitalize;">
                                                    <span data-toggle="popover" class="detail_popover" data-original-title="" title=""><a href="#"><?php echo $value['name'] . " " . $value['surname']; ?></a></span>
                                                    <div class="fee_detail_popover" style="display: none"><?php echo $this->lang->line('staff_id'); ?><?php echo ": " . $value['employee_id']; ?></div>
                                                </td>
                                                <td>
                                                    <?php echo $value['user_type']; ?>
                                                </td>
                                                <td>
                                                    <span  data-original-title="" title=""><?php
                                                        echo $value['designation'];
                                                        ;
                                                        ?></span>

                                                </td>
                                                <td>
                                                    <?php echo $value['month'] . " - " . $value['year']; ?>
                                                </td>
                                                <td>
                                                    <?php echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($value['payment_date']));
                                                    ?>
                                                </td>
                                                <td>

                                                    <span data-toggle="popover" class="detail_popover" data-original-title="" title=""><a href="#"><?php echo $value['id']; ?></a></span>
                                                    <div class="fee_detail_popover" style="display: none"><?php echo $this->lang->line('mode'); ?>: <?php
                                                        if ($value["payment_mode"] != '') {
                                                            echo $payment_mode[$value["payment_mode"]];
                                                        }
                                                        ?></div>

                                                </td>
                                                <td class="text text-right">
                                                    <?php echo number_format($value['basic'], 2, '.', ''); ?>
                                                </td>

                                                <td class="text text-right">
                                                    <?php echo (number_format($value['total_allowance'], 2, '.', '')); ?>
                                                </td>
                                                <td class="text text-right">
                                                    <?php
                                                    $t = ($value['total_deduction']);
                                                    echo (number_format($t, 2, '.', ''))
                                                    ?>
                                                </td>
                                                <td class="text text-right">
                                                    <?php echo number_format($value['basic'] + $value['total_allowance'], 2, '.', ''); ?>
                                                </td>
                                                <td class="text text-right">
                                                    <?php
                                                    $t = ($value['tax']);
                                                    echo (number_format($t, 2, '.', ''))
                                                    ?>
                                                </td>
                                                <td class="text text-right">
                                                    <?php
                                                    $t = ($value['net_salary']);
                                                    echo (number_format($t, 2, '.', ''))
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php
                                            $count++;
                                        }
                                        ?>
                                        <tr class="box box-solid total-bg">
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td  class="text-right"><?php echo $this->lang->line('total'); ?> </td>
                                            <td class="text text-right"><?php echo ($currency_symbol . number_format($basic, 2, '.', '')); ?></td>

                                            <td class="text text-right"><?php echo ($currency_symbol . number_format($earnings, 2, '.', '')); ?></td>
                                            <td class="text text-right"><?php echo ($currency_symbol . number_format($deduction, 2, '.', '')); ?></td>
                                            <td class="text text-right"><?php echo ($currency_symbol . number_format($gross, 2, '.', '')); ?></td>
                                            <td class="text text-right"><?php echo ($currency_symbol . number_format($tax, 2, '.', '')); ?></td>
                                            <td class="text text-right"><?php echo ($currency_symbol . number_format($net, 2, '.', '')); ?></td>



                                        </tr>
                                    <?php } ?>
                                </tbody>

                                <?php //}    ?>
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
        $('.detail_popover').popover({
            placement: 'right',
            title: '',
            trigger: 'hover',
            container: 'body',
            html: true,
            content: function () {
                return $(this).closest('td').find('.fee_detail_popover').html();
            }
        });
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