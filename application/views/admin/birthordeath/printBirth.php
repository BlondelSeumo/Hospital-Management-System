<?php
$currency_symbol = $this->customlib->getSchoolCurrencyFormat();
?>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title><?php echo $this->lang->line('birth_record'); ?></title>
        <style type="text/css">
            body{font-size: 12px;}
            .printablea4{width: 100%;}

            .printablea4 table tr th,
            .printablea4 table tr td{vertical-align: top; font-size: 12px;}
        </style>
    </head>
    <div id="html-2-pdfwrapper">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <div class="">
                    <?php if (!empty($print_details[0]['print_header'])) { ?>
                        <div class="pprinta4">
                            <img src="<?php
                            if (!empty($print_details[0]['print_header'])) {
                                echo base_url() . $print_details[0]['print_header'];
                            }
                            ?>" class="img-responsive" style="height:100px; width: 100%;">
                        </div>
                    <?php } ?>
                    <table width="100%" class="printablea4">
                        <tr>
                            <td style="padding-top: 5px; font-size: 12px;"><?php echo $this->lang->line('sr_no')." ".$result['ref_no']; ?></td>
                            <td style="padding-top: 5px; text-align: right;font-size: 12px;" align="result"><?php echo $this->lang->line('birth_date') . " : "; ?><?php echo date($this->customlib->getSchoolDateFormat(true, true), strtotime($result['birth_date'])) ?>
                            </td>
                        </tr>
                    </table>
                    <hr style="height: 1px; clear: both;margin-bottom: 10px; margin-top: 10px">
                    <table class="printablea4" cellspacing="0" cellpadding="0" width="100%">
                        <tr>
                            <td>
                                <table cellspacing="0" cellpadding="0" width="100%">
                                    <tr>
                                        <th width="20%"><?php echo $this->lang->line('child') . " " . $this->lang->line('name'); ?></th>
                                        <td width="25%" ><?php echo $result["child_name"]; ?></td>
                                    </tr>
                                    <tr>
                                        <th valign="top" width="20%"><?php echo $this->lang->line('gender'); ?></th>
                                        <td valign="top" width="25%"><?php echo $result["gender"]; ?></td>
                                        <th valign="top" width="25%"><?php echo $this->lang->line('weight'); ?></th>
                                        <td valign="top" width="30%" align="left"><?php echo $result['weight']; ?></td> 
                                    </tr> 
                                    <tr>
                                        <th width="25%"><?php echo $this->lang->line('mother_name'); ?></th>
                                        <td width="30%" align="left"><?php echo $result["patient_name"]; ?></td>
                                        <th width="20%"><?php echo $this->lang->line('father_name'); ?></th>
                                        <td width="25%"><?php echo $result["father_name"]; ?></td>
                                    </tr>

                                    <tr>

                                        <th width="25%"><?php echo $this->lang->line('address'); ?></th>
                                        <td width="30%" align="left"><?php echo $result['address']; ?></td> 
                                    </tr> 
                                </table>
                            </td> 
                            <td align="right" valign="top" width="20%">
                                <?php
                                $picdemo = "uploads/patient_images/no_image.png";
                                if ($result['child_pic'] !== $picdemo) {
                                    ?>
                                    <img  style="height: 60px;" class="" src="<?php echo base_url() . $result['child_pic'] ?>" id="image" alt="User profile picture">
                                <?php } ?>      
                            </td>   
                        </tr>

                    </table>
                    <hr style="height: 1px; clear: both;margin-bottom: 10px; margin-top: 10px">
                    <table class="printablea4" cellspacing="0" cellpadding="0" width="100%">

                        <?php
                        //$customid=8;
                        $cutom_fields_data = get_custom_table_values($result['id'], 'birth_report');
                        if (!empty($cutom_fields_data)) {
                            foreach ($cutom_fields_data as $field_key => $field_value) {
                                ?>
                                <tr>
                                    <th style="font-size: 13px;"><?php echo $field_value->name; ?></th>
                                    <td style="font-size: 13px;">
                                        <?php
                                        if (is_string($field_value->field_value) && is_array(json_decode($field_value->field_value, true)) && (json_last_error() == JSON_ERROR_NONE)) {
                                            $field_array = json_decode($field_value->field_value);
                                            echo "<ul class=''>";
                                            foreach ($field_array as $each_key => $each_value) {
                                                echo "<li>" . $each_value . "</li>";
                                            }
                                            echo "</ul>";
                                        } else {
                                            $display_field = $field_value->field_value;

                                            if ($field_value->type == "link") {
                                                $display_field = "<a href=" . $field_value->field_value . " target='_blank'>" . $field_value->field_value . "</a>";
                                            }
                                            echo $display_field;
                                        }
                                        ?>
                                    </td> 
                                </tr>

                                <?php
                            }
                        }
                        ?>
                    </table>



                    <hr style="height: 1px; clear: both;margin-bottom: 10px; margin-top: 10px">    
                    <p><?php
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
<script type="text/javascript">
    function delete_bill(id) {
        if (confirm('<?php echo $this->lang->line('delete_conform') ?>')) {
            $.ajax({
                url: '<?php echo base_url(); ?>admin/pharmacy/deletePharmacyBill/' + id,
                success: function (res) {
                    successMsg('<?php echo $this->lang->line('delete_message'); ?>');
                    window.location.reload(true);
                },
                error: function () {
                    alert("Fail")
                }
            });
        }
    }
    function printData(id) {

        var base_url = '<?php echo base_url() ?>';
        $.ajax({
            url: base_url + 'admin/pharmacy/getBillDetails/' + id,
            type: 'POST',
            data: {id: id, print: 'yes'},
            success: function (result) {
                // $("#testdata").html(result);
                popup(result);
            }
        });
    }

    function popup(data)
    {
        var base_url = '<?php echo base_url() ?>';
        var frame1 = $('<iframe />');
        frame1[0].name = "frame1";
        frame1.css({"position": "absolute", "top": "-1000000px"});
        $("body").append(frame1);
        var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
        frameDoc.document.open();
        //Create a new HTML document.
        frameDoc.document.write('<html>');
        frameDoc.document.write('<head>');
        frameDoc.document.write('<title></title>');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/bootstrap/css/bootstrap.min.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/dist/css/font-awesome.min.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/dist/css/ionicons.min.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/dist/css/AdminLTE.min.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/dist/css/skins/_all-skins.min.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/plugins/iCheck/flat/blue.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/plugins/morris/morris.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/plugins/jvectormap/jquery-jvectormap-1.2.2.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/plugins/datepicker/datepicker3.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/plugins/daterangepicker/daterangepicker-bs3.css">');
        frameDoc.document.write('</head>');
        frameDoc.document.write('<body>');
        frameDoc.document.write(data);
        frameDoc.document.write('</body>');
        frameDoc.document.write('</html>');
        frameDoc.document.close();
        setTimeout(function () {
            window.frames["frame1"].focus();
            window.frames["frame1"].print();
            frame1.remove();
        }, 500);
        return true;
    }
</script>