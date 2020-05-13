<?php
$currency_symbol = $this->customlib->getSchoolCurrencyFormat();
?>
<form id="editexpense"  class="ptt10" method="post" accept-charset="utf-8" enctype="multipart/form-data">
    <div class="row">

        <?php if ($this->session->flashdata('msg')) { ?>
            <?php echo $this->session->flashdata('msg') ?>
        <?php } ?>
        <?php
        if (isset($error_message)) {
            echo "<div class='alert alert-danger'>" . $error_message . "</div>";
        }
        ?>   
        <?php echo $this->customlib->getCSRF(); ?> 
        <div class="col-sm-6">                      
            <div class="form-group">
                <label for="exampleInputEmail1"><?php echo $this->lang->line('expense_head'); ?></label><small class="req"> *</small>
                <select autofocus="" id="exp_head_id" name="exp_head_id" class="form-control" >
                    <option value=""><?php echo $this->lang->line('select'); ?></option>
                    <?php
                    foreach ($expheadlist as $exphead) {
                        ?>
                        <option value="<?php echo $exphead['id'] ?>"<?php
                        if ($expense['exp_head_id'] == $exphead['id']) {
                            echo "selected =selected";
                        }
                        ?>><?php echo $exphead['exp_category'] ?></option>
                                <?php
                                $count++;
                            }
                            ?>
                </select>
                <span class="text-danger"><?php echo form_error('exp_head_id'); ?></span>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="exampleInputEmail1"><?php echo $this->lang->line('name'); ?></label><small class="req"> *</small>
                <input id="name" name="name" placeholder="" type="text" class="form-control"  value="<?php echo set_value('name', $expense['name']); ?>" />
                <input id="expense_id"  type="hidden" class="form-control"  value="<?php echo $expense['id']; ?>" />

            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="exampleInputEmail1"><?php echo $this->lang->line('invoice_no'); ?></label>
                <input id="invoice_no" name="invoice_no" placeholder="" type="text" class="form-control"  value="<?php echo set_value('invoice_no', $expense['invoice_no']); ?>" />

            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="exampleInputEmail1"><?php echo $this->lang->line('date'); ?></label><small class="req"> *</small>
                <input id="editdate" name="date" placeholder="" type="text" class="form-control"  value="<?php echo set_value('date', date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($expense['date']))); ?>" readonly="readonly" />

            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="exampleInputEmail1"><?php echo $this->lang->line('amount') . " (" . $currency_symbol . ")"; ?></label><small class="req"> *</small>
                <input id="amount" name="amount" placeholder="" type="text" class="form-control"  value="<?php echo set_value('amount', $expense['amount']); ?>" />

            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="exampleInputEmail1"><?php echo $this->lang->line('attach_document'); ?></label>
                <input id="documents" name="documents" placeholder="" type="file" class="filestyle form-control"  value="<?php echo set_value('documents'); ?>" />
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                <label for="exampleInputEmail1"><?php echo $this->lang->line('description'); ?></label>
                <textarea class="form-control" id="description" name="description" placeholder="" rows="3" placeholder="Enter ..."><?php echo set_value('description'); ?><?php echo set_value('description', $expense['note']) ?></textarea>

            </div>
        </div>
    </div><!-- /.box-body -->
    <div class="row">
        <div class="box-footer">
            <div class="pull-right">
                <button type="submit" data-loading-text="<?php echo $this->lang->line('processing') ?>" id="editexpensebtn" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
            </div>
        </div>
    </div>    
</form>
<script type="text/javascript">
    $(document).ready(function () {
        $('.filestyle').dropify();
    });
    $(document).ready(function () {
        var date_format = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(), ['d' => 'dd', 'm' => 'mm', 'Y' => 'yyyy',]) ?>';
        $('#editdate').datepicker({

            format: date_format,
            endDate: '+0d',
            autoclose: true
        });
    });
    $(document).ready(function (e) {
        $("#editexpense").on('submit', (function (e) {
            $("#editexpensebtn").button('loading');

            var id = $("#expense_id").val();

            e.preventDefault();
            $.ajax({
                url: '<?php echo base_url(); ?>admin/expense/edit/' + id,
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
                    $("#editexpensebtn").button('reset');

                },
                error: function () {
                    alert("Fail")
                }
            });
        }));
    });
</script>