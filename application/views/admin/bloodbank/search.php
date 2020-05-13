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
                        <h3 class="box-title titlefix"> <?php echo $this->lang->line('donor') . " " . $this->lang->line('details'); ?></h3>
                        <div class="box-tools pull-right">
                            <?php if ($this->rbac->hasPrivilege('blood_donor', 'can_add')) { ?>
                                <a data-toggle="modal" onclick="holdModal('myModal')" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> <?php echo $this->lang->line('add') . " " . $this->lang->line('blood') . " " . $this->lang->line('donor'); ?></a> 
                            <?php } ?>
                        </div>    
                    </div><!-- /.box-header -->

                    <div class="box-body">
                        <div class="download_label"><?php echo $this->lang->line('donor') . " " . $this->lang->line('details') . " " . $this->lang->line('list(varname)'); ?></div>
                        <table class="table table-striped table-bordered table-hover example" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th><?php echo $this->lang->line('donor') . " " . $this->lang->line('name'); ?></th>
                                    <th><?php echo $this->lang->line('age'); ?></th>
                                    <th><?php echo $this->lang->line('blood_group'); ?></th>
                                    <th><?php echo $this->lang->line('gender'); ?></th>
                                    <th><?php echo $this->lang->line('contact'); ?></th>
                                    <th><?php echo $this->lang->line('father_name'); ?></th>
                                    <th><?php echo $this->lang->line('address'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (empty($resultlist)) {
                                    
                                } else {
                                    $count = 1;
                                    foreach ($resultlist as $student) {
                                        ?>
                                        <tr class="">
                                            <td>
                                                <?php if ($this->rbac->hasPrivilege('blood_donor', 'can_view')) { ?>
                                                    <a  onclick="viewDetail('<?php echo $student['id'] ?>')"><?php echo $student['donor_name']; ?></a> 
                                                <?php } ?>
                                                <div class="rowoptionview">
                                                    <?php if ($this->rbac->hasPrivilege('blood_donor', 'can_add')) { ?>
                                                        <a href="#" onclick="addDonorBlood('<?php echo $student['id'] ?>')" class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('donor') . " " . $this->lang->line('blood') . " " . $this->lang->line('details'); ?>">
                                                            <i class="fa fa-plus-square" aria-hidden="true"></i>
                                                        </a>
                                                    <?php } if ($this->rbac->hasPrivilege('blood_donor', 'can_view')) { ?> 
                                                        <a href="#" 
                                                           onclick="viewDetail('<?php echo $student['id'] ?>')"
                                                           class="btn btn-default btn-xs"  data-toggle="tooltip"
                                                           title="<?php echo $this->lang->line('show'); ?>" >
                                                            <i class="fa fa-reorder"></i>
                                                        </a> 
                                                    <?php } ?>

                                                </div>  
                                            </td>
                                            <td><?php
                                                if (!empty($student['age'])) {
                                                    echo $student['age'] . " " . $this->lang->line('year') . " ";
                                                }
                                                if (!empty($student['month'])) {
                                                    echo $student['month'] . " " . $this->lang->line('month') . " ";
                                                }
                                                ?></td>
                                            <td><?php echo $student['blood_group']; ?></td>
                                            <td><?php echo $student['gender']; ?></td>
                                            <td><?php echo $student['contact_no']; ?></td>
                                            <td><?php echo $student['father_name']; ?></td>
                                            <td><?php echo $student['address']; ?></td>
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
                <h4 class="box-title"><?php echo $this->lang->line('add') . " " . $this->lang->line('donor') . " " . $this->lang->line('details'); ?></h4> 
            </div>
            <form id="formadd" accept-charset="utf-8" method="post" class="">   
                <div class="modal-body pt0 pb0">
                    <div class="ptt10">


                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('donor') . " " . $this->lang->line('name'); ?></label>
                                    <small class="req"> *</small> 
                                    <input type="text" name="donor_name" class="form-control">
                                    <span class="text-danger"><?php echo form_error('donor_name'); ?></span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('age'); ?></label>
                                    <div style="clear: both;overflow: hidden;"><input type="text" placeholder="<?php echo $this->lang->line('year'); ?>" name="age" value="" class="form-control" style="width: 40%; float: left;">
                                        <input type="text" placeholder="<?php echo $this->lang->line('month') ?>" name="month" value="" class="form-control" style="width: 56%;float: left; margin-left: 5px;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('blood_group'); ?></label><small class="req"> *</small> 
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
                                    <span class="text-danger"><?php echo form_error('blood_group'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label> <?php echo $this->lang->line('gender'); ?></label><small class="req"> *</small> 
                                    <select class="form-control"  name="gender">
                                        <option value="<?php echo set_value('gender'); ?>"><?php echo $this->lang->line('select'); ?></option>
                                        <?php
                                        foreach ($genderList as $key => $value) {
                                            ?>
                                            <option value="<?php echo $key; ?>" <?php if (set_value('gender') == $key) echo "selected"; ?>><?php echo $value; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                    <span class="text-danger"><?php echo form_error('gender'); ?></span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('father_name'); ?></label>
                                    <input type="text" name="father_name" class="form-control">
                                    <span class="text-danger"><?php echo form_error('father_name'); ?></span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('contact_no'); ?></label>
                                    <input type="text" name="contact_no" class="form-control">
                                    <span class="text-danger"><?php echo form_error('contact_no'); ?></span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="Address"><?php echo $this->lang->line('address'); ?></label>
                                    <textarea name="address"  class="form-control" ></textarea>
                                </div>
                            </div>

                        </div><!--./row--> 
                    </div><!--./row--> 
                </div>      
                <div class="box-footer">
                    <div class="pull-right">
                        <button type="submit" id="formaddbtn" data-loading-text="<?php echo $this->lang->line('processing') ?>" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>

                    </div>
                </div>
            </form>



        </div>
    </div>    
</div>
<!-- dd -->
<div class="modal fade" id="myModaledit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="box-title"><?php echo $this->lang->line('edit') . " " . $this->lang->line('donor') . " " . $this->lang->line('information'); ?></h4> 
            </div>

            <div class="modal-body pt0 pb0">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 paddlr">
                        <form id="formedit" accept-charset="utf-8"  method="post" class="ptt10">
                            <div class="row">
                                <input type="hidden" name="id" id="id" value="<?php echo set_value('id'); ?>">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('donor') . " " . $this->lang->line('name'); ?></label>
                                        <small class="req"> *</small> 
                                        <input type="text" name="donor_name" id="donor_name" value="<?php echo set_value('donor_name'); ?>" class="form-control">
                                        <span class="text-danger"><?php echo form_error('donor_name'); ?></span>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('age'); ?></label>
                                        <div style="clear: both;overflow: hidden;"><input type="text" placeholder="Age" name="age" id="age" value="<?php echo set_value('age'); ?>" class="form-control" style="width: 40%; float: left;">
                                            <input type="text" placeholder="Month" id="month" name="month" value="<?php echo set_value('month'); ?>" class="form-control" style="width: 56%;float: left; margin-left: 5px;">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('blood_group'); ?></label><small class="req"> *</small> 
                                        <select id="blood_group" name="blood_group"  class="form-control" >
                                            <option value=""><?php echo $this->lang->line('select') ?></option>
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
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label> <?php echo $this->lang->line('gender'); ?></label>
                                        <select class="form-control" id="gender" name="gender">
                                            <option value="<?php echo set_value('gender'); ?>"><?php echo $this->lang->line('select'); ?></option>
                                            <?php
                                            foreach ($genderList as $key => $value) {
                                                ?>
                                                <option value="<?php echo $key; ?>" <?php if (set_value('gender') == $key) echo "selected"; ?>><?php echo $value; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        <span class="text-danger"><?php echo form_error('gender'); ?></span>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('father_name'); ?></label>
                                        <input type="text" name="father_name"  id="father_name" value="<?php echo set_value('father_name'); ?>" class="form-control">
                                        <span class="text-danger"><?php echo form_error('father_name'); ?></span>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('contact_no'); ?></label>

                                        <input type="text" name="contact_no" id="contact_no" value="<?php echo set_value('contact_no'); ?>" class="form-control">
                                        <span class="text-danger"><?php echo form_error('contact_no'); ?></span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="Address"><?php echo $this->lang->line('address'); ?></label>
                                        <textarea name="address"  id="address" value="<?php echo set_value('address'); ?>" class="form-control" ></textarea>
                                    </div>
                                </div>
                            </div><!--./row-->

                    </div><!--./col-md-12-->       
                </div><!--./row--> 
            </div>
            <div class="box-footer">
                <div class="pull-right">
                    <button type="submit" id="formeditbtn" data-loading-text="<?php echo $this->lang->line('processing') ?>" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                    </form> 
                </div>
            </div>
        </div>
    </div>    
</div>
<div class="modal fade" id="addBloodDetailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="box-title"><?php echo $this->lang->line('donor') . " " . $this->lang->line('blood') . " " . $this->lang->line('details'); ?></h4> 
            </div>
            <div class="modal-body pt0 pb0">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 paddlr">
                        <form id="donorblood" accept-charset="utf-8"  method="post" class="ptt10" >
                            <input type="hidden" name="blood_donor_id" id="donor_id">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('donate') . " " . $this->lang->line('date'); ?></label> 
                                        <small class="req"> *</small> 
                                        <input  name="donate_date" type="text" class="form-control date"/>
                                        <span class="text-danger"><?php echo form_error('quantity'); ?></span>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('lot'); ?> </label>
                                        <input  name="lot" type="text" class="form-control"/>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('bag_no'); ?> </label> <small class="req"> *</small> 
                                        <input  name="bag_no" type="text" class="form-control"/>
                                        <span class="text-danger"><?php echo form_error('bag_no'); ?></span>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('quantity') . " " . $this->lang->line('in_ml'); ?></label> 
                                        <small class="req"> *</small> 
                                        <input  name="quantity" type="text" class="form-control"/>
                                        <span class="text-danger"><?php echo form_error('quantity'); ?></span>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('institution'); ?></label>
                                        <input  name="institution"  type="text" class="form-control"/>
                                    </div>
                                </div>
                            </div><!--./row-->   

                    </div><!--./col-md-12-->       

                </div><!--./row--> 

            </div>
            <div class="box-footer">
                <div class="pull-right">
                    <button type="submit" data-loading-text="<?php echo $this->lang->line('processing') ?>" id="donorbloodbtn" class="btn btn-info pull-right" ><?php echo $this->lang->line('save'); ?></button>
                    </form>   
                </div>
            </div>
        </div>
    </div>    
</div>
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class="modalicon"> 
                    <div id='edit_delete'>

                    </div>
                </div>
                <h4 class="box-title"><?php echo $this->lang->line('donor') . " " . $this->lang->line('information'); ?></h4> 
            </div>

            <div class="modal-body pt0 pb0">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 paddlr">
                        <form id="view" accept-charset="utf-8" method="get" class="ptt10">
                            <div class="table-responsive">
                                <table class="table mb0 table-striped table-bordered examples">
                                    <tr>
                                        <th><?php echo $this->lang->line('donor') . " " . $this->lang->line('name'); ?></th>
                                        <td><span id='donor_names'></span></td>
                                        <th><?php echo $this->lang->line('age'); ?></th>
                                        <td><span id="ages"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><?php echo $this->lang->line('blood_group'); ?></th>
                                        <td><span id='blood_groups'></span></td>
                                        <th><?php echo $this->lang->line('gender'); ?></th>
                                        <td><span id="genders"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><?php echo $this->lang->line('father_name'); ?></th>
                                        <td><span id="father_names"></span>
                                        </td>
                                        <th><?php echo $this->lang->line('contact_no'); ?></th>
                                        <td><span id="contact_nos"></span>

                                    </tr>

                                    <tr>
                                        <th><?php echo $this->lang->line('address'); ?></th>
                                        <td><span id='addresss'></span></td>
                                    </tr>

                                </table>
                            </div>
                        </form>                                   
                    </div><!--./col-md-12-->       
                </div><!--./row--> 
                <div id="reportdata"></div>
            </div>
        </div>
    </div>    
</div>
<script type="text/javascript">
    $(function () {
        $('#easySelectable').easySelectable();
    })
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
<script>
            $(document).ready(function (e) {
                $("#formadd").on('submit', (function (e) {
                    $("#formaddbtn").button('loading');
                    e.preventDefault();
                    $.ajax({
                        url: '<?php echo base_url(); ?>admin/bloodbank/add',
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
                        url: '<?php echo base_url(); ?>admin/bloodbank/update',
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
                            //  alert("Fail")
                        }
                    });
                }));
            });

            function getRecord(id) {
                $.ajax({
                    url: '<?php echo base_url(); ?>admin/bloodbank/getDetails',
                    type: "POST",
                    data: {blood_donor_id: id},
                    dataType: 'json',
                    success: function (data) {
                        $("#id").val(data.id);
                        $("#donor_name").val(data.donor_name);
                        $("#age").val(data.age);
                        $("#month").val(data.month);
                        $("#blood_group").val(data.blood_group);
                        $("#gender").val(data.gender);
                        // $("#date_of_birth").val(data.date_of_birth);
                        $("#father_name").val(data.father_name);
                        $("#address").val(data.address);
                        $("#city").val(data.city);
                        $("#state").val(data.state);
                        $("#contact_no").val(data.contact_no);
                        $("#institution").val(data.institution);
                        $("#lot").val(data.lot);
                        $("#bag_no").val(data.bag_no);
                        $("#quantity").val(data.quantity);
                        $("#updateid").val(id);
                        $('select[id="blood_group"] option[value="' + data.blood_group + '"]').attr("selected", "selected");
                        $('select[id="gender"] option[value="' + data.gender + '"]').attr("selected", "selected");
                        $("#viewModal").modal('hide');
                        holdModal('myModaledit');
                    },
                })
            }
            $(document).ready(function (e) {
                var date_format = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(), ['d' => 'DD', 'm' => 'MM', 'Y' => 'YYYY',]) ?>';
                $('#dates_of_birth , #date_of_birth').datepicker();
            });
            function viewDetail(id) {
                $.ajax({
                    url: '<?php echo base_url(); ?>admin/bloodbank/getDetails',
                    type: "POST",
                    data: {blood_donor_id: id},
                    dataType: 'json',
                    success: function (data) {
                        $.ajax({
                            url: '<?php echo base_url(); ?>admin/bloodbank/getDonorBloodBatch',
                            type: "POST",
                            data: {blood_donor_id: id},
                            success: function (data) {
                                $('#reportdata').html(data);
                            },
                        });
                        $("#donor_names").html(data.donor_name);
                        $("#ages").html(data.age + " Year " + data.month + " Month");
                        $("#blood_groups").html(data.blood_group);
                        $("#genders").html(data.gender);
                        $("#father_names").html(data.father_name);
                        $("#contact_nos").html(data.contact_no);
                        $("#addresss").html(data.address);
                        $("#edit_delete").html("<a href='#' onclick='getRecord(" + id + ")' data-toggle='tooltip' title='' data-original-title='Edit'><i class='fa fa-pencil'></i></a><a onclick='delete_record(" + id + ")'  href='#'  data-toggle='tooltip'  data-original-title='Delete'><i class='fa fa-trash'></i></a>");
                        holdModal('viewModal');
                    },
                });
            }
            function delete_record(id) {
                if (confirm('<?php echo $this->lang->line('delete_conform'); ?>')) {
                    $.ajax({
                        url: '<?php echo base_url(); ?>admin/bloodbank/delete/' + id,
                        type: "POST",
                        data: {id: ''},
                        dataType: 'json',
                        success: function (data) {
                            successMsg('<?php echo $this->lang->line('success_message'); ?>')
                            window.location.reload(true);
                        }
                    });
                }
            }

            function addDonorBlood(id) {
                $.ajax({
                    url: '<?php echo base_url(); ?>admin/bloodbank/getBloodBank',
                    type: "POST",
                    data: {blood_donor_id: id},
                    dataType: 'json',
                    success: function (data) {
                        $("#donor_id").val(id);
                        holdModal('addBloodDetailModal');
                    },
                })
            }
            $(document).ready(function (e) {
                $("#donorblood").on('submit', (function (e) {
                    $("#donorbloodbtn").button('loading');
                    e.preventDefault();
                    $.ajax({
                        url: '<?php echo base_url(); ?>admin/bloodbank/donorCycle',
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
                            $("#donorbloodbtn").button('reset');
                        },
                        error: function () {
                            //  alert("Fail")
                        }
                    });
                }));
            });
            function holdModal(modalId) {
                $('#' + modalId).modal({
                    backdrop: 'static',
                    keyboard: false,
                    show: true
                });
            }
</script>