<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-12">


                <?php
                $bar_chart = true;
                $line_chart = true;
                foreach ($notifications as $notice_key => $notice_value) {
                    ?>

                    <div class="dashalert alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="alertclose close close_notice" data-dismiss="alert" aria-label="Close" data-noticeid="<?php echo $notice_value->id; ?>"><span aria-hidden="true">&times;</span></button>

                        <a href="<?php echo site_url('admin/notification') ?>"><?php echo $notice_value->title; ?></a>
                    </div>

                    <?php
                }
                ?>

                <!--  <?php
                if ($systemnotifications) {
                    foreach ($systemnotifications as $key => $systemnotification) {
                        ?>
                                    <div class="dashalert alert alert-success alert-dismissible" role="alert">
                                         <button type="button" class="alertclose close close_notice" data-dismiss="alert" aria-label="Close" data-noticeid="<?php echo $systemnotification['id']; ?>"><span aria-hidden="true">&times;</span></button>
                                         <a href="<?php echo site_url('admin/systemnotification') ?>"><?php echo $systemnotification["notification_title"]; ?></a>
                                     </div>   
                    <?php
                    }
                }
                ?> -->

            </div>
            <?php
            $currency_symbol = $this->customlib->getSchoolCurrencyFormat();
            ?>  
            <?php
            $div_col = 12;
            $div_rol = 12;

            if ($this->rbac->hasPrivilege('staff_role_count_widget', 'can_view')) {
                $div_col = 9;
                $div_rol = 12;
            }

            $widget_col = array();
            if ($this->rbac->hasPrivilege('Monthly fees_collection_widget', 'can_view')) {
                $widget_col[0] = 1;
                $div_rol = 3;
            }

            if ($this->rbac->hasPrivilege('monthly_expense_widget', 'can_view')) {
                $widget_col[1] = 2;
                $div_rol = 3;
            }

            if ($this->rbac->hasPrivilege('student_count_widget', 'can_view')) {
                $widget_col[2] = 3;
                $div_rol = 3;
            }
            $div = sizeof($widget_col);

            if (!empty($widget_col)) {
                $widget = 12 / $div;
            } else {
                $widget = 12;
            }
            ?>          
        </div><!--./row-->

        <div class="row">

            <?php
            if ($this->module_lib->hasActive('OPD')) {
                if ($this->rbac->hasPrivilege('opd_income_widget', 'can_view')) {
                    ?>

                    <div class="col-lg-2 col-md-3 col-sm-6 col20
                         ">
                        <div class="info-box">
                            <a href="<?php echo site_url('admin/patient/search') ?>">
                                <span class="info-box-icon bg-green"><i class="fas fa-stethoscope"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text"><?php echo $this->lang->line('opd') . " " . $this->lang->line('income'); ?></span>
                                    <span class="info-box-number"><?php
                                        if (!empty($opd_income)) {
                                            echo $currency_symbol . $opd_income;
                                        } else {
                                            echo "0";
                                        }
                                        ?></span>
                                </div>
                            </a>
                        </div>
                    </div><!--./col-lg-2-->
                    <?php
                }
            }
            ?>
            <?php
            if ($this->module_lib->hasActive('IPD')) {
                if ($this->rbac->hasPrivilege('ipd_income_widget', 'can_view')) {
                    ?>

                    <div class="col-lg-2 col-md-3 col-sm-6 col20">
                        <div class="info-box">
                            <a href="<?php echo site_url('admin/patient/ipdsearch') ?>">
                                <span class="info-box-icon bg-green"><i class="fas fa-procedures"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text"><?php echo $this->lang->line('ipd') . " " . $this->lang->line('income'); ?></span>
                                    <span class="info-box-number"><?php
                                        if (!empty($ipd_income)) {
                                            echo $currency_symbol . $ipd_income;
                                        } else {
                                            echo "0";
                                        }
                                        ?></span>
                                </div>
                            </a>
                        </div>
                    </div><!--./col-lg-2-->
                    <?php
                }
            }
            ?>
            <?php
            if ($this->module_lib->hasActive('pharmacy')) {
                if ($this->rbac->hasPrivilege('pharmacy_income_widget', 'can_view')) {
                    ?>


                    <div class="col-lg-2 col-md-3 col-sm-6 col20">
                        <div class="info-box">
                            <a href="<?php echo site_url('admin/pharmacy/bill') ?>">
                                <span class="info-box-icon bg-green"><i class="fas fa-mortar-pestle"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text"><?php echo $this->lang->line('pharmacy') . " " . $this->lang->line('income'); ?></span>
                                    <span class="info-box-number"><?php
                                        if (!empty($pharmacy_income)) {
                                            echo $currency_symbol . $pharmacy_income;
                                        } else {
                                            echo "0";
                                        }
                                        ?></span>
                                </div>
                            </a>
                        </div>
                    </div><!--./col-lg-2-->
                    <?php
                }
            }
            if ($this->module_lib->hasActive('pathology')) {

                if ($this->rbac->hasPrivilege('pathology_income_widget', 'can_view')) {
                    ?>


                    <div class="col-lg-2 col-md-3 col-sm-6 col20">
                        <div class="info-box">
                            <a href="<?php echo site_url('admin/pathology/search') ?>">
                                <span class="info-box-icon bg-green"><i class="fas fa-flask"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text"><?php echo $this->lang->line('pathology') . " " . $this->lang->line('income'); ?></span>
                                    <span class="info-box-number"><?php
                                        if (!empty($pathology_income)) {
                                            echo $currency_symbol . $pathology_income;
                                        } else {
                                            echo "0";
                                        }
                                        ?></span>
                                </div>
                            </a>
                        </div>
                    </div><!--./col-lg-2-->
                    <?php
                }
            }
            ?>
            <?php
            if ($this->module_lib->hasActive('radiology')) {
                if ($this->rbac->hasPrivilege('radiology_income_widget', 'can_view')) {
                    ?>


                    <div class="col-lg-2 col-md-3 col-sm-6 col20">
                        <div class="info-box">
                            <a href="<?php echo site_url('admin/radio/search') ?>">
                                <span class="info-box-icon bg-green"><i class="fas fa-microscope"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text"><?php echo $this->lang->line('radiology') . " " . $this->lang->line('income'); ?></span>
                                    <span class="info-box-number"><?php
                                        if (!empty($radiology_income)) {
                                            echo $currency_symbol . $radiology_income;
                                        } else {
                                            echo "0";
                                        }
                                        ?></span>
                                </div>
                            </a>
                        </div>
                    </div><!--./col-lg-2-->
                    <?php
                }
            }
            ?>

            <?php
            if ($this->module_lib->hasActive('operation_theatre')) {
                if ($this->rbac->hasPrivilege('ot_income_widget', 'can_view')) {
                    ?>


                    <div class="col-lg-2 col-md-3 col-sm-6 col20">
                        <div class="info-box">
                            <a href="<?php echo site_url('admin/operationtheatre/otsearch') ?>">
                                <span class="info-box-icon bg-green"><i class="fas fa-scissors"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text"><?php echo $this->lang->line('operation_theatre') . " " . $this->lang->line('income'); ?></span>
                                    <span class="info-box-number"><?php
                                        if (!empty($operation_theatre_income)) {
                                            echo $currency_symbol . $operation_theatre_income;
                                        } else {
                                            echo "0";
                                        }
                                        ?></span>
                                </div>
                            </a>
                        </div>
                    </div><!--./col-lg-2-->
                    <?php
                }
            }
            ?>
            <?php
            if ($this->module_lib->hasActive('blood_bank')) {
                if ($this->rbac->hasPrivilege('blood_bank_income_widget', 'can_view')) {
                    ?>


                    <div class="col-lg-2 col-md-3 col-sm-6 col20">
                        <div class="info-box">
                            <a href="<?php echo site_url('admin/bloodbank/issue') ?>">
                                <span class="info-box-icon bg-green"><i class="fas fa-tint"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text"><?php echo $this->lang->line('blood_bank') . " " . $this->lang->line('income'); ?></span>
                                    <span class="info-box-number"><?php
                                        if (!empty($blood_bank_income)) {
                                            echo $currency_symbol . $blood_bank_income;
                                        } else {
                                            echo "0";
                                        }
                                        ?></span>
                                </div>
                            </a>
                        </div>
                    </div><!--./col-lg-2-->
                    <?php
                }
            }
            ?>
            <?php
            if ($this->module_lib->hasActive('ambulance')) {
                if ($this->rbac->hasPrivilege('ambulance_income_widget', 'can_view')) {
                    ?>


                    <div class="col-lg-2 col-md-3 col-sm-6 col20
                         ">
                        <div class="info-box">
                            <a href="<?php echo site_url('admin/vehicle/search') ?>">
                                <span class="info-box-icon bg-green"><i class="fas fa-ambulance"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text"><?php echo $this->lang->line('ambulance') . " " . $this->lang->line('income'); ?></span>
                                    <span class="info-box-number"><?php
                                        if (!empty($ambulance_income)) {
                                            echo $currency_symbol . $ambulance_income;
                                        } else {
                                            echo "0";
                                        }
                                        ?></span>
                                </div>
                            </a>
                        </div>
                    </div><!--./col-lg-2-->
                    <?php
                }
            }
            ?>
