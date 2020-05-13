<?php
$currency_symbol = $this->customlib->getSchoolCurrencyFormat();
?>
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-3">                
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <?php
                        $file = "no_image.png";
                        ?>
                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item listnoback">
                                <b><?php echo $this->lang->line('organisation') . " " . $this->lang->line('name'); ?></b> <a class="pull-right text-aqua"><?php echo $result['organisation_name']; ?></a>
                            </li>
                            <li class="list-group-item listnoback">
                                <b><?php echo $this->lang->line('code'); ?></b> <a class="pull-right text-aqua"><?php echo $result['code']; ?></a>
                            </li>
                            <li class="list-group-item listnoback">
                                <b><?php echo $this->lang->line('contact_no'); ?></b> <a class="pull-right text-aqua"><?php echo $result['contact_no']; ?></a>
                            </li>
                            <li class="list-group-item listnoback">
                                <b><?php echo $this->lang->line('address'); ?></b> <a class="pull-right text-aqua"><?php echo $result['address']; ?></a>
                            </li>
                            <li class="list-group-item listnoback">
                                <b><?php echo $this->lang->line('contact_person_name'); ?></b> <a class="pull-right text-aqua"><?php echo $result['contact_person_name']; ?></a>
                            </li>
                            <li class="list-group-item listnoback">
                                <b><?php echo $this->lang->line('contact_person_phone'); ?></b> <a class="pull-right text-aqua"><?php echo $result['contact_person_phone']; ?></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <?php
                        $j = 0;
                        foreach ($charge_type as $ckey => $value) {
                            ?>
                            <li class="<?php
                            if ($j == 0) {
                                echo "active";
                            }
                            ?>"><a href="#<?php echo $ckey ?>" data-toggle="tab" aria-expanded="true"><?php echo $value ?></a></li>
                                <?php
                                $j++;
                            }
                            ?>

                    </ul>

                    <div class="tab-content">
                        <?php
                        $i = 0;
                        foreach ($charge_type as $key => $value) {
                            ?>
                            <div class="tab-pane <?php
                            if ($i == 0) {
                                echo "active";
                            }
                            ?>" id="<?php echo $key ?>">
                                <div class="table-responsive">
                                    <div class="download_label"><?php echo $result['organisation_name'] . " " . $this->lang->line('charge') . " " . $this->lang->line('details'); ?></div>
                                    <table class="table table-striped table-bordered table-hover example" cellspacing="0" width="100%">
                                        <thead>
                                        <th><?php echo $this->lang->line('charge') . " " . $this->lang->line('category'); ?></th>
                                        <th><?php echo $this->lang->line('code'); ?></th>
                                        <th><?php echo $this->lang->line('description'); ?></th>
                                        <th class="text-right"><?php echo $this->lang->line('standard') . " " . $this->lang->line('charges') . " (" . $currency_symbol . ")"; ?></th>
                                        <th class="text-right"><?php echo $this->lang->line('organisation') . " " . $this->lang->line('charges') . " (" . $currency_symbol . ")"; ?></th>
                                        <th class="text-right"><?php echo $this->lang->line('action') ?></th>     
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (!empty($org[$key])) {
                                                foreach ($org[$key] as $keys => $orgvalue) {
                                                    ?>  
                                                    <tr>
                                                        <td><?php echo $orgvalue["charge_category"] ?></td>
                                                        <td><?php echo $orgvalue["code"] ?></td>
                                                        <td><?php echo $orgvalue["description"] ?></td>
                                                        <td class="text-right"><?php echo $orgvalue["standard_charge"] ?></td>
                                                        <td class="text-right"><?php echo $orgvalue["org_charge"] ?></td>
                                                        <td class="text-right editviewdelete-icon">
                                                            <?php if ($this->rbac->hasPrivilege('tpa_charges', 'can_edit')) { ?>
                                                                <a  href="#<?php echo $value ?>" data-toggle="tooltip" title="<?php echo $this->lang->line('edit'); ?>" onclick="get_org_charge('<?php echo $orgvalue["id"] ?>', 'edit_org_mad')" ><i class="fa fa-pencil"></i>
                                                                </a> 
                                                            <?php } if ($this->rbac->hasPrivilege('tpa_charges', 'can_delete')) { ?>
                                                                <a href="#" onclick="delete_recordById('<?php echo base_url('admin/tpa/delete/' . $orgvalue["id"] . '/'); ?><?php echo $orgvalue["org_id"] ?>', '<?php echo $this->lang->line('delete_message'); ?>')" data-toggle="tooltip" title="<?php echo $this->lang->line('delete'); ?>" ><i class="fa fa-trash"></i>
                                                                </a>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                            ?> 
                                        </tbody>
                                    </table>
                                </div> 
                            </div>
                            <?php
                            $i++;
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<div class="modal fade edit_org"  tabindex="-1" role="dialog" aria-labelledby="follow_up">
    <div class="modal-dialog modal-mid modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close"  data-dismiss="modal">&times;</button>
                <h4 class="box-title"><?php echo $this->lang->line('edit') . " " . $this->lang->line('organisation') . " " . $this->lang->line('charge'); ?></h4>
            </div>
            <div class="modal-body pt0 pb0" >
                <div class="table-responsive ptt10">
                    <form id="edit_org_form" method="POST" action="<?php echo base_url(); ?>admin/tpa/edit_org">               			                        
                </div> 
                <table class="table table-striped table-bordered">                     
                    <thead>
                    <th><?php echo $this->lang->line('charge') . " " . $this->lang->line('category'); ?></th>
                    <th><?php echo $this->lang->line('code'); ?></th>
                    <th><?php echo $this->lang->line('description'); ?></th>

                    <th class="text-right"><?php echo $this->lang->line('standard') . " " . $this->lang->line('charge') . " (" . $currency_symbol . ")"; ?></th>
                    <th class="text-right"><?php echo $this->lang->line('organisation') . " " . $this->lang->line('charge') . " (" . $currency_symbol . ")"; ?></th>       
                    </thead>
                    <tbody>
                        <tr>
                            <td id="charge_category_html"></td>
                            <td id="code_html"></td>
                            <td id="charge_data"></td>
                            <td class="text-right" id="standard_charge_data"></td>
                            <td class="text-right">                                                
                                <input type="text" name="org_charge" id="org_charge_data" class="form-control text-right">
                                <input type="hidden" name="org_charge_id" id="org_charge_id_data" class="form-control">                                               
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="box-footer clear">
                <div class="pull-right">
                    <button type="submit" id="edit_org_btn" data-loading-text="<?php echo $this->lang->line('processing') ?>"  class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    function get_org_charge(id, modal_id) {
        $.ajax({
            url: '<?php echo base_url(); ?>admin/tpa/get_org_charge/' + id,
            dataType: 'json',
            success: function (res) {
                $('.edit_org').attr("id", modal_id);
                $('#' + modal_id).modal('show');
                $('#org_charge_id_data').val(res.org_charge_id);
                $('#charge_data').html('<label>' + res.description + '</label>');
                $('#charge_category_html').html('<label>' + res.charge_category + '</label>');
                $('#code_html').html('<label>' + res.code + '</label>');
                $('#standard_charge_data').html('<label>' + res.standard_charge + '</label>');
                $('#org_charge_data').val(res.org_charge);
            }
        });
    }
    $(document).ready(function (e) {
        $('#edit_org_form').on('submit', (function (e) {
            $("#edit_org_btn").button('loading');
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
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
                    $("#edit_org_btn").button('reset');
                },
                error: function () {}
            });
        }));
    });

    $(document).ready(function (e) {
        var date_format = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(), ['d' => 'dd', 'm' => 'mm', 'Y' => 'yyyy',]) ?>';
        $('#timeline_date').datepicker({
            format: date_format,
            autoclose: true
        });
    });

    $(document).ready(function (e) {

        $(function () {
            var hash = window.location.hash;
            hash && $('ul.nav-tabs a[href="' + hash + '"]').tab('show');

            $('.nav-tabs a').click(function (e) {
                $(this).tab('show');
                var scrollmem = $('body').scrollTop();
                window.location.hash = this.hash;
                $('html,body').scrollTop(scrollmem);
            });
        });


    });
</script>

