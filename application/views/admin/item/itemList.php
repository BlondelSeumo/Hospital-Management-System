<?php $currency_symbol = $this->customlib->getSchoolCurrencyFormat(); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <?php if ($this->rbac->hasPrivilege('item', 'can_add')) { ?> 

                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header ptbnull">
                            <h3 class="box-title titlefix"> <?php echo $this->lang->line('item_list'); ?></h3>
                            <div class="box-tools pull-right">
                                <a href="<?php //echo site_url('admin/issueitem/create')     ?>" data-toggle="modal" data-target="#myModal" class="btn btn-primary btn-sm" ><i class="fa fa-plus"></i> <?php echo $this->lang->line('add_item'); ?></a>


                            </div><!-- /.box-tools -->
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive mailbox-messages">
                                <div class="download_label"><?php echo $this->lang->line('item_list'); ?></div>
                                <table class="table table-hover table-striped table-bordered example">
                                    <thead>
                                        <tr>
                                            <th><?php echo $this->lang->line('item'); ?></th>                                 
                                            <th><?php echo $this->lang->line('category'); ?>
                                            </th>
                                            <th><?php echo $this->lang->line('unit'); ?>
                                            </th>
                                            <th><?php echo $this->lang->line('available_quantity'); ?>
                                            </th>
                                            <th class="text-right"><?php echo $this->lang->line('action'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (empty($itemlist)) {
                                            ?>

                                            <?php
                                        } else {
                                            foreach ($itemlist as $items) {
                                                ?>
                                                <tr>
                                                    <td class="mailbox-name">
                                                        <a href="#" data-toggle="popover" class="detail_popover"><?php echo $items['name'] ?></a>

                                                        <div class="fee_detail_popover" style="display: none">
                                                            <?php
                                                            if ($items['description'] == "") {
                                                                ?>
                                                                <p class="text text-danger"><?php echo $this->lang->line('no_description'); ?></p>
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <p class="text text-info"><?php echo $items['description']; ?></p>
                                                                <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </td>


                                                    <td class="mailbox-name">
                                                        <?php echo $items['item_category']; ?>

                                                    </td>
                                                    <td class="mailbox-name">
                                                        <?php echo $items['unit']; ?>

                                                    </td>
                                                    <td class="mailbox-name">
                                                        <?php
                                                        echo $items['added_stock'] - $items['issued'];
                                                        ;
                                                        ?>

                                                    </td>
                                                    <td class="mailbox-date pull-right">
                                                        <?php if ($this->rbac->hasPrivilege('item', 'can_edit')) { ?> 
                                                            <a  class="btn btn-default btn-xs" data-target="#editmyModal"  data-toggle="tooltip" onclick="get_data(<?php echo $items['id']; ?>);" title="<?php echo $this->lang->line('edit'); ?>">
                                                                <i class="fa fa-pencil"></i>
                                                            </a>
                                                        <?php }if ($this->rbac->hasPrivilege('item', 'can_delete')) { ?>  
                                                            <a  class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('delete'); ?>" onclick="delete_recordById('<?php echo base_url(); ?>admin/item/delete/<?php echo $items['id'] ?>', '<?php echo $this->lang->line('delete_message') ?>')">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>

                                    </tbody>
                                </table><!-- /.table -->



                            </div><!-- /.mail-box-messages -->
                        </div><!-- /.box-body -->
                    </div>
                </div><!--/.col (left) -->
                <!-- right column -->
                <?php
            }
            ?>
        </div>
        <div class="row">
            <!-- left column -->

            <!-- right column -->
            <div class="col-md-12">

            </div><!--/.col (right) -->
        </div>   <!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<div class="modal fade"  id="myModal" tabindex="-1" role="dialog" aria-labelledby="follow_up">
    <div class="modal-dialog modal-mid" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close"  data-dismiss="modal">&times;</button>
                <h4 class="box-title"><?php echo $this->lang->line('add_item') ?></h4>
            </div>

            <div class="modal-body pt0 pb0" >
                <div class="row ptt10">


                    <form id="form1" action="<?php echo base_url() ?>admin/item/add"  id="itemstockform" name="itemstockform" method="post" accept-charset="utf-8" enctype="multipart/form-data">


                        <?php echo $this->customlib->getCSRF(); ?>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo $this->lang->line('item'); ?></label><small class="req"> *</small>
                                <input autofocus="" id="name" name="name" placeholder="" type="text" class="form-control"  value="<?php echo set_value('name'); ?>" />
                                <span class="text-danger"><?php echo form_error('name'); ?></span>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo $this->lang->line('item_category'); ?></label><small class="req"> *</small>

                                <select  id="item_category_id" name="item_category_id" class="form-control" >
                                    <option value=""><?php echo $this->lang->line('select'); ?></option>
                                    <?php
                                    foreach ($itemcatlist as $item_category) {
                                        ?>
                                        <option value="<?php echo $item_category['id'] ?>"<?php
                                        if (set_value('item_category_id') == $item_category['id']) {
                                            echo "selected = selected";
                                        }
                                        ?>><?php echo $item_category['item_category'] ?></option>

                                        <?php
                                        $count++;
                                    }
                                    ?>
                                </select>
                                <span class="text-danger"><?php echo form_error('item_category_id'); ?></span>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo $this->lang->line('unit'); ?></label><small class="req"> *</small>
                                <input autofocus="" id="unit" name="unit" placeholder="" type="text" class="form-control"  value="<?php echo set_value('name'); ?>" />
                                <span class="text-danger"><?php echo form_error('unit'); ?></span>
                            </div>
                        </div>

                        <!---  <div class="col-md-12">
                          <div class="form-group">
                          <label for="exampleInputEmail1"><?php echo $this->lang->line('purchase') . " " . $this->lang->line('price'); ?></label><small class="req"> *</small>
                          <input autofocus="" id="purchase_price" name="purchase_price" placeholder="" type="text" class="form-control"  value="<?php echo set_value('purchase_price'); ?>" />
                         
                          </div>
                          </div>-->

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo $this->lang->line('description'); ?></label>
                                <textarea class="form-control" id="description" name="description" placeholder="" rows="3" placeholder=""><?php echo set_value('description'); ?></textarea>
                                <span class="text-danger"></span>
                            </div>
                        </div>
                </div>
            </div>
            <div class="box-footer clear">
                <div class="pull-right">
                    <button type="submit"  class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade"  id="editmyModal" tabindex="-1" role="dialog" aria-labelledby="follow_up">
    <div class="modal-dialog modal-mid" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close"  data-dismiss="modal">&times;</button>
                <h4 class="box-title"><?php echo $this->lang->line('edit_item'); ?></h4>
            </div>

            <div class="modal-body pt0 pb0" >
                <div class="row ptt10">

                    <form id="eform1" action="<?php echo base_url() ?>admin/item/edit"  id="itemstockform" name="itemstockform" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                        <?php echo $this->customlib->getCSRF(); ?>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo $this->lang->line('item'); ?></label><small class="req"> *</small>
                                <input autofocus="" id="ename" name="name" placeholder="" type="text" class="form-control"  value="<?php echo set_value('name'); ?>" />
                                <span class="text-danger"><?php echo form_error('name'); ?></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo $this->lang->line('item_category'); ?></label><small class="req"> *</small>

                                <select  id="eitem_category_id" name="item_category_id" class="form-control" >
                                    <option value=""><?php echo $this->lang->line('select'); ?></option>
                                    <?php
                                    foreach ($itemcatlist as $item_category) {
                                        ?>
                                        <option value="<?php echo $item_category['id'] ?>"<?php
                                        if (set_value('item_category_id') == $item_category['id']) {
                                            echo "selected = selected";
                                        }
                                        ?>><?php echo $item_category['item_category'] ?></option>

                                        <?php
                                        $count++;
                                    }
                                    ?>
                                </select>
                                <span class="text-danger"><?php echo form_error('item_category_id'); ?></span>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo $this->lang->line('unit'); ?></label><small class="req"> *</small>
                                <input autofocus="" id="eunit" name="unit" placeholder="" type="text" class="form-control"  value="<?php echo set_value('unit'); ?>" />
                                <span class="text-danger"><?php echo form_error('unit'); ?></span>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo $this->lang->line('description'); ?></label>
                                <textarea class="form-control" id="edescription" name="description" placeholder="" rows="3" placeholder="Enter ..."><?php echo set_value('description'); ?></textarea>
                                <span class="text-danger"></span>
                                <input type="hidden" name="id" id="e_id" >
                            </div>
                        </div>
                </div>
            </div>
            <div class="box-footer clear">
                <div class="pull-right">
                    <button type="submit"  class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        var date_format = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(), ['d' => 'dd', 'm' => 'mm', 'Y' => 'yyyy',]) ?>';

        $('#date').datepicker({
            //  format: "dd-mm-yyyy",
            format: date_format,
            autoclose: true
        });

        $("#btnreset").click(function () {
            $("#form1")[0].reset();
        });

    });
</script>
<script>
    $(document).ready(function () {
        $('.detail_popover').popover({
            placement: 'right',
            trigger: 'hover',
            container: 'body',
            html: true,
            content: function () {
                return $(this).closest('td').find('.fee_detail_popover').html();
            }
        });
    });

    $(document).ready(function (e) {

        $('#form1').on('submit', (function (e) {

            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
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
                    //  alert("Fail")
                }
            });


        }));

    });

    function get_data(id) {

        //alert(id);
        $.ajax({

            url: "<?php echo base_url() ?>admin/item/get_data/" + id,
            type: "POST",
            dataType: 'json',

            success: function (res) {
                console.log(res);
                $('#ename').val(res.name);
                $('#eunit').val(res.unit);
                $('#epurchase_price').val(res.purchase_price);
                $('#e_id').val(res.id);
                $('#eitem_category_id').val(res.item_category_id);
                $('#edescription').val(res.description);
                $('#editmyModal').modal('show');
            }

        });



    }


    $(document).ready(function (e) {

        $('#eform1').on('submit', (function (e) {

            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
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
                    //  alert("Fail")
                }
            });


        }));

    });

</script>

