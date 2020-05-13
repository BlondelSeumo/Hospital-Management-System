<?php
$currency_symbol = $this->customlib->getSchoolCurrencyFormat();
$genderList = $this->customlib->getGender();
?>


<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title titlefix"> <?php echo $this->lang->line('blood_bank'); ?></h3>

                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="download_label"><?php echo $this->lang->line('pharmacy') . " " . $this->lang->line('bill'); ?></div>
                        <table class="table table-striped table-bordered table-hover example" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th><?php echo $this->lang->line('bill') . " " . $this->lang->line('no'); ?></th>
                                    <th><?php echo $this->lang->line('issue_date'); ?></th>
                                    <th><?php echo $this->lang->line('recieved_to'); ?></th>
                                    <th><?php echo $this->lang->line('blood_group'); ?></th>
                                    <th><?php echo $this->lang->line('donor') . " " . $this->lang->line('name'); ?></th>
                                    <th><?php echo $this->lang->line('bag_no'); ?></th>
                                    <th class="text-right"><?php echo $this->lang->line('amount') . " (" . $currency_symbol . ")"; ?></th>
                                    <th><?php echo $this->lang->line('action'); ?></th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (empty($resultlist)) {
                                    ?>
                                              <!-- <tr>
                                                <td colspan="12" class="text-danger text-center"><?php //echo $this->lang->line('no_record_found');     ?></td>
                                              </tr> -->
                                    <?php
                                } else {
                                    $count = 1;
                                    foreach ($resultlist as $bill) {
                                        ?>
                                        <tr class="">
                                            <td ><?php echo $bill['bill_no']; ?></td>
                                            <td><?php echo $bill['date_of_issue']; ?></td>
                                            <td><?php echo $bill['patient_name']; ?></td>
                                            <td><?php echo $bill['bloodgroup']; ?></td>
                                            <td><?php echo $bill['donorname']; ?></td>
                                            <td><?php echo $bill['bag_no']; ?></td>
                                            <td class="text-right"><?php echo $bill['amount']; ?></td>
                                            <td class="">
                                                <a href="#" 
                                                   onclick="viewDetail('<?php echo $bill['id'] ?>')"
                                                   class="btn btn-default btn-xs"  data-toggle="tooltip"
                                                   title="<?php echo $this->lang->line('print'); ?>" >
                                                    <i class="fa fa-print"></i>
                                                </a> 
                                            </td>

                                        </tr>
                                        <?php
                                        $count++;
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>                                                    
            </div>
        </div>  
    </section>
</div>

<div class="modal fade" id="viewModal"  role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-toggle="tooltip" title="<?php echo $this->lang->line('clase'); ?>" data-dismiss="modal">&times;</button>
                <div class="modalicon"> 
                    <div id='edit_deletebill'>
                        <a href="#"  data-target="#edit_prescription"  data-toggle="modal" title="" data-original-title="<?php echo $this->lang->line('edit'); ?>"><i class="fa fa-pencil"></i></a>

                        <a href="#" data-toggle="tooltip" title="" data-original-title="<?php echo $this->lang->line('delete'); ?>"><i class="fa fa-trash"></i></a>
                    </div>
                </div>
                <h4 class="box-title"><?php echo $this->lang->line('bill') . " " . $this->lang->line('details'); ?></h4> 
            </div>
            <div class="modal-body pt0 pb0">
                <div id="reportdata"></div>
            </div>
        </div>
    </div>    
</div>
<script type="text/javascript">


    function viewDetail(id) {
        $.ajax({
            url: '<?php echo base_url() ?>patient/dashboard/getBillDetailsBloodbank/' + id,
            type: "GET",
            data: {id: id},
            success: function (data) {
                $('#reportdata').html(data);
                $('#edit_deletebill').html("<a href='#' data-toggle='tooltip' onclick='printData(" + id + ")'   data-original-title='<?php echo $this->lang->line('print'); ?>'><i class='fa fa-print'></i></a> ");
                holdModal('viewModal');
            },
        });
    }


    function holdModal(modalId) {
        $('#' + modalId).modal({
            backdrop: 'static',
            keyboard: false,
            show: true
        });
    }






</script>
