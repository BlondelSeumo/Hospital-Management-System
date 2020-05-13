<table class="table table-striped table-bordered table-hover example" id="testreport" cellspacing="0" width="100%" >
    <thead>
        <tr>
            <th><?php echo $this->lang->line('applied') . " " . $this->lang->line('date'); ?></th>
            <th><?php echo $this->lang->line('instruction') . " " . $this->lang->line('date'); ?></th>
            <th><?php echo $this->lang->line('consultant') . " " . $this->lang->line('doctor'); ?></th>
            <th><?php echo $this->lang->line('instruction'); ?></th>
          <!--  <th class="text-right"><?php echo $this->lang->line('action'); ?></th>-->
        </tr>
    </thead>
    <tbody>
        <?php
        $count = 1;
        foreach ($result as $detail) {
            ?>
            <tr>
                <td><?php echo date($this->customlib->getSchoolDateFormat(true, true), strtotime($detail->date)) ?></td>
                <td><?php echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($detail->ins_date)); ?></td>
                <td><?php echo $detail->name . " " . $detail->surname; ?></td>
                <td><?php echo $detail->instruction; ?></td>
               <!-- <td class="text-right">
                <?php if ($detail->consultant == 'yes') { ?>
                            <a href="#" data-toggle="tooltip" class="btn btn-default btn-xs" title="<?php echo $this->lang->line('delete'); ?>" onclick="deleteRecord('<?php echo $detail->id ?>')"><i class="fa fa-trash"></i></a>
                <?php } ?>
                </td>-->
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
                url: '<?php echo base_url(); ?>admin/operationtheatre/deleteConsultant/' + id,
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

