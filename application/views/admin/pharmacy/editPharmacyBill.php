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
<form id="editbill"  accept-charset="utf-8" method="post" class="ptt10">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 paddlr">
            <div class="row">
                <?php foreach ($detail as $pkey => $pvalue) {
                    ?>
                    <input type="hidden" name="previous_bill_id[]" value="<?php echo $pvalue['id'] ?>">

                <?php } ?>
                <input name="bill_basic_id" type="hidden" class="form-control" value="<?php echo $result['id']; ?>" />
                <input type="hidden" name="patient_id" id="editbillpatientid">
                <input type="hidden" name="date" id="editbilldate">
                <input name="bill_no" type="hidden" class="form-control" value="<?php echo $result['bill_no']; ?>" />
               <!--  <input name="date" id="editdate" type="hidden" class="form-control datetime" value="<?php echo date($this->customlib->getSchoolDateFormat(true, true), strtotime($result['date'])); ?>" /> -->


                <div class="col-sm-2">
                    <div class="form-group">
                        <label for="exampleInputFile">
                            <?php echo $this->lang->line('hospital') . " " . $this->lang->line('doctor'); ?></label>
                        <div><select name='' style="width:100%;" id="consultant_doctor" onchange="get_DocEditname(this.value)" class="form-control select2" <?php
                            if ($disable_option == true) {
                                echo "disabled";
                            }
                            ?> style="width:100%"  >
                                <option value=""><?php
                                    if ($result['doctor_name']) {
                                        echo $result['doctor_name'];
                                    } else {
                                        echo $this->lang->line('select');
                                    }
                                    ?> </option>
                                <?php foreach ($doctors as $dkey => $dvalue) { ?> 
                                    <option value="<?php echo $dvalue["id"]; ?>" <?php
                                        if ((isset($doctor_select)) && ($doctor_select == $dvalue["id"])) {
                                            echo "selected";
                                        }
                                        ?>><?php echo $dvalue["name"] . " " . $dvalue["surname"] ?>
                                    </option>   
<?php } ?>
                            </select>
                        </div>
                        <span class="text-danger"><?php echo form_error('refference'); ?></span>
                    </div>
                </div>

                <div class="col-sm-2">    
                    <div class="form-group">
                        <label><?php echo $this->lang->line('doctor') . " " . $this->lang->line('name') . " "; ?></label>
                        <input name="doctor_name" type="text" id="docteditname" class="form-control" value="<?php echo $result['doctor_name']; ?>" />
                        <span class="text-danger"><?php echo form_error('doctor_name'); ?></span>
                    </div>
                </div> 

                <script type="text/javascript">

                    function get_PatienteditDetails(id) {
                        //$("#patient_name").html("patient_name");
                        //$("#schedule_charge").html("schedule_charge");

                        $.ajax({
                            url: '<?php echo base_url(); ?>admin/pharmacy/patientDetails',
                            type: "POST",
                            data: {id: id},
                            dataType: 'json',
                            success: function (res) {
                                // console.log(res);
                                if (res) {
                                    //$('#patient_name').val(res.patient_name);
                                    $('#patienteditid').val(res.id);
                                    $('#patienteditname').val(res.patient_name);

                                }
                            }
                        });
                    }
                    function geteditQuantity(id,med_id,batch = '', newrow = '') {
                        if (batch == "") {
                            var batch_no = $('#batch_edit_no' + id).val();
                            //var batch_no = $('#medicine_edit_name' + id).val();
                        } else {
                            var batch_no = batch;
                           // var med_id = med_id
                        }

                         // alert(id);
                        if (batch_no != "") {
                            $('#quantity_edit').val("");
                            $.ajax({
                                type: "GET",
                                url: base_url + "admin/pharmacy/getQuantityedit",
                                data: {'batch_no': batch_no,'med_id':med_id},
                                dataType: 'json',
                                success: function (data) {
                            //console.log(data);
                                    $('#medicine_batch_id' + id).val(data.id);
                                    $('#quantity_edit').val(data.available_quantity);
                                    $('#totaleditqty' + id).html(data.available_quantity);
                                    $('#available_edit_quantity' + id).val(data.available_quantity);
                                  
                                    if (newrow != '') {
                                        $('#sale_price_edit' + id).val(data.sale_rate);
                                    }
                                    // $('#sale_price_edit' + id).val(data.sale_price);
                                }
                            });
                    }
                    }

                    function get_DocEditname(id) {
                        // $("#standard_charge").html("standard_charge");
                        //$("#schedule_charge").html("schedule_charge");

                        $.ajax({
                            url: '<?php echo base_url(); ?>admin/patient/doctName',
                            type: "POST",
                            data: {doctor: id},
                            dataType: 'json',
                            success: function (res) {
                                //alert(res);
                                if (res) {
                                    $('#docteditname').val(res.name + " " + res.surname);
                                    //$('#surname').val(res.surname);

                                } else {

                                }
                            }
                        });
                    }
                    function geteditExpire(id) {
                        var batch_no = $("#batch_edit_no" + id).val();
                         //var medicine = $("#medicine_edit_name" + id).val();
                        $('#edit_expire_date' + id).val('');
                        $.ajax({
                            type: "POST",
                            url: base_url + "admin/pharmacy/getExpireDate",
                            data: {'batch_no': batch_no},
                            dataType: 'json',
                            success: function (data) {
                                if (data != null) {
                                    $('#edit_expire_date' + id).val(data.expiry_date);
                                    geteditQuantity(id,batch_no,)

                                }
                            }
                        });
                    }


                    function getneweditExpire(id) {
                        var med_id = $("#medicine_edit_name" + id).val();
                        var batch_no = $("#batch_edit_no" + id).val();
                        $('#edit_expire_date' + id).val('');
                        $.ajax({
                            type: "POST",
                            url: base_url + "admin/pharmacy/getExpiryDate",
                            data: {'batch_no': batch_no,'med_id':med_id},
                            dataType: 'json',
                            success: function (data) {
                                if (data != null) {
                                    $('#edit_expire_date' + id).val(data.expiry_date);
                                    geteditQuantity(id,med_id,batch_no, newrow = 'yes')

                                }
                            }
                        });
                    }

                    function getmedicine_edit_name(id, rowid, selectid = '') {
                        $(".select2").select2();
                        //$('#medicine_edit_name' + rowid).select2("val", '');
                        $("#medicine_edit_name" + rowid).html("<option value='l'><?php echo $this->lang->line('loading') ?></option>");
                        $('#medicine_edit_name' + rowid).select2("val", 'l');
                        var div_data = "";
                        $("#medicine_edit_name" + rowid).html("<option value=''>Select</option>");
                        $.ajax({
                            url: '<?php echo base_url(); ?>admin/pharmacy/get_medicine_name',
                            type: "POST",
                            data: {medicine_category_id: id},
                            dataType: 'json',
                            success: function (res) {
                                $.each(res, function (i, obj)
                                {
                                    var sel = "";
                                    if (obj.id == selectid) {
                                        sel = "selected";
                                    }
                                    div_data += "<option " + sel + " value=" + obj.id + " >" + obj.medicine_name + "</option>";
                                });
                                $("#medicine_edit_name" + rowid).html("<option value=''>Select</option>");

                                $('#medicine_edit_name' + rowid).append(div_data);
                                $(".select2").select2().select2('val', res.medicine_name);
                            }

                        });
                    }

                    function geteditbatchnolist(id, rowid, selectid) {

                        // var batch_no = $("#batch_no"+id).val();
                        //$('#medicine_name'+rowid).select2("val", '');
                        //alert(rowid)
                        var div_data = "";
                        $('#medicine_batch_id' + rowid).val('');
                        $('#quantity_edit').val('');
                        $('#totaleditqty' + rowid).html('');
                        $('#available_edit_quantity' + rowid).val('');
                        //$('#sale_price_edit' + rowid).val('');
                        $('#edit_expire_date' + rowid).val('');
                        $("#batch_edit_no" + rowid).html("<option value='l'><?php echo $this->lang->line('loading') ?></option>");
                        $("#batch_edit_no" + rowid).html("<option value=''>Select</option>");
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
                                // $("#batch_edit_no" + rowid).html("<option value=''>Select</option>");
                                $('#batch_edit_no' + rowid).append(div_data);
                                geteditExpire(rowid)
                            }
                        });
                    }
                </script>
                <div class="col-md-12" style="clear: both;">
                    <div class="">
                        <table class="table table-striped table-bordered table-hover" id="edittableID">
                            <tr style="font-size: 13">
                                <th><?php echo $this->lang->line('medicine') . " " . $this->lang->line('category'); ?><small class="req" style="color:red;"> *</small></th>
                                <th><?php echo $this->lang->line('medicine') . " " . $this->lang->line('name'); ?><small class="req" style="color:red;"> *</small></th>
                                <th><?php echo $this->lang->line('batch') . " " . $this->lang->line('no'); ?><small class="req" style="color:red;">*</small></th>
                                <th><?php echo $this->lang->line('expire') . " " . $this->lang->line('date'); ?><small class="req" style="color:red;"> *</small></th>
                                <th class="text-right"><?php echo $this->lang->line('quantity'); ?><small class="req" style="color:red;"> *</small> <?php echo " | " . $this->lang->line('available') . " " . $this->lang->line('qty'); ?></th>
                                <th class="text-right"><?php echo $this->lang->line('sale_price') . ' (' . $currency_symbol . ')'; ?><small class="req" style="color:red;"> *</small></th>
                                <th class="text-right"><?php echo $this->lang->line('amount') . " (" . $currency_symbol . ")"; ?><small class="req" style="color:red;"> *</small></th>
                            </tr>
                            <?php
                            $i = 0;
                            foreach ($detail as $key => $value) {
                                # code...
                                // echo "<pre>";
                                //  print_r($value);
                                ?>
                                <script type="text/javascript">
                                    getmedicine_edit_name('<?php echo $value['medicine_category_id'] ?>', '<?php echo $i ?>', '<?php echo $value['medicine_id'] ?>');


                                    geteditbatchnolist('<?php echo $value['medicine_id'] ?>', '<?php echo $i ?>', '<?php echo $value['batch_no'] ?>');
                                    geteditQuantity('<?php echo $i ?>','<?php echo $value['medicine_id'] ?>','<?php echo $value['batch_no'] ?>');
                                </script>
                                <tr id="row<?php echo $i ?>">
                                    <td width="16%"> 
                                        <input name="id" type="hidden" class="form-control" value="<?php echo $value['id']; ?>" />
                                        <select class="form-control" name='medicine_category_id[]'  onchange="getmedicine_edit_name(this.value, '<?php echo $i ?>', '<?php echo $value['medicine_name'] ?>')">
                                            <option value=""><?php echo $this->lang->line('select') ?>
                                            </option>
                                            <?php foreach ($medicineCategory as $dkey => $dvalue) {
                                                ?>
                                                <option value="<?php echo $dvalue["id"]; ?>" <?php if ($value["medicine_category_id"] == $dvalue["id"]) echo "selected"; ?> ><?php echo $dvalue["medicine_category"] ?>
                                                </option>   
    <?php } ?>
                                        </select>
                                        <span class="text-danger"><?php echo form_error('medicine_category_id[]'); ?>
                                        </span>
                                    </td>
                                    <td width="24%">
                                        <select class="form-control select2" style="width: 100%" id="medicine_edit_name<?php echo $i ?>" name='medicine_name[]' onchange="geteditbatchnolist(this.value, '<?php echo $i ?>')">
                                            <option value="<?php echo set_value('medicine_name'); ?>"><?php echo $this->lang->line('select') ?>
                                            </option>  
                                        </select>
                                        <span class="text-danger"><?php echo form_error('medicine_name[]'); ?>
                                    </td>
                                    <td width="16%"> 
                                        <select name="batch_no[]" onchange="geteditExpire(<?php echo $i ?>)" placeholder="Batch No" class="form-control" id="batch_edit_no<?php echo $i ?>">
                                            <option value="<?php echo $value['batch_no']; ?>" selected><?php echo $value['batch_no']; ?></option>
                                        </select>
                                        <span class="text-danger"><?php echo form_error('batch_no[]'); ?></span>
                                    </td>
                                    <td width="8%">
                                        <input type="text" readonly="" name="expire_date[]" id="edit_expire_date<?php echo $i ?>" class="form-control" value="<?php echo $value['expire_date']; ?>" >
                                        <span class="text-danger"><?php echo form_error('expire_date[]'); ?>
                                        </span>
                                    </td>

                                    <td class="text-right">
                                      <!--input type="text" name="quantity[]" id="quantity_edit<?php echo $i ?>" placeholder="Quantity" class="form-control" id="quantity_edit" onchange="multiply(<?php echo $i ?>)" onfocus="geteditQuantity('<?php echo $i ?>')" value="<?php echo $value['quantity']; ?>"/>
                                      <span id="totaleditqty<?php echo $i ?>" class="text-danger"><?php echo form_error('quantity[]'); ?></span-->
                                        <div class="input-group">
                                            <input type="text" name="quantity[]" onchange="multiply(<?php echo $i ?>)" onfocus="geteditQuantity(<?php echo $i ?>)" value="<?php echo $value['quantity']; ?>" id="quantity_edit<?php echo $i ?>" class="form-control text-right">
                                            <span class="input-group-addon text-danger"  id="totaleditqty<?php echo $i ?>">&nbsp;&nbsp;</span>
                                        </div>
                                        <input type="hidden" name="available_quantity[]" id="available_edit_quantity<?php echo $i ?>">
                                        <input type="hidden" name="medicine_batch_id[]" id="medicine_batch_id<?php echo $i ?>" >
                                        <input type="hidden" name="bill_detail_id[]" value="<?php echo $value["id"] ?>" >
                                    </td>
                                    <td class="text-right">
                                        <input type="text" name="sale_price[]" onchange="multiply(<?php echo $i ?>)" id="sale_price_edit<?php echo $i ?>" value="<?php echo $value['sale_price']; ?>" placeholder="Sale Price" class="form-control text-right" />
                                        <span class="text-danger"><?php echo form_error('sale_price[]'); ?></span>
                                    </td>
                                    <td class="text-right">
                                        <input type="text" name="amount[]" id="amount_edit<?php echo $i ?>" placeholder="Amount" class="form-control text-right" value="<?php echo $value['amount']; ?>"/>
                                        <span class="text-danger"><?php echo form_error('amount[]'); ?></span>
                                    </td>
                                    <?php if ($i != 0) { ?>
                                        <td><button type='button' onclick="delete_row('<?php echo $i ?>')" class='closebtn'><i class='fa fa-remove'></i></button></td>
                                <?php } else { ?>
                                        <td><button type="button" onclick="editMore()" style="color:#2196f3" class="closebtn"><i class="fa fa-plus"></i></button></td>
                                <?php } ?>
                                </tr>
    <?php
    $i++;
}
?>
                        </table>
                    </div>  
                    <div class="divider"></div>

                    <!-- <div class="col-sm-4">
                      <div class="form-group">
                        <input type="text" placeholder="Total" value="<?php //echo $result["total"]     ?>" name="total" id="edittotal" class="form-control"/>
                      </div>
                    </div>
                    -->
                    <div class="col-sm-6">
                        <div class="form-group">   
                            <label><?php echo $this->lang->line('note'); ?></label>
                            <textarea name="note" rows="3" id="note" class="form-control"></textarea>
                        </div> 
                    </div>  
                    <div class="col-sm-6">

                        <table class="printablea4">
                            <tr>
                                <th><?php echo $this->lang->line('total') . " (" . $currency_symbol . ")"; ?></th>
                                <td class="text-right ipdbilltable" width="40%" colspan="2"><input type="text" placeholder="Total" value="<?php echo $result["total"] ?>" value="0" name="total" id="edittotal"  style="width: 30%; float: right" class="form-control"/></td>
                            </tr>
                            <tr>
                                <th><?php echo $this->lang->line('discount') . " (" . $currency_symbol . ")"; ?></th>

                                <td class="text-right ipdbilltable"><h4 style="float: right;font-size: 12px; padding-left: 5px;"> %</h4><input type="text" placeholder="Discount" value="" name="discount_percent" id="editdiscount_percent" style="width: 50%; float: right;font-size: 12px;" class="form-control"/></td>
                                <td class="text-right ipdbilltable"><input type="text" placeholder="Discount" value="<?php echo $result["discount"] ?>" name="discount" id="editdiscount" style="width: 40%; float: right" class="form-control"/></td>
                            </tr>
                            <tr>
                                <th><?php echo $this->lang->line('tax') . " (" . $currency_symbol . ")"; ?></th>

                                <td class="text-right ipdbilltable">
                                    <h4 style="float: right;font-size: 12px;padding-left: 5px;"> %</h4><input type="text" placeholder="Tax" name="tax_percent" value="" id="edittax_percent" style="width: 50%; float: right;font-size: 12px;" class="form-control"/>
                                </td>
                                <td class="text-right ipdbilltable"><input type="text" placeholder="Tax" name="tax" value="<?php echo $result["tax"] ?>" id="edittax" style="width: 40%; float: right" class="form-control"/></td>
                            </tr>
                            <tr>
                                <th><?php echo $this->lang->line('net_amount') . "(" . $currency_symbol . ")"; ?></th>
                                <td class="text-right ipdbilltable" width="40%" colspan="2"><input type="text" placeholder="Net Amount" value="<?php echo $result["net_amount"] ?>" name="net_amount" id="editnet_amount" style="width: 30%; float: right" class="form-control"/></td>
                            </tr>


                        </table>


                    </div><!--.col-sm-6-->
                </div><!--./row-->  
            </div><!--.col-sm-12-->
            <!--  <div class="col-sm-offset-9 ">
               <label>Total</label>
               <input type="text" name="total" placeholder="Total">
             </div> -->
        </div><!--./row-->   

    </div><!--./col-md-12--> 
    <div class="box-footer" style="clear: both">
        <div class="pull-right">
            <input type="button" onclick="addEditTotal()" value="<?php echo $this->lang->line('calculate'); ?>" class="btn btn-info"/>&nbsp;
            <button type="submit" style="display: none" data-loading-text="<?php echo $this->lang->line('processing') ?>" id="editbillsave" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
        </div>
    </div><!--./box-footer-->


