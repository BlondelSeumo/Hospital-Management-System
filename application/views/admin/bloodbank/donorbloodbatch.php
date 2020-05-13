<div class="download_label"><?php echo $this->lang->line('blood') . " " . $this->lang->line('donor') . " " . $this->lang->line('details') . " " . $this->lang->line('list(varname)'); ?></div>
<table class="table table-striped table-bordered table-hover example" id="testreport" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th><?php echo $this->lang->line('institution'); ?></th>
            <th><?php echo $this->lang->line('lot'); ?></th>
            <th><?php echo $this->lang->line('bag_no'); ?></th>
            <th><?php echo $this->lang->line('quantity'), " " . $this->lang->line('in_ml'); ?></th>
            <th><?php echo $this->lang->line('donate'), " " . $this->lang->line('date'); ?></th>
            <th><?php echo $this->lang->line('action'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $count = 1;
        foreach ($result as $detail) {
            ?>
            <tr>
                <td><?php echo $detail->institution; ?></td>
                <td><?php echo $detail->lot; ?></td>
                <td><?php echo $detail->bag_no; ?></td>
                <td><?php echo $detail->quantity; ?></td>
                <td><?php echo date($this->customlib->getSchoolDateFormat(), strtotime($detail->donate_date)) ?></td>

                <td><a href="#" class="btn btn-default btn-xs" data-toggle="tooltip" title="<?php echo $this->lang->line('delete'); ?>"  onclick="deleteRecord('<?php echo $detail->id ?>')"><i class="fa fa-trash"></i></a></td>

            </tr>
            <?php
            $count++;
        }
        ?>
    </tbody>
</table>
<script type="text/javascript">
    $(document).ready(function () {
        $("#testreport").DataTable({
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

    function deleteRecord(id) {
        if (confirm('<?php echo $this->lang->line('delete_conform') ?>')) {
            $.ajax({
                url: '<?php echo base_url(); ?>admin/bloodbank/deleteDonorCycle/' + id,
                type: "POST",
                data: {id: id},
                dataType: 'json',
                success: function (data) {
                    successMsg('<?php echo $this->lang->line('delete_message') ?>');
                    viewDetail('<?php echo $id ?>');
                    //window.location.reload(true);
                }
            })
        }
    }
</script>