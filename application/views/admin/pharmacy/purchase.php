<?php
$currency_symbol = $this->customlib->getSchoolCurrencyFormat();
$genderList = $this->customlib->getGender();
?>
<style type="text/css">
    #easySelectable {/*display: flex; flex-wrap: wrap;*/}
    #easySelectable li {}
    #easySelectable li.es-selected {background: #2196F3; color: #fff;}
    .easySelectable {-webkit-user-select:none; -moz-user-select:none; -ms-user-select: none;}
    .printablea4{width: 100%;}
    /*.printablea4 p{margin-bottom: 0;}*/
    .printablea4>tbody>tr>th,
    .printablea4>tbody>tr>td{padding:2px 0; line-height: 1.42857143;vertical-align: top; font-size: 12px;}
</style>
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title titlefix"><?php echo $this->lang->line('medicines') . " " . $this->lang->line('purchase') . " " . $this->lang->line('list'); ?></h3>
                        <div class="box-tools pull-right">
                            <?php if ($this->rbac->hasPrivilege('medicine_purchase', 'can_add')) { ?>
                                <a data-toggle="modal" onclick="holdModal('myModal')" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> <?php echo $this->lang->line('purchase') . " " . $this->lang->line('medicine'); ?></a> 
                            <?php } ?>

                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="download_label"><?php echo $this->lang->line('medicines') . " " . $this->lang->line('purchase') . " " . $this->lang->line('list'); ?></div>
                        <table class="table table-striped table-bordered table-hover example" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th><?php echo $this->lang->line('purchase') . " " . $this->lang->line('no'); ?></th>
                                    <th><?php echo $this->lang->line('supplier') . " " . $this->lang->line('name'); ?></th>
                                    <th><?php echo $this->lang->line('amount'); ?></th>
                                    <th><?php echo $this->lang->line('tax'); ?></th>
                                    <th><?php echo $this->lang->line('discount'); ?></th>
                                    <th><?php echo $this->lang->line('total'); ?></th>
                                    <th><?php echo $this->lang->line('action'); ?></th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                foreach ($resultlist as $pharmacy) {
                                    ?>
                                    <tr class="">
                                        <td >
                                            <?php if ($this->rbac->hasPrivilege('medicine_purchase', 'can_view')) { ?>   
                                                <a href="#" onclick="viewDetail('<?php echo $pharmacy['id'] ?>')"
                                                   data-toggle="tooltip"  title="<?php echo $this->lang->line('show'); ?>" ><?php echo $pharmacy['purchase_no']; ?></a> 
                                               <?php } ?> 
                                        </td>

                                        <td><?php echo $pharmacy['supplier_category']; ?></td>
                                        <td><?php echo $pharmacy['total']; ?></td>
                                        <td><?php echo $pharmacy['tax']; ?></td>
                                        <td><?php echo $pharmacy['discount']; ?></td>
                                        <td><?php echo $pharmacy['net_amount']; ?></td>
                                        <td class="">

                                            <a href="#" 
                                               onclick="viewDetail(<?php echo $pharmacy['id'] ?>,<?php echo $pharmacy['purchase_no'] ?>,<?php echo $pharmacy['supplier_id'] ?>)"
                                               class="btn btn-default btn-xs"  data-toggle="tooltip"
                                               title="<?php echo $this->lang->line('show'); ?>" >
                                                <i class="fa fa-reorder"></i>
                                            </a>
                                            <?php if (!empty($pharmacy['file'])) { ?>
                                                <a href="<?php echo base_url(); ?>admin/pharmacy/download/<?php echo $pharmacy['file'] ?>"class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('download'); ?>">
                                                    <i class="fa fa-download"></i>
                                                </a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    </tr>
                                    <?php
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


<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog pup100" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <div class="row modalbillform">
                    <div class="col-lg-4 col-sm-5">
                        <!--  <label for="">
                        <?php echo $this->lang->line('supplier'); ?>
                                            </label>
                                            <small class="req" style="color:red;"> *</small> -->

                        <select style="width:100%" onchange="get_SupplierDetails(this.value)"   class="form-control select2" <?php
                        if ($disable_option == true) {
                            echo "disabled";
                        }
                        ?>  id="" name='' >
                            <option value=""><?php echo $this->lang->line('select') . " " . $this->lang->line('supplier') ?></option>
                            <?php foreach ($supplierCategory as $dkey => $dvalue) {
                                ?>
                                <option value="<?php echo $dvalue["id"]; ?>" <?php
                                if ((isset($supplier_select)) && ($supplier_select == $dvalue["id"])) {
                                    echo "selected";
                                }
                                ?>><?php echo $dvalue["supplier_category"]; ?></option>   
<?php } ?>
                        </select>

                        <span class="text-danger"><?php echo form_error('refference'); ?></span>

                    </div><!--./col-sm-5-->  
                    <div class="col-lg-6 col-sm-6"> 
                        <div class="row">        
                            <div class="col-lg-3 col-sm-4 col-xs-5">
                                <label><?php echo $this->lang->line('purchase') . " " . $this->lang->line('date'); ?></label>
                            </div><!--./col-sm-6-->
                            <div class="col-lg-5 col-sm-4 col-xs-7">                 
                                <input name="date" id="date_supplier"  type="text" value="<?php echo date($this->customlib->getSchoolDateFormat(true, true)) ?>" class="form-control datetime"/>
                                <span class="text-danger"><?php echo form_error('date'); ?></span>
                            </div><!--./col-sm-6-->
                        </div><!--./row-->    
                    </div><!--./col-sm-6--> 
                    <div class="">
                        <button type="button" data-toggle="tooltip" title="<?php echo $this->lang->line('close'); ?>" class="close" data-dismiss="modal">&times;</button>
                        <!-- <h4 class="box-title"><?php echo $this->lang->line('purchase') . " " . $this->lang->line('medicine'); ?></h4>  -->
                    </div><!--./col-sm-6-->   
                </div><!--./row--> 
            </div><!--./modal-header-->
            <div class="modal-body pt0 pb0">
                <form id="bill" accept-charset="utf-8" method="post" class="ptt10">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 paddlr">

                            <div class="row">
                                <input name="supplier_id" id="supplierid" type="hidden" class="form-control"/>
                                <!--  
                                 <div class="col-sm-2">
                                     <div class="form-group">
                                         <label> <th><?php echo $this->lang->line('purchase') . " " . $this->lang->line('date'); ?></th></label>
                                         <small class="req" style="color:red;"> *</small> 
                                         <input name="date"  type="text" value="<?php echo date($this->customlib->getSchoolDateFormat(true, true)) ?>" class="form-control datetime"/>
                                         <span class="text-danger"><?php echo form_error('date'); ?></span>
                                     </div>
                                 </div> -->

                                <!-- <div class="col-sm-2">
    <div class="form-group">
        <label for="">
<?php echo $this->lang->line('supplier'); ?>
                                                </label>
                                                <small class="req" style="color:red;"> *</small>
        <div>
                                                        <select style="width:100%" onchange="get_SupplierDetails(this.value)" 	class="form-control select2" <?php
if ($disable_option == true) {
    echo "disabled";
}
?>  id="" name='supplier_id' >
                                                                <option value=""><?php echo $this->lang->line('select') ?></option>
                                <?php foreach ($supplierCategory as $dkey => $dvalue) {
                                    ?>
                                                                        <option value="<?php echo $dvalue["id"]; ?>" <?php
                                    if ((isset($supplier_select)) && ($supplier_select == $dvalue["id"])) {
                                        echo "selected";
                                    }
                                    ?>><?php echo $dvalue["supplier_category"]; ?></option>   
<?php } ?>
                                                        </select>
                                                </div>
                                                <span class="text-danger"><?php echo form_error('refference'); ?></span>
                                        </div>
                                </div> -->
                                <input name="date"  id="date_result" type="hidden" class="form-control"/>
                                <div class="col-sm-2" hidden>
                                    <div class="form-group">
                                        <label> <th><?php echo $this->lang->line('supplier') . " " . $this->lang->line('person'); ?></th></label>
                                        <small class="req" style="color:red;"> *</small> 
                                        <input name="supplier_name" readonly hidden id="supplier_name" type="text" class="form-control"/>

                                        <span class="text-danger"><?php echo form_error('supplier_name'); ?></span>
                                    </div>
                                </div>

                                <div class="col-md-12" style="clear: both;">
                                    <div class="">
                                        <table class="table table-striped table-bordered table-hover" id="tableID">
                                            <tr>
                                                <th width="12%"><?php echo $this->lang->line('medicine') . " " . $this->lang->line('category'); ?><small class="req" style="color:red;"> *</small></th>
                                                <th width="14%"><?php echo $this->lang->line('medicine') . " " . $this->lang->line('name'); ?><small class="req" style="color:red;"> *</small></th>
                                                <th style="width: 100px"><?php echo $this->lang->line('batch') . " " . $this->lang->line('no'); ?><small style="color:red;"> *</small></th>
                                                <th style="width: 110px"><?php echo $this->lang->line('expire') . " " . $this->lang->line('date'); ?><small class="req" style="color:red;"> *</small></th>
                                                <th style="width: 80px"><?php echo $this->lang->line('mrp') . " " . ' (' . $currency_symbol . ')'; ?><small class="req" style="color:red;"> *</small></th>
                                                <th style="width: 85px;"><?php echo $this->lang->line('batch') . " " . $this->lang->line('amt') ?></th>

                                                <th style="width: 122px"><?php echo $this->lang->line('sale_price') . " " . ' (' . $currency_symbol . ')'; ?><small class="req" style="color:red;"> *</small></th>
                                                <th style="width: 110px"><?php echo $this->lang->line('packing') . " " . $this->lang->line('qty'); ?></th>

                                                <th style="width:75px" class="text-right;"><?php echo $this->lang->line('quantity'); ?><small class="req" style="color:red;"> *</small> </th>
                                                <th style="width:155px" class="text-right"><?php echo $this->lang->line('purchase') . " " . $this->lang->line('price') . " " . ' (' . $currency_symbol . ')'; ?><small class="req" style="color:red;"> *</small></th>
                                                <th style="width:100px" class="text-right"><?php echo $this->lang->line('amount') . " (" . $currency_symbol . ")"; ?><small class="req" style="color:red;"> *</small></th>
                                            </tr>
                                            <tr id="row0">
                                                <td>      
                                                    <select class="form-control" name='medicine_category_id[]'  onchange="getmedicine_name(this.value, '0')">
                                                        <option value="<?php echo set_value('medicine_category_id'); ?>"><?php echo $this->lang->line('select') ?>
                                                        </option>
                                                        <?php foreach ($medicineCategory as $dkey => $dvalue) {
                                                            ?>
                                                            <option value="<?php echo $dvalue["id"]; ?>"><?php echo $dvalue["medicine_category"] ?>
                                                            </option>   
<?php } ?>
                                                    </select>
                                                    <span class="text-danger"><?php echo form_error('medicine_category_id[]'); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <select class="form-control select2" style="width:100%" onchange="getbatchnolist(this.value, 0)" id="medicine_name0" name='medicine_name[]'>

                                                        <option value=""><?php echo $this->lang->line('select') ?>
                                                        </option>

                                                    </select>
                                                    <span class="text-danger"><?php echo form_error('medicine_name[]'); ?>
                                                </td>


                                                <td>
                                                    <input type="text"  name="batch_no[]"  id="batchno" class="form-control">
                                                    <span class="text-danger"><?php echo form_error('batch_no[]'); ?>
                                                    </span>
                                                </td>

                                                <td>
                                                    <input type="text"  name="expiry_date[]"  id="expiry" class="form-control">
                                                    <span class="text-danger"><?php echo form_error('expiry_date[]'); ?>
                                                    </span>
                                                </td>

                                                <td>
                                                    <input type="text"  name="mrp[]"  id="mrp" class="form-control">
                                                    <span class="text-danger"><?php echo form_error('mrp[]'); ?>
                                                    </span>
                                                </td>

                                                <td>
                                                    <input type="text" name="batch_amount[]" id="batch_amount" class="form-control">
                                                    <span class="text-danger"></span>
                                                </td>
                                                <td>
                                                    <input type="text"  name="sale_rate[]"  id="sale_price" class="form-control">
                                                    <span class="text-danger"><?php echo form_error('sale_rate[]'); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <input type="text"  name="packing_qty[]"  id="packing_qty" class="form-control">
                                                    <span class="text-danger"><?php echo form_error('packing_qty[]'); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <input type="text" name="quantity[]" onchange="multiply(0)"  id="quantity0" class="form-control text-right">
                                                    </div>
                                                </td>

                                                <td class="text-right">

                                                    <input type="text" name="purchase_price[]" onchange="multiply(0)" id="purchase_price0" placeholder="" class="form-control text-right">
                                                    <span class="text-danger"><?php echo form_error('purchase_price[]'); ?></span>
                                                </td>

                                                <td class="text-right">
                                                    <input type="text" name="amount[]" id="amount0" placeholder="" class="form-control text-right">
                                                    <span class="text-danger"><?php echo form_error('net_amount[]'); ?></span>
                                                </td>
                                                <td><button type="button" onclick="addMore()" style="color: #2196f3" class="closebtn"><i class="fa fa-plus"></i></button></td>
                                            </tr>
                                        </table>
                                    </div>  
                                    <div class="divider"></div>    

                                    <div class="row">  
                                        <div class="col-sm-6">
                                            <div class="form-group">  
<?php echo $this->lang->line('note'); ?>
                                                <textarea name="note" rows="3" id="note" class="form-control"></textarea>
                                            </div>    

                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('attach_document') ?></label>
                                                <input type="file" name="file" id="file" class="form-control filestyle" />
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <table class="printablea4">
                                                <tr>
                                                    <th width="50%"><?php echo $this->lang->line('total') . " (" . $currency_symbol . ")"; ?></th>
                                                    <td width="40%" colspan="2" class="text-right ipdbilltable"><input type="text" placeholder="Total" value="0" name="total" id="total" style="width: 30%; float: right" class="form-control"/></td>
                                                </tr>

                                                <tr>
                                                    <th><?php echo $this->lang->line('discount') . " (" . $currency_symbol . ")"; ?></th>
                                                    <td class="text-right ipdbilltable"><h4 style="float: right;font-size: 12px; padding-left: 5px;"> %</h4><input type="text" placeholder="Discount" value="" name="discount_percent" id="discount_percent" style="width: 50%; float: right;font-size: 12px;" class="form-control"/></td>

                                                    <td class="text-right ipdbilltable"><input type="text" placeholder="Discount" value="0" name="discount" id="discount" style="width: 50%; float: right" class="form-control"/></td>
                                                </tr>

                                                <tr>
                                                    <th><?php echo $this->lang->line('tax') . " (" . $currency_symbol . ")"; ?></th>
                                                    <td class="text-right ipdbilltable">
                                                        <h4 style="float: right;font-size: 12px;     padding-left: 5px;"> %</h4><input type="text" placeholder="Tax" name="tax_percent" value="" id="tax_percent" style="width: 50%; float: right;font-size: 12px;" class="form-control"/>
                                                    </td>

                                                    <td class="text-right ipdbilltable">
                                                        <input type="text" placeholder="Tax" name="tax" value="0" id="tax" style="width: 50%; float: right" class="form-control"/>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th><?php echo $this->lang->line('net_amount') . " (" . $currency_symbol . ")"; ?></th>
                                                    <td colspan="2" class="text-right ipdbilltable">
                                                        <input type="text" placeholder="Net Amount" value="0" name="net_amount" id="net_amount" style="width: 30%; float: right" class="form-control"/></td>
                                                </tr>
                                            </table>
                                        </div>


                                    </div><!--./row-->  
                                </div><!--./col-md-12-->

                            </div><!--./row-->  

                        </div><!--./col-md-12-->    
                    </div><!--./row-->

            </div><!--./modal-body-->
            <div class="box-footer" style="clear: both;">
                <div class="pull-right">
                    <input type="button" onclick="addTotal()" value="<?php echo $this->lang->line('calculate'); ?>" class="btn btn-info"/>&nbsp;
                    <button type="submit" data-loading-text="<?php echo $this->lang->line('processing') ?>" style="display: none" id="billsave" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                </div>
            </div><!--./box-footer-->
            </form>
        </div>
    </div> 
</div>

<div class="modal fade" id="viewModal"  role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog pup100" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-toggle="tooltip" title="" data-dismiss="modal" data-original-title="Close" autocomplete="off">&times;</button>
                <div class="modalicon"> 
                    <div id='edit_deletebill'>
                        <a href="#" data-toggle="tooltip"  data-target="#edit_prescription"  data-toggle="modal" title="" data-original-title="<?php echo $this->lang->line('edit'); ?>"><i class="fa fa-pencil"></i></a>

                        <a href="#" data-toggle="tooltip" title="" data-original-title="<?php echo $this->lang->line('delete'); ?>"><i class="fa fa-trash"></i></a>
                    </div>
                </div>
                <h4 class="box-title"><?php echo $this->lang->line('purchase') . " " . $this->lang->line('details'); ?></h4> 
            </div>
            <div class="modal-body pt0 pb0">
                <div id="reportdata"></div>
            </div>
        </div>
    </div>    
</div>

<div class="modal fade" id="edit_bill" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog pup100" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <div class="row modalbillform">
                    <div class="col-sm-3">
                        <select style="width:100%" onchange="get_SupplierDetails(this.value)"   class="form-control select2"   id="editsupplier" name='supplier' >
                            <option value=""><?php echo $this->lang->line('select') . " " . $this->lang->line('supplier') ?></option>
                            <?php foreach ($supplierCategory as $dkey => $dvalue) { ?>
                                <option value="<?php echo $dvalue["id"]; ?>" <?php
                                        if ((isset($supplier_select)) && ($supplier_select == $dvalue["id"])) {
                                            echo "selected";
                                        }
                                        ?>><?php echo $dvalue["supplier_category"]; ?></option>   
<?php } ?>
                        </select>

                        <span class="text-danger"><?php echo form_error('refference'); ?></span>

                    </div><!--./col-sm-5-->  


                    <div class="col-sm-4"> 
                        <div class="row">        
                            <div class="col-lg-4 col-sm-5 col-xs-6">
                                <label><?php echo $this->lang->line('purchase') . " " . $this->lang->line('no'); ?></label>
                            </div><!--./col-sm-6-->
                            <div class="col-lg-5 col-sm-5 col-xs-6">                 
                                <input name="purchase_no" id="purchaseno"  readonly type="text" class="form-control" value="" />
                                <span class="text-danger"><?php echo form_error('purchase_no'); ?></span>
                            </div><!--./col-sm-6-->
                        </div><!--./row-->    
                    </div><!--./col-sm-6--> 

                    <div class="col-sm-4"> 
                        <div class="row">        
                            <div class="col-lg-4 col-sm-6 col-xs-5">
                                <label><?php echo $this->lang->line('purchase') . " " . $this->lang->line('date'); ?></label>
                            </div><!--./col-sm-6-->
                            <div class="col-lg-5 col-sm-6 col-xs-7">                 
                                <input name="date" id="dateedit_supplier"  type="text" value="" class="form-control datetime"/>
                                <span class="text-danger"><?php echo form_error('date'); ?></span>
                            </div><!--./col-sm-6-->
                        </div><!--./row-->    
                    </div><!--./col-sm-6--> 


                    <div class="pull-right">
                        <button type="button" data-toggle="tooltip" title="<?php echo $this->lang->line('close'); ?>" class="close" data-dismiss="modal">&times;</button>
                        <!-- <h4 class="box-title"><?php echo $this->lang->line('purchase') . " " . $this->lang->line('medicine'); ?></h4>  -->
                    </div><!--./col-sm-6-->   
                </div><!--./row--> 
            </div>                 
            <div class="modal-body pt0 pb0" id="edit_bill_details">
            </div>    
        </div>
    </div> 
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

            function holdModal(modalId) {
                $('#' + modalId).modal({
                    backdrop: 'static',
                    keyboard: false,
                    show: true
                });
            }

</script>

<script>
            function getmedicine_name(id, rowid) {
                var div_data = "";

                //$("#medicine_name" + rowid).prepend($('<option></option>').html('Loading...'));
                $("#medicine_name" + rowid).html("<option value='l'><?php echo $this->lang->line('loading') ?></option>");
                $('#medicine_name' + rowid).select2("val", 'l');
                $.ajax({
                    url: '<?php echo base_url(); ?>admin/pharmacy/get_medicine_name',
                    type: "POST",
                    data: {medicine_category_id: id},
                    dataType: 'json',
                    success: function (res) {
                        $.each(res, function (i, obj)
                        {
                            var sel = "";
                            div_data += "<option value=" + obj.id + ">" + obj.medicine_name + "</option>";
                        });
                        $("#medicine_name" + rowid).html("<option value=''>Select</option>");
                        $('#medicine_name' + rowid).append(div_data);
                        $('#medicine_name' + rowid).select2("val", '');
                        //$('#medicine_name'+rowid).select2();
                    }
                });
            }

            function edit_bill(id, purchase_no, supplier_id) {
            $.ajax({
            url: '<?php echo base_url(); ?>admin/pharmacy/getindate',
            type: "POST",
            data: {purchase_id: id},
            dataType: 'json',
            success: function (data) {
            var date_format = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(true, false), ['d' => 'dd', 'm' => 'MM', 'Y' => 'yyyy',]) ?>';
            ///new Date().toLocaleTimeString();
            var indate = new Date(data.date).toString(date_format);
            $('#dateedit_supplier').val(indate);
            $('#editsupplier').val(data.supplier_id);
           $('#purchaseno').val(data.purchase_no);
               $.ajax({
                    url: '<?php echo base_url(); ?>admin/pharmacy/editSupplierBill/' + id,
                    success: function (res) {
                        $('#viewModal').modal('hide');
                        $("#edit_bill_details").html(res);
                        holdModal('edit_bill');
                    },
                    error: function () {
                        alert("Fail")
                    }
                });

             }
           
        });
                
        } 

            function get_SupplierDetails(id) {
                $("#supplier_name").html("supplier_name");
                //$("#schedule_charge").html("schedule_charge");

                $.ajax({
                    url: '<?php echo base_url(); ?>admin/pharmacy/supplierDetails',
                    type: "POST",
                    data: {id: id},
                    dataType: 'json',
                    success: function (res) {
                        console.log(res);
                        if (res) {
                            $('#supplier_name').val(res.supplier_person);
                            $('#supplierid').val(res.id);
                        } else {
                            $('#supplier_name').val('Null');

                        }
                    }
                });
            }

            $(document).ready(function (e) {

                $('#expiry').datepicker({
                    format: "M/yyyy",
                    viewMode: "months",
                    minViewMode: "months",
                    autoclose: true
                });
            });
            function addMore() {
                var table = document.getElementById("tableID");
                var table_len = (table.rows.length);
                var id = parseInt(table_len - 1);
                var div = "<td><select class='form-control' name='medicine_category_id[]' onchange='getmedicine_name(this.value," + id + ")'><option value='<?php echo set_value('medicine_category_id'); ?>'><?php echo $this->lang->line('select') ?></option><?php foreach ($medicineCategory as $dkey => $dvalue) { ?><option value='<?php echo $dvalue["id"]; ?>'><?php echo $dvalue["medicine_category"] ?></option><?php } ?></select></td><td><select class='form-control select2' style='width:100%' name='medicine_name[]' onchange='getbatchnolist(this.value," + id + ")' id='medicine_name" + id + "' ><option value='<?php echo set_value('medicine_name'); ?>'><?php echo $this->lang->line('select') ?></option></select></td><td><input type='text' name='batch_no[]' id='batchno" + id + "' class='form-control batch_no'></td><td><input type='text' name='expiry_date[]' id='expiry" + id + "' class='form-control expiry_date'></td><td><input type='text' name='mrp[]' id='mrp" + id + "' class='form-control mrp'></td><td><input type='text' name='batch_amount[]' id='batch_amount" + id + "' class='form-control mrp'></td><td><input type='text' name='sale_rate[]' id='salerate" + id + "' class='form-control sale_rate'></td><td><input type='text' name='packing_qty[]' id='packingqty" + id + "' class='form-control packing_qty'></td><td><div class='input-group'><input type='text' name='quantity[]' onchange='multiply(" + id + ")' onfocus='getQuantity(" + id + ")' id='quantity" + id + "' class='form-control text-right'></div></td><td><input type='text' onchange='multiply(" + id + ")' name='purchase_price[]' id='purchase_price" + id + "'  class='form-control text-right'></td><td><input type='text' name='amount[]' id='amount" + id + "'  class='form-control text-right'></td>";

                var row = table.insertRow(table_len).outerHTML = "<tr id='row" + id + "'>" + div + "<td><button type='button' onclick='delete_row(" + id + ")' class='closebtn'><i class='fa fa-remove'></i></button></td></tr>";
                $('.select2').select2();

                var expiry_date = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(), ['d' => 'DD', 'm' => 'MM', 'Y' => 'YYYY',]) ?>';
                $('.expiry_date').datepicker({
                    format: "M/yyyy",
                    viewMode: "months",
                    minViewMode: "months",
                    autoclose: true
                });
            }

         
            function delete_row(id) {
                var table = document.getElementById("tableID");
                var rowCount = table.rows.length;
                $("#row" + id).remove();
            }


            function addTotal() {
                var total = 0;
                var sale_price = document.getElementsByName('amount[]');
                for (var i = 0; i < sale_price.length; i++) {
                    var inp = sale_price[i];
                    if (inp.value == '') {
                        var inpvalue = 0;
                    } else {
                        var inpvalue = inp.value;
                    }
                    total += parseInt(inpvalue);
                }
                var discount_percent = $("#discount_percent").val();
                var tax_percent = $("#tax_percent").val();
                // var discount_amnt = $("#discount").val();
                //var tax_amnt = $("#tax").val();

                if (discount_percent != '') {
                    var discount = (total * discount_percent) / 100;
                    $("#discount").val(discount.toFixed(2));
                } else {
                    var discount = $("#discount").val();
                    //var discount = 0; 
                }

                if (tax_percent != '') {
                    var tax = ((total - discount) * tax_percent) / 100;
                    $("#tax").val(tax.toFixed(2));
                } else {
                    var tax = $("#tax").val();
                    // var tax = 0; 
                }


                //   var tax = $("#tax").val();
                //  var discount = $("#discount").val();
                $("#total").val(total.toFixed(2));

                var net_amount = parseFloat(total) + parseFloat(tax) - parseFloat(discount);
                // var net_amount = (total)+(tax) - (discount);
                //  alert(net_amount);
                var cnet_amount = net_amount.toFixed(2)
                $("#net_amount").val(cnet_amount);
                var editdate = $("#date_supplier").val();
                $("#date_result").val(editdate);
                $("#billsave").show();
                $(".printsavebtn").show();
            }

            /* function addTotal() {
             var total = 0;
             var purchase_price = document.getElementsByName('amount[]');
             for (var i = 0; i < purchase_price.length; i++) {
             var inp = purchase_price[i];
             if (inp.value == '') {
             var inpvalue = 0;
             } else {
             var inpvalue = inp.value;
             }
             total += parseInt(inpvalue);
             }
             var tax = $("#tax").val();
             var discount = $("#discount").val();
             
             $("#total").val(total);
             var net_amount = parseInt(total) + parseInt(tax) - parseInt(discount);
             $("#net_amount").val(net_amount);
             $("#billsave").show();
             }
             */
            $(document).ready(function (e) {
                $("#bill").on('submit', (function (e) {

                    e.preventDefault();
                    var btn = $("#billsave");
                    btn.button('loading');
                    var table = document.getElementById("tableID");
                    var rowCount = table.rows.length;
                    $.ajax({
                        url: '<?php echo base_url(); ?>admin/pharmacy/addBillSupplier',
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
                            $("#billsave").button('reset');
                        },
                        error: function () {}
                    });   //alert(parseInt(quantity));



                }));
            });

            $(document).ready(function (e) {

                var expiry_date = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(), ['d' => 'DD', 'm' => 'MM', 'Y' => 'YYYY',]) ?>';
                $('.expiry_date').datepicker({
                    format: "M/yyyy",
                    viewMode: "months",
                    minViewMode: "months",
                    autoclose: true,
                });
            });

            function viewDetail(id, purchase_no, supplier_id) {

                $.ajax({
                    url: '<?php echo base_url() ?>admin/pharmacy/getSupplierDetails/' + id,
                    type: "GET",
                    data: {id: id},
                    success: function (data) {
                        $('#reportdata').html(data);
                        $('#edit_deletebill').html("<?php if ($this->rbac->hasPrivilege('medicine_purchase', 'can_view')) { ?><a href='#' data-toggle='tooltip' onclick='printData(" + id + ")'   data-original-title='<?php echo $this->lang->line('print'); ?>'><i class='fa fa-print'></i></a> <?php } ?><?php if ($this->rbac->hasPrivilege('medicine_purchase', 'can_edit')) { ?><a href='#'' onclick='edit_bill(" + id + "," + purchase_no + "," + supplier_id + ")' data-toggle='tooltip'  data-original-title='<?php echo $this->lang->line('edit'); ?>'><i class='fa fa-pencil'></i></a><?php } ?><?php if ($this->rbac->hasPrivilege('medicine_purchase', 'can_delete')) { ?><a onclick='delete_bill(" + id + ")'  href='#'  data-toggle='tooltip'  data-original-title='<?php echo $this->lang->line('delete'); ?>'><i class='fa fa-trash'></i></a><?php } ?>");
                        holdModal('viewModal');
                    },
                });
            }
            /* function getQuantity(id) {
             var batch_no = $('#batch_no' + id).val();
             if (batch_no != "") {
             $('#quantity').html("");
             $.ajax({
             type: "GET",
             url: base_url + "admin/pharmacy/getQuantity",
             data: {'batch_no': batch_no},
             dataType: 'json',
             success: function (data) {
             $('#id' + id).val(data.id);
             //$('#quantity').html(data.available_quantity);
             $('#totalqty' + id).html(data.available_quantity);
             $('#available_quantity' + id).val(data.available_quantity);
             $('#purchase_price' + id).val(data.sale_rate);
             }
             });
             }
             }*/

            function multiply(id) {

                var quantity = $('#quantity' + id).val();
                var availquantity = $('#available_quantity' + id).val();
                if (parseInt(quantity) > parseInt(availquantity)) {
                    errorMsg('Order quantity should not be greater than available quantity');
                } else {
                    //alert(parseInt(quantity));
                }
                var purchase_price = $('#purchase_price' + id).val();
                var amount = quantity * purchase_price;
                $('#amount' + id).val(amount);
            }

            function getExpire(id) {
                var batch_no = $("#batch_no" + id).val();
                $.ajax({
                    type: "POST",
                    url: base_url + "admin/pharmacy/getExpiryDate",
                    data: {'batch_no': batch_no},
                    dataType: 'json',
                    success: function (res) {
                        if (res != null) {
                            $('#expiry_date' + id).val(res.expiry_date);
                            getQuantity(id);
                        }
                    }
                });
            }

            function getbatchnolist(id, rowid) {

                // var batch_no = $("#batch_no"+id).val();
                //$('#medicine_name'+rowid).select2("val", '');
                var div_data = "";
                //$('#quantity').html(data.available_quantity);
                $('#totalqty' + rowid).html("<span class='input-group-addon text-danger' style='font-size:10pt'  id='totalqty" + rowid + "'></span>");
                $('#available_quantity' + rowid).val('');
                $('#purchase_price' + rowid).val('');
                $('#expiry_date' + rowid).val('');
                $('#amount' + rowid).val('');
                $('#quantity' + rowid).val('');
                //      $("#batch_no" + rowid).html("<option value=''>Select</option>");
                $("#batch_no" + rowid).html("<option value='l'><?php echo $this->lang->line('loading') ?></option>");
                //  $('#batch_no' + rowid).select2("val", 'l');
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
                            div_data += "<option value='" + obj.batch_no + "'>" + obj.batch_no + "</option>";
                        });
                        $("#batch_no" + rowid).html("<option value=''>Select</option>");
//       $('#batch_no' + rowid).select2("val", 'l');

                        $('#batch_no' + rowid).append(div_data);
                    }
                });
            }

            function get_PatientDetails(id) {
                $("#patient_name").html("patient_name");
                //$("#schedule_charge").html("schedule_charge");

                $.ajax({
                    url: '<?php echo base_url(); ?>admin/pharmacy/patientDetails',
                    type: "POST",
                    data: {id: id},
                    dataType: 'json',
                    success: function (res) {
                        console.log(res);
                        if (res) {
                            $('#patient_name').val(res.patient_name);
                            $('#pharma_patientid').val(res.id);
                        } else {
                            $('#patient_name').val('Null');

                        }
                    }
                });
            }
</script>