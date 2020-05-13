<div class="content-wrapper" style="min-height: 946px;">  

    <!-- Main content -->
    <section class="content">
        <div class="row">        

            <div class="col-md-12">            
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs pull-right">

                        <li><a href="#tab_patient" data-toggle="tab"><?php echo $this->lang->line('patient'); ?></a></li>
                        <li><a href="#tab_staff" data-toggle="tab"><?php echo $this->lang->line('staff') ?></a></li>
                        <li class="active"><a href="#tab_allusers" data-toggle="tab"><?php echo $this->lang->line('all_users'); ?></a></li>

                        <li class="pull-left header"> <?php echo $this->lang->line('user_log'); ?></li>
                    </ul>
                    <form role="form" action="<?php echo site_url('admin/userlog') ?>" method="post" class="">
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

                    <div class="tabsborderbg"></div>  
                    <div class="tab-content">

                        <div class="tab-pane active table-responsive" id="tab_allusers">

                            <div class="download_label"><?php echo $this->lang->line('user_log'); ?></div>
                            <table class="table table-striped table-bordered table-hover example" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('users'); ?></th>
                                        <th><?php echo $this->lang->line('role'); ?></th>
                                        <th><?php echo $this->lang->line('ip_address'); ?></th>
                                        <th><?php echo $this->lang->line('login_time'); ?></th>
                                        <th><?php echo $this->lang->line('user_agent'); ?></th>                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($userlogList)) {
                                        $count = 1;
                                        foreach ($userlogList as $userlog) {
                                            ?>
                                            <tr>
                                                <td><?php echo $userlog['user']; ?></td>                                                
                                                <td><?php echo ucfirst($userlog['role']); ?></td>
                                                <td><?php echo $userlog['ipaddress']; ?></td>
                                                <td>
                                                    <?php
                                                    $date_time = strtotime($userlog['login_datetime']);
                                                    $date = date('Y-m-d', $date_time);
                                                    $time = date('H:i:s', $date_time);
                                                    echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($date)) . " " . $time;
                                                    ?>

                                                </td>
                                                <td><?php echo $userlog['user_agent']; ?></td>  
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
                            <table class="table table-striped table-bordered table-hover example" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('users'); ?></th>
                                        <th><?php echo $this->lang->line('role'); ?></th>
                                        <th><?php echo $this->lang->line('ip_address'); ?></th>
                                        <th><?php echo $this->lang->line('login_time'); ?></th>
                                        <th><?php echo $this->lang->line('user_agent'); ?></th>                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($userlogStaffList)) {
                                        $count = 1;
                                        foreach ($userlogStaffList as $userlogAdmin) {
                                            ?>
                                            <tr>
                                                <td><?php echo $userlogAdmin['user']; ?></td>                                                
                                                <td><?php echo ucfirst($userlogAdmin['role']); ?></td>
                                                <td><?php echo $userlogAdmin['ipaddress']; ?></td>
                                                <td>
                                                    <?php
                                                    $date_time = strtotime($userlogAdmin['login_datetime']);
                                                    $date = date('Y-m-d', $date_time);
                                                    $time = date('H:i:s', $date_time);
                                                    echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($date)) . " " . $time;
                                                    ?>


                                                </td>
                                                <td><?php echo $userlogAdmin['user_agent']; ?></td>  
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
                        <div class="tab-pane table-responsive" id="tab_patient">
                            <table class="table table-striped table-bordered table-hover example" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('users'); ?></th>
                                        <th><?php echo $this->lang->line('role'); ?></th>
                                        <th><?php echo $this->lang->line('ip_address'); ?></th>
                                        <th><?php echo $this->lang->line('login_time'); ?></th>
                                        <th><?php echo $this->lang->line('user_agent'); ?></th>                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($userlogPatientList)) {
                                        $count = 1;
                                        foreach ($userlogPatientList as $userlogPatient) {
                                            ?>
                                            <tr>
                                                <td><?php echo $userlogPatient['user']; ?></td>                                                
                                                <td><?php echo ucfirst($userlogPatient['role']); ?></td>
                                                <td><?php echo $userlogPatient['ipaddress']; ?></td>
                                                <td>
                                                    <?php
                                                    $date_time = strtotime($userlogPatient['login_datetime']);
                                                    $date = date('Y-m-d', $date_time);
                                                    $time = date('H:i:s', $date_time);
                                                    echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($date)) . " " . $time;
                                                    ?>

                                                </td>
                                                <td><?php echo $userlogPatient['user_agent']; ?></td>  
                                            </tr>
                                            <?php
                                            $count++;
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.tab-content -->
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