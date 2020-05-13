<?php
$currency_symbol = $this->customlib->getSchoolCurrencyFormat();
$genderList = $this->customlib->getGender();
$marital_status = $this->config->item('marital_status');
$bloodgroup = $this->config->item('bloodgroup');
//print_r($genderList);
//exit();
?>
<style type="text/css">
    /*REQUIRED*/
    .carousel-row {
        margin-bottom: 10px;
    }
    .slide-row {
        padding: 0;
        background-color: #ffffff;
        min-height: 150px;
        border: 1px solid #e7e7e7;
        overflow: hidden;
        height: auto;
        position: relative;
    }
    .slide-carousel {
        width: 20%;
        float: left;
        display: inline-block;
    }
    .slide-carousel .carousel-indicators {
        margin-bottom: 0;
        bottom: 0;
        background: rgba(0, 0, 0, .5);
    }
    .slide-carousel .carousel-indicators li {
        border-radius: 0;
        width: 20px;
        height: 6px;
    }
    .slide-carousel .carousel-indicators .active {
        margin: 1px;
    }
    .slide-content {
        position: absolute;
        top: 0;
        left: 20%;
        display: block;
        float: left;
        width: 80%;
        max-height: 76%;
        padding: 1.5% 2% 2% 2%;
        overflow-y: auto;
    }
    .slide-content h4 {
        margin-bottom: 3px;
        margin-top: 0;
    }
    .slide-footer {
        position: absolute;
        bottom: 0;
        left: 20%;
        width: 78%;
        height: 20%;
        margin: 1%;
    }
    /* Scrollbars */
    .slide-content::-webkit-scrollbar {
        width: 5px;
    }
    .slide-content::-webkit-scrollbar-thumb:vertical {
        margin: 5px;
        background-color: #999;
        -webkit-border-radius: 5px;
    }
    .slide-content::-webkit-scrollbar-button:start:decrement,
    .slide-content::-webkit-scrollbar-button:end:increment {
        height: 5px;
        display: block;
    }
</style>

