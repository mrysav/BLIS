<?php

require_once(__DIR__."/../../includes/features.php");

// Assume authentication + everything has been done outside of this file
global $lab_config_id;
global $lab_config_name;
global $selected_tab;

function render_tab($tab_name, $tab_link, $tab_label) {
    global $selected_tab;

    if ($tab_name == $selected_tab) {
        echo("<b>$tab_label</b>");
    } else {
        echo("<a href=\"$tab_link\">$tab_label</a>");
    }
}

?>

<script src="/config/v2/js/lab_config.js" type="application/javascript"></script>

<style type="text/css">
.tab-bar {
    padding: 1rem 0.5rem;
}

#backup_list table {
    width: 100%;
}

#backup_list table th {
    font-weight: bold;
}

.text-right {
    text-align: right;
}

.text-center {
    text-align: center;
}

.text-bold {
    font-weight: bold;
}

.text-monospace {
    font-family: monospace;
}

#settings {
    padding: 0.5rem 1rem;
}

#key-management {
    padding: 0.5rem 1rem;
}

.section {
    padding: 0.5rem 1rem;
}

.section-head {
    margin-top: 0rem;
}

.form-element {
    margin: 0.5rem 1rem;
}

a.delete-backup {
    color: red;
}

#pending-migrations {
    border: 1px solid darkblue;
    background-color: lightblue;
}
</style>

<div class="tab-bar">
    <?php
        if ($lab_config_name) {
            echo("<b>$lab_config_name</b>");
        } else {
            echo("<b>" . "Lab Backups" . "</b>");
        }
    ?>
    | <?php render_tab("lab_backups", "lab_config_backups.php?id=$lab_config_id", "Lab Backups"); ?>
    | <?php render_tab("settings", "lab_config_backup_settings.php?id=$lab_config_id", "Settings"); ?>
    | <?php render_tab("upload", "lab_config_backup_upload.php?id=$lab_config_id", "Upload Backup"); ?>
    <?php if (Features::allow_client_connections()) { ?>
    | <?php render_tab("connect", "lab_config_backup_connect.php?id=$lab_config_id", "Connect Offline Lab"); ?>
    <?php } ?>
</div>