<?php if ($this->module_lib->hasActive('income')) { ?>
                <div class="col-lg-2 col-md-3 col-sm-6 col20">
                    <div class="info-box">
                        <a href="<?php echo site_url('admin/income') ?>">
                            <span class="info-box-icon bg-green"><i class="fas fa-money-bill-wave"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text"><?php echo $this->lang->line('general') . " " . $this->lang->line('income'); ?></span>
                                <span class="info-box-number"><?php
                                    if (!empty($general_income)) {
                                        echo $currency_symbol . $general_income;
                                    } else {
                                        echo "0";
                                    }
                                    ?></span>
                            </div>
                        </a>
                    </div>
                </div><!--./col-lg-2-->
            <?php } ?>
<?php if ($this->module_lib->hasActive('expense')) { ?>
                <div class="col-lg-2 col-md-3 col-sm-6 col20
                     ">
                    <div class="info-box">
                        <a href="<?php echo site_url('admin/expense') ?>">
                            <span class="info-box-icon expenes-red"><i class="fab fa-creative-commons-nc"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text"><?php echo $this->lang->line('expenses'); ?></span>
                                <span class="info-box-number"><?php
                                    if (!empty($expense->amount)) {
                                        echo $currency_symbol . number_format($expense->amount, 2);
                                    } else {
                                        echo $currency_symbol ."0.00";
                                    }
                                    ?></span>
                            </div>
                        </a>
                    </div>
                </div><!--./col-lg-2-->
<?php } ?>
        </div><!--./row-->

        <div class="row">
            <?php
            if ($this->rbac->hasPrivilege('yearly_income_expense_chart', 'can_view')) {
                ?>
                <div class="col-lg-6 col-md-6 col-sm-12 col60">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?php echo $this->lang->line('yearly_income_expense'); ?></h3>
                            <div class="box-tools pull-right">
                                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="chart"> 
                                <canvas id="lineChart" style="height:250px"></canvas>
                            </div>
                        </div>
                    </div>
                </div><!--./col-lg-7-->
            <?php } ?>
            <?php
            if ($this->rbac->hasPrivilege('monthly_income_expense_chart', 'can_view')) {
                ?>
                <div class="col-lg-6 col-md-6 col-sm-12 col40">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?php echo $this->lang->line('monthly_income_overview'); ?> </h3>
                            <div class="box-tools pull-right">
                                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="chart"> 
                                <canvas id="pieChart" style="height:250px"></canvas>
                            </div>
                        </div>
                    </div>
                </div><!--./col-lg-5-->
<?php } ?>
        </div><!--./row-->
        <div class="row">
            <div class="col-lg-9 col-md-9 col-sm-12 col80">
                <?php
                if ($this->rbac->hasPrivilege('calendar_to_do_list', 'can_view')) {
                    ?>
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?php echo $this->lang->line('calendar'); ?></h3>
                            <div class="box-tools pull-right">
                                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="chart"> 
                                <div id="calendar" ></div>
                            </div>
                        </div>
                    </div>
            <?php } ?>
            </div><!--./col-lg-9-->
            <?php if ($this->rbac->hasPrivilege('staff_role_count_widget', 'can_view')) {
                ?>

                <div class="col-lg-3 col-md-3 col-sm-12 col20">
                    <?php foreach ($roles as $key => $value) {
                        ?>

                        <div class="info-box">
                            <a href="<?php echo base_url() . "admin/staff" ?>">
                                <span class="info-box-icon bg-yellow"><i class="fas fa-user-secret"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text"><?php echo $key; ?></span>
                                    <span class="info-box-number"><?php echo $value; ?></span>
                                </div>
                            </a>
                        </div>
    <?php } ?>

                </div><!--./col-lg-3-->
<?php } ?>
        </div><!--./row-->  
    </section>
