<form id="editward"  class="ptt10"  accept-charset="utf-8" enctype="multipart/form-data">
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <label for="exampleInputEmail1"><?php echo $this->lang->line('name'); ?></label>
                <input id="invoice_no" name="name" placeholder="" type="text" class="form-control"  value="<?php echo set_value('invoice_no', $ward_data['ward_name']); ?>" />
                <input id="ward_id" name="ward_id" placeholder="" type="hidden" class="form-control"  value="<?php echo $ward_data['id']; ?>" />

            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                <label for="exampleInputEmail1"><?php echo $this->lang->line('floor') ?></label> 

                <select autofocus="" id="fee_groups_id" name="floor_id" class="form-control" >
                    <option value=""><?php echo $this->lang->line('select'); ?></option>
                    <?php
                    foreach ($floor_list as $floors) {
                        ?>
                        <option value="<?php echo $floors['id'] ?>"<?php
                        if (set_value('floor_id', $ward_data['floor_id']) == $floors['id']) {
                            echo "selected =selected";
                        }
                        ?>><?php echo $floors['name'] ?></option>

                        <?php
                        // $count++;
                    }
                    ?>
                </select>

            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                <label for="exampleInputEmail1"><?php echo $this->lang->line('department') ?></label>

                <select autofocus="" name="department_id" class="form-control" >
                    <option value=""><?php echo $this->lang->line('select'); ?></option>
                    <?php
                    foreach ($dept_list as $value) {
                        ?>
                        <option value="<?php echo $value['id'] ?>"<?php
                        if (set_value('department_id', $ward_data['dep_id']) == $value['id']) {
                            echo "selected =selected";
                        }
                        ?>><?php echo $value['department_name'] ?></option>

                        <?php
                        //$count++;
                    }
                    ?>
                </select>
                <span class="text-danger"><?php echo form_error('fee_groups_id'); ?></span>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                <label for="exampleInputEmail1"><?php echo $this->lang->line('description'); ?></label>
                <textarea class="form-control" id="description" name="description" placeholder="" rows="2" placeholder="Enter ..."><?php echo set_value('description'); ?><?php echo set_value('description', $ward_data['description']) ?></textarea>

            </div>
        </div>
    </div><!-- /.box-body -->
    <div class="box-footer">
        <div class="pull-right paddA10">
            <button type="submit" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
        </div>
    </div>
</form>                  
<script type="text/javascript">
    $("#editward").on('submit', (function (e) {
        var id = $("#ward_id").val();
        e.preventDefault();
        $.ajax({
            url: '<?php echo base_url(); ?>admin/setup/ward/edit/' + id,
            type: "POST",
            data: new FormData(this),
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {

                //alert(data);
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
            },
            error: function () {
                alert("Fail")
            }
        });
    }));


</script>
