<link rel="stylesheet" href="<?php echo base_url(); ?>backend/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
<script src="<?php echo base_url(); ?>backend/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script type="text/javascript">
    $(document).ready(function (e) {
        $('.select2').select2();
    });

    function geteditMedicineName(id, selectid = '') {
        console.log(id);

        var category_selected = $("#editmedicine_cat" + id).val();
        var arr = category_selected.split('-');
        var category_set = arr[0];
        div_data = '';
        $("#editsearch-query" + id).html("<option value='l'><?php echo $this->lang->line('loading') ?></option>");
        $('#editsearch-query' + id).select2("val", +id);
        $.ajax({
            type: "POST",
            url: base_url + "admin/pharmacy/get_medicine_name",
            data: {'medicine_category_id': category_selected},
            dataType: 'json',
            success: function (res) {
                console.log(res);
                $.each(res, function (i, obj)
                {
                    var sel = "";

                    div_data += "<option '" + sel + "' value='" + obj.medicine_name + "'>" + obj.medicine_name + "</option>";
                });
                $("#editsearch-query" + id).html("<option value=''>Select</option>");
                $('#editsearch-query' + id).append(div_data);
                $('#editsearch-query' + id).select2().select2("val", selectid);
                geteditMedicineDosage(id);
            }
        });
    }
    ;

    function geteditMedicineDosage(id, selectid = '') {
        //  alert(category_selected)
        // alert(id);
        var category_selected = $("#editmedicine_cat" + id).val();
        var arr = category_selected.split('-');
        var category_set = arr[0];

        div_data = '';

        $("#editsearch-dosage" + id).html("<option value='l'><?php echo $this->lang->line('loading') ?></option>");
        $('#editsearch-dosage' + id).select2("val", +id);

        $.ajax({
            type: "POST",
            url: base_url + "admin/pharmacy/get_medicine_dosage",
            data: {'medicine_category_id': category_selected},
            dataType: 'json',
            success: function (res) {

                $.each(res, function (i, obj)
                {
                    var sel = "";
                    if (selectid == obj.dosage) {
                        sel = "selected";
                    }

                    div_data += "<option '" + sel + "' value='" + obj.dosage + "'>" + obj.dosage + "</option>";

                });
                $("#editsearch-dosage" + id).html("<option value=''>Select</option>");
                $('#editsearch-dosage' + id).append(div_data);
                //$("#search-dosage" + id).select2();
                $('#editsearch-dosage' + id).select2("val", selectid);

            }
        });

    }
    ;