</div>
<div id="newEventModal" class="modal fade " role="dialog">
    <div class="modal-dialog modal-dialog2 modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo "Add New Event"; ?></h4>
            </div>
            <div class="modal-body">

                <div class="row">
                    <form role="form"  id="addevent_form" method="post" enctype="multipart/form-data" action="">
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1"><?php echo $this->lang->line('event'); ?> <?php echo $this->lang->line('title'); ?></label>
                            <input class="form-control" name="title" id="input-field"> 
                            <span class="text-danger"><?php echo form_error('title'); ?></span>

                        </div>

                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1"><?php echo $this->lang->line('description'); ?></label>
                            <textarea name="description" class="form-control" id="desc-field"></textarea></div>
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1"><?php echo $this->lang->line('event'); ?> <?php echo $this->lang->line('date'); ?></label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" autocomplete="off" name="event_dates" class="form-control pull-right" id="date-field">
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1"><?php echo $this->lang->line('event'); ?> <?php echo $this->lang->line('color'); ?></label>
                            <input type="hidden" name="eventcolor" autocomplete="off" id="eventcolor" class="form-control">
                        </div>
                        <div class="form-group col-md-12">

                            <?php
                            $i = 0;
                            $colors = '';
                            foreach ($event_colors as $color) {
                                $color_selected_class = 'cpicker-small';
                                if ($i == 0) {
                                    $color_selected_class = 'cpicker-big';
                                }
                                $colors .= "<div class='calendar-cpicker cpicker " . $color_selected_class . "' data-color='" . $color . "' style='background:" . $color . ";border:1px solid " . $color . "; border-radius:100px'></div>";

                                $i++;
                            }
                            echo '<div class="cpicker-wrapper">';
                            echo $colors;
                            echo '</div>';
                            ?>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1"><?php echo $this->lang->line('event'); ?> <?php echo $this->lang->line('type'); ?></label>
                            <br/>
                            <label class="radio-inline">

                                <input type="radio" name="event_type" value="public" id="public"><?php echo $this->lang->line('public'); ?>
                            </label>
                            <label class="radio-inline">

                                <input type="radio" name="event_type" value="private" checked id="private"><?php echo $this->lang->line('private'); ?>
                            </label>
                            <label class="radio-inline">

                                <input type="radio" name="event_type" value="sameforall" id="public"><?php echo $this->lang->line('all'); ?> <?php echo $role ?>
                            </label>
                            <label class="radio-inline">

                                <input type="radio" name="event_type" value="protected" id="public"><?php echo $this->lang->line('protected'); ?>
                            </label> </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <input type="submit" class="btn btn-primary submit_addevent pull-right" value="<?php echo $this->lang->line('save'); ?>"></div> </form>
                </div>

            </div>
        </div>
    </div>
