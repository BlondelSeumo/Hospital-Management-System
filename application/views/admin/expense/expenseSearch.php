<?php
$currency_symbol = $this->customlib->getSchoolCurrencyFormat();
?>
<div class="content-wrapper" style="min-height: 946px;">
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"></i> <?php echo $this->lang->line('expense') . " " . $this->lang->line('report'); ?></h3>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <form role="form" action="<?php echo site_url('admin/expense/expenseSearch') ?>" method="post" class="">
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
                                    <div class="box border0 clear">
                                        <div class="box-header ptbnull">
                                        </div>
                                    </div>

                                </div>  
                            </div>
                        </div>
                        <?php if (isset($resultList)) {
                            ?>
                            <div class="box-body table-responsive">
                                <div class="download_label"><?php echo $this->lang->line('expense') . " " . $this->lang->line('report'); ?>
                                </div>
                                <table class="table table-striped table-bordered table-hover example">
                                    <thead>
                                        <tr>
                                            <th><?php echo $this->lang->line('name'); ?></th>
                                            <th><?php echo $this->lang->line('invoice_no'); ?></th>

                                            <th><?php echo $this->lang->line('expense_head'); ?></th>
                                            <th><?php echo $this->lang->line('date'); ?></th>
                                            <th class="text-right"><?php echo $this->lang->line('amount'); ?> <span><?php echo "(" . $currency_symbol . ")"; ?></span></th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        if (empty($resultList)) {
                                            ?>

                                            <?php
                                        } else {
                                            $count = 1;
                                            $grand_total = 0;
                                            foreach ($resultList as $key => $value) {
                                                $grand_total = $grand_total + $value['amount'];
                                                ?>
                                                <tr>
                                                    <td><?php echo $value['name']; ?></td>
                                                    <td><?php echo $value['invoice_no']; ?></td>
                                                    <td><?php echo $value['exp_category'] ?></td>
                                                    <td> <?php echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($value['date'])); ?>     </td>
                                                    <td class="pull-right"><?php echo ($value['amount']); ?>  </td>
                                                </tr>
                                                <?php
                                                $count++;
                                            }
                                            ?>
                                            <tr class="total-bg">
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td class="pull-right text-bold"><?php echo $this->lang->line('grand_total'); ?> : <?php echo ($currency_symbol . number_format($grand_total, 2, '.', '')); ?>

                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
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
        var capital_date_format = date_format.toUpperCase();
        $.fn.dataTable.moment(capital_date_format);
        $(".date").datepicker({

            format: date_format,
            autoclose: true,
            todayHighlight: true

        });

        $.extend($.fn.dataTable.defaults, {
            paging: false,
            bSort: false,
        });
    });
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