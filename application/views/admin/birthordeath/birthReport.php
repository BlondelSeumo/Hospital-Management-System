<?php
$currency_symbol = $this->customlib->getSchoolCurrencyFormat();
$genderList = $this->customlib->getGender();
?>
<style type="text/css">
    #easySelectable {/*display: flex; flex-wrap: wrap;*/}
    #easySelectable li {}
    #easySelectable li.es-selected {background: #2196F3; color: #fff;}
    .easySelectable {-webkit-user-select:none; -moz-user-select:none; -ms-user-select: none;}
</style>
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="row">

            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title titlefix"><?php echo $this->lang->line('birth_record'); ?></h3>
                        <div class="box-tools pull-right">
                            <?php
                            if ($this->rbac->hasPrivilege('birth_record', 'can_add')) {
                                ?>
                                <a data-toggle="modal" onclick="holdModal('myModal')" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> <?php echo $this->lang->line('add') . " " . $this->lang->line('birth_record'); ?></a> 
                            <?php } ?>
                            <div class="btn-group">
                                <ul class="dropdown-menu multi-level pull-right width300" role="menu" aria-labelledby="dropdownMenu1" id="easySelectable">
                                    <li><a href="#">All</a></li>
                                    <li><a href="#">Not Sent</a></li> 
                                    <li><a href="#">Invoiced</a></li>
                                    <li><a href="#">Not Invoiced</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#">Draft</a></li>
                                    <li class="dropdown-submenu pull-left">
                                        <a href="#">Sale Agent</a> 
                                        <ul class="dropdown-menu dropdown-menu-left">
                                            <li><a href="#">Edward Thomas</a></li>
                                            <li><a href="#">Robin Peterson</a></li>
                                            <li><a href="#">Nicolas Fleming</a></li>
                                            <li><a href="#">Glen Stark</a></li>
                                            <li><a href="#">Simon Peterson</a></li>
                                            <li><a href="#">Brian Kohlar</a></li>
                                            <li><a href="#">Laura Clinton</a></li>
                                            <li><a href="#">David Heart</a></li>
                                            <li><a href="#">Emma Thomas</a></li>
                                            <li><a href="#">Benjamin Gates</a></li>
                                            <li><a href="#">Kriti Singh</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">Sent</a></li>
                                    <li><a href="#">Expired</a></li>
                                    <li><a href="#">Declined</a></li>
                                    <li><a href="#">Accepted</a></li>
                                </ul>
                            </div>     
                        </div>    
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="download_label"><?php echo $this->lang->line('birth_record'); ?></div>
                        <table class="table table-striped table-bordered table-hover example" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <!--<th><?php echo $this->lang->line('opd_ipd_no'); ?></th>-->
                                    <th><?php echo $this->lang->line('child') . " " . $this->lang->line('name'); ?></th>
                                    <th><?php echo $this->lang->line('gender'); ?></th>
                                    <th><?php echo $this->lang->line('refrence') . " " . $this->lang->line('no'); ?></th>
                                    <th><?php echo $this->lang->line('birth_date'); ?></th>
                                    <th><?php echo $this->lang->line('mother') . " " . $this->lang->line('name'); ?></th>
                                    <th><?php echo $this->lang->line('father') . " " . $this->lang->line('name'); ?></th>
                                    <th class=""><?php echo $this->lang->line('report'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (empty($resultlist)) {
                                    ?>

                                    <?php
                                } else {
                                    $count = 1;
                                    foreach ($resultlist as $birth) {
                                        ?>
                                        <tr class="">
                                            <td>
                                                <?php echo $birth['child_name']; ?> 
                                                <div class="rowoptionview">
                                                    <a href="#" 
                                                       onclick="viewDetail('<?php echo $birth['id'] ?>')"
                                                       class="btn btn-default btn-xs"  data-toggle="tooltip"
                                                       title="<?php echo $this->lang->line('show'); ?>" >
                                                        <i class="fa fa-reorder"></i>
                                                    </a> 
                                                    <?php
                                                    if ($this->rbac->hasPrivilege('birth_record', 'can_edit')) {
                                                        ?>
                                                        <a href="#" onclick="getRecord('<?php echo $birth['id'] ?>')" class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('edit'); ?>">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>      
                                                    <?php } if ($this->rbac->hasPrivilege('birth_record', 'can_delete')) { ?>
                                                        <a  class="btn btn-default btn-xs" data-toggle="tooltip" title="" onclick="delete_recordById('<?php echo base_url(); ?>admin/birthordeath/delete/<?php echo $birth['id']; ?>', '<?php echo $this->lang->line('delete_message'); ?>')" data-original-title="<?php echo $this->lang->line('delete'); ?>">
                                                            <i class="fa fa-trash"></i>
                                                        </a>    
                                                    <?php } ?> 
                                                </div> 
                                            </td>
                                            <!--<td class=""><?php echo $birth['child_name']; ?></td>-->
                                            <td class=""><?php echo $birth['gender']; ?></td>
                                            <td class=""><?php echo $birth['ref_no']; ?></td>
                                            <td class=""><?php echo date($this->customlib->getSchoolDateFormat(true, true), strtotime($birth['birth_date'])); ?></td>
                                            <td class=""><?php echo $birth['patient_name']; ?></td>
                                            <td class=""><?php echo $birth['father_name']; ?></td>
                                            <td class=""><?php echo $birth['birth_report']; ?></td>
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

<div class="modal fade" id="myModal"  role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="box-title"><?php echo $this->lang->line('add') . " " . $this->lang->line('birth_record'); ?></h4> 
            </div>
            <div class="modal-body pt0 pb0">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 paddlr">
                        <form id="formadd" accept-charset="utf-8" method="post" class="ptt10" >
                            <div class="row">
                                <input type="hidden" id="patient_id" name="mother_name" value=<?php set_value('id') ?>>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('child') . " " . $this->lang->line('name'); ?></label><small class="req"> *</small> 
                                        <input type="text" name="child_name" id="child_name" class="form-control">    
                                        <span class="text-danger"><?php echo form_error('code'); ?></span>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label> <?php echo $this->lang->line('gender'); ?></label><small class="req"> *</small>
                                        <select class="form-control" name="gender">
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                            <?php
                                            foreach ($genderList as $key => $value) {
                                                ?>
                                                <option value="<?php echo $key; ?>" <?php if (set_value('gender') == $key) echo "selected"; ?>><?php echo $value; ?>
                                                </option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('weight'); ?></label> <small class="req">*</small>
                                        <input type="text" name="weight" id="weight" class="form-control">    
                                        <span class="text-danger"><?php echo form_error('weight'); ?></span>
                                    </div> 
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="exampleInputFile">
                                            <?php echo $this->lang->line('child') . " " . $this->lang->line('photo'); ?>
                                        </label>
                                        <div><input class="filestyle form-control" type='file' name='child_img' id="child_img" size='20' data-height="26" />
                                        </div>
                                        <span class="text-danger"><?php echo form_error('file'); ?></span>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('birth_date'); ?></label>
                                        <small class="req">*</small>
                                        <input id="birth_date" name="birth_date" placeholder="" type="text" class="form-control datetime"   />
                                        <span class="text-danger"><?php echo form_error('birth_date'); ?></span>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('phone'); ?></label>
                                        <input type="text" name="contact" id="contact" class="form-control">
                                        <span class="text-danger"><?php echo form_error('contact'); ?></span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('address'); ?></label>
                                        <input type="text" name="address" id="address" class="form-control">    
                                        <span class="text-danger"><?php echo form_error('address'); ?></span>
                                    </div>
                                </div>

                                <!--<div class="col-md-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('mother') . " " . $this->lang->line('name'); ?></label><small class="req"> *</small> 
                                        <input type="text" name="mother_name" id="mother_name" class="form-control">    
                                        <span class="text-danger"><?php echo form_error('mother_name'); ?></span>
                                    </div>
                                </div>-->
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="">
                                            <?php echo $this->lang->line('mother') . " " . $this->lang->line('name'); ?>
                                        </label>
                                        <small class="req">*</small>
                                        <div>
                                            <select onchange="get_PatientDetails(this.value)"  style="width: 100%" class="form-control select2"<?php
                                            if ($disable_option == true) {
                                                echo "disabled";
                                            }
                                            ?> id="" name='' >
                                                <option value=""><?php echo $this->lang->line('select') ?></option>
                                                <?php foreach ($patients as $dkey => $dvalue) {
                                                    ?>
                                                    <option value="<?php echo $dvalue["id"]; ?>" <?php
                                                    if ((isset($patient_select)) && ($patient_select == $dvalue["id"])) {
                                                        echo "selected";
                                                    }
                                                    ?>><?php echo $dvalue["patient_name"] . " ( " . $dvalue["patient_unique_id"] . ")" ?></option>   
<?php } ?>
                                            </select>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('ipd') . " / " . $this->lang->line('opd') . " " . $this->lang->line('no');
;
?></label>
                                        <input type="text" name="opd_ipd_no" id="opd_ipd_no" class="form-control">    
                                        <span class="text-danger"><?php echo form_error('ipd'); ?></span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="exampleInputFile">
<?php echo $this->lang->line('mother') . " " . $this->lang->line('photo'); ?>
                                        </label>
                                        <div><input class="filestyle form-control" type='file' name='first_img' id="first_img" size='20' data-height="26" />
                                        </div>
                                        <span class="text-danger"><?php echo form_error('file'); ?></span>
                                    </div>
                                </div> 
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('father') . " " . $this->lang->line('name'); ?></label> 
                                        <input type="text" name="father_name" id="father_name" class="form-control">    
                                        <span class="text-danger"><?php echo form_error('father_name'); ?></span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="exampleInputFile">
<?php echo $this->lang->line('father') . " " . $this->lang->line('photo'); ?>
                                        </label>
                                        <div><input class="filestyle form-control" type='file' name='second_img' id="second_img" size='20' data-height="26" />
                                        </div>
                                        <span class="text-danger"><?php echo form_error('file'); ?></span>
                                    </div>
                                </div> 


                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="email"><?php echo $this->lang->line('report'); ?></label> 
                                        <textarea name="birth_report" id="birth_report" class="form-control" ><?php echo set_value('birth_report'); ?></textarea>
                                    </div> 
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="exampleInputFile">
<?php echo $this->lang->line('attach_document'); ?>
                                        </label>
                                        <div><input class="filestyle form-control" type='file' name='document' id="document" size='20' data-height="26" />
                                        </div>
                                        <span class="text-danger"><?php echo form_error('file'); ?></span>
                                    </div>
                                </div>

                                <div class="">  
<?php
echo display_custom_fields('birth_report');
?>
                                </div>

                            </div><!--./row-->  

                    </div><!--./col-md-12-->  
                    <div class="box-footer" style="clear: both;">
                        <div class="pull-right">
                            <button type="submit" id="formaddbtn" data-loading-text="<?php echo $this->lang->line('processing') ?>" class="btn btn-info"><?php echo $this->lang->line('save'); ?></button>
                        </div>
                    </div>       
                    </form>     
                </div><!--./row--> 
            </div>
        </div>
    </div>    
</div>
<!-- dd -->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class="modalicon"> 
                    <div id='edit_delete'>
                       
                    </div>
                </div>
                <h4 class="box-title"><?php echo $this->lang->line('birth_record') . " " . $this->lang->line('information'); ?></h4> 
            </div>
            <div class="modal-body pt0 pb0">
                <div class="row">
                    <div class=" table-responsive">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <form id="view" accept-charset="utf-8" method="get" class="ptt10">

                                <table class="table mb0 table-striped table-bordered">
                                    <tr>
                                        <th><?php echo $this->lang->line('child') . " " . $this->lang->line('name'); ?></th>
                                        <th><?php echo $this->lang->line('mother_name'); ?></th>
                                        <th><?php echo $this->lang->line('father_name'); ?></th>
                                    </tr>
                                    <tr>
                                        <td><span id='vchild_name'></span></td> 
                                        <td><span id="vmother_name"></span></td>
                                        <td><span id="vfather_name"></span></td>
                                    </tr>
                                    <tr>
                                        <td class="">

<?php
$file = "uploads/patient_images/no_image.png";
?> 
                                            <div class="childimg">           
                                                <img class="" src="<?php echo base_url() . $file ?>" id="image" alt="User profile picture">
                                            </div> 
                                            <?php echo $this->lang->line('child') . " " . $this->lang->line('photo'); ?>
                                        </td> 

                                        <td class="">
                                            <?php
                                            $file = "uploads/patient_images/no_image.png";
                                            ?>        
                                            <div class="childimg"><img class="" src="<?php echo base_url() . $file ?>" id="imagem" alt="User profile picture"></div>
                                            <?php echo $this->lang->line('mother') . " " . $this->lang->line('photo'); ?>
                                        </td>

                                        <td class="">
                                            <?php
                                            $file = "uploads/patient_images/no_image.png";
                                            ?>        
                                            <div class="childimg"><img class="" src="<?php echo base_url() . $file ?>" id="imagef" alt="User profile picture"></div>
<?php echo $this->lang->line('father') . " " . $this->lang->line('photo'); ?>
                                        </td>

                                    </tr>

                                    <tr>
                                        <th><?php echo $this->lang->line('birth_date'); ?></th>
                                        <td><span id="vbirth_date"></span>
                                        </td>
                                        <th><?php echo $this->lang->line('weight'); ?></th>
                                        <td><span id='vweight'></span></td>
                                        <th><?php echo $this->lang->line('gender'); ?></th>
                                        <td><span id='vgender'></span></td>
                                    </tr>
                                    <tr>
                                        <th><?php echo $this->lang->line('phone'); ?></th>
                                        <td><span id='vcontact'></span></td>
                                        <th><?php echo $this->lang->line('address'); ?></th>
                                        <td><span id='vaddress'></span></td>
                                        <th><?php echo $this->lang->line('document'); ?></th>
                                        <td><span id='download_document'></span>
                                       <!--<a href=""class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('download'); ?>">
<?php echo $this->lang->line('download'); ?>
                                       <i class="fa fa-download"></i>
                                       </a>-->
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><?php echo $this->lang->line('report'); ?></th>
                                        <td><span id='vreport'></span></td>
                                    </tr>

<!--<?php echo base_url(); ?>admin/pharmacy/download/<?php echo $bill['file'] ?>-->
                                    <tr id="field_data">
                                        <th><span id="vcustom_name"></span></th>
                                        <td><span id="vcustom_value"></span></td>
                                    </tr>


                                </table>

                            </form> 
                        </div>                      
                    </div><!--./col-md-12-->       
                </div><!--./row--> 
                <div id="tabledata"></div>
            </div>

            <div class="box-footer">
                <div class="pull-right paddA10">
                </div>
            </div>
        </div>
    </div>    
</div>
<div class="modal fade" id="myModaledit"  role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="box-title"><?php echo $this->lang->line('edit'); ?></h4> 
            </div>
            <div class="modal-body pt0 pb0">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 paddlr">
                        <form id="formedit" accept-charset="utf-8" enctype="multipart/form-data" method="post" class="ptt10">
                            <div class="row">
                                <input type="hidden" name="id" id="eid" value="<?php echo set_value('id'); ?>">

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('child') . " " . $this->lang->line('name'); ?></label><small class="req"> *</small> 
                                        <input type="text" value="<?php echo set_value('child_name'); ?>" name="child_name" id="echild_name" class="form-control">    
                                        <span class="text-danger"><?php echo form_error('child_name'); ?></span>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label> <?php echo $this->lang->line('gender'); ?></label>
                                        <small class="req"> *</small> 
                                        <select class="form-control" name="gender" id="gender">
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
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('weight'); ?></label><small class="req"> *</small> 
                                        <input type="text" value="<?php echo set_value('weight'); ?>" name="weight" id="eweight" class="form-control">    
                                        <span class="text-danger"><?php echo form_error('weight'); ?></span>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="exampleInputFile">
<?php echo $this->lang->line('child') . " " . $this->lang->line('photo'); ?>
                                        </label>
                                        <div><input class="filestyle form-control" type='file' name='child_img' id="echild_img" value="<?php echo set_value('child_pic'); ?>" size='20' data-height="26" />
                                        </div>
                                        <span class="text-danger"><?php echo form_error('file'); ?></span>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('birth_date'); ?></label>
                                        <small class="req">*</small>
                                        <input value="<?php echo set_value('birth_date'); ?>" id="ebirth_date" name="birth_date" placeholder="" type="text" class="form-control datetime"   />
                                        <span class="text-danger"><?php echo form_error('birth_date'); ?></span>
                                    </div>
                                </div>


                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('phone'); ?></label>
                                        <input type="text" value="<?php echo set_value('contact'); ?>" name="contact" id="econtact" class="form-control">    
                                        <span class="text-danger"><?php echo form_error('contact'); ?></span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('address'); ?></label>
                                        <input type="text" value="<?php echo set_value('address'); ?>" name="address" id="eaddress" class="form-control">    
                                        <span class="text-danger"><?php echo form_error('address'); ?></span>
                                    </div>
                                </div>


                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="">
<?php echo $this->lang->line('mother') . " " . $this->lang->line('name'); ?>
                                        </label>
                                        <small class="req">*</small>
                                        <div>
                                            <select onchange="get_PatientDetails(this.value)"  style="width: 100%" class="form-control select2" id="emother_name" name='mother_name' >
                                                <option value="<?php echo set_value('mother_name'); ?>"><?php echo $this->lang->line('select') ?></option>
                                                <?php foreach ($patients as $dkey => $dvalue) {
                                                    ?>
                                                    <option value="<?php echo $dvalue["id"]; ?>" ><?php echo $dvalue["patient_name"] . " ( " . $dvalue["patient_unique_id"] . ")" ?></option>   
<?php } ?>
                                            </select>
                                        </div>

                                    </div>
                                </div>



                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('ipd') . "/" . $this->lang->line('opd') . " " . $this->lang->line('no'); ?></label>
                                        <input type="text" name="opd_ipd_no" value="<?php echo set_value('opd_ipd_no'); ?>" id="eopd_ipd_no" class="form-control">    
                                        <span class="text-danger"><?php echo form_error('ipd'); ?></span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="exampleInputFile">
<?php echo $this->lang->line('mother'); ?>
                                        </label>
                                        <div><input class="filestyle form-control" type='file' name='mother_pic' id="emother_pic" value="<?php echo set_value('mother_pic'); ?>" size='20' data-height="26" />
                                        </div>
                                        <span class="text-danger"><?php echo form_error('file'); ?></span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('father') . " " . $this->lang->line('name'); ?></label> 
                                        <input type="text" value="<?php echo set_value('father_name'); ?>" name="father_name" id="efather_name" class="form-control">    
                                        <span class="text-danger"><?php echo form_error('father_name'); ?></span>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="exampleInputFile">
<?php echo $this->lang->line('father') . " " . $this->lang->line('photo'); ?>
                                        </label>
                                        <div><input class="filestyle form-control" type='file' name='father_pic' id="efather_pic" value="<?php echo set_value('father_pic'); ?>" size='20' data-height="26" />
                                        </div>
                                        <span class="text-danger"><?php echo form_error('file'); ?></span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="email"><?php echo $this->lang->line('report'); ?></label> 
                                        <textarea name="birth_report" id="ebirth_report" class="form-control" ><?php echo set_value('birth_report'); ?></textarea>
                                    </div> 
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="exampleInputFile">
<?php echo $this->lang->line('attach_document') . " " . $this->lang->line('photo'); ?>
                                        </label>
                                        <div><input class="filestyle form-control" type='file' name='document' id="document" value="<?php echo set_value('document'); ?>" size='20' data-height="26" />
                                        </div>
                                        <span class="text-danger"><?php echo form_error('file'); ?></span>
                                    </div>
                                </div>
                            </div>

                            <div class="">
                                <span id="customdata"></span>
                            </div>

                    </div><!--./col-md-12--> 
                    <div class="box-footer" style="clear: both;">

                        <button type="submit" id="formeditbtn" data-loading-text="<?php echo $this->lang->line('processing') ?>" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                    </div>      
                </div><!--./row--> 
            </div> 
            </form>

        </div>
    </div>    
</div>
</div>


<script type="text/javascript">

    $('#myModal').on('hidden.bs.modal', function (e) {
        $(this).find('#formadd')[0].reset();
    });

    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()
    });
    $(function () {
        $('#easySelectable').easySelectable();
        //stopPropagation();
    });
    function apply_to_all() {

        var standard_charge = $("#standard_charge").val();


        $('input name=schedule_charge_id').val(standard_charge);
    }

</script>


<script type="text/javascript">
    /*
     Author: mee4dy@gmail.com
     */
    (function ($) {
        //selectable html elements
        $.fn.easySelectable = function (options) {
            var el = $(this);
            var options = $.extend({
                'item': 'li',
                'state': true,
                onSelecting: function (el) {

                },
                onSelected: function (el) {

                },
                onUnSelected: function (el) {

                }
            }, options);
            el.on('dragstart', function (event) {
                event.preventDefault();
            });
            el.off('mouseover');
            el.addClass('easySelectable');
            if (options.state) {
                el.find(options.item).addClass('es-selectable');
                el.on('mousedown', options.item, function (e) {
                    $(this).trigger('start_select');
                    var offset = $(this).offset();
                    var hasClass = $(this).hasClass('es-selected');
                    var prev_el = false;
                    el.on('mouseover', options.item, function (e) {
                        if (prev_el == $(this).index())
                            return true;
                        prev_el = $(this).index();
                        var hasClass2 = $(this).hasClass('es-selected');
                        if (!hasClass2) {
                            $(this).addClass('es-selected').trigger('selected');
                            el.trigger('selected');
                            options.onSelecting($(this));
                            options.onSelected($(this));
                        } else {
                            $(this).removeClass('es-selected').trigger('unselected');
                            el.trigger('unselected');
                            options.onSelecting($(this))
                            options.onUnSelected($(this));
                        }
                    });
                    if (!hasClass) {
                        $(this).addClass('es-selected').trigger('selected');
                        el.trigger('selected');
                        options.onSelecting($(this));
                        options.onSelected($(this));
                    } else {
                        $(this).removeClass('es-selected').trigger('unselected');
                        el.trigger('unselected');
                        options.onSelecting($(this));
                        options.onUnSelected($(this));
                    }
                    var relativeX = (e.pageX - offset.left);
                    var relativeY = (e.pageY - offset.top);
                });
                $(document).on('mouseup', function () {
                    el.off('mouseover');
                });
            } else {
                el.off('mousedown');
            }
        };
    })(jQuery);

</script>

<script type="text/javascript">
    $(document).ready(function (e) {
        $("#formadd").on('submit', (function (e) {
            $("#formaddbtn").button('loading');
            e.preventDefault();
            $.ajax({
                url: '<?php echo base_url(); ?>admin/birthordeath/addBirthdata',
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
                    $("#formaddbtn").button('reset');
                },
                error: function () {
                }
            });
        }));
    });


    $(document).ready(function (e) {
        $("#formedit").on('submit', (function (e) {
            $("#formeditbtn").button('loading');
            e.preventDefault();
            $.ajax({
                url: '<?php echo base_url(); ?>admin/birthordeath/update_birth',
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
                    $("#formeditbtn").button('reset');
                },
                error: function () {

                }
            });
        }));
    });


    $(document).ready(function (e) {
        var date_format = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(), ['d' => 'DD', 'm' => 'MM', 'Y' => 'YYYY',]) ?>';

        // var capital_date_format=date_format.toUpperCase();      
        //  $.fn.dataTable.moment(capital_date_format);

        $('#dates_of_birth , #date_of_birth').datepicker();
    });



    function get_PatientDetails(id) {
        //$("#patient_name").html("patient_name");
        //$("#schedule_charge").html("schedule_charge");

        $.ajax({
            url: '<?php echo base_url(); ?>admin/pharmacy/patientDetails',
            type: "POST",
            data: {id: id},
            dataType: 'json',
            success: function (res) {

                if (res) {
                    $('#patient_name').val(res.patient_name);
                    $('#patient_id').val(res.id);
                } else {
                    $('#patient_name').val('Null');

                }
            }
        });
    }
    function viewDetail(id) {
        $('#viewModal').modal('show');
        $.ajax({
            url: '<?php echo base_url(); ?>admin/birthordeath/getBirthdata',
            type: "POST",
            data: {id: id},
            dataType: 'json',
            success: function (data) {
                //    console.log(data);
                $("#vid").html(data.id);
                $("#vopd_ipd_no").html(data.opd_ipd_no);
                //console.log(data.child_name);
                $("#vchild_name").html(data.child_name);
                $("#vbirth_date").html(data.birth_date);
                $("#vweight").html(data.weight);
                $("#vmother_name").html(data.patient_name);
                $("#vcontact").html(data.contact);
                $("#vaddress").html(data.address);
                $("#vreport").html(data.birth_report);
                $("#vgender").html(data.gender);
                $("#vfather_name").html(data.father_name);
                //$("#vmother_pic").html(data.mother_pic);
                // $("#vfather_pic").html(data.father_pic);
                $("#vbirth_report").html(data.birth_report);
                $("#image").attr("src", '<?php echo base_url() ?>' + data.child_pic);
                $("#imagem").attr("src", '<?php echo base_url() ?>' + data.mother_pic);
                $("#imagef").attr("src", '<?php echo base_url() ?>' + data.father_pic);
                //$("#imaged").attr("src",'<?php echo base_url() ?>'+data.document);
                /// var downloadid = html(data.document);
                var downloadid = data.document;

                var table_html = '';


                $.each(data.field_data, function (i, obj)
                {
                    if (obj.field_value == null) {
                        var field_value = "";
                    } else {
                        var field_value = obj.field_value;
                    }
                    table_html += "<th><span id='vcustom_name'>" + obj.name + "</span></th><td><span id='vcustom_value'>" + field_value + "</span></td>";
                });
                $("#field_data").html(table_html);
                $('#edit_delete').html("<?php if ($this->rbac->hasPrivilege('birth_record', 'can_view')) { ?><a href='#' data-toggle='tooltip' onclick='printData(" + id + ")'   data-original-title='<?php echo $this->lang->line('print'); ?>'><i class='fa fa-print'></i></a> <?php } ?><?php if ($this->rbac->hasPrivilege('birth_record', 'can_edit')) { ?><a href='#'' onclick='getRecord(" + id + ")' data-toggle='tooltip'  data-original-title='<?php echo $this->lang->line('edit'); ?>'><i class='fa fa-pencil'></i></a><?php } ?><?php if ($this->rbac->hasPrivilege('birth_record', 'can_delete')) { ?><a onclick='delete_bill(" + id + ")'  href='#'  data-toggle='tooltip'  data-original-title='<?php echo $this->lang->line('delete'); ?>'><i class='fa fa-trash'></i></a><?php } ?>");
                if (data.document) {
                    $('#download_document').html("<a href='<?php echo base_url(); ?>admin/birthordeath/download/" + downloadid + "' data-toggle='tooltip'  data-original-title='<?php echo $this->lang->line('download'); ?>'><i class='fa fa-download'></i></a>");
                }
            },
        });
    }




    function getRecord(id) {
        $('#myModaledit').modal('show');
        $.ajax({
            url: '<?php echo base_url(); ?>admin/birthordeath/edit',
            type: "POST",
            data: {id: id},
            dataType: 'json',
            success: function (data) {
                //console.log(data.field_data);
                $("#eid").val(data.id);
                // console.log(id);
                var $exampleDestroy = $('#emother_name').select2();

                var table_html = '';
                $.each(data.field_data, function (i, obj)
                {


                    if (obj.field_value == null) {
                        var field_value = "";
                    } else {
                        var field_value = obj.field_value;
                    }
                    table_html += "<div class='form-group'><label for='exampleInputFile'>" + obj.name + "</label><div><input class='form-control' type='text' name='custom_field_value[]'  value='" + field_value + "'  size='20' data-height='26' /></div><span class='text-danger'></span><input type='hidden' name='custom_field_id[]' value='" + obj.cid + "'><input type='hidden' name='custom_field[]' value='" + obj.name + "'><input type='hidden' name='belong_table_id' value='" + obj.belong_table_id + "'></div>";

                });

                //console.log(belong_table_id);
                $("#customdata").html(table_html);
                //$("#evid").html(data.id);
                //console.log(data.id);
                $("#eopd_ipd_no").val(data.opd_ipd_no);
                $exampleDestroy.val(data.mother_name).select2('').select2();
                // console.log(data.mother_name);
                $("#echild_name").val(data.child_name);

                $("#ebirth_date").val(data.birth_date);

                $("#eweight").val(data.weight);
                $("#gender").val(data.gender);
                //$("#emother_name").val(data.mother_name);
                $("#econtact").val(data.contact);
                $("#eaddress").val(data.address);
                $("#efather_name").val(data.father_name);
                //$("#emother_pic").val(data.mother_pic);
                // $("#efather_pic").val(data.father_pic);
                $("#ebirth_report").val(data.birth_report);

            },
        });
    }

    function delete_bill(id) {
        if (confirm('<?php echo $this->lang->line('delete_conform') ?>')) {
            $.ajax({
                url: '<?php echo base_url(); ?>admin/birthordeath/delete/' + id,
                success: function (res) {
                    successMsg('<?php echo $this->lang->line('delete_message'); ?>');
                    window.location.reload(true);
                },
                error: function () {
                    alert("Fail")
                }
            });
        }
    }



    function printData(id) {

        var base_url = '<?php echo base_url() ?>';
        $.ajax({
            url: base_url + 'admin/birthordeath/getBirthprintDetails/' + id,
            type: 'POST',
            data: {id: id, print: 'yes'},
            success: function (result) {
                // $("#testdata").html(result);
                popup(result);

            }
        });
    }



    function popup(data)
    {
        var base_url = '<?php echo base_url() ?>';
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
    function apply_to_all() {
        var total = 0;
        var standard_charge = $("#standard_charge").val();
        var schedule_charge = document.getElementsByName('schedule_charge[]');
        for (var i = 0; i < schedule_charge.length; i++) {
            var inp = schedule_charge[i];
            inp.value = standard_charge;
        }
    }
    function holdModal(modalId) {
        $('#' + modalId).modal({
            backdrop: 'static',
            keyboard: false,
            show: true
        });
    }
</script>
