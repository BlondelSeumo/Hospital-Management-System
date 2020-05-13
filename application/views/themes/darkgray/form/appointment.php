<h2 class="text-center"><?php echo $this->lang->line('make_appointment') ?></h2>
<div style="height:50px;">&nbsp;</div>
<form class="form appointment" action="<?php echo site_url('form/appointment') ?>" method="POST">
    <input type="hidden" name="customer_id" value="<?php echo set_value('customer_id') ?>"  class="customer_id">
    <div class="row">

        <?php
if (($this->session->flashdata('msg'))) {
    $message = $this->session->flashdata('msg');
    ?>
            <div class="<?php echo $message['class'] ?>"><?php echo $message['message']; ?></div>
            <?php
}
?>


        <?php //echo validation_errors(); ?>
        <div class="col-md-6">
            <div class="form-group">

                <label style="display: block;"><?php echo $this->lang->line('patient') . " " . $this->lang->line('appointment') ?></label>
                  
                    <label class="radio-inline">
                        <input type="radio" name="patient_type" value="new patient" <?php
    echo set_value('patient_type', 'new patient') == "new patient" ? "checked" : "";
    ?>><?php echo $this->lang->line('new') . " " . $this->lang->line('patient') ?>
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="patient_type" value="old patient" <?php
    echo set_value('patient_type') == "old patient" ? "checked" : "";
    ?>><?php echo $this->lang->line('old') . " " . $this->lang->line('patient') ?>
                    </label>

            
         </div>
        </div><!--./col-md-6-->
        <div class="col-md-6">
            <div class="form-group patient_id <?php
if (form_error('patient_id')) {
    echo 'has-error';
}
?>">
                <label for="date"><?php echo $this->lang->line('patient') . " " . $this->lang->line('id') . " " ?> <span class="text text-danger patient_verify"></span></label>
                <input type="text" class="form-control" onkeyup="getpatientDetails()" id="patient_id" name="patient_id" value="<?php echo set_value('patient_id') ?>" >
            </div>
        </div><!--./col-md-6-->
        <div class="col-md-6">
            <div class="form-group formgroup75 <?php
if (form_error('date')) {
    echo 'has-error';
}
?>">
                <label for="date"><?php echo $this->lang->line('date') . " " ?></label>
                <div class='input-group' >
                    <input type='text' class="form-control" id='datetimepicker' readonly name="date" value="<?php echo set_value('date') ?>"  /><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </div>
            </div>
        </div><!--./col-md-6-->
        <div class="col-md-6">
            <div class="form-group <?php
if (form_error('patient_name')) {
    echo 'has-error';
}
?>">
                <label for="pwd"><?php echo $this->lang->line('patient') . " " . $this->lang->line('name') . " " ?></label>

                <input type="text" name="patient_name" class="form-control"  id="patient_name" value="<?php echo set_value('patient_name') ?>" placeholder="<?php echo $this->lang->line('enter') . " " . $this->lang->line('patient') . " " . $this->lang->line('name') . " :" ?>">

            </div>
        </div><!--./col-md-6-->
        <div class="col-md-6">
            <div class="form-group <?php
if (form_error('gender')) {
    echo 'has-error';
}
?>">
                <label for="pwd"><?php echo $this->lang->line('gender') . " " ?></label>
                <select name="gender" class="form-control" id="gender">
                    <?php
foreach ($gender as $gender_key => $gender_value) {
    ?>
                        <option value="<?php echo $gender_key; ?>"><?php echo $gender_value; ?></option>
                        <?php
}
?>
                </select>
            </div>
        </div><!--./col-md-6-->
        <div class="col-md-6">
            <div class="form-group">
                <label for="pwd"><?php echo $this->lang->line('email') . " " ?></label>
                <input type="email" name="email" class="form-control" id="email" value="<?php echo set_value('email') ?>" placeholder="<?php echo $this->lang->line('enter') . " " . $this->lang->line('email') . " :" ?>">

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group <?php
if (form_error('phone')) {
    echo 'has-error';
}
?>">
                <label for="pwd"><?php echo $this->lang->line('phone') . " " ?></label>

                <input type="text" name="phone" class="form-control" id="phone" value="<?php echo set_value('phone') ?>" placeholder="<?php echo $this->lang->line('enter') . " " . $this->lang->line('phone') . " :" ?>">

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group <?php
if (form_error('doctor')) {
    echo 'has-error';
}
?>">
                <label for="pwd"><?php echo $this->lang->line('doctor') . " " ?></label>

                <select name="doctor" class="form-control select2">
                    <option value=""><?php echo $this->lang->line('select'); ?></option>
                    <?php
foreach ($doctors as $doctors_key => $doctors_value) {
    ?>
                        <option value="<?php echo $doctors_value['id']; ?>"><?php echo $doctors_value['name'] . " " . $doctors_value['surname']; ?></option>
                        <?php
}
?>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group <?php
if (form_error('message')) {
    echo 'has-error';
}
?>">
                <label for="pwd"><?php echo $this->lang->line('message') . " " ?></label>
                <textarea class="form-control" id="message" name="message"  placeholder="<?php echo $this->lang->line('enter') . " " . $this->lang->line('message') ?>"><?php echo set_value('message') ?></textarea>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group pull-right">
                <button type="submit" class="btn btn-default"><?php echo $this->lang->line('send') . " " . $this->lang->line('your') . " " . $this->lang->line('request'); ?></button>
            </div>
        </div>
    </div>
</form>

<script src="<?php echo base_url(); ?>backend/plugins/datepicker/bootstrap-datepicker.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>backend/plugins/select2/select2.min.css">
<script src="<?php echo base_url() ?>backend/plugins/select2/select2.full.min.js"></script>
<script type="text/javascript">

                    $(function () {
                        //Initialize Select2 Elements
                        $('.select2').select2();
                    });

                    $(document).ready(function () {
                        var datetime_format = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(true, true), ['d' => 'DD', 'm' => 'MM', 'Y' => 'YYYY', 'H' => 'hh', 'i' => 'mm']) ?>';
                        $(function () {
                            $('#datetimepicker').datetimepicker({

                                format: datetime_format,
                                ignoreReadonly: true
                            });
                        });
                        var patient_type = "<?php echo set_value('patient_type') ?>";
                        var patient_type = (patient_type == "") ? 'new patient' : patient_type;
                        updatePatientID(patient_type);
                        $('input[type=radio][name=patient_type]').change(function () {
                            updatePatientID(this.value);
                        });

                    });

                    function updatePatientID(patient_type) {
                        if (patient_type == 'old patient') {
                            $('.patient_id').show();
                        } else if (patient_type == 'new patient') {
                            $('.patient_id').hide();


                        }
                    }

                    function getpatientDetails() {
                        var id = $("#patient_id").val();
                        $.ajax({
                            url: '<?php echo base_url(); ?>site/getpatientDetails',
                            type: "POST",
                            data: {patient_id: id},
                            dataType: 'json',
                              beforeSend: function() {
                                $('.patient_verify').text("");
                                  // setting a timeout
                                $("#patient_name,#gender,#email,#phone").val("");
                                $(".customer_id").val(0);
                              },
                            success: function (data) {
                                console.log(data.result.id);
                                if(data.status){
                                $('.customer_id').val(data.result.id);
                                $("#patient_name").val(data.result.patient_name);
                                $("#gender").val(data.result.gender);
                                $("#email").val(data.result.email);
                                $("#phone").val(data.result.mobileno);

                                }else{
$('.patient_verify').text("is Invalid");
                                }
                            }
                        })
                    }
</script>
