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
                        <h3 class="box-title titlefix"> <?php echo $this->lang->line('ipd') . " " . $this->lang->line('discharged') . " " . $this->lang->line('patient'); ?></h3>

                        <div class="box-tools pull-right">

                        </div>    
                    </div><!-- /.box-header -->

                    <?php
                    if (isset($resultlist)) {
                        ?>
                        <div class="box-body">
                            <div class="download_label"> <?php echo $this->lang->line('ipd') . " " . $this->lang->line('discharged') . " " . $this->lang->line('patient'); ?></div>

                            <table class="table table-striped table-bordered table-hover example" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('name') ?></th>
                                        <th><?php echo $this->lang->line('patient') . " " . $this->lang->line('id'); ?></th>

                                        <th><?php echo $this->lang->line('gender'); ?></th>
                                        <th><?php echo $this->lang->line('phone'); ?></th>
                                        <th><?php echo $this->lang->line('consultant') ?></th>

                                        <th><?php echo $this->lang->line('admission') . " " . $this->lang->line('date') ?></th>
                                        <th><?php echo $this->lang->line('discharged') . " " . $this->lang->line('date') ?></th>
                                        <th class="text-right" ><?php echo $this->lang->line('charges') . " (" . $currency_symbol . ")"; ?></th>
                                        <th class="text-right" ><?php echo $this->lang->line('other') . " " . $this->lang->line('charges') . " (" . $currency_symbol . ")" ?></th>
                                        <th class="text-right"><?php echo $this->lang->line('tax') . " (" . $currency_symbol . ")" ?></th>
                                        <th class="text-right"><?php echo $this->lang->line('discount') . " (" . $currency_symbol . ")" ?></th>
                                        <th class="text-right"><?php echo $this->lang->line('paid') . " " . $this->lang->line('amount') . " (" . $currency_symbol . ")" ?></th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (empty($resultlist)) {
                                        ?>

                                        <?php
                                    } else {
                                        $count = 1;
                                        foreach ($resultlist as $student) {
                                            // echo "<pre>";
                                            // print_r($student);
                                            ?>
                                            <tr class="">

                                                <td><a href="<?php echo base_url(); ?>admin/patient/ipdprofile/<?php echo $student['id']; ?>/<?php echo $student['ipdid']; ?>"><?php echo $student['patient_name']; ?></a>
                                                    <div class="rowoptionview">       
                                                        <a href="<?php echo base_url(); ?>admin/patient/ipdprofile/<?php echo $student['id']; ?>/<?php echo $student['ipdid']; ?>" class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('show'); ?>" >
                                                            <i class="fa fa-reorder"></i>
                                                        </a>

                                                    </div>  
                                                </td>
                                                <td><?php echo $student["patient_unique_id"] ?></td>
                                                <td><?php echo $student['gender']; ?></td>
                                                <td><?php echo $student['mobileno']; ?></td>
                                                <td><?php echo $student['name'] . " " . $student['surname']; ?></td>
                                                <td><?php echo date($this->customlib->getSchoolDateFormat(true, true), strtotime($student['date'])) ?></td>
                                                <td><?php echo date($this->customlib->getSchoolDateFormat(), strtotime($student['discharge_date'])) ?></td>
                                                <td class="text-right"><?php echo $student['charges'] ?></td>
                                                <td class="text-right"><?php echo $student['other_charge'] ?></td>
                                                <td class="text-right"><?php echo $student['tax'] ?></td>
                                                <td class="text-right"><?php echo $student['discount'] ?></td>
                                                <td class="text-right"><?php echo $student['net_amount'] ?></td>
                                            </tr>
                                            <?php
                                            $count++;
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <?php
                    }
                    ?>
                </div>  
            </div>
        </div> 
    </section>
</div>


<script type="text/javascript">
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()
    });
    $(function () {
        $('#easySelectable').easySelectable();
//stopPropagation();
    })
</script>


<script type="text/javascript">

            (function ($) {
                //selectable html elements
                $.fn.easySelectable = function (options) {
                    var el = $(this);
                    var options = $.extend({
                        'item': 'li',
                        'state': true,
                        onSelecting: function (el) {

                        },
                        onSelected: function (el) {

                        },
                        onUnSelected: function (el) {

                        }
                    }, options);
                    el.on('dragstart', function (event) {
                        event.preventDefault();
                    });
                    el.off('mouseover');
                    el.addClass('easySelectable');
                    if (options.state) {
                        el.find(options.item).addClass('es-selectable');
                        el.on('mousedown', options.item, function (e) {
                            $(this).trigger('start_select');
                            var offset = $(this).offset();
                            var hasClass = $(this).hasClass('es-selected');
                            var prev_el = false;
                            el.on('mouseover', options.item, function (e) {
                                if (prev_el == $(this).index())
                                    return true;
                                prev_el = $(this).index();
                                var hasClass2 = $(this).hasClass('es-selected');
                                if (!hasClass2) {
                                    $(this).addClass('es-selected').trigger('selected');
                                    el.trigger('selected');
                                    options.onSelecting($(this));
                                    options.onSelected($(this));
                                } else {
                                    $(this).removeClass('es-selected').trigger('unselected');
                                    el.trigger('unselected');
                                    options.onSelecting($(this))
                                    options.onUnSelected($(this));
                                }
                            });
                            if (!hasClass) {
                                $(this).addClass('es-selected').trigger('selected');
                                el.trigger('selected');
                                options.onSelecting($(this));
                                options.onSelected($(this));
                            } else {
                                $(this).removeClass('es-selected').trigger('unselected');
                                el.trigger('unselected');
                                options.onSelecting($(this));
                                options.onUnSelected($(this));
                            }
                            var relativeX = (e.pageX - offset.left);
                            var relativeY = (e.pageY - offset.top);
                        });
                        $(document).on('mouseup', function () {
                            el.off('mouseover');
                        });
                    } else {
                        el.off('mousedown');
                    }
                };
            })(jQuery);

</script>