</div>  
<div id="viewEventModal" class="modal fade " role="dialog">
    <div class="modal-dialog modal-dialog2 modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo "View Event"; ?></h4>
            </div>
            <div class="modal-body">

                <div class="row">
                    <form role="form"   method="post" id="updateevent_form"  enctype="multipart/form-data" action="" >
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1"><?php echo $this->lang->line('event') ?><?php echo $this->lang->line('title') ?></label>
                            <input class="form-control" name="title" placeholder="Event Title" id="event_title"> 
                        </div>
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1"><?php echo $this->lang->line('description') ?></label>
                            <textarea name="description" class="form-control" placeholder="Event Description" id="event_desc"></textarea></div>
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1"><?php echo $this->lang->line('event') ?><?php echo $this->lang->line('date') ?></label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" autocomplete="off" name="eventdates" class="form-control pull-right" id="eventdates">
                            </div>
                        </div>
                        <input type="hidden" name="eventid" id="eventid">
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1"><?php echo $this->lang->line('event') ?><?php echo $this->lang->line('color') ?></label>
                            <input type="hidden" name="eventcolor" autocomplete="off" placeholder="Event Color" id="event_color" class="form-control">
                        </div>
                        <div class="form-group col-md-12">

                            <?php
                            $i = 0;
                            $colors = '';
                            foreach ($event_colors as $color) {
                                $colorid = trim($color, "#");
                                $color_selected_class = 'cpicker-small';
                                if ($i == 0) {
                                    $color_selected_class = 'cpicker-big';
                                }
                                $colors .= "<div id=" . $colorid . " class='calendar-cpicker cpicker " . $color_selected_class . "' data-color='" . $color . "' style='background:" . $color . ";border:1px solid " . $color . "; border-radius:100px'></div>";
                                $i++;
                            }
                            echo '<div class="cpicker-wrapper selectevent">';
                            echo $colors;
                            echo '</div>';
                            ?>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1"><?php echo $this->lang->line('event') ?><?php echo $this->lang->line('type') ?></label>
                            <label class="radio-inline">

                                <input type="radio" name="eventtype" value="public" id="public"><?php echo $this->lang->line('public') ?>
                            </label>
                            <label class="radio-inline">

                                <input type="radio" name="eventtype" value="private" id="private"><?php echo $this->lang->line('private') ?> 
                            </label>
                            <label class="radio-inline">

                                <input type="radio" name="eventtype" value="sameforall" id="public"><?php echo $this->lang->line('all') ?> <?php echo $role ?>
                            </label>
                            <label class="radio-inline">

                                <input type="radio" name="eventtype" value="protected" id="public"><?php echo $this->lang->line('protected') ?> 
                            </label>
                        </div>

                        <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11">

                            <input type="submit" class="btn btn-primary submit_update pull-right" value="<?php echo $this->lang->line('save'); ?>">
                        </div>
                        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                            <?php if ($this->rbac->hasPrivilege('calendar_to_do_list', 'can_delete')) { ?>
                                <input type="button" id="delete_event" class="btn btn-primary submit_delete pull-right" value="<?php echo $this->lang->line('delete'); ?>">
<?php } ?>
                        </div>       
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>  
<script src="<?php echo base_url() ?>backend/js/Chart.bundle.js"></script>
<script src="<?php echo base_url() ?>backend/js/utils.js"></script>
<script type="text/javascript">



    window.onload = function () {
        var dataPointss = [];
        console.log(dataPointss);


        var yearly_collection_array = <?php echo json_encode($yearly_collection) ?>;
        var yearly_expense_array = <?php echo json_encode($yearly_expense) ?>;
        var MONTHS = <?php echo json_encode($total_month) ?>;
        console.log(yearly_collection_array);
        console.log(yearly_expense_array);


        var config = {
            type: 'line',
            data: {
                labels: MONTHS,
                datasets: [

                    {
                        label: '<?php echo $this->lang->line('income') ?>',
                        fill: false,
                        backgroundColor: '#66aa18',
                        borderColor: '#66aa18',
                        data: yearly_collection_array,
                    },

                    {
                        label: '<?php echo $this->lang->line('expense') ?>',
                        backgroundColor: window.chartColors.red,
                        borderColor: window.chartColors.red,
                        data: yearly_expense_array,
                        fill: false,
                    }
                ]
            },
            options: {
                responsive: true,
                title: {
                    display: false,
                    text: 'Chart Data'
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    xAxes: [{
                            display: true,
                            scaleLabel: {
                                display: false,
                                labelString: 'Month'
                            }
                        }],
                    yAxes: [{
                            display: true,
                            scaleLabel: {
                                display: false,
                                labelString: 'Value'
                            },

                        }]
                }
            }
        };

        var ctx = document.getElementById('lineChart').getContext('2d');
        window.myLine = new Chart(ctx, config);

        /* Pie chart */
        var ph = "pharmacy";

        var dataPointss = [];
        var color = ['#f56954', '#00a65a', '#f39c12', '#2f4074', '#00c0ef', '#3c8dbc', '#d2d6de', '#b7b83f'];
        var datas = <?php echo json_encode($jsonarr) ?>;
//console.log(datas);

        function addData(datap) {
            for (var i = 0; i < datap.value.length; i++) {
                lb = datap.label[i];

                console.log(lb);
                dataPointss.push({
                    label: lb,
                    value: datap.value[i],
                    color: color[i],
                    highlight: color[i]
                });
            }
            //chart.render();
        }
        addData(datas);
        var labe = ['<?php echo $this->lang->line('opd') ?>', '<?php echo $this->lang->line('ipd') ?>', '<?php echo $this->lang->line('pharmacy') ?>', '<?php echo $this->lang->line('pathology') ?>', '<?php echo $this->lang->line('radiology') ?>', '<?php echo $this->lang->line('operation_theatre') ?>', '<?php echo $this->lang->line('blood_bank') ?>', '<?php echo $this->lang->line('ambulance') ?>', '<?php echo $this->lang->line('income') ?>'];
        /* donut chart */
        var config2 = {
            type: 'doughnut',
            data: {
                datasets: [{
                        data: datas.value,
                        backgroundColor: [
                            '#715d20',
                            window.chartColors.orange,
                            window.chartColors.yellow,
                            window.chartColors.green,
                            window.chartColors.purple,
                            window.chartColors.blue,
                            window.chartColors.grey,
                            '#42b782',
                            '#66aa18',
                        ],
                        label: 'Dataset 1'
                    }],
                labels: labe,
            },
            options: {
                responsive: true,
                circumference: Math.PI,
                rotation: -Math.PI,
                legend: {
                    position: 'top',
                },
                title: {
                    display: false,
                    text: 'Chart.js Doughnut Chart'
                },
                animation: {
                    animateScale: true,
                    animateRotate: true
                }
            }
        };


        var ctx2 = document.getElementById('pieChart').getContext('2d');

        window.myDoughnut = new Chart(ctx2, config2);


    }

    $(document).ready(function () {

        $(document).on('click', '.close_notice', function () {
            var data = $(this).data();
            $.ajax({
                type: "POST",
                url: base_url + "admin/notification/read",
                data: {'notice': data.noticeid},
                dataType: "json",
                success: function (data) {
                    if (data.status == "fail") {

                        errorMsg(data.msg);
                    } else {
                        successMsg(data.msg);
                    }

                }
            });
        });
    });
</script>
