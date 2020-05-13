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
                        <h3 class="box-title titlefix"><?php echo $this->lang->line('patient'); ?></h3>
                        <div class="box-tools pull-right">

                            <?php if ($this->rbac->hasPrivilege('import_patient', 'can_add')) { ?>                

                                <a href="<?php echo site_url('admin/patient/exportformat') ?>">
                                    <button class="btn btn-primary btn-sm"><i class="fa fa-download"></i> <?php echo $this->lang->line('download_data'); ?></button>
                                </a>
                            <?php } ?>

                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body">      
                        <?php if ($this->session->flashdata('msg')) { ?> <div>  <?php echo $this->session->flashdata('msg') ?> </div> <?php } ?>
                        <br/>           
                        1. Your CSV data should be in the format below. The first line of your CSV file should be the column headers as in the table example. Also make sure that your file is UTF-8 to avoid unnecessary encoding problems.<br/>

                        2. For patient "Gender" use Male, Female value.<br/>

                        3. For patient "Blood Group" use O+, A+, B+, AB+, O-, A-, B-, AB- value.<br/>

                        4. For Age column "Age (year)" and "Age (month)" make sure that is numbers only.<br/>

                        5. For patient "Marital Status" user Single, Married, Widowed, Separated, Not Specified value.<br/>

                        <hr/>

                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="sampledata">
                            <thead>
                                <tr>
                                    <?php
                                    foreach ($fields as $key => $value) {
                                        $add = "";
                                        if ($value == 'patient_name') {
                                            $add = "<span class=text-red>*</span>";
                                            $value = $this->lang->line("patient");
                                        } else

                                        if ($value == 'guardian_name') {
                                            $value = $this->lang->line("guardian");
                                        } else if ($value == 'mobileno') {
                                            $value = $this->lang->line("phone");
                                        } else if ($value == 'note') {
                                            $value = $this->lang->line("remarks");
                                        } else if ($value == 'age') {
                                            $value = $this->lang->line("age") . " (" . $this->lang->line("year") . ")";
                                        } else if ($value == 'month') {
                                            $value = $this->lang->line("age") . " (" . $this->lang->line("month") . ")";
                                        } else {
                                            $value = $this->lang->line($value);
                                        }

                                        /* if($value == 'gender'){
                                          $value = "gender";
                                          }

                                          if($value == 'address'){
                                          $value = "address";
                                          }
                                          if($value == 'age'){
                                          $value = "age";
                                          } */


                                        // if(($value == "patient")){
                                        //     $add = "<span class=text-red>*</span>";
                                        // }
                                        ?> 
                                        <th><?php echo $add . "<span>" . $value . "</span>"; ?></th>   

                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php foreach ($fields as $key => $value) {
                                        ?>    
                                        <td><?php echo "Sample Data" ?></td>
                                    <?php } ?>
                                </tr>
                            </tbody>

                        </table>        
                    </div>
                    <form action="<?php echo site_url('admin/patient/import') ?>" id="employeeform" name="employeeform" method="post" enctype="multipart/form-data">
                        <div class="box-body">
                            <?php echo $this->customlib->getCSRF(); ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputFile"><?php echo $this->lang->line('select_csv_file'); ?></label><small class="req"> *</small>
                                        <div><input  class="filestyle form-control" type='file' name='file' id="file" size='20' />
                                            <span class="text-danger"><?php echo form_error('file'); ?></span></div>
                                    </div>
                                </div>

                                <div class="col-md-6 pt20">

                                    <button type="submit" class="btn btn-info pull-right"><i class="fa fa-upload"></i> <?php echo $this->lang->line('import'); ?></button>
                                </div>     

                            </div>
                        </div>
                    </form>
                </div>                                                    
            </div>                                                                                                                                          
        </div>  
    </section>
</div>

<script type="text/javascript">
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()
    });
    $(function () {
        $('#easySelectable').easySelectable();
//stopPropagation();
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
<script type="text/javascript">
            $(document).ready(function (e) {
                $("#formadd").on('submit', (function (e) {
                    e.preventDefault();
                    $("#formaddbtn").button('loading');
                    $.ajax({
                        url: '<?php echo base_url(); ?>admin/pharmacy/add',
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
                            //  alert("Fail")
                        }

                    });
                }));
            });

            $(document).ready(function (e) {
                $("#formimp").on('submit', (function (e) {
                    e.preventDefault();
                    $("#formimpbtn").button('loading');
                    $.ajax({
                        url: '<?php echo base_url(); ?>admin/pharmacy/import',
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
                            $("#formimpbtn").button('reset');
                        },
                        error: function () {
                            //  alert("Fail")
                        }

                    });
                }));
            });

            $(document).ready(function (e) {
                $("#formstock").on('submit', (function (e) {
                    e.preventDefault();
                    $("#formstockbtn").button('loading');
                    $.ajax({
                        url: '<?php echo base_url(); ?>admin/pharmacy/addBadStock',
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
                            $("#formstockbtn").button('reset');
                        },
                        error: function () {
                            //  alert("Fail")
                        }
                    });
                }));
            });
            $(document).ready(function (e) {
                $("#formedit").on('submit', (function (e) {
                    e.preventDefault();
                    $("#formeditbtn").button('loading');
                    $.ajax({
                        url: '<?php echo base_url(); ?>admin/pharmacy/update',
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
            $(document).ready(function (e) {

                $('#expiry,#stockexpiry_date').datepicker({
                    format: "M/yyyy",
                    viewMode: "months",
                    minViewMode: "months",
                    autoclose: true
                });
            });
            function getRecord(id) {
                $.ajax({
                    url: '<?php echo base_url(); ?>admin/pharmacy/getDetails',
                    type: "POST",
                    data: {pharmacy_id: id},
                    dataType: 'json',
                    success: function (data) {
                        $("#id").val(data.id);
                        $("#medicines_name").val(data.medicine_name);
                        $("#medicines_category_id").val(data.medicine_category_id);
                        $("#medicine_company").val(data.medicine_company);
                        $("#medicine_composition").val(data.medicine_composition);
                        $("#medicine_group").val(data.medicine_group);
                        $("#unit").val(data.unit);
                        $("#min_level").val(data.min_level);
                        $("#reorder_level").val(data.reorder_level);
                        $("#vat").val(data.vat);
                        $("#unit_packing").val(data.unit_packing);
                        $("#supplier").val(data.supplier);
                        $("#pre_medicine_image").val(data.pre_medicine_image);
                        $("#vat_ac").val(data.vat_ac);
                        $("#updateid").val(id);
                        $("#viewModal").modal('hide');
                        $(".select2").select2().select2('val', data.medicine_category_id);
                        //$('select[id="medicines_category_id"] option[value="' + data.medicines_category_id + '"]').attr("selected", "selected");
                        holdModal('myModaledit');
                    },
                });
            }
            function viewDetail(id) {
                // alert(id);
                $.ajax({
                    url: '<?php echo base_url(); ?>admin/pharmacy/getDetails',
                    type: "POST",
                    data: {pharmacy_id: id},
                    dataType: 'json',
                    success: function (data) {
                        $.ajax({
                            url: '<?php echo base_url(); ?>admin/pharmacy/getMedicineBatch',
                            type: "POST",
                            data: {pharmacy_id: id},
                            success: function (data) {
                                $('#tabledata').html(data);
                            },
                        });
                        if (data.medicine_image != "") {
                            $("#medicine_image").attr('src', '<?php echo base_url() ?>' + data.medicine_image);
                        } else {
                            $("#medicine_image").attr('src', '<?php echo base_url() ?>uploads/medicine_images/no_medicine_image.png');

                        }

                        $("#medicine_names").html(data.medicine_name);
                        $("#medicine_category_ids").html(data.medicine_category);
                        $("#medicine_companys").html(data.medicine_company);
                        $("#medicine_compositions").html(data.medicine_composition);
                        $("#medicine_groups").html(data.medicine_group);
                        $("#units").html(data.unit);
                        $("#min_levels").html(data.min_level);
                        $("#reorder_levels").html(data.reorder_level);
                        $("#vats").html(data.vat);
                        $("#unit_packings").html(data.unit_packing);
                        $("#suppliers").html(data.supplier);
                        $("#vat_acs").html(data.vat_ac);
                        $('#edit_delete').html("<?php if ($this->rbac->hasPrivilege('medicine', 'can_edit')) { ?><a href='#'' onclick='getRecord(" + id + ")' data-toggle='tooltip'  data-original-title='<?php echo $this->lang->line('edit'); ?>'><i class='fa fa-pencil'></i></a><?php } if ($this->rbac->hasPrivilege('medicine', 'can_delete')) { ?><a onclick='delete_record(" + id + ")'  href='#'  data-toggle='tooltip'  data-original-title='<?php echo $this->lang->line('delete'); ?>'><i class='fa fa-trash'></i></a><?php } ?>");
                        holdModal('viewModal');
                    },
                });
            }
            function addBulk(id) {
                $.ajax({
                    url: '<?php echo base_url(); ?>admin/pharmacy/getPharmacy',
                    type: "POST",
                    data: {pharmacy_id: id},
                    dataType: 'json',
                    success: function (data) {
                        $("#pharm_id").val(id);
                        holdModal('addBulkModal');
                    },
                })
            }
            $(document).ready(function (e) {
                $("#formbatch").on('submit', (function (e) {
                    e.preventDefault();
                    $("#formbatchbtn").button("loading");
                    $.ajax({
                        url: '<?php echo base_url(); ?>admin/pharmacy/medicineBatch',
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
                            $("#formbatchbtn").button('reset');
                        },
                        error: function () {
                            //  alert("Fail")
                        }
                    });
                }));
            });
            function delete_record(id) {
                if (confirm('Are you sure')) {
                    $.ajax({
                        url: '<?php echo base_url(); ?>admin/pharmacy/delete/' + id,
                        type: "POST",
                        data: {opdid: ''},
                        dataType: 'json',
                        success: function (data) {

                            window.location.reload(true);
                        }
                    })
                }
            }
            function holdModal(modalId) {
                $('#' + modalId).modal({
                    backdrop: 'static',
                    keyboard: false,
                    show: true
                });
            }

            function addbadstock(id) {
                $("#pharmacy_stock_id").val(id);
                getbatchnolist(id);
                holdModal('addBadStockModal');
            }


            function getbatchnolist(id, selectid = '') {
                var div_data = "";
                $("#batch_stock_no").html("<option value=''><?php echo $this->lang->line('select') ?></option>");
                $.ajax({
                    type: "POST",
                    url: base_url + "admin/pharmacy/getBatchNoList",
                    data: {'medicine': id},
                    dataType: 'json',
                    success: function (res) {
                        console.log(res);
                        $.each(res, function (i, obj)
                        {
                            var sel = "";
                            if (obj.batch_no == selectid) {
                                sel = "selected";
                            }
                            div_data += "<option " + sel + " value='" + obj.batch_no + "'>" + obj.batch_no + "</option>";
                        });
                        $('#batch_stock_no').append(div_data);
                    }
                });
            }

            function getExpire(batch_no) {
                //var batch_no = $("#batch_expire").val();
                $.ajax({
                    type: "POST",
                    url: base_url + "admin/pharmacy/getExpiryDate",
                    data: {'batch_no': batch_no},
                    dataType: 'json',
                    success: function (data) {
                        if (data != null) {
                            $('#batch_expire').val(data.expiry_date);
                            $('#batch_available_qty').val(data.available_quantity);
                            $('#medicine_batch_id').val(data.id);
                        }
                    }
                });
            }
</script>