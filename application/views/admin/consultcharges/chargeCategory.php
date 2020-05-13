<div class="content-wrapper" style="min-height: 946px;">  

    <!-- Main content -->
    <section class="content">
        <div class="row">

            <div class="col-md-2">
                <div class="box border0">
                    <ul class="tablists">
                        <?php if ($this->rbac->hasPrivilege('hospital_charges', 'can_view')) { ?> 
                            <li>
                                <a href="<?php echo base_url(); ?>admin/charges" ><?php echo $this->lang->line('charges'); ?></a></li>
                        <?php } ?>
                        <?php if ($this->rbac->hasPrivilege('charge_category', 'can_view')) { ?> 
                            <li><a class="active" href="<?php echo base_url(); ?>admin/chargecategory/charges"><?php echo $this->lang->line('charge') . " " . $this->lang->line('category'); ?></a></li>
                        <?php } ?>                                                                  
                    </ul>
                </div>
            </div>
            <div class="col-md-10"> 
                <div class="box box-primary" id="tachelist">
                    <div class="box-header ptbnull">
                        <h3 class="box-title titlefix"><?php echo $this->lang->line('charge_category') . " " . $this->lang->line('list'); ?></h3>
                        <div class="box-tools pull-right">
                            <?php if ($this->rbac->hasPrivilege('charge_category', 'can_add')) { ?> 
                                <a data-toggle="modal" data-target="#myModal" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> <?php echo $this->lang->line('add') . " " . $this->lang->line('charge_category'); ?></a>  
                            <?php } ?>   
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="mailbox-controls">
                        </div>
                        <div class="table-responsive mailbox-messages">
                            <div class="download_label"><?php echo $this->lang->line('charge_category') . " " . $this->lang->line('details'); ?></div>
                            <table class="table table-striped table-bordered table-hover example" >
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('name'); ?></th>
                                        <th><?php echo $this->lang->line('description'); ?></th>
                                        <th><?php echo $this->lang->line('charge_type'); ?></th>
                                        <th class="text-right"><?php echo $this->lang->line('action'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $count = 1;
                                    foreach ($chargeCategory as $category) {
                                        ?>
                                        <tr>
                                            <td><?php echo $category['name']; ?></td>
                                            <td><?php echo $category['description']; ?></td>
                                            <td><?php echo $category['charge_type']; ?></td>
                                            <td class="text-right">
                                                <?php if ($this->rbac->hasPrivilege('charge_category', 'can_edit')) { ?> 
                                                    <a onclick="get(<?php echo $category['id']; ?>)" data-target="#editmyModal"  class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('edit'); ?>">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>
                                                <?php } if ($this->rbac->hasPrivilege('charge_category', 'can_delete')) { ?> 
                                                    <a  class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('delete'); ?>" onclick="delete_recordById('<?php echo base_url(); ?>admin/chargecategory/delete/<?php echo $category['id'] ?>', '<?php echo $this->lang->line('delete_message'); ?>')";>
                                                        <i class="fa fa-trash"></i>
                                                    </a> 
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php
                                        $count++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="">
                        <div class="mailbox-controls">
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </section>
</div>


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-mid" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="box-title"> <?php echo $this->lang->line('add') . " " . $this->lang->line('charge_category') ?></h4> 
            </div>

            <div class="modal-body pt0 pb0">

                <form id="formadd" action="<?php echo site_url('admin/chargecategory/add') ?>"  id="employeeform" name="employeeform" method="post" accept-charset="utf-8">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1"><?php echo $this->lang->line('name'); ?></label><small class="req"> *</small>
                            <input autofocus="" id="type"  name="name"  type="text" class="form-control" value="<?php
                            if (isset($result)) {
                                echo $result["name"];
                            }
                            ?>" />
                            <span class="text-danger"><?php echo form_error('name'); ?></span> 
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1"><?php echo $this->lang->line('description'); ?></label><small class="req"> *</small>
                            <textarea name="description" class="form-control"><?php
                                if (isset($result)) {
                                    echo $result["description"];
                                }
                                ?></textarea>
                            <span class="text-danger"><?php echo form_error('description'); ?></span>
                        </div>
                        <div class="form-group">
                            <label for="pwd"><?php echo $this->lang->line('charge_type'); ?></label>
                            <small class="req"> *</small>  
                            <select name="charge_type" class="form-control">
                                <option value=""><?php echo $this->lang->line('select') ?></option>
                                <?php foreach ($charge_type as $charge_key => $charge_value) {
                                    ?>
                                    <option value="<?php echo $charge_key; ?>" <?php if ((isset($result['charge_type']) ) && ($result['charge_type'] == $charge_key)) echo "selected"; ?>><?php echo $charge_value; ?></option>
                                <?php } ?>
                            </select>
                            <span class="text-danger"><?php echo form_error('charge_type'); ?></span>
                        </div>

                    </div>
                    <div class="box-footer">
                        <button type="submit" id="formaddbtn" data-loading-text="<?php echo $this->lang->line('processing') ?>" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                    </div>
                </form>

            </div><!--./col-md-12-->       
        </div><!--./row--> 
    </div>
</div>


<div class="modal fade" id="editmyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-mid" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="box-title"><?php echo $this->lang->line('edit') . " " . $this->lang->line('charge_category'); ?></h4> 
            </div>

            <div class="modal-body pt0 pb0">

                <form id="editformadd" action="<?php echo site_url('admin/chargecategory/add') ?>" name="employeeform" method="post" accept-charset="utf-8"  enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1"><?php echo $this->lang->line('name'); ?></label><small class="req"> *</small>
                            <input  id="type1"  name="name"  type="text" class="form-control" value="<?php
                            if (isset($result)) {
                                echo $result["name"];
                            }
                            ?>" />
                            <span class="text-danger"><?php echo form_error('name'); ?></span> 
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1"><?php echo $this->lang->line('description'); ?></label><small class="req"> *</small>
                            <textarea name="description" id="description1" class="form-control"><?php
                                if (isset($result)) {
                                    echo $result["description"];
                                }
                                ?></textarea>
                            <span class="text-danger"><?php echo form_error('description'); ?></span>
                        </div>
                        <div class="form-group">
                            <label for="pwd"><?php echo $this->lang->line('charge_type'); ?></label>
                            <small class="req"> *</small>  
                            <select name="charge_type" id="charge_type1" class="form-control">
                                <option value=""><?php echo $this->lang->line('select') ?></option>
                                <?php foreach ($charge_type as $charge_key => $charge_value) {
                                    ?>
                                    <option value="<?php echo $charge_key; ?>" <?php if ((isset($result['charge_type']) ) && ($result['charge_type'] == $charge_key)) echo "selected"; ?>><?php echo $charge_value; ?></option>
                                <?php } ?>
                            </select>
                            <input type="hidden" id="chargecategory_id" name="id" >
                            <span class="text-danger"><?php echo form_error('charge_type'); ?></span>
                        </div>                             

                    </div>
                    <div class="box-footer">
                        <button type="submit" data-loading-text="<?php echo $this->lang->line('processing') ?>" id="editformaddbtn" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                    </div>
                </form>

            </div><!--./col-md-12-->       
        </div><!--./row--> 
    </div>
</div>

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

            url: '<?php echo base_url(); ?>admin/chargecategory/get_data/' + id,

            success: function (result) {
                $('#chargecategory_id').val(result.id);
                $('#description1').val(result.description);
                $('#charge_type1').val(result.charge_type);
                $('#type1').val(result.name);

            }

        });

    }


    $(document).ready(function (e) {

        $('#editformadd').on('submit', (function (e) {
            e.preventDefault();
            $("#editformaddbtn").button('loading');
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