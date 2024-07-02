<?php
include(__DIR__."/db_lib.php");
require_once(__DIR__."/user_lib.php");

function password_reset_required(){
	$password_reset_need = password_reset_need_confirm();
	return $password_reset_need;
}

?>
