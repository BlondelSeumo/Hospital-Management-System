<style type="text/css">
    .panel-group .panel {
        border-radius: 0;
        box-shadow: none;
        border-color: #EEEEEE;
    }
    .panel-default > .panel-heading {
        padding: 0;
        border-radius: 0;
        color: #212121;
        background-color: #FAFAFA;
        border-color: #EEEEEE;
    }
    .panel-title {
        font-size: 14px;
    }
    .panel-title > a {
        display: block;
        padding: 15px;
        text-decoration: none;
    }
    .more-less {
        float: right;
        color: #212121;
    }
    .panel-default > .panel-heading + .panel-collapse > .panel-body {
        border-top-color: #EEEEEE;
    }

</style>
<?php $currency_symbol = $this->customlib->getSchoolCurrencyFormat(); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-credit-card"></i> Custom Fields --r</h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <?php
            if ($this->rbac->hasPrivilege('expense', 'can_add')) {
                ?>
                <div class="col-md-4">
                    <!-- Horizontal Form -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Add Custom Fields --r</h3>
                        </div><!-- /.box-header -->
                        <form id="form1" action="<?php echo site_url('admin/customfield') ?>"  id="employeeform" name="employeeform" method="post" accept-charset="utf-8">
                            <div class="box-body">
                                <?php echo validation_errors(); ?>
                                <?php if ($this->session->flashdata('msg')) { ?>
                                    <?php echo $this->session->flashdata('msg') ?>
                                <?php } ?>
                                <?php
                                if (isset($error_message)) {
                                    echo "<div class='alert alert-danger'>" . $error_message . "</div>";
                                }
                                ?>
                                <?php echo $this->customlib->getCSRF(); ?>
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('name'); ?></label> <small class="req">*</small>
                                    <input id="name" name="name" placeholder="" type="text" class="form-control"  value="<?php echo set_value('name'); ?>" />
                                    <span class="text-danger"><?php echo form_error('name'); ?></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1"> Grid (Bootstrap Column eq. 12) - Max is 12 --r</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">col-md-</span>
                                        <input type="number" max="12" class="form-control" name="column" id="column" value="12" aria-invalid="false">
                                    </div>
                                    <span class="text-danger"><?php echo form_error('column'); ?></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Field Values (Seprate By Comma) --r</label>
                                    <textarea class="form-control" name="field_values"><?php echo set_value('field_values') ?></textarea>
                                    <span class="text-danger"><?php echo form_error('field_values'); ?></span>
                                </div>
                            </div><!-- /.box-body -->
                            <div class="box-footer">
                                <button type="submit" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                            </div>
                        </form>
                    </div>
                </div><!--/.col (right) -->
                <!-- left column -->
            <?php } ?>
            <div class="col-md-<?php
            if ($this->rbac->hasPrivilege('expense', 'can_add')) {
                echo "8";
            } else {
                echo "12";
            }
            ?>">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header ptbnull">
                        <h3 class="box-title titlefix">Custom Fields List --r</h3>
                        <div class="box-tools pull-right">
                        </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div id="fade"></div>
                        <div id="modal">
                            <img id="loader" src="<?php echo base_url() ?>/backend/images/loading_blue.gif" />
                        </div>
                        <?php
                        if (!empty($customfields)) {
                            ?>
                            <div id="accordion" class="panel-group">
                                <?php
                                foreach ($custom_field_table as $custom_field_table_key => $custom_field_table_value) {
                                    ?>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $custom_field_table_key ?>" aria-expanded="false" aria-controls="collapse<?php echo $custom_field_table_key ?>">
                                                    <i class="more-less glyphicon glyphicon-plus"></i>
                                                    <?php echo $custom_field_table_value; ?>
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapse<?php echo $custom_field_table_key ?>" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <?php
                                                $records_fields = isset($customfields[$custom_field_table_key]) ? $customfields[$custom_field_table_key] : array();
                                                if (!empty($records_fields)) {
                                                    ?>
                                                    <ul class="sortable-item ui-sortable list-group" data-record_name="<?php echo $custom_field_table_key; ?>">
                                                        <?php
                                                        foreach ($records_fields as $records_fields_key => $records_fields_value) {
                                                            ?>
                                                            <li id="<?php echo $records_fields_value['id']; ?>" class="list-group-item-sort text-left">
                                                                <span class="sort-action">
                                                                    <a href="<?php echo site_url('admin/customfield/edit/' . $records_fields_value['id']); ?>" class="btn btn-xs" title="Edit"><i class="fa fa-pencil"></i></a>
                                                                    <a href="<?php echo site_url('admin/customfield/delete/' . $records_fields_value['id']); ?>" class="btn btn-xs" title="Delete" ><i class="fa fa-remove"></i></a>


                                                                </span> <i class="fa fa-arrows"></i> <?php
                                                                echo ($records_fields_value['name']);
                                                                ?>
                                                            </li>
                                                            <?php
                                                        }
                                                        ?>
                                                        </ol>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <div class="alert alert-danger">
                                                            No Record Found --r
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <?php
                        }
                        ?>
                    </div><!-- /.box-body -->
                </div>
            </div><!--/.col (left) -->

        </div>

    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<script type="text/javascript">
    function toggleIcon(e) {
        $(e.target)
                .prev('.panel-heading')
                .find(".more-less")
                .toggleClass('glyphicon-plus glyphicon-minus');
    }
    $('.panel-group').on('hidden.bs.collapse', toggleIcon);
    $('.panel-group').on('shown.bs.collapse', toggleIcon);
    $('.sortable-item').sortable({
        connectWith: '.sortable-item',
        update: function (event, ui) {
            $(this).closest('div.box-body').addClass("sdfdsfs");
            var record_name = $(this).data('record_name');
            var data = $(this).sortable('toArray');
            // data.push({name: 'wordlist', value: 1});
            $.ajax({
                type: "POST",
                url: base_url + "admin/customfield/updateorder",
                data: {"items": data, "belong_to": record_name},
                dataType: "json",

                beforeSend: function () {
                    $('#fade,#modal').css({'display': 'block'});
                },
                success: function (data) {
                    if (data.status) {
                        successMsg(data.msg);
                    } else {
                        errorMsg(data.msg);
                    }
                    $('#fade,#modal').css({'display': 'none'});
                },
                error: function (xhr) { // if error occured
                    alert("Error occured.please try again");
                    $('#fade,#modal').css({'display': 'none'});
                },
                complete: function () {
                    $('#fade,#modal').css({'display': 'none'});
                }
            });
        }
    });
</script>