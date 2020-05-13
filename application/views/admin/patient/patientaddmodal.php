<?php
$genderList = $this->customlib->getGender();
$marital_status = $this->config->item('marital_status');
$bloodgroup = $this->config->item('bloodgroup');
?>
<div class="modal fade" id="myModalpa"  role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="box-title"><?php echo $this->lang->line('add') . " " . $this->lang->line('patient') ?></h4> 
            </div>
            <form id="formaddpa" accept-charset="utf-8" action="<?php echo base_url() . "admin/patient" ?>" enctype="multipart/form-data" method="post">    
                <div class="modal-body pt0 pb0">
                    <div class="ptt10">

                        <div class="row row-eq">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line('name'); ?></label><small class="req"> *</small> 
                                            <input id="name" name="name" placeholder="" type="text" class="form-control"  value="<?php echo set_value('name'); ?>" />
                                            <span class="text-danger"><?php echo form_error('name'); ?></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line('guardian_name') ?></label>
                                            <input type="text" name="guardian_name" placeholder="" value="" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-12">  
                                        <div class="row">  
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label> <?php echo $this->lang->line('gender'); ?></label>
                                                    <select class="form-control" name="gender" id="addformgender">
                                                        <option value=""><?php echo $this->lang->line('select'); ?></option>
                                                        <?php
                                                        foreach ($genderList as $key => $value) {
                                                            ?>
                                                            <option value="<?php echo $key; ?>" <?php if (set_value('gender') == $key) echo "selected"; ?>><?php echo $value; ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="dob"><?php echo $this->lang->line('date_of_birth'); ?></label> 
                                                    <input type="text" name="dob" id="birth_date" placeholder="" class="form-control date" /><?php echo set_value('dob'); ?>
                                                </div>
                                            </div>

                                            <div class="col-sm-5" id="calculate">
                                                <div class="form-group">
                                                    <label><?php echo $this->lang->line('age') ?></label>
                                                    <div style="clear: both;overflow: hidden;">
                                                        <input type="text" placeholder="<?php echo $this->lang->line('year') ?>" name="age" id="age_year" value="" class="form-control" style="width: 43%; float: left;">
                                                        <input type="text" id="age_month" placeholder="<?php echo $this->lang->line('month') ?>" name="month" value="" class="form-control" style="width: 53%;float: left; margin-left: 4px;">
                                                    </div>
                                                </div>
                                            </div> 
                                        </div>  
                                    </div><!--./col-md-6-->  
                                    <div class="col-md-6 col-sm-12"> 
                                        <div class="row"> 
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label><?php echo $this->lang->line('blood_group'); ?></label>
                                                    <select name="blood_group"  class="form-control" >
                                                        <option value=""><?php echo $this->lang->line('select') ?></option>
                                                        <?php
                                                        foreach ($bloodgroup as $key => $value) {
                                                            ?>
                                                            <option value="<?php echo $value; ?>" <?php if (set_value('blood_group') == $key) echo "selected"; ?>><?php echo $value; ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>   
                                                </div>
                                            </div>

                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="pwd"><?php echo $this->lang->line('marital_status'); ?></label>
                                                    <select name="marital_status" class="form-control">
                                                        <option value=""><?php echo $this->lang->line('select') ?></option>
                                                        <?php foreach ($marital_status as $mkey => $mvalue) {
                                                            ?>
                                                            <option value="<?php echo $mvalue; ?>" <?php if (set_value('marital_status') == $mkey) echo "selected"; ?>><?php echo $mvalue; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>   

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="exampleInputFile">
                                                        <?php echo $this->lang->line('patient') . " " . $this->lang->line('photo'); ?>
                                                    </label>
                                                    <div><input class="filestyle form-control" type='file' name='file' id="file" size='20' data-height="26" />
                                                    </div>
                                                    <span class="text-danger"><?php echo form_error('file'); ?></span>
                                                </div>
                                            </div> 
                                        </div> 
                                    </div><!--./col-md-6-->      


                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="pwd"><?php echo $this->lang->line('phone'); ?></label>
                                            <input id="number" autocomplete="off" name="mobileno"  type="text" placeholder="" class="form-control"  value="<?php echo set_value('mobileno'); ?>" />
                                        </div>
                                    </div> 

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line('email'); ?></label>
                                            <input type="text" placeholder="" id="addformemail" value="<?php echo set_value('email'); ?>" name="email" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="address"><?php echo $this->lang->line('address'); ?></label> 
                                            <input name="address" placeholder="" class="form-control" /><?php echo set_value('address'); ?>
                                        </div> 
                                    </div>


                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="pwd"><?php echo $this->lang->line('remarks'); ?></label> 
                                            <textarea name="note" id="note" class="form-control" ><?php echo set_value('note'); ?></textarea>
                                        </div>
                                    </div>   
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="email"><?php echo $this->lang->line('any_known_allergies'); ?></label> 
                                            <textarea name="known_allergies" id="" placeholder="" class="form-control" ><?php echo set_value('known_allergies'); ?></textarea>
                                        </div> 
                                    </div>  
                                </div><!--./row--> 
                            </div><!--./col-md-8--> 
                        </div><!--./row--> 
                    </div>
                </div>

                <div class="box-footer">
                    <div class="pull-right">
                        <button type="submit" id="formaddpabtn" data-loading-text="<?php echo $this->lang->line('processing') ?>" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                    </div>
                </div>

            </form>                            

        </div>
    </div>    
</div>


<script type="text/javascript">
    $(document).ready(function (e) {
        $("#formaddpa").on('submit', (function (e) {
            $("#formaddpabtn").button('loading');
            e.preventDefault();
            $.ajax({
                url: '<?php echo base_url(); ?>admin/patient/addpatient',
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
                        //$("#myModal").text(data);
                        //window.location.hash = '#myModal'
                        //   $("#myModalpa").modal('hide');
                      
                        //$("#myModal").modal('toggle');
                        $("#myModalpa").modal('toggle');
                        addappointmentModal(data.id, 'myModal');
                       // window.location.reload(true);
                    }
                    $("#formaddpabtn").button('reset');
                },
                error: function () {
                    //  alert("Fail")
                }
            });
        }));
    });

    function addappointmentModal(patient_id = '', modalid) {
        //alert(patient_id);
        var div_data = '';
        $.ajax({
            url: '<?php echo base_url(); ?>admin/patient/getPatientList',
            type: "POST",
            data: '',
            dataType: 'json',
            success: function (data) {
                // $("#addpatient_id").html("");
                $('#addpatient_id').html(div_data);
                $.each(data, function (i, obj)
                {
                    if (obj.id == patient_id) {
                        ne = 'selected';
                    } else {
                        ne = "";
                    }

                    div_data += "<option value='" + obj.id + "' " + ne + " >" + obj.patient_name + " (" + obj.patient_unique_id + ")" + "</option>";
                });

                $('#addpatient_id').append(div_data);
                $('#addpatient_id').select2().select2("val", patient_id);
                get_PatientDetails(patient_id);
                $("#" + modalid).modal('show');
                holdModal(modalid);
            }
        })
    }

    /*	$(document).ready(function(){
     $("#birth_date").change(function(){
     var mdate = $("#birth_date").val().toString();
     var yearThen = parseInt(mdate.substring(6,10), 10);
     //console.log(yearThen);
     var monthThen = parseInt(mdate.substring(0,2), 10);
     //console.log(monthThen);
     var dayThen = parseInt(mdate.substring(3,5), 10);
     
     var today = new Date();
     var birthday = new Date(yearThen, monthThen-1, dayThen);
     
     var differenceInMilisecond = today.valueOf() - birthday.valueOf();
     
     var year_age = Math.floor(differenceInMilisecond / 31536000000);
     var day_age = Math.floor((differenceInMilisecond % 31536000000) / 86400000);
     
     var month_age = Math.floor(day_age/30);
     
     day_age = day_age % 30;
     
     if (isNaN(year_age) || isNaN(month_age) || isNaN(day_age)) {
     $("#exact_age").text("Invalid birthday - Please try again!");
     }
     else {
     $("#exact_age").html("You are<br/><span id=\"age\">" + year_age + " years " + month_age + " months " + day_age + " days</span> old");
     
     $("#age_year").val(year_age);
     $("#age_month").val(month_age);
     $("#age_day").val(day_age);
     
     }
     });
     });*/

    function CalculateAgeInQC(DOB, txtAge, Txndate) {
        if (DOB.value != '') {

            now = new Date(Txndate)

            var txtValue = DOB;

            if (txtValue != null)
                dob = txtValue.split('/');
            if (dob.length === 3) {
                born = new Date(dob[2], dob[1] * 1 - 1, dob[0]);
                if (now.getMonth() == born.getMonth() && now.getDate() == born.getDate()) {
                    age = now.getFullYear() - born.getFullYear();
                } else {
                    age = Math.floor((now.getTime() - born.getTime()) / (365.25 * 24 * 60 * 60 * 1000));
                }
                if (isNaN(age) || age < 0) {
                    // alert('Input date is incorrect!');
                } else {

                    if (now.getMonth() > born.getMonth()) {
                        var calmonth = now.getMonth() - born.getMonth();

                    } else {
                        var calmonth = born.getMonth() - now.getMonth();

                    }
                    //console.log(age);
                    //console.log(now.getMonth());
                    // console.log(calmonth);
                    $("#age_year").val(age);
                    $("#age_month").val(calmonth);
                    return age;
                    //  document.getElementById(txtAge).value = age;
                    // document.getElementById(txtAge).focus();
                }
            }
        }

        //$("#age_day").val(day_age);
    }
    $(document).ready(function () {
        $("#birth_date").change(function () {
            var mdate = $("#birth_date").val().toString();
            var yearThen = parseInt(mdate.substring(6, 10), 10);
            var dayThen = parseInt(mdate.substring(0, 2), 10);
            var monthThen = parseInt(mdate.substring(3, 5), 10);

            var DOB = dayThen + "/" + monthThen + "/" + yearThen;
            // console.log(DOB);
            CalculateAgeInQC(DOB, '', new Date());
        });
    });
</script>