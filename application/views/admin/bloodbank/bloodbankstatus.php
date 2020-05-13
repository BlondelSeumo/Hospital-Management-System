<div class="content-wrapper" style="min-height: 946px;">  
    <!-- Main content -->
    <section class="content">
        <div class="row">

            <div class="col-md-12">              
                <div class="box box-primary" id="tachelist">
                    <div class="box-header with-border">
                        <h3 class="box-title titlefix"><?php echo $this->lang->line('blood_bank') . " " . $this->lang->line('status'); ?></h3>
                        <div class="box-tools pull-right">
                            <?php if ($this->rbac->hasPrivilege('blood_donor', 'can_view')) { ?> 
                                <a href="<?php echo base_url(); ?>admin/bloodbank/search" class="btn btn-primary btn-sm"><i class="fa fa-reorder"></i> <?php echo $this->lang->line('donor') . " " . $this->lang->line('details'); ?></a> 
                                <?php
                            }
                            if ($this->rbac->hasPrivilege('blood_issue', 'can_view')) {
                                ?> 
                                <a href="<?php echo base_url() ?>admin/bloodbank/issue" class="btn btn-primary btn-sm"><i class="fa fa-reorder"></i> <?php echo $this->lang->line('blood_issue') . " " . $this->lang->line('details'); ?></a> 
                            <?php } ?>
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="mailbox-controls">
                        </div>
                        <div class="table-responsive mailbox-messages">
                            <div class="download_label"><?php echo $this->lang->line('blood_bank') . " " . $this->lang->line('status'); ?></div>
                            <table class="table table-striped table-bordered table-hover example" >
                                <thead>
                                    <tr>
                                        <th></i><?php echo $this->lang->line('blood_group'); ?></th>
                                        <th><?php echo $this->lang->line('status') . " " . $this->lang->line('in_bags'); ?></th>
                                        <th class="text-right"><?php echo $this->lang->line('action'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $count = 1;
                                    foreach ($bloodGroup as $category) {
                                        ?>
                                        <tr>
                                            <td><?php echo $category['blood_group']; ?></td>
                                            <td><?php echo $category['status']; ?></td>
                                            <td class="text-right">
                                                <?php if ($this->rbac->hasPrivilege('blood_bank_status', 'can_edit')) { ?> 
                                                    <a href="#" onclick="get('<?php echo $category['id'] ?>')" class="btn btn-default btn-xs" data-target="#editmyModal" data-toggle="tooltip" title="<?php echo $this->lang->line('edit'); ?>">
                                                        <i class="fa fa-pencil"></i>
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
<div class="modal fade" id="editmyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-mid" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="box-title"><?php echo $this->lang->line('edit') . " " . $this->lang->line('blood_bank') . " " . $this->lang->line('status'); ?></h4> 
            </div>

            <div class="modal-body pt0 pb0">
                <form   id="bloodgroupstatus" action="<?php echo site_url('admin/bloodbankstatus/status') ?>"  method="post" accept-charset="utf-8">
                    <div class="box-body">
                        <?php if ($this->session->flashdata('msg')) { ?>
                            <?php echo $this->session->flashdata('msg') ?>
                        <?php } ?>        
                        <?php echo $this->customlib->getCSRF(); ?>
                        <div class="row">
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo $this->lang->line('blood_group'); ?></label>
                                <input autofocus=""  name="blood_group" readonly="readonly" type="text" id="blood_group" class="form-control" value="<?php
                                if (isset($result)) {
                                    echo $result["blood_group"];
                                }
                                ?>" />
                                <span class="text-danger"><?php echo form_error('blood_group'); ?></span> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">

                                <label for="exampleInputEmail1"><?php echo $this->lang->line('status') . " " . $this->lang->line('in_bags'); ?></label><small class="req"> *</small>
                                <input autofocus="" id="status"  name="status" placeholder="" type="text" class="form-control"  value="<?php
                                if (isset($result)) {
                                    echo $result["status"];
                                }
                                ?>" />
                                <span class="text-danger"><?php echo form_error('status'); ?></span>
                                <input autofocus="" id="id"  name="id" placeholder="" type="hidden" class="form-control"  value="<?php
                                if (isset($result)) {
                                    echo $result["id"];
                                }
                                ?>" />
                            </div>
                        </div>

                    </div>
                    <div class="box-footer">
                        <button type="submit" id="bloodgroupstatusbtn" data-loading-text="<?php echo $this->lang->line('processing') ?>" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                    </div>
                </form>

            </div><!--./col-md-12-->       
        </div><!--./row--> 
    </div>
</div>
<script>
    function get(id) {
        $('#editmyModal').modal('show');
        $.ajax({
            dataType: 'json',
            url: '<?php echo base_url(); ?>admin/bloodbankstatus/edit/' + id,
            success: function (result) {
                $('#id').val(result.id);
                $('#status').val(result.status);
                $('#blood_group').val(result.blood_group);
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
                    $("#editformaddbtn").button('loading');
                },
                error: function () { }
            });
        }));

        //
        $('#bloodgroupstatus').on('submit', (function (e) {

            $("#bloodgroupstatusbtn").button('loading');
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
                    $("#bloodgroupstatusbtn").button('reset');
                },
                error: function () { }
            });
        }));
    });
</script>
