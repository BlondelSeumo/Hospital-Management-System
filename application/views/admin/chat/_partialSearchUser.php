<?php
if (!empty($chat_user)) {
    echo "<ul class='list-group' id='contact-list'>";
    foreach ($chat_user as $user_key => $user_value) {
        ?>
        <li class="list-group-item" data-user-type="<?php echo ($user_value->patient_id == "") ? 'Staff' : 'Student'; ?>" data-user-id="<?php echo ($user_value->patient_id == "") ? $user_value->staff_id : $user_value->patient_id; ?>">
            <div class="col-xs-2 col-sm-1">
                <?php
                if ($user_value->image == "") {
                    $img = base_url() . "uploads/staff_images/no_image.png";
                } else {
                    $img = ($user_value->patient_id == "") ? base_url() . "uploads/staff_images/" . $user_value->image : base_url() . $user_value->image;
                }
                ?>

                <img src="<?php echo $img; ?>" alt="Glenda Patterson" class="img-responsive">
            </div>
            <div class="col-xs-10 col-sm-9">
                <span class="name"><?php echo $user_value->name; ?></span>
                <br>

                <span>
                    <?php
                    if ($user_value->patient_id != "") {
                        echo "(Patient --r)";
                    } else {
                        echo "(Staff --r)";
                    }
                    ?>
                </span>
            </div>
            <div class="clearfix"></div>
        </li>
        <?php
    }
    echo "</ul>";
}
?>