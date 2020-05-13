
<table class="table table-striped table-bordered table-hover" id="attendancetable">
    <thead>
        <tr>
            <th>
                <?php echo $this->lang->line('date') . " | " . $this->lang->line('month'); ?>
            </th>
            <?php foreach ($monthlist as $monthkey => $monthvalue) {
                ?>
                <th><?php echo $this->lang->line(substr($monthvalue, 0, 3)) ?></th>
            <?php }
            ?>

        </tr>
    </thead>
    <tbody>
        <?php
        if (!empty($resultlist)) {
            $j = 0;
            for ($i = 1; $i <= 31; $i++) {
                ?>
                <tr>
                    <td><?php echo $attendence_array[$j] ?></td>
                    <?php
                    foreach ($monthlist as $key => $value) {

                        $datemonth = date("m", strtotime($value));
                        $att_dates = date("Y") . "-" . $datemonth . "-" . sprintf("%02d", $i);
                        ?>
                        <td><span data-toggle="popover" class="detail_popover" data-original-title="" title=""><a href="#" style="color:#333"><?php
                                    if (array_key_exists($att_dates, $resultlist)) {
                                        echo $resultlist[$att_dates]["key"];
                                    }
                                    ?></a></span>
                            <div class="fee_detail_popover" style="display: none"><?php echo $resultlist[$att_dates]["remark"]; ?></div>
                        </td>

                    <?php } ?>
                </tr>
                <?php
                $j++;
            }
            ?>
            <?php
        } else {
            echo "No Record Found";
        }
        ?>   
    </tbody>
</table>