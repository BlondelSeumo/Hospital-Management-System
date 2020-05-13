<?php
$currency_symbol = $this->customlib->getSchoolCurrencyFormat();
$genderList = $this->customlib->getGender();
?>
<style type="text/css">

    #easySelectable {/*display: flex; flex-wrap: wrap;*/}
    #easySelectable li {}
    #easySelectable li.es-selected {background: #2196F3; color: #fff;}
    .easySelectable {-webkit-user-select:none; -moz-user-select:none; -ms-user-select: none;}
</style>

<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title titlefix"> <?php echo $this->lang->line('operation_theatre') . " " . $this->lang->line('patient'); ?></h3>
                        <!--<div class="box-tools pull-right">
                               
                                <a data-toggle="modal" onclick="holdModal('myModal')" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> <?php echo $this->lang->line('add') . " " . $this->lang->line('patient'); ?></a> 
                           
                        </div> --> 
                    </div><!-- /.box-header -->
                    <?php
                    if (isset($resultlist)) {
                        ?>
                        <div class="box-body">
                            <div class="download_label"><?php echo $this->lang->line('operation_theatre') . " " . $this->lang->line('patient'); ?></div>
                            <table class="table table-striped table-bordered table-hover example" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('bill') . " " . $this->lang->line('no'); ?></th>
                                        <th><?php echo $this->lang->line('patient') . " " . $this->lang->line('name'); ?></th>
                                        <th><?php echo $this->lang->line('patient') . " " . $this->lang->line('id'); ?></th>
                                        <th><?php echo $this->lang->line('patient') . " " . $this->lang->line('type'); ?></th>
                                        <th><?php echo $this->lang->line('gender'); ?></th>
                                        <th><?php echo $this->lang->line('phone'); ?></th>
                                        <th><?php echo $this->lang->line('operation') . " " . $this->lang->line('name'); ?></th>
                                        <th><?php echo $this->lang->line('operation') . " " . $this->lang->line('type'); ?></th>
                                        <th><?php echo $this->lang->line('consultant'); ?></th>
                                        <th><?php echo $this->lang->line('operation') . " " . $this->lang->line('date'); ?></th>
                                        <th><?php echo $this->lang->line('applied') . " " . $this->lang->line('charge') . " (" . $currency_symbol . ")"; ?></th>
                                        <th class="text-right"><?php echo $this->lang->line('action') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (empty($resultlist)) {
                                        ?>

                                        <?php
                                    } else {
                                        $count = 1;
                                        foreach ($resultlist as $optpatient) {
                                            ?>
                                            <tr class="">
                                                <td><?php echo $optpatient['bill_no']; ?></td>
                                                <td><?php echo $optpatient['patient_name']; ?>
                                                </td>
                                                <td><?php echo $optpatient["patient_unique_id"] ?></td>
                                                <td><?php echo $this->lang->line($optpatient["customer_type"]) ?></td>
                                                <td><?php echo $optpatient['gender']; ?></td>
                                                <td><?php echo $optpatient['mobileno']; ?></td>
                                                <td><?php echo $optpatient['operation_name']; ?></td>
                                                <td><?php echo $optpatient['operation_type']; ?></td>
                                                <td><?php echo $optpatient['name'] . " " . $optpatient['surname']; ?></td>
                                                <td><?php echo date($this->customlib->getSchoolDateFormat(), strtotime($optpatient['date'])) ?></td>
                                                <td><?php echo $optpatient['apply_charge']; ?></td>
                                                <td class="pull-right">
                                                    <a href="#" 
                                                       onclick="viewDetailBill('<?php echo $optpatient['id']; ?>')"
                                                       class="btn btn-default btn-xs"  data-toggle="tooltip"
                                                       title="<?php echo $this->lang->line('print'); ?>" >
                                                        <i class="fa fa-print"></i>
                                                    </a> 
                                                </td>
                                            </tr>
                                            <?php
                                            $count++;
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } ?>
                </div>  
            </div>
        </div> 
    </section>
</div>

<div class="modal fade" id="viewModalBill"  role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-toggle="tooltip" title="<?php echo $this->lang->line('clase'); ?>" data-dismiss="modal">&times;</button>
                <div class="modalicon"> 
                    <div id='edit_deletebill'>
                        <a href="#"  data-target="#edit_prescription"  data-toggle="modal" title="" data-original-title="<?php echo $this->lang->line('edit'); ?>"><i class="fa fa-pencil"></i></a>

                        <a href="#" data-toggle="tooltip" title="" data-original-title="<?php echo $this->lang->line('delete'); ?>"><i class="fa fa-trash"></i></a>
                    </div>
                </div>
                <h4 class="box-title"><?php echo $this->lang->line('bill') . " " . $this->lang->line('details'); ?></h4> 
            </div>
            <div class="modal-body pt0 pb0">
                <div id="reportdataot"></div>
            </div>
        </div>
    </div>    
</div>  

<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class="modalicon"> 
                    <div id='edit_delete'>

                        <a href="#" data-toggle="tooltip" title="<?php echo $this->lang->line('edit'); ?>" ><i class="fa fa-pencil"></i></a>
                        <a href="#" data-toggle="tooltip" title="" data-original-title="<?php echo $this->lang->line('delete'); ?>"><i class="fa fa-trash"></i></a>
                    </div>
                </div>
                <h4 class="box-title"><?php echo $this->lang->line('operation') . " " . $this->lang->line('information'); ?></h4> 
            </div>
            <div class="modal-body pt0 pb0">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 paddlr">
                        <form id="view" accept-charset="utf-8" method="get" class="ptt10">
                            <div class="table-responsive">
                                <div class="col-md-6">
                                    <table class="printablea4 examples">
                                        <tr>
                                            <th><?php echo $this->lang->line('patient') . " " . $this->lang->line('name'); ?></th>
                                            <td><span id='patients_name'></span></td>



                                        </tr>
                                        <tr>

                                            <th><?php echo $this->lang->line('patient') . " " . $this->lang->line('id'); ?></th>
                                            <td><span id='patientsids'></span> (<span id='patient_type'></span>)</td>

                                        </tr>
                                        <tr>
                                            <th><?php echo $this->lang->line('opd_ipd_no'); ?></th>
                                            <td><span id="opd_ipd_no"></span>
                                            </td>

                                        </tr>
                                        <tr>
                                            <th><?php echo $this->lang->line('gender') ?></th>
                                            <td><span id="genderes"></span>
                                            </td>

                                        </tr>
                                        <tr>
                                            <th><?php echo $this->lang->line('age') ?></th>
                                            <td><span id="age_age"></span>

                                        </tr>
                                        <tr>
                                            <th><?php echo $this->lang->line('phone'); ?></th>
                                            <td><span id='mobileno'></span></td>

                                        </tr>

                                        <tr>
                                            <th><?php echo $this->lang->line('guardian_name') ?></th>
                                            <td><span id='guardians_name'></span></td>


                                        </tr>

                                        <tr>
                                            <th><?php echo $this->lang->line('address') ?></th>
                                            <td><span id='guardians_address'></span></td>

                                        </tr>

                                        <tr>

                                            <th><?php echo $this->lang->line('result'); ?></th>
                                            <td><span id='results'></span></td>

                                        </tr>                             
                                        <tr>
                                            <th><?php echo $this->lang->line('remarks'); ?></th>
                                            <td><span id="remarks"></span>
                                            </td>

                                            </td>
                                        </tr>

                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="printablea4 examples">
                                        <tr>
                                            <th><?php echo $this->lang->line('operation') . " " . $this->lang->line('name'); ?></th>
                                            <td><span id='operations_name'></span> (<span id="operations_type"></span>)</td>
                                        </tr>
                                        <tr>

                                            <th><?php echo $this->lang->line('operation') . " " . $this->lang->line('date') ?></th>
                                            <td><span id="date_s"></span>
                                            </td>
                                        </tr>
                                        <tr>                                  
                                            <th><?php echo $this->lang->line('consultant') . " " . $this->lang->line('doctor'); ?></th>
                                            <td><span id='cons_doctors'></span></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo $this->lang->line('assistent') . " " . $this->lang->line('consultant') . " " . '1'; ?></th>
                                            <td><span id="ass_consultants_1"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th><?php echo $this->lang->line('assistent') . " " . $this->lang->line('consultant') . " " . '2'; ?></th>
                                            <td><span id='ass_consultants_2'></span></td>

                                        </tr>
                                        <tr>

                                            <th><?php echo $this->lang->line('anesthetist'); ?></th>
                                            <td><span id="anesthetists"></span>
                                            </td>

                                        </tr>
                                        <tr>

                                            <th><?php echo $this->lang->line('anaethesia') . " " . $this->lang->line('type'); ?></th>
                                            <td><span id='anaethesia_types'></span></td>

                                        </tr>

                                        <tr>

                                            <th><?php echo $this->lang->line('ot') . " " . $this->lang->line('technician'); ?></th>
                                            <td><span id="ot_techniciandata"></span>
                                            </td>
                                        </tr>

                                        <tr>                                   
                                            <th><?php echo $this->lang->line('ot') . " " . $this->lang->line('assistent'); ?></th>
                                            <td><span id='ot_assistent'></span></td>                                   
                                        </tr>
                                        <tr>                                   
                                            <th><?php echo $this->lang->line('organisation'); ?></th>
                                            <td><span id="organisation_name"></span>
                                            </td>                               
                                        </tr>
                                        <tr>
                                        <tr>                                   
                                            <th><?php echo $this->lang->line('charge') . " " . $this->lang->line('category'); ?></th>
                                            <td><span id="charge_categorys"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th><?php echo $this->lang->line('code') . " (" . $this->lang->line('description') . ")"; ?></th>
                                            <td><span id='codes'></span>
                                                <span id="description"></span>
                                            </td>


                                        </tr>

                                        <th><?php echo $this->lang->line('applied') . " " . $this->lang->line('charge') . ' (' . $currency_symbol . ')'; ?></th>
                                        <td><span id='apply_chargeview'></span> (<span id="stdcharge"></span>)                                   
                                            </tr>
                                    </table>
                                </div>


                            </div>
                        </form>
                    </div>
                </div>
                <div id="reportdata"></div>
            </div>    
        </div>
    </div>
</div>

<script type="text/javascript">

    function viewDetailBill(id) {
        $.ajax({
            url: '<?php echo base_url() ?>patient/dashboard/getBillDetailsOt/' + id,
            type: "GET",
            data: {id: id},
            success: function (data) {
                $('#reportdataot').html(data);
                $('#edit_deletebill').html("<a href='#' data-toggle='tooltip' onclick='printData(" + id + ")'   data-original-title='<?php echo $this->lang->line('print'); ?>'><i class='fa fa-print'></i></a> ");
                holdModal('viewModalBill');
            },
        });
    }


    function viewDetail(id) {
        $.ajax({
            url: '<?php echo base_url(); ?>patient/dashboard/getDetailsOt',
            type: "POST",
            data: {patient_id: id},
            dataType: 'json',
            success: function (data) {
                $.ajax({
                    url: '<?php echo base_url(); ?>patient/dashboard/getConsultantBatch',
                    type: "POST",
                    data: {patient_id: id},
                    success: function (data) {
                        $('#reportdata').html(data);
                    },
                });
                console.log(data.opd_ipd_no);
                $("#patientsids").html(data.patient_unique_id);
                $("#admit_date").html(data.admission_date);
                $("#patients_name").html(data.patient_name);
                $("#genderes").html(data.gender);
                $("#age_age").html(data.age + " Year " + data.month + " Month");
                $("#guardians_name").html(data.guardian_name);
                $("#guardians_address").html(data.guardian_address);
                $("#date_s").html(data.date);
                $("#operations_name").html(data.operation_name);
                $("#operations_type").html(data.operation_type);
                $("#organisation_name").html(data.organisation_name);
                $("#cons_doctors").html(data.name + "\n" + data.surname);
                $("#ass_consultants_1").html(data.ass_consultant_1);
                $("#ass_consultants_2").html(data.ass_consultant_2);
                $("#anesthetists").html(data.anesthetist);
                $("#anaethesia_types").html(data.anaethesia_type);
                $("#ot_technicians").html(data.ot_technician);
                $("#ot_assistants").html(data.ot_assistant);
                $("#charge_categorys").html(data.charge_category);
                $("#codes").html(data.code);
                $("#opd_ipd_no").html(data.opd_ipd_no);
                $("#description").html("(" + data.description + ")");
                $("#stdcharge").html(data.standard_charge);
                $("#results").html(data.result);
                $("#remarks").html(data.remark);
                $("#patient_type").html(data.customer_type);
                $("#ot_assistent").html(data.ot_assistant);
                $("#ot_techniciandata").html(data.ot_technician);
                $("#apply_chargeview").html(data.apply_charge);
                $("#mobileno").html(data.mobileno);
                $('#edit_delete').html("");
                holdModal('viewModal');
            },
        })
    }


    function holdModal(modalId) {
        $('#' + modalId).modal({
            backdrop: 'static',
            keyboard: false,
            show: true
        });
    }


</script>