<div class="content-wrapper" style="min-height: 946px;">
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info" style="padding:5px;">
                    <div class="box-header ptbnull">
                        <div class="col-sm-4 col-xs-3">
                            <h3 class="box-title titlefix"><?php
                                echo $this->lang->line('disabled') . " " . $this->lang->line('patient') . " " . $this->lang->line('list') . " ";
                                ?>

                            </h3>
                        </div> 
                        <div class="box-tools pull-right">




                            <a  href="<?php echo base_url() ?>admin/admin/search" class="btn btn-primary btn-sm"><i class="fa fa-reorder"></i> <?php echo $this->lang->line('patient') . " " . $this->lang->line('list'); ?></a> 



                        </div>     

                    </div>

                    <div class="box-body table-responsive">
                        <div class="download_label"><?php
                            echo $this->lang->line('disabled') . " " . $this->lang->line('patient') . " " . $this->lang->line('list') . " ";
                            ?></div>
                        <table class="table table-striped table-bordered table-hover example">
                            <thead>
                                <tr>
                                    <th><?php echo $this->lang->line('patient') . " " . $this->lang->line('id'); ?></th>
                                   <!-- <th><?php echo $this->lang->line('patient') . " " . $this->lang->line('type'); ?></th>-->
                                    <th><?php echo $this->lang->line('patient') . " " . $this->lang->line('name'); ?></th>
                                    <th><?php echo $this->lang->line('age'); ?></th>
                                    <th><?php echo $this->lang->line('gender'); ?></th>
                                    <th><?php echo $this->lang->line('phone'); ?></th>
                                    <th><?php echo $this->lang->line('guardian_name'); ?></th>
                                    <th><?php echo $this->lang->line('address'); ?></th>
                                    <th class=""><?php echo $this->lang->line('action'); ?></th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (empty($resultlist)) {
                                    ?>
                                    <?php
                                } else {

                                    foreach ($resultlist as $report) {
                                        //$patient_type = $report['patient_type'];
                                        $url = '#';
                                        //$patient= array();
                                        $patient_type = $report['id'];
                                        if ($patient_type) {
                                            ?>      
                                            <tr>
                                                <!-- <td><?php echo date($this->customlib->getSchoolDateFormat(true, true), strtotime($report['appointment_date'])) ?></td> -->

                                                <td><?php echo $report['patient_unique_id']; ?></td>

                                                <td>
                                                    <a href="#" data-toggle="modal"  onclick="getpatientData('<?php echo $report['id'] ?>')" data-target="" class="" title="" ><?php echo $report['patient_name'] ?>
                                                    </a>
                                                </td>
                                                <td><?php echo $report['age']; ?></td>
                                                <td><?php echo $report['gender']; ?></td>
                                                <td><?php echo $report['mobileno']; ?></td>
                                                <td><?php echo $report['guardian_name']; ?></td>
                                                <td><?php echo $report['address']; ?></td>
                                                <td class="">
                                                    <a href="#" data-toggle="modal"  onclick="getpatientData('<?php echo $report['id'] ?>')" data-target="" class="btn btn-default btn-xs" 
                                                       title="<?php echo $this->lang->line('show'); ?>" >
                                                        <i class="fa fa-reorder"></i>
                                                    </a>
                                                    <!-- <?php if ($this->rbac->hasPrivilege('patient', 'can_delete')) { ?>
                                                                    <a class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('delete'); ?>" onclick="delete_recordById('<?php echo base_url(); ?>admin/patient/deletePatient/<?php echo $report['id'] ?>', '<?php echo $this->lang->line('delete_message') ?>')">
                                                                        <i class="fa fa-trash"></i>
                                                                    </a>
                                                    <?php } ?>-->
                                                    <!--<div class="btn-group" style="margin-left:2px;">
                                                    <?php if (!empty($report['info'])) { ?>
                                                                                    <a style="width: 20px;border-radius: 2px;" href="" style="" class="btn btn-default btn-xs" data-toggle="dropdown">
                                                                                            <i class="fa fa-ellipsis-v"></i>
                                                                                    </a>
                                                                                            <ul class="dropdown-menu dropdown-menu2" role="menu">
                                                        <?php
                                                        foreach ($report['info'] as $key => $value) {
                                                            ?>
                                                                                                                    <li><a href="<?php echo $report['url'][$key] ?>" >
                                                            <?php echo $value; ?>
                                                                                                                    </a>
                                                                                                                    </li>
                                                        <?php } ?>
                                                                                            </ul>
                                                    <?php } ?>
                                                            </div>-->
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    //exit();
                                    ?>
                                </tbody>

                            <?php } ?>
                        </table>

                    </div>
                </div>
            </div>  
        </div>   

    </section>
</div>

<div class="modal fade" id="myModal"  role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close pt4" data-toggle="tooltip" title="Close"  data-dismiss="modal">&times;</button>
                <div class="modalicon"> 
                    <div id='edit_delete' class="pt4">
                        <?php if ($this->rbac->hasPrivilege('revisit', 'can_edit')) { ?>

                            <a href="#"  data-toggle="tooltip" title="<?php echo $this->lang->line('edit'); ?>" ><i class="fa fa-pencil"></i></a>
                            <?php
                        }
                        if ($this->rbac->hasPrivilege('revisit', 'can_delete')) {
                            ?>
                            <a href="#" data-toggle="tooltip" title="" data-original-title="<?php echo $this->lang->line('delete'); ?>"><i class="fa fa-trash"></i></a>
                        <?php } ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 col-xs-3">
                        <div class="form-group15">




                        </div>
                    </div><!--./col-sm-4--> 
                </div><!-- ./row -->                
            </div><!--./modal-header-->

            <div class="modal-body pt0 pb0">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <form id="formadd" accept-charset="utf-8" action="<?php echo base_url() . "admin/patient" ?>" enctype="multipart/form-data" method="post">
                            <input class="" name="id" type="hidden" id="patientid">
                            <div class="row row-eq">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="row ptt10">
                                        <div class="col-md-9 col-sm-9 col-xs-9" id="Myinfo">

                                            <ul class="singlelist">
                                                <li class="singlelist24bold">
                                                    <span id="patient_name"></span></li>
                                                <li>
                                                    <i class="fas fa-user-secret" data-toggle="tooltip" data-placement="top" title="Patient"></i>
                                                    <span id="guardian"></span>
                                                </li>
                                            </ul>   
                                            <ul class="multilinelist">   
                                                <li>
                                                    <i class="fas fa-venus-mars" data-toggle="tooltip" data-placement="top" title="Gender"></i>
                                                    <span id="genders" ></span>
                                                </li>
                                                <li>
                                                    <i class="fas fa-tint" data-toggle="tooltip" data-placement="top" title="Blood Group"></i>
                                                    <span id="blood_group"></span>
                                                </li>
                                                <li>
                                                    <i class="fas fa-ring" data-toggle="tooltip" data-placement="top" title="Marital Status"></i>
                                                    <span id="marital_status"></span>
                                                </li> 
                                            </ul>  
                                            <ul class="singlelist">  
                                                <li>
                                                    <i class="fas fa-hourglass-half" data-toggle="tooltip" data-placement="top" title="Age"></i>
                                                    <span id="age"></span>
                                                </li>    

                                                <li>
                                                    <i class="fa fa-phone-square" data-toggle="tooltip" data-placement="top" title="Phone"></i> 
                                                    <span id="contact"></span>
                                                </li>
                                                <li>
                                                    <i class="fa fa-envelope" data-toggle="tooltip" data-placement="top" title="Email"></i>
                                                    <span id="email"></span>
                                                </li>
                                                <li>
                                                    <i class="fas fa-street-view" data-toggle="tooltip" data-placement="top" title="Address"></i>
                                                    <span id="address" ></span>
                                                </li>

                                                <li>
                                                    <b><?php echo $this->lang->line('any_known_allergies') ?> </b> 
                                                    <span id="allergies" ></span>
                                                </li>
                                                <li>
                                                    <b><?php echo $this->lang->line('remarks') ?> </b> 
                                                    <span id="note"></span>
                                                </li>    
                                            </ul>                               
                                        </div><!-- ./col-md-9 -->
                                        <div class="col-md-3 col-sm-3 col-xs-3"> 
                                            <div class="pull-right">  

                                                <?php $file = "uploads/patient_images/no_image.png"; ?>        
                                                <img class="profile-user-img img-responsive" src="<?php echo base_url() . $file ?>" id="image" alt="User profile picture">
                                            </div>           
                                        </div><!-- ./col-md-3 --> 
                                    </div>

                                </div><!--./col-md-8--> 

                            </div><!--./row--> 

                            <div class="row">            
                                <div class="box-footer">
                                    <div class="pull-right">
                                       <!--  <button type="submit" id="formaddbtn" data-loading-text="<?php echo $this->lang->line('processing') ?>" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button> -->
                                    </div>
                                </div>
                            </div><!--./row-->  
                        </form>                       
                    </div><!--./col-md-12-->       
                </div><!--./row--> 
            </div>
        </div>
    </div>    
</div>


<div class="modal fade" id="editModal"  role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close pt4" data-dismiss="modal">&times;</button>
                <h4 class="box-title"> <?php echo $this->lang->line('patient') . " " . $this->lang->line('information'); ?></h4> 
            </div><!--./modal-header-->

            <div class="modal-body pt0 pb0">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <form id="formeditpa" accept-charset="utf-8" action="" enctype="multipart/form-data" method="post">
                            <input id="eupdateid" name="updateid" placeholder="" type="hidden" class="form-control"  value="" />
                            <div class="row row-eq">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="row ptt10">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('name'); ?></label><small class="req"> *</small> 
                                                <input id="ename" name="name" placeholder="" type="text" class="form-control"  value="<?php echo set_value('name'); ?>" />
                                                <span class="text-danger"><?php echo form_error('name'); ?></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('guardian_name') ?></label>
                                                <input type="text" name="guardian_name"  id="eguardian_name"placeholder="" value="" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-sm-12">  
                                            <div class="row">  
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label> <?php echo $this->lang->line('gender'); ?></label>
                                                        <select class="form-control" name="gender" id="egenders">
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
                                                        <input type="text" name="dob" id="ebirth_date" placeholder="" class="form-control date" /><?php echo set_value('dob'); ?>
                                                    </div>
                                                </div>

                                                <div class="col-sm-5" id="calculate">
                                                    <div class="form-group">
                                                        <label><?php echo $this->lang->line('age') ?></label>
                                                        <div style="clear: both;overflow: hidden;">
                                                            <input type="text" placeholder="<?php echo $this->lang->line('year') ?>" name="age" id="eage_year" value="" class="form-control" style="width: 43%; float: left;">
                                                            <input type="text" id="eage_month" placeholder="<?php echo $this->lang->line('month') ?>" name="month" value="" class="form-control" style="width: 53%;float: left; margin-left: 4px;">
                                                        </div>
                                                    </div>
                                                </div> 
                                            </div>  
                                        </div><!--./col-md-6-->  
                                        <div class="col-md-6 col-sm-12"> 
                                            <div class="row"> 
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label> <?php echo $this->lang->line('blood_group'); ?></label>
                                                        <select class="form-control" id="blood_groups" name="blood_group">
                                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                                            <?php
                                                            foreach ($bloodgroup as $key => $value) {
                                                                ?>
                                                                <option value="<?php echo $value; ?>" <?php if (set_value('blood_group') == $key) echo "selected"; ?>><?php echo $value; ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                        <span class="text-danger"><?php echo form_error('blood_group'); ?></span>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label for="pwd"><?php echo $this->lang->line('marital_status'); ?></label>
                                                        <select name="marital_status" id="maritalstatuss" class="form-control">
                                                            <option value=""><?php echo $this->lang->line('select') ?></option>
                                                            <?php foreach ($marital_status as $key => $value) {
                                                                ?>
                                                                <option value="<?php echo $value; ?>" <?php if (set_value('marital_status') == $key) echo "selected"; ?>><?php echo $value; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>   

                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="exampleInputFile">
                                                            <?php echo $this->lang->line('patient') . " " . $this->lang->line('photo'); ?>
                                                        </label>
                                                        <div><input  class="filestyle form-control" type='file' name='file' id="exampleInputFile" size='20' data-height="26" data-default-file="<?php echo base_url() ?>uploads/patient_images/no_image.png" >

                                                        </div>
                                                        <span class="text-danger"><?php echo form_error('file'); ?></span>
                                                    </div>
                                                </div> 
                                            </div> 
                                        </div><!--./col-md-6-->      


                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="pwd"><?php echo $this->lang->line('phone'); ?></label>
                                                <input id="emobileno" autocomplete="off" name="contact"  type="text" placeholder="" class="form-control"  value="<?php echo set_value('mobileno'); ?>" />
                                            </div>
                                        </div> 

                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('email'); ?></label>
                                                <input type="text" placeholder="" id="eemail" value="<?php echo set_value('email'); ?>" name="email" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="address"><?php echo $this->lang->line('address'); ?></label> 
                                                <input name="address" id="eaddress" placeholder="" class="form-control" /><?php echo set_value('address'); ?>
                                            </div> 
                                        </div>


                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="pwd"><?php echo $this->lang->line('remarks'); ?></label> 
                                                <textarea name="note" id="enote" class="form-control" ><?php echo set_value('note'); ?></textarea>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="email"><?php echo $this->lang->line('any_known_allergies'); ?></label> 
                                                <textarea name="known_allergies" id="eknown_allergies" placeholder="" class="form-control" ><?php echo set_value('address'); ?></textarea>
                                            </div> 
                                        </div>  
                                    </div><!--./row--> 
                                </div><!--./col-md-8--> 
                            </div><!--./row--> 

                            <div class="row">            
                                <div class="box-footer">
                                    <div class="pull-right">
                                        <button type="submit" id="formeditpabtn" data-loading-text="<?php echo $this->lang->line('processing') ?>" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                                    </div>
                                </div>
                            </div><!--./row-->  
                        </form>                       
                    </div><!--./col-md-12-->       
                </div><!--./row--> 
            </div>
        </div>
    </div>    
</div>

<script type="text/javascript">
    /* $(document).ready(function (e) {
     var date_format = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(), ['d' => 'dd', 'm' => 'mm', 'Y' => 'yyyy',]) ?>';
     $('#date_from,#date_to').datepicker({
     format: date_format,
     autoclose: true
     });
     
     showdate('<?php echo $search_type; ?>');
     });*/

    /* $('#myModalpa').on('hidden.bs.modal', function (e) {
     $(this).find('#formaddpa')[0].reset();
     });*/
    function showdate(value) {

        if (value == 'period') {
            $('#fromdate').show();
            $('#todate').show();
        } else {
            $('#fromdate').hide();
            $('#todate').hide();
        }
    }

    function holdModal(modalId) {

        $('#' + modalId).modal({
            backdrop: 'static',
            keyboard: false,
            show: true
        });
    }



    function getpatientData(id) {
        $.ajax({
            url: '<?php echo base_url(); ?>admin/patient/getpatientDetails',
            type: "POST",
            data: {id: id},
            dataType: 'json',
            success: function (data) {
                if (data.is_active == 'yes') {
                    var link = "<?php if ($this->rbac->hasPrivilege('enabled_disabled', 'can_view')) { ?><a href='#' data-toggle='tooltip'  onclick='patient_deactive(" + id + ")' data-original-title='<?php echo $this->lang->line('disable'); ?>'><i class='fa fa-thumbs-o-down'></i></a><?php } ?>";

                } else {
                    var link = "<?php if ($this->rbac->hasPrivilege('patient', 'can_delete')) { ?><a href='#' data-toggle='tooltip'  onclick='patient_active(" + id + ")' data-original-title='<?php echo $this->lang->line('enable'); ?>'><i class='fa fa-thumbs-o-up'></i></a><?php } if ($this->rbac->hasPrivilege('patient', 'can_delete')) { ?> <a href='#' data-toggle='tooltip'  onclick='delete_record(" + id + ")' data-original-title='<?php echo $this->lang->line('delete'); ?>'><i class='fa fa-trash'></i></a><?php } ?>";

                }

                $("patientid").val(data.id);
                $("#patient_name").html(data.patient_name);
                $("#guardian").html(data.guardian_name);
                $("#patients_id").html(data.patient_unique_id);
                $("#genders").html(data.gender);
                $("#marital_status").html(data.marital_status);
                $("#contact").html(data.mobileno);
                $("#email").html(data.email);
                $("#address").html(data.address);
                $("#is_active").html(data.is_active);
                $("#blood_group").html(data.blood_group);
                if (data.age == "") {
                    $("#age").html("");
                } else {
                    $("#age").html(data.age + " Years " + data.month + " Month (" + data.dob + ")");
                }

                $("#allergies").html(data.known_allergies);
                $("#note").html(data.note);
                $("#image").attr("src", '<?php echo base_url() ?>' + data.image);
                $('#edit_delete').html("<?php if ($this->rbac->hasPrivilege('patient', 'can_edit')) { ?><a href='#' onclick='editRecord(" + id + ")' data-toggle='tooltip' title='<?php echo $this->lang->line('edit'); ?>' data-target='' data-toggle='modal'  data-original-title='<?php echo $this->lang->line('edit'); ?>'><i class='fa fa-pencil'></i></a><?php } ?> " + link + "<?php ?>");

                holdModal('myModal');

            },
        });
    }

    function editRecord(id) {
        // var $exampleDestroy =$('#edit_consdoctor').select2();
        // alert("hello")
        $.ajax({
            url: '<?php echo base_url(); ?>admin/patient/getpatientDetails',
            type: "POST",
            data: {id: id},
            dataType: 'json',
            success: function (data) {
                $("#eupdateid").val(data.id);
                $("#ename").val(data.patient_name);
                $("#eguardian_name").val(data.guardian_name);
                $("#emobileno").val(data.mobileno);
                $("#eemail").val(data.email);
                $("#eaddress").val(data.address);
                $("#eage_year").val(data.age);
                $("#eage_month").val(data.month);
                $("#ebirth_date").val(data.dob);
                $("#enote").val(data.note);
                $("#exampleInputFile").attr("data-default-file", '<?php echo base_url() ?>' + data.image);
                $(".dropify-render").find("img").attr("src", '<?php echo base_url() ?>' + data.image);
                // $("#imagefile").attr("src",'<?php echo base_url() ?>'+data.image);
                $("#eknown_allergies").val(data.known_allergies);
                $('select[id="blood_groups"] option[value="' + data.blood_group + '"]').attr("selected", "selected");
                $('select[id="egenders"] option[value="' + data.gender + '"]').attr("selected", "selected");
                $('select[id="marital_statuss"] option[value="' + data.marital_status + '"]').attr("selected", "selected");
                $("#myModal").modal('hide');
                holdModal('editModal');

            },
        });
    }

    $(document).ready(function (e) {
        $("#formeditpa").on('submit', (function (e) {
            $("#formeditpabtn").button('loading');
            e.preventDefault();
            $.ajax({
                url: '<?php echo base_url(); ?>admin/patient/update',
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
                    $("#formeditpabtn").button('reset');
                },
                error: function () {
                    //  alert("Fail")
                }
            });
        }));
    });
    function delete_record(id) {
        //console.log(id);
        //alert("delete")
        if (confirm(<?php echo "'" . $this->lang->line('delete_conform') . "'"; ?>)) {
            $.ajax({
                url: '<?php echo base_url(); ?>admin/patient/deletePatient',
                type: "POST",
                data: {delid: id},
                dataType: 'json',
                success: function (data) {
                    successMsg(<?php echo "'" . $this->lang->line('delete_message') . "'"; ?>);
                    window.location.reload(true);
                }
            })
        }
    }

    function patient_deactive(id) {

        if (confirm(<?php echo "'" . $this->lang->line('are_you_sure_deactive_account') . "'"; ?>)) {
            $.ajax({
                url: '<?php echo base_url(); ?>admin/patient/deactivePatient',
                type: "POST",
                data: {id: id},
                dataType: 'json',
                success: function (data) {
                    successMsg(<?php echo "'" . $this->lang->line('deactive_message') . "'"; ?>);
                    //window.location.reload(true);
                    //$('#myModal').modal('hide');
                    window.getpatientData(id);
                    /*$(window).load(function(){
                     $('#myModal').modal('show');
                     });*/
                }
            })
        }
    }

    $(document).ready(function () {
        $("#ebirth_date").change(function () {
            var mdate = $("#ebirth_date").val().toString();
            var yearThen = parseInt(mdate.substring(6, 10), 10);
            //console.log(yearThen);
            var monthThen = parseInt(mdate.substring(0, 2), 10);
            //console.log(monthThen);
            var dayThen = parseInt(mdate.substring(3, 5), 10);

            var today = new Date();
            var birthday = new Date(yearThen, monthThen - 1, dayThen);

            var differenceInMilisecond = today.valueOf() - birthday.valueOf();

            var year_age = Math.floor(differenceInMilisecond / 31536000000);
            var day_age = Math.floor((differenceInMilisecond % 31536000000) / 86400000);

            /*if ((today.getMonth() == birthday.getMonth()) && (today.getDate() == birthday.getDate())) {
             alert("Happy B'day!!!");
             }*/

            var month_age = Math.floor(day_age / 30);

            day_age = day_age % 30;

            if (isNaN(year_age) || isNaN(month_age) || isNaN(day_age)) {
                $("#exact_age").text("Invalid birthday - Please try again!");
            } else {
                $("#exact_age").html("You are<br/><span id=\"age\">" + year_age + " years " + month_age + " months " + day_age + " days</span> old");

                $("#eage_year").val(year_age);
                $("#eage_month").val(month_age);
                $("#eage_day").val(day_age);

            }
        });
    });


    function patient_active(id) {
        //console.log(id);
        if (confirm(<?php echo "'" . $this->lang->line('are_you_sure_active_account') . "'"; ?>)) {
            $.ajax({
                url: '<?php echo base_url(); ?>admin/patient/activePatient',
                type: "POST",
                data: {activeid: id},
                dataType: 'json',
                success: function (data) {
                    //console.log(data);
                    successMsg(<?php echo "'" . $this->lang->line('active_message') . "'"; ?>);
                    // window.location.reload(true);
                    // $('#myModal').modal('hide');
                    window.getpatientData(id);
                    /* $(window).load(function(){
                     $('#myModal').modal('show');
                     });*/
                }
            })
        }
    }
</script>
<?php $this->load->view('admin/patient/patientaddmodal') ?>