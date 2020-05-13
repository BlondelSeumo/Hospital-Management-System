<style type="text/css">
    .table-sortable tbody tr {
        cursor: move;
    }

</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">


    <!-- Main content -->
    <section class="content">
        <div class="row">

            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary" id="holist">
                    <div class="box-header ptbnull">
                        <h3 class="box-title titlefix"><?php echo $this->lang->line('page_list'); ?></h3>
                        <?php
                        if ($this->rbac->hasPrivilege('pages', 'can_add')) {
                            ?>

                            <div class="box-tools pull-right">
                                <div class="btn-group" style="margin-left:4px;">
                                    <a href="<?php echo site_url('admin/front/page/create'); ?>" style="border-radius:2px 0px 0px 2px" class="btn btn-primary btn-sm"><?php echo $this->lang->line('add_page'); ?></a>
                                    <button type="button" style="border-left: 1px solid #2e6da4;" class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown">
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="<?php echo base_url(); ?>admin/front/events"><?php echo $this->lang->line('add') . " " . $this->lang->line('event'); ?></a></li>
                                        <li><a href="<?php echo base_url(); ?>admin/front/gallery"><?php echo $this->lang->line('add') . " " . $this->lang->line('gallery'); ?></a></li>
                                        <li><a href="<?php echo base_url(); ?>admin/front/notice"><?php echo $this->lang->line('add') . " " . $this->lang->line('notice'); ?></a></li>
                                    </ul>
                                </div>

                                <a href="<?php echo site_url('admin/front/media'); ?>" class="btn btn-sm btn-primary"><i class="fa fa-reorder"></i> <?php echo $this->lang->line('media_manager'); ?></a>
                                <a href="<?php echo site_url('admin/front/menus'); ?>" class="btn btn-sm btn-primary"><i class="fa fa-reorder"></i> <?php echo $this->lang->line('menus'); ?></a>
                                <a href="<?php echo site_url('admin/front/banner'); ?>" class="btn btn-sm btn-primary"><i class="fa fa-reorder"></i> <?php echo $this->lang->line('banners'); ?></a>

                            </div>
                        <?php } ?>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="mailbox-controls">
                            <div class="pull-right">
                            </div><!-- /.pull-right -->
                        </div>
                        <div class="table-responsive mailbox-messages">
                            <div class="download_label"><?php echo $this->lang->line('page'); ?></div>
                            <table class="table table-striped table-bordered table-hover example" >
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('title'); ?></th>
                                        <th><?php echo $this->lang->line('url'); ?></th>
                                        <th><?php echo $this->lang->line('page_type'); ?></th>
                                        <th class="text-right no-print">
                                            <?php echo $this->lang->line('action'); ?>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($listPages)) {
                                        ?>

                                        <?php
                                    } else {
                                        $count = 1;
                                        foreach ($listPages as $page) {
                                            ?>
                                            <tr id="<?php echo $page["id"]; ?>">

                                                <td class="mailbox-name">
                                                    <a href="#" ><?php echo $page['title'] ?></a>


                                                </td>

                                                <td class="mailbox-name"> <a href="<?php echo base_url() . $page['url'] ?>" target="_blank"><?php echo base_url() . $page['url'] ?></a></td>
                                                <td class="mailbox-name">
                                                    <?php
                                                    if ($page['content_type'] == "gallery") {
                                                        ?>
                                                        <span class="label bg-green"><?php echo $this->lang->line($page['content_type']); ?></span>
                                                        <?php
                                                    } elseif ($page['content_type'] == "events") {
                                                        ?>
                                                        <span class="label label-info"><?php echo $this->lang->line('event'); ?></span>
                                                        <?php
                                                    } elseif ($page['content_type'] == "notice") {
                                                        ?>
                                                        <span class="label label-warning"><?php echo $this->lang->line($page['content_type']); ?></span>
                                                        <?php
                                                    } else {
                                                        ?>

                                                        <span class="label label-default"><?php echo $this->lang->line('standard'); ?></span>
                                                    <?php } ?>



                                                </td>
                                                <td class="mailbox-date pull-right no-print">
                                                    <?php
                                                    if ($this->rbac->hasPrivilege('pages', 'can_edit')) {
                                                        ?>
                                                        <a href="<?php echo site_url('admin/front/page/edit/' . $page['slug']); ?>" class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('edit'); ?>">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                                                        <?php
                                                    }
                                                    if ($this->rbac->hasPrivilege('pages', 'can_delete')) {

                                                        if ($page['page_type'] != "default") {
                                                            ?>
                                                            <a  class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('delete'); ?>" onclick="delete_recordById('<?php echo site_url('admin/front/page/delete/' . $page['slug']); ?>', '<?php echo $this->lang->line('delete_message'); ?>')">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

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
            </div><!--/.col (left) -->
        </div>

    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
