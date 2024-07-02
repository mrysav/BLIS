<?php

include(__DIR__ . "/../includes/db_lib.php");
include(__DIR__ . "/../includes/SessionCheck.php");

$equipment_id=$_REQUEST['equipment_id'];

$e_det = getEquipmentDetails($equipment_id);

$equipment_id = $e_det[0]["id"];
$equipment_name = $e_det[0]["equipment_name"];
$equipment_version = $e_det[0]["equipment_version"];
$lab_department = $e_det[0]["lab_department"];
$comm_type = $e_det[0]["comm_type"];
$feed_source = $e_det[0]["feed_source"];
$config_file = $e_det[0]["config_file"];

$e_prop = getEquipmentProps($equipment_id);

$prop_name = array();
$prop_value = array();

foreach( $e_prop as $record ) {
	array_push($prop_name, $record["config_prop"]);
	array_push($prop_value, $record["prop_value"]);
}

// Part 1
$file = __DIR__ . '/../BLISInterfaceClient/part1.txt';
$current = file_get_contents($file);
$config_p1 = str_replace("--FS--", $feed_source, $current);

//Part2
if ($feed_source == "RS232"){
	$file = __DIR__ . '/../BLISInterfaceClient/rs232.txt';
}
else if ($feed_source == "TEXT"){
	$file = __DIR__ . '/../BLISInterfaceClient/flatfile.txt';
}
else if ($feed_source == "MSACCESS"){
	$file = __DIR__ . '/../BLISInterfaceClient/msaccess.txt';
}
else if ($feed_source == "HTTP"){
	$file = __DIR__ . '/../BLISInterfaceClient/http.txt';
}
else if ($feed_source == "TCP/IP"){
	$file = __DIR__ . '/../BLISInterfaceClient/tcpip.txt';
}

$current = file_get_contents($file);
$config_p2 ="";
for($i = 0; $i < count($prop_name); $i++){
	$config_p2 = str_replace("--".$prop_name[$i]."--",$prop_name[$i]." = ". $prop_value[$i], $current);
	$current = $config_p2;
}
echo $config_p2;


//Part 3
$file = __DIR__ . '/../BLISInterfaceClient/part3.txt';
$current = file_get_contents($file);
$config_p3 = str_replace("--BLIS_URL--", 'http://'.$_SERVER['HTTP_HOST'], $current);


//Part 4
$file = __DIR__ . '/../BLISInterfaceClient/part4.txt';
$current = file_get_contents($file);
$config_p4 = str_replace("--EQUIP_NAME--", $equipment_name, $current);


//Concatenated file
$config_file_content = $config_p1."\n".$config_p2."\n".$config_p3."\n".$config_p4;
$file2 = __DIR__ . '/../BLISInterfaceClient/BLISInterfaceClient.ini';
file_put_contents($file2, $config_file_content);

?>