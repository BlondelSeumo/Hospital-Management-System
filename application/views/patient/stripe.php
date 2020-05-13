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
                                   <!--  <td><?php echo $patient['ipd_no']; ?>
                                    </td> -->
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
                        <div class="row">
                            <div class=" col-md-offset-6 col-xs-6">
                                <p class="lead">Amount</p>

                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody><tr>
                                                <th style="width:50%"><?php echo $this->lang->line('balance') . " " . $this->lang->line('bill') . " " . $this->lang->line('amount') . " (" . $currency_symbol . ")"; ?></th>
                                                <td><?php echo $total ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo $this->lang->line('add') . " " . $this->lang->line('amount') . " (" . $currency_symbol . ")" ?></th>
                                                <td><?php echo $amount ?></td>
                                            </tr>


                                        </tbody></table>
                                </div>
                            </div>
                        </div>



                        <?php echo validation_errors(); ?>
                        <form class="paddtlrb" action="<?php echo site_url('patient/stripe/complete'); ?>" method="POST">
                        <!--data-description="<?php echo $payment_details; ?>"-->
                            <script
                                src="https://checkout.stripe.com/checkout.js" class="stripe-button pull-right"
                                data-key="<?php echo $api_publishable_key; ?>"
                                data-amount="<?php echo ($amount * 100); ?>"
                                data-name="<?php echo $hospital_name; ?>"
                                
                                data-image="<?php echo base_url('uploads/hospital_content/logo/' . $image); ?>"
                                data-locale="auto"
                                data-zip-code="true"
                                data-currency="<?php echo $currency; ?>"
                                >
                            </script>

                            <input type="hidden" name="total" value="<?php echo $amount; ?>">
                        </form>

                    </div><!-- /.box-body -->

                    <div class="box-footer">

                    </div>

                </div>

            </div><!--/.col (right) -->
        </div>   <!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
