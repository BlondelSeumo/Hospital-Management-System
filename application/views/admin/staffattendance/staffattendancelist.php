
<style type="text/css">
    .radio {
        padding-left: 20px; }
    .radio label {
        display: inline-block;
        vertical-align: middle;
        position: relative;
        padding-left: 5px; }
    .radio label::before {
        content: "";
        display: inline-block;
        position: absolute;
        width: 17px;
        height: 17px;
        left: 0;
        margin-left: -20px;
        border: 1px solid #cccccc;
        border-radius: 50%;
        background-color: #fff;
        -webkit-transition: border 0.15s ease-in-out;
        -o-transition: border 0.15s ease-in-out;
        transition: border 0.15s ease-in-out; }
    .radio label::after {
        display: inline-block;
        position: absolute;
        content: " ";
        width: 11px;
        height: 11px;
        left: 3px;
        top: 3px;
        margin-left: -20px;
        border-radius: 50%;
        background-color: #555555;
        -webkit-transform: scale(0, 0);
        -ms-transform: scale(0, 0);
        -o-transform: scale(0, 0);
        transform: scale(0, 0);
        -webkit-transition: -webkit-transform 0.1s cubic-bezier(0.8, -0.33, 0.2, 1.33);
        -moz-transition: -moz-transform 0.1s cubic-bezier(0.8, -0.33, 0.2, 1.33);
        -o-transition: -o-transform 0.1s cubic-bezier(0.8, -0.33, 0.2, 1.33);
        transition: transform 0.1s cubic-bezier(0.8, -0.33, 0.2, 1.33); }
    .radio input[type="radio"] {
        opacity: 0;
        z-index: 1; }
    .radio input[type="radio"]:focus + label::before {
        outline: thin dotted;
        outline: 5px auto -webkit-focus-ring-color;
        outline-offset: -2px; }
    .radio input[type="radio"]:checked + label::after {
        -webkit-transform: scale(1, 1);
        -ms-transform: scale(1, 1);
        -o-transform: scale(1, 1);
        transform: scale(1, 1); }
    .radio input[type="radio"]:disabled + label {
        opacity: 0.65; }
    .radio input[type="radio"]:disabled + label::before {
        cursor: not-allowed; }
    .radio.radio-inline {
        margin-top: 0; }
    .radio-primary input[type="radio"] + label::after {
        background-color: #337ab7; }
    .radio-primary input[type="radio"]:checked + label::before {
        border-color: #337ab7; }
    .radio-primary input[type="radio"]:checked + label::after {
        background-color: #337ab7; }
    .radio-danger input[type="radio"] + label::after {
        background-color: #d9534f; }
    .radio-danger input[type="radio"]:checked + label::before {
        border-color: #d9534f; }
    .radio-danger input[type="radio"]:checked + label::after {
        background-color: #d9534f; }
    .radio-info input[type="radio"] + label::after {
        background-color: #5bc0de; }
    .radio-info input[type="radio"]:checked + label::before {
        border-color: #5bc0de; }
    .radio-info input[type="radio"]:checked + label::after {
        background-color: #5bc0de;}
    @media (max-width:767px){
        .radio.radio-inline {display: inherit;}
    }    
</style>

<div class="content-wrapper" style="min-height: 946px;">
    <!-- Content Header (Page header) -->

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">

                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo $this->lang->line('staff') . " " . $this->lang->line('attendance'); ?></h3>

                    </div>
                    <form id='form1' action="<?php echo site_url('admin/staffattendance/index') ?>"  method="post" accept-charset="utf-8">
                        <div class="box-body">
                            <?php
                            if ($this->session->flashdata('msg')) {
                                echo $this->session->flashdata('msg');
                            }
                            ?>

                            <?php echo $this->customlib->getCSRF(); ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('role'); ?></label>

                                        <select id="class_id" name="user_id" class="form-control" >
                                            <option value="select"><?php echo $this->lang->line('select'); ?></option>
                                            <?php
                                            foreach ($classlist as $key => $class) {
                                                ?>
                                                <option value="<?php echo $class["type"] ?>"   <?php
                                                if ($class["type"] == $user_type_id) {
                                                    echo "selected =selected";
                                                }
                                                ?>><?php print_r($class["type"]) ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                        </select>
                                        <span class="text-danger"><?php echo form_error('class_id'); ?></span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">
                                            <?php echo $this->lang->line('attendance'); ?>
                                            <?php echo $this->lang->line('date'); ?>
                                        </label>
                                        <input id="date" name="date" placeholder="" type="text" class="form-control date"  value="<?php echo set_value('date', date($this->customlib->getSchoolDateFormat())); ?>" readonly="readonly"/>
                                        <span class="text-danger"><?php echo form_error('date'); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" name="search" value="search" class="btn btn-primary btn-sm pull-right checkbox-toggle"><i class="fa fa-search"></i> <?php echo $this->lang->line('search'); ?></button>
                        </div>
                    </form>

                    <?php
                    if (isset($resultlist)) {
                        ?>
                        <div class="ptbnull"></div>  
                        <div class="box border0 clear">
                            <div class="box-body">
                                <?php
                                if (!empty($resultlist)) {
                                    $checked = "";
                                    if (!isset($msg)) {
                                        if ($resultlist[0]['staff_attendance_type_id'] != "") {
                                            if ($resultlist[0]['staff_attendance_type_id'] != 5) {
                                                ?>
                                                <div class="alert alert-success"><?php echo $this->lang->line('attendance_already_submitted_you_can_edit_record'); ?></div>
                                                <?php
                                            } else {
                                                $checked = "checked='checked'";
                                                ?>
                                                <div class="alert alert-warning"><?php echo $this->lang->line('attendance_already_submitted_as_holiday'); ?>. <?php echo $this->lang->line('you_can_edit_record'); ?></div>
                                                <?php
                                            }
                                        }
                                    } else {
                                        ?>
                                        <div class="alert alert-success"><?php echo $this->lang->line('attendance_saved_successfully'); ?></div>
                                        <?php
                                    }
                                    ?>
                                    <form action="<?php echo site_url('admin/staffattendance/index') ?>" method="post">
                                        <?php echo $this->customlib->getCSRF(); ?>
                                        <div class="mailbox-controls">
                                            <span class="button-checkbox">
                                                <button type="button" class="btn btn-sm btn-primary" data-color="primary"><?php echo $this->lang->line('mark_as_holiday'); ?></button>
                                                <input type="checkbox" id="checkbox1" class="hidden" name="holiday" value="checked" <?php echo $checked; ?>/>
                                            </span>
                                            <div class="pull-right">
                                                <?php if ($this->rbac->hasPrivilege('staff_attendance', 'can_add')) { ?>
                                                    <button type="submit" name="search" value="saveattendence" class="btn btn-primary btn-sm pull-right checkbox-toggle"><i class="fa fa-save"></i> <?php echo $this->lang->line('save_attendance'); ?> </button>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <input type="hidden" name="user_id" value="<?php echo $user_type_id; ?>">
                                        <input type="hidden" name="section_id" value="">
                                        <input type="hidden" name="date" value="<?php echo $date; ?>">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-striped example">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th><?php echo $this->lang->line('staff_id'); ?></th>
                                                        <th><?php echo $this->lang->line('name'); ?></th>
                                                        <th><?php echo $this->lang->line('role'); ?></th>
                                                        <th class=""><?php echo $this->lang->line('attendance'); ?></th>
                                                        <th class=""><?php echo $this->lang->line('note'); ?></th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $row_count = 1;
                                                    foreach ($resultlist as $key => $value) {

                                                        $attendendence_id = $value["id"];
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <input type="hidden" name="student_session[]" value="<?php echo $value['staff_id']; ?>">
                                                                <input  type="hidden" value="<?php echo $attendendence_id ?>"  name="attendendence_id<?php echo $value["staff_id"]; ?>">
                                                                <?php echo $row_count; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $value['employee_id']; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $value['name'] . " " . $value['surname']; ?>
                                                            </td>
                                                            <td><?php echo $value['user_type']; ?></td>

                                                            <td>
                                                                <?php
                                                                $c = 1;
                                                                $count = 0;
                                                                foreach ($attendencetypeslist as $key => $type) {

                                                                    if ($type['key_value'] != "H") {
                                                                        $att_type = str_replace(" ", "_", strtolower($type['type']));
                                                                        if ($value["date"] != "xxx") {
                                                                            ?>
                                                                            <div class="radio radio-info radio-inline">
                                                                                <input <?php if ($value['staff_attendance_type_id'] == $type['id']) echo "checked"; ?>  type="radio" id="attendencetype<?php echo $value['staff_id'] . "-" . $count; ?>" value="<?php echo $type['id'] ?>" name="attendencetype<?php echo $value['staff_id']; ?>">
                                                                                <label for="attendencetype<?php echo $value['staff_id'] . "-" . $count; ?>">
                                                                                    <?php echo $this->lang->line(strtolower($type['type'])) . "f"; ?> 
                                                                                </label>
                                                                            </div>
                                                                            <?php
                                                                        }else {
                                                                            ?>

                                                                            <div class="radio radio-info radio-inline">
                                                                                <input <?php if (($c == 1) && ($resultlist[0]['staff_attendance_type_id'] != 5)) echo "checked"; ?> type="radio" id="attendencetype<?php echo $value['staff_id'] . "-" . $count; ?>" value="<?php echo $type['id'] ?>" name="attendencetype<?php echo $value['staff_id']; ?>" >
                                                                                <label for="attendencetype<?php echo $value['staff_id'] . "-" . $count; ?>"> 
                                                                                    <?php echo $this->lang->line(strtolower($type['type'])); ?> 
                                                                                </label>

                                                                            </div>

                                                                            <?php
                                                                        }
                                                                        $c++;
                                                                        $count++;
                                                                    }
                                                                }
                                                                ?>

                                                            </td>
                                                            <?php if ($value["date"] == 'xxx') { ?> 
                                                                <td><input type="text" name="remark<?php echo $value["staff_id"] ?>" ></td>
                                                            <?php } else { ?>

                                                                <td><input type="text" name="remark<?php echo $value["staff_id"] ?>" value="<?php echo $value["remark"]; ?>" ></td>
                                                            <?php } ?>
                                                        </tr>
                                                        <?php
                                                        $row_count++;
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </form>
                                    <?php
                                } else {
                                    ?>
                                    <div class="alert alert-info"><?php echo $this->lang->line('no_record_found'); ?></div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>   
                    <?php
                }
                ?>
                </section>
            </div>

            <script type="text/javascript">
                $(document).ready(function () {
                    $.extend($.fn.dataTable.defaults, {
                        searching: false,
                        ordering: true,
                        paging: false,
                        retrieve: true,
                        destroy: true,
                        info: false
                    });
                    var table = $('.example').DataTable();
                    table.buttons('.export').remove();
                });
            </script>       
            <script type="text/javascript">


                window.onload = function xy() {


                    var ch = '<?php
                if (!empty($resultlist)) {
                    echo $resultlist[0]['staff_attendance_type_id'];
                }
                ?>';

                    if (ch == 5) {

                        $("input[type=radio]").attr('disabled', true);

                    } else {

                        $("input[type=radio]").attr('disabled', false);
                    }

                };
                $(document).ready(function () {


                    $('#checkbox1').change(function () {

                        if (this.checked) {
                            var returnVal = confirm('<?php echo $this->lang->line('are_you_sure') ?>');
                            $(this).prop("checked", returnVal);

                            $("input[type=radio]").attr('disabled', true);


                        } else {
                            $("input[type=radio]").attr('disabled', false);
                            $("input[type=radio][value='1']").attr("checked", "checked");

                        }

                    });
                });


            </script>
            <script type="text/javascript">
                $(function () {
                    $('.button-checkbox').each(function () {
                        var $widget = $(this),
                                $button = $widget.find('button'),
                                $checkbox = $widget.find('input:checkbox'),
                                color = $button.data('color'),
                                settings = {
                                    on: {
                                        icon: 'glyphicon glyphicon-check'
                                    },
                                    off: {
                                        icon: 'glyphicon glyphicon-unchecked'
                                    }
                                };
                        $button.on('click', function () {
                            $checkbox.prop('checked', !$checkbox.is(':checked'));
                            $checkbox.triggerHandler('change');
                            updateDisplay();
                        });
                        $checkbox.on('change', function () {
                            updateDisplay();
                        });

                        function updateDisplay() {
                            var isChecked = $checkbox.is(':checked');
                            $button.data('state', (isChecked) ? "on" : "off");
                            $button.find('.state-icon')
                                    .removeClass()
                                    .addClass('state-icon ' + settings[$button.data('state')].icon);
                            if (isChecked) {
                                $button
                                        .removeClass('btn-success')
                                        .addClass('btn-' + color + ' active');
                            } else {
                                $button
                                        .removeClass('btn-' + color + ' active')
                                        .addClass('btn-primary');
                            }
                        }

                        function init() {
                            updateDisplay();
                            if ($button.find('.state-icon').length == 0) {
                                $button.prepend('<i class="state-icon ' + settings[$button.data('state')].icon + '"></i> ');
                            }
                        }
                        init();
                    });
                });
            </script>        