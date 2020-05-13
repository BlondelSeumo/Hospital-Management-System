
<script src="https://ilikenwf.github.io/jquery.mjs.nestedSortable.js"></script>
<style type="text/css">
    ol {
        margin: 0;
        padding: 0;
        padding-left: 30px;
    }

    ol.sortable{
        margin: 0 0 0 0px;
        padding: 0;
        list-style-type: none;
    }
    ol.sortable ol {
        margin: 0 0 0 25px;
        padding: 0;
        list-style-type: none;
    }
    .sortable li {
        margin: 7px 0 0 0;
        padding: 0;
        position: relative;
    }
    .material-switch > input[type="checkbox"] {
        display: none;   
    }

    .material-switch > label {
        cursor: pointer;
        height: 0px;
        position: relative; 
        width: 40px;  
    }

    .material-switch > label::before {
        background: rgb(0, 0, 0);
        box-shadow: inset 0px 0px 10px rgba(0, 0, 0, 0.5);
        border-radius: 8px;
        content: '';
        height: 16px;
        margin-top: -8px;
        position:absolute;
        opacity: 0.3;
        transition: all 0.4s ease-in-out;
        width: 40px;
    }
    .material-switch > label::after {
        background: rgb(255, 255, 255);
        border-radius: 16px;
        box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
        content: '';
        height: 24px;
        left: -4px;
        margin-top: -8px;
        position: absolute;
        top: -4px;
        transition: all 0.3s ease-in-out;
        width: 24px;
    }
    .material-switch > input[type="checkbox"]:checked + label::before {
        background: inherit;
        opacity: 0.5;
    }
    .material-switch > input[type="checkbox"]:checked + label::after {
        background: inherit;
        left: 20px;
    }
    .ui-sortable-handle a{color: #444;}
    .tooltip.top .tooltip-inner {
        background-color:#000;
        padding:5px 20px;
        opacity:100;
        border-radius:2px;

    }
    .tooltip.top .tooltip-arrow {
        border-top-color:#000;
        opacity:0.5;
    }
</style>



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-8">
                <!-- Horizontal Form -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo $this->lang->line('add_menu_item'); ?></h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form id="form1" action="<?php echo site_url('admin/front/menus/additem/' . $result['slug']) ?>"  id="employeeform" name="employeeform" method="post" accept-charset="utf-8">
                        <div class="box-body">
                            <input type="hidden" name="menu_id" value="<?php echo $result['id'] ?>">
                            <?php if ($this->session->flashdata('msg')) { ?>
                                <?php echo $this->session->flashdata('msg') ?>
                            <?php } ?>
                            <?php
                            if (isset($error_message)) {
                                echo "<div class='alert alert-danger'>" . $error_message . "</div>";
                            }
                            ?>
                            <?php echo $this->customlib->getCSRF(); ?>
                            <?php //echo validation_errors(); ?>
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo $this->lang->line('menu_item'); ?></label><small class="req"> *</small>
                                <input autofocus="" id="menu" name="menu" placeholder="" type="text" class="form-control"  value="<?php echo set_value('menu'); ?>" />
                                <span class="text-danger"><?php echo form_error('menu'); ?></span>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo $this->lang->line('external_url'); ?></label>
                                <div class="material-switch">
                                    <input id="ext_url" name="ext_url" type="checkbox" class="ext_url_chk"  value="1" <?php echo set_checkbox('ext_url', '1', (set_value('ext_url')) ? TRUE : FALSE); ?> />
                                    <label for="ext_url" class="label-success"></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo $this->lang->line('open_in_new_tab'); ?></label>
                                <div class="material-switch">
                                    <input id="open_new_tab" name="open_new_tab" type="checkbox" class="chk"  value="1"  />
                                    <label for="open_new_tab" class="label-success"></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo $this->lang->line('external_url_address'); ?></label>
                                <input id="ext_url_link" name="ext_url_link"  type="text" class="form-control"  value="<?php echo set_value('ext_url_link'); ?>" <?php echo (!set_value('ext_url')) ? 'disabled' : ''; ?>/>
                                <span class="text-danger"><?php echo form_error('ext_url_link'); ?></span>
                            </div> 
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo $this->lang->line('page'); ?></label>
                                <select  id="page_id" name="page_id" class="form-control"  >
                                    <option value=""><?php echo $this->lang->line('select'); ?></option>
                                    <?php
                                    foreach ($listPages as $page) {
                                        ?>
                                        <option value="<?php echo $page['id'] ?>"<?php if (set_value('page_id') == $page['id']) echo "selected=selected" ?>><?php echo $page['title'] ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <span class="text-danger"><?php echo form_error('class_id'); ?></span>
                            </div>

                        </div><!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                        </div>
                    </form>
                </div>

            </div><!--/.col (right) -->
            <!-- left column -->
            <div class="col-md-4">
                <!-- general form elements -->
                <div class="box box-primary" id="holist">
                    <div class="box-header ptbnull">
                        <h3 class="box-title titlefix"><?php echo $this->lang->line('menu_item_list'); ?></h3>
                    </div><!-- /.box-header -->
                    <form id="form1" action="<?php echo site_url('admin/front/menus/update') ?>"  id="employeeform" name="employeeform" method="post" accept-charset="utf-8">
                        <div class="box-body">
                            <div class="mailbox-controls">
                                <div class="pull-right">
                                </div><!-- /.pull-right -->
                            </div>
                            <div class="table-responsive mailbox-messages">
                                <div class="download_label"><?php echo $this->lang->line('menu_item_list'); ?></div>

                                <div class="menu-box">
                                    <ol class="sortable">


                                        <?php if (empty($listdropdown_Menus)) {
                                            ?>

                                            <?php
                                        } else {
                                            $count = 1;

                                            foreach ($listdropdown_Menus as $menu) {
                                                ?>
                                                <li id="list_<?php echo $menu['id']; ?>">
                                                    <div>
                                                        <?php echo $menu['menu']; ?>


                                                        <span class="pull-right">
                                                            <a href="<?php echo site_url('admin/front/menus/edititem/' . $menu['slug'] . "/" . $top_menu) ?>" class="btn btn-xs" title="<?php echo $this->lang->line('edit'); ?>"><i class="fa fa-pencil"></i></a>    
                                                            <a href="#" class="btn btn-xs" title="<?php echo $this->lang->line('delete'); ?>" data-id="<?php echo $menu['id']; ?>" id="deleteItem" data-toggle="modal" data-target="#confirm-delete"><i class="fa fa-remove"></i></a>
                                                        </span>

                                                    </div>

                                                    <?php
                                                    if (!empty($menu['submenus'])) {
                                                        ?>
                                                        <ol class="submenu-list">

                                                            <?php
                                                            foreach ($menu['submenus'] as $submenu_key => $submenu_value) {
                                                                ?>
                                                                <li id="list_<?php echo $submenu_value['id']; ?>">
                                                                    <div class="ui-sortable-handle">
                                                                        <?php echo $submenu_value['menu']; ?>

                                                                        <span class="pull-right">
                                                                            <a href="<?php echo site_url('admin/front/menus/edititem/' . $submenu_value['slug'] . "/" . $top_menu) ?>" class="btn btn-xs" title="Edit Item"><i class="fa fa-pencil"></i></a>  
                                                                            <a href="#" class="btn btn-xs" title="Delete Item" data-id="<?php echo $submenu_value['id']; ?>" id="deleteItem" data-toggle="modal" data-target="#confirm-delete"><i class="fa fa-remove"></i></a>
                                                                        </span>

                                                                    </div></li>
                                                                <?php
                                                            }
                                                            ?>
                                                        </ol>
                                                        <?php
                                                    }
                                                    ?>
                                                </li>
                                                <?php
                                            }
                                            $count++;
                                        }
                                        ?>
                                    </ol>
                                </div>
                            </div><!-- /.mail-box-messages -->
                        </div><!-- /.box-body -->

                    </form>
                </div>
            </div><!--/.col (left) -->
        </div>
        <div class="row">
            <div class="col-md-12">
            </div><!--/.col (right) -->
        </div>   <!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<script type="text/javascript">
    $(document).ready(function () {
        $('.delmodal').modal({
            backdrop: 'static',
            keyboard: false,
            show: false
        })
        $('#confirm-delete').on('show.bs.modal', function (e) {
            var data = $(e.relatedTarget).data();
            $('.del_menuid', this).val("");
            $('.del_menuid', this).val(data.id);
        });


        $('#confirm-delete').on('click', '.btn-ok', function (e) {
            var $modalDiv = $(e.delegateTarget);
            var id = $('.del_menuid').val();


            $.ajax({
                type: "post",
                url: '<?php echo site_url("admin/front/menus/deleteMenuItem") ?>',
                dataType: 'JSON',
                data: {'id': id},
                beforeSend: function () {
                    $modalDiv.addClass('modalloading');
                },
                success: function (data) {
                    if (data.status == 1) {
                        successMsg(data.message);
                        location.reload(true);

                    } else {
                        errorMsg(data.message);
                    }
                },
                complete: function () {

                    $modalDiv.removeClass('modalloading');

                }
            });


        });


    });


</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#postdate').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true
        });



        $('.ext_url_chk').change(function () {
            var c = this.checked ? 1 : 0;
            if (c) {
                $('#ext_url_link').prop("disabled", false);
            } else {
                $('#ext_url_link').prop("disabled", true);

            }
        });
        $('ol.sortable').nestedSortable({
            disableNesting: 'no-nest',
            forcePlaceholderSize: true,
            handle: 'div',
            helper: 'clone',
            items: 'li',
            maxLevels: 2,
            opacity: .6,
            tabSize: 25,
            tolerance: 'pointer',
            toleranceElement: '> div',
            update: function () {
                var list = $(this).nestedSortable('toHierarchy');
                var urls = baseurl + "admin/front/menus/updateMenu";
                $.ajax({
                    url: urls,
                    type: 'post',
                    data: {order: list},

                    dataType: "html",
                    success: function (response) {

                    },
                    beforeSend: function () {

                    },
                    complete: function () {


                    }
                });
            }
        });
    });

</script>
<div class="delmodal modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line('confirmation'); ?></h4>
            </div>

            <div class="modal-body">

                <p>Are you sure want to delete item, this action is irreversible!</p>
                <p>Do you want to proceed?</p>
                <p class="debug-url"></p>
                <input type="hidden" name="del_menuid" class="del_menuid" value="">

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('cancel'); ?></button>
                <a class="btn btn-danger btn-ok"><?php echo $this->lang->line('delete'); ?></a>
            </div>
        </div>
    </div>
</div>
