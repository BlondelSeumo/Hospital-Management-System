<?php
$currency_symbol = $this->customlib->getSchoolCurrencyFormat();
$genderList = $this->customlib->getGender();
//print_r($result['id']);die;
?>
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-3">                
                <div class="box box-primary" <?php
                // if ($result["is_active"] == 0) {
                //     echo "style='background-color:#f0dddd;'";
                // }
                ?>>
                    <div class="box-body box-profile">
                        <?php
                        $image = $result['image'];
                        if (!empty($image)) {

                            $file = $result['image'];
                        } else {

                            $file = "uploads/patient_images/no_image.png";
                        }
                        ?>
                        <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url() . $file ?>" alt="User profile picture">
                        <h3 class="profile-username text-center"><?php echo $result['patient_name']; ?></h3>
                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item listnoback">
                                <b><?php echo $this->lang->line('patient') . " " . $this->lang->line('id') ?></b> <a class="pull-right text-aqua"><?php echo $result['patient_unique_id']; ?></a>
                            </li>

                            <li class="list-group-item listnoback">
                                <b><?php echo $this->lang->line('gender'); ?></b> <a class="pull-right text-aqua"><?php echo $result['gender']; ?></a>
                            </li>
                            <li class="list-group-item listnoback">
                                <b><?php echo $this->lang->line('marital_status'); ?></b> <a class="pull-right text-aqua"><?php echo $result['marital_status']; ?></a>
                            </li>

                            <li class="list-group-item listnoback">
                                <b><?php echo $this->lang->line('phone'); ?></b> <a class="pull-right text-aqua"><?php echo $result['mobileno']; ?></a>
                            </li>
                            <li class="list-group-item listnoback">
                                <b><?php echo $this->lang->line('email'); ?></b> <a class="pull-right text-aqua"><?php echo $result['email']; ?></a>
                            </li>
                            <li class="list-group-item listnoback">
                                <b><?php echo $this->lang->line('address'); ?></b> <a class="pull-right text-aqua"><?php echo $result['address']; ?></a>
                            </li>
                            <li class="list-group-item listnoback">
                                <b><?php echo $this->lang->line('age'); ?></b> <a class="pull-right text-aqua"><?php
                                    if (!empty($result['age'])) {
                                        echo $result['age'] . " " . $this->lang->line('years');
                                    } if (!empty($result['month'])) {
                                        echo $result['month'] . " Month";
                                    }
                                    ?></a>
                            </li>
                            <li class="list-group-item listnoback">
                                <b><?php echo $this->lang->line('guardian_name'); ?></b> <a class="pull-right text-aqua"><?php echo $result['guardian_name']; ?></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title titlefix"><?php echo $this->lang->line('my_appointments'); ?></h3>
                        <div class="box-tools pull-right">
                             <!-- <a data-toggle="modal" data-target="#myModal" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>Add Appointment</a> -->
                            <a href="#" onclick="getRecord('<?php echo $result['id'] ?>', '<?php echo $result['is_active'] ?>')" class="btn btn-primary btn-sm" data-target="#myModal" data-toggle="modal" >
                                <i class="fa fa-plus"></i> <?php echo $this->lang->line('add') . " " . $this->lang->line('appointment'); ?>
                            </a>   
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="download_label"><?php echo $this->lang->line('appointed_patient_list'); ?></div>
                        <table class="table table-striped table-bordered table-hover example" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th><?php echo $this->lang->line('appointment')." ".$this->lang->line('no'); ?></th>
                                    <th><?php echo $this->lang->line('date'); ?></th>
                                    <th><?php echo $this->lang->line('doctor'); ?></th>
                                    <th><?php echo $this->lang->line('status'); ?></th> 
                                    <th><?php echo $this->lang->line('message'); ?></th>
                                    <th><?php echo $this->lang->line('action'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (empty($resultlist)) {
                                    ?>
                                    <?php
                                } else {
                                    $count = 1;
                                    foreach ($resultlist as $appointment) {
                                        if ($appointment["appointment_status"] == "approved") {
                                            $label = "class='label label-success'";
                                            $app_no = $appointment["appointment_no"];
                                        } else if ($appointment["appointment_status"] == "pending") {
                                            $label = "class='label label-warning'";
                                            $app_no =  $this->lang->line($appointment['appointment_status']); 
                                        } else if ($appointment["appointment_status"] == "cancel") {
                                            $label = "class='label label-danger'";
                                        }
                                        ?>
                                        <tr class="">
                                            <td><?php echo  $app_no; ?>
                                            <td><?php echo date($this->customlib->getSchoolDateFormat(true, true), strtotime($appointment['date'])); ?></td>
                                            <td><?php echo $appointment['name'] . " " . $appointment['surname']; ?>
                                            <td><small <?php echo $label ?>><?php echo $this->lang->line($appointment['appointment_status']); ?></small></td> 
                                            <td><?php echo $appointment['message']; ?></td>
                                            </td>
                                            <td>
                                                <?php if ($appointment["appointment_status"] == "pending") { ?> 
                                                    <a href="#" class="btn btn-default btn-xs" data-toggle="tooltip" title="<?php echo $this->lang->line('delete'); ?>" onclick="delete_recordById('<?php echo base_url(); ?>patient/dashboard/deleteappointment/<?php echo $appointment['id'] ?>', '<?php echo $this->lang->line('delete_message'); ?>')" >
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                <?php } ?>                 
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
                </div>                                                    
            </div>  
        </div>
    </section>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="box-title"><?php echo $this->lang->line('appointment') . " " . $this->lang->line('information'); ?></h4> 
            </div>
            <div class="modal-body pt0 pb0">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 paddlr">
                        <form id="formadd" accept-charset="utf-8"  method="post" class="ptt10">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('date'); ?></label>
                                        <small class="req"> *</small> 
                                        <input type="text" id="dates" name="date" class="form-control datetime" value="<?php echo set_value('dates'); ?>">
                                        <span class="text-danger"><?php echo form_error('date'); ?></span>
                                        <input type="hidden" name="patient_id" id="patient_ids" class="form-control" value="<?php echo $result['id']; ?>">
                                        <input type="hidden" name="patient_name" id="patient_names" class="form-control" value="<?php echo $result['patient_name']; ?>">
                                        <select class="form-control" id="gender" name="gender" style="display: none;">
                                            <option value="<?php echo set_value('gender'); ?>"><?php echo $this->lang->line('select'); ?></option>

                                            <option value="<?php echo $result['gender']; ?>" ></option>

                                        </select>
                                        <input type="hidden" name="email" id="emails" class="form-control" value="<?php echo $result['email']; ?>">
                                        <input type="hidden" name="mobileno" id="phones" class="form-control" value="<?php echo $result['mobileno']; ?>">
                                        <input type="hidden" name="appointment_status" value="pending" class="form-control" >
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="exampleInputFile">
                                            <?php echo $this->lang->line('doctor'); ?></label><small class="req"> *</small>

                                        <div>
                                            <select class="form-control" name='doctor' id="doctor" >
                                                <option value="<?php echo set_value('doctor'); ?>"><?php echo $this->lang->line('select') ?></option>
                                                <?php foreach ($doctors as $dkey => $dvalue) {
                                                    ?>
                                                    <option value="<?php echo $dvalue["id"]; ?>"><?php echo $dvalue["name"] . " " . $dvalue["surname"] ?></option>   
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="message"><?php echo $this->lang->line('message'); ?></label> 
                                        <small class="req"> *</small> 
                                        <textarea name="message" id="message" class="form-control" ><?php echo set_value('message'); ?></textarea>
                                        <span class="text-danger"><?php echo form_error('message'); ?></span>
                                    </div> 
                                </div>
                                <div class="box-footer">
                                <div class="" style="padding-right:5px;">
                                    <button type="submit" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                                </div>
                            </div>
                            </div>
                     </form>  
                    </div><!--./col-md-12-->       
                </div><!--./row--> 
            </div>
        </div>
    </div>    
</div>
<script type="text/javascript">
    // $(document).ready(function (e) {
    //   var date_format = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(), ['d' => 'DD', 'm' => 'MM', 'Y' => 'YYYY',]) ?>';
    //   $('#dates').datetimepicker();
    // });

    // function getRecord(id){
    //   alert(id);
    //     $.ajax({
    //         url: '<?php echo base_url(); ?>patient/dashboard/getDetails',
    //         type: "POST",     
    //         data: { patient_id:id}, 
    //         dataType: 'json',
    //         success: function (data) {
    //           $("#patient_id").html(data.id);
    //           $("#patient_name").html(data.patient_name);
    //           $("#contact").html(data.mobileno);
    //           $("#email").html(data.email);
    //           $("#age").html(data.age);
    //           $("#updateid").val(id);
    //         },
    //     })
    // }
    function getRecord(id, active) {
        $.ajax({
            url: '<?php echo base_url(); ?>patient/dashboard/getDetails',
            type: "POST",
            data: {patient_id: id, active: active},
            dataType: 'json',
            success: function (data) {
                $("#patient_ids").val(id);
                $("#patient_names").val(data.patient_name);
                $("#emails").val(data.email);
                $("#phones").val(data.mobileno);
                $('select[id="gender"] option[value="' + data.gender + '"]').attr("selected", "selected");
            },
        })
    }
    $(document).ready(function (e) {
        $("#formadd").on('submit', (function (e) {
            e.preventDefault();
            $.ajax({
                url: '<?php echo base_url(); ?>patient/dashboard/bookAppointment',
                type: "POST",
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    if (data.status == "fail") {
                        var message = "";
                        $.each(data.error, function (index, value) {
                            message += value;
                        });
                        errorMsg(message);
                    } else {
                        successMsg(data.message);
                        window.location.reload(true);
                    }
                },
                error: function () {
                    //  alert("Fail")
                }
            });
        }));
    });

    function delete_recordById(url, Msg) {
        if (confirm(<?php echo "'" . $this->lang->line('delete_conform') . "'"; ?>)) {
            $.ajax({
                url: url,
                success: function (res) {
                    successMsg(Msg);
                    window.location.reload(true);
                }
            })
        }
    }
</script>