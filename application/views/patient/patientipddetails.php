<?php
$currency_symbol = $this->customlib->getSchoolCurrencyFormat();
$genderList = $this->customlib->getGender();
?>
<style type="text/css">
    .profile-user-img {
        margin: 0 auto;
        width: 100px;
        height: 100px;
    }
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
                        <h3 class="box-title titlefix"> <?php echo $this->lang->line('ipd') . " " . $this->lang->line('patient'); ?></h3>
                    </div>
                    <?php
                    if (isset($resultlist)) {
                        ?>
                        <div class="box-body">

                            <div class="download_label"><?php echo $this->lang->line('ipd') . " " . $this->lang->line('patient'); ?></div>

                            <table class="table table-striped table-bordered table-hover example" cellspacing="0" width="100%">
                                <thead>
                                    <tr>

                                        <th><?php echo $this->lang->line('name') ?></th>
                                        <th><?php echo $this->lang->line('ipd_no'); ?></th>
                                        <th><?php echo $this->lang->line('patient') . " " . $this->lang->line('id'); ?></th>
                                        <th><?php echo $this->lang->line('gender'); ?></th>
                                        <th><?php echo $this->lang->line('phone'); ?></th>
                                        <th><?php echo $this->lang->line('consultant'); ?></th>
                                        <th><?php echo $this->lang->line('bed'); ?></th>
                                        <th class="text-right"><?php echo $this->lang->line('charges') . " (" . $currency_symbol . ")"; ?></th>
                                        <th class="text-right"><?php echo $this->lang->line('payment') . " (" . $currency_symbol . ")"; ?></th>
                                        <th class="text-right"><?php echo $this->lang->line('due') . " " . $this->lang->line('payment') . " (" . $currency_symbol . ")"; ?></th>
                                        <th class="text-right"><?php echo $this->lang->line('credit_limit') . " (" . $currency_symbol . ")"; ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (empty($resultlist)) {
                                        ?>
                                        <?php
                                    } else {
                                        $count = 1;
                                        $class = "";
                                        foreach ($resultlist as $student) {

                                            $payment = $student["payment"];
                                            $credit_limit = $student["credit_limit"];
                                            $charge = $student["charges"];
                                            $bill = $student['charges'] - $student['payment'];
                                            if ($bill >= $credit_limit) {
                                                $color = "alert alert-danger";
                                            }
                                            ?>
                                            <tr class="<?php echo $class; ?>">

                                                <td>

                                                    <a href="<?php echo base_url(); ?>patient/dashboard/ipdprofile/<?php echo $student['ipdid']; ?>"><?php echo $student['patient_name']; ?></a>

                                                </td>
                                                <td><?php echo $student["ipd_no"] ?></td>
                                                <td><?php echo $student["patient_unique_id"] ?></td>
                                                <td><?php echo $student['gender']; ?></td>
                                                <td><?php echo $student['mobileno']; ?></td>
                                                <td><?php echo $student['name'] . " " . $student['surname']; ?></td>
                                                <td><?php echo $student['bed_name'] . " - " . $student['bedgroup_name'] . " - " . $student['floor_name']; ?></td>
                                                <td class="text-right"><?php echo $student['charges'] ?></td>
                                                <td class="text-right"><?php echo $student['payment'] ?></td>
                                                <td class="text-right"><?php echo $student['charges'] - $student['payment'] ?></td>
                                                <td class="text-right"><?php echo $student['credit_limit'] ?></td>
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
    </section>
</div>




<!-- revisit -->

<!-- dd -->



<!-- Modal -->


<script type="text/javascript">
    /*
     Author: mee4dy@gmail.com
     */
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
