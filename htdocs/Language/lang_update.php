<?php


$directories = scandir(__DIR__ . '/../../local');
foreach($directories as $directory){
	if($directory=='.' or $directory==__DIR__ . '/..' ){
		//echo 'dot';
	}else{
		if (strpos($directory,'test') !== false && is_dir(__DIR__ . "/../../local/".$directory)) {
			copy("en.php",__DIR__ . "/../../local/".$directory."/en.php");
			copy("default.php",__DIR__ . "/../../local/".$directory."/default.php");
			copy("fr.php",__DIR__ . "/../../local/".$directory."/fr.php");
			echo $directory .'<br />';
		}
		
	}
}

?>