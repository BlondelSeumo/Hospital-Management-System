
<div class="content-wrapper" style="min-height: 946px;">
    <!-- Content Header (Page header) -->

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-2">
                <div class="box border0">
                    <ul class="tablists">
                        <li><a href="<?php echo base_url(); ?>admin/itemcategory" ><?php echo $this->lang->line('item_category'); ?></a></li>
                        <li><a href="<?php echo base_url(); ?>admin/itemstore"><?php echo $this->lang->line('item_store'); ?></a></li>
                        <li><a href="<?php echo base_url(); ?>admin/itemsupplier" class="active"><?php echo $this->lang->line('item_supplier'); ?></a></li>

                    </ul>
                </div>
            </div>

            <div class="col-md-10">
                <!-- general form elements -->
                <div class="box box-primary" id="exphead">
                    <div class="box-header ptbnull">
                        <h3 class="box-title titlefix"><?php echo $this->lang->line('item_supplier_list'); ?></h3>
                        <div class="box-tools pull-right">
                            <a data-toggle="modal" data-target="#myModal" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>  <?php echo $this->lang->line('add'); ?> <?php echo $this->lang->line('item_supplier'); ?></a>     
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body  ">
                        <div class="table-responsive mailbox-messages">
                            <div class="download_label"><?php echo $this->lang->line('item_supplier_list'); ?></div>
                            <table class="table table-striped table-bordered table-hover example">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('item_supplier'); ?></th>
                                        <th><?php echo $this->lang->line('contact_person'); ?></th>
                                        <th><?php echo $this->lang->line('address'); ?></th>
                                        <th class="text-right no-print"><?php echo $this->lang->line('action'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($itemsupplierlist)) {
                                        ?>

                                        <?php
                                    } else {
                                        $count = 1;
                                        foreach ($itemsupplierlist as $supplier) {
                                            ?>
                                            <tr>   


                                                <td class="mailbox-name">

                                                    <a href="#" data-toggle="popover" class="detail_popover" >
                                                        <?php echo $supplier['item_supplier'] ?>
                                                        <br>
                                                    </a>
                                                    <?php
                                                    if ($supplier['phone'] != "") {
                                                        ?>
                                                        <i class="fa fa-phone-square"></i> <?php echo $supplier['phone'] ?>
                                                        <br>
                                                        <?php
                                                    }
                                                    ?>
                                                    <?php
                                                    if ($supplier['email'] != "") {
                                                        ?>
                                                        <i class="fa fa-envelope"></i> <?php echo $supplier['email'] ?>

                                                        <?php
                                                    }
                                                    ?>

                                                    <div class="fee_detail_popover" style="display: none">
                                                        <?php
                                                        if ($supplier['description'] == "") {
                                                            ?>
                                                            <p class="text text-danger"><?php echo $this->lang->line('no_description'); ?></p>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <p class="text text-info"><?php echo $supplier['description']; ?></p>
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </td>
                                                <td class="mailbox-name">
                                                    <?php
                                                    if ($supplier['contact_person_name'] != "") {
                                                        ?>
                                                        <i class="fa fa-user"></i> <?php echo $supplier['contact_person_name'] ?>
                                                        <br>
                                                        <?php
                                                    }
                                                    ?>
                                                    <?php
                                                    if ($supplier['contact_person_phone'] != "") {
                                                        ?>
                                                        <i class="fa fa-phone-square"></i> <?php echo $supplier['contact_person_phone'] ?>
                                                        <br>
                                                        <?php
                                                    }
                                                    ?>
                                                    <?php
                                                    if ($supplier['contact_person_email'] != "") {
                                                        ?>
                                                        <i class="fa fa-envelope"></i> <?php echo $supplier['contact_person_email'] ?>
                                                        <?php
                                                    }
                                                    ?>
                                                </td>
                                                <td class="mailbox-name">
                                                    <?php
                                                    if ($supplier['address'] != "") {
                                                        ?>
                                                        <i class="fa fa-building"></i> <?php echo $supplier['address'] ?>
                                                        <?php
                                                    }
                                                    ?>

                                                </td>
                                                <td class="mailbox-date pull-right no-print">
                                                    <?php if ($this->rbac->hasPrivilege('supplier', 'can_edit')) { ?>
                                                        <a onclick="get(<?php echo $supplier['id']; ?>)" data-target="#editmyModal" class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('edit'); ?>">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                                                    <?php } if ($this->rbac->hasPrivilege('supplier', 'can_delete')) { ?>
                                                        <a  class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('delete'); ?>" onclick="delete_recordById('<?php echo base_url(); ?>admin/itemsupplier/delete/<?php echo $supplier['id'] ?>', '<?php echo $this->lang->line('delete_message') ?>')">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        $count++;
                                    }
                                    ?>

                                </tbody>
                            </table><!-- /.table -->
                        </div><!-- /.mail-box-messages -->
                    </div><!-- /.box-body -->
                </div>
            </div>

            <!-- right column -->

        </div>   <!-- /.row -->
    </section><!-- /.content -->
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-mid" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="box-title"> <?php echo $this->lang->line('add'); ?>  <?php echo $this->lang->line('item_supplier'); ?></h4> 
            </div>



            <form id="formadd" action="<?php echo site_url('admin/itemsupplier/add') ?>" name="employeeform" method="post" accept-charset="utf-8"  enctype="multipart/form-data">
                <div class="modal-body pt0 pb0">
                    <div class="ptt10">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1"> <?php echo $this->lang->line('name'); ?></label><small class="req"> *</small>
                                    <input autofocus="" id="name" name="name" placeholder="" type="text" class="form-control"  value="<?php echo set_value('name'); ?>" />
                                    <span class="text-danger"><?php echo form_error('name'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1"> <?php echo $this->lang->line('phone'); ?></label>
                                    <input id="phone" name="phone" placeholder="" type="text" class="form-control"  value="<?php echo set_value('phone'); ?>" />
                                    <span class="text-danger"><?php echo form_error('phone'); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1"> <?php echo $this->lang->line('email'); ?></label>
                                    <input id="text" name="email" placeholder="" type="text" class="form-control"  value="<?php echo set_value('email'); ?>" />
                                    <span class="text-danger"><?php echo form_error('email'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1"> <?php echo $this->lang->line('contact_person_name'); ?></label>
                                    <input id="contact_person_name" name="contact_person_name" placeholder="" type="text" class="form-control"  value="<?php echo set_value('contact_person_name'); ?>" />
                                    <span class="text-danger"><?php echo form_error('contact_person_name'); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1"><?php echo $this->lang->line('address'); ?></label>
                            <textarea class="form-control" id="address" name="address" placeholder="" rows="3" placeholder="Enter ..."><?php echo set_value('address'); ?></textarea>
                            <span class="text-danger"><?php echo form_error('address'); ?></span>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1"><?php echo $this->lang->line('contact_person_phone'); ?></label>
                            <input id="contact_person_phone" name="contact_person_phone" placeholder="" type="text" class="form-control"  value="<?php echo set_value('contact_person_phone'); ?>" />
                            <span class="text-danger"><?php echo form_error('contact_person_phone'); ?></span>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1"> <?php echo $this->lang->line('contact_person_email'); ?></label>
                            <input id="contact_person_email" name="contact_person_email" placeholder="" type="email" class="form-control"  value="<?php echo set_value('contact_person_email'); ?>" />
                            <span class="text-danger"><?php echo form_error('contact_person_email'); ?></span>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1"><?php echo $this->lang->line('description'); ?></label>
                            <textarea class="form-control" id="description" name="description" placeholder="" rows="3" placeholder="Enter ..."><?php echo set_value('description'); ?></textarea>
                            <span class="text-danger"><?php echo form_error('description'); ?></span>
                        </div>              

                    </div>
                </div><!--./modal-->      
                <div class="box-footer">
                    <button type="submit" id="formaddbtn" data-loading-text="<?php echo $this->lang->line('processing') ?>" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                </div>
            </form>


        </div><!--./row--> 
    </div>
</div>


<div class="modal fade" id="editmyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-mid" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="box-title"> <?php echo $this->lang->line('edit'); ?>  <?php echo $this->lang->line('item_supplier'); ?></h4> 
            </div>



            <form id="editformadd" action="<?php echo site_url('admin/itemsupplier/edit') ?>" name="employeeform" method="post" accept-charset="utf-8"  enctype="multipart/form-data">
                <div class="modal-body pt0 pb0">
                    <div class="ptt10">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1"> <?php echo $this->lang->line('name'); ?></label><small class="req"> *</small>
                                    <input autofocus="" id="name1" name="name" placeholder="" type="text" class="form-control"  value="<?php echo set_value('name'); ?>" />
                                    <span class="text-danger"><?php echo form_error('name'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1"> <?php echo $this->lang->line('phone'); ?></label>
                                    <input id="phone1" name="phone" placeholder="" type="text" class="form-control"  value="<?php echo set_value('phone'); ?>" />
                                    <span class="text-danger"><?php echo form_error('phone'); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1"> <?php echo $this->lang->line('email'); ?></label>
                                    <input id="email1" name="email" placeholder="" type="text" class="form-control"  value="<?php echo set_value('email'); ?>" />
                                    <span class="text-danger"><?php echo form_error('email'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1"> <?php echo $this->lang->line('contact_person_name'); ?></label>
                                    <input id="contact_person_name1" name="contact_person_name" placeholder="" type="text" class="form-control"  value="<?php echo set_value('contact_person_name'); ?>" />
                                    <span class="text-danger"><?php echo form_error('contact_person_name'); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1"><?php echo $this->lang->line('address'); ?></label>
                            <textarea class="form-control" id="address1" name="address" placeholder="" rows="3" placeholder="Enter ..."><?php echo set_value('address'); ?></textarea>
                            <span class="text-danger"><?php echo form_error('address'); ?></span>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1"><?php echo $this->lang->line('contact_person_phone'); ?></label>
                            <input id="contact_person_phone1" name="contact_person_phone" placeholder="" type="text" class="form-control"  value="<?php echo set_value('contact_person_phone'); ?>" />
                            <span class="text-danger"><?php echo form_error('contact_person_phone'); ?></span>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1"> <?php echo $this->lang->line('contact_person_email'); ?></label>
                            <input id="contact_person_email1" name="contact_person_email" placeholder="" type="email" class="form-control"  value="<?php echo set_value('contact_person_email'); ?>" />
                            <span class="text-danger"><?php echo form_error('contact_person_email'); ?></span>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1"><?php echo $this->lang->line('description'); ?></label>
                            <textarea class="form-control" id="description1" name="description" placeholder="" rows="3" placeholder="Enter ..."><?php echo set_value('description'); ?></textarea>
                            <input type="hidden" id="supp_id" name="supp_id">
                            <span class="text-danger"><?php echo form_error('description'); ?></span>
                        </div>              


                    </div>
                </div><!--./modal-->    
                <div class="box-footer">
                    <button type="submit" id="editformaddbtn" data-loading-text="<?php echo $this->lang->line('processing') ?>" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                </div>
            </form>


        </div><!--./row--> 
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
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
</script>

<script type="text/javascript">
    var base_url = '<?php echo base_url() ?>';


</script>
<script>


    $(document).ready(function (e) {
        $('#formadd').on('submit', (function (e) {
            $("#formaddbtn").button('loading');
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
                    $("#formaddbtn").button('reset');
                },
                error: function () {

                }
            });


        }));

    });


    function get(id) {

        $('#editmyModal').modal('show');

        $.ajax({

            dataType: 'json',

            url: '<?php echo base_url(); ?>admin/itemsupplier/get_data/' + id,

            success: function (result) {
                $('#supp_id').val(result.id);
                $('#name1').val(result.item_supplier);
                $('#phone1').val(result.phone);
                $('#email1').val(result.email);
                $('#description1').val(result.description);
                $('#address1').val(result.address);
                $('#contact_person_name1').val(result.contact_person_name);
                $('#contact_person_phone1').val(result.contact_person_phone);
                $('#contact_person_email1').val(result.contact_person_email);
            }

        });

    }


    $(document).ready(function (e) {
        $('#editformadd').on('submit', (function (e) {
            $("#editformaddbtn").button('loading');
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
                    $("#editformaddbtn").button('reset');
                },
                error: function () {

                }
            });


        }));

    });


</script>


