<div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <?php $this->load->view('setting/sidebar'); ?>
            <div class="col-md-10">
                <!-- left column -->
                <form id="form1" action="<?php echo site_url('admin/notification/setting') ?>"  id="employeeform" name="employeeform" method="post" accept-charset="utf-8">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?php echo $this->lang->line('notification_setting'); ?></h3>
                        </div>
                        <div class="around10">
                            <?php if ($this->session->flashdata('msg')) { ?>
                                <?php echo $this->session->flashdata('msg') ?>
                            <?php } ?> 
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table class="table table-hover ">
                                <thead>
                                <th><?php echo $this->lang->line('event'); ?></th>
                                <th><?php echo $this->lang->line('option'); ?></th>
                                <th><?php echo $this->lang->line('sample_message'); ?></th>
                                </thead>
                                <tbody>

                                    <?php
                                    $content = array(
                                        $this->lang->line('opd_patient_registration') => $this->lang->line('opd_patient_registration_message'),
                                        $this->lang->line('ipd_patient_registration') => $this->lang->line('ipd_patient_registration_message'),
                                        $this->lang->line('opd') . " " . $this->lang->line('patient') . " " . $this->lang->line('revisit') => $this->lang->line('patient_revisit_message'),
                                        $this->lang->line('ipd') . " " . $this->lang->line('patient') . " " . $this->lang->line('discharged') => $this->lang->line('patient_discharged_message'),
                                        $this->lang->line('login_credential') => $this->lang->line('login_credential_message'),
                                        $this->lang->line('appointment') . " " . $this->lang->line('approved') => $this->lang->line('appointment_message')
                                    );



                                    $last_key = count($notificationMethods);
                                    $i = 1;
                                    foreach ($notificationMethods as $note_key => $note_value) {


                                        $mail_checked = "";
                                        $sms_checked = "";
                                        $post_back = checkExists($notificationlist, $note_key);
                                        if ($post_back) {
                                            $mail_checked = ($post_back['is_mail']) ? "checked=checked" : "";
                                            $sms_checked = ($post_back['is_sms']) ? "checked=checked" : "";
                                        }

                                        $hr = "";

                                        if ($i != $last_key) {
                                            $hr = "<hr>";
                                        }
                                        ?>

                                        <tr><td>
                                                <?php echo $note_value; ?>
                                            </td>
                                            <td width="20%"><label class="checkbox-inline">
                                                    <input type="checkbox" name="<?php echo $note_key ?>_mail" value="1" <?php echo $mail_checked; ?>> <?php echo $this->lang->line('email'); ?>
                                                </label>
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" name="<?php echo $note_key ?>_sms" value="1" <?php echo $sms_checked; ?>> <?php echo $this->lang->line('sms'); ?>
                                                </label></td>
                                            <td> <?php
                                                if (!empty($note_value)) {
                                                    echo $content[$note_value];
                                                }
                                                ?> <input type="hidden" name="key_array[]" value="<?php echo $note_key ?>"></td>
                                        </tr>     




                                        <?php
                                        // echo $hr;
                                        $i++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>  
                        <div class="box-footer">
                            <button type="submit" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                        </div>   
                </form>                 
            </div>

        </div>
</div><!--./wrapper-->

</section><!-- /.content -->
</div>

<?php

function checkExists($notificationlist, $key) {

    foreach ($notificationlist as $not_key => $not_value) {
        if ($not_value->type == $key) {
            return array(
                'is_mail' => $not_value->is_mail,
                'is_sms' => $not_value->is_sms
            );
        }
    }
    return false;
}
?>