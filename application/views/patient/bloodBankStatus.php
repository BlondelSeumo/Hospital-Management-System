<div class="content-wrapper" style="min-height: 946px;">  
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12"> 
                <div class="box box-primary" id="tachelist">
                    <div class="box-header with-border">
                        <h3 class="box-title titlefix"><?php echo $this->lang->line('blood_bank') . " " . $this->lang->line('status') . " " . $this->lang->line('list'); ?></h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="mailbox-controls"></div>
                        <div class="table-responsive mailbox-messages">
                            <div class="download_label"><?php echo $this->lang->line('blood_bank') . " " . $this->lang->line('status'); ?></div>
                            <table class="table table-striped table-bordered table-hover example" >
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('blood_group'); ?></th>
                                        <th><?php echo $this->lang->line('status') . " " . $this->lang->line('in_bags'); ?></th>
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
                                        </tr>
                                        <?php
                                        $count++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </section>
</div>


