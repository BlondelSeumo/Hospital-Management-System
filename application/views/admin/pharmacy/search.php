<style type="text/css">
    #easySelectable {/*display: flex; flex-wrap: wrap;*/}
    #easySelectable li {}
    #easySelectable li.es-selected {background: #2196F3; color: #fff;}
    .easySelectable {-webkit-user-select:none; -moz-user-select:none; -ms-user-select: none;}
</style>
<?php
$currency_symbol = $this->customlib->getSchoolCurrencyFormat();
?>
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title titlefix"><?php echo $this->lang->line('medicines') . " " . $this->lang->line('stock'); ?></h3>
                        <div class="box-tools pull-right">

                            <?php if ($this->rbac->hasPrivilege('import_medicine', 'can_view')) { ?>                
                                <a data-toggle="modal" href="<?php echo base_url(); ?>admin/pharmacy/import"  class="btn btn-primary btn-sm"><i class="fa fa-upload"></i> <?php echo $this->lang->line('import_medicine'); ?>
                                </a>
                            <?php } ?>

                            <?php if ($this->rbac->hasPrivilege('medicine', 'can_add')) { ?>
                                <a data-toggle="modal" onclick="holdModal('myModal')" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> <?php echo $this->lang->line('add') . " " . $this->lang->line('medicine'); ?></a> 
                            <?php } ?>

                            <?php if ($this->rbac->hasPrivilege('medicine_purchase', 'can_view')) { ?>
                                <a href="<?php echo base_url(); ?>admin/pharmacy/purchase" class="btn btn-primary btn-sm"><i class="fa fa-reorder"></i> <?php echo $this->lang->line('purchase'); ?></a>
                            <?php } ?>
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="download_label"><?php echo $this->lang->line('medicines') . " " . $this->lang->line('stock'); ?></div>
                        <table class="table table-striped table-bordered table-hover test_ajax" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th><?php echo $this->lang->line('medicine') . " " . $this->lang->line('name'); ?></th>
                                    <th><?php echo $this->lang->line('medicine') . " " . $this->lang->line('company'); ?></th>
                                    <th><?php echo $this->lang->line('medicine') . " " . $this->lang->line('composition'); ?></th>
                                    <th><?php echo $this->lang->line('medicine') . " " . $this->lang->line('category'); ?></th>                 

                                    <th><?php echo $this->lang->line('medicine') . " " . $this->lang->line('group'); ?></th>
                                    <th><?php echo $this->lang->line('unit'); ?></th>
                                    <th ><?php echo $this->lang->line('available') . " " . $this->lang->line('qty'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                             
                            </tbody>
                        </table>
                    </div>
                </div>                                                    
            </div>                                                                                                                                          
        </div>  
    </section>
</div>

<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close pt4" data-toggle="tooltip" title="<?php echo $this->lang->line('close'); ?>" data-dismiss="modal">&times;</button>
                <h4 class="box-title"><?php echo $this->lang->line('add') . " " . $this->lang->line('medicine') . " " . $this->lang->line('details'); ?></h4> 
            </div>
            <form id="formadd" accept-charset="utf-8"  method="post" class="ptt10" enctype="multipart/form-data" > 
                <div class="modal-body pt0 pb0">

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 paddlr">

                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('medicine') . " " . $this->lang->line('name'); ?></label>
                                        <small class="req"> *</small> 
                                        <input id="medicine_name" name="medicine_name" placeholder="" type="text" class="form-control"/>
                                        <span class="text-danger"><?php echo form_error('medicine_name'); ?></span>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="exampleInputFile">
                                            <?php echo $this->lang->line('medicine') . " " . $this->lang->line('category'); ?></label>
                                        <small class="req"> *</small> 
                                        <div>
                                            <select class="form-control select2" style="width:100%" name='medicine_category_id' >
                                                <option value="<?php echo set_value('medicine_category_id'); ?>"><?php echo $this->lang->line('select') ?>
                                                </option>
                                                <?php foreach ($medicineCategory as $dkey => $dvalue) {
                                                    ?>
                                                    <option value="<?php echo $dvalue["id"]; ?>"><?php echo $dvalue["medicine_category"] ?>
                                                    </option>   
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('medicine_category_id'); ?></span>
                                    </div>
                                </div>  
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('medicine') . " " . $this->lang->line('company'); ?></label>
                                        <small class="req"> *</small> 
                                        <input type="text" name="medicine_company" value="" class="form-control">
                                        <span class="text-danger"><?php echo form_error('medicine_company'); ?></span>
                                    </div>
                                </div> 
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('medicine') . " " . $this->lang->line('composition'); ?></label>
                                        <small class="req"> *</small> 
                                        <input type="text" name="medicine_composition" value="" class="form-control">
                                        <span class="text-danger"><?php echo form_error('medicine_composition'); ?></span>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('medicine') . " " . $this->lang->line('group'); ?></label>
                                        <small class="req"> *</small> 
                                        <input type="text" name="medicine_group" value="" class="form-control">
                                        <span class="text-danger"><?php echo form_error('medicine_group'); ?></span>
                                    </div>
                                </div>
                                <!-- <div class="col-sm-3">
                                     <div class="form-group">
                                         <label><?php echo $this->lang->line('supplier'); ?></label>
                                         <input type="text" name="supplier" class="form-control">
                                     </div>
                                 </div>-->
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('unit'); ?></label>
                                        <small class="req"> *</small> 
                                        <input type="text" name="unit" class="form-control">
                                        <span class="text-danger"><?php echo form_error('unit'); ?></span>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('min_level'); ?></label>
                                        <input type="text" name="min_level" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('re_order_level'); ?></label>
                                        <input type="text" name="reorder_level" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('vat') . " (%)" ?></label>
                                        <input type="text" name="vat" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('unit') . "/" . $this->lang->line('packing'); ?></label>
                                        <small class="req"> *</small> 
                                        <input type="text" name="unit_packing" class="form-control">
                                        <span class="text-danger"><?php echo form_error('unit_packing'); ?>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('vat') . " " . $this->lang->line('a/c'); ?></label>
                                        <input type="text" name="vat_ac" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('note'); ?></label>
                                        <textarea name="note" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('medicine') . " " . $this->lang->line('photo') . " ( " . $this->lang->line('jpg_jpeg_png') . " )"; ?></label>
                                        <input type="file" name="file" id="file" class="form-control filestyle" />
                                    </div>
                                </div>
                            </div><!--./row-->   

                        </div><!--./col-md-12-->       
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


<div class="modal fade" id="myModalImport" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-toggle="tooltip" title="<?php echo $this->lang->line('close'); ?>" data-dismiss="modal">&times;</button>
                <h4 class="box-title"><?php echo $this->lang->line('add') . " " . $this->lang->line('medicine'); ?></h4> 
            </div>
            <div class="modal-body pt0 pb0">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 paddlr">
                        <form id="formimp" accept-charset="utf-8"  method="post" class="ptt10" enctype="multipart/form-data" >
                            <div class="row">

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="exampleInputFile">
                                            <?php echo $this->lang->line('medicine') . " " . $this->lang->line('category'); ?></label>
                                        <small class="req"> *</small> 
                                        <div>
                                            <select class="form-control select2" style="width:100%" name='medicine_category_id' >
                                                <option value="<?php echo set_value('medicine_category_id'); ?>"><?php echo $this->lang->line('select') ?>
                                                </option>
                                                <?php foreach ($medicineCategory as $dkey => $dvalue) {
                                                    ?>
                                                    <option value="<?php echo $dvalue["id"]; ?>"><?php echo $dvalue["medicine_category"] ?>
                                                    </option>   
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('medicine_category_id'); ?></span>
                                    </div>
                                </div>  

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('medicine'); ?>    CSV File Upload</label>
                                        <input type="file" name="medicine_image" class="form-control filestyle" />
                                    </div>
                                </div>
                            </div><!--./row-->   

                    </div><!--./col-md-12-->       
                </div><!--./row--> 
            </div>
            <div class="box-footer">
                <div class="pull-right">
                    <button type="submit" id="formimpbtn" data-loading-text="<?php echo $this->lang->line('processing') ?>" class="btn btn-info pull-right">Import <?php echo $this->lang->line('medicine'); ?></button>
                    </form> 
                </div>
            </div>

        </div>
    </div>    
</div>
<!-- dd -->
<div class="modal fade" id="myModaledit" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" data-toggle="tooltip" title="<?php echo $this->lang->line('close'); ?>" class="close" data-dismiss="modal">&times;</button>
                <h4 class="box-title"><?php echo $this->lang->line('edit') . " " . $this->lang->line('medicine') . " " . $this->lang->line('information'); ?></h4> 
            </div>
            <div class="modal-body pt0 pb0">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 paddlr">
                        <form id="formedit" accept-charset="utf-8" enctype="multipart/form-data"  method="post" class="ptt10" >
                            <div class="row">
                                <input type="hidden" name="id" id="id" value="<?php echo set_value('id'); ?>">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('medicine') . " " . $this->lang->line('name'); ?></label>
                                        <small class="req"> *</small> 
                                        <input type="text" id="medicines_name" name="medicine_name" value="<?php echo set_value('medicine_name'); ?>" class="form-control">
                                        <span class="text-danger"><?php echo form_error('medicine_name'); ?></span>
                                    </div>
                                </div> 
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="exampleInputFile">
                                            <?php echo $this->lang->line('medicine') . " " . $this->lang->line('category'); ?></label>
                                        <small class="req"> *</small> 
                                        <div><select class="form-control select2" style="width:100%" name='medicine_category_id' id="medicines_category_id" >
                                                <option value="<?php echo set_value('medicine_category_id'); ?>"><?php echo $this->lang->line('select') ?></option>
                                                <?php foreach ($medicineCategory as $dkey => $dvalue) {
                                                    ?>
                                                    <option value="<?php echo $dvalue["id"]; ?>"><?php echo $dvalue["medicine_category"] ?></option>   
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('medicine_category_id'); ?></span>
                                    </div>
                                </div>  
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('medicine') . " " . $this->lang->line('company'); ?></label>
                                        <small class="req"> *</small> 
                                        <input type="text" id="medicine_company" name="medicine_company" value="<?php echo set_value('medicine_company'); ?>" class="form-control">
                                        <span class="text-danger"><?php echo form_error('medicine_company'); ?></span>
                                    </div>
                                </div> 
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('medicine') . " " . $this->lang->line('composition'); ?></label>
                                        <small class="req"> *</small> 
                                        <input type="text" id="medicine_composition" name="medicine_composition" value="<?php echo set_value('medicine_composition'); ?>" class="form-control">
                                        <span class="text-danger"><?php echo form_error('medicine_composition'); ?></span>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('medicine') . " " . $this->lang->line('group'); ?></label>
                                        <small class="req"> *</small> 
                                        <input type="text" id="medicine_group" name="medicine_group" value="<?php echo set_value('medicine_group'); ?>" class="form-control">
                                        <span class="text-danger"><?php echo form_error('medicine_group'); ?></span>
                                    </div>
                                </div>
                                <!-- <div class="col-sm-3">
                                     <div class="form-group">
                                         <label><?php echo $this->lang->line('supplier'); ?></label>
                                         <input type="text" id="supplier" name="supplier" value="<?php echo set_value('supplier'); ?>" class="form-control">
                                     </div>
                                 </div>-->
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('unit'); ?></label>
                                        <small class="req"> *</small> 
                                        <input type="text" name="unit" id="unit" value="<?php echo set_value('unit'); ?>" class="form-control">
                                        <span class="text-danger"><?php echo form_error('unit'); ?></span>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('min_level'); ?></label>
                                        <input type="text" name="min_level" id="min_level" value="<?php echo set_value('min_level'); ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('re_order_level'); ?></label>
                                        <input type="text" name="reorder_level" id="reorder_level"  value="<?php echo set_value('reorder_level'); ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('vat') . " (%)" ?></label>
                                        <input type="text" id="vat" name="vat" value="<?php echo set_value('vat'); ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('unit') . "/" . $this->lang->line('packing'); ?></label>
                                        <small class="req"> *</small> 
                                        <input type="text" id="unit_packing"  name="unit_packing" class="form-control" value="<?php echo set_value('unit_packing'); ?>">
                                        <span class="text-danger"><?php echo form_error('unit_packing'); ?>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('vat') . " " . $this->lang->line('a/c'); ?></label>
                                        <input type="text" id="vat_ac" name="vat_ac" value="<?php echo set_value('vat_ac'); ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('note'); ?></label>
                                        <textarea type="text" id="edit_note" name="edit_note"  class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('medicine') . " " . $this->lang->line('photo'); ?></label>
                                        <input type="file"  name="medicine_image"  class="form-control filestyle" />
                                        <span class="text-danger"><?php echo form_error('image'); ?>
                                            <input type="hidden"  name="pre_medicine_image" id="pre_medicine_image"  class="form-control" />
                                    </div>
                                </div>
                            </div><!--./row-->   

                    </div><!--./col-md-12-->       
                </div><!--./row--> 
            </div>
            <div class="box-footer">
                <div class="pull-right">
                    <button type="submit" id="formeditbtn" data-loading-text="<?php echo $this->lang->line('processing') ?>" class="btn btn-info pull-right" ><?php echo $this->lang->line('save'); ?></button>
                    </form> 
                </div>
            </div>
        </div>
    </div>    
</div>
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog pup100" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-toggle="tooltip" title="Close" data-dismiss="modal">&times;</button>

                <div class="modalicon"> 
                    <div id='edit_delete' class="">
                        <a href="#"  onclick="holdModal('editModal')" data-toggle="modal" title="" data-original-title="<?php echo $this->lang->line('edit'); ?>"><i class="fa fa-pencil"></i></a>

                        <a href="#" data-toggle="tooltip" title="" data-original-title="<?php echo $this->lang->line('delete') ?>"><i class="fa fa-trash"></i></a>
                    </div>
                </div>
                <h4 class="box-title"><?php echo $this->lang->line('medicine') . " " . $this->lang->line('information'); ?></h4> 
            </div>
            <div class="modal-body pt0 pb0">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 paddlr">
                        <form id="view" accept-charset="utf-8" method="get" class="ptt10">
                            <div class="col-lg-1 col-md-2 col-sm-4">
                                <img id="medicine_image" src="#" style="width:100px;height: 100px;" />
                            </div>    
                            <div class="col-lg-11 col-md-10 col-sm-8 table-responsive">
                                <table class="table mb0 table-striped table-bordered examples">
                                    <tr>
                                        <th></th>
                                        <td></td>
                                        <th width="15%"><?php echo $this->lang->line('medicine') . " " . $this->lang->line('name'); ?></th>
                                        <td width="35%"><span id='medicine_names'></span></td>
                                        <th width="15%"><?php echo $this->lang->line('medicine') . " " . $this->lang->line('category'); ?></th>
                                        <td width="35%"><span id="medicine_category_ids"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <td></td>
                                        <th width="15%"><?php echo $this->lang->line('medicine') . " " . $this->lang->line('company'); ?></th>
                                        <td width="35%"><span id='medicine_companys'></span></td>
                                        <th width="15%"><?php echo $this->lang->line('medicine') . " " . $this->lang->line('composition'); ?></th>
                                        <td width="35%"><span id="medicine_compositions"></span>
                                        </td>

                                    </tr>
                                    <tr>
                                        <th></th>
                                        <td></td>
                                        <th width="15%"><?php echo $this->lang->line('medicine') . " " . $this->lang->line('group'); ?></th>
                                        <td width="35%"><span id='medicine_groups'></span></td>
                                        <th width="15%"><?php echo $this->lang->line('unit'); ?></th>
                                        <td width="35%"><span id="units"></span>
                                        </td>

                                    </tr>
                                    <tr>
                                        <th></th>
                                        <td></td>
                                        <th width="15%"><?php echo $this->lang->line('min_level'); ?></th>
                                        <td width="35%"><span id='min_levels'></span></td>
                                        <th width="15%"><?php echo $this->lang->line('re_order_level'); ?></th>
                                        <td width="35%"><span id="reorder_levels"></span>
                                        </td>

                                    </tr>
                                    <tr>                                  <th></th>
                                        <td></td>
                                        <th width="15%"><?php echo $this->lang->line('vat') . " (%)" ?></th>
                                        <td width="35%"><span id='vats'></span></td>
                                        <th width="15%"><?php echo $this->lang->line('unit') . "/" . $this->lang->line('packing'); ?></th>
                                        <td width="35%"><span id="unit_packings"></span>
                                        </td>

                                    </tr>
                                    <tr>
                                        <th></th>
                                        <td></td>

                                        <th width="15%"><?php echo $this->lang->line('vat') . " " . $this->lang->line('a/c'); ?></th>
                                        <td width="35%"><span id="vat_acs"></span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </form>            
                    </div><!--./col-md-12-->       
                </div><!--./row-->
                <div id="tabledata"></div> 
            </div>
            <div class="box-footer">
                <div class="pull-right paddA10">
                  <!--  <a  onclick="saveEnquiry()" class="btn btn-info pull-right"><?php //echo $this->lang->line('save');     ?></a> -->
                </div>
            </div>
        </div>
    </div>    
</div>
<div class="modal fade" id="addBulkModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="box-title"><?php echo $this->lang->line('add') . " " . $this->lang->line('stock') ?></h4> 
            </div>
            <div class="modal-body pt0 pb0">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 paddlr">
                        <form id="formbatch" accept-charset="utf-8"  method="post" class="ptt10" >
                            <input type="hidden" name="pharmacy_id" id="pharm_id" >
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('batch') . " " . $this->lang->line('no'); ?></label>
                                        <small class="req"> *</small> 
                                        <input type="text" name="batch_no" class="form-control">
                                        <span class="text-danger"><?php echo form_error('batch_no'); ?></span>
                                    </div>
                                </div> 
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('expire') . " " . $this->lang->line('date'); ?></label>
                                        <small class="req"> *</small> 
                                        <input type="text" id="expiry" name="expiry_date" class="form-control">
                                        <span class="text-danger"><?php echo form_error('expiry_date'); ?></span>
                                    </div>
                                </div> 
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('inward') . " " . $this->lang->line('date'); ?></label>
                                        <small class="req"> *</small> 
                                        <input type="text" id="inward_date" name="inward_date" class="form-control date">
                                        <span class="text-danger"><?php echo form_error('inward_date'); ?></span>
                                    </div>
                                </div> 

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('packing') . " " . $this->lang->line('qty'); ?></label>
                                        <small class="req"> *</small> 
                                        <input type="text" name="packing_qty" class="form-control">
                                        <span class="text-danger"><?php echo form_error('packing_qty'); ?></span>
                                    </div>
                                </div> 
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('purchase_rate') . " (" . $currency_symbol . ")"; ?></label>

                                        <input type="text" name="purchase_rate_packing" class="form-control">
                                        <span class="text-danger"><?php echo form_error('purchase_rate_packing'); ?></span>
                                    </div>
                                </div> 
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('quantity'); ?></label>
                                        <small class="req"> *</small> 
                                        <input type="text" name="quantity" class="form-control">
                                        <span class="text-danger"><?php echo form_error('quantity'); ?></span>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('mrp') . " (" . $currency_symbol . ")"; ?></label>
                                        <small class="req"> *</small> 
                                        <input type="text" name="mrp" class="form-control">
                                        <span class="text-danger"><?php echo form_error('mrp'); ?></span>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('sale_price') . " (" . $currency_symbol . ")"; ?></label>
                                        <small class="req"> *</small> 
                                        <input  name="sale_rate" type="text" class="form-control"/>
                                        <span class="text-danger"><?php echo form_error('sale_rate'); ?></span>
                                    </div>
                                </div> 
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('batch') . " " . $this->lang->line('amount') . " (" . $currency_symbol . ")"; ?></label>

                                        <input type="text" name="amount" class="form-control">
                                        <span class="text-danger"><?php echo form_error('amount'); ?></span>
                                    </div>
                                </div> 
                            </div><!--./row-->   

                    </div><!--./col-md-12-->       

                </div><!--./row--> 

            </div>
            <div class="box-footer">
                <div class="pull-right">
                    <button type="submit" id="formbatchbtn" data-loading-text="<?php echo $this->lang->line("processing") ?>" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>

                </div>

            </div>
            </form>
        </div>
    </div>    
</div>

<div class="modal fade" id="addBadStockModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="box-title"><?php echo $this->lang->line('add') . " " . $this->lang->line('bad') . " " . $this->lang->line('stock'); ?></h4> 
            </div>
            <div class="modal-body pt0 pb0">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 paddlr">
                        <form id="formstock"  accept-charset="utf-8"  method="post" class="ptt10" >
                            <input type="hidden" name="pharmacy_id" id="pharm_id" >
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('batch') . " " . $this->lang->line('no'); ?></label>
                                        <small class="req"> *</small> 
                                        <select name="batch_no" onchange="getExpire(this.value)" id="batch_stock_no" class="form-control">
                                            <option value=""><?php echo $this->lang->line('select') ?></option>
                                        </select>
                                        <span class="text-danger"><?php echo form_error('batch_no'); ?></span>
                                    </div>
                                </div> 
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('expire') . " " . $this->lang->line('date'); ?></label>
                                        <small class="req"> *</small> 
                                        <input type="text" id="batch_expire"  name="expiry_date" id="stockexpiry_date" class="form-control">
                                        <span class="text-danger"><?php echo form_error('expiry_date'); ?></span>
                                    </div>
                                </div> 
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('outward') . " " . $this->lang->line('date'); ?></label>
                                        <small class="req"> *</small> 
                                        <input type="text"  name="inward_date" value="<?php echo date($this->customlib->getSchoolDateFormat()) ?>" class="form-control date">
                                        <span class="text-danger"><?php echo form_error('inward_date'); ?></span>
                                    </div>
                                </div> 
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('qty'); ?></label>
                                        <small class="req"> *</small> 
                                        <input type="text" name="packing_qty" class="form-control">
                                        <input type="hidden" name="pharmacy_id" id="pharmacy_stock_id" class="form-control">
                                        <input type="hidden" name="available_quantity" id="batch_available_qty" class="form-control">
                                        <input type="hidden" name="medicine_batch_id" id="medicine_batch_id" class="form-control">
                                        <span class="text-danger"><?php echo form_error('packing_qty'); ?></span>
                                    </div>
                                </div> 
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('note'); ?></label>
                                        <textarea  name="note" class="form-control "></textarea>
                                    </div>
                                </div> 

                            </div><!--./row-->   

                    </div><!--./col-md-12-->       

                </div><!--./row--> 

            </div>
            <div class="box-footer">
                <div class="pull-right">
                    <button type="submit" id="formstockbtn" data-loading-text="<?php echo $this->lang->line('processing') ?>" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                    </form>  
                </div>
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

            /*	$(document).ready(function (e) {
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
             });*/

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
                       // console.log(vat);
                        $("#unit_packing").val(data.unit_packing);
                        //$("#supplier").val(data.supplier);
                        $("#pre_medicine_image").val(data.pre_medicine_image);
                        $("#vat_ac").val(data.vat_ac);
                        $("#edit_note").val(data.note);
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


<script type="text/javascript">
    $(document).ready(function() {
    $('.test_ajax').DataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": base_url+"admin/pharmacy/dt_search",
            "type": "POST"
        }
    });
});
</script>