</script>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 paddlr">
        <form id="update_prescription" accept-charset="utf-8"  enctype="multipart/form-data" method="post" class="ptt10">
            <div class="row">

                <div class="col-sm-12">
                    <div class="form-group">
                        <label><?php echo $this->lang->line('header_note'); ?></label> 
                        <textarea name="header_note" class="form-control editor" id="compose-textarea" style="height:50px"><?php echo $result["header_note"] ?></textarea>
                        <input type="hidden" name="opd_id" value="<?php echo $result['opd_id'] ?>">

                    </div> 
                </div>

                <?php foreach ($prescription_list as $pkey => $pvalue) {
                    ?>
                    <input type="hidden" name="previous_pres_id[]" value="<?php echo $pvalue['id'] ?>">
                    <input type="hidden" name="visit_id" value="<?php echo $pvalue['visit_id'] ?>">
                <?php } ?>
                <div class="col-md-12">  
                    <div style="max-height: 300px;overflow-x: hidden; margin-bottom: 20px;">   
                        <table style="width: 100%;" id="edittableID">

                            <?php
                            $i = 0;

                            foreach ($prescription_list as $key => $value) {
                                ?>
                               
                               
                                <tr id="row<?php echo $i ?>">
                                    <td>      
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <?php if ($i == 0) { ?>
                                                    <label><?php echo $this->lang->line('medicine') . " " . $this->lang->line("category"); ?></label> 
                                                <?php } ?>
                                                <select class="form-control select2" style="width: 100%" name='medicine_cat[]' onchange="geteditMedicineName(0)"  id="editmedicine_cat<?php echo $i ?>">
                                                    <option value="<?php echo set_value('medicine_category_id'); ?>"><?php echo $this->lang->line('select') ?>
                                                    </option>
                                                    <?php foreach ($medicineCategory as $dkey => $dvalue) {
                                                        ?>
                                                        <option value="<?php echo $dvalue["id"]; ?>" <?php
                                                        if ($value['medicine_category_id'] == $dvalue["id"]) {
                                                            echo "selected";
                                                        }
                                                        ?>><?php echo $dvalue["medicine_category"] ?>
                                                        </option>   
    <?php } ?>
                                                </select>
                                            </div>
                                        </div>                              
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                    <?php if ($i == 0) { ?>
                               
             <label>
        <?php echo $this->lang->line('medicine'); ?></label>
    <?php } ?> 
                                                <select class="form-control select2" style="width: 100%"  name="medicine[]" id="editsearch-query<?php echo $i ?>">
                                                    <option value="l"><?php echo $this->lang->line('select') ?></option>
                                                </select>
                                                 <script type="text/javascript">
                                    geteditMedicineName('<?php echo $i ?>', '<?php echo $value['medicine'] ?>');
                                    
                                </script>
                                                <input type="hidden" value="<?php echo $value['id'] ?>" name="prescription_id[]" class="form-control" id="report_type" />

                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <?php if ($i == 0) { ?>
                                                
                                                    <label><?php echo $this->lang->line('dosage'); ?></label> 
    <?php } ?>
                                                <select   class="form-control select2" style="width: 100%"  name="dosage[]" id="editsearch-dosage<?php echo $i ?>">
                                                    <option value="l"><?php echo $this->lang->line('select') ?></option>
                                                </select>
                                                  <!-- <script type="text/javascript">
                                  
                                    geteditMedicineDosage('<?php echo $i ?>', '<?php echo $value['dosage'] ?>');
                                </script> -->
                                            </div> 
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
    <?php if ($i == 0) { ?>
                                                    <label><?php echo $this->lang->line('instruction'); ?></label>
    <?php }
    ?> 
                                                <textarea name="instruction[]" class="form-control" style="height: 28px;" id="instruction[]"><?php echo $value['instruction'] ?></textarea>

                                            </div> 
                                        </div>
                                    </td>

    <?php if ($i != 0) { ?>
                                        <td><button type='button' onclick="delete_row('<?php echo $i ?>')" class='modaltableclosebtn'><i class='fa fa-remove'></i></button></td>
                                    <?php } else {
                                        ?>
                                        <td><button type="button" onclick="edit_more()" style="color: #2196f3" class="modaltableclosebtn"><i class="fa fa-plus"></i></button>
                                        </td>
    <?php } ?>
                                </tr>
                              <!--   <tr>
                                     <td colspan="3" style="text-align: right;"><button type="button" onclick="edit_more()" style="color: #2196f3" class="modaltableclosebtn"><i class="fa fa-plus"></i></button>
                                        </td>
                                </tr> -->
    <?php
    $i++;
}
?>
                        </table>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="form-group">
                        <label><?php echo $this->lang->line('footer_note'); ?></label> 
                        <textarea name="footer_note" class="form-control editor" id="compose-textareaold" style="height:50px"><?php echo $result["footer_note"] ?></textarea>
                    </div> 
                </div>  


            </div>


            <div class="box-footer">
                <div class="pull-right">
                    <button type="submit" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>

                </div>
            </div>

        </form>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $("#compose-textarea,#compose-textareaold").wysihtml5({
            toolbar: {
                "image": false,
            }
        });
        $('.select2').select2();
    });

    function edit_more() {
        var table = document.getElementById("edittableID");
        var table_len = (table.rows.length);
        var id = parseInt(table_len);
        var div = "<div id=row1><div class=col-sm-3><select class='form-control select2' onchange='geteditMedicineName(" + id + ")' name='medicine_cat[]'  id='editmedicine_cat" + id + "'><option value='<?php echo set_value('medicine_category_id'); ?>'><?php echo $this->lang->line('select') ?></option><?php foreach ($medicineCategory as $dkey => $dvalue) { ?><option value='<?php echo $dvalue["id"]; ?>'><?php echo $dvalue["medicine_category"] ?></option><?php } ?></select></div><div class=col-sm-3><div class=form-group><select  class='form-control select2'  name='medicine[]' id='editsearch-query" + id + "'><option value='l'><?php echo $this->lang->line('select') ?></option></select></div><div id='editsuggesstion-box" + id + "'></div></div><div class=col-sm-3><div class=form-group><select class='form-control select2' name='dosage[]' id='editsearch-dosage" + id + "' ><option value='l'><?php echo $this->lang->line('select') ?></option><?php foreach ($dosage as $dkey => $dosagevalue) { ?><option value='<?php echo $dosagevalue["dosage"]; ?>'><?php echo $dosagevalue["dosage"] ?></option><?php } ?></select><input type=hidden class=form-control value='0' name='prescription_id[]' /></div></div><div class=col-sm-3><div class=form-group><textarea name='instruction[]' style='height:28px;' class=form-control id=description></textarea></div></div></div>";


        var row = table.insertRow(table_len).outerHTML = "<tr id='row" + id + "'><td>" + div + "</td><td><div class=form-group><button type='button' onclick='delete_row(" + id + ")' class='modaltableclosebtn'><i class='fa fa-remove'></i></button></div></td></tr>";
        $(".select2").select2();
    }

    $(document).ready(function (e) {
        $("#update_prescription").on('submit', (function (e) {
            e.preventDefault();
            $.ajax({
                url: '<?php echo base_url(); ?>admin/patient/update_prescription',
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
                    //alert("Fail")
                }
            });
        }));
    });

</script>                        