<?php
$theme = $this->customlib->getCurrentTheme();

if ($theme == "default") {
    ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>backend/dist/themes/default/skins/_all-skins.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>backend/dist/themes/default/ss-main.css">
    <?php
} elseif ($theme == "red") {
    ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>backend/dist/themes/red/skins/skin-red.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>backend/dist/themes/red/ss-main-red.css">
    <?php
} elseif ($theme == "blue") {
    ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>backend/dist/themes/blue/skins/skin-darkblue.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>backend/dist/themes/blue/ss-main-darkblue.css">
    <?php
} elseif ($theme == "gray") {
    ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>backend/dist/themes/gray/skins/skin-light.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>backend/dist/themes/gray/ss-main-light.css">
    <?php
}



