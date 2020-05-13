<form id="editfloor_data"  class="ptt10"  accept-charset="utf-8" enctype="multipart/form-data">
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <label for="exampleInputEmail1"><?php echo $this->lang->line('name'); ?> <span class="req"> *</span></label>
                <input  name="name" placeholder="" type="text" class="form-control"  value="<?php echo set_value('name', $floor_data['name']); ?>" />
                <input id="floor_id" name="floor_id" placeholder="" type="hidden" class="form-control"  value="<?php echo $floor_data['id']; ?>" />

            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                <label for="exampleInputEmail1"><?php echo $this->lang->line('description'); ?></label>
                <textarea class="form-control" id="description" name="description" placeholder="" rows="2" placeholder="Enter ..."><?php echo set_value('description'); ?><?php echo set_value('description', $floor_data['description']) ?></textarea>

            </div>
        </div>

    </div><!-- /.box-body -->
    <div class="box-footer">
        <div class="pull-right">
            <button type="submit" id="editfloor_databtn"  data-loading-text="<?php echo $this->lang->line('processing') ?>" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
        </div>
    </div>


</form>                  
<script type="text/javascript">
    $("#editfloor_data").on('submit', (function (e) {
        var id = $("#floor_id").val();
        $("#editfloor_databtn").button('loading');
        e.preventDefault();
        $.ajax({
            url: '<?php echo base_url(); ?>admin/setup/floor/edit/' + id,
            type: "POST",
            data: new FormData(this),
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {

                // alert(data);
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
                $("#editfloor_databtn").button('reset');
            },

            error: function () {
                alert("Fail")

            }


        });

    }));


</script>
