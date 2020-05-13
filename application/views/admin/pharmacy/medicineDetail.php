<?php
$currency_symbol = $this->customlib->getSchoolCurrencyFormat();
?>
<div class="nav-tabs-custom border0" id="tabs">

    <ul class="nav nav-tabs">

        <?php if ($this->rbac->hasPrivilege('add_medicine_stock', 'can_view')) { ?>
            <li class="active">
                <a href="#current_stock"  data-toggle="tab" aria-expanded="true"><?php echo $this->lang->line('stock'); ?></a>
            </li>
        <?php } if ($this->rbac->hasPrivilege('medicine_bad_stock', 'can_view')) { ?>
            <li class="">
                <a href="#bad_stock"  data-toggle="tab" aria-expanded="true"><?php echo $this->lang->line('bad') . " " . $this->lang->line('stock'); ?></a>
            </li>
        <?php } ?>
    </ul>    
    <div class="tab-content">
        <?php if ($this->rbac->hasPrivilege('add_medicine_stock', 'can_view')) { ?>
            <div class="tab-pane active" id="current_stock">   
                <table class="table table-striped table-bordered table-hover example" id="detail" cellspacing="0" width="100%" >
                    <thead>
                        <tr>
                            <th><?php echo $this->lang->line('inward') . " " . $this->lang->line('date'); ?></th>
                            <th><?php echo $this->lang->line('batch') . " " . $this->lang->line('no'); ?></th>

                            <th><?php echo $this->lang->line('expire') . " " . $this->lang->line('date'); ?></th>
                            <th class="text-right"><?php echo $this->lang->line('packing') . " " . $this->lang->line('qty') . " (" . $currency_symbol . ")"; ?></th>
                            <th class="text-right"><?php echo $this->lang->line('purchase_rate') . " (" . $currency_symbol . ")"; ?></th>
                            <th class="text-right"><?php echo  $this->lang->line('amount') . ' (' . $currency_symbol . ')'; ?></th>
                            <th class="text-right"><?php echo $this->lang->line('quantity'); ?></th>
                            <th class="text-right"><?php echo $this->lang->line('mrp') . ' (' . $currency_symbol . ')'; ?></th>
                            <th class="text-right"><?php echo $this->lang->line('sale_price') . ' (' . $currency_symbol . ')'; ?></th>
                            <th class="text-right"><?php echo $this->lang->line('action'); ?></th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $count = 1;
                        foreach ($result as $detail) {
                            ?>
                            <tr>
                                <td><?php echo date($this->customlib->getSchoolDateFormat(), strtotime($detail->inward_date)); ?></td>
                                <td ><?php echo $detail->batch_no ?></td>
                                <td><?php echo $detail->expiry_date ?></td>
                                <td class="text-right"><?php echo $detail->packing_qty ?></td>
                                <td class="text-right"><?php echo $detail->purchase_price ?></td>
                                <td class="text-right"><?php echo $detail->amount; ?></td>
                                <td class="text-right"><?php echo $detail->quantity ?></td>
                                <td class="text-right"><?php echo $detail->mrp; ?> </td>
                                <td class="text-right"><?php echo $detail->sale_rate; ?></td>

                                <td class="text-right"><?php if ($this->rbac->hasPrivilege('add_medicine_stock', 'can_delete')) { ?><a href="#" class="btn btn-default btn-xs" data-toggle="tootip" title="<?php echo $this->lang->line('delete'); ?>" onclick="delete_batch('<?php echo $detail->id ?>', '<?php echo $detail->pharmacy_id ?>')"><i class="fa fa-trash"></i></a><?php } ?></td>
                            </tr>
                            <?php
                            $count++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        <?php } if ($this->rbac->hasPrivilege('medicine_bad_stock', 'can_view')) { ?>
            <div class="tab-pane" id="bad_stock">   
                <table class="table table-striped table-bordered table-hover example" cellspacing="0" width="100%" >
                    <thead>
                        <tr>
                            <th><?php echo $this->lang->line('outward') . " " . $this->lang->line('date'); ?></th>
                            <th><?php echo $this->lang->line('batch') . " " . $this->lang->line('no'); ?></th>

                            <th><?php echo $this->lang->line('expire') . " " . $this->lang->line('date'); ?></th>
                            <th class="text-right"><?php echo $this->lang->line('quantity'); ?></th>

                            <th class="text-right"><?php echo $this->lang->line('action'); ?></th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $count = 1;
                        // if(!empty($badstockresult)){
                        foreach ($badstockresult as $stockdetail) {
                            ?>
                            <tr>
                                <td><?php echo date($this->customlib->getSchoolDateFormat(), strtotime($stockdetail->outward_date)); ?></td>
                                <td ><?php echo $stockdetail->batch_no ?></td>
                                <td><?php echo $stockdetail->expiry_date ?></td>
                                <td class="text-right"><?php echo $stockdetail->quantity ?></td>
                                <td class="text-right"><?php if ($this->rbac->hasPrivilege('medicine_bad_stock', 'can_delete')) { ?> <a href="#" class="btn btn-default btn-xs" data-toggle="tootip" title="<?php echo $this->lang->line('delete'); ?>" onclick="delete_badstock('<?php echo $stockdetail->id ?>', '<?php echo $stockdetail->pharmacy_id ?>')"><i class="fa fa-trash"></i></a><?php } ?></td>
                            </tr>
                            <?php
                        } //}
                        ?>
                    </tbody>
                </table>
            </div>
        <?php } ?>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#detail").DataTable({
                dom: "Bfrtip",
                buttons: [
                    {
                        extend: 'copyHtml5',
                        text: '<i class="fa fa-files-o"></i>',
                        titleAttr: 'Copy',
                        title: $('.download_label').html(),
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fa fa-file-excel-o"></i>',
                        titleAttr: 'Excel',

                        title: $('.download_label').html(),
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'csvHtml5',
                        text: '<i class="fa fa-file-text-o"></i>',
                        titleAttr: 'CSV',
                        title: $('.download_label').html(),
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fa fa-file-pdf-o"></i>',
                        titleAttr: 'PDF',
                        title: $('.download_label').html(),
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'print',
                        text: '<i class="fa fa-print"></i>',
                        titleAttr: 'Print',
                        title: $('.download_label').html(),
                        customize: function (win) {
                            $(win.document.body)
                                    .css('font-size', '10pt');

                            $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                        },
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'colvis',
                        text: '<i class="fa fa-columns"></i>',
                        titleAttr: 'Columns',
                        title: $('.download_label').html(),
                        postfixButtons: ['colvisRestore']
                    },
                ]
            });
        });

        function delete_batch(id, pharmacy_id) {
            // alert(id);
            // alert(pharmacy_id);
            if (confirm('Are you sure')) {
                $.ajax({
                    url: '<?php echo base_url(); ?>admin/pharmacy/delete_medicine_batch/' + id,
                    type: "POST",
                    data: {opdid: ''},
                    dataType: 'json',
                    success: function (data) {

                        if (data.status == 'success') {

                            viewDetail(pharmacy_id, id);

                        } else {

                        }
                    }
                })
            }
        }

        function delete_badstock(id, pharmacy_id) {
            // alert(id);
            // alert(pharmacy_id);
            if (confirm('Are you sure')) {
                $.ajax({
                    url: '<?php echo base_url(); ?>admin/pharmacy/deleteBadStock/' + id,
                    type: "POST",
                    data: {opdid: ''},
                    dataType: 'json',
                    success: function (data) {

                        if (data.status == 'success') {

                            viewDetail(pharmacy_id, id);

                        } else {

                        }
                    }
                })
            }
        }
    </script>