</form>      




<script type="text/javascript">
    function multiply(id) {

        var quantity = $('#quantity_edit' + id).val();
        var availquantity = $('#available_edit_quantity' + id).val();
        if (parseInt(quantity) > parseInt(availquantity)) {
            errorMsg('Order quantity should not be greater than available quantity');
        } else {
            //alert(parseInt(quantity));
        }
        var sale_price = $('#sale_price_edit' + id).val();
        var amount = quantity * sale_price;


        $('#amount_edit' + id).val(amount);
    }

    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2();


    });
    var expire_date = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(), ['d' => 'DD', 'm' => 'MM', 'Y' => 'YYYY',]) ?>';
    $('.expires_date').datepicker({
        format: "M/yyyy",
        viewMode: "months",
        minViewMode: "months",
        autoclose: true
    });

    function editMore() {
        var table = document.getElementById("edittableID");
        var table_len = (table.rows.length);
        var id = parseInt(table_len);
        var div = "<td><select class='form-control' name='medicine_category_id[]' onchange='getmedicine_edit_name(this.value," + id + ")'><option value='<?php echo set_value('medicine_category_id'); ?>'><?php echo $this->lang->line('select') ?></option><?php foreach ($medicineCategory as $dkey => $dvalue) { ?><option value='<?php echo $dvalue["id"]; ?>'><?php echo $dvalue["medicine_category"] ?></option><?php } ?></select></td><td><select class='form-control select2' name='medicine_name[]' onchange='geteditbatchnolist(this.value," + id + ")' id='medicine_edit_name" + id + "' ><option value='<?php echo set_value('medicine_name'); ?>'><?php echo $this->lang->line('select') ?></option></select></td><td><select name='batch_no[]' onchange='getneweditExpire(" + id + ")' id='batch_edit_no" + id + "'  class='form-control'><option></option></select></td><td><input type='text' id='edit_expire_date" + id + "' readonly name='expire_date[]' class='form-control'></td><td><div class='input-group'><input type='text' name='quantity[]' onchange='multiply(" + id + ")' onfocus='geteditQuantity(" + id + ")' id='quantity_edit" + id + "' class='form-control text-right'><span class='input-group-addon text-danger'  id='totaleditqty" + id + "'>&nbsp;&nbsp;</span></div><input type='hidden' name='available_quantity[]' id='available_edit_quantity" + id + "'><input type=hidden class=form-control value='0' name='bill_detail_id[]'  /><input type='hidden' name='medicine_batch_id[]' id='medicine_batch_id" + id + "'></td><td> <input type='text' name='sale_price[]' onchange='multiply(" + id + ")' id='sale_price_edit" + id + "'  class='form-control text-right'></td><td><input type='text' name='amount[]' id='amount_edit" + id + "'  class='form-control text-right'></td>";

        var row = table.insertRow(table_len).outerHTML = "<tr id='row" + id + "'>" + div + "<td><button type='button' onclick='delete_row(" + id + ")' class='closebtn'><i class='fa fa-remove'></i></button></td></tr>";

        var expire_date = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(), ['d' => 'DD', 'm' => 'MM', 'Y' => 'YYYY',]) ?>';
        $('.expires_date').datepicker({
            format: "M/yyyy",
            viewMode: "months",
            minViewMode: "months",
            autoclose: true,
        });
        $('.select2').select2();
    }
    function addEditTotal() {
        var total = 0;
        var sale_price = document.getElementsByName('amount[]');
        for (var i = 0; i < sale_price.length; i++) {
            var inp = sale_price[i];
            if (inp.value == '') {
                var inpvalue = 0;
            } else {
                var inpvalue = inp.value;
            }
            total += parseFloat(inpvalue);
        }

        var tax_percent = $("#edittax_percent").val();
        var discount_percent = $("#editdiscount_percent").val();

        if (discount_percent != '') {
            var discount = (total * discount_percent) / 100;
            $("#editdiscount").val(discount.toFixed(2));
        } else {
            var discount = $("#editdiscount").val();
            //var discount = 0; 
        }

        if (tax_percent != '') {
            var tax = ((total - discount) * tax_percent) / 100;
            $("#edittax").val(tax.toFixed(2));
        } else {
            var tax = $("#edittax").val();
            // var tax = 0; 
        }


        $("#edittotal").val(total.toFixed(2));
        var net_amount = parseFloat(total) + parseFloat(tax) - parseFloat(discount);

        $("#editnet_amount").val(net_amount.toFixed(2));
        var patient_id = $("#addeditpatient_id").val();
        $("#editbillpatientid").val(patient_id);
        var editdate = $("#editdate").val();
        $("#editbilldate").val(editdate);
        $("#editbillsave").show();
    }

    function delete_row(id) {
        var table = document.getElementById("edittableID");
        var rowCount = table.rows.length;
        $("#row" + id).html("");
    }

    $(document).ready(function (e) {
        $("#editbill").on('submit', (function (e) {
            $("#editbillsave").button('loading');

            /* var patient_id = $("#addeditpatient_id").val();
             $("#editbillpatientid").val(patient_id);
             var editdate = $("#editdate").val();
             $("#editbilldate").val(editdate);*/
            // console.log(editdate);
            var table = document.getElementById("edittableID");
            var rowCount = table.rows.length;

            for (var k = 0; k < rowCount; k++) {
                var quantityk = $('#quantity_edit' + k).val();
                var availquantityk = $('#available_edit_quantity' + k).val();
                if (parseInt(quantityk) > parseInt(availquantityk)) {
                    errorMsg('Order quantity should not be greater than available quantity');

                    return false;
                } else {
                }
            }
            e.preventDefault();
            $.ajax({
                url: '<?php echo base_url(); ?>admin/pharmacy/updateBill',
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
                error: function () {}
            });
            $("#editbillsave").button('reset');
        }));
    });
    // function viewDetail(id){
    //   $.ajax({
    //     url: '<?php echo base_url() ?>admin/pharmacy/getBillDetails/'+id,
    //     type: "GET",     
    //     data: { id:id },
    //     success: function (data) { 
    //       $('#reportdata').html(data); 
    //     },
    //   });
    // } 


// function add_instruction(id){
//     $('#ins_patient_id').val(id);
// }
</script>
<script type="text/javascript">
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
