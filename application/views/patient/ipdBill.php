<?php
$currency_symbol = $this->customlib->getSchoolCurrencyFormat();
?>
<style type="text/css">
    .printablea4{width: 100%;}
    .printablea4>tbody>tr>th,
    .printablea4>tbody>tr>td{padding:2px 0; line-height: 1.42857143;vertical-align: top; font-size: 12px;}
</style>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title><?php echo $this->lang->line('bill'); ?></title>
    </head>
    <div id="html-2-pdfwrapper">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <div class="">
                    <!--table width="100%">
                    <?php
                    //echo "<pre>";
                    //print_r($result); 
                    ?>
                        <tr>
                            <td align="center">
                               <h3 style="margin: 0;"><?php
                    if (!empty($print_details[0]['print_header'])) {
                        echo $print_details[0]['print_header'];
                    }
                    ?></h3>
                            </td>
                        </tr>
                    </table-->
                    <div class="pprinta4">
                        <?php if (!empty($print_details[0]['print_header'])) { ?>
                            <img style="height:100px" class="img-responsive" src="<?php echo base_url() . $print_details[0]["print_header"] ?>">
                        <?php } ?>
                        <div style="height: 10px; clear: both;"></div>
                    </div>
                    <table width="100%" class="printablea4">
                        <tr>
                            <td align="text-left"><h5><?php echo $this->lang->line('bill') . " #" ?><?php echo $result["ipdid"] ?></h5></td>
                            <td align="right"><h5><?php echo $this->lang->line('date') . " : " ?><?php echo date($this->customlib->getSchoolDateFormat(true, true), strtotime($result['date'])) ?></h5></td>
                        </tr>
                    </table>
                    <hr style="height: 1px; clear: both;margin-bottom: 10px; margin-top: 10px">
                    <table class="printablea4" cellspacing="0" width="100%">
                        <tr>
                            <th width="25%"><?php echo $this->lang->line('name'); ?></th>
                            <td width="25%"><?php echo $result["patient_name"]; ?></td>
                            <th width="25%"><?php echo $this->lang->line('doctor'); ?></th>
                            <td width="25%"><?php echo $result["name"] . "" . $result["surname"]; ?></td>
                        </tr>
                        <tr>
                            <th><?php echo $this->lang->line('ipd') . " " . $this->lang->line('no'); ?></th>
                            <td><?php echo $result['ipd_no']; ?></td> 
                            <th><?php echo $this->lang->line('organisation'); ?></th>
                            <td><?php echo $result['organisation_name']; ?></td> 
                        </tr> 
                        <tr>
                            <th><?php echo $this->lang->line('admission') . " " . $this->lang->line('date'); ?></th>
                            <td><?php echo date($this->customlib->getSchoolDateFormat(true, true), strtotime($result['date'])); ?></td>
                            <?php if (!empty($result['discharge_date'])) { ?> 
                                <th><?php echo $this->lang->line('discharged') . " " . $this->lang->line('date'); ?></th>
                                <td><?php echo date($this->customlib->getSchoolDateFormat(), strtotime($result['discharge_date'])); ?></td> 
                            <?php } ?>
                        </tr> 
                    </table>
                    <hr style="height: 1px; clear: both;margin-bottom: 10px; margin-top: 10px">


                    <table class="printablea4" width="100%">
                        <tr>
                            <th width="16%" ><?php echo $this->lang->line('charges') . ' (' . $currency_symbol . ')'; ?> </th>
                            <th width="16%" ><?php echo $this->lang->line('category'); ?></th>
                            <th width="19%"><?php echo $this->lang->line('date'); ?></th> 
                            <th width="16%" class="pttright reborder text-right"><?php echo $this->lang->line('amount') . ' (' . $currency_symbol . ')'; ?> </th>
                        </tr>
                        <?php
                        $j = 0;
                        $total = 0;
                        foreach ($charges as $key => $charge) {
                            ?>
                            <tr>
                                <td><?php echo $charge["charge_type"]; ?></td> 
                                <td><?php echo $charge["charge_category"]; ?></td>
                                <td><?php echo date($this->customlib->getSchoolDateFormat(), strtotime($charge["created_at"])); ?></td>
                                <td class="pttright reborder text-right"><?php echo $charge["apply_charge"]; ?></td>
                            </tr>
                            <?php
                            $total += $charge["apply_charge"];
                            ?>

                            <?php
                            $j++;
                        }
                        ?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="text-right"><?php echo $this->lang->line('total') . " : " ?>  <?php echo $total ?></td>

                        </tr>
                    </table>
                    <hr style="height: 1px; clear: both;margin-bottom: 10px; margin-top: 10px">
                    <table class="printablea4" width="100%">
                        <tr>
                            <th width="20%" class=""><?php echo $this->lang->line('payment') . " " . $this->lang->line('mode'); ?></th>
                            <th width="16%" class=""><?php echo $this->lang->line('payment') . " " . $this->lang->line('date'); ?></th>
                            <th width="16%" class="text-right"><?php echo $this->lang->line('paid') . " " . $this->lang->line('amount') . ' (' . $currency_symbol . ')'; ?></th>
                        </tr>
                        <?php
                        $k = 0;
                        $total_paid = 0;
                        if ($result['status'] != 'paid') {
                            $status = $this->lang->line('unpaid');
                        } else {
                            $status = $this->lang->line('paid');
                        }
                        foreach ($payment_details as $key => $payment) {
                            ?>
                            <tr>
                                <td class="pttleft"><?php echo $payment["payment_mode"]; ?></td>
                                <td class=""><?php echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($payment['date'])); ?></td>
                                <td class="text-right"><?php echo $payment["paid_amount"]; ?></td>
                            </tr>
                            <?php
                            $total_paid += $payment["paid_amount"];
                        }
                        ?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td class="text-right"><?php echo $this->lang->line('total') . " : " ?> <?php echo $total_paid ?></td>
                        </tr>
                    </table>
                    <hr style="height: 1px; clear: both;margin-bottom: 10px; margin-top: 10px">  
                    <table class="printablea4" width="100%">
                        <tr>
                            <th width="20%"><?php echo $this->lang->line('total') . " " . $this->lang->line('charges') . " (" . $currency_symbol . ")" ?> </th> 
                            <td align="right"><?php echo $total; ?></td>
                        </tr>
                        <tr>
                            <th width="20%"><?php echo $this->lang->line('total') . " " . $this->lang->line('payment') . " (" . $currency_symbol . ")" ?> </th> 
                            <td align="right" width=""><?php
                                if (empty($result['paid_amount'])) {
                                    echo $paid_amount;
                                } else {
                                    echo $result['paid_amount'];
                                }
                                ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <hr style="height: 1px; clear: both;margin-bottom: 10px; margin-top: 10px">
                            </td>
                        </tr>
                        <tr>
                            <th width="20%"><?php echo $this->lang->line('gross') . " " . $this->lang->line('total') . " (" . $currency_symbol . ")" ?> </th> 
                            <td align="right"><?php
                                if (!empty($result['gross_total'])) {
                                    echo $result['gross_total'];
                                } else {
                                    echo $gross_total;
                                }
                                ?></td>
                        </tr>
                        <tr>
                            <th width="20%"><?php echo $this->lang->line('discount') . " (" . $currency_symbol . ")"; ?></th> 
                            <td align="right">
                                <input type="hidden" name="patient_id" value="<?php echo $result["id"] ?>">
                                <?php
                                if (!empty($result["discount"])) {
                                    echo $result["discount"];
                                } else {
                                    echo $discount;
                                }
                                ?></td>
                        </tr>

                        <tr>
                            <th width="30%"><?php echo $this->lang->line('any_other_charges') . " (" . $currency_symbol . ")"; ?></th> 
                            <td align="right"><?php
                                if (!empty($result["other_charge"])) {
                                    echo $result["other_charge"];
                                } else {
                                    echo $other_charge;
                                }
                                ?></td>
                        </tr>
                        <tr>
                            <th width="20%"><?php echo $this->lang->line('tax') . " (" . $currency_symbol . ")" ?></th> 
                            <td align="right"><?php
                                if (empty($result['tax'])) {
                                    echo $tax;
                                } else {
                                    echo $result['tax'];
                                }
                                ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <hr style="height: 1px; clear: both;margin-bottom: 10px; margin-top: 10px">
                            </td>
                        </tr>
                        <tr>
                            <th width="20%"><?php echo $this->lang->line('net_payable') . " " . $this->lang->line('amount') . " (" . $status . ")" ?></th> 
                            <td align="right"><?php
                                if (empty($result['net_amount'])) {
                                    echo $net_amount;
                                } else {
                                    echo $result['net_amount'];
                                }
                                ?></td>
                        </tr>

                    </table>
                    <hr style="height: 1px; clear: both;margin-bottom: 10px; margin-top: 10px">   
                    <p class="ptt10"><?php
                        if (!empty($print_details[0]['print_footer'])) {
                            echo $print_details[0]['print_footer'];
                        }
                        ?></p>
                </div>
            </div>
            <!--/.col (left) -->
        </div>
    </div>

</html>