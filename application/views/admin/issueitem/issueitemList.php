
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Horizontal Form -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo $this->lang->line('issue_item'); ?></h3>
                        <div class="box-tools pull-right">
                            <?php if ($this->rbac->hasPrivilege('issue_item', 'can_add')) { ?>
                                <a href="<?php //echo site_url('admin/issueitem/create')     ?>" data-toggle="modal" data-target="#myModal" class="btn btn-primary btn-sm" ><i class="fa fa-plus"></i> <?php echo $this->lang->line('add_issue_item'); ?></a>
                            <?php } ?>
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <?php $logUser = $this->customlib->getLoggedInUserData();
                        ?>
                        <div class="table-responsive mailbox-messages">
                            <div class="download_label"><?php echo $this->lang->line('issue_item'); ?></div>
                            <table class="table table-hover table-striped table-bordered example">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('item'); ?></th>
                                        <th><?php echo $this->lang->line('item_category'); ?></th>
                                        <th><?php echo $this->lang->line('issue') . " - " . $this->lang->line('return'); ?></th>
                                        <th><?php echo $this->lang->line('issue_to'); ?></th>
                                        <th><?php echo $this->lang->line('issued_by'); ?></th>
                                        <th><?php echo $this->lang->line('quantity'); ?></th>
                                        <th><?php echo $this->lang->line('status'); ?></th>
                                        <th class="text-right"><?php echo $this->lang->line('action'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (empty($itemissueList)) {
                                        ?>

                                        <?php
                                    } else {
                                        foreach ($itemissueList as $item) {
                                            ?>
                                            <tr>
                                                <td class="mailbox-name">
                                                    <a href="#" data-toggle="popover" class="detail_popover"><?php echo $item['item_name'] ?></a>

                                                    <div class="fee_detail_popover" style="display: none">
                                                        <?php
                                                        if ($item['note'] == "") {
                                                            ?>
                                                            <p class="text text-danger"><?php echo $this->lang->line('no_description'); ?></p>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <p class="text text-info"><?php echo $item['note']; ?></p>
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </td>
                                                <td class="mailbox-name">
                                                    <?php echo $item['item_category']; ?>
                                                </td>


                                                <td class="mailbox-name">
                                                    <?php
                                                    if ($item['return_date'] == "0000-00-00") {
                                                        $return_date = "";
                                                    } else {
                                                        $return_date = date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($item['return_date']));
                                                    }
                                                    echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($item['issue_date'])) . " - " . $return_date;
                                                    ?>
                                                </td>
                                                <td class="mailbox-name">
                                                    <?php
                                                    echo $item['name']." ".$item['docname'] . " " . $item['docsurname'] . "(" . $item['employee_id'] . ")";
                                                    ;
                                                    ?>
                                                </td>
                                                <td class="mailbox-name"><?php echo $item['issue_by']; ?></td>
                                                <td class="mailbox-name"><?php echo $item['quantity']; ?></td>
                                                <td class="mailbox-name"><?php
                                                    if ($item['is_returned'] == 1) {
                                                        ?>


                                                        <span class="label label-danger item_remove" data-item="<?php echo $item['id'] ?>" data-category="<?php echo $item['item_category'] ?>" data-item_name="<?php echo $item['item_name'] ?>" data-quantity="<?php echo $item['quantity'] ?>" data-toggle="modal" data-target="#confirm-delete"><?php echo $this->lang->line('click_to_return'); ?></span>

                                                        <?php
                                                    } else {
                                                        ?>

                                                        <span class="label label-success"><?php echo $this->lang->line('returned'); ?></span>

                                                        <?php
                                                    }
                                                    ?></td>

                                                <td class="mailbox-date pull-right">

                                                    <?php if ($this->rbac->hasPrivilege('issue_item', 'can_delete')) { ?>
                                                        <a  class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('delete'); ?>" onclick="delete_recordById('<?php echo base_url(); ?>admin/issueitem/delete/<?php echo $item['id'] ?>', '<?php echo $this->lang->line('delete_message') ?>')">
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
            </div><!--/.col (right) -->
        </div>

    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

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

    $(document).ready(function () {
        $('#confirm-delete').on('show.bs.modal', function (e) {
            $('#item_issue_id').val("");
            $('.debug-url').html('');
            $('#modal_item_quantity,#modal_item,#modal_item_cat').text("");
            var item_issue_id = $(e.relatedTarget).data('item');
            var item_category = $(e.relatedTarget).data('category');
            var quantity = $(e.relatedTarget).data('quantity');
            var item_name = $(e.relatedTarget).data('item_name');
            $('#item_issue_id').val(item_issue_id);
            $('#modal_item_cat').text(item_category);
            $('#modal_item').text(item_name);
            $('#modal_item_quantity').text(quantity);

        });
        $("#confirm-delete").modal({
            backdrop: false,
            show: false
        });
        var date_format = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(), ['d' => 'dd', 'm' => 'mm', 'Y' => 'yyyy',]) ?>';
        $('.date').datepicker({
            format: date_format,
            autoclose: true
        });
    });

    var base_url = '<?php echo base_url() ?>';

    $(document).on('change', '#item_category_id', function (e) {

        var item_category_id = $(this).val();
        populateItem(0, item_category_id);
    });

    $(document).on('click', '.btn-ok', function () {
        var $this = $('.btn-ok');
        $this.button('loading');
        var item_issue_id = $('#item_issue_id').val();
        $.ajax(
                {
                    url: "<?php echo site_url('admin/issueitem/returnItem') ?>",
                    type: "POST",
                    data: {'item_issue_id': item_issue_id},
                    dataType: 'Json',
                    success: function (data, textStatus, jqXHR)
                    {
                        if (data.status == "fail") {

                            errorMsg(data.message);
                        } else {
                            successMsg(data.message);

                            $("#confirm-delete").modal('hide');
                            location.reload();
                        }

                        $this.button('reset');
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        $this.button('reset');
                    }
                });

    });


</script>
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line('confirm_return'); ?></h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="item_issue_id" name="item_issue_id" value="">
                <p>Are you sure to return this item !</p>
                <ul class="list2">
                    <li><?php echo $this->lang->line('item'); ?><span id="modal_item"></span></li>
                    <li><?php echo $this->lang->line('item_category'); ?><span id="modal_item_cat"></span></li>
                    <li><?php echo $this->lang->line('quantity'); ?><span id="modal_item_quantity"></span></li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('cancel'); ?></button>
                <a class="btn cfees btn-ok" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Please Wait.."><?php echo $this->lang->line('return'); ?></a>
            </div>
        </div>
    </div>
</div>
<div class="modal fade"  id="myModal" tabindex="-1" role="dialog" aria-labelledby="follow_up">
    <div class="modal-dialog modal-mid" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close"  data-dismiss="modal">&times;</button>
                <h4 class="box-title"><?php echo $this->lang->line('add') . " " . $this->lang->line('issue') . " " . $this->lang->line('item') ?></h4>
            </div>
            <div class="modal-body pt0 pb0" >
                <div class="row ptt10">
                    <form id="form1" action="<?php echo base_url() ?>admin/issueitem/add"   name="itemstockform" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                        <?php echo $this->customlib->getCSRF(); ?>
                        <div class="form-group col-md-4 col-sm-4">
                            <label for="exampleInputEmail1"><?php echo $this->lang->line('user_type'); ?></label><small class="req"> *</small>
                            <select name="account_type" onchange="getIssueUser(this.value)"  id="input-type-student" class="form-control ac_type">
                                <option value=""><?php echo $this->lang->line('select'); ?></option>
                                <?php
                                foreach ($roles as $role_key => $role_value) {
                                    ?>
                                    <option value="<?php echo $role_value['id']; ?>"><?php echo $role_value['name'] ?></option>

                                    <?php echo $role_value['name']; ?>

                                    <?php
                                }
                                ?>
                            </select>
                            <span class="text-danger"><?php echo form_error('Items'); ?></span>
                        </div>
                        <div class="form-group col-md-4 col-sm-4">
                            <label for="exampleInputEmail1"><?php echo $this->lang->line('issue_to'); ?></label><small class="req"> *</small>

                            <select  id="issue_to" name="issue_to" class="form-control">
                                <option value=""><?php echo $this->lang->line('select'); ?></option>
                            </select>
                            <span class="text-danger"><?php echo form_error('Items'); ?></span>

                        </div>
                        <!-- <div class="clearfix"></div> -->
                        <div class="form-group col-md-4 col-sm-4">
                            <label for="exampleInputEmail1"><?php echo $this->lang->line('issue_by'); ?></label><small class="req"> *</small>
                            <input id="issue_by" name="issue_by" placeholder="" type="text" class="form-control"  value="<?php echo $logUser['username']; ?>" />
                            <span class="text-danger"><?php echo form_error('issue_by'); ?></span>

                        </div>
                        <div class="form-group col-md-4 col-sm-4">
                            <label for="exampleInputEmail1"><?php echo $this->lang->line('issue_date'); ?></label><small class="req"> *</small>
                            <input id="issue_date" name="issue_date" placeholder="" type="text" class="form-control date"  value="<?php echo set_value('issue_date'); ?>" readonly />
                            <span class="text-danger"><?php echo form_error('issue_date'); ?></span>
                        </div>
                        <!-- <div class="clearfix"></div> -->
                        <div class="form-group col-md-4 col-sm-4">
                            <label for="exampleInputEmail1"><?php echo $this->lang->line('return_date'); ?></label>
                            <input id="return_date" name="return_date" placeholder="" type="text" class="form-control date"  value="<?php echo set_value('return_date'); ?>" readonly/>
                            <span class="text-danger"><?php echo form_error('return_date'); ?></span>
                        </div>

                        <div class="form-group col-md-4 col-sm-4">
                            <label for="exampleInputEmail1"><?php echo $this->lang->line('note'); ?></label>
                            <textarea name="note" class="form-control" id="note"/><?php echo set_value('note'); ?></textarea>
                            <span class="text-danger"><?php echo form_error('note'); ?></span>
                        </div>
                        <div class="clearfix"></div>
                        <hr>
                        <div class="col-md-12">
                            <div class="row">

                                <div class="form-group col-sm-4">
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
                                        }
                                        ?>
                                    </select>
                                    <span class="text-danger"><?php echo form_error('item_category_id'); ?></span>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('item'); ?></label><small class="req"> *</small>

                                    <select  id="item_id" name="item_id" class="form-control" >
                                        <option value=""><?php echo $this->lang->line('select'); ?></option>

                                    </select>
                                    <span class="text-danger"><?php echo form_error('item_id'); ?></span>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('quantity'); ?></label><small class="req"> *</small>
                                    <input  class="form-control" name="quantity"/>
                                    <div id="div_avail">
                                        <span><?php echo $this->lang->line('available_quantity'); ?> : </span>
                                        <span id="item_available_quantity">0</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            <div class="box-footer clear">
                <div class="pull-right">
                    <button type="submit" id="form1btn" data-loading-text="<?php echo $this->lang->line('processing') ?>"  class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">


    $(document).ready(function (e) {

        $('#form1').on('submit', (function (e) {
            $("#form1btn").button('loading');
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
                    $("#form1btn").button('reset');
                },
                error: function () {
                    alert("Fail")
                }
            });


        }));

    });

    var base_url = '<?php echo base_url() ?>';
    function populateItem(item_id_post, item_category_id_post) {
        if (item_category_id_post != "") {
            $('#item_id').html("");
            var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
            $.ajax({
                type: "GET",
                url: base_url + "admin/itemstock/getItemByCategory",
                data: {'item_category_id': item_category_id_post},
                dataType: "json",
                success: function (data) {
                    $.each(data, function (i, obj)
                    {
                        var select = "";
                        if (item_id_post == obj.id) {
                            var select = "selected=selected";
                        }
                        div_data += "<option value=" + obj.id + " " + select + ">" + obj.name + "</option>";
                    });
                    $('#item_id').append(div_data);
                }

            });
        }
    }

    $(document).on('change', '#item_id', function (e) {
        $('#div_avail').hide();
        var item_id = $(this).val();
        availableQuantity(item_id);

    });

    function availableQuantity(item_id) {
        if (item_id != "") {
            $('#item_available_quantity').html("");
            var div_data = '';
            $.ajax({
                type: "GET",
                url: base_url + "admin/item/getAvailQuantity",
                data: {'item_id': item_id},
                dataType: "json",
                success: function (data) {

                    $('#item_available_quantity').html(data.available);
                    $('#div_avail').show();
                }

            });
        }
    }

    $("input[name=account_type]:radio").change(function () {
        var user = $('input[name=account_type]:checked').val();
        getIssueUser(user);
    });

    function getIssueUser(usertype) {
        $('#issue_to').html("");
        var div_data = "";
        $.ajax({
            type: "POST",
            url: base_url + "admin/issueitem/getUser",
            data: {'usertype': usertype},
            dataType: "json",
            success: function (data) {

                $.each(data.result, function (i, obj)
                {
                    if (data.usertype == "admin") {
                        name = obj.username;
                    } else {
                        name = obj.name + " " + obj.surname;

                    }
                    div_data += "<option value=" + obj.id + ">" + name + "</option>";
                });
                $('#issue_to').append(div_data);
            }

        });
    }
</script>