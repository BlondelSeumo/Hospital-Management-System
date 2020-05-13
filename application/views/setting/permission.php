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
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo $this->lang->line('modules'); ?></h3>
                    </div>
                    <div class="box-body">   
                        <div class="tab-content">
                            <div class="tab-pane active table-responsive" id="tab_students">
                                <div class="download_label"><?php echo $this->lang->line('module'); ?></div>
                                <table class="table table-striped table-bordered table-hover " cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th><?php echo $this->lang->line('name'); ?></th>

                                            <th class="text-right"><?php echo $this->lang->line('action'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (!empty($permissionList)) {
                                            $count = 1;
                                            foreach ($permissionList as $permission) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $permission['name']; ?></td>


                                                    <td class="pull-right">
                                                        <div class="material-switch">

                                                            <input id="student<?php echo $permission['id'] ?>" name="someSwitchOption001" type="checkbox" data-role="student" class="chk" data-rowid="<?php echo $permission['id'] ?>" value="checked" <?php if ($permission['is_active'] == 1) echo "checked='checked'"; ?> />
                                                            <label for="student<?php echo $permission['id'] ?>" class="label-success"></label>
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


                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div>  
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
                if (!confirm('<?php echo $this->lang->line('are_sure_active_permission') ?>')) {
                    $(this).removeAttr('checked');
                } else {
                    var status = "1";
                    changeStatus(rowid, status, role);


                }
            } else if (!confirm('<?php echo $this->lang->line('are_sure_deactive') ?>')) {
                $(this).prop("checked", true);
            } else {
                var status = "0";
                changeStatus(rowid, status, role);

            }
        });
    });

    function changeStatus(rowid, status, role) {


        var base_url = '<?php echo base_url() ?>';

        $.ajax({
            type: "POST",
            url: base_url + "admin/module/changeStatus",
            data: {'id': rowid, 'status': status, 'role': role},
            dataType: "json",
            success: function (data) {
                successMsg(data.msg);
                window.location.reload(true);
            }
        });
    }


</script>