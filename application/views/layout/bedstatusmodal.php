

<?php foreach ($floor_list as $key => $floor) {
    ?>
    <fieldset class="floormain">
        <legend><h4><?php echo $floor["name"] ?></h4></legend>
        <div class="row">  

            <?php
            foreach ($bedgroup_list as $key => $bedgroup) {
                if ($bedgroup["fid"] == $floor["id"]) {
                    ?>
                    <div class="col-md-12">
                        <fieldset class="bedgroups">
                            <legend class="text-center floorwardbg"><h4><?php echo $bedgroup["name"] ?></h4></legend>
                            <div class="row">
                                <?php
                                foreach ($bedlist as $key => $beds) {

                                    if ($beds["bedgroupid"] == $bedgroup["id"]) {
                                        if ($beds["is_active"] == 'no') {
                                            $name = $beds["patient_name"];
                                            ?>
                                            <div class="col-md-1">
                                                <a data-toggle="popover" class="beddetail_popover" href="<?php echo base_url() . "admin/patient/ipdprofile/" . $beds["pid"] ?>">
                                                    <div class="">
                                                        <div class="<?php
                                                        if ($beds["is_active"] == "yes") {
                                                            echo "bedgreen";
                                                        } else {
                                                            echo "bedred";
                                                        }
                                                        ?>"><i class="fas fa-bed"></i>
                                                            <div class="bedtpmiuns6"><?php echo $name ?></div></div>
                                                    </div>
                                                    <div class="bed_detail_popover" style="display: none">
                                                        <?php
                                                        echo $this->lang->line('bed_no') . " : " . $beds["name"] . "<br/>" . $this->lang->line('patient') . " " . $this->lang->line('id') . " : " . $beds["patient_unique_id"] . "<br/>" . $this->lang->line('admission') . " " . $this->lang->line('date') . " : " . date($this->customlib->getSchoolDateFormat(true, true), strtotime($beds['date'])) . "<br/>" . $this->lang->line('phone') . " : " . $beds["mobileno"] . "<br/>" . $this->lang->line('gender') . " : " . $beds["gender"] . "<br/>" . $this->lang->line('guardian') . " " . $this->lang->line('name') . " : " . $beds["guardian_name"] . "<br/>" . $this->lang->line('consultant') . " : " . $beds["staff"] . " " . $beds["surname"];
                                                        ?>
                                                    </div>
                                                </a>
                                            </div><!--./col-md-2-->
                                            <?php
                                        } 
                                        if ($beds["is_active"] == 'yes') {
                                            $name = $beds["name"];
                                            $dataarr = array($beds["id"], $bedgroup["id"]);
                                            //foreach ($bedactive as $key => $bed) {
                                              // $name = $bed["name"]; 
                                            
                                            ?>
                                            <div class="col-md-1">
                                                <a href="<?php echo base_url() . "admin/patient/ipdsearch/" . $beds["id"] . "/" . $bedgroup["id"] ?>" >
                                                    <div class="">
                                                        <div class="<?php
                                                        if ($beds["is_active"] == "yes") {
                                                            echo "bedgreen";
                                                        } else {
                                                            echo "bedred";
                                                        }
                                                        ?>"><i class="fas fa-bed"></i>
                                                            <div class="bedtpmiuns6"><?php echo $name ?></div></div>
                                                    </div>
                                                </a>
                                            </div>    

                                            <?php
                                      //  }
                                        }
                                    }
                                }
                                ?>
                            </div>
                        </fieldset>
                    </div> 
                    <?php
                }
            }
            ?>

        </div>
    </fieldset>         
<?php } ?>    
<script type="text/javascript">
    $(document).ready(function () {
        $('.beddetail_popover').popover({
            placement: 'right',
            trigger: 'hover',
            container: 'body',
            html: true,
            content: function () {
                return $(this).closest('div').find('.bed_detail_popover').html();
            }
        });
    });

</script>

