<form id="editbedtype"  class="ptt10"  accept-charset="utf-8" enctype="multipart/form-data">
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <label for="exampleInputEmail1"><?php echo $this->lang->line('name'); ?></label>
                <input  name="name" placeholder="" type="text" class="form-control"  value="<?php echo set_value('name', $bedtype_data['name']); ?>" />
                <input id="bedtype_id" name="bedtype_id" placeholder="" type="hidden" class="form-control"  value="<?php echo $bedtype_data['id']; ?>" />

            </div>
        </div>

    </div><!-- /.box-body -->
    <div class="box-footer">
        <div class="pull-right">
            <button type="submit" id="editbedtypebtn" data-loading-text="<?php echo $this->lang->line('processing') ?>" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
        </div>
    </div>


</form>                  
<script type="text/javascript">
    $("#editbedtype").on('submit', (function (e) {
        $("#editbedtypebtn").button('loading');
        var id = $("#bedtype_id").val();
        e.preventDefault();
        $.ajax({
            url: '<?php echo base_url(); ?>admin/setup/bedtype/edit/' + id,
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
                $("#editbedtypebtn").button('reset');
            },

            error: function () {
                alert("Fail")

            }


        });

    }));


</script>
