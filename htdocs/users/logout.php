<?php
session_unset();
session_destroy();
if(isset($_REQUEST['timeout']))
	header("Location:login.php?to");
else
	header("Location:login.php");
?>