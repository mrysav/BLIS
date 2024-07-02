<?php
#
# Enables redirect via .htaccess by appending root to PATH
#
$path = __DIR__ . "/../";
set_include_path(get_include_path() . PATH_SEPARATOR . $path);
?>