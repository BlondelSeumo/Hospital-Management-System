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

    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo $this->lang->line('income') . " " . $this->lang->line('report'); ?></h3>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <div class="box-body pb0">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">

                                    <form role="form" action="<?php echo site_url('admin/income/incomeSearch') ?>" method="post" class="">
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
                            </div>

                        </div>

                    </div>  

                    <?php if (isset($resultList)) {
                        ?>

                        <div class="tabsborderbg"></div>  
                        <div class="box-body table-responsive">
                            <div class="download_label"><?php echo $this->lang->line('income') . " " . $this->lang->line('report'); ?></div>
                            <table class="table table-striped table-bordered table-hover example">
                                <thead>
                                    <tr>

                                        <th><?php echo $this->lang->line('name'); ?></th>
                                        <th><?php echo $this->lang->line('invoice_no'); ?></th>
                                        <th><?php echo $this->lang->line('income_head'); ?></th>
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
                                                <td><?php echo $value['name']; ?> </td>
                                                <td><?php echo $value['invoice_no']; ?> </td>
                                                <td><?php echo $value['income_category'] ?></td>
                                                <td><?php echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($value['date'])); ?>     </td>

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


                        <?php
                    }
                    ?>



                </div>   <!-- /.row -->

                </section><!-- /.content -->
            </div>
            <script type="text/javascript">
                $(document).ready(function () {
                    var date_format = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(), ['d' => 'dd', 'm' => 'mm', 'Y' => 'yyyy',]) ?>';
                    // var capital_date_format=date_format.toUpperCase();      
                    // 	$.fn.dataTable.moment(capital_date_format);
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
                        ordering: false,
                        paging: false,
                        bSort: false,
                        info: false
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
