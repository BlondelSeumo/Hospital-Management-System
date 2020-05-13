<style type="text/css">
    .material-switch > input[type="checkbox"] {
        display: none;   
    }

    .material-switch > label {
        cursor: pointer;
        height: 0px;
        position: relative; 
        width: 40px;  
    }

    .material-switch > label::before {
        background: rgb(0, 0, 0);
        box-shadow: inset 0px 0px 10px rgba(0, 0, 0, 0.5);
        border-radius: 8px;
        content: '';
        height: 16px;
        margin-top: -8px;
        position:absolute;
        opacity: 0.3;
        transition: all 0.4s ease-in-out;
        width: 40px;
    }
    .material-switch > label::after {
        background: rgb(255, 255, 255);
        border-radius: 16px;
        box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
        content: '';
        height: 24px;
        left: -4px;
        margin-top: -8px;
        position: absolute;
        top: -4px;
        transition: all 0.3s ease-in-out;
        width: 24px;
    }
    .material-switch > input[type="checkbox"]:checked + label::before {
        background: inherit;
        opacity: 0.5;
    }
    .material-switch > input[type="checkbox"]:checked + label::after {
        background: inherit;
        left: 20px;
    }
</style>

<div class="content-wrapper" style="min-height: 946px;">  

    <!-- Main content -->
    <section class="content">
        <div class="row">        
            <?php $this->load->view('setting/sidebar'); ?>
            <div class="col-md-10">            
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs pull-right">

                        <li><a href="#tab_staff" data-toggle="tab"><?php echo $this->lang->line('staff') ?></a></li>
                        <!--li><a href="#tab_parent" data-toggle="tab"><?php echo $this->lang->line('parent') ?></a></li-->                        
                        <li class="active"><a href="#tab_patients" data-toggle="tab"><?php echo $this->lang->line('patient') ?></a></li>

                        <li class="pull-left header"><?php echo $this->lang->line('users'); ?></li>
                    </ul>
                    <div class="tab-content">

                        <div class="tab-pane active table-responsive" id="tab_patients">
                            <div class="download_label"><?php echo $this->lang->line('users'); ?></div>
                            <table class="table table-striped table-bordered table-hover example" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('patient') . " " . $this->lang->line('id'); ?></th>
                                        <th><?php echo $this->lang->line('name'); ?></th>
                                        <th><?php echo $this->lang->line('username'); ?></th>
                                        <th><?php echo $this->lang->line('mobile_no'); ?></th>

                                        <th class="text-right"><?php echo $this->lang->line('action'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($patientList)) {
                                        $count = 1;
                                        foreach ($patientList as $patient) {
                                            ?>
                                            <tr>
                                                <td><?php echo $patient['patient_unique_id']; ?></td>
                                                <td>
                                                    <a href="#" target="_blank"><?php echo $patient['patient_name']; ?></a>

                                                </td>
                                                <td><?php echo $patient['username']; ?></td>
                                                <td><?php echo $patient['mobileno']; ?></td>

                                                <td class="pull-right">
                                                    <div class="material-switch pull-right">

                                                        <input id="student<?php echo $patient['user_tbl_id'] ?>" name="someSwitchOption001" type="checkbox" data-role="patient" class="chk" data-rowid="<?php echo $patient['user_tbl_id'] ?>" value="checked" <?php if ($patient['user_tbl_active'] == "yes") echo "checked='checked'"; ?> />
                                                        <label for="student<?php echo $patient['user_tbl_id'] ?>" class="label-success"></label>
                                                    </div>

                                                </td>
                                            </tr>
                                            <?php
                                            $count++;
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.tab-pane -->

                        <div class="tab-pane table-responsive" id="tab_staff">
                            <div class="download_label"><?php echo $this->lang->line('users'); ?></div>
                            <table class="table table-striped table-bordered table-hover example" cellspacing="0" width="100%">
                                <thead>
                                    <tr>

                                        <th><?php echo $this->lang->line('staff_id'); ?></th>
                                        <th><?php echo $this->lang->line('name'); ?></th>
                                        <th><?php echo $this->lang->line('email'); ?></th>
                                        <th><?php echo $this->lang->line('role'); ?></th>
                                        <th><?php echo $this->lang->line('designation'); ?></th>
                                        <th><?php echo $this->lang->line('department'); ?></th>
                                        <th><?php echo $this->lang->line('phone'); ?></th>
                                        <th class="text-right"><?php echo $this->lang->line('action'); ?>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($staffList)) {
                                        $count = 1;
                                        foreach ($staffList as $staff) {
                                            if ($staff["role_id"] != 7) {
                                                ?>
                                                <tr>

                                                    <td class="mailbox-name"> <?php echo $staff['employee_id'] ?></td>
                                                    <td class="mailbox-name"> <a href="<?php echo base_url(); ?>admin/staff/profile/<?php echo $staff['id']; ?>"><?php echo $staff['name'] ?></a></td>
                                                    <td class="mailbox-name"> <?php echo $staff['email'] ?></td>
                                                    <td class="mailbox-name"> <?php echo $staff['role'] ?></td>
                                                    <td class="mailbox-name"> <?php echo $staff['designation'] ?></td>
                                                    <td class="mailbox-name"> <?php echo $staff['department'] ?></td>

                                                    <td class="mailbox-name"> <?php echo $staff['contact_no'] ?></td>
                                                    <td class="pull-right">
                                                        <div class="material-switch pull-right">

                                                            <input id="staff<?php echo $staff['id'] ?>" name="someSwitchOption001" type="checkbox" class="chk" data-rowid="<?php echo $staff['id'] ?>" data-role="staff" value="checked" <?php if ($staff['is_active'] == 1) echo "checked='checked'"; ?> />
                                                            <label for="staff<?php echo $staff['id'] ?>" class="label-success"></label>
                                                        </div>

                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        $count++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
            </div> 
        </div> 
    </section>
</div>


<script type="text/javascript">
    $(document).ready(function () {

        $(document).on('click', '.chk', function () {
            var checked = $(this).is(':checked');
            var rowid = $(this).data('rowid');
            var role = $(this).data('role');
            if (checked) {
                if (!confirm('<?php echo $this->lang->line('are_you_sure_active_account') ?>')) {
                    $(this).removeAttr('checked');
                } else {
                    var status = "yes";
                    changeStatus(rowid, status, role);

                }
            } else if (!confirm('<?php echo $this->lang->line('are_you_sure_deactive_account') ?>')) {
                $(this).prop("checked", true);
            } else {
                var status = "no";
                changeStatus(rowid, status, role);

            }
        });
    });

    function changeStatus(rowid, status, role) {


        var base_url = '<?php echo base_url() ?>';

        $.ajax({
            type: "POST",
            url: base_url + "admin/users/changeStatus",
            data: {'id': rowid, 'status': status, 'role': role},
            dataType: "json",
            success: function (data) {
                successMsg(data.msg);
            }
        });
    }


</script>