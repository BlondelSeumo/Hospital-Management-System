
<div class="col-sm-12 col-md-6 col-lg-6">
    <label><?php echo $this->lang->line('fee_schedule_based_charges'); ?></label> 
    <button type="button" class="plusign" onclick="same_to_all()"><?php echo $this->lang->line('apply_to_all'); ?></button>
    <div class="chargesborbg">
        <div class="form-group">
            <table class="printablea4">
                <?php foreach ($allCharge as $category) { ?>
                    <tr>
                    <input type="hidden" name="sid[]" 
                           value="<?php
                           if (!empty($category['id'])) {
                               echo $category['id'];
                           } else {
                               echo '0';
                           }
                           ?>">
                    <input type="hidden" id="schedule_charge_id[]" name="schedule_charge_id[]" value="<?php echo $category['org_id']; ?>">
                    <td class="col-sm-8" style="vertical-align: bottom; text-align: right; padding-right: 20px;"><?php echo $category['organisation_name']; ?></td>
                    <td class="col-sm-4"><input type="text"  class="edit_standard" name="schedule_charge[]"
                                                value="<?php
                                                if (!empty($category['org_charge'])) {
                                                    echo $category['org_charge'];
                                                } else {
                                                    echo '0';
                                                }
                                                ?>"></td>
                    </tr>
                <?php } ?>
            </table>
            <span class="text-danger"><?php echo form_error('schedule_charge'); ?></span>
        </div> 
    </div>  
</div>
<script type="text/javascript">
    function same_to_all() {
        var total = 0;
        var standard_charge = $("#standard").val();
        var schedule_charge = $('.edit_standard');
        for (var i = 0; i < schedule_charge.length; i++) {
            var inp = schedule_charge[i];
            inp.value = standard_charge;
        }
    }
</script>