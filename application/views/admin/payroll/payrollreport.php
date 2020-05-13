<style type="text/css">
    .nav-tabs-custom>.nav-tabs>li.active {
        border-top-color: #faa21c;
    }
</style>
<?php
$currency_symbol = $this->customlib->getSchoolCurrencyFormat();
?>
<div class="content-wrapper" style="min-height: 946px;">

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo $this->lang->line('payroll') . " " . $this->lang->line('month') . " " . $this->lang->line('report'); ?></h3>
                    </div>

                    <div class="">

                        <form role="form" action="<?php echo site_url('admin/payroll/payrollreport') ?>" method="post" class="">
                            <div class="box-body">   
                                <div class="row">
                                    <?php echo $this->customlib->getCSRF(); ?>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line('role'); ?></label>
                                            <select name="role" class="form-control">
                                                <option value="select"><?php
                                                    echo $this->lang->line(
                                                            'select')
                                                    ?></option>
                                                <?php foreach ($role as $rolekey => $rolevalue) { ?>
                                                    <option <?php
                                                    if ($rolevalue["type"] == $role_select) {
                                                        echo "selected";
                                                    }
                                                    ?> value="<?php echo $rolevalue["type"] ?>"><?php echo $rolevalue["type"]; ?></option>
                                                    <?php } ?>   
                                            </select>
                                            <span class="text-danger"><?php echo form_error('role'); ?></span>
                                        </div>
                                    </div>   
                                    <div class="col-sm-4">
                                        <div class="form-group">  
                                            <label><?php echo $this->lang->line('month'); ?></label>
                                            <select name="month" class="form-control">
                                                <option value=""><?php
                                                    echo $this->lang->line(
                                                            'select')
                                                    ?></option>
                                                <?php foreach ($monthlist as $monthkey => $monthvalue) { ?>
                                                    <option <?php
                                                    if ($month == $monthvalue) {
                                                        echo "selected";
                                                    }
                                                    ?> value="<?php echo $monthvalue ?>"><?php echo $this->lang->line(strtolower($monthvalue)); ?></option>
                                                    <?php } ?>   
                                            </select>
                                            <span class="text-danger"><?php echo form_error('month'); ?></span>
                                        </div>  
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">  
                                            <label><?php echo $this->lang->line('year'); ?><small class="req"> *</small></label>
                                            <?php
                                            if (isset($year)) {
                                                $selected_year = $year;
                                            } else {
                                                $selected_year = date('Y');
                                            }
                                            ?>
                                            <select name="year" class="form-control">
                                                <option value=""><?php
                                                    echo $this->lang->line(
                                                            'select')
                                                    ?></option>
                                                <?php foreach ($yearlist as $yearkey => $yearvalue) { ?>
                                                    <option <?php
                                                    if (($yearvalue["year"] == $selected_year)) {
                                                        echo "selected";
                                                    }
                                                    ?> value="<?php echo $yearvalue["year"]; ?>"><?php echo $yearvalue["year"]; ?></option>
                                                    <?php } ?>   
                                            </select>
                                            <span class="text-danger"><?php echo form_error('year'); ?></span>
                                        </div>  
                                    </div>
                                </div> 
                            </div> 
                            <div class="box-footer">
                                <button type="submit" name="search" value="search_filter" class="btn btn-primary btn-sm checkbox-toggle pull-right"><i class="fa fa-search"></i> <?php echo $this->lang->line('search'); ?></button>
                            </div>
                        </form>     
                        <?php if (isset($result)) {
                            ?>
                            <div class="ptbnull"></div>
                            <div class="box border0 clear">
                                <div class="box-body">     
                                    <div class="tab-content">
                                        <div class="" id="tab_parent">
                                            <div class="download_label"><?php echo $this->lang->line('payroll'); ?> <?php echo $this->lang->line('report_for'); ?> <?php echo $month . " " . $year; ?></div>
                                            <table class="table table-striped table-bordered table-hover  table-fixed-header example">
                                                <thead class="header">
                                                    <tr>
                                                        <th><?php echo $this->lang->line('name'); ?></th>
                                                        <th><?php echo $this->lang->line('role'); ?></th>
                                                        <th><?php echo $this->lang->line('designation'); ?></th>
                                                        <th><?php echo $this->lang->line('month'); ?> - <?php echo $this->lang->line('year') ?></th>

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

                                                    if (empty($result)) {
                                                        ?>

                                                        <?php
                                                    } else {
                                                        $count = 1;

                                                        foreach ($result as $key => $value) {


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

                                                                    <span data-toggle="popover" class="detail_popover" data-original-title="" title=""><a href="#"><?php echo $value['id']; ?></a></span>
                                                                    <div class="fee_detail_popover" style="display: none"><?php echo $this->lang->line('mode'); ?>: <?php echo $payment_mode[$value["payment_mode"]] ?></div>

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
                                                            <td class="text-right"><?php echo $this->lang->line('total'); ?> </td>
                                                            <td class="text text-right"><?php echo ($currency_symbol . number_format($basic, 2, '.', '')); ?></td>

                                                            <td class="text text-right"><?php echo ($currency_symbol . number_format($earnings, 2, '.', '')); ?></td>
                                                            <td class="text text-right"><?php echo ($currency_symbol . number_format($deduction, 2, '.', '')); ?></td>
                                                            <td class="text text-right"><?php echo ($currency_symbol . number_format($gross, 2, '.', '')); ?></td>
                                                            <td class="text text-right"><?php echo ($currency_symbol . number_format($tax, 2, '.', '')); ?></td>
                                                            <td class="text text-right"><?php echo ($currency_symbol . number_format($net, 2, '.', '')); ?></td>

                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>    


                                    </div>

                                </div>
                            </div><!--./tabs--> 
                            <?php
                        }
                        ?>            </div>

                </div>
            </div>  
        </div>

    </section>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $.extend($.fn.dataTable.defaults, {
            ordering: false,
            paging: false,
            bSort: false,
            info: false
        });
    })
    $(document).ready(function () {
        $('.table-fixed-header').fixedHeader();
    });

    (function ($) {

        $.fn.fixedHeader = function (options) {
            var config = {
                topOffset: 50

            };
            if (options) {
                $.extend(config, options);
            }

            return this.each(function () {
                var o = $(this);

                var $win = $(window);
                var $head = $('thead.header', o);
                var isFixed = 0;
                var headTop = $head.length && $head.offset().top - config.topOffset;

                function processScroll() {
                    if (!o.is(':visible')) {
                        return;
                    }
                    if ($('thead.header-copy').size()) {
                        $('thead.header-copy').width($('thead.header').width());
                    }
                    var i;
                    var scrollTop = $win.scrollTop();
                    var t = $head.length && $head.offset().top - config.topOffset;
                    if (!isFixed && headTop !== t) {
                        headTop = t;
                    }
                    if (scrollTop >= headTop && !isFixed) {
                        isFixed = 1;
                    } else if (scrollTop <= headTop && isFixed) {
                        isFixed = 0;
                    }
                    isFixed ? $('thead.header-copy', o).offset({
                        left: $head.offset().left
                    }).removeClass('hide') : $('thead.header-copy', o).addClass('hide');
                }
                $win.on('scroll', processScroll);

                // hack sad times - holdover until rewrite for 2.1
                $head.on('click', function () {
                    if (!isFixed) {
                        setTimeout(function () {
                            $win.scrollTop($win.scrollTop() - 47);
                        }, 10);
                    }
                });

                $head.clone().removeClass('header').addClass('header-copy header-fixed').appendTo(o);
                var header_width = $head.width();
                o.find('thead.header-copy').width(header_width);
                o.find('thead.header > tr:first > th').each(function (i, h) {
                    var w = $(h).width();
                    o.find('thead.header-copy> tr > th:eq(' + i + ')').width(w);
                });
                $head.css({
                    margin: '0 auto',
                    width: o.width(),
                    'background-color': config.bgColor
                });
                processScroll();
            });
        };

    })(jQuery);

</script>

<script type="text/javascript">
    $(document).ready(function () {
        var date_format = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(), ['d' => 'dd', 'm' => 'mm', 'Y' => 'yyyy',]) ?>';
        $(".date").datepicker({
            format: date_format,
            autoclose: true,
            todayHighlight: true
        });
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
</script>


