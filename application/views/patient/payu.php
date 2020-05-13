<!-- Content Wrapper. Contains page content -->
<?php
$currency_symbol = $this->customlib->getSchoolCurrencyFormat();
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <!-- Main content -->
    <section class="content">
        <div class="row">

            <div class="col-md-12">
                <!-- Horizontal Form -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Payment Details</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table class="table table-striped mb0 font13">
                            <tbody>
                                <tr>
                                    <th class="bozero"><?php echo $this->lang->line('name'); ?></th>
                                    <td class="bozero"><?php echo $patient['patient_name'] ?></td>
                                    <th class="bozero"><?php echo $this->lang->line('patient') . " " . $this->lang->line('id'); ?></th>
                                    <td class="bozero"><?php echo $patient['patient_unique_id']; ?> </td>
                                </tr>
                                <tr>
                                    <th><?php echo $this->lang->line('gender'); ?></th>
                                    <td><?php echo $patient['gender']; ?></td>
                                    <th><?php echo $this->lang->line('marital_status'); ?></th>
                                    <td><?php echo $patient['marital_status']; ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo $this->lang->line('phone'); ?></th>
                                    <td><?php echo $patient['mobileno']; ?></td>
                                    <th><?php echo $this->lang->line('email'); ?></th>
                                    <td><?php echo $patient['email']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo $this->lang->line('age'); ?></th>
                                    <td>
                                        <?php echo $patient['age'] . " years " . $patient['month'] . " months"; ?>
                                    </td>
                                    <th><?php echo $this->lang->line('guardian_name'); ?></th>
                                    <td><?php echo $patient['guardian_name']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo $this->lang->line('credit_limit') . " (" . $currency_symbol . ")"; ?></th>
                                    <td><?php echo $patient['credit_limit']; ?>
                                    </td>
                                    <th><?php echo $this->lang->line('opd_ipd_no'); ?></th>
                                    <td><?php echo $patient['ipd_no']; ?>
                                    </td>
                                </tr>

                            </tbody>
                        </table>

                        <?php
                        $j = 0;
                        $total = 0;
                        foreach ($charges as $key => $charge) {
                            ?>


                            <?php
                            $total += $charge["apply_charge"];
                            ?>

                            <?php
                            $j++;
                        }
                        ?>
                        <hr>
                        <div class="row">
                            <div class=" col-md-offset-6 col-xs-6">
                                <p class="lead"><?php echo $this->lang->line('amount'); ?></p>

                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody><tr>
                                                <th style="width:50%"><?php echo $this->lang->line('balance') . " " . $this->lang->line('bill') . " " . $this->lang->line('amount') . " (" . $currency_symbol . ")"; ?></th>
                                                <td><?php echo $total ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo $this->lang->line('add') . " " . $this->lang->line('amount') . " (" . $currency_symbol . ")"; ?></th>
                                                <td><?php echo $amount ?></td>
                                            </tr>

                                        </tbody></table>
                                </div>
                                <form action="<?php echo $action; ?>" method="post"  name="payuForm" id="payuForm">

                                    <input type="hidden" name="key" value="<?php echo $MERCHANT_KEY ?>" />
                                    <input type="hidden" name="hash" value="<?php echo $hash ?>"/>
                                    <input type="hidden" name="txnid" value="<?php echo $txnid ?>" />
                                    <input type="hidden" name="amount" value="<?php echo set_value('amount', $amount) ?>" />
                                    <input type="hidden" name="firstname" id="firstname" value="<?php echo set_value('firstname', $patient['patient_name']); ?>" />
                                    <textarea name="productinfo" style="display:none"><?php echo set_value('productinfo', $productinfo); ?></textarea>
                                    <input type="hidden" name="surl" value="<?php echo set_value('surl', $surl); ?>" size="64" />
                                    <input type="hidden" name="furl" value="<?php echo set_value('furl', $furl); ?>" size="64" />
                                    <input type="hidden" name="service_provider" value="payu_paisa" size="64" />
                                    <div class="row">
                                        <div class="col-md-4">

                                            <div class="form-group">
                                                <label for="email"><?php echo $this->lang->line('email'); ?> <small class="req"> *</small></label> 
                                                <input type="text" class="form-control" name="email" id="email" value="<?php echo set_value('email', $patient['email']); ?>" />
                                                <span class="text-danger"><?php echo form_error('email'); ?></span>
                                            </div>

                                            <div class="form-group">
                                                <label for="pwd"><?php echo $this->lang->line('phone'); ?> <small class="req"> *</small></label>
                                                <input type="text" class="form-control" name="phone" value="<?php echo set_value('phone', $patient['mobileno']); ?>" />
                                                <span class="text-danger"><?php echo form_error('phone'); ?></span>
                                            </div>

                                        </div>
                                    </div>

                                    <?php if (!$hash) { ?>
                                        <button type="submit"  class="btn btn-primary submit_button"><i class="fa fa fa-money"></i> <?php echo $this->lang->line('make_payment') ?></button>
                                    <?php } ?>
                                </form>
                            </div>
                        </div>




                    </div><!-- /.box-body -->
                </div>

            </div><!--/.col (right) -->
        </div>   <!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<script type="text/javascript">
    $(window).load(function () {

        submitPayuForm();
    });
    function submitPayuForm() {

        var hash = '<?php echo $hash ?>';
        if (hash == '') {
            return;
        }
        $('form#payuForm').submit();
    }
</script>