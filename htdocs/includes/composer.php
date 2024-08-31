<?php

require_once(__DIR__."/../../vendor/autoload.php");
require_once(__DIR__."/features.php");

# Logger setup

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

# Check if log/ folder does not exist
if (!file_exists(__DIR__."/../../log")) {
    # If not, create it
    mkdir(__DIR__."/../../log", 0755);
}

$log = new Logger("application");

if (Features::application_log_to_docker_enabled()) {
    $log->pushHandler(new StreamHandler("/proc/1/fd/1", Logger::DEBUG));
}

$log->pushHandler(new StreamHandler(__DIR__."/../../log/application.log", Logger::DEBUG));

$db_log = new Logger("database");

if (Features::database_log_to_docker_enabled()) {
    $db_log->pushHandler(new StreamHandler("/proc/1/fd/1", Logger::DEBUG));
}

$db_log->pushHandler(new StreamHandler(__DIR__."/../../log/database.log", Logger::DEBUG));

# Check for other folders needed by application
if (!file_exists(__DIR__."/../../files")) {
    # If not, create it
    mkdir(__DIR__."/../../files", 0755);
}

?>
