<?php
#
# (c) C4G, Santosh Vempala, Ruban Monu and Amol Shintre
# Contains method calls for commonly used HTML page elements
#

require_once(__DIR__."/../export/backup_lib.php");
require_once(__DIR__."/../regn/field_htmlFactory.php");
require_once(__DIR__."/../regn/generate_customize_field_order_patient.php");
require_once(__DIR__."/db_lib.php");
require_once(__DIR__."/field_order_update.php");
include_once(__DIR__."/../lang/lang_util.php");


class PageElems
{
	public function getSideTip($heading, $contents)
	{
		$html_code =
			"<div class='sidetip'>".
			"<b>".$heading."</b><br><br>".$contents.
			"</div>";
		echo $html_code;
	}

	public function getSideTipBatchResults($heading, $contents)
	{
		$html_code =
		"<div class='sidetip_batch_results_subdiv_help'>".
		"<b>".$heading."</b><br><br>".$contents.
		"</div>";
		echo $html_code;
	}

	public function getProgressSpinner($message)
	{
		?>
		<img src='/includes/img/small_spinner.gif' /><?php echo "<small> ".$message."</small>";
	}

	public function getProgressSpinnerBig($message)
	{
		?>
		<div style='width:250px;'>
		<center>
		<font class='smaller_font'>
		<?php echo $message; ?>
		</font>
		<img id='spinner_img' src='includes/img/spinner.gif'></img>
		</center>
		</div>
		<?php
	}

	public function getSmallArrow()
	{
		?>
		&nbsp;<img src='includes/img/small_arrow.gif'></img>
		<?php
	}

	public function getAsterisk()
	{
		?>
		<font color='red'>*</font>
		<?php
	}
	//AS 05/11/2019
//This function returns type privileges in tabular read only mode
	public function getLabUserReadWriteOptionRO($user_level="", $user_rwoptions=""){
		// if($user_level == 17) {
		// 	$user_rwoptions= "2,4";
		// }
//echo "<tr>";
		echo " 	<td> <div id='readOrWrite' name='readOrWrite' >";
		if($user_level < 16 || $user_level == 17)
			echo "Writeable Options ";
		else
			echo "Readable Options";

		echo "</div>".$this->getAsterisk()."</td>";
		$userRWoptions = explode( ',', $user_rwoptions );
		if($user_level < 16 || $user_level == 17)
		{

			echo "<td><div id='readWrite_options' name='readWrite_options'>";
		echo "<table>";
echo "<tr>";
echo "<th>Patient Registration</th>";
echo "<th>Test Results</th>";
echo "<th>Search</th>";
echo "<th>Inventory</th>";
echo "<th>Backup Data</th>";
echo "</tr>";
echo "<tr>";
echo "<td id='readwriteOpt2'>";
//		 			<input type='checkbox' name='readwriteOpt' id='readwriteOpt2' value='2' ";
			if(in_array("2", $userRWoptions))
echo "Y";
else
echo "N";
//				echo "checked";
//			echo ">Patient Registration<br>
	echo "</td>";
echo '<td id="readwriteOpt3">';
//					<input type='checkbox' name='readwriteOpt' id='readwriteOpt3' value='3' ";
					if(in_array("3", $userRWoptions))
echo "Y";
else
echo "N";
//						echo " checked";
echo "</td>";
echo '<td id="readwriteOpt4">';
//					echo ">Test Results<br>
//						<input type='checkbox' name='readwriteOpt' id='readwriteOpt4' value='4' ";
					if(in_array("4", $userRWoptions))
echo "Y";
else
echo "N";
//						echo " checked";
echo "</td>";
//					echo ">Search<br>
//					<input type='checkbox' name='readwriteOpt' id='readwriteOpt6' value='6' ";
echo '<td id="readwriteOpt6">';
					if(in_array("6", $userRWoptions))
echo "Y";
else
echo "N";
echo "</td>";
//						echo " checked";
//					echo ">Inventory<br>
//					<input type='checkbox' name='readwriteOpt' id='readwriteOpt7' value='7' ";
echo '<td id="readwriteOpt7">';
					if(in_array("7", $userRWoptions))
echo "Y";
else
echo "N";
echo "</td>";
//						echo " checked";
//					echo ">Backup Data <br>
echo "</tr>";
echo "</table>";
echo "</div></td>";
//				</div>
//		 	</td>";
		} else {
		echo "<td><div id='readWrite_options' name='readWrite_options'>";
		echo "<table>";
echo "<tr>";
echo "<th>";
echo "Test - option";
echo "</th>";
echo "<th>Generate Bill - option</th>";
echo "</tr>";
echo "<tr>";
echo "<td id='readwriteOpt51'>";
//			<input type='checkbox' name='readwriteOpt' id='readwriteOpt51' value='51' ";
			if(in_array("51", $userRWoptions))
echo "Y";
else
echo "N";
echo "</td>";
echo "<td id='readwriteOpt52'>";
//				echo " checked";
//			echo ">Select Test - option<br>
//			<input type='checkbox' name='readwriteOpt' id='readwriteOpt52' value='52' ";
			if(in_array("52", $userRWoptions))
echo "Y";
else
echo "N";
//				echo " checked";
//			echo ">Generate Bill - option<br>";
echo "</td>";
echo "</tr>";
echo "</table>";
echo "</div>";
echo "</td>";
}
//echo "</tr>";

}
	public function getAsteriskMessage()
	{
		# Indicator that * is for mandatory fields.
		# Can be used in form objects
		?>
		<small>
		<font color='red'>*</font> <?php echo LangUtil::$generalTerms['MSG_MANDATORYFIELD']; ?>
		</small>
		<?php
	}

	public function getDatePicker($name_list, $id_list, $value_list, $show_format=true, $lab_config=null)
	{
		# Returns a date picker element based on passed parameters
		# Element ID ise determined using random number generator
		$date_format = "";
		$date_format_js = "";
		$start_date = "";
		if($lab_config == null)
		{
			# Logged in as technician: Use session variable to fetch format
			$date_format = $_SESSION['dformat'];
		}
		else
		{
			# Logged in as admin
			$date_format = $lab_config->dateFormat;
		}
		$order_list = array(0, 1, 2); # Y-m-d
		switch($date_format)
		{
			case "d-m-Y":
				$order_list[0] = 2;
				$order_list[1] = 1;
				$order_list[2] = 0;
				$date_format_js = "dd-mm-yyyy";
				$start_date = "01-01-1950";
				break;
			case "m-d-Y":
				$order_list[0] = 1;
				$order_list[1] = 2;
				$order_list[2] = 0;
				$date_format_js = "mm-dd-yyyy";
				$start_date = "01-01-1950";
				break;
			case "Y-m-d":
				$order_list[0] = 0;
				$order_list[1] = 1;
				$order_list[2] = 2;
				$date_format_js = "yyyy-mm-dd";
				$start_date = "1950-01-01";
				break;
		}
		$date_format_js_parts = explode("-", $date_format_js);
		$picker_id = rand();
		if(DebugLib::isOldIe() === true || strpos($_SERVER['PHP_SELF'], "reports_tat.php") !== false)
		{
			# Show only date fields and not datepicker
			?>
			<input type='text' name='<?php echo $name_list[$order_list[0]]; ?>' id='<?php echo $id_list[$order_list[0]]; ?>' onkeypress="return isNumberKey(event)" value="<?php echo $value_list[$order_list[0]]; ?>" size='2' maxlength='2' />-
			<input type='text' name='<?php echo $name_list[$order_list[1]]; ?>' id='<?php echo $id_list[$order_list[1]]; ?>' onkeypress="return isNumberKey(event)" value="<?php echo $value_list[$order_list[1]]; ?>" size='2' maxlength='2' />-
			<input type='text' name='<?php echo $name_list[$order_list[2]]; ?>' id='<?php echo $id_list[$order_list[2]]; ?>' onkeypress="return isNumberKey(event)" value="<?php echo $value_list[$order_list[2]]; ?>" size='4' maxlength='4' />
			<?php
			if($show_format == true)
			{
			?>
				<br>
				<small><sup>
				&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;(<?php echo $date_format_js_parts[0]; ?>)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;(<?php echo $date_format_js_parts[1]; ?>)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;(<?php echo $date_format_js_parts[2]; ?>)
				</sup></small>
			<?php
			}
			return;
		}
		?>
		<SCRIPT type="text/javascript" charset="utf-8">
		    <!--
			function isNumberKey(evt)
			{
				var charCode = (evt.which) ? evt.which : event.keyCode
				if (charCode > 31 && (charCode < 48 || charCode > 57))
					return false;

					return true;
			}
			//-->

		Date.format = '<?php echo $date_format_js; ?>';
		$(function()
		{
			$('#<?php echo $picker_id; ?>').datePicker({startDate:'<?php echo $start_date; ?>'});
		});

		$(function()
		{
			$('#<?php echo $picker_id; ?>')
				.datePicker({createButton:false})
				.bind(
					'click',
					function()
					{
						$(this).dpDisplay();
						this.blur();
						return false;
					}
				)
				.bind(
					'dateSelected',
					function(e, selectedDate, $td)
					{
						var date_selected = $('#<?php echo $picker_id; ?>').val();
						var date_parts = date_selected.split('-');
						$('#<?php echo $id_list[$order_list[0]]; ?>').attr("value", date_parts[0]);
						$('#<?php echo $id_list[$order_list[1]]; ?>').attr("value", date_parts[1]);
						$('#<?php echo $id_list[$order_list[2]]; ?>').attr("value", date_parts[2]);
					}
				);
		});

		</SCRIPT>

		<style type='text/css'>
		a.dp-choose-date {
			float: left;
			width: 16px;
			height: 16px;
			padding: 0;
			margin: 5px 3px 0;
			display: block;
			text-indent: -2000px;
			overflow: hidden;
			background: url('includes/img/calendar_icon.gif') no-repeat;
		}
		a.dp-choose-date.dp-disabled {
			background-position: 0 -20px;
			cursor: default;
		}
		/* makes the input field shorter once the date picker code
		* has run (to allow space for the calendar icon
		*/
		input.dp-applied {
			width: 140px;
			float: right;
		}
		</style>

		<input type='text' name='<?php echo $name_list[$order_list[0]]; ?>' id='<?php echo $id_list[$order_list[0]]; ?>' onkeypress="return isNumberKey(event)" value="<?php echo $value_list[$order_list[0]]; ?>" size='2'  maxlength='2' />-
		<input type='text' name='<?php echo $name_list[$order_list[1]]; ?>' id='<?php echo $id_list[$order_list[1]]; ?>' onkeypress="return isNumberKey(event)" value="<?php echo $value_list[$order_list[1]]; ?>" size='2'  maxlength='2' />-
		<input type='text' name='<?php echo $name_list[$order_list[2]]; ?>' id='<?php echo $id_list[$order_list[2]]; ?>' onkeypress="return isNumberKey(event)" value="<?php echo $value_list[$order_list[2]]; ?>" size='4'  maxlength='4' />

		<INPUT name="<?php echo $picker_id; ?>" id="<?php echo $picker_id; ?>" class="date-pick dp-applied" style='display:none'/>

		<?php
		if($show_format == true)
		{
		?>
			<br>
			<small><sup>
			&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;(<?php echo $date_format_js_parts[0]; ?>)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;(<?php echo $date_format_js_parts[1]; ?>)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;(<?php echo $date_format_js_parts[2]; ?>)
			</sup></small>
		<?php
		}
		?>

	<?php
	}

	public function getDatePickerPlain($name_list, $id_list, $value_list, $show_format=true, $lab_config=null)
	{
		# Date field without the Jquery based picker object
		$date_format = "";
		$date_format_js = "";
		$start_date = "";
		if($lab_config == null)
		{
			# Logged in as technician: Use session variable to fetch format
			$date_format = $_SESSION['dformat'];
		}
		else
		{
			# Logged in as admin
			$date_format = $lab_config->dateFormat;
		}
		$order_list = array(0, 1, 2); # Y-m-d
		switch($date_format)
		{
			case "d-m-Y":
				$order_list[0] = 2;
				$order_list[1] = 1;
				$order_list[2] = 0;
				$date_format_js = "dd-mm-yyyy";
				$start_date = "01-01-1950";
				break;
			case "m-d-Y":
				$order_list[0] = 1;
				$order_list[1] = 2;
				$order_list[2] = 0;
				$date_format_js = "mm-dd-yyyy";
				$start_date = "01-01-1950";
				break;
			case "Y-m-d":
				$order_list[0] = 0;
				$order_list[1] = 1;
				$order_list[2] = 2;
				$date_format_js = "yyyy-mm-dd";
				$start_date = "1950-01-01";
				break;
		}
		$date_format_js_parts = explode("-", $date_format_js);
		?>
		<!-- Handling for non-numeric input -->
		<SCRIPT type="text/javascript" charset="utf-8">
		    <!--
			function isNumberKey(evt)
			{
				var charCode = (evt.which) ? evt.which : event.keyCode
				if (charCode > 31 && (charCode < 48 || charCode > 57))
					return false;

					return true;
			}
			//-->
		</SCRIPT>
		<input type='text' name='<?php echo $name_list[$order_list[0]]; ?>' id='<?php echo $id_list[$order_list[0]]; ?>' onkeypress="return isNumberKey(event)" value="<?php echo $value_list[$order_list[0]]; ?>" size='2'  maxlength='2' />-
		<input type='text' name='<?php echo $name_list[$order_list[1]]; ?>' id='<?php echo $id_list[$order_list[1]]; ?>' onkeypress="return isNumberKey(event)" value="<?php echo $value_list[$order_list[1]]; ?>" size='2'  maxlength='2' />-
		<input type='text' name='<?php echo $name_list[$order_list[2]]; ?>' id='<?php echo $id_list[$order_list[2]]; ?>' onkeypress="return isNumberKey(event)" value="<?php echo $value_list[$order_list[2]]; ?>" size='4'  maxlength='4' />
		<?php
		if($show_format == true)
		{
		?>
			<br>
			<small><sup>
			(<?php echo $date_format_js; ?>)
			</sup></small>
		<?php
		}
	}

	public function getResultFormForTest($test_type)
	{
		# Creates HTML form elements for a given test type
		return true;
	}

	public function getResultsForm($specimen_id)
	{
		# Creates HTML form for all tests pending for a specimen
		$test_list = get_pending_tests_by_sid($specimen_id);
		foreach($test_list as $test_type)
		{
			$garbage = $this->getResultFormForTest($test_type);
		}
		echo $specimen_id;
	}

	public function getSiteConfigForm($lab_config_id)
	{
		# Form to edit site config for a lab
		#$lab_config = LabConfig::getById($lab_config_id);
		$lab_sites = Sites::getByLabConfigId($lab_config_id);

		# Show all the sites, with option to select
		$this->getCollectionSitesCheckboxes($lab_sites, $lab_config_id);
		$this->toggleSiteEntry($lab_config_id);

	}

	public function toggleSiteEntry($lab_config_id)
	{
		$lab_config = LabConfig::getById($lab_config_id);
		echo "<br><br>". LangUtil::$pageTerms['ENABLE_SITE_ENTRY'];
		if ($lab_config->site_choice_enabled == 1) {
			?>
			<input type="radio" name="site_choice_enabled" value="1" checked> <?php echo LangUtil::$generalTerms['YES']; ?>
			<input type="radio" name="site_choice_enabled" value="0"> <?php echo LangUtil::$generalTerms['NO']; ?>
			<?php
		} else {
			?>
			<input type="radio" name="site_choice_enabled" value="1" > <?php echo LangUtil::$generalTerms['YES']; ?>
			<input type="radio" name="site_choice_enabled" value="0" checked> <?php echo LangUtil::$generalTerms['NO']; ?>
			<?php
		}
	}

	public function getCollectionSitesCheckboxes($site_records, $lab_config_id)
	{
		$lab_config = LabConfig::getById($lab_config_id);
		if (is_array($site_records)) {
		foreach ($site_records as $site){
			if ($lab_config->name == $site->name)
			    {
			        echo "<br/>";
			         echo "$site->name";
			          echo "<br/>";
			          echo "<input type='hidden' name='all_sites[][site]' value='$site->id'>";
			         echo "District: <input type='text' name='sites_district[$site->id]' placeholder = 'District' value='$site->district'/>&nbsp;<br/>";
			         echo "Region: <input type='text' name='sites_region[$site->id]' placeholder='Region' value='$site->region'/>";
			           echo "&nbsp;&nbsp;&nbsp;&nbsp;";
			            echo "<br/><input type='checkbox' name='sites[]' value='$site->id' >Delete?";
			        echo "<br/><br/>";
			    }

			else
			    {
                    echo "<br/>";
			       echo "$site->name";
			          echo "<br/>";
			          echo "<input type='hidden' name='all_sites[][site]' value='$site->id'>";
                    echo "District: <input type='text' name='all_sites[][district]' placeholder = 'District' value='$site->district'/>&nbsp;";
                    echo "Region: <input type='text' name='all_sites[][region]' placeholder='Region' value='$site->region'/>";
			           echo "<br/>";
			            echo "<input type='checkbox' name='sites[]' value='$site->id' >Delete?";
			        echo "<br/><br/>";
			    }
        }
        }
	}

	public function getCollectionSitesOptions($lab_config_id)
	{
		$lab_sites = Sites::getByLabConfigId($lab_config_id);
		foreach ($lab_sites as $site)
		{
			echo "<option value='$site->id'>$site->name</option>";
		}
	}

	public function getSiteOptions()
	{
		# Returns accessible sites for drop down <select> boxes
		$site_list = get_site_list_with_labid($_SESSION['user_id']);
		foreach($site_list as $key => $value)
		{
			echo "<option value='$key'>$value</option>";
		}
	}

	public function getCollectionSitesOptions2($lab_config_id)
	{
		# Returns accessible sites for drop down <select> boxes
        $config_list = get_lab_configs_imported();
        $districts = array();
        $regions = array();
        $strings = array();
        $site_counter = 0;
        foreach($config_list as $lab_config) {
			//$strippedLabName = substr($lab_config->name,0,strpos($lab_config->name,'-')-1);
			$lab_sites = Sites::getByLabConfigId($lab_config-> id);

			if($lab_sites!=null){
			foreach ($lab_sites as $site)
		    {
            $site_counter = $site_counter+1;
		    echo "<br><input type='checkbox' name='sites[]' id='$site->id' value='$site->id|$lab_config->id|$site->name' >$site->name</input>";

                if( $site->region!="")    {
                    $regions[$site->region] = array($site->region,$lab_config->id);
                }
                if( $site->district!="" )    {
                    $districts[$site->district] = array($site->district,$lab_config->id);
                }



		    if(empty($strings[$site->district]) && $site->district!="" )    {
		        $strings[$site->district] = array();
		    }
		    if(empty($strings[$site->region]) && $site->region!="")    {
		        $string[$site->region] = array();
		    }



                if( $site->region!="")    {
                    $string[$site->region][] = $site->id;
                }

                if( $site->district!="" )    {
                    $string[$site->district][] = $site->id;
                }

		    }
			}
		}

		$districts = array_values($districts);
		$regions = array_values($regions);

        if (count($districts) != 0){
             echo"<br/>Districts";
        }
        else{
            echo "<br/><br/>No Districts found";
        }

		foreach ($districts as $site)
		    {
                $str = implode(",",$string[$site[0]]);
		    echo "<br><input type='checkbox' name='sites[]' id='$site[0]' value='$str|$site[1]|$site[0]' >$site[0]</input>";

		    }

		    if(count($regions)!=0)
		        {
		            echo"<br/></br>Regions";
		        }
            else{
                echo "<br/><br/>No Regions found";
            }

		  foreach ($regions as $site)
		    {
             $str = implode(",",$string[$site[0]]);

		    echo "<br><input type='checkbox' name='sites[]' id='$site[0]' value='$str|$site[1]|$site[0]' >$site[0]</input>";

		    }
        if($site_counter==0){
            echo "No sites available in imported data.";
        }
	}


	public function getCollectionSiteRegionOptions($lab_config_id)
	{
		# Returns accessible sites for drop down <select> boxes
        $config_list = get_lab_configs_imported();
        foreach($config_list as $lab_config) {
			//$strippedLabName = substr($lab_config->name,0,strpos($lab_config->name,'-')-1);
			$lab_sites = Sites::getByLabConfigId($lab_config-> id);

			if($lab_sites!=null){
			foreach ($lab_sites as $site)
		    {

		    echo "<br><input type='checkbox' name='sites[]' id='$site->id' value='$site->id;$lab_config->id' checked>$site->district</input>";

		    }
			}
		}


	}



	public function getSiteOptionsCheckBoxes($checkBoxName)
	{
		//$site_list = get_site_list($_SESSION['user_id']);
                $config_list = get_lab_configs_imported();
                echo "<br><input type='checkbox' name='$checkBoxName' id='$checkBoxName' value='0' checked>All</input>";

		foreach($config_list as $lab_config) {
			//$strippedLabName = substr($lab_config->name,0,strpos($lab_config->name,'-')-1);
			echo "<br><input type='checkbox' name='$checkBoxName' id='$checkBoxName' value='$lab_config->id'>$lab_config->name</input>";
		}
	}

	public function getSiteOptionsCheckBoxesCountryDir($checkBoxName)
	{
		//$site_list = get_site_list($_SESSION['user_id']);
                $admin_user_id = $_SESSION['user_id'];
				#$lab_config_list = get_lab_configs($admin_user_id);
				$lab_config_list_imported = get_lab_configs_imported();
				$config_list = $lab_config_list_imported;
				#$config_list = array_merge($lab_config_list, $lab_config_list_imported);


		foreach($config_list as $lab_config) {
			//$strippedLabName = substr($lab_config->name,0,strpos($lab_config->name,'-')-1);
			echo "<br><input type='checkbox' name='$checkBoxName' id='$checkBoxName' value='$lab_config->id:$lab_config->name:$lab_config->location' checked>$lab_config->name</input>";
		}
	}
	public function getAdminUserOptions()
	{
		# Returns accessible sites for drop down <select> boxes
		$admin_user_list = get_admin_user_list($_SESSION['user_id']);
		foreach($admin_user_list as $key => $value)
		{
			echo "<option value='$key'>$value</option>";
		}
	}

	public function getLabUserReadWriteOption($user_level="", $user_rwoptions=""){
		// if($user_level == 17) {
		// 	$user_rwoptions= "2,4";
		// }

		echo " 	<td> <div id='readOrWrite' name='readOrWrite' >";
		if($user_level < 16 || $user_level == 17)
			echo "Writeable Options ";
		else
			echo "Readable Options";

		echo "</div>".$this->getAsterisk()."</td>";
		$userRWoptions = explode( ',', $user_rwoptions );
		if($user_level < 16 || $user_level == 17)
		{

			echo "<td><div id='readWrite_options' name='readWrite_options'>
		 			<input type='checkbox' name='readwriteOpt' id='readwriteOpt2' value='2' ";
			if(in_array("2", $userRWoptions))
				echo "checked";
			echo ">Patient Registration<br>

					<input type='checkbox' name='readwriteOpt' id='readwriteOpt3' value='3' ";
					if(in_array("3", $userRWoptions))
						echo " checked";
					echo ">Test Results<br>
						<input type='checkbox' name='readwriteOpt' id='readwriteOpt4' value='4' ";
					if(in_array("4", $userRWoptions))
						echo " checked";
					echo ">Search<br>
					<input type='checkbox' name='readwriteOpt' id='readwriteOpt6' value='6' ";
					if(in_array("6", $userRWoptions))
						echo " checked";
					echo ">Inventory<br>
					<input type='checkbox' name='readwriteOpt' id='readwriteOpt7' value='7' ";
					if(in_array("7", $userRWoptions))
						echo " checked";
					echo ">Backup Data <br>
				</div>
		 	</td>";
		} else {
		echo "<td><div id='readWrite_options' name='readWrite_options'>
			<input type='checkbox' name='readwriteOpt' id='readwriteOpt51' value='51' ";
			if(in_array("51", $userRWoptions))
				echo " checked";
			echo ">Select Test - option<br>
			<input type='checkbox' name='readwriteOpt' id='readwriteOpt52' value='52' ";
			if(in_array("52", $userRWoptions))
				echo " checked";
			echo ">Generate Bill - option<br>";

		}

	}

	public function getLabUserTypeOptions($selected_value="")
	{
		# Returns accessible sites for drop down <select> boxes
		# TODO: Link the hard-coded values below to includes/user_lib.php


		$saved_db = DbUtil::switchToGlobal();
		$query = "SELECT * FROM user_type where defaultdisplay = 1";
		$resultset = query_associative_all($query, $count);

		if( count($resultset) > 0 ) { ?>
			<?php
				foreach($resultset as $record) {
					echo "<option value='".$record['level']."'";
					if($selected_value == $record['level'])
						echo " selected ";
					echo ">". $record['name']."</option>";
				}
			?>s
		<?php }

		DbUtil::switchRestore($saved_db);


		// $LIS_TECH_RW = 0;
		// $LIS_TECH_RO = 1;
		// $LIS_ADMIN = 3;
		// $LIS_SUPERADMIN = 4;
		// $LIS_COUNTRYDIR = 5;
		// $LIS_CLERK = 6;

		// $LIS_VERIFIER = 15;
		// $LIS_TECH_SHOWPNAME = 13;

		// $LIS_DOCTOR = 16;
		// $LIS_PHYSICIAN = 17;

		// echo "<option value='$LIS_TECH_RW'";
		// if($selected_value == $LIS_TECH_RW)
		// 	echo " selected ";
		// echo ">".LangUtil::$generalTerms['LAB_TECH']."</option>";
		// /*
		// echo "<option value='$LIS_TECH_RO'";
		// if($selected_value == $LIS_TECH_RO)
		// 	echo " selected ";
		// echo ">Tech read-only</option>";
		// */
		// echo "<option value='$LIS_CLERK'";
		// if($selected_value == $LIS_CLERK)
		// 	echo " selected ";
		// echo ">".LangUtil::$generalTerms['LAB_RECEPTIONIST']."</option>";

		// echo "<option value='$LIS_VERIFIER'";
		// if($selected_value == $LIS_VERIFIER)
		// 	echo " selected ";
		// echo ">Verifier</option>";

		// echo "<option value='$LIS_DOCTOR'";
		// if($selected_value == $LIS_DOCTOR)
		// 	echo " selected ";
		// echo ">Requester</option>";

		// echo "<option value='$LIS_READONLY'";
		// if($selected_value == $LIS_READONLY)
		// 	echo " selected ";
		// echo ">Read-Only Mode</option>";

		// echo "<option value='$LIS_PHYSICIAN'";
		// if($selected_value == $LIS_PHYSICIAN)
		// 	echo " selected ";
		// echo ">Doctor</option>";

	}

	public function getCustomPatientFieldCheckBoxes()
	{
		$lab_config = LabConfig::getById($_SESSION['lab_config_id']);

		if ( $lab_config ) { ?>
			<?php
				$custom_field_list = $lab_config->getPatientCustomFields();
				foreach($custom_field_list as $custom_field) {
					echo '<input type="checkbox" name="patient_custom_fields[]" id='.$custom_field->id.' value='.$custom_field->id.' checked';
					echo ">Include ". $custom_field->fieldName."</input><br/>";
				}
			?>
		<?php }
	}

	public function getCustomSpecimenFieldCheckBoxes()
	{
		$lab_config = LabConfig::getById($_SESSION['lab_config_id']);

		if ( $lab_config ) { ?>
			<?php
				$custom_field_list = $lab_config->getSpecimenCustomFields();
				foreach($custom_field_list as $custom_field) {
					echo '<input type="checkbox" name="specimen_custom_fields[]" id='.$custom_field->id.' value='.$custom_field->id.' checked';
					echo ">Include ". $custom_field->fieldName."</input><br/>";
				}
			?>
		<?php }
	}

	public function getSpecimenTypesSelect($lab_config_id)
	{

		# Returns specimen types used at a site for drop down <select> boxes
		$specimen_type_list = get_specimen_types_by_site($lab_config_id);

		foreach($specimen_type_list as $specimen_type)
		{
			echo "<option value='$specimen_type->specimenTypeId'>".$specimen_type->getName()."</option>";
		}
	}

	public function getTestTypesSelect($lab_config_id)
	{
		# Returns test types used at a site for drop down <select> boxes
		$test_type_list = get_test_types_by_site($lab_config_id);
		foreach($test_type_list as $test_type)
		{
			echo "<option value='$test_type->testTypeId'>".$test_type->getName()."</option>";
		}
	}

	public function getTestTypesCountryLevel() {
		# Returns test types available for aggregation
		$saved_db = DbUtil::switchToLabConfigRevamp();
		$user_id = $_SESSION['user_id'];
		$query = "SELECT * FROM test_mapping where user_id =".$user_id;
		$resultset = query_associative_all($query, $count);

		if( count($resultset) > 0 ) { ?>
			<table class='hor-minimalist-b'>
			<tbody>
			<th>#</th>
			<?php
				echo "<th>".LangUtil::$generalTerms['NAME']."</th><th></th>";
				foreach($resultset as $record) {
					$testName = $record['test_name'];
					echo "<tr><td>".$record['test_id']."</td>";
					echo "<td>".$testName."</td>";
					echo "<td><a href=test_type_edit_dir.php?tid=".$record['test_id'].">".LangUtil::$generalTerms['CMD_VIEW']."/".LangUtil::$generalTerms['CMD_EDIT']."</a></td>";
					echo "</tr>";
				}
			?>
			</tbody>
			</table>
		<?php }
		else {
			echo "No Tests Currently Added";
		}
		DbUtil::switchRestore($saved_db);
	}

	public function getSpecimenTypesCountryLevel() {
		# Returns specimen types available for aggregation
		$saved_db = DbUtil::switchToLabConfigRevamp();
		$user_id = $_SESSION['user_id'];
		$query = "SELECT * FROM specimen_mapping where user_id =".$user_id;
		$resultset = query_associative_all($query, $count);

		if( count($resultset) > 0 ) { ?>
			<table class='hor-minimalist-b'>
			<tbody>
			<th>#</th>
			<?php echo "<th>".LangUtil::$generalTerms['NAME']."</th>";
			foreach($resultset as $record) {
				echo "<tr><td>".$record['specimen_id']."</td><td>".$record['specimen_name']."</td></tr>";
			}
			?>
			</tbody>
			</table>
		<?php }
		else {
			echo "No Specimens Currently Added";
		}
		DbUtil::switchRestore($saved_db);
	}

	public function getTestCategoryTypesCountryLevel() {
		# Returns test category types available for aggregation
		$saved_db = DbUtil::switchToGlobal();
		$user_id = $_SESSION['user_id'];
		$query = "SELECT * FROM test_category_mapping where user_id =".$user_id;
		$resultset = query_associative_all($query, $count);

		if( count($resultset) > 0 ) { ?>
			<table class='hor-minimalist-b'>
			<tbody>
			<th>#</th>
			<?php
				echo "<th>".LangUtil::$generalTerms['NAME']."</th><th></th>";
				foreach($resultset as $record) {
					echo "<tr><td>".$record['test_category_id']."</td>";
					echo "<td>".$record['test_category_name']."</td>";
                                        echo "<td><a href=lab_section_edit_dir.php?tid=".$record['test_category_id'].">".LangUtil::$generalTerms['CMD_VIEW']."/".LangUtil::$generalTerms['CMD_EDIT']."</a></td>";

					echo "</tr>";
				}
			?>
			</tbody>
			</table>
		<?php }
		else {
			echo "No Test Categories Currently Added";
		}
		DbUtil::switchRestore($saved_db);
	}

	public function getTestTypesCountrySelect()
	{
		/*
		$site_list = get_site_list($_SESSION['user_id']);
		$count = 0;
		$finalTestList = array();
		foreach($site_list as $lab_config_id => $lab_name)
		{
			$test_type_list = get_test_types_by_site($lab_config_id);
			foreach($test_type_list as $test_type) {
				$testName = $test_type->getName();
				if ( !array_key_exists($testName, $finalTestList) )
					$finalTestList[$testName] = $lab_config_id.":".$test_type->testTypeId.";";
				else {
					$existingValue = $finalTestList[$testName];
					$finalTestList[$testName] = $existingValue.$lab_config_id.":".$test_type->testTypeId.";";
				}
				continue;
			}
		}
		ksort($finalTestList);
		foreach($finalTestList as $key => $value)
			echo "<option value=$value>$key</option>";
		*/
		$userId = $_SESSION['user_id'];
		$saved_db = DbUtil::switchToGlobal();
		$query = "SELECT * FROM test_mapping WHERE user_id = $userId";
		$resultset = query_associative_all($query, $row_count);
		foreach($resultset as $record) {
				//$key = $record['lab_id_test_id'];
                                $key = $record['test_id'];
				$value = $record['test_name'];
				echo "<option value='$key'>$value</option>";
		}
		DbUtil::switchRestore($saved_db);
	}

	public function getTestNamesSelector() {
		#Return table which includes dropdowns of test types configured in all labs in the country
		echo "<table>";
		$count = 1;
		//$siteList = get_site_list($_SESSION['user_id']);
                $config_list = get_lab_configs_imported();
		foreach($config_list as $lab_config) {
			echo "<tr><td>".$lab_config->name."</td>";
			echo "<td><select id='testNameSelect$count'>";
			$testTypeList = get_test_types_by_site($lab_config->id);
			foreach($testTypeList as $testType) {
				echo "<option value='$lab_config->id:$testType->testTypeId'>".$testType->getName()."</option>";
			}
			echo "</select></td></tr>";
			$count++;
		}
		echo "<tr><td></td><td></td>";
		echo "</tr>";
		echo "<tr>"; ?>
		<td>Country Test Name:</td>
		<td><input type="text" id="commonTestName" size="50"></input>
		<div id='commonTestNameError' style='display:none'>
			<label class="error" id="commonTestNameErrorLabel"><small><font color="red"><?php echo LangUtil::getGeneralTerm("MSG_REQDFIELD"); ?></font></small></label>
		</div>
		</td>
		</tr>
		<tr>
		<td></td>
		<td><input type="button" id="submit" type="submit" onclick="submitTestNames();" value="<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>" size="20" />
		<?
	}

        public function getTestNamesSelectorForEdit($mapping) {
		#Return table which includes dropdowns of test types configured in all labs in the country
		print_r($mapping);
                ?>

                <table class='hor-minimalist-a'>
                <tr>
                <td><b>Country Test Name:</b></td>
		<td><input type="text" id="commonTestName" size="50" value></input>
		<div id='commonTestNameError' style='display:none'>
			<label class="error" id="commonTestNameErrorLabel"><small><font color="red"><?php echo LangUtil::getGeneralTerm("MSG_REQDFIELD"); ?></font></small></label>
		</div>
		</td>
                </tr>
                <tr><td></td></tr>
                <?php
		$count = 1;
		//$siteList = get_site_list($_SESSION['user_id']);
                $config_list = get_lab_configs_imported();
		foreach($config_list as $lab_config) {
			echo "<tr><td>".$lab_config->name."</td>";
			echo "<td><select id='testNameSelect$count' >";
			$testTypeList = get_test_types_by_site($lab_config->id);
			foreach($testTypeList as $testType) {
				echo "<option value='$labConfigId:$testType->testTypeId'>".$testType->getName()."</option>";
			}
			echo "</select></td></tr>";
			$count++;
		}
		//echo "<tr><td></td><td></td>";
		echo "</tr>";
		 ?>

		<tr>
		<td></td>
		<td><input type="button" id="submit" type="submit" onclick="submitTestNames();" value="<?php echo LangUtil::$generalTerms['CMD_UPDATE']; ?>" size="20" />
		<?
	}

	public function getSpecimenTypesCountrySelect()
	{
		$userId = $_SESSION['user_id'];
		$saved_db = DbUtil::switchToGlobal();
		$query = "SELECT * FROM specimen_mapping WHERE user_id = $userId";
		$resultset = query_associative_all($query, $row_count);
		foreach($resultset as $record) {
				$key = $record['lab_id_specimen_id'];
				$value = $record['specimen_name'];
				echo "<option value='$key'>$value</option>";
		}
		DbUtil::switchRestore($saved_db);
	}

	public function getTestCategoryNamesSelector() {
		#Return table which includes dropdowns of test categories configured in all labs in the country
		echo "<table>";
		$count = 1;
		 $config_list = get_lab_configs_imported();
		foreach($config_list as $lab_config) {
			echo "<tr><td>".$lab_config->name."</td>";
			echo "<td><select id='testCategoryNameSelect$count'>";
			$testCategoriesList = get_test_categories($lab_config->id);
			foreach( $testCategoriesList as $testCategoryId => $testCategoryName ) {
				echo "<option value='$lab_config->id:$testCategoryId'>".$testCategoryName."</option>";
			}
			echo "</select></td></tr>";
			$count++;
		}
		echo "<tr><td></td><td></td>";
		echo "</tr>";
		echo "<tr>"; ?>
		<td>Country Category Name:</td>
		<td><input type="text" id="commonTestCategoryName" size="50"></input>
		<div id='commonTestCategoryNameError' style='display:none'>
			<label class="error" id="commonTestCategoryNameErrorLabel"><small><font color="red"><?php echo LangUtil::getGeneralTerm("MSG_REQDFIELD"); ?></font></small></label>
		</div>
		</td>
		</tr>
		<tr>
		<td></td>
		<td><input type="button" id="submit" type="submit" onclick="submitTestCategoryNames();" value="<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>" size="20" />
		<?
	}

	public function getTestCategoryTypesCountrySelect() {
		$userId = $_SESSION['user_id'];
		$saved_db = DbUtil::switchToGlobal();
		$query = "SELECT * FROM test_category_mapping WHERE user_id = $userId";
		$resultset = query_associative_all($query, $row_count);
		foreach($resultset as $record) {
				$key = $record['test_category_id'];
				$value = $record['test_category_name'];
				echo "<option value='$key'>$value</option>";
		}
		DbUtil::switchRestore($saved_db);
	}

	public function getMeasuresSelector() {
		#Return table which includes dropdowns of measures configured in all labs in the country
		echo "<table>";
		$count = 1;
		$siteList = get_site_list($_SESSION['user_id']);
		foreach($siteList as $labConfigId => $labName) {
			echo "<tr><td>".$labName."</td>";
			echo "<td><select id='measureNameSelect$count'>";
			$measuresList = getMeasuresByLab($labConfigId);
			foreach($measuresList as $measure) {
				echo "<option value='$labConfigId:$measure->measureId'>".$measure->name."</option>";
			}
			echo "</select></td></tr>";
			$count++;
			DbUtil::switchRestore($saved_db);
		}
		echo "<tr><td></td><td></td></tr>";
		echo "<tr>";
		echo "<td>Country Specimen Name:</td>"; ?>
		<td><input type="text" id="commonMeasureName" size="50"></input>
		<div id='commonMeasureError' style='display:none'>
			<label class="error" id="commonMeasureErrorLabel"><small><font color="red"><?php echo LangUtil::getGeneralTerm("MSG_REQDFIELD"); ?></font></small></label>
		</div>
		</tr>
		<tr>
		<td></td>
		<td>
		<input type="button" id="submit" type="submit" onclick="submitMeasureNames();" value="<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>" size="20" />
		</td>
	<?php
	}

	public function getMeasuresCountryLevel() {
		$userId = $_SESSION['user_id'];
		$saved_db = DbUtil::switchToGlobal();
		$query = "SELECT * FROM measure_mapping WHERE user_id = $userId";
		$resultset = query_associative_all($query, $row_count);

		if( count($resultset) > 0 ) { ?>
			<table class='hor-minimalist-b'>
			<tbody>
			<th>#</th>
			<?php
				echo "<th>".LangUtil::$generalTerms['NAME']."</th>";
				foreach($resultset as $record) {
					$measureName = $record['measure_name'];
					echo "<tr><td>".$record['measure_id']."</td>";
					echo "<td>".$measureName."</td>";
					echo "</tr>";
				}
			?>
			</tbody>
			</table>
		<?php }
		else {
			echo "No Measures Currently Mapped";
		}
		DbUtil::switchRestore($saved_db);
	}

        public function getMasterCatalog() {
		#Return table which includes dropdowns of measures configured in all labs in the country
		echo "<table class='hor-minimalist-b tablesorter' id='testTypeTable'>";
		$count = 1;
                echo "<tr><th>"."Test Name"."</th><th></th><th>"."Site Name"."</th></tr>";
		$siteList = get_site_list($_SESSION['user_id']);
		foreach($siteList as $labConfigId => $labName) {
                    $ttype_list = get_test_types_catalog($labConfigId);
                    $space = 0;
                    foreach($ttype_list as $key => $value)
                    {
                        echo  "<tr><td>".$value."</td>";
                        echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
			echo "<td>".$labName."</td></tr>";
                        $space = 1;

                    }
                    if($space == 1)
                        echo "<tr><td></td><td></td><td></td></tr>";
                    //echo "<pre>";
                    //print_r($ttype_list);
                    //echo "</pre>";

			//echo "<td><select id='measureNameSelect$count'>";
			//$measuresList = getMeasuresByLab($labConfigId);
			//foreach($measuresList as $measure) {
			//	echo "<option value='$labConfigId:$measure->measureId'>".$measure->name."</option>";
			//}
			//echo "</select></td></tr>";
			$count++;
			DbUtil::switchRestore($saved_db);
		}
                echo "</table>";
		//echo "<tr><td></td><td></td></tr>";
		//echo "<tr>";
		//echo "<td>Country Specimen Name:</td>"; ?>

	<?php
	}

	public function getSpecimenNamesSelector() {
		#Return table which includes dropdowns of specimens configured in all labs in the country
		echo "<table>";
		$count = 1;
		$siteList = get_site_list($_SESSION['user_id']);
		foreach($siteList as $labConfigId => $labName) {
			echo "<tr><td>".$labName."</td>";
			echo "<td><select id='specimenNameSelect$count'>";
			$specimenTypeList = get_specimen_types_by_site($labConfigId);
			foreach($specimenTypeList as $specimenType) {
				echo "<option value='$labConfigId:$specimenType->specimenTypeId'>".$specimenType->getName()."</option>";
			}
			echo "</select></td></tr>";
			$count++;
		}
		echo "<tr><td></td><td></td></tr>";
		echo "<tr>";
		echo "<td>Country Specimen Name:</td>"; ?>
		<td><input type="text" id="commonSpecimenName" size="50"></input>
		<div id='commonSpecimenNameError' style='display:none'>
			<label class="error" id="commonSpecimenNameErrorLabel"><small><font color="red"><?php echo LangUtil::getGeneralTerm("MSG_REQDFIELD"); ?></font></small></label>
		</div>
		</tr>
		<tr>
		<td></td>
		<td>
		<input type="button" id="submit" type="submit" onclick="submitSpecimenNames();" value="<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>" size="20" />
		</td>
	<?php
	}

	public function getDiscreteTestTypesSelect($lab_config_id)
	{
		# Returns test types used at a site for drop down <select> boxes
		$lab_config = LabConfig::getById($lab_config_id);
		$test_id_list = get_discrete_value_test_types($lab_config);
		$test_type_list = array();
		foreach($test_id_list as $test_type_id)
		{
			$test_type = TestType::getById($test_type_id);
			$test_type_list[] = $test_type;
		}
		foreach($test_type_list as $test_type)
		{
			echo "<option value='$test_type->testTypeId'>".$test_type->getName()."</option>";
		}
	}

	public function getTestTypesByCategorySelect($lab_config_id, $cat_code)
	{
		# Returns test types used at a site for a particular category (lab section)
		# For drop down <select> boxes
		if($cat_code == 0)
		{
			# No category selected: Return all test types
			return $this->getTestTypesSelect($lab_config_id);
		}
		# Else, particular lab section selected: Fetch by category
		$test_type_list = get_test_types_by_site_category($lab_config_id, $cat_code);
		if(count($test_type_list) == 0)
		{
			# No matching test types found
			echo "<option value='0'>-".LangUtil::$generalTerms['MSG_NOTFOUND']."-</option>";
			return;
		}
		foreach($test_type_list as $test_type)
		{
			echo "<option value='$test_type->testTypeId'>".$test_type->getName()."</option>";
		}
	}

	public function getTestTypeCatalogOptions($elem_name, $elem_id)
	{
		# Returns a set of check boxes buttons for all tests available in catalog
		$test_list = get_test_types_catalog();
		if(count($test_list) == 0)
		{
			echo "No tests present in catalog";
			return;
		}
		foreach($test_list as $key => $value)
		{
			echo "<input type='checkbox' name='".$elem_name."[]' id='$elem_id' value='$key'>$value</input>";
		}
	}

	public function getTestCategorySelect($lab_config_id=null)
	{
		# Returns a set of drop down options for test categories in catalog
		$cat_list = get_test_categories($lab_config_id);
		if($cat_list) {
			foreach($cat_list as $key => $value)
				echo "<option value='$key'>$value</option>";
			return 1;
		}
		else
			return 0;
	}

	public function getTestCategoryCountrySelect($lab_config_id=null)
	{
		#Returns a set of drop down options for test categories in catalog of all labs in a country
		$site_list = get_site_list($_SESSION['user_id']);
		$final_cat_list = array();
		$count = 0;
		foreach($site_list as $lab_config_id => $lab_name)
		{
			$cat_list = get_test_categories($lab_config_id);
			foreach($cat_list as $key => $value) {
				if ( !in_array($value, $final_cat_list) )
					$final_cat_list[] = $value;
				else
					continue;
			}
		}
		foreach($final_cat_list as $value)
			echo "<option value='$value'>$value</option>";
	}
//AS 09/04/2018 Fill the lab drop down BEGIN
	public function getLabSelect()
	{
		$lcs = LabConfig::getAllLabs();
		foreach($lcs as $lc)
{
echo "<option value='$lc->id'>$lc->name</option>";
}
	}
//AS 09/04/2018 END

	public function getLangSelect()
	{
		echo "<option value='default'>Default</option>";
		echo "<option value='en'>English</option>";
		echo "<option value='fr'>Francais</option>";
	}

	public function getSpecimenTypeCatalogOptions($elem_name, $elem_id)
	{
		# Returns a set of check boxes buttons for all tests available in catalog
		$test_list = get_specimen_types_catalog();
		if(count($test_list) == 0)
		{
			echo "No tests present in catalog";
			return;
		}
		foreach($test_list as $key => $value)
		{
			echo "<input type='checkbox' name='".$elem_name."[]' id='$elem_id' value='$key'>$value</input>";
		}
	}

        public function getTestListToImport($elem_name, $elem_id)
	{
		# Returns a set of check boxes buttons for all tests available in catalog
		$test_list = get_specimen_types_catalog();
		if(count($test_list) == 0)
		{
			echo "No tests present in catalog";
			return;
		}
		foreach($test_list as $key => $value)
		{
			echo "<input type='checkbox' name='".$elem_name."[]' id='$elem_id' value='$key'>$value</input>";
		}
	}


	public function getTestTypeInfo($test_name, $show_db_name=false)
	{
		# Returns HTML for displaying test type information
		$test_type = get_test_type_by_name($test_name);
		?>
		<table class='hor-minimalist-b'>
			<tbody>
				<tr>
					<td><?php echo LangUtil::$generalTerms['NAME']; ?></td>
					<td>
						<?php
						if($show_db_name === true)
							echo $test_type->name;
						else
							echo $test_type->getName();
						?>
					</td>
				</tr>
				<tr>
					<td><?php echo LangUtil::$generalTerms['LAB_SECTION']; ?></td>
					<td><?php echo get_test_category_name_by_id($test_type->testCategoryId); ?></td>
				</tr>
				<tr valign='top'>
					<td><?php echo LangUtil::$generalTerms['DESCRIPTION']; ?></td>
					<td><?php echo $test_type->getDescription(); ?></td>
				</tr>
				<tr valign='top'>
					<td><?php echo LangUtil::$generalTerms['MEASURES']; ?></td>
					<td>
					<?php
						# Fetch all test measures
						$measure_id_list = get_test_type_measures($test_type->testTypeId);
                                                sort($measure_id_list);
                                                //print_r($measure_id_list);
						foreach($measure_id_list as $measure_id)
						{
							$measure = get_measure_by_id($measure_id);
							if($measure==NULL && count($meausre_id_list)==1 )
								{	echo "No Measures Found!";
									break;
								}
							else if($measure!=NULL)
                                                        {
                                                            if(strpos($measure->getName(), "\$sub") !== false)
                                                            {
                                                                $decName = $measure->truncateSubmeasureTag();
                                                                echo "&nbsp&nbsp&nbsp&nbsp;".$decName."<br>";
                                                            }
                                                            else
                                                            {
                                                                echo $measure->getName()."<br>";
                                                            }
                                                        }
						}
					?>
					</td>
				</tr>
				<tr valign='top'>
					<td><?php echo LangUtil::$generalTerms['COMPATIBLE_SPECIMENS']; ?></td>
					<td>
					<?php
						# Fetch list of compatible specimens
						$compatible_specimens = get_compatible_specimens($test_type->testTypeId);
						if(count($compatible_specimens) == 0)
						{
							echo "-";
						}
						else
						{
							foreach($compatible_specimens as $curr_specimen)
							{
								# Show test name
								$specimen_type = get_specimen_type_by_id($curr_specimen);
								echo $specimen_type->getName()."<br>";
							}
						}
					?>
					</td>
				</tr>

				<tr valign='top'>
					<td>Hide Patient Name in Report</td>
					<td><?php
						if(	$test_type->hidePatientName == 0) {
							echo "No";
						}
						else {
							echo "Yes";
						}
						?>
					</td>
				</tr>
				<tr valign='top'>
					<td>Prevalence Threshold</td>
					<td><?php echo $test_type->prevalenceThreshold; ?></td>
				</tr>

				<tr valign='top'>
					<td>Target TAT</td>
					<td><?php echo $test_type->targetTat; ?></td>
				</tr>

                                <tr valign='top' <?php is_billing_enabled($_SESSION['lab_config_id']) ? print("") : print("style='display:none;'") ?>>
                                        <td>Cost To Patient</td>
                                        <td><?php print(format_number_to_money(get_latest_cost_of_test_type($test_type->testTypeId))); ?></td>
                                </tr>

			</tbody>
		</table>
		<?php

	}

	public function getTestTypeInfoAggregateDir($testTypeMapping, $show_db_name=false)
	{
		# Returns HTML for displaying test type information
		$test_type = getAggregateTestTypeByName($testTypeMapping->name);
		?>
		<table class='hor-minimalist-b'>
			<tbody>
				<tr>
					<td><?php echo LangUtil::$generalTerms['NAME']; ?></td>
					<td><?php echo $test_type->name; ?></td>
				</tr>
			</tbody>
		</table>
		<?php
	}

        public function getTestTypeInfoAggregate($testTypeMapping, $show_db_name=false)
	{
		# Returns HTML for displaying test type information
		$test_type = getAggregateTestTypeByName($testTypeMapping->name);
		?>
		<table class='hor-minimalist-b'>
			<tbody>
				<tr>
					<td><?php echo LangUtil::$generalTerms['NAME']; ?></td>
					<td><?php echo $test_type->name; ?></td>
				</tr>

				<tr>
					<td><?php echo LangUtil::$generalTerms['LAB_SECTION']; ?></td>
					<td><?php echo getTestCategoryAggNameById($test_type->testCategoryId); ?></td>
				</tr>

				<tr valign='top'>
					<td><?php echo LangUtil::$generalTerms['MEASURES']; ?></td>
					<td>
					<?php
						# Fetch all test measures
						$measure_id_list = $testTypeMapping->getMeasureIds();
						foreach($measure_id_list as $measure_id)
						{
							$measure = getAggregateMeasureById($measure_id);
							if($measure==NULL && count($meausre_id_list)==1 ) {
									echo "No Measures Found!";
									break;
							}
							else if($measure!=NULL)
									echo $measure->getName()."<br>";
						}
					?>
					</td>
				</tr>

			</tbody>
		</table>
		<?php
	}

	public function getSpecimenTypeInfo($specimen_name, $show_db_name=false)
	{
		# Returns HTML for displaying specimen type information
		# Fetch specimen type record
		$specimen_type = get_specimen_type_by_name($specimen_name);
		?>
		<table class='hor-minimalist-b'>
			<tbody>
				<tr valign='top'>
					<td style='width:150px;'><?php echo LangUtil::$generalTerms['NAME']; ?></td>
					<td>
						<?php
						if($show_db_name === true)
						{
							# Show original name stored in DB
							echo $specimen_type->name;
						}
						else
						{
							# Show name store din locale string
							echo $specimen_type->getName();
						}
						?>
					</td>
				</tr>
				<tr valign='top'>
					<td><?php echo LangUtil::$generalTerms['DESCRIPTION']; ?></td>
					<td><?php echo $specimen_type->getDescription(); ?></td>
				</tr>
				<tr valign='top'>
					<td><?php echo LangUtil::$generalTerms['COMPATIBLE_TESTS']; ?></td>
					<td>
					<?php
						# Fetch list of compatible tests
						$compatible_tests = get_compatible_tests($specimen_type->specimenTypeId);
						if(count($compatible_tests) == 0)
						{
							echo "-";
						}
						else
						{
							$count = 1;
							foreach($compatible_tests as $curr_test)
							{
								# Show test name
								$test_type = get_test_type_by_id($curr_test);
								if($test_type == null)
								{
									# When mapping table entries are missing
									# TODO: Add error handling
									continue;
								}
								echo $test_type->getName();
								if($count % 2 == 0)
								{
									echo "<br>";
								}
								else if($count < count($compatible_tests))
								{
									echo ",  ";
								}
								$count++;
							}
						}
					?>
					</td>
				</tr>
			</tbody>
		</table>
		<?php
	}

	public function getTestTypeTable($lab_config_id)
	{
		# Returns HTML table listing all test types in catalog
		?>

		<script type='text/javascript'>
			$(document).ready(function(){
				$('#testTypeTable').tablesorter();
			});
		</script>

		<?php
		$ttype_list = get_test_types_catalog($lab_config_id);
		if(count($ttype_list) == 0)
		{
			echo "<div class='sidetip_nopos'>".LangUtil::$pageTerms['TIPS_TESTSNOTFOUND']."</div>";
			return;
		}
		?>
		<table class='hor-minimalist-b tablesorter' id='testTypeTable' >
			<thead>
					<th>#</th>
					<th><?php echo LangUtil::$generalTerms['TEST']; ?></th>
					<th><?php echo LangUtil::$generalTerms['LAB_SECTION']; ?></th>
					<th></th>
					<th></th>
			</thead>
		<tbody>
		<?php
		$count = 1;
		foreach($ttype_list as $key => $value)
		{
			$test_type = get_test_type_by_id($key);
			$cat_name = get_test_category_name_by_id($test_type->testCategoryId);
			?>
			<tr>
			<td>
				<?php echo $count; ?>.
			</td>
			<td>
				<?php echo $value; ?>
			</td>
			<td>
				<?php echo $cat_name; ?>
			</td>
			<td>
			</td>
			<td>
				<a href='test_type_edit.php?tid=<?php echo $key; ?>' title='Click to Edit Test Info'><?php echo LangUtil::$generalTerms['CMD_EDIT']; ?></a>
			</td>
			<?php
			$user = get_user_by_id($_SESSION['user_id']);
			if(is_country_dir($user) || is_super_admin($user))
			{
			?>
			<td>
				<a href='test_type_delete.php?id=<?php echo $key; ?>'><?php echo LangUtil::$generalTerms['CMD_DELETE']; ?></a>
			</td>
			<?php
			}
			?>
			</tr>
			<?php
			$count++;
		}
		?>
		</tbody>
		</table>
		<?php
	}

	public function getSpecimenTypeTable($lab_config_id)
	{
		# Returns HTML table listing all specimen types in catalog
		$stype_list = get_specimen_types_catalog($lab_config_id);
		if(count($stype_list) == 0)
		{
			echo "<div class='sidetip_nopos'>".LangUtil::$pageTerms['TIPS_SPECIMENSNOTFOUND']."</div>";
			return;
		}
		?>
		<table class='hor-minimalist-b'>
		<tbody>
		<?php
		$count = 1;
		foreach($stype_list as $key => $value)
		{
			?>
			<tr>
			<td>
				<?php echo $count; ?>.
			</td>
			<td>
				<?php echo $value; ?>
			</td>
			<td>
				<a href='specimen_type_edit.php?sid=<?php echo $key; ?>' title='Click to Edit Specimen Info'><?php echo LangUtil::$generalTerms['CMD_EDIT']; ?></a>
			</td>
			<?php
			$user = get_user_by_id($_SESSION['user_id']);
			if(is_country_dir($user) || is_super_admin($user))
			{
			?>
			<td>
				<a href='specimen_type_delete.php?id=<?php echo $key; ?>'><?php echo LangUtil::$generalTerms['CMD_DELETE']; ?></a>
			</td>
			<?php
			}
			?>
			</tr>
			<?php
			$count++;
		}
		?>
		</tbody>
		</table>
		<?php
	}

	public function getOperatorForm($num_entries)
	{
		# Returns HTML form code for adding technicians
		global $LIS_TECH_RO, $LIS_TECH_RW, $LIS_CLERK;
		$html_code = "";
		$html_code .="<span id='tech_entries'>";
		$html_code .=
			"<div id='tech_access_help' style='display:none;'>".
			"<table class='smaller_font'><tr><td>".
			"<u>Technician Access Levels</u><br><br>".
			"<b>Read-Write</b><br>".
			"Technician can Add/update patient records, ".
			"register samples (specimens) and schedule them for various tests, ".
			"perform results entry for completed tests, ".
			"search and export test-related data and ".
			"view reports for the lab assigned to the account".
			"<br><br>".
			"<b>Read-Only</b><br>".
			"Technician can search and export test-related data and ".
			"view reports for the lab assigned to the account ".
			"</td></tr></table>".
			"</div>";
		$html_code .=
			LangUtil::$generalTerms['USERNAME'].
			"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".
			"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".
			LangUtil::$generalTerms['PWD_TEMP'].
			"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".
			"&nbsp;&nbsp;&nbsp;".
			LangUtil::$generalTerms['NAME'].
			"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".
			"&nbsp;&nbsp;&nbsp;&nbsp;".
			//"Access [<a rel='facebox' href='#tech_access_help'>?</a>]".
			"<br>";
		$entry_row =
			"<input type='text' name='username[]' />&nbsp;&nbsp;&nbsp;".
			"<input type='text' name='password[]' />&nbsp;&nbsp;&nbsp;".
			"<input type='text' name='fullname[]' />&nbsp;&nbsp;&nbsp;";
		for($count = 1; $count <= $num_entries; $count++)
		{
			$radio_row =
				"<input type='radio' name='access_priv_".($count-1)."' id='access_priv_".($count-1)."' value='".$LIS_TECH_RW."' checked /> ".LangUtil::$generalTerms['TECHNICIAN'].
				"&nbsp;&nbsp;&nbsp;<input type='radio' name='access_priv_".($count-1)."' id='access_priv_".($count-1)."' value='".$LIS_CLERK."' /> ".LangUtil::$generalTerms['LAB_RECEPTIONIST']."<br>";
			$html_code .= $entry_row.$radio_row;
		}
		$html_code .= "</span>";
		$html_code .= "<a href='javascript:add_row();'>Add another&raquo;</a>";
		$html_code .=
			"<script type='text/javascript'>".
			"var entry_count=".($num_entries)."; ".
			"function add_row() {".
			"	var radio_row = \"<input type='radio' name='access_priv_\"+entry_count+\"' id='access_priv_\"+entry_count+\"' value='".$LIS_TECH_RO."' checked /> ".LangUtil::$generalTerms['TECHNICIAN']."\"+".
			"\"&nbsp;&nbsp;&nbsp;<input type='radio' name='access_priv_\"+entry_count+\"' id='access_priv_\"+entry_count+\"' value='".$LIS_TECH_RW."' /> ".LangUtil::$generalTerms['LAB_RECEPTIONIST']."<br>\";".
			"	var html_code=\"".$entry_row."\"+radio_row;".
			"	$('#tech_entries').append(html_code);".
			"	entry_count++;".
			"}".
			"</script>";
		echo $html_code;
	}

	public function getOperatorExistingForm($lab_config_id)
	{
		# Returns HTML table listing existing technician account,
		# with options to change access or delete account

		global $LIS_TECH_RO, $LIS_TECH_RW;
		?>
		<table cellspacing='4px'>
			<tbody>
				<tr>
					<td><u>Existing</u></td>
					<td><u>Change Access</u></td>
					<td><u>Remove</u></td>
				</tr>
				<?php
				$technician_list = get_tech_users_by_site_map($lab_config_id);
				foreach($technician_list as $user_id=>$username)
				{
					$user = get_user_by_id($user_id);
					?>
					<tr>
						<td>
							<?php echo $username; ?>
							<input type='hidden' name='tech_id[]' value='<?php echo $user_id; ?>'></input>
						</td>
						<td>
							<select name='tech_access[]'>
								<option value='<?php echo $LIS_TECH_RO; ?>'
								<?php
								if($user->level == $LIS_TECH_RO)
									echo " selected ";
								?>
								>Read-Only</option>
								<option value='<?php echo $LIS_TECH_RW; ?>'
								<?php
								if($user->level == $LIS_TECH_RW)
									echo " selected ";
								?>
								>Read-Write</option>
							</select>
						</td>
						<td>
							<input type='checkbox' name='tech_remove_<?php echo $user_id; ?>'></input>
						</td>
					</tr>
					<?php
				}
				?>
			</tbody>
		</table>
		<?php
	}
	public function getTokenLis($count,$id, $name, $json_url, $hint_text, $json_prepopulate="", $class_name="")
	{



		# Returns a tokenized list as form input element (using jquery.tokeninput plugin)
		$test=explode("_",$id);
		$test_id=$test[1];

		?>
		<script type="text/javascript">
		$(document).ready(function() {
			$("#<?php echo $id; ?>").tokenInput("<?php echo $json_url; ?>", {
				hintText: "<?php echo $hint_text; ?>",
				noResultsText: "No results",
				searchingText: "Searching..."
				/*
				classes: {
					tokenList: "token-input-list-facebook",
					token: "token-input-token-facebook",
					tokenDelete: "token-input-delete-token-facebook",
					selectedToken: "token-input-selected-token-facebook",
					highlightedToken: "token-input-highlighted-token-facebook",
					dropdown: "token-input-dropdown-facebook",
					dropdownItem: "token-input-dropdown-item-facebook",
					dropdownItem2: "token-input-dropdown-item2-facebook",
					selectedDropdownItem: "token-input-selected-dropdown-item-facebook",
					inputToken: "token-input-input-token-facebook"
				}
				*/
				<?php
				if($json_prepopulate != "")
				{
					echo ", prePopulate: $json_prepopulate";
				}
				?>
			});
		});
		</script>
		<input type="text" id="<?php echo $id; ?>" class='uniform_width  <?php
		if(trim($class_name) != "")
			echo " ".$class_name." ";
		?>' name="<?php echo $name; ?>"  />
		<?php
	}
	public function getTokenList($count,$id, $name, $json_url, $hint_text, $json_prepopulate="", $class_name="")
	{
		# Returns a tokenized list as form input element (using jquery.tokeninput plugin)
		$test=explode("_",$id);
		$test_id=$test[1];
		?>
		<script type="text/javascript">
		$(document).ready(function() {
			$("#<?php echo $id; ?>").tokenInput("<?php echo $json_url; ?>", {
				hintText: "<?php echo $hint_text; ?>",
				noResultsText: "No results",
				searchingText: "Searching...",
				preventDuplicates: true
				/*
				classes: {
					tokenList: "token-input-list-facebook",
					token: "token-input-token-facebook",
					tokenDelete: "token-input-delete-token-facebook",
					selectedToken: "token-input-selected-token-facebook",
					highlightedToken: "token-input-highlighted-token-facebook",
					dropdown: "token-input-dropdown-facebook",
					dropdownItem: "token-input-dropdown-item-facebook",
					dropdownItem2: "token-input-dropdown-item2-facebook",
					selectedDropdownItem: "token-input-selected-dropdown-item-facebook",
					inputToken: "token-input-input-token-facebook"
				}
				*/
				<?php
				if($json_prepopulate != "")
				{
					echo ", prePopulate: $json_prepopulate";
				}

				?>
			});

		});
		</script>

		<input type="text" id="<?php echo $id; ?>" class='uniform_width  <?php
		if(trim($class_name) != "")
			echo " ".$class_name." ";
		?>' name="<?php echo $name; ?>" <?php if($count!=-1){?> onchange="javascript:update_remarks(<?php echo $test_id ; ?>,<?php echo $count; ?>, 1, B)"  <?php }?>/>
		<?php

	}

	public function getLabConfigTable($lab_config_list)
	{
		# Returns HTML table of site/locations
		# Called from lab_configs.php
		if(count($lab_config_list) == 0)
		{
			echo "<div class='sidetip_nopos'>".LangUtil::$generalTerms['MSG_NOTFOUND']."</div>";
			return;
		}
		?>
		<table class='hor-minimalist-b' style='width:950px;'>
			<thead>
				<tr valign='top'>
					<th>
						#
					</th>
					<th>
						<?php echo LangUtil::$generalTerms['FACILITY']; ?>
					</th>
					<th>
						<?php echo LangUtil::$generalTerms['LOCATION']; ?>
					</th>
					<th>
						<?php echo LangUtil::$generalTerms['LAB_MGR']; ?>
					</th>
                                        <th>
                                        </th>
					<!--<th>
					</th>
					<th>
					</th>
					<th>
					</th>
					<th>
					</th>-->
				</tr>
			</thead>
			<tbody>
		<?php
		$count = 1;
		foreach($lab_config_list as $lab_config)
		{
			?>
				<tr valign='top'>
					<td>
						<?php echo $count; ?>.
					</td>
					<td>
						<a href='lab_config_home.php?id=<?php echo $lab_config->id; ?>' title='Click to Manage Lab Configuration'><?php echo $lab_config->name; ?></a>
					</td>
					<td>
						<?php echo $lab_config->location; ?>
					</td>
					<td>
						<?php echo get_username_by_id($lab_config->adminUserId); ?>
					</td>
                                        <td>
 						<a href='exportLabConfiguration.php?id=<?php echo $lab_config->id; ?>' title='Click to Export Lab Configuration'><?php echo "Export Lab Configuration"; ?></a>

                                        </td>
					<!--<td>
						<a rel='facebox' href='lab_config_status.php?id=<?php echo $lab_config->id; ?>' title='Click to view pending tests at the lab'><?php echo LangUtil::$generalTerms['LAB_STATUS']; ?></a>
					</td>
					<td>
						<a href='lab_config_home.php?id=<?php echo $lab_config->id; ?>' title='Click to Manage Lab Configuration'><?php echo LangUtil::$generalTerms['MANAGE']; ?></a>
					</td>
					<td>
						<a href='switchto_tech.php?id=<?php echo $lab_config->id; ?>' title='Click to perform technician tasks in this lab'><?php echo LangUtil::$generalTerms['SWITCH_TOTECH']; ?></a>
					</td>-->
					<!--
					<td>
						<a
							href="javascript:delete_lab_config('<?php #echo $lab_config->getSiteName(); ?>', <?php #echo $lab_config->id; ?>);"
							title='Click to Delete Lab Configuration'
						>
							Delete
						</a>
					</td>
					-->
				</tr>
			<?php
			$count++;
		}
		?>
			</tbody>
		</table>
		<?php
	}

        public function getLabConfigTableImported($lab_config_list)
	{
		# Returns HTML table of site/locations
		# Called from lab_configs.php
		if(count($lab_config_list) == 0)
		{
			echo "<div class='sidetip_nopos'>".LangUtil::$generalTerms['MSG_NOTFOUND']."</div>";
			return;
		}
		?>
		<table class='hor-minimalist-b' style='width:950px;'>
			<thead>
				<tr valign='top'>
					<th>
						#
					</th>
					<th>
						<?php echo LangUtil::$generalTerms['FACILITY']; ?>
					</th>
					<th>
						<?php echo LangUtil::$generalTerms['LOCATION']; ?>
					</th>
					<th>
						<?php echo LangUtil::$generalTerms['LAB_MGR']; ?>
					</th>
					<th>
                                            <?php echo "Last Import Date"; ?>
					</th>
                                        <th>
                                        </th>

				</tr>
			</thead>
			<tbody>
		<?php
		$count = 1;
		foreach($lab_config_list as $lab_config)
		{
			?>
				<tr valign='top'>
					<td>
						<?php echo $count; ?>.
					</td>
					<!--<td>
						<a href='lab_config_home.php?id=<?php echo $lab_config->id; ?>' title='Click to Manage Lab Configuration'><?php echo $lab_config->name; ?></a>
					</td>-->

					<td>
						<?php echo $lab_config->name; ?>
					</td>
                                        <td>
						<?php echo $lab_config->location; ?>
					</td>
					<td>
						<?php echo get_username_by_id($lab_config->adminUserId); ?>
					</td>
                                        <td>
                                               <?php echo get_last_import_date($lab_config->id); ?>
                                        </td>
					<td>
						<a rel='facebox' href='lab_config_status.php?id=<?php echo $lab_config->id; ?>' title='Click to view pending tests at the lab'><?php echo LangUtil::$generalTerms['LAB_STATUS']; ?></a>
					</td>

					<!--<td>
						<a href='lab_config_home.php?id=<?php echo $lab_config->id; ?>' title='Click to Manage Lab Configuration'><?php echo LangUtil::$generalTerms['MANAGE']; ?></a>
					</td>
					<td>
						<a href='switchto_tech.php?id=<?php echo $lab_config->id; ?>' title='Click to perform technician tasks in this lab'><?php echo LangUtil::$generalTerms['SWITCH_TOTECH']; ?></a>
					</td>-->
					<!--
					<td>
						<a
							href="javascript:delete_lab_config('<?php #echo $lab_config->getSiteName(); ?>', <?php #echo $lab_config->id; ?>);"
							title='Click to Delete Lab Configuration'
						>
							Delete
						</a>
					</td>
					-->
				</tr>
			<?php
			$count++;
		}
		?>
			</tbody>
		</table>
		<?php
	}

	public function getLabAdminTable($lab_admin_list)
	{
		# Returns HTML table of lab admin accounts
		# Called from lab_admins.php
		if(count($lab_admin_list) == 0)
		{
			echo "<div class='sidetip_nopos'>".LangUtil::$generalTerms['MSG_NOTFOUND']."</div>";
			return;
		}
		?>
		<table class='hor-minimalist-b' style='width:730px'>
			<thead>
				<tr valign='top'>
					<th>
						#
					</th>
					<th>
						<?php echo LangUtil::$generalTerms['USERNAME']; ?>
					</th>
					<th>
						<?php echo LangUtil::$generalTerms['NAME']; ?>
					</th>
					<th>
						<?php echo LangUtil::$pageTerms['LABS_ASSIGNED']; ?>
					</th>
					<th>
					</th>
					<th>
					</th>
				</tr>
			</thead>
			<tbody>
		<?php
		$count = 1;
		foreach($lab_admin_list as $lab_admin)
		{
			?>
				<tr valign='top'>
					<td>
						<?php echo $count; ?>.
					</td>
					<td>
						<?php echo $lab_admin->username; ?>
					</td>
					<td>
						<?php echo $lab_admin->actualName; ?>
					</td>
					<td>
						<?php
//AS 09/044/2018 Fixed missing lab name issue BEGIN
						$lab_list =LabConfig::getById($lab_admin->labConfigId)->name; //$this->listOwnedLabs($lab_admin->userId);
//AS 09/04/2018 END
						echo $lab_list;
						?>
						<br>
						<?php
						$dialog_id = "dialog_".$lab_admin->userId;
						$del_progress_div_id = "delete_$lab_admin->userId";
						$del_link_div_id = "delete_link_$lab_admin->userId";
						if($lab_list != "-")
						{
							$message = "'$lab_admin->username' - ".LangUtil::$pageTerms['TIPS_ACC_LABSEXIST'];
							$this->getAlertDialog($dialog_id, $message);
						}
						else
						{
							$message = "'$lab_admin->username' - ".LangUtil::$generalTerms['TIPS_ACC_CONFIRMDELETE'];
							$ok_function = "delete_lab_admin($lab_admin->userId,'$lab_admin->username',0,'$del_link_div_id','$del_progress_div_id');";
							$cancel_function = "toggle('$dialog_id')";
							$this->getConfirmDialog($dialog_id, $message, $ok_function, $cancel_function);
						}
						?>
					</td>
					<td>
						<?php
						$url_edit = "lab_admin_edit.php?id=$lab_admin->userId";
						?>
						<a href="<?php echo $url_edit; ?>" title='Click to Edit Lab Admin Account'>Edit</a>
					</td>
					<td>
						<?php
						$url = "javascript:show_dialog_box('$dialog_id');";
						?>
						<span id='<?php echo $del_link_div_id; ?>'><a href="<?php echo $url; ?>" title='Click to Delete Lab Admin Account'>Delete</a></span>
						<span id='<?php echo $del_progress_div_id; ?>' style='display:none'>
							<?php
							$this->getProgressSpinner("Deleting");
							?>
						</span>
					</td>
				</tr>
			<?php
			$count++;
		}
		?>
			</tbody>
		</table>
		<?php
	}

	public function getLabUsersTable($user_list, $lab_config_id, $to_export=false)
	{
		# Returns HTML table of lab users
		# Called from lab_config_home.php
		if(count($user_list) == 0)
		{
			echo "<div class='sidetip_nopos'>".LangUtil::$generalTerms['MSG_NOTFOUND']."</div>";
			return;
		}
		?>
		<table class='hor-minimalist-b' style='width:700px;'>
			<thead>
				<tr valign='top'>
					<th>
						#
					</th>
					<th>
						<?php echo LangUtil::$generalTerms['USERNAME']; ?>
					</th>
					<th>
						<?php echo LangUtil::$generalTerms['TYPE']; ?>
					</th>
					<?php
					if($to_export == false)
					{
					?>
					<th>
					</th>
					<?php
					}
					?>
				</tr>
			</thead>
			<tbody>
			<?php
			$count = 1;
			foreach($user_list as $user)
			{
				?>
					<tr valign='top'>
						<td>
							<?php echo $count; ?>.
						</td>
						<td>
							<?php echo $user->username; ?>
						</td>
						<td>
							<?php $l_name = get_level_name($user->level);
							if ($l_name == null)
								$l_name = get_level_name_db($user->level);
							echo $l_name;
							?>
						</td>
						<?php
						if($to_export == false)
						{
						?>
						<td>
							<a href="lab_user_edit.php?id=<?php echo $user->userId; ?>&backurl=lab_config_home.php?id=<?php echo $lab_config_id; ?>">
							<?php echo LangUtil::$generalTerms['CMD_EDIT']; ?>
							</a>
							&nbsp;&nbsp;&nbsp;&nbsp;
							<a href='javascript:ask_to_delete_user(<?php echo $user->userId; ?>);'><?php echo LangUtil::$generalTerms['CMD_DELETE']; ?></a>
							<br>
							<?php
							$div_id = 'delete_confirm_'.$user->userId;
							$message = "'$user->username' - ".LangUtil::$generalTerms['TIPS_ACC_CONFIRMDELETE'];
							$ok_function_call = "javascript:delete_user($user->userId);";
							$cancel_function_call = "javascript:toggle('$div_id');";
							$this->getConfirmDialog($div_id, $message, $ok_function_call, $cancel_function_call, $width=200);
							?>
						</td>
						<?php
						}
						?>
					</tr>
				<?php
				$count++;
			}
			?>
			</tbody>
		</table>
		<?php
	}

	public function getLabUserTypesTable($user_list, $lab_config_id, $to_export=false)
	{
		# Returns HTML table of lab users
		# Called from lab_config_home.php
		if(count($user_list) == 0)
		{
			echo "<div class='sidetip_nopos'>".LangUtil::$generalTerms['MSG_NOTFOUND']."</div>";
			return;
		}
		?>
		<table class='hor-minimalist-b' style='width:700px;'>
			<thead>
				<tr valign='top'>
					<th>
						Level
					</th>
					<th>
						Type
					</th>
					<th>
						Default
					</th>
					<?php
					if($to_export == false)
					{
					?>
					<th>
					</th>
					<?php
					}
					?>
				</tr>
			</thead>
			<tbody>
			<?php
			$count = 1;
			foreach($user_list as $user)
			{

				?>
					<tr valign='top'>
						<td>
							<?php echo $user->level; ?>.
						</td>
						<td>
							<?php $val = get_level_name($user->level);
								if ($val == null)
									echo  $user->name;
								else
									echo $val;
							?>
						</td>
						<td>
							<?php
								if($user->defaultdisplay)
									echo "Yes";
								else
									echo "No";
							?>
						</td>
						<?php
						if($to_export == false)
						{
						?>
						<td>
							<a href="lab_user_type_edit.php?type=<?php echo $user->level; ?>&backurl=lab_config_home.php?id=<?php echo $lab_config_id; ?>">
							<!-- <a href="lab_user_edit.php?id=<?php echo "521"; ?>&backurl=lab_config_home.php?id=<?php echo $lab_config_id; ?>"> -->
							<?php echo LangUtil::$generalTerms['CMD_EDIT']; ?>
							</a>
							&nbsp;&nbsp;&nbsp;&nbsp;
							<a href='javascript:ask_to_delete_user_type(<?php echo $user->level; ?>);'><?php echo LangUtil::$generalTerms['CMD_DELETE']; ?></a>
							<br>
							<?php
							$div_id = 'delete_confirm_'.$user->level;
							$message = "'$user->name' - Are you sure you want to delete this user type?";
							$ok_function_call = "javascript:delete_user_type($user->level);";
							$cancel_function_call = "javascript:toggle('$div_id');";
							$this->getConfirmDialog($div_id, $message, $ok_function_call, $cancel_function_call, $width=200);
							?>
						</td>
						<?php
						}
						?>
					</tr>
				<?php
				$count++;
			}
			?>
			</tbody>
		</table>
		<?php
	}

	public function listOwnedLabs($admin_user_id)
	{
		# Returns list of lab configurations / sites owned by the admin user
		$query_string =
			"SELECT * FROM lab_config WHERE admin_user_id=$admin_user_id";
		$resultset = query_associative_all($query_string, $row_count);
		$retval = "";
		if(count($resultset) == 0)
		{
			$retval = "-";
			return $retval;
		}
		foreach($resultset as $record)
		{
			$lab_config = LabConfig::getObject($record);
			$retval .= $lab_config->getSiteName()."<br>";
		}
		return $retval;
	}

	public function getLabConfigInfo($lab_config_id)
	{
		# Returns HTML displaying lab configuration info
		global $LIS_TECH_RW, $LIS_TECH_RO;
		$lab_config = get_lab_config_by_id($lab_config_id);
		if($lab_config == null)
		{
			?>
			<div class='sidetip_nopos'>Lab Configuration not found</div>
			<?php
			return;
		}
		?>
		<table class='hor-minimalist-b'>
			<tbody>
				<tr>
					<td>Facility Name</td>
					<td><?php echo $lab_config->name; ?></td>
				</tr>
				<tr>
					<td>Location</td>
					<td><?php echo $lab_config->location; ?></td>
				</tr>
				<tr>
					<td>Lab Manager</td>
					<td><?php echo get_username_by_id($lab_config->adminUserId); ?></td>
				</tr>
				<tr valign='top'>
					<td>Specimen Types</td>
					<td>
					<?php
					$specimen_list = get_specimen_types_by_site($lab_config_id);
					foreach($specimen_list as $specimen)
					{
 						echo $specimen->getName()."<br>";
					}
					?>
					</td>
				</tr>
				<tr valign='top'>
					<td>Test Types</td>
					<td>
					<?php
					$test_list = get_test_types_by_site($lab_config_id);
					foreach($test_list as $test)
					{
						echo $test->getName()."<br>";
					}
					?>
					</td>
				</tr>
				<tr valign='top'>
					<td>Technician Accounts</td>
					<td>
					<?php
					$user_list = get_tech_users_by_site_map($lab_config_id);
					foreach($user_list as $user_id=>$username)
					{
						$user = get_user_by_id($user_id);
						echo "$user->username [$user->actualName] ";
						if($user->level == $LIS_TECH_RW)
						{
							echo "Read-Write";
						}
						else if($user->level == $LIS_TECH_RO)
						{
							echo "Read-Only";
						}
						echo "<br>";
					}
					?>
					</td>
				</tr>
			</tbody>
		</table>
		<?php
	}

	public function getReportConfigInfo($report)
	{
		# Displays HTML for showing report configuration info
		if($report == null)
		{
			?>
			<div class='sidetip_nopos'>
				ERROR: Report type not found.
			</div>
			<?php
			return;
		}
		?>
		<table class='hor-minimalist-b'>
			<tbody>
				<tr valign='top'>
					<td>Report Name</td>
					<td><?php echo $report->name; ?></td>
				</tr>
				<tr valign='top'>
					<td>Group By Gender</td>
					<td>
					<?php
					if($report->groupByGender == 1)
						echo " Yes ";
					else
						echo " No ";
					?>
					</td>
				</tr>
				<tr valign='top'>
					<td>Group By Age</td>
					<td>
					<?php
					if($report->groupByAge == 1)
						echo " Yes ";
					else
						echo " No ";
					?>
					</td>
				</tr>
				<?php
				if($report->groupByAge == 1)
				{
				?>
				<tr valign='top'>
					<td>Age Slots (years)</td>
					<td>
						<?php
						$slot_count = 0;
						foreach($report->ageSlots as $age_slot)
						{
							echo $age_slot[0]."-".$age_slot[1];
							$slot_count++;
							if($slot_count < count($report->ageSlots))
								echo " , ";
						}
						?>
					</td>
				</tr>
				<?php
				}
				?>
			</tbody>
		</table>
		<?php
	}

	public function getLabConfigStatus_backup($lab_config_id)
	{
		$lab_config = get_lab_config_by_id($lab_config_id);
		if($lab_config == null)
		{
			# Error
			?>
			<div class='sidetip_nopos'>
			<?php echo LangUtil::$generalTerms['MSG_NOTFOUND']; ?>
			</div>
			<?php
			return;
		}
		?>
		<table class='hor-minimalist-b'>
			<thead>
				<tr>
					<th><b><?php echo $lab_config->getSiteName(); ?></b></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Total Patients</td>
					<td><?php echo get_lab_config_num_patients($lab_config_id); ?></td>
				</tr>
				<tr>
					<td>Total Specimens</td>
					<td><?php echo get_lab_config_num_specimens($lab_config_id); ?></td>
				</tr>
				<tr>
					<td>Pending Specimens -</td>
					<td><?php echo get_lab_config_num_specimens_pending($lab_config_id); ?></td>
				</tr>

				<?php
				$specimen_list = get_specimen_types_by_site($lab_config_id);
				foreach($specimen_list as $specimen_type)
				{
					?>
					<tr>
						<td>&nbsp;&nbsp;&nbsp;<?php echo $specimen_type->getName(); ?></td>
						<td><?php echo get_lab_config_num_specimens_pending($lab_config_id, $specimen_type->specimenTypeId); ?></td>
					</tr>
					<?php
				}
				?>

				<tr>
					<td>Pending Tests -</td>
					<td><?php echo get_lab_config_num_tests_pending($lab_config_id); ?></td>
				</tr>

				<?php
				$test_list = get_test_types_by_site_map($lab_config_id);
				foreach($test_list as $test_type_id=>$test_name)
				{
					?>
					<tr>
						<td>&nbsp;&nbsp;&nbsp;<?php echo $test_name; ?></td>
						<td><?php echo get_lab_config_num_tests_pending($lab_config_id, $test_type_id); ?></td>
					</tr>
					<?php
				}
				?>
			</tbody>
		</table>
		<?php
	}

	public function getLabConfigStatus($lab_config_id)
	{
		$lab_config = get_lab_config_by_id($lab_config_id);
		if($lab_config == null)
		{
			# Error
			?>
			<div class='sidetip_nopos'>
			<?php echo LangUtil::$generalTerms['MSG_NOTFOUND']; ?>
			</div>
			<?php
			return;
		}
		# TODO:
		$test_counts = get_tests_done_this_month($lab_config);
		?>
		<table class='hor-minimalist-b'>
			<thead>
				<tr>
					<th><b><?php echo $lab_config->getSiteName(); ?></b></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><?php echo LangUtil::$generalTerms['PENDING_RESULTS']; ?></td>
					<td><?php echo get_lab_config_num_tests_pending($lab_config_id); ?></td>
				</tr>

				<?php
				$test_list = get_test_types_by_site_map($lab_config_id);
				foreach($test_list as $test_type_id=>$test_name)
				{
					?>
					<tr>
						<td>&nbsp;&nbsp;&nbsp;<?php echo $test_name; ?></td>
						<td><?php echo get_lab_config_num_tests_pending($lab_config_id, $test_type_id); ?></td>
					</tr>
					<?php
				}
				?>
			</tbody>
		</table>
		<?php
	}

	public function getPatientInfo($pid, $width="")
	{
		# Returns HTML table displaying patient info
		$patient = get_patient_by_id($pid);
		if($patient == null)
		{
		?>
			<div class='sidetip_nopos'>
				<?php echo LangUtil::$generalTerms['PATIENT']." ".LangUtil::$generalTerms['MSG_NOTFOUND']; ?>
			</div>
		<?php
			return;
		}
		$lab_config = LabConfig::getById($_SESSION['lab_config_id']);
		?>
		<table class='hor-minimalist-b' <?php  if($width!="") echo " style='width:".$width."px;' "; ?>>
			<tbody>
				<?php
				//if($_SESSION['pid'] != 0)
				if(0)//$lab_config->pid != 0)
				{
				?>
				<tr valign='top'>
					<td><u><?php echo LangUtil::$generalTerms['PATIENT_ID']; ?></u></td>
					<td><?php echo $patient->surrogateId; ?></td>
				</tr>
				<?php
				}
				if($lab_config->patientAddl != 0)
				{
				?>
				<tr>
					<td><u><?php echo LangUtil::$generalTerms['ADDL_ID']; ?></u></td>
					<td>
						<?php echo $patient->getAddlId(); ?>
					</td>
				</tr>
				<?php
				}
				?>
				<tr>
					<td><u><?php echo LangUtil::$generalTerms['NAME']; ?></u></td>
					<td><?php echo $patient->getName(); ?></td>
				</tr>
				<tr valign='top'>
					<td><u>Satellite Lab ID</u></td>
					<td><?php echo $patient->getSatelliteLabId()?></td>
				</tr>
				<tr>
					<td><u><?php echo LangUtil::$generalTerms['GENDER']; ?></u></td>
					<td><?php echo $patient->sex; ?></td>
				</tr>
				<tr>
					<td><u><?php echo LangUtil::$generalTerms['AGE']; ?></u></td>
					<td>
						<?php
							echo $patient->getAge();
						?>
					</td>
				</tr>
				<?php
				//if($_SESSION['dob'] != 0)
				if($lab_config->dob != 0)
				{
				?>
				<tr>
					<td><u><?php echo LangUtil::$generalTerms['DOB']; ?></u></td>
					<td><?php
							echo $patient->getDob();
						?>
					</td>
				</tr>
				<?php
				}
				# Custom fields here
				$custom_data_list = get_custom_data_patient($patient->patientId);
				foreach($custom_data_list as $custom_data)
				{

						$field_name = get_custom_field_name_patient($custom_data->fieldId);
						if(stripos($field_name,"^^")!= NULL || $field_name!= "" )
					{
						$field_value = $custom_data->fieldValue;

					?>
					<tr>
						<td><u><?php

						echo $field_name; ?></u></td>
						<td>
							<?php
							echo $custom_data->getFieldValueString($lab_config->id , 2);
							?>
						</td>
					</tr>
					<?php
					}
				}
				?>
			</tbody>
		</table>

		<?php
	}

	public function getPatientUpdateForm($pid)
	{
		$patient = get_patient_by_id($pid);
		$lab_config = LabConfig::getById($_SESSION['lab_config_id']);
		?>
		<form name='profile_update_form' id='profile_update_form'>
		<input type='hidden' value='<?php echo $patient->patientId; ?>' name='patient_id'></input>
		<input type='hidden' value='0' name='pd_ym' id='pd_ym'></input>
		<input type='hidden' value='0' name='pd_y' id='pd_y'></input>
		<table class='hor-minimalist-b'>
			<tbody>
				<tr <?php
				if($lab_config->pid == 0)
				{
					echo " style='display:none;' ";
				}
				?>>
					<td><u><?php echo LangUtil::$generalTerms['PATIENT_ID']; ?></u></td>
					<td>
						<input type='text' name='surr_id' id='surr_id' value='<?php if($patient->surrogateId != undefined) { echo $patient->surrogateId; }?>' class='uniform_width'></input>
					</td>
				</tr>
				<tr>
					<td><u>Satellite Lab ID</u></td>
					<td>
						<select name='satellite_lab_id' id='satellite_lab_id' class='uniform_width'>
							<option value=''>Select Satellite Lab</option>
							<?php
							$satellite_lab_ids = get_all_satellite_lab_ids();
							$selected_satellite_lab_id = $patient->satelliteLabId;
							foreach ($satellite_lab_ids as $satellite_lab_id) {
								if ($satellite_lab_id == $selected_satellite_lab_id) {
									echo "<option value='{$satellite_lab_id}' selected>{$satellite_lab_id}</option>";
								}
								else {
									echo "<option value='{$satellite_lab_id}'>{$satellite_lab_id}</option>";
								}
							}
							?>
						</select>
					</td>
				</tr>
				<tr <?php
				if($lab_config->patientAddl == 0)
				{
					echo " style='display:none;' ";
				}
				?>>
					<td><u><?php echo LangUtil::$generalTerms['ADDL_ID']; ?></u></td>
					<td>
						<input type='text' value='<?php echo $patient->addlId; ?>' name='addl_id' class='uniform_width'></input>
					</td>
				</tr>
				<tr>
					<td><u><?php echo LangUtil::$generalTerms['NAME']; ?></u></td>
					<td>
					<input type='text' value='<?php echo $patient->name; ?>' name='name' class='uniform_width'></input>
					</td>
				</tr>
				<tr>
					<td><u><?php echo LangUtil::$generalTerms['GENDER']; ?></u></td>
					<td>
						<select name='sex'  class='uniform_width'>
						<option value='M'
						<?php
						if($patient->sex == 'M')
							echo " selected ";
						?>
						>
						<?php echo LangUtil::$generalTerms['MALE']; ?>
						</option>
						<option value='F'
						<?php
						if($patient->sex == 'F')
							echo " selected ";
						?>
						>
						<?php echo LangUtil::$generalTerms['FEMALE']; ?>
						</option>
						<option value='O'
						<?php
						if($patient->sex == 'O')
							echo " selected ";
						?>
						>
						<?php echo LangUtil::$generalTerms['OTHER']; ?>
						</option>
						</select>
				</tr>
				<tr>
					<td><u title='Enter either Age or Date of Birth'><?php echo LangUtil::$generalTerms['AGE']; ?></u></td>
					<td>
						<?php
						if($patient->age != null and $patient->age != "" and $patient->age != "0")
						{
						?>
							<input type='text' name='age' id='age' value='<?php  echo $patient->age; ?>'  class='uniform_width'></input>
						<?php
						}
						else
						{
						?>
							<input type='text' name='age' id='age' value=' <?php $pieces = explode(" ", $patient->getAge()); echo $pieces[0]  ?>'  class='uniform_width'></input>
						<?php
						}
						?>
						<select name='age_param' id='age_param'>
							<option value='1'><?php echo LangUtil::$generalTerms['YEARS']; ?></option>
							<option value='2'><?php echo LangUtil::$generalTerms['MONTHS']; ?></option>
						</select>
					</td>
				</tr>
				<tr valign='top'>
					<td><u title='Enter either Age or Date of Birth'><?php echo LangUtil::$generalTerms['DOB']; ?></u></td>
					<td><?php
						$value_list = array();
						$name_list = array();
						$id_list = array();
						$name_list[] = "yyyy";
						$name_list[] = "mm";
						$name_list[] = "dd";
						$id_list = $name_list;
						if($patient->partialDob != null && $patient->partialDob != "")
						{
							# Partial DoB value is present
							if(strpos($patient->partialDob, "-") === false)
							{
								# Year-only available
								$value_list[] = $patient->partialDob;
								$value_list[] = "";
								$value_list[] = "";
							}
							else
							{
								# Year and month available
								$partial_dob_parts = explode("-", $patient->partialDob);
								$value_list[] = $partial_dob_parts[0];
								$value_list[] = $partial_dob_parts[1];
								$value_list[] = "";
							}
						}
						else if($patient->dob == null || $patient->dob == "")
						{
							# DoB not previously entered
							$value_list[] = "";
							$value_list[] = "";
							$value_list[] = "";
						}
						else
						{
							# Previous DoB value exists
							$dob_parts = explode("-", $patient->dob);
							$value_list = $dob_parts;
						}
						$this->getDatePicker($name_list, $id_list, $value_list, $show_format=true);
						?>
					</td>
				</tr>
				<?php
				# Custom fields here
				$custom_field_list = get_custom_fields_patient();
				$custom_data_list = get_custom_data_patient($patient->patientId);
				$custom_data_map = array();
				foreach($custom_data_list as $custom_data)
				{
					$custom_data_map[$custom_data->fieldId] = $custom_data->fieldValue;
				}
				foreach($custom_field_list as $custom_field)
				{
					?>
					<tr valign='top'>
						<td><u><?php echo $custom_field->fieldName; ?></u></td>
						<td>
						<?php
							if(isset($custom_data_map[$custom_field->id]))
								$field_value = $custom_data_map[$custom_field->id];
							else
								$field_value = "";
							$this->getCustomFormField($custom_field, $field_value);
						?>
						</td>
					</tr>
					<?php
				}
				?>
				<tr>
					<td>
					</td>
					<td>
						<input type='button' value='<?php echo LangUtil::$generalTerms['CMD_UPDATE']; ?>' onclick='javascript:update_profile();'></input>
						&nbsp;&nbsp;&nbsp;
						<a href='javascript:toggle_profile_divs();'><?php echo LangUtil::$generalTerms['CMD_CANCEL']; ?></a>
						&nbsp;&nbsp;&nbsp;
						<span id='update_profile_progress' style='display:none;'><?php $this->getProgressSpinner(LangUtil::$generalTerms['CMD_SUBMITTING']); ?></span>
					</td>
				</tr>
			</tbody>
		</table>
		</form>
	<?php
	}

	public function getSelectSpecimenInfoRow($specimen, $rem_specs, $admin)
	{
		# Returns HTML table row containing specimen info
		# Called by getPatientHistory() function

		?>
		<form name="f1" id="f1">

		<tr valign='top'>
			<?php
			if($_SESSION['s_addl'] != 0)
			{
			?>
				<td>
					<?php echo $specimen->getAuxId(); ?>
				</td>
			<?php
			}
			?>
			<td>
				<?php echo get_specimen_name_by_id($specimen->specimenTypeId); ?>
			</td>
			<td>
				<?php echo DateLib::mysqlToString($specimen->dateRecvd); ?>
			</td>
			<td>
				<?php if($admin == 1)
                                     {
                                        if(in_array($specimen->specimenId, $rem_specs))
                                        {
                                            echo "Removed";
                                        }
                                        else
                                        {
                                            echo $specimen->getStatus();
                                        }
                                     }
                                     else
                                     {
                                         echo $specimen->getStatus();
                                     }
                                ?>
			</td>
			<td>
				<a href='specimen_info.php?sid=<?php echo $specimen->specimenId; ?>' title='Click to View Details of this Specimen'><?php echo LangUtil::$generalTerms['DETAILS']; ?></a>
			</td>
			<?php
			$sid=$specimen->specimenId;
			$pid=$specimen->patientId;

			?>
			<td><input id="liked" type="checkbox" name="liked" value=<?php echo $specimen->specimenId; ?>> </td>
		</tr>
		</form>
		<?php
	}
	public function getSpecimenInfoRow($specimen, $rem_specs, $admin)
	{
		# Returns HTML table row containing specimen info
		# Called by getPatientHistory() function
                $specimenBarcode = specimenBarcodeCheck();
		?>

		<tr valign='top'>
			<?php
			if($_SESSION['s_addl'] != 0)
			{
			?>
				<td>
					<?php echo $specimen->getAuxId(); ?>
				</td>
			<?php
			}
			?>
			<td>
				<?php echo get_specimen_name_by_id($specimen->specimenTypeId); ?>
			</td>
			<td>
				<?php echo DateLib::mysqlToString($specimen->dateRecvd); ?>
			</td>
			<td>
				<?php
				$removed = false;

				//print_r($rem_specs);
				if($admin == 1)
                                     {

                                        if(in_array($specimen->specimenId, $rem_specs))
                                        {
                                            echo "Removed";
                                            $removed = true;
                                        }
                                        else
                                        {
                                            echo $specimen->getStatus();
                                        }
                                     }
                                     else
                                     {
                                         echo $specimen->getStatus();
                                     }
                                ?>
			</td>
			<td>
				<a href='specimen_info.php?sid=<?php echo $specimen->specimenId; ?>' title='Click to View Details of this Specimen'><?php echo LangUtil::$generalTerms['DETAILS']; ?></a>
			</td>
			<?php
			$sid=$specimen->specimenId;
			$pid=$specimen->patientId;

			?>
			<td>
			<a href="javascript:get_report(<?php echo $pid;?>,<?php echo $sid;?> )">Report</a> </td>
			<td><!-- <a href="javascript:update_specimen(<?php echo $sid;?>)"> Update</a> &nbsp;/&nbsp; -->
			<?php if($removed == false){?>
			<a href="javascript:delete_specimen(<?php echo $sid;?>)"> Delete</a>
			<?php } else {
					if(is_admin_check(get_user_by_id($_SESSION['user_id']))){
						?>
						<a href="javascript:retrieve_deleted(<?php echo $sid;?>,'specimen')"> Retrieve</a>
					<?php } else {
			   echo "Request Admin to undo delete";
			   }
			}?>
			</td>
                        <?php
                            if($specimenBarcode)
                            {
                            ?>
                                <td><a href="javascript:print_specimen_barcode(<?php echo $pid;?>,<?php echo $sid;?> )">Print Barcode</a> </td>
                            <?
                            }

                        ?>
		</tr>
		<?php
	}

	public function getSpecimenExceededInfoRow($specimen, $count)
	{
		# Returns HTML table row containing specimen info
		# Called by getPatientHistory() function
		?>
		<tr valign='top'>
			<td>
				<?php echo $count; ?>.
			</td>
			<td>
				<?php echo $specimen->specimenId; ?>
			</td>
			<td>
				<?php echo get_specimen_name_by_id($specimen->specimenTypeId); ?>
			</td>
			<td>
				<?php echo $specimen->getTestNames(); ?>
			</td>
			<td>
				<?php echo DateLib::mysqlToString($specimen->dateCollected)." ".$specimen->timeCollected; ?>
			</td>
			<td>
				<?php echo get_username_by_id($specimen->userId); ?>
			</td>
		</tr>
		<?php
	}

	public function getPatientHistory($pid)
	{
		# Returns HTML table displaying patient test history
                $admin = 0;
                $specimenBarcode = specimenBarcodeCheck();
                if(is_admin(get_user_by_id($_SESSION['user_id']))) {
                    $admin = 1;}
                $rem_recs = get_removed_specimens($_SESSION['lab_config_id'], "specimen");
                $rem_specs = array();
                $rem_remarks = array();
                foreach($rem_recs as $rem_rec)
                {
                    $rem_specs[] = $rem_rec['r_id'];
                    $rem_remarks[] = $rem_rec['remarks'];
                }

		$specimen_list = get_specimens_by_patient_id($pid);
		if(count($specimen_list) == 0)
		{
			?>
			<br>
			<div class='sidetip_nopos'><?php echo LangUtil::$generalTerms['TESTS']." - ".LangUtil::$generalTerms['MSG_NOTFOUND']; ?></div>
			<?php
			return;
		}
		?>
		<script type='text/javascript'>
		$(document).ready(function(){
			$('#test_history_table').tablesorter();
		});

		function get_report(pid,sid)
		{
			var url_string = "report_onetesthistory.php?ppid="+pid+"&spid="+sid;
			window.open(url_string);
		}

		function delete_specimen(sid){
			if(ConfirmDelete()){
				var params = "specimen_id="+sid;
				//alert("patient Id " + patient_id);
				$.ajax({
					type: "POST",
					url: "ajax/delete_specimen.php",
					data: params,
					success: function(msg) {
						if(msg.indexOf("1")> -1){
							// refresh the page with updated specimen details
							location.href = location.href + '&del=1';
						} else {
							$("#target_div_id_del").html("Specimen cannot be deleted");
						}

					}
				});

			}
		}

		function update_specimen(sid){

		}

		function ConfirmDelete()
		{
		  var x = confirm("Are you sure you want to delete?");
		  if (x)
		      return true;
		  else
		    return false;
		}

		</script>
		<table class='tablesorter' id='test_history_table'>
			<thead>
				<tr valign='top'>
					<?php
					if($_SESSION['s_addl'] != 0)
					{
					?>
					<th><?php echo LangUtil::$generalTerms['SPECIMEN_ID']; ?></th>
					<?php
					}
					?>
					<th><?php echo LangUtil::$generalTerms['TYPE']; ?></th>
					<th><?php echo LangUtil::$generalTerms['R_DATE']; ?></th>
					<th><?php echo LangUtil::$generalTerms['SP_STATUS']; ?></th>
					<th></th>
					<th></th>
					<!-- Deleting the patient specimen -->
					<th></th>
                                        <?php
                            if($specimenBarcode)
                            {
                            ?>
                                 <th></th>
                            <?
                            }

                        ?>
				</tr>
			</thead>
			<tbody>
			<?php
			foreach($specimen_list as $specimen)
			{

                            if($admin == 0)
                            {
                                if(in_array($specimen->specimenId, $rem_specs))
                                    continue;
                            }
                            //echo $admin. " admin";
				$this->getSpecimenInfoRow($specimen, $rem_specs, $admin);
			}
			?>
			</tbody>
		</table>
		<?php
		# TODO: Add paging to this table
	}

	public function getSelectPatientHistory($pid, $labsection)
	{
		# Returns HTML table displaying patient test history
                $admin = 0;
                if(is_admin(get_user_by_id($_SESSION['user_id']))) {
                    $admin = 1;}
                $rem_recs = get_removed_specimens($_SESSION['lab_config_id'], "specimen");
                $rem_specs = array();
                $rem_remarks = array();
                foreach($rem_recs as $rem_rec)
                {
                    $rem_specs[] = $rem_rec['r_id'];
                    $rem_remarks[] = $rem_rec['remarks'];
                }

		$specimen_list = get_specimens_by_patient_id($pid, $labsection);
		if(count($specimen_list) == 0)
		{
			?>
			<br>
			<div class='sidetip_nopos'><?php echo LangUtil::$generalTerms['TESTS']." - ".LangUtil::$generalTerms['MSG_NOTFOUND']; ?></div>
			<?php
			return;
		}
		?>
		<script type='text/javascript'>
		$(document).ready(function(){
			$('#test_history_table').tablesorter();
		});


		</script>
		<table class='tablesorter' id='test_history_table'>
			<thead>
				<tr valign='top'>
					<?php
					if($_SESSION['s_addl'] != 0)
					{
					?>
					<th><?php echo LangUtil::$generalTerms['SPECIMEN_ID']; ?></th>
					<?php
					}
					?>
					<th><?php echo LangUtil::$generalTerms['TYPE']; ?></th>
					<th><?php echo LangUtil::$generalTerms['R_DATE']; ?></th>
					<th><?php echo LangUtil::$generalTerms['SP_STATUS']; ?></th>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			<?php
			foreach($specimen_list as $specimen)
			{
                            if($admin == 0)
                            {
                                if(in_array($specimen->specimenId, $rem_specs))
                                    continue;
                            }

				$this->getSelectSpecimenInfoRow($specimen, $rem_specs, $admin);
			}
			?>
			</tbody>
		</table>
		<?php
		# TODO: Add paging to this table
	}


		public function getPatientSelectReport($patient_id)
	{
	?><!--'reports_testhistory.php?location=<?php echo $_SESSION['lab_config_id']; ?>&patient_id=<?php echo $patient_id; ?>'-->
				<a href='javascript:get_select_tests(<?php echo $patient_id;?>);' title='Click to Generate Test History Report for this Patient'>
					<?php echo LangUtil::$pageTerms['MSG_PRINTHISTORY']; ?>
				</a>
	<?php
	}

        public function getDeleteOptions($patient_id)
	{
	?><!--'reports_testhistory.php?location=<?php echo $_SESSION['lab_config_id']; ?>&patient_id=<?php echo $patient_id; ?>'-->
				<a href='javascript:get_select_tests_del(<?php echo $patient_id;?>);' title='Click here to Delete the selected Tests'>
					<?php echo "Remove Selected Specimens"; ?>
				</a>
	<?php
	}

        public function getUnDeleteOptions($patient_id)
	{
	?><!--'reports_testhistory.php?location=<?php echo $_SESSION['lab_config_id']; ?>&patient_id=<?php echo $patient_id; ?>'-->
				<a href='javascript:get_select_tests_undel(<?php echo $patient_id;?>);' title='Click here to Retrieve deleted Tests'>
					<?php echo "Retrieve Deleted Specimens"; ?>
				</a>
	<?php
	}

	public function getPostSpecimenEntryTaskList($patient_id)
	{
		?>
			<div class='sidetip_nopos'>
				<p>
					<a rel='facebox' href='bill_generator.php?location=<?php echo$_SESSION['lab_config_id']; ?>&patient_id=<?php echo $patient_id; ?>' title='Click to generate a billing statement for this Patient' target='_blank'>
						<?php echo "Billing Report" ?>
					</a>
				</p>
			</div>
		<?php
	}

	public function getPatientTaskList($patient_id)
	{
		$patient = get_patient_by_id($patient_id);
		$patient_num =$patient->getDailyNum();
		$pieces = explode("-", $patient_num);

		# Lists patient-profile related tasks in a tips box
            $patientBarcodes = patientBarcodeCheck();
		global $LIS_TECH_RO, $DISABLE_UPDATE_PATIENT_PROFILE, $LIS_SATELLITE_LAB_USER;
		if($_SESSION['user_level'] != $LIS_TECH_RO)
		{
		?>
			<div class='sidetip_nopos'>
			<p>
				<?php
				// Exclude "new_specimen.php" option for satellite user
				if ($_SESSION['user_level'] != $LIS_SATELLITE_LAB_USER){
				?>
					<a href='new_specimen.php?pid=<?php echo $patient_id; ?>&dnum=<?php echo $pieces[1]; ?>' title='Click to Register a New Specimen for this Patient'>
						<?php echo LangUtil::$pageTerms['MSG_REGNEWSPECIMEN']; ?>
					</a>
				<?php
				}
				?>
			</p>
			<?php
			if(($DISABLE_UPDATE_PATIENT_PROFILE === false)&&(get_level_by_id($_SESSION['user_id']) ==2)) {
				?>
				<p>
					<a href='javascript:toggle_profile_divs();' title='Click to Update Patient Profile'>
						<?php echo LangUtil::$pageTerms['MSG_UPDATEPROFILE']; ?>
					</a>

				</p>
				<?php
			}
			?>
			<p>
				<a href='reports_testhistory.php?location=<?php echo $_SESSION['lab_config_id']; ?>&patient_id=<?php echo $patient_id; ?>' title='Click to Generate Test History Report for this Patient' target='_blank'>
					<?php echo LangUtil::$pageTerms['MSG_PRINTHISTORY']; ?>
				</a>
			</p>
                        <?php
			if($patientBarcodes == 1)
			{
				?>
				<p>
					<a href='javascript:print_patient_barcode();' title='Click to Print Patient Barcode'>
						<?php echo "Print Patient Barcode" ?>
					</a>

				</p>
				<?php
			}
			?>
			<!--<p><a href='#'>Export as XML</a></p>-->
				<?php
				if (is_billing_enabled($_SESSION['lab_config_id']))
					{ ?>
				<p>
					<a rel='facebox' href='bill_generator.php?location=<?php echo$_SESSION['lab_config_id']; ?>&patient_id=<?php echo $patient_id; ?>' title='Click to generate a billing statement for this Patient' target='_blank'>
						<?php echo "Billing Report" ?>
					</a>
				</p>
				<?php } ?>
			</div>
		<?php
		}
	}

	public function getSpecimenInfo($sid)
	{
		# Returns HTML table displaying specimen info
		$specimen = get_specimen_by_id($sid);


		//print_r($rem_specs);
		if($specimen == null)
		{
			?>
			<div class='sidetip_nopos'>
				<?php echo LangUtil::$generalTerms['ERROR'].": ".LangUtil::$generalTerms['SPECIMEN_ID']." ".LangUtil::$generalTerms['MSG_NOTFOUND']; ?>
			</div>
			<?php
			return;
		}

		$rem_recs = get_removed_specimens($_SESSION['lab_config_id'], "specimen");
		$rem_specs = array();
		$rem_remarks = array();
		foreach($rem_recs as $rem_rec)
		{
			$rem_specs[] = $rem_rec['r_id'];
			$rem_remarks[] = $rem_rec['remarks'];
		}



		?>

		<script type="text/javascript">
		function retrieve_deleted(sid, category){
			var params = "item_id="+sid+"&ret_cat="+category;
			 $.ajax({
				type: "POST",
				url: "ajax/retrieve_deleted.php",
				data: params,
				success: function(msg) {
					if(msg.indexOf("1")> -1){
						location.href = location.href;
					} else {
						$("#target_div_id_del").html("Specimen cannot be Retrieved");
					}

				}
			});

		}

		</script>
		<table class='hor-minimalist-b'>
			<tbody>
				<tr>
					<td><u><?php echo LangUtil::$generalTerms['TYPE']; ?></u></td>
					<td><?php echo get_specimen_name_by_id($specimen->specimenTypeId); ?></td>
				</tr>
				<?php
				if($_SESSION['sid'] != 0)
				{
				?>
				<tr valign='top' style='display:none;'>
					<td><u>DB Key</u></td>
					<td><?php echo $specimen->specimenId; ?></td>
				</tr>
				<?php
				}
				if($_SESSION['s_addl'] != 0)
				{
				?>
				<tr>
					<td><u><?php echo LangUtil::$generalTerms['SPECIMEN_ID']; ?></u></td>
					<td><?php $specimen->getAuxId(); ?></td>
				</tr>
				<?php
				}
				if($_SESSION['dnum'] != 0)
				{
				?>
				<tr>
					<td><u><?php echo LangUtil::$generalTerms['PATIENT_DAILYNUM']; ?></u></td>
					<td><?php echo $specimen->getDailyNum(); ?></td>
				</tr>
				<?php
				}
				?>
				<tr valign='top'>
					<td><u><?php echo LangUtil::$generalTerms['ACCESSION_NUM']; ?></u></td>
					<td><?php echo $specimen->sessionNum; ?></td>
				</tr>
				<tr>
					<td><u><?php echo LangUtil::$generalTerms['PATIENT']; ?></u></td>
					<td>
						<?php
						$patient = Patient::getById($specimen->patientId);
						echo $patient->getName()." (".$patient->sex." ".$patient->getAge().")";
						?>
						&nbsp;&nbsp;
						<a href='patient_profile.php?pid=<?php echo $specimen->patientId?>' title='Click to go to Patient Profile'>Profile</a>
					</td>
				</tr>
				<tr>
					<td><u><?php echo LangUtil::$generalTerms['R_DATE']; ?></u></td>
					<td>
						<?php echo DateLib::mysqlToString($specimen->dateRecvd); ?>
					</td>
				</tr>
				<tr>
					<td><u><?php echo LangUtil::$generalTerms['REGD_BY']; ?></u></td>
					<td><?php echo get_username_by_id($specimen->userId); ?></td>
				</tr>
				<?php
				if($_SESSION['comm'] != 0)
				{
				?>
				<tr>
					<td><u><?php echo LangUtil::$generalTerms['COMMENTS']; ?></u></td>
					<td><?php echo $specimen->getComments(); ?></td>
				</tr>
				<?php
				}
				?>
				<tr valign='top'>
					<td><u><?php echo LangUtil::$generalTerms['TESTS']; ?></u></td>
					<td><?php echo $specimen->getTestNames(); ?></td>
				</tr>
				<?php
				if($_SESSION['doctor'] != 0)
				{
					?>
					<tr>
						<td><u><?php echo LangUtil::$generalTerms['DOCTOR']; ?></u></td>
						<td>
						<?php
						if(trim($specimen->doctor) == "")
						{
							echo "-";
						}
						else
						{
							echo  $specimen->doctor;
						}
						?>
						</td>
					</tr>
					<?php
				}
				?>
				<?php
				# Custom fields here
				$custom_data_list = get_custom_data_specimen($specimen->specimenId);
				foreach($custom_data_list as $custom_data)
				{
					$field_name = get_custom_field_name_specimen($custom_data->fieldId);
					if(stripos($field_name ,"^^")==NULL)
					{
					$field_value = $custom_data->fieldValue;
					?>
					<tr>
						<td><u><?php echo $field_name; ?></u></td>
						<td><input type="text" value="<?php echo $custom_data->getFieldValueString($_SESSION['lab_config_id'], 1); ?>" /></td>
					</tr>
					<?php
					}
				}
				if($_SESSION['refout'] != 0)
				{
				# Show referred-out hospital name if specimen was referred out and/or returned back
				if
				(
					$specimen->statusCodeId == Specimen::$STATUS_REFERRED ||
					$specimen->statusCodeId == Specimen::$STATUS_RETURNED
				)
				{
					if(strlen(trim($specimen->referredToName)) > 0){
					?>

					<tr>
						<td><u><?php echo LangUtil::$generalTerms['REF_TO']; ?></u></td>
						<td>
						<?php
						if(trim($specimen->referredToName) == "")
						{
							echo "Not Known";
						}
						else
						{
							echo $specimen->referredToName;
						}
						?>
						</td>
					</tr>
					<?php }
					if(strlen(trim($specimen->referredFromName)) > 0){
					?>
					<tr>
						<td><u><?php echo "Referred From "; ?></u></td>
						<td>
						<?php
						if(trim($specimen->referredFromName) == "")
						{
							echo "Not Known";
						}
						else
						{
							echo $specimen->referredFromName;
						}
						?>
						</td>
					</tr>
					<?php
						}
				}
				}
				?>
				<tr>
					<td><u><?php echo LangUtil::$generalTerms['SP_STATUS']; ?></u></td>
					<td>
					<?php
					if(in_array($specimen->specimenId, $rem_specs) && is_admin(get_user_by_id($_SESSION['user_id']))!=1){
						echo "Specimen Removed. Contact lab admin";
					} else if(in_array($specimen->specimenId, $rem_specs) && is_admin(get_user_by_id($_SESSION['user_id']))==1){
					?> <a href='javascript:retrieve_deleted(<?php echo $specimen->specimenId;?>, "specimen")' title='Click to retrieve deleted Specimen'>Retrieve Specimen</a>
					<?php
					} else {
					echo $specimen->getStatus();
					$result1="Completed";
					$result= $specimen->getStatus();
					?> <a href='specimen_result.php?sid=<?php echo $specimen->specimenId;?>'
					<?php if(strcmp($result,$result1)==0 || $_SESSION['user_level'] == 17){ ?> style='display:none;' <?php }?>
					title='Click to Enter result values for this Specimen'><?php echo LangUtil::$generalTerms['ENTER_RESULTS']; ?></a>
					<?php }
					?>
					</td>
				</tr>
			</tbody>
		</table>
		<?php
	}


	public function getSpecimenTaskList($specimen_id)
	{
		# Lists patient-profile related tasks in a tips box
		global $LIS_CLERK,$LIS_VERIFIER;
		$specimen = Specimen::getById($specimen_id);
		$test = Test::getTestBySpecimenID($specimen_id);
		$print_unverified = LabConfig::getPrintUnverified($_SESSION['lab_config_id']);
		$deleted = false;
		if(check_removal_record($_SESSION['lab_config_id'], $specimen_id, "specimen")){
			$deleted = true;
		}
		?>
		<div class='sidetip_nopos'>
			<?php
			$date_parts = explode("-", $specimen->dateCollected);
			$report_url = "reports_testhistory.php?location=".$_SESSION['lab_config_id']."&patient_id=".$specimen->patientId."&yf=$date_parts[0]&mf=$date_parts[1]&df=$date_parts[2]&yt=$date_parts[0]&mt=$date_parts[1]&dt=$date_parts[2]";
			//$report_url = "reports_specimen.php?location=".$_SESSION['lab_config_id']."specimen_id=".$specimen_id;
			if($test->isVerified() || $print_unverified) {
				?>
				<p><a href='<?php echo $report_url; ?>' title='Click to Generate Specimen Report' target='_blank'><?php echo LangUtil::$generalTerms['CMD_GETREPORT']; ?></a></p>
				<?php
			}
			?>
			<p><a href='reports_specimenlog.php?location=<?php echo $_SESSION['lab_config_id']; ?>&specimen_id=<?php echo $specimen_id; ?>' title='Click to View a Log of Actions Performed on this Specimen' target='_blank'><?php echo LangUtil::$generalTerms['CMD_TRACK']; ?></a></p>
			<?php
			if($_SESSION['user_level'] != $LIS_CLERK && $deleted == false)
			{
				$user = get_user_by_id($_SESSION['user_level']);
				if
				( $specimen->statusCodeId == Specimen::$STATUS_TOVERIFY || $specimen->statusCodeId == Specimen::$STATUS_DONE )
				{

					?>
					<p><a href='specimen_verify.php?sid=<?php echo $specimen_id; ?>' title='Click to Verify or Update result values for this Specimen'><?php echo LangUtil::$generalTerms['CMD_VERIFY']; ?></a></p>
					<?php

				}
				else
				{
					?>
					<p><a href='javascript:fetch_specimen2(<?php echo $specimen_id;  ?>);' title='Click to Enter result values for this Specimen'><?php echo LangUtil::$generalTerms['ENTER_RESULTS']; ?></a></p>
					<?php
				}
			}
			?>

		</div>
		<?php
	}

	public function getSpecimenTestsTable($sid)
	{
		# Displays list of all tests registered for a specimen w/ status/results

		$test_list = get_tests_by_specimen_id($sid);
		if(count($test_list) == 0)
		{
			?>
			<br>
			<div class='sidetip_nopos'><?php echo LangUtil::$pageTerms['TIPS_NOTESTSREGD']; ?></div>
			<?php
			return;
		}

		?>
		<script type='text/javascript'>
		$(document).ready(function(){
			$('#specimen_tests_table').tablesorter();
		});

		function delete_test(test_id){
			if(ConfirmDelete()){
				//alert("Test with ID "+test_id+" will be deleted");
				var params = "test_id="+test_id;
				$.ajax({
					type: "POST",
					url: "ajax/delete_test.php",
					data: params,
					success: function(msg) {
						if(msg.indexOf("1")> -1){
							location.href = location.href + '&del=1';
						} else {
							$("#target_div_id_del").html("Test cannot be deleted");
						}

					}
				});
			}
		}


		function ConfirmDelete()
		{
		  var x = confirm("Are you sure you want to delete?");
		  if (x)
		      return true;
		  else
		    return false;
		}

		</script>
		<table class='tablesorter' id='specimen_tests_table'>
			<thead>
				<tr valign='top'>
					<th><?php echo LangUtil::$generalTerms['TEST']; ?></th>
					<th><?php echo LangUtil::$generalTerms['RESULTS']; ?></th>
					<th><?php echo LangUtil::$generalTerms['RESULT_COMMENTS']; ?></th>
					<th><?php echo LangUtil::$generalTerms['ENTERED_BY']; ?></th>
					<th><?php echo LangUtil::$generalTerms['VERIFIED_BY']; ?></th>
					<th><?php echo LangUtil::$generalTerms['ACTIONS']; ?></th>

				</tr>
			</thead>
			<tbody>
			<?php
			foreach($test_list as $test)
			{
				$this->getTestInfoRow($test);
			}
			# TODO: Add paging to this table
			?>
			</tbody>
		</table>
		<?php
	}

	public function getTestInfoRow($test)
	{
		# Returns HTML table row containing specimen info
		# Called by getSpecimenTestsTable() function
		?>
		<tr valign='top'>
			<td>
				<?php echo get_test_name_by_id($test->testTypeId); ?>
			</td>
			<td>
				<?php
				if($test->isPending())
					echo LangUtil::$generalTerms['PENDING_RESULTS'];
				else
					echo $test->decodeResult(false,false);
				?>
			</td>
			<td>
				<?php echo $test->getComments(); ?>
			</td>
			<td>
				<?php echo get_username_by_id($test->userId); ?>
			</td>
			<td>
				<?php echo $test->getVerifiedBy(); ?>
			</td>
			<td>

			<?php
					if(check_removal_record($_SESSION['lab_config_id'], $test->testId) && is_admin(get_user_by_id($_SESSION['user_id']))!=1){
						echo "Test removed. Contact Lab admin";
					} else if(check_removal_record($_SESSION['lab_config_id'], $test->testId) && is_admin(get_user_by_id($_SESSION['user_id']))==1){
					?> <a href='javascript:retrieve_deleted(<?php echo $test->testId;?>, "test")' title='Click to retrieve deleted Test'>Retrieve Test</a>
					<?php
					} else {
					?>
						<a href="javascript:delete_test(<?php echo  $test->testId ;?>)">Delete</a>
					<?php }
					?>



			</td>
			<?php
			$specimen_object=Specimen::getById($test->specimenId);
			$pid=$specimen_object->patientId;
			$sid=$test->specimenId;

			?>
			<!--<td><a href="javascript:get_report(<?php echo $pid;?>,<?php echo $sid;?> )">Report</a> </td>-->

		</tr>
		<?php
	}


	public function getTatStatsTable($lab_config, $date_from, $date_to)
	{
		# Returns HTML table showing Turnaround time values
		# Called from reports_tat.php
		?>
		<script type='text/javascript'>
		$(document).ready(function(){
			$('#tat_table').tablesorter();
		});
		</script>
		<table class='tablesorter' id='tat_table'>
		<thead>
			<tr>
				<th>Test Type</th>
				<th>Specimens Handled</th>
				<th>Average Turnaround Time</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$stat_list = StatsLib::getTatStats($lab_config, $date_from, $date_to);
		foreach($stat_list as $key=>$value)
		{
			$test_type_id = $key;
			$tat_value = $value[0];
			$num_specimens = $value[1];
			?>
			<tr>
				<td><?php echo get_test_name_by_id($test_type_id); ?></td>
				<td><?php echo $num_specimens; ?></td>
				<td>
					<?php
					$days = floor($tat_value);
					$hours = floor(($tat_value - $days)*24);
					$mins = floor(((($tat_value - $days)*24) - $hours)*60);
					$avg_tat = "";
					if($days > 0) {
						$avg_tat = $avg_tat.$days." days ";
					}
					if($hours > 0) {
						$avg_tat = $avg_tat.$hours." hours ";
					}
					if($mins > 0) {
						$avg_tat = $avg_tat.$mins." mins";
					}
					echo $avg_tat;
					?>
				</td>
			</tr>
			<?php
		}
		?>
		</tbody>
		</table>
		<?php
	}

public function getStockOutDetails($retval)
{
	?>
		<script type='text/javascript'>
		$(document).ready(function(){
			$('#current_inventory').tablesorter();
		});
		</script>
	<table class='tablesorter' id='current_inventory' style='width:500px'>
		<thead>
	<tr>
	<th>Reagent Name</th>
	<th>Lot Number</th>
	<th>Quantity Checked Out</th>
	<th>Date of Issue</th>
	<th>User Name</th>
	<th>Current Quantity</th>
</tr>
<thead>
<tbody>
<?php
foreach($retval as $value)
{
?>
<tr>
<td><?php echo $value[0]; ?></td>
<td><?php echo $value[1];?></td>
<td><?php echo $value[2]; ?></td>
<td><?php echo $value[3]; ?></td>
<td><?php echo $value[4]; ?></td>
<td><?php echo $value[5]; ?></td>

</tr>
<?php } ?>
</tbody>
</table>
<?php
}

public function getInventory($retval) {
?>
	<script type='text/javascript'>
		$(document).ready(function(){
			$('#current_inventory').tablesorter();
		});
	</script>
	<table class='tablesorter' id='current_inventory' style='width:500px'>
		<thead>
			<tr>
				<th>Reagent Name</th>
				<th>Lot Number</th>
				<th>Current Stock</th>
			</tr>
		<thead>
		<tbody>
		<?php
			foreach($retval as $value) {
		?>
			<tr>
				<td><?php echo $value[0]; ?></td>
				<td><?php echo $value[3]; ?></td>
				<td><?php echo $value[1];?></td>
			</tr>
		<?php
			}
		?>
		</tbody>
	</table>
<?php
}

public function getTestsDoneStatsTable($stat_list)
	{
		# Returns HTML table showing number of tests performed
		# Called from reports_tests_done.php
		?>
		<script type='text/javascript'>
		$(document).ready(function(){
			$('#testsdone_table').tablesorter();
		});
		</script>
		<table class='tablesorter' id='testsdone_table' style='width:500px'>
		<thead>
			<tr>
				<th><?php echo LangUtil::$generalTerms['TEST_TYPE']; ?></th>
				<th> Completed Tests</th>
				<th> Pending Tests</th>
			</tr>
		</thead>
		<tbodys>
		<?php
		$total_tests_done_count = 0;
		$total_tests_pending_count = 0;
		foreach($stat_list as $key=>$value)
		{
			$test_type_id = $key;
			$tests_done_count = $value[0];
			$tests_pending_count = $value[1];
			$total_tests_done_count = $total_tests_done_count + $tests_done_count;
			$total_tests_pending_count = $total_tests_pending_count + $tests_pending_count;
			?>
			<tr>
			<td><?php
					if( is_numeric($test_type_id) )
						echo get_test_name_by_id($test_type_id);
					else
						echo $test_type_id;
			?></td>
			<td><?php echo $tests_done_count; ?></td>
			<td><?php echo $tests_pending_count; ?></td>
			</tr>
			<?php
		}
		?>

		<tr>
			<td><?php
			echo LangUtil::$pageTerms['TOTAL_TESTS'];
			?></td>
			<td><?php echo $total_tests_done_count; ?></td>
			<td><?php echo $total_tests_pending_count; ?></td>
			</tr>
		</tbody>
		</table>
		<?php
	}
	public function getDoctorStatsTable($stat_list, $dateFrom = null, $dateTo = null, $location = null)
	{

		# Returns HTML table showing number of specimens handled
		# Called from reports_specimencount.php
		?>
		<script type='text/javascript'>
		$(document).ready(function(){
			$('#doctorstats_table').tablesorter();
		});
		</script>
		<table class='tablesorter' id='doctorstats_table' style='width:500px'>
		<thead>
			<tr>
				<th><?php echo LangUtil::$generalTerms['DOCTOR_NAME']; ?></th>
				<th><?php echo LangUtil::$pageTerms['TOTAL_PATIENTS']; ?></th>
				<th><?php echo LangUtil::$pageTerms['TOTAL_SPECIMENS']; ?></th>
				<th><?php echo LangUtil::$pageTerms['TOTAL_TESTS']; ?></th>
				<th><?php echo "Edit Toggle"; ?></th>
			</tr>
		</thead>
		<tbody>
		<?php
		$count = 1;
		$grand_total_patients=0;
		$grand_total_specimens=0;
		$grand_total_tests=0;
		if(empty($stat_list)===false)
		foreach($stat_list as $key=>$value)
		{
			$doctor_name=$key;
			$total_patients=$value[0];
			$total_specimens=$value[1];
			$total_tests=$value[2];

			///grand totals
			$grand_total_patients += $total_patients;
			$grand_total_specimens += $total_specimens;
			$grand_total_tests += $total_tests;

			?>
			<tr>
				<td><form id='updateDoctorNameForm<?php echo $count; ?>' name='updateDoctorName<?php echo $count; ?>' action='ajax/UpdateDoctorNames.php?id=<?php echo $count; ?>' method='POST'>
					<input type='hidden' id='dateFrom' name='dateFrom' value=<?php echo $dateFrom; ?>
					<input type='hidden' id='dateTo' name='dateTo' value=<?php echo $dateTo; ?>
					<input type='hidden' id='location' name='location' value=<?php echo $location; ?>
					<div id='originalDoctorNameDiv<?php echo $count; ?>' name='originalDoctorNameDiv<?php echo $count; ?>' >
						<input type='text' id='originalDoctorName<?php echo $count; ?>' name='originalDoctorName<?php echo $count; ?>' value='<?php echo $doctor_name; ?>' readonly></input>
					</div>
					<div id='newDoctorName<?php echo $count; ?>' style='display:none'>
						<br>
						<input type='text' id='newDoctorNameInput<?php echo $count; ?>' name='newDoctorNameInput<?php echo $count; ?>'></input>
						<input type='button' id='submitNewName<?php echo $count; ?>' name='submitNewName<?php echo $count; ?>' value='Update' onclick='updateDoctorName(<?php echo $count; ?>)'></input>
					</div>
					</form>
				</td>
				<td><?php echo $total_patients; ?></td>
				<td><?php echo $total_specimens; ?></td>
				<td><?php echo $total_tests; ?></td>
				<td><a href='javascript:showEditBox(<?php echo $count; ?>);'><?php echo "Edit"; ?></td>
			</tr>
			<?php
			$count++;
		}
		?>
		</tbody>
        <tfoot>
        	<tr>
            <th>Grand Totals</th>
				<th><?php echo $grand_total_patients; ?></th>
				<th><?php echo $grand_total_specimens ?></th>
				<th><?php echo $grand_total_tests; ?></th>
				<th></th>
			</tr>
        </tfoot>
		</table>
		<?php
	}

	public function getSpecimenCountStatsTable($stat_list)
	{
		# Returns HTML table showing number of specimens handled
		# Called from reports_specimencount.php
		?>
		<script type='text/javascript'>
		$(document).ready(function(){
			$('#specimencount_table').tablesorter();
		});
		</script>
		<table class='tablesorter' id='specimencount_table' style='width:500px'>
		<thead>
			<tr>
				<th><?php echo LangUtil::$generalTerms['SPECIMEN_TYPE']; ?></th>
				<th><?php echo LangUtil::$pageTerms['TOTAL_SPECIMENS']; ?></td>
			</tr>
		</thead>
		<tbody>
		<?php
		foreach($stat_list as $key=>$value)
		{
			$specimen_type_id = $key;
			$specimen_count = $value;
			?>
			<tr>
				<td><?php echo get_specimen_name_by_id($specimen_type_id); ?></td>
				<td><?php echo $specimen_count; ?></td>
			</tr>
			<?php
		}
		?>
		</tbody>
		</table>
		<?php
	}

	public function getInfectionStatsTable($stat_list, $lab_config_id=null)
	{
		# Returns HTML table showing infection rate summary
		# Called from reports_summary.php
		?>
		<script type='text/javascript'>
		$(document).ready(function(){
			$('#infection_table').tablesorter();
		});
		</script>
		<?php
		echo "<table class='tablesorter' id='infection_table'";
		?>
		<thead>
			<tr>
				<th><?php echo LangUtil::$generalTerms['TEST_TYPE']; ?></th>
				<th><?php echo LangUtil::$pageTerms['TOTAL_SPECIMENS']; ?></th>
				<th><?php echo LangUtil::$pageTerms['TESTED_P']; ?></th>
				<th><?php echo LangUtil::$pageTerms['TESTED_N']; ?></th>
				<th><?php echo LangUtil::$generalTerms['PREVALENCE_RATE']." (%)"; ?></th>
			</tr>
		</thead>
		<tbody>
		<?php
		foreach($stat_list as $key=>$value)
		{
			$test_type_id = $key;
			$count_all = $value[0];
			$count_negative = $value[1];
			$infection_rate = 0;
			if($count_all != 0)
				$infection_rate = round((($count_all-$count_negative)/$count_all)*100, 2);
			?>
			<tr>
				<td><?php echo get_test_name_by_id($test_type_id, $lab_config_id); ?></td>
				<td><?php echo $count_all; ?></td>
				<td><?php echo $count_all-$count_negative; ?></td>
				<td><?php echo $count_negative; ?></td>
				<td><?php echo $infection_rate; ?></td>
			</tr>
			<?php
		}
		?>
		</tbody>
		</table>
		<?php
	}

public function getInfectionStatsTableAggregate($stat_list, $date_from, $date_to, $test_type_id, $lab_config_id = null, $multipleIndividualLabs = null, $viewTrendsEnabled = false)
	{
		# Returns HTML table showing infection rate summary for all labs
		# Called from reports_summary.php
		?>
		<script type='text/javascript'>
			$(document).ready(function(){
				$('#infection_table').tablesorter();
			});
		</script>
		<table class='tablesorter' id='infection_table'>
		<thead>
			<tr>
				<?php
				if ( $multipleIndividualLabs ) { ?>
					<th>Lab Name</th>
				<?php
				}
				else {
				?>
					<th><?php echo LangUtil::$generalTerms['TEST_TYPE']; ?></th>
				<?php
				}
				?>
				<th><?php echo LangUtil::$pageTerms['TOTAL_SPECIMENS']; ?></th>
				<th><?php echo LangUtil::$pageTerms['TESTED_P']; ?></th>
				<th><?php echo LangUtil::$pageTerms['TESTED_N']; ?></th>
				<th><?php echo LangUtil::$generalTerms['PREVALENCE_RATE']." (%)"; ?></th>
				<?php
					if ( $viewTrendsEnabled ) {
						echo "<th>View Trends</th>";
					}
				?>
			</tr>
		</thead>
		<tbody>
		<?php
		foreach($stat_list as $key=>$value)
		{
			$test_type_name = $key;
			$count_all = $value[0];
			$count_negative = $value[1];
			$threshold = $value[2];
			$infection_rate = 0;
			$colorCode = "green";
			if($count_all != 0) {
				$infection_rate = round((($count_all-$count_negative)/$count_all)*100, 2);
				if ( $infection_rate >= $threshold )
					$colorCode = "red";
				else if ( $infection_rate >= intval($threshold*0.8) )
					$colorCode = "darkorange";
			}
			?>
			<tr>
				<?php
				if ( $multipleIndividualLabs ) { ?>
					<td><?php echo $value[2]; ?></td>
				<?php
				}
				else {
				?>
					<td><?php echo $test_type_name ?></td>
				<?php
				}
				?>
				<td><?php echo $count_all; ?></td>
				<td><?php echo $count_all-$count_negative; ?></td>
				<td><?php echo $count_negative; ?></td>
				<?php
					echo "<td style='color:$colorCode;'>$infection_rate</td>";
					if ( $viewTrendsEnabled ) { ?>
						<td><a href='javascript:viewTrendsIndividual(<?php echo json_encode($test_type_name);?>,<?php echo json_encode($lab_config_id);?>,<?php echo json_encode($date_from);?>,<?php echo json_encode($date_to);?>);'>View Trends</a></td>
				<?php
					}
				?>
			</tr>
			<?php
		}
		?>
		</tbody>
		</table>
		<?php
	}

	public function getAllSpecimenList()
	{
		# Returns HTML listing all specimen types available in catalog
		$specimen_list = get_specimen_types_catalog();
		$count = 0;
		?>
		<table cellspacing='4px'>
			<tbody>
				<tr valign='top'>
				<?php
				foreach($specimen_list as $specimen)
				{
					echo "<td>".$specimen."</td>";
					$count++;
					if($count % 3 == 0)
					{
					?>
						</tr>
						<tr valign='top'>
					<?php
					}
				}
				?>
				</tr>
			</tbody>
		</table>
		<?php
	}

	public function getAllTestList()
	{
		# Returns HTML listing all test types available in catalog
		$test_list = get_test_types_catalog();
		$count = 0;
		?>
		<table cellspacing='4px'>
			<tbody>
				<tr valign='top'>
				<?php
				foreach($test_list as $test)
				{
					echo "<td>".$test."</td>";
					$count++;
					if($count % 3 == 0)
					{
					?>
						</tr>
						<tr valign='top'>
					<?php
					}
				}
				?>
				</tr>
			</tbody>
		</table>
		<?php
	}

	public function getAllMeasureList()
	{
		# Returns HTML listing all measures available in catalog
		$measure_list = get_measures_catalog();
		$count = 0;
		?>
		<table cellspacing='4px'>
			<tbody>
				<tr valign='top'>
				<?php
				foreach($measure_list as $measure)
				{
					echo "<td>".$measure."</td>";
					$count++;
					if($count % 3 == 0)
					{
					?>
						</tr>
						<tr valign='top'>
					<?php
					}
				}
				?>
				</tr>
			</tbody>
		</table>
		<?php
	}

	function getCustomFormField($custom_field, $field_value="")
	{
		# Returns HTML form element for this custom field
		$seq_num = rand();
		$name_prefix = "custom_".$custom_field->id;
		if($custom_field->fieldTypeId == CustomField::$FIELD_FREETEXT)
		{
			echo "<input name='$name_prefix' class='uniform_width custom' value='$field_value' type='text'></input>";
		}
		else if($custom_field->fieldTypeId == CustomField::$FIELD_DATE)
		{
			$name_list = array($name_prefix."_yyyy", $name_prefix."_mm", $name_prefix."_dd");
			$id_list = $name_list;
			$today = date("Y-m-d");
			if($field_value == "")
				$field_value = $today;
			$value_list = explode("-", $field_value);
			$this->getDatePicker($name_list, $id_list, $value_list, true);
		}
		else if($custom_field->fieldTypeId == CustomField::$FIELD_OPTIONS)
		{
			$options = explode("/", $custom_field->fieldOptions);
			echo "<SELECT name='$name_prefix' class='uniform_width custom'>";
			foreach($options as $option)
			{
				if(trim($option) == "")
					continue;
				echo "<option value='$option'";
				if($option == $field_value)
				{
					echo " selected ";
				}
				echo " >$option</option>";
			}
			echo "</SELECT>";
		}
		else if($custom_field->fieldTypeId == CustomField::$FIELD_MULTISELECT)
		{
			# TODO: Update this to multiselect plugin
			?>
			<script type='text/javascript'>
			$(document).ready(function(){
				$('.multiselect_custom_field').multiSelect({ oneOrMoreSelected: '*' });
			});
			</script>
			<?php
			$options = explode("/", $custom_field->fieldOptions);
			echo "<SELECT name='".$name_prefix."[]' id='$name_prefix' class='uniform_width multiselect_custom_field custom' multiple='multiple' size='5'>";
			foreach($options as $option)
			{
				if(trim($option) == "")
					continue;
				echo "<option value='$option'";
				if($option == $field_value)
				{
					echo " selected ";
				}
				echo " >$option</option>";
			}
			echo "</SELECT>";
		}
		else if($custom_field->fieldTypeId == CustomField::$FIELD_NUMERIC)
		{
			$range = explode(":", $custom_field->fieldOptions);
			$elem_id = $name_prefix."_".$seq_num;
			$error_elem_id = $elem_id."_err";
			echo "<input class='uniform_width custom' name='$name_prefix' value='$field_value' type='text' onkeyup=\"javascript:validate_custom_numeric(this, '$elem_id', $range[0], $range[1]);\" onblur=\"javascript:validate_custom_numeric(this, '$elem_id', $range[0], $range[1]);\"></input>";
			echo "<small>($range[0]-$range[1]) $range[2]</small><br>";
			echo "<div id='$error_elem_id' class='clean-error uniform_width' style='display:none;'>".LangUtil::$generalTerms['RANGE_OUTOF']."</div>";
		}
	}

	function getExistingSpecimenCustomFields($lab_config_id)
	{
		$field_list = get_lab_config_specimen_custom_fields($lab_config_id);
		if(count($field_list) == 0)
		{
			echo "None";
			return;
		}
		for($i = 0; $i < count($field_list); $i++)
		{
			echo $field_list[$i]->fieldName;
			if($i < count($field_list) - 1)
				echo ", ";
		}
	}

	function getExistingPatientCustomFields($lab_config_id)
	{
		$field_list = get_lab_config_patient_custom_fields($lab_config_id);
		if(count($field_list) == 0)
		{
			echo "None";
			return;
		}
		for($i = 0; $i < count($field_list); $i++)
		{
			echo $field_list[$i]->fieldName;
			if($i < count($field_list) - 1)
				echo ", ";
		}
	}

	function getExistingLabTitleCustomFields($lab_config_id)
	{
		$field_list = get_lab_config_labtitle_custom_fields($lab_config_id);
		if(count($field_list) == 0)
		{
			echo "None";
			return;
		}
		for($i = 0; $i < count($field_list); $i++)
		{
			echo $field_list[$i]->fieldName;
			if($i < count($field_list) - 1)
				echo ", ";
		}
	}

	function getStockForm($count)
	{
	$name_request="txtRow".$count."1";
$lot_number_request="txtRow".$count."2";
$expiry_date_request="txtRow".$count."3";
$manufacture_request="txtRow".$count."4";
$quantity_supplied_request="txtRow".$count."6";
$supplier_request="txtRow".$count."5";
$unit_request="txtRow".$count."7";
$cost_request="txtRow".$count."8";
$name_list = array("yyyy_to".$count, "mm_to".$count, "dd_to".$count);
		$id_list = $name_list;
		 $today = date("Y-m-d");
		$today_array = explode("-", $today);
		$value_list = $today_array;
	?>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<div class="pretty_box" style="width:400px"><table>
			<tr>
			<td>
					Reagent
				</td>
				<td>
					<input type="text" name='<?php echo $name_request; ?>' id='<?php echo $name_request; ?>'/>
				</td>
				</tr><tr>
				<td>
					Lot_Number
				</td>
				<td>
					<input type="text" name='<?php echo $lot_number_request; ?>' id='<?php echo $lot_number_request; ?>'/>
				</td>
				</tr><tr>
				<td>
				Expiry_Date
				</td>
				<td>
					<input type="text" name='<?php echo $expiry_date_request; ?>' id='<?php echo $expiry_date_request; ?>'/>
				</td>
				</tr><tr>
				<td>
					Manufacturer
				</td><td>
					<input type="text" name='<?php echo $manufacture_request; ?>' id='<?php echo $manufacture_request; ?>'/>
				</td>
				</tr><tr>
				<td>
					Supplier
				</td>
				<td>
					<input type="text" name='<?php echo $supplier_request; ?>' id='<?php echo $supplier_request; ?>'/>
				</td>
				</tr><tr>
				<td>
					Quantity_Supplied
				</td>

				<td>
					<input type="text" name='<?php echo $quantity_supplied_request; ?>' id='<?php echo $quantity_supplied_request; ?>'/>
				</td>
				</tr><tr>
				<td>Units
				</td>
				<td>
					<input type="text" name='<?php echo $unit_request; ?>' id='<?php echo $unit_request; ?>'/>
				</td>
			</tr>
			<tr>
				<td>Cost per Unit
				</td>
				<td>
					<input type="text" name='<?php echo $cost_request; ?>' id='<?php echo $cost_request; ?>'/>
				</td>
			</tr>
			<tr>
			<td>
	<label for='<?php echo $curr_form_id; ?>_date_1'>
		Date of Entry
	</label></td><td>
	<span id='<?php echo $curr_form_id; ?>_date_l'>

		<?php echo $this->getDatePicker($name_list, $id_list, $value_list); ?>
		</span>
	</td></tr>

			</table>
			</div>
			<?php

	}

	// field order customizations for specimen
	function generate_patient_Number($dnum){
		print "<tr valign='top'";
		if(is_numeric($_SESSION['dnum']) && $_SESSION['dnum'] == 0)
		{
		# Hide if daily num not in use
		echo " style='display:none;' ";
		}
		echo "><td><label for='dnum'>";
				echo LangUtil::$generalTerms['PATIENT_DAILYNUM'];
		    $this->getAsterisk();
		echo "</label></td><td></td><td><input type='text' name='dnum' id='dnum' value='";
		    echo $dnum;
		echo "' size='20' class='uniform_width'> </input>	</td></tr>";
	}

	function generate_specimen_type($stype_id, $testbox_id){
		echo "<tr valign='top'><td><label for='stype'>".LangUtil::$generalTerms['SPECIMEN_TYPE'];
		$this->getAsterisk();
		echo "</label></td><td></td><td>";


		echo "<select name='stype'
						id='".$stype_id."'
						onchange=\"javascript:get_testbox('".$testbox_id."', '".$stype_id."');\"
						class='uniform_width'
					>
						<option value=\"\">-".LangUtil::$generalTerms['CMD_SELECT']."-</option>
						";
		echo $this->getSpecimenTypesSelect($_SESSION['lab_config_id']);
		echo "</select>";

		echo "</td></tr>";



	}

	function generate_test($testbox_id){
		echo "<tr valign='top'><td><label for='tests'>".
		      LangUtil::$generalTerms['TESTS'];
			 $this->getAsterisk();
		echo "</label></td><td></td><td><span id='".$testbox_id."' class='uniform_width'>-".
		      LangUtil::$pageTerms['MSG_SELECT_STYPE'].
		      "-</span></td></tr>";
	}

	function generate_specimen_addId($lab_config){
		echo "<tr valign='top' ";
		if($lab_config->specimenAddl == 0)
			echo " style='display:none;' ";
		echo ">	<td> <label for='addlid'>".LangUtil::$generalTerms['SPECIMEN_ID'];
		if($_SESSION['s_addl'] == 2)
		 $this->getAsterisk();
		echo " </label>	</td> <td>   </td>	<td><input type=\"text\" name=\"addl_id\" id=\"addl_id\" value=\"\" size=\"20\" class='uniform_width'> </input>
				</td>
			</tr>";
	}

	function generate_reciept_date($lab_config, $form_id){
		echo "<tr valign='top' ";
		if($_SESSION['rdate'] == 0)
				echo " style='display:none;' ";
		echo ">	<td><label>".LangUtil::$generalTerms['R_DATE'];
		if($_SESSION['rdate'] == 2)
			$this->getAsterisk();
		echo "</label>	</td>	<td>  </td>	<td>";
			$today = date("Y-m-d");
			$today_array = explode("-", $today);
			$name_list = array("receipt_yyyy", "receipt_mm", "receipt_dd");
			$id_list = array($form_id."_receipt_yyyy", $form_id."_receipt_mm", $form_id."_receipt_dd");
			$value_list = array($today_array[0], $today_array[1], $today_array[2]);
		$this->getDatePicker($name_list, $id_list, $value_list, true);
		echo "
				</td>
			</tr>";
	}


	function generate_comments(){
		echo "<tr valign='top'";
		if($_SESSION['comm'] == 0)
				echo " style='display:none;' ";
		echo ">	<td> <label for='comments' valign='top'>".LangUtil::$generalTerms['COMMENTS'];
		if($_SESSION['comm'] == 2)
		    $this->getAsterisk();
		echo "</label>	</td><td>   </td>		<td>
					<textarea name=\"comments\" id=\"comments\" class='uniform_width'></textarea>
				</td>
			</tr>";
	}

	function generate_sites($lab_config, $site_choice_enabled) {
		if (($site_choice_enabled == 1))
			echo "<tr valign='top'>";
		else
			echo "<tr valign='top' style='display: none;'>";
		?>
			<td><label for="collection_sites">Collection Site<?php $this->getAsterisk(); ?></label></td>
			<td></td>
			<td>
				<select id="collection_sites" name="collection_sites">
<!--					<?php $this->getCollectionSitesOptions($lab_config->id); ?>-->
<?php $this->getSiteOptions(); ?>

				</select>
			</td>
		</tr>
		<?php
	}

	function generate_doctors($doc_row_id, $doc=""){
		/* $doc_array= getDoctorList();
		$php_array= addslashes(implode("%", $doc_array));
		echo '<script type="text/javascript">$(document).ready(function(){';

		echo 'var data_string="'.$php_array;
		echo 'var data=data_string.split("%");

			$("#doc_row_1_input").autocomplete(data);
		}</script>';
 */
		if($_SESSION['user_level'] == 17) {
			if($doc =="") {
				$doc = $_SESSION['username'];
			}
		}
		echo "<tr valign='top' id='";
		echo $doc_row_id."'";
		if($_SESSION['doctor'] == 0)
				echo " style='display:none;' ";
		echo ">
				<td><label for='doctor' valign='top'>".LangUtil::$generalTerms['DOCTOR'];
			if($_SESSION['doctor'] == 2)
				$this->getAsterisk();
		echo "</label></label>
				</td>
				<td>";
		$labtitlefieldoptions = get_custom_fields_labtitle(1);
		$lab_titles = explode("/",$labtitlefieldoptions);
		echo "<SELECT name='title' id='".$doc_row_id."_title'>";

		foreach($lab_titles as $option)
			{
				if(trim($option) == "")
					continue;
				echo "<option value='".$option."'";
				if($option == $field_value)
						{
							echo " selected ";
						}
						echo " >".$option."</option>";
			}

        echo "</select></td>";
		// [Sep 3, 2018 - Jung Wook] The input method of physician's name is changed from Selector to Input
		echo "<td><input name='doctor'  class ='doctors_auto' id='".$doc_row_id."_input' placeholder='Enter physician&apos;s name' list='physicians' size='30'></input>";
		echo "<datalist id='physicians'>";
		foreach ($doc as $option)
		{
			echo "<option value='" .$option. "'>";
		}

		echo "</datalist></td>";
			/*
		echo "	</SELECT>
				</td>
				<td>
					<input type='text' name='doctor' class ='doctors_auto' id='".$doc_row_id."_input'  value='".$doc."' ></input>

				</td>
			</tr>";
			*/
	}

	function generate_refOut($ref_out_check_id, $ref_out_row_id, $refTo_row_id, $ref_from_row_id, $refTo=""){
// refTo_row_
		echo "<tr valign='top'";
			if($_SESSION['refout'] == 0)
				echo " style='display:none;' ";
		echo ">
				<td>
					<label for='ref_out' valign='top'>".LangUtil::$generalTerms['REF_OUT']."?";
			if($_SESSION['refout'] == 2) $this->getAsterisk();
		echo "</label>
				</td>
				<td>   </td>
				<td>
					<INPUT TYPE=RADIO NAME=\"ref_out\" id='".$ref_out_check_id."' VALUE=\"Y\" onchange=\"javascript:checkandtoggle_ref('".$ref_out_check_id. "', '".$ref_out_row_id."','".$ref_from_row_id."');\">".LangUtil::$generalTerms['YES']."
					<INPUT TYPE=RADIO NAME=\"ref_out\" onchange=\"javascript:checkandtoggle_ref('".$ref_out_check_id."', '".$ref_out_row_id."','".$ref_from_row_id."');\" VALUE=\"N\" checked>".LangUtil::$generalTerms['NO']."
				</td>
			</tr>
			<tr valign='top' id='".$ref_out_row_id."' style='display:none'>
				<td>".LangUtil::$generalTerms['REF_TO']."</td>
				<td>
					<input type='text' name='ref_out_name' id='".$refTo_row_id."_input"."' value='".$refTo."'></input></td>
					<td>&nbsp;&nbsp; OR </td>

			</tr>
			<tr valign='top' id='".$ref_from_row_id."' style='display:none'>
				<td>Referred From</td>
				<td>
					<input type='text' name='ref_from_name' id='".$ref_from_row_id."_input"."'></input>

				</td>
			</tr>";
	}

	function generate_customFields($custom_field){
		echo "<tr valign='top'>
					<td>".$custom_field->fieldName."</td>
					<td></td>
					<td>";
		$this->getCustomFormField($custom_field);
		echo "</td>	</tr>";
	}


	function getNewSpecimenForm($form_num, $pid, $dnum, $session_num, $doc="" ,$title ="Dr.", $refTo="")
	{
		# Returns HTML for new specimen form
		LangUtil::setPageId("new_specimen");
		$form_name = 'specimenform_'.$form_num;
		$form_id = $form_name;
		$form_class = 'specimenform_class';
		$testbox_id = $form_id.'_testbox';
		$stype_id = $form_id.'_stype';
		$dnum_id = $form_id.'_dnum';
		$time_id = $form_id.'_ctime';
		$div_id = 'specimen_form_container_'.$form_num;
		$dialog_id = $div_id."_dialog";
		$specimen_id_div_id = 'specimen-id_'.$form_num;
		$specimen_err_div_id = 'specimen_msg_'.$form_num;
		$doc_row_id = 'doc_row_'.$form_num;
		$refTo_row_id = 'refTo_row_'.$form_num;
		$ref_out_row_id = 'ref_out_row_'.$form_num;
		$ref_out_check_id = 'ref_out_'.$form_num;

		$ref_from_row_id = 'ref_from_row_'.$form_num;
		$ref_from_check_id = 'ref_out_'.$form_num;

		$lab_config = LabConfig::getById($_SESSION['lab_config_id']);
		?>
		<div id='<?php echo $div_id; ?>'>
		<div class='pretty_box' style='width:530px;'>
		<form name='<?php echo $form_name; ?>' id='<?php echo $form_id; ?>' action='ajax/specimen_add.php?session_num=<?php echo $session_num ?>' method='post'>
			<input type='hidden' name='pid' value='<?php echo $pid; ?>' class='uniform_width'></input>
			<?php /*<input type='hidden' name='session_num' value='<?php echo get_session_number(); ?>' class='uniform_width'></input> */ ?>
			<table class='regn_form_table'>
			<tbody>

			<?php $this->generate_patient_Number($dnum);?>
			<?php $this->generate_specimen_type($stype_id, $testbox_id);?>
			<?php $this->generate_test($testbox_id);?>

			<?php
					$specimenFieldOrder = $_SESSION['specimenFieldOrder'];
					$custom_field_list = get_custom_fields_specimen();
					$custFieldArray = array();
					foreach($custom_field_list as $custom_field)
					{
						if(($custom_field->flag)==NULL)
						{
							array_push($custFieldArray, $custom_field->fieldName);
						}
					}
					if(sizeOf($specimenFieldOrder) > 0){
						foreach($specimenFieldOrder as $field){

							if(in_array($field, $custFieldArray)){
								// custom field generation
								$custom_field = null;
								foreach($custom_field_list as $custField){
									if($custField->fieldName == $field){
										$custom_field = $custField;
									}
								}
								$this->generate_customFields($custom_field);
							}
							else if($field == "Specimen ID"){
								 $this->generate_specimen_addId($lab_config);
							} /*else if($field == "Specimen Additional ID"){
								<?php $this->generate_specimen_addId($lab_config);?>
							}*/ else if($field == "Comments"){
								$this->generate_comments();
							} else if($field == "Lab Reciept Date"){
								 $this->generate_reciept_date($lab_config, $form_id);
							} else if($field == "Referred Out"){
								$this->generate_refOut($ref_out_check_id, $ref_out_row_id, $refTo_row_id, $ref_from_row_id, $refTo);
							} else if($field == "Physician"){
								$this->generate_doctors($doc_row_id, $doc);
							}
						}
					}
			$this->generate_sites($lab_config, $lab_config->site_choice_enabled);
				?>






			<tr valign='top'<?php
			//if($_SESSION['sid'] == 0)
			if(true)
				echo " style='display:none;' ";
			?>>
				<td>
					<label for='sid'>DB Key
					<?php if($_SESSION['sid'] == 2) $this->getAsterisk(); ?></label>
				</td>
				<td>   </td>
				<td>
					<!--
					<input type="text" name="specimen_id" id="<?php echo $specimen_id_div_id; ?>" value="" onblur="javascript:check_specimen_id('<?php echo $specimen_id_div_id; ?>', '<?php echo $specimen_err_div_id; ?>');" size="20" class='uniform_width'>
					</input>
					-->
					<input type='text' name='specimen_id' id='specimen_id' value="<?php echo $form_num; ?>" readonly="readonly" class='uniform_width'>
					</input>
					<br><span id='<?php echo $specimen_err_div_id; ?>'></span>
				</td>
			</tr>





			<tr valign='top' style='display:none;'>
				<td>
					<label><?php echo LangUtil::$generalTerms['C_DATE']; ?></label>
				</td>
				<td>  </td>
				<td>
					<?php
					$today = date("Y-m-d");
					$today_array = explode("-", $today);
					$name_list = array("collect_yyyy", "collect_mm", "collect_dd");
					$id_list = array($form_id."_collect_yyyy", $form_id."_collect_mm", $form_id."_collect_dd");
					$value_list = array($today_array[0], $today_array[1], $today_array[2]);
					$this->getDatePicker($name_list, $id_list, $value_list, false);
					?>
				</td>
			</tr>
			<tr valign='top' style='display:none;'>
				<td>
					<label><?php echo LangUtil::$generalTerms['C_TIME']; ?></label>
				</td>
				<td>
					<select name='ctime_hh' autocomplete="OFF">
					<?php
					$time = date("H:i");
					$time_parts = explode(":", $time);
					for($i = 0; $i < 24; $i++)
					{
						if($i < 10)
							$option = '0'.$i;
						else
							$option = $i;
						echo "<option value='$option' ";
						if($option == $time_parts[0])
						//if($option == 9)
							echo "selected ";
						echo ">$option</option>";


					}
					?>
					</select>
					:
					<select name='ctime_mm' autocomplete="OFF">
					<?php
					for($i = 0; $i < 60; $i++)
					{
						if($i < 10)
							$option = '0'.$i;
						else
							$option = $i;
						echo "<option value='$option' ";
						if($option == $time_parts[1])
						//if($option == "00")
							echo "selected ";
						echo ">$option</option>";
					}
					?>
					</select>
					&nbsp;&nbsp;hrs
				</td>
			</tr>


			<tr valign='top' style='display:none' <?php ## Disabled for now ?>>
				<td>
					<label for='report_to' valign='top'>Report To</label>
				</td>
				<td>  </td>
				<td>
					<select name='report_to' class='uniform_width'>
					<?php
					# Enable the following line if this field is to be used:
					echo " onchange=\"javascript:checkandtoggle(this, '$doc_row_id');\" ";
					?>
						<option value='1'>Patient</option>
						<option value='2'>Doctor/Hospital</option>
					</select>
				</td>
			</tr>




			<?php
			/*$custom_field_list = get_custom_fields_specimen();
			foreach($custom_field_list as $custom_field)
			{	if(($custom_field->flag)==NULL)
				{
				?>
				<tr valign='top'>
					<td><?php echo $custom_field->fieldName; ?></td>
					<td></td>
					<td><?php $this->getCustomFormField($custom_field); ?></td>
				</tr>
				<?php
				}
			}*/
			?>



			<?php
			if($form_num != 1)
			{
				?>
				<tr valign='top'>
					<td>
						<a href="javascript:show_dialog_box('<?php echo $div_id; ?>');"><?php echo LangUtil::$generalTerms['CMD_REMOVE']; ?></a>
					</td>
					<td>
					<?php
					$message = LangUtil::$pageTerms['MSG_SURETO_REMOVE'];
					$ok_function = "remove_specimenbox('$div_id')";
					$cancel_function = "hide_dialog_box('$div_id')";
					$this->getConfirmDialog($dialog_id, $message, $ok_function, $cancel_function, $width=200);
					?>
					</td>
				</tr>
				<?php
			}
			?>
			</tbody>
			</table>
		</form>
		</div>
		<small>
		<span style='float:right'>
			<?php $this->getAsteriskMessage(); ?>
		</span>
		</small>
		<br>
		</div>
		<?php
	}

	public function getReportResultsForm($form_name, $form_id)
	{
		$specimen_list = Specimen::getUnreported();
		if($specimen_list == null || count($specimen_list) == 0)
			return;
		?>
		<table class='tablesorter'>
			<thead>
				<tr valign='top'>
					<?php
					if($_SESSION['pid'] != 0)
					{
						?>
						<th><?php echo LangUtil::$generalTerms['PATIENT_ID']; ?></th>
						<?php
					}
					if($_SESSION['dnum'] != 0)
					{
						?>
						<th><?php echo LangUtil::$generalTerms['PATIENT_DAILYNUM']; ?></th>
						<?php
					}
					if($_SESSION['s_addl'] != 0)
					{
						?>
						<th><?php echo LangUtil::$generalTerms['SPECIMEN_ID']; ?></th>
						<?php
					}
					?>
					<th><?php echo LangUtil::$generalTerms['PATIENT_NAME']; ?></th>
					<th><?php echo LangUtil::$generalTerms['SPECIMEN_TYPE']; ?></th>
					<th><?php echo LangUtil::$generalTerms['C_DATE']; ?></th>
					<th><?php echo LangUtil::$generalTerms['TESTS']; ?></th>
					<th><?php echo LangUtil::$generalTerms['REPORT_TO']; ?></th>
					<th>
						<?php echo LangUtil::$generalTerms['REPORTED']; ?>?
						<input type='checkbox' name='check_all' id='check_all' onclick='checkoruncheckall();'>
						</input>
					</th>
				</tr>
			</thead>
			<tbody>
			<?php
			foreach($specimen_list as $specimen)
			{
				$test_list = get_tests_by_specimen_id($specimen->specimenId);
				$patient = Patient::getById($specimen->patientId);
				?>
				<tr valign='top'>
					<input type='hidden' name='sid[]' value='<?php echo $specimen->specimenId; ?>'></input>
					<?php
					if($_SESSION['pid'] != 0)
					{
						?>
						<td><?php echo $specimen->getSurrogateId(); ?></td>
						<?php
					}
					if($_SESSION['dnum'] != 0)
					{
						?>
						<td><?php $specimen->getDailyNum(); ?></td>
						<?php
					}
					if($_SESSION['s_addl'] != 0)
					{
						?>
						<td><?php $specimen->getAuxId(); ?></td>
						<?php
					}
					?>
					<td><?php echo $patient->getName(); ?></td>
					<td><?php echo get_specimen_name_by_id($specimen->specimenTypeId); ?></td>
					<td><?php echo DateLib::mysqlToString($specimen->dateCollected)." ".$specimen->timeCollected; ?></td>
					<td>
						<?php
						foreach($test_list as $test)
						{
							echo get_test_name_by_id($test->testTypeId);
							echo "<br>";
						}
						?>
					</td>
					<td><?php echo $specimen->getReportTo(); ?></td>
					<td>
						<center>
							<input type='checkbox' class='report_flag' name='mark_<?php echo $specimen->specimenId; ?>'></input>
						</center>
					</td>
				</tr>
				<?php
			}
			?>
			</tbody>
		</table>
		<?php
	}


	public function getGoalTatForm($lab_config_id)
	{
		# Returns HTML form for setting/modifying goal TAT values
		# Called from lab_config_home.php
		global $DEFAULT_TARGET_TAT;
		$test_type_list = get_test_types_by_site($lab_config_id);
		$lab_config = get_lab_config_by_id($lab_config_id);
		$tat_list = $lab_config->getGoalTatValues();
		?>
		<input type='hidden' name='lid' value='<?php echo $lab_config_id; ?>'></input>
		<table class='tablesorter' style='width:600px;'>
			<thead>
				<tr>
					<th><?php echo LangUtil::$generalTerms['TEST_TYPE']; ?></th>
					<th><?php echo LangUtil::$generalTerms['TAT']; ?></th>
				</tr>
			</thead>
			<tbody>
			<?php
			foreach($tat_list as $key=>$value)
			{
				$curr_tat_value = $value;
				$days = 0;
				$hours = 0;
				$minutes = 0;
				// minutes exist
				if($value !=  floor($value)) {
					$hours = floor($value);
					$minutes = 60*($value - $hours);
					$curr_tat_value = $hours;
				}
				// days exists
				if($value >= 24) {
					$days = round($curr_tat_value/24);
					$hours = $curr_tat_value - $days*24;
				}

				?>
				<tr valign='top'>
					<td>
						<?php
						if($key != 0)
						{
							echo get_test_name_by_id($key, $lab_config_id);
						}
						else
						{
							echo LangUtil::$pageTerms['MSG_PENDINGTAT'];
						}
						?>
						<input type='hidden' name='ttype[]' value='<?php echo $key; ?>'></input>
					</td>
					<td>
						<div>
							<!-- input box for days -->
							<input type='text' name='tat_days[]' value='<?php echo $days;?>'></input>
							&nbsp;&nbsp;&nbsp;
							<span>Days</span>
							&nbsp;&nbsp;&nbsp;
						</div>

						<div>
							<!-- input box for days -->
							<input type='text' name='tat_hours[]' value='<?php echo $hours;?>'></input>
							&nbsp;&nbsp;&nbsp;
							<span>Hours</span>
							&nbsp;&nbsp;&nbsp;
						</div>

						<div>
							<!-- input box for days -->
							<input type='text' name='tat_mins[]' value='<?php echo $minutes;?>'></input>
							&nbsp;&nbsp;&nbsp;
							<span>Minutes</span>
							&nbsp;&nbsp;&nbsp;
						</div>
					</td>
				</tr>
				<?php
			}
			?>
			</tbody>
		</table>
		<?php
	}

	public function getGetGoalTatTable($lab_config_id)
	{
		# Returns HTML table showing existing goal TAT values
		$lab_config = get_lab_config_by_id($lab_config_id);
		$tat_list = $lab_config->getGoalTatValues();
		?>
		<table class='tablesorter' style='width:600px;'>
			<thead>
				<tr valign='top'>
					<th><?php echo LangUtil::$generalTerms['TEST_TYPE']; ?></th>
					<th><?php echo LangUtil::$generalTerms['TAT']; ?></th>
				</tr>
			</thead>
			<tbody>
			<?php
			foreach($tat_list as $key=>$value)
			{
				$days = 0;
				$hours = $value;
				$minutes = 0;
				// minutes exist
				if($value !=  floor($value)) {
				  	$hours = floor($value);
				  	$minutes = 60*($value - $hours);
				  	$value = $hours;
				}
			  	// days exists^M
			 	if($value >= 24) {
			  		$days = round($value/24);
			  		$hours = $value - $days*24;
			  	}

				?>
				<tr valign='top'>
					<td>
						<?php
						if($key != 0)
						{
							echo get_test_name_by_id($key, $lab_config_id);
						}
						else
						{
							echo LangUtil::$pageTerms['MSG_PENDINGTAT'];
						}
						?>
					</td>
					<td>
						<?php
						echo "$days ".LangUtil::$generalTerms['DAYS']." ";
						echo "$hours ".LangUtil::$generalTerms['HOURS']." ";
						echo "$minutes ".LangUtil::$generalTerms['MINUTES'];
						/*
						if($value < 24)
							echo "$value hours";
						else
						{
							$value_days = round($value/24, 2);
							echo "$value_days days";
						}
						*/
						?>
					</td>
				</tr>
				<?php
			}
			?>
			</tbody>
		</table>
		<?php
	}

	public function getCustomFieldTable($lab_config_id, $custom_field_list, $type)
	{
		# Returns a list of existing custom fields in a lab configuration
		# $type = 1 for specimens
		# $type = 2 for patients
		# $type = 3 for lab titles
		if($custom_field_list == null || count($custom_field_list) == 0)
		{
			?>
			<div class='sidetip_nopos'>
			<?php echo LangUtil::$pageTerms['TIPS_CUSTOMFIELD_NOTFOUND']; ?>
			</div>
			<?php
			return;
		}
		?>
		<table class='hor-minimalist-b' style='width:700px;'>
			<thead>
				<tr valign='top'>
					<th>
						#
					</th>
					<th>
						<?php echo LangUtil::$generalTerms['NAME']; ?>
					</th>
					<th>
						<?php echo LangUtil::$generalTerms['TYPE']; ?>
					</th>
					<th>
					</th>
					<th>
					</th>
					<th>
					</th>
				</tr>
			</thead>
			<tbody>
			<?php
			$count = 1;
			foreach($custom_field_list as $custom_field)
			{
				?>
					<tr valign='top'>
						<td>
							<?php echo $count; ?>.
						</td>
						<td>
							<?php echo $custom_field->fieldName; ?>
						</td>
						<td>
							<?php echo $custom_field->getFieldTypeName(); ?>
						</td>
						<td>
							<a href='cfield_edit.php?id=<?php echo $custom_field->id; ?>&lid=<?php echo $lab_config_id; ?>&t=<?php echo $type; ?>'>
							Edit
							</a>
						</td>

					</tr>
				<?php
				$count++;
			}
			?>
			</tbody>
		</table>
		<?php
	}

	public function getCustomFieldTypeOptions($edit=0, $type='')
	{
		# Returns <select> options for custom field type
		?>
		<? if ($edit==0): ?>
			<option value='<?php echo CustomField::$FIELD_FREETEXT; ?>'><?php echo LangUtil::$generalTerms['FREETEXT']; ?></option>
			<option value='<?php echo CustomField::$FIELD_DATE; ?>'><?php echo LangUtil::$generalTerms['DATE']; ?></option>
			<option value='<?php echo CustomField::$FIELD_NUMERIC; ?>'><?php echo LangUtil::$generalTerms['NUMERIC_FIELD']; ?></option>
			<option value='<?php echo CustomField::$FIELD_OPTIONS; ?>'><?php echo LangUtil::$generalTerms['DROPDOWN']; ?></option>
			<!--<option value='<?php #echo CustomField::$FIELD_MULTISELECT; ?>'><?php #echo LangUtil::$generalTerms['MULTISELECT']; ?></option>-->
		<? endif; ?>
		<? if ($edit==1): ?>
	  		<? if (strcmp($type,LangUtil::$generalTerms['FREETEXT'])==0): ?>
	  			<option value='<?php echo CustomField::$FIELD_FREETEXT; ?>' selected><?php echo LangUtil::$generalTerms['FREETEXT']; ?></option>
			<? else: ?>
	  			<option value='<?php echo CustomField::$FIELD_FREETEXT; ?>' ><?php echo LangUtil::$generalTerms['FREETEXT']; ?></option>
			<? endif; ?>
			<? if (strcmp($type,LangUtil::$generalTerms['DATE'])==0): ?>
	  			<option value='<?php echo CustomField::$FIELD_DATE; ?>' selected><?php echo LangUtil::$generalTerms['DATE']; ?></option>
			<? else: ?>
	  			<option value='<?php echo CustomField::$FIELD_DATE; ?>' ><?php echo LangUtil::$generalTerms['DATE']; ?></option>
			<? endif; ?>
			<? if (strcmp($type,LangUtil::$generalTerms['NUMERIC_FIELD'])==0): ?>
	  			<option value='<?php echo CustomField::$FIELD_NUMERIC; ?>' selected><?php echo LangUtil::$generalTerms['NUMERIC_FIELD']; ?></option>
			<? else: ?>
	  			<option value='<?php echo CustomField::$FIELD_NUMERIC; ?>' ><?php echo LangUtil::$generalTerms['NUMERIC_FIELD']; ?></option>
			<? endif; ?>
			<? if (strcmp($type,LangUtil::$generalTerms['DROPDOWN'])==0): ?>
	  			<option value='<?php echo CustomField::$FIELD_OPTIONS; ?>' selected><?php echo LangUtil::$generalTerms['DROPDOWN']; ?></option>
			<? else: ?>
	  			<option value='<?php echo CustomField::$FIELD_OPTIONS; ?>' ><?php echo LangUtil::$generalTerms['DROPDOWN']; ?></option>
			<? endif; ?>
		<? endif; ?>

	<?php
	}

	public function getCustomFieldNewForm($lab_config_id)
	{
		# Returns HTML form field for adding a new custom field
		?>
		<input type='hidden' name='lid' value='<?php echo $lab_config_id; ?>'></input>
		<table>
			<tbody>
				<tr valign='top'>
					<td>
						<?php echo LangUtil::$generalTerms['NAME']; ?>&nbsp;&nbsp;&nbsp;
					</td>
					<td>
						<input type='input' id='fname' name='fname' value='' class='uniform_width'>
						</input>
					</td>
				</tr>
				<tr valign='top'>
					<td>
						<?php echo LangUtil::$pageTerms['ASSIGN_TO']; ?>
					</td>
					<td>
						<select name='tabletype' id='tabletype' class='uniform_width'>
							<option value='1'><?php echo LangUtil::$generalTerms['SPECIMENS']; ?></option>
							<option value='2'><?php echo LangUtil::$generalTerms['PATIENTS']; ?></option>
							<option value='3'><?php echo "Lab Titles"; ?></option>
						</select>
					</td>
				</tr>
				<tr valign='top'>
					<td>
						<?php echo LangUtil::$generalTerms['TYPE']; ?>
					</td>
					<td>
						<select name='ftype' id='ftype' class='uniform_width'>
							<?php $this->getCustomFieldTypeOptions();	?>
						</select>
					</td>
				</tr>
				<tr valign='top' id='options_row' style='display:none;'>
					<td>
						<?php echo LangUtil::$generalTerms['OPTIONS']; ?>
					</td>
					<td>
						<span id='options_list'>
						<?php
						$initial_num_of_options = 2;
						for($i = 1; $i <= $initial_num_of_options; $i++)
						{
							?>
							<input type='text' name='option[]' value='' class='uniform_width'>
							</input>
							<br>
							<?php
						}
						?>
						</span>
						<small><a href='javascript:appendoption();'><?php echo LangUtil::$generalTerms['ADDANOTHER']; ?> &raquo;</a></small>
					</td>
				</tr>
				<tr valign='top' id='range_row' style='display:none;'>
					<td>
						<?php echo LangUtil::$generalTerms['RANGE']; ?>
					</td>
					<td>
						<input type='text' value='' name='range_lower' id='range_lower' size='5'></input>
						-
						<input type='text' value='' name='range_upper' id='range_upper' size='5'></input>
					</td>
				</tr>
				<tr valign='top' id='unit_row' style='display:none;'>
					<td>
						<?php echo LangUtil::$generalTerms['UNIT']; ?>
					</td>
					<td>
						<input type='text' value='' name='unit' id='unit' class='uniform_width'></input>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
					<br>
					<input type='button' id='cfield_add_button' value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>' onclick='javascript:checkandsubmit()'>
					</input>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<small><a href='lab_config_home.php?id=<?php echo $lab_config_id; ?>&show_f=1'><?php echo LangUtil::$generalTerms['CMD_CANCEL']; ?></a></small>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<span id='cfield_progress_spinner' style='display:none;'>
						<?php $this->getProgressSpinner(LangUtil::$generalTerms['CMD_SUBMITTING']); ?>
					</span>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<br>
						<div id='err_msg' class='clean-error uniform_width' style='display:none;'>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
		<?php
	}

	public function getCustomFieldEditForm($field_id, $lab_config_id, $type)
	{
		# Returns HTML form fields for editing a custom field
		# $type = 1 for specimen custom field
		# $type = 2 for patient custom field
		# $type = 3 for labtitle custom field
		$custom_field = CustomField::getById($field_id, $lab_config_id, $type);
		if($custom_field == null)
		{
			?>
			<div class='sidetip_nopos'>
			<?php echo LangUtil::$generalTerms['MSG_NOTFOUND']; ?>
			</div>
			<?php
			return;
		}

		?>
		<input type='hidden' name='id' value='<?php echo $custom_field->id; ?>'></input>
		<input type='hidden' name='lid' value='<?php echo $lab_config_id; ?>'></input>
		<input type='hidden' name='t' value='<?php echo $type; ?>'></input>
		<table>
			<tbody>
				<tr valign='top'>
					<td>
						<?php echo LangUtil::$generalTerms['NAME']; ?>&nbsp;&nbsp;&nbsp;
					</td>
					<td>
						<input type='input' id='fname' name='fname' value='<?php echo $custom_field->fieldName; ?>' class='uniform_width'>
						</input>
					</td>
				</tr>
				<tr valign='top'>
					<td>
						<?php echo LangUtil::$generalTerms['TYPE']; ?>
					</td>
					<!--td>
						<input type='hidden' id='ftype' name='ftype' value='<?php echo $custom_field->fieldTypeId; ?>'></input>
						<?php echo $custom_field->getFieldTypeName(); ?>
					</td-->
					<td>
						<select name='ftype' id='ftype' class='uniform_width'>
							<?php $this->getCustomFieldTypeOptions(1,$custom_field->getFieldTypeName());	?>
						</select>
					</td>
				</tr>
				<?php
				if($custom_field->fieldTypeId == CustomField::$FIELD_OPTIONS || $custom_field->fieldTypeId == CustomField::$FIELD_MULTISELECT)
				{
					?>
					<tr valign='top' id='options_row'>
						<td>
							<?php echo LangUtil::$generalTerms['OPTIONS']; ?>
						</td>
						<td>
						<span id='options_list'>
					<?php
					# Show existing options with fields to add new options
					$options = $custom_field->getFieldOptions();
					$count = 1;
					foreach($options as $option)
					{
						?>
						<input type='text' name='option[]' value='<?php echo $option; ?>' class='uniform_width'>
						</input>
						<br>
						<?php
					}
					?>
						</span>
						<small><a href='javascript:appendoption();'><?php echo LangUtil::$generalTerms['ADDANOTHER']; ?> &raquo;</a></small>
						</td>
					</tr>
					<?php
				}
				else{
					?>
					<tr valign='top' id='options_row' style='display:none;'>
					<td>
						<?php echo LangUtil::$generalTerms['OPTIONS']; ?>
					</td>
					<td>
						<span id='options_list'>
						<?php
						$initial_num_of_options = 2;
						for($i = 1; $i <= $initial_num_of_options; $i++)
						{
							?>
							<input type='text' name='option[]' value='' class='uniform_width'>
							</input>
							<br>
							<?php
						}
						?>
						</span>
						<small><a href='javascript:appendoption();'><?php echo LangUtil::$generalTerms['ADDANOTHER']; ?> &raquo;</a></small>
					</td>
				</tr>
				<?php
				}
				if($custom_field->fieldTypeId == CustomField::$FIELD_NUMERIC)
				{
					# Show existing range value fields
					$range = $custom_field->getFieldRange();
					?>
					<tr valign='top' id='range_row'>
						<td>
							<?php echo LangUtil::$generalTerms['RANGE']; ?>
						</td>
						<td>
							<input type='text' value='<?php echo $range[0]; ?>' name='range_lower' id='range_lower' size='5'></input>
							-
							<input type='text' value='<?php echo $range[1]; ?>' name='range_upper' id='range_upper' size='5'></input>
						</td>
					</tr>
					<tr valign='top' id='unit_row'>
						<td>
							<?php echo LangUtil::$generalTerms['UNIT']; ?>
						</td>
						<td>
							<input type='text' value='<?php echo $range[2]; ?>' name='unit' id='unit' class='uniform_width'></input>
						</td>
					</tr>
					<?php
				}
				else{
					?>
					<tr valign='top' id='range_row' style='display:none;'>
					<td>
						<?php echo LangUtil::$generalTerms['RANGE']; ?>
					</td>
					<td>
						<input type='text' value='' name='range_lower' id='range_lower' size='5'></input>
						-
						<input type='text' value='' name='range_upper' id='range_upper' size='5'></input>
					</td>
				</tr>
				<tr valign='top' id='unit_row' style='display:none;'>
					<td>
						<?php echo LangUtil::$generalTerms['UNIT']; ?>
					</td>
					<td>
						<input type='text' value='' name='unit' id='unit' class='uniform_width'></input>
					</td>
				</tr>
				<?php
				}
				?>
				<tr>
					<td>
					Enable:
					</td>
					<td>

					<input type="checkbox" name="Enable" value="enable" <?php if(($custom_field->flag)==0) { ?> checked <?php }?> >
					</td>
				</tr>
				<tr>
					<td>
					Delete:
					</td>
					<td>
					<input type="checkbox" name="Delete" id="Delete" value="Delete" >
					</td>
				</tr>
				<tr>
				<td>
				<input type='hidden' id='flag' name='flag' value='<?php echo $custom_field->flag; ?>'></input>
				</td>
				</tr>
				<tr>
					<td></td>
					<td>
					<br>
					<input type='button' id='cfield_edit_button' value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>' onclick='javascript:checkandsubmit()'>
					</input>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<small><a href='lab_config_home.php?id=<?php echo $lab_config_id; ?>&show_f=1'><?php echo LangUtil::$generalTerms['CMD_CANCEL']; ?></a></small>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<span id='cfield_progress_spinner' style='display:none;'>
						<?php $this->getProgressSpinner(LangUtil::$generalTerms['CMD_SUBMITTING']); ?>
					</span>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<br>
						<div id='err_msg' class='clean-error uniform_width' style='display:none;'>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
		<?php
	}

	public function getSpecimenTypeCheckboxes($lab_config_id=null, $allCompatibleCheckingOn=true)
	{
		# Returns a set of checkboxes with existing specimen types checked if allCompatibleCheckingOn is set to true,
		# else only returns checkboxes with available specimen names
		$lab_config = get_lab_config_by_id($lab_config_id);
		if($lab_config == null && $lab_config_id != "")
		{
			?>
			<div class='sidetip_nopos'>
			ERROR: Lab configuration not found
			</div>
			<?php
			return;
		}
		# Fetch all specimen types
		//if($lab_config_id == "")
			//$specimen_list = get_specimen_types_catalog();
		//else
			$specimen_list = get_specimen_types_catalog($lab_config_id);
		$current_specimen_list = array();
		if($lab_config_id != "")
			$current_specimen_list = get_lab_config_specimen_types($lab_config_id);
		# For each specimen type, create a check box. Check it if specimen already in lab configuration
		?>
		<table class='hor-minimalist-b' style='width:700px;'>
			<tbody>
			<tr>
			<?php
			$count = 0;
			foreach($specimen_list as $key=>$value)
			{
				$specimen_type_id = $key;
				$specimen_name = $value;
				$count++;
				?>
				<td><input type='checkbox' class='stype_entry' name='s_type_<?php echo $key; ?>' id='s_type_<?php echo $key; ?>' value='<?php echo $key; ?>'
				<?php
				if($allCompatibleCheckingOn==true) {
					if(in_array($specimen_type_id, $current_specimen_list))
					{
						echo " checked ><span class='clean-ok'>$specimen_name</span>";

					}
					else
						echo ">$specimen_name";
				}
				else
					echo ">$specimen_name";
				?>
				</input></td>

				<?php
				if($count % 3 == 0)
					echo "</tr><tr>";
			}
			?>
			</tbody>
		</table>
		<?php
	}

	public function getTestTypeCheckboxes($lab_config_id=null, $allCompatibleCheckingOn=true)
	{
		# Returns a set of checkboxes with existing test types checked, if allCompatibleCheckingOn is set to true,
		# else only returns checkboxes with available test tpe names
		$lab_config = get_lab_config_by_id($lab_config_id);
		if($lab_config == null && $lab_config_id != "")
		{
			?>
			<div class='sidetip_nopos'>
			ERROR: Lab configuration not found
			</div>
			<?php
			return;
		}
		# Fetch all test types
		//if($lab_config_id == "")
                //{
			//$test_list = get_test_types_catalog(true);
                  //  $reff = 1;
		//	$test_list = get_test_types_catalog($lab_config_id, $reff);
                //}
                  //     else
                //{
                //NC3065
                $reff = 1;
		$test_list = get_test_types_catalog($lab_config_id, $reff );
                 //-NC3065
               // }
                $current_test_list = array();
		if($lab_config_id != "")
			$current_test_list = get_lab_config_test_types($lab_config_id)
		# For each test type, create a check box. Check it if test already in lab configuration
		?>
		<table class='hor-minimalist-b' style='width:700px;'>
			<tbody>
			<tr>
			<?php
			$count = 0;
			foreach($test_list as $key=>$value)
			{
				$test_type_id = $key;
				$test_name = $value;
				$count++;
				?>
				<td><input type='checkbox' class='ttype_entry' name='t_type_<?php echo $key; ?>' id='t_type_<?php echo $key; ?>'
				<?php
				if($allCompatibleCheckingOn==true) {
					if(in_array($test_type_id, $current_test_list))
					{
						echo " checked ><span class='clean-ok'>$test_name</span>";

					}
					else
						echo ">$test_name";
				}
				else
					echo ">$test_name";
				?>
				</input></td>

				<?php
				if($count % 3 == 0)
					echo "</tr><tr>";
			}
			?>
			</tbody>
		</table>
		<?php
	}

        //NC3065
        public function getTestTypeCheckboxes_dir($lab_config_id=null, $allCompatibleCheckingOn=true)
	{
		# Returns a set of checkboxes with existing test types checked, if allCompatibleCheckingOn is set to true,
		# else only returns checkboxes with available test tpe names
		$lab_config = get_lab_config_by_id($lab_config_id);
		if($lab_config == null && $lab_config_id != "")
		{
			?>
			<div class='sidetip_nopos'>
			ERROR: Lab configuration not found
			</div>
			<?php
			return;
		}
		# Fetch all test types
		//if($lab_config_id == "")
                //{
			//$test_list = get_test_types_catalog(true);
                  //  $reff = 1;
		//	$test_list = get_test_types_catalog($lab_config_id, $reff);
                //}
                  //     else
                //{
                //NC3065
                $reff = 2;
		$test_list = get_test_types_catalog($lab_config_id, $reff );
                 //-NC3065
               // }
                $current_test_list = array();
		if($lab_config_id != "")
			$current_test_list = get_lab_config_test_types($lab_config_id)
		# For each test type, create a check box. Check it if test already in lab configuration
		?>
		<table class='hor-minimalist-b' style='width:700px;'>
			<tbody>
			<tr>
			<?php
			$count = 0;
			foreach($test_list as $key=>$value)
			{
				$test_type_id = $key;
				$test_name = $value;
				$count++;
				?>
				<td><input type='checkbox' class='ttype_entry' name='t_type_<?php echo $key; ?>' id='t_type_<?php echo $key; ?>'
				<?php
				if($allCompatibleCheckingOn==true) {
					if(in_array($test_type_id, $current_test_list))
					{
						echo " checked ><span class='clean-ok'>$test_name</span>";

					}
					else
						echo ">$test_name";
				}
				else
					echo ">$test_name";
				?>
				</input></td>

				<?php
				if($count % 3 == 0)
					echo "</tr><tr>";
			}
			?>
			</tbody>
		</table>
		<?php
	}
        //-NC3065

        public function getSearchFieldsCheckboxes($lab_config_id=null)
	{
		# Returns a set of checkboxes with existing fields types checked.

		$lab_config = get_lab_config_by_id($lab_config_id);
		if($lab_config == null && $lab_config_id != "")
		{
			?>
			<div class='sidetip_nopos'>
			ERROR: Lab configuration not found
			</div>
			<?php
			return;
		}
		# Fetch all specimen types
		//if($lab_config_id == "")
			//$specimen_list = get_specimen_types_catalog();
		//else
			//$specimen_list = get_search_fields($lab_config_id);
                        $sfields = get_search_fields($lab_config_id);
                        $ssfields = get_lab_config_settings_search($lab_config_id);
                       //"SELECT pid, p_addl, daily_num, pname, age, sex, dob FROM lab_config WHERE lab_config_id=$lab_config_id";

		//$current_specimen_list = array();
		//if($lab_config_id != "")
		//	$current_specimen_list = get_lab_config_specimen_types($lab_config_id);
		# For each specimen type, create a check box. Check it if specimen already in lab configuration
		?>
		<table class='hor-minimalist-b' style='width:700px;'>
			<tbody>

                        <tr>
				<td><input type='checkbox' class='sfields_entry' name='sfields_daily_num' id='sfields_daily_num' value='1'
				<?php
					if($sfields['daily_num'] == 12 || $sfields['daily_num'] == 11 || $sfields['daily_num'] == 10)
					{
						echo " checked ><span class='clean-ok'>Patient Number</span>";
					}
					else
                                        {
						echo ">Patient Number";
                                        }
				?>
				</input></td>
                                <br>
                                <td><input type='checkbox' class='sfields_entry' name='sfields_age' id='sfields_age' value='1'
				<?php
					if($sfields['age'] == 12 || $sfields['age'] == 11 || $sfields['age'] == 10)
					{
						echo " checked ><span class='clean-ok'>Patient's Age</span>";
					}
					else
                                        {
						echo ">Patient's Age";
                                        }
				?>
				</input></td>

			</tr>


			</tbody>
		</table>
                <br><br>
                Number of Results Per Page:
                                <?php
                                echo "<select name='sfields_resultsPerPage' id='sfields_resultsPerPage'>";
                                $i = 1;
			while($i < 101)
                        {
                            if($ssfields['results_per_page'] == $i)
				echo "<option selected value='".$i."'>".$i."</option>";
                            else
                                echo "<option value='".$i."'>".$i."</option>";
                            $i++;
			}
			echo "</select>";?>

		<?php
	}

        public function getBarcodeFields($lab_config_id=null)
	{
		# Returns a set of checkboxes with existing fields types checked.

		$lab_config = get_lab_config_by_id($lab_config_id);
		if($lab_config == null && $lab_config_id != "")
		{
			?>
			<div class='sidetip_nopos'>
			ERROR: Lab configuration not found
			</div>
			<?php
			return;
		}
		# Fetch all specimen types
		//if($lab_config_id == "")
			//$specimen_list = get_specimen_types_catalog();
		//else
			//$specimen_list = get_search_fields($lab_config_id);
                        $brfields = get_lab_config_settings_barcode();
                        //print_r($brfields);
                       //"SELECT pid, p_addl, daily_num, pname, age, sex, dob FROM lab_config WHERE lab_config_id=$lab_config_id";

		//$current_specimen_list = array();
		//if($lab_config_id != "")
		//	$current_specimen_list = get_lab_config_specimen_types($lab_config_id);
		# For each specimen type, create a check box. Check it if specimen already in lab configuration
		?>
                <table>
                    <tr>
                        <td>Encoding Format: </td>
                                 <td>
                                <?php //$sfields['rpp']= '45';
                                echo "<select id='brfields_type' name='brfields_type'>";
                                $codeTypes = getBarcodeTypes();
                                foreach ($codeTypes as $type)
                                {
                                    if($brfields['type'] == $type)
                                    echo "<option selected value='".$type."'>".$type."</option>";
                                    else
                                    echo "<option value='".$type."'>".$type."</option>";
                                }
                                echo "</select>";?></td>
                    </tr>
                    <tr>
                               <td> Barcode Width:
                                   </td>
                                   <td>
                                <?php //$sfields['rpp']= '45';
                                echo "<select id='brfields_width' name='brfields_width'>";
                                $i = 1;
                                while($i < 11)
                                {
                                    if($brfields['width'] == $i)
                                    echo "<option selected value='".$i."'>".$i."</option>";
                                    else
                                    echo "<option value='".$i."'>".$i."</option>";
                                    $i++;
                                }
                                echo "</select>";?>
                                   </td>
                        </tr>
                        <tr>
                                 <td>Barcode Height:</td>
                                 <td>
                                <?php //$sfields['rpp']= '45';
                                echo "<select id='brfields_height' name='brfields_height'>";
                                $i = 5;
                                while($i < 81)
                                {
                                    if($brfields['height'] == $i)
                                    echo "<option selected value='".$i."'>".$i."</option>";
                                    else
                                    echo "<option value='".$i."'>".$i."</option>";
                                    $i++;
                                }
                                echo "</select>";?>
                                </td>
                           </tr>
                          <tr>
                              <td>Text Size:</td>
                                 <td>
                                <?php //$sfields['rpp']= '45';
                                echo "<select id='brfields_textsize' name='brfields_textsize'>";
                                $i = 5;
                                while($i < 40)
                                {
                                    if($brfields['textsize'] == $i)
                                    echo "<option selected value='".$i."'>".$i."</option>";
                                    else
                                    echo "<option value='".$i."'>".$i."</option>";
                                    $i++;
                                }
                                echo "</select>";?></td>
                          </tr>
                    </table>
		<?php
	}

	public function getMeasureCheckboxes($lab_config_id="")
	{
		# Returns a set of checkboxes with existing test types checked
		$lab_config = get_lab_config_by_id($lab_config_id);
		if($lab_config == null && $lab_config_id != "")
		{
			?>
			<div class='sidetip_nopos'>
			ERROR: Lab configuration not found
			</div>
			<?php
			return;
		}
		# Fetch all specimen types
		$measure_list = get_measures_catalog();
		# For each measure, create a check box.
		?>
		<table class='hor-minimalist-b' style='width:700px;'>
			<tbody>
			<tr>
			<?php
			$count = 0;
			foreach($measure_list as $key=>$value)
			{
				$measure_id = $key;
				$measure_name = $value;
				$count++;
				?>
				<td><input type='checkbox' class='m_entry' name='m_<?php echo $key; ?>' id='m_<?php echo $key; ?>'
				<?php
				/*
				if(in_array($test_type_id, $current_test_list))
				{
					echo " checked ";
				}
				*/
				?>
				>
				<?php
				/*
				if(in_array($test_type_id, $current_test_list))
				{
					?>
					<span class='clean-ok'><?php echo $test_name; ?></span>
					<?php
				}
				else
				*/
				echo $measure_name;
				?>
				</input></td>

				<?php
				if($count % 2 == 0)
					echo "</tr><tr>";
			}
			?>
			</tbody>
		</table>
		<?php
	}

	public function getConfirmDialog($div_id, $message, $ok_function_call, $cancel_function_call, $width=300)
	{
		?>
		<div id='<?php echo $div_id; ?>' class='clean-orange' style='display:none;width:<?php echo $width; ?>px;'>
			<?php echo $message; ?>
			<br><br>
			<input type='button' onclick="<?php echo $ok_function_call; ?>;" value="<?php echo LangUtil::$generalTerms['CMD_OK']; ?>"></input>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input type='button' onclick="<?php echo $cancel_function_call; ?>;" value="<?php echo LangUtil::$generalTerms['CMD_CANCEL']; ?>"></input>
		</div>
		<?php
	}

	public function getAlertDialog($div_id, $message, $width=300)
	{
		?>
		<div id='<?php echo $div_id; ?>' class='clean-orange' style='display:none;width:<?php echo $width; ?>px;'>
			<?php echo $message; ?>
			<br><br>
			<input type='button' onclick="toggle('<?php echo $div_id; ?>');" value="<?php echo LangUtil::$generalTerms['CMD_OK']; ?>"></input>
		</div>
		<?php
	}

	public function getCompatibilityJsArray($array_name, $lab_config_id=null)
	{
		# Returns a JavaScript array storing compatible test types for each specimen type
		$specimen_type_list = get_specimen_types_catalog($lab_config_id);
		echo "$array_name=new Array(); ";
		foreach($specimen_type_list as $key=>$value)
		{
			$test_list = get_compatible_tests($key);
			$test_csv = implode(",", $test_list);
			echo $array_name."[".$key."]='$test_csv'; ";
		}
	}

        public function getGroupedCountReportConfigureForm($lab_config)
        {
            $configArray = getTestCountGroupedConfig($lab_config->id);
            $byAge = $configArray['group_by_age'];
            $ageGroups = $configArray['age_groups'];
            $byGender = $configArray['group_by_gender'];
            $bySection = $configArray['measure_id'];
            $combo = $configArray['test_type_id']; // 1 - registered, 2 - completed, 3 - completed / pending

            $sp_configArray = getSpecimenCountGroupedConfig($lab_config->id);
            $sp_byAge = $sp_configArray['group_by_age'];
            $sp_ageGroups = $sp_configArray['age_groups'];
            $sp_byGender = $sp_configArray['group_by_gender'];
            $sp_bySection = $sp_configArray['measure_id'];
            $sp_combo = $sp_configArray['test_type_id']; // 1 - registered, 2 - completed, 3 - completed / pending

            ?>
            <input type='hidden' name='lab_config_id' value='<?php echo $lab_config->id; ?>'></input>
		<div class='pretty_box' style='width:700px;'>
		<table cellspacing='5px'>
                    <th></th>
                    <th>Test Count (Grouped) Report Settings:</th>
                    </tr>
			<tbody>
                            <tr valign='top'>
					<td><?php echo "Group By Lab Section"; ?></td>
					<td>
						<input type='radio' id='rsection' name='rsection' value='y' <?php
						if($bySection == 1)
							echo " checked ";
						?>><?php echo LangUtil::$generalTerms['YES']; ?></input>
						&nbsp;&nbsp;&nbsp;
						<input type='radio' id='rsection' name='rsection' value='n' <?php
						if($bySection == 0)
							echo " checked ";
						?>><?php echo LangUtil::$generalTerms['NO']; ?></input>
					</td>
				</tr>
				<tr valign='top'>
					<td><?php echo LangUtil::$pageTerms['GROUP_BYGENDER']; ?></td>
					<td>
						<input type='radio' id='rgender' name='rgender' value='y' <?php
						if($byGender == 1)
							echo " checked ";
						?>><?php echo LangUtil::$generalTerms['YES']; ?></input>
						&nbsp;&nbsp;&nbsp;
						<input type='radio' id='rgender' name='rgender' value='n' <?php
						if($byGender == 0)
							echo " checked ";
						?>><?php echo LangUtil::$generalTerms['NO']; ?></input>
					</td>
				</tr>
				<tr valign='top'>
					<td><?php echo LangUtil::$pageTerms['GROUP_BYAGE']; ?></td>
					<td>
						<input type='radio' id='rage' name='rage' value='y'<?php
						if($byAge == 1)
							echo " checked ";
						?>><?php echo LangUtil::$generalTerms['YES']; ?></input>
						&nbsp;&nbsp;&nbsp;
						<input type='radio' id='rage' name='rage' value='n'<?php
						if($byAge == 0)
							echo " checked ";
						?>><?php echo LangUtil::$generalTerms['NO']; ?></input>
					</td>
				</tr>
				<tr valign='top' id='agegrouprow' <?php
						//if($byAge == 0)
							//echo " style='display:none' ";
						?>>
					<td><?php echo LangUtil::$pageTerms['RANGE_AGE']; ?> (<?php echo LangUtil::$generalTerms['YEARS']; ?>)</td>
					<td>
						<div id='t_agegrouplist'>
							<span id='t_agegrouplist_inner'>
							<?php

								# Group by age enabled. Shoe prefilled form fields.
                                                            $age_parts = explode(",", $ageGroups);
								foreach($age_parts as $age_part)
								{
									if(trim($age_part) == "")
										continue;
									$age_bounds = explode(":", $age_part);
									?>
									<input type='text' name='age_l[]' class='range_field' value='<?php echo $age_bounds[0]; ?>'></input>-<input type='text' name='age_u[]' class='range_field' value='<?php echo $age_bounds[1]; ?>'></input>&nbsp;&nbsp;&nbsp;
									<?php
								}

							?>
							</span>
							<br>
							<a href='javascript:t_agegrouplist_append();'><?php echo LangUtil::$generalTerms['ADDANOTHER']; ?> &raquo;</a>
						</div>
					</td>
				</tr>
                                <tr valign='top'>
					<td><?php echo "Counts to Display"; ?></td>
					<td>
						<input type='radio' id='rcombo' name='rcombo' value='1'<?php
						if($combo == 1)
							echo " checked ";
						?>><?php echo "All registered tests"; ?></input>
						<br>
						<input type='radio' id='rcombo' name='rcombo' value='2'<?php
						if($combo == 2)
							echo " checked ";
						?>><?php echo "Only completed tests"; ?></input>
                                                <br>
                                                <input type='radio' id='rcombo' name='rcombo' value='3'<?php
						if($combo == 3)
							echo " checked ";
						?>><?php echo "Both completed and pending tests (separated by a slash)"; ?></input>
					</td>
				</tr>
                                <tr>
                                <th></th>
                                 <th><br>Specimen Count (Grouped) Report Settings:</th>
                                 </tr>
                                <tr valign='top'>
					<td><?php echo LangUtil::$pageTerms['GROUP_BYGENDER']; ?></td>
					<td>
						<input type='radio' id='sp_rgender' name='sp_rgender' value='y' <?php
						if($sp_byGender == 1)
							echo " checked ";
						?>><?php echo LangUtil::$generalTerms['YES']; ?></input>
						&nbsp;&nbsp;&nbsp;
						<input type='radio' id='sp_rgender' name='sp_rgender' value='n' <?php
						if($sp_byGender == 0)
							echo " checked ";
						?>><?php echo LangUtil::$generalTerms['NO']; ?></input>
					</td>
				</tr>
				<tr valign='top'>
					<td><?php echo LangUtil::$pageTerms['GROUP_BYAGE']; ?></td>
					<td>
						<input type='radio' id='sp_rage' name='sp_rage' value='y'<?php
						if($sp_byAge == 1)
							echo " checked ";
						?>><?php echo LangUtil::$generalTerms['YES']; ?></input>
						&nbsp;&nbsp;&nbsp;
						<input type='radio' id='sp_rage' name='sp_rage' value='n'<?php
						if($sp_byAge == 0)
							echo " checked ";
						?>><?php echo LangUtil::$generalTerms['NO']; ?></input>
					</td>
				</tr>
				<tr valign='top' id='sp_agegrouprow' <?php
						//if($sp_byAge == 0)
						//	echo " style='display:none' ";
						?>>
					<td><?php echo LangUtil::$pageTerms['RANGE_AGE']; ?> (<?php echo LangUtil::$generalTerms['YEARS']; ?>)</td>
					<td>
						<div id='s_agegrouplist'>
							<span id='s_agegrouplist_inner'>
							<?php

								# Group by age enabled. Shoe prefilled form fields.
                                                            $sp_age_parts = explode(",", $sp_ageGroups);
								foreach($sp_age_parts as $age_part)
								{
									if(trim($age_part) == "")
										continue;
									$age_bounds = explode(":", $age_part);
									?>
									<input type='text' name='sp_age_l[]' class='range_field' value='<?php echo $age_bounds[0]; ?>'></input>-<input type='text' name='sp_age_u[]' class='range_field' value='<?php echo $age_bounds[1]; ?>'></input>&nbsp;&nbsp;&nbsp;
									<?php
								}

							?>
							</span>
							<br>
							<a href='javascript:s_agegrouplist_append();'><?php echo LangUtil::$generalTerms['ADDANOTHER']; ?> &raquo;</a>
						</div>
					</td>
				</tr>

                                <tr valign='top'>
					<td></td>
					<td>
						<br>
						<input type='button' id='rsubmit' onclick='javascript:grouped_checkandsubmit();' value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT'];?>'></input>
						&nbsp;&nbsp;&nbsp;
						<span id='grouped_count_progress_spinner' style='display:none'>
							<?php $this->getProgressSpinner(LangUtil::$generalTerms['CMD_SUBMITTING']); ?>
						</span>
					</td>
				</tr>

                                </tbody>
		</table>
		</div>
            <?php
        }

        public function getGroupedCountReportConfigureFormCountryDir($lab_config)
        {
            $configArray = getTestCountGroupedConfigCountryDir($lab_config->id);
            $byAge = $configArray['group_by_age'];
            $ageGroups = $configArray['age_groups'];
            $byGender = $configArray['group_by_gender'];
            $bySection = $configArray['measure_id'];
            $combo = $configArray['test_type_id']; // 1 - registered, 2 - completed, 3 - completed / pending
            $age_unit = $configArray['age_unit']; //the unit of age represented by integer [1: Years, 2: Months, 3: Weeks, 4: Days]

            $sp_configArray = getSpecimenCountGroupedConfigCountryDir($lab_config->id);
            $sp_byAge = $sp_configArray['group_by_age'];
            $sp_ageGroups = $sp_configArray['age_groups'];
            $sp_byGender = $sp_configArray['group_by_gender'];
            $sp_bySection = $sp_configArray['measure_id'];
            $sp_combo = $sp_configArray['test_type_id']; // 1 - registered, 2 - completed, 3 - completed / pending
            $sp_age_unit = $sp_configArray['age_unit']; //the unit of age represented by integer [1: Years, 2: Months, 3: Weeks, 4: Days]

            ?>
            <input type='hidden' name='lab_config_id' value='<?php echo $lab_config->id; ?>'></input>
		<div class='pretty_box' style='width:700px;'>
		<table cellspacing='5px'>
                    <th></th>
                    <th>Test Count (Grouped) Report Settings:</th>
                    </tr>
			<tbody>
                            <tr valign='top'>
					<td><?php echo "Group By Lab Section"; ?></td>
					<td>
						<input type='radio' id='rsection' name='rsection' value='y' <?php
						if($bySection == 1)
							echo " checked ";
						?>><?php echo LangUtil::$generalTerms['YES']; ?></input>
						&nbsp;&nbsp;&nbsp;
						<input type='radio' id='rsection' name='rsection' value='n' <?php
						if($bySection == 0)
							echo " checked ";
						?>><?php echo LangUtil::$generalTerms['NO']; ?></input>
					</td>
				</tr>
				<tr valign='top'>
					<td><?php echo LangUtil::$pageTerms['GROUP_BYGENDER']; ?></td>
					<td>
						<input type='radio' id='rgender' name='rgender' value='y' <?php
						if($byGender == 1)
							echo " checked ";
						?>><?php echo LangUtil::$generalTerms['YES']; ?></input>
						&nbsp;&nbsp;&nbsp;
						<input type='radio' id='rgender' name='rgender' value='n' <?php
						if($byGender == 0)
							echo " checked ";
						?>><?php echo LangUtil::$generalTerms['NO']; ?></input>
					</td>
				</tr>

				<tr valign='top'>
					<td><?php echo LangUtil::$pageTerms['AGE_UNIT']; ?></td>
					<td>
						<input type='radio' id='rage_unit' name='rage_unit' value='Years'<?php
						if($age_unit == 1)
							echo " checked ";
						?>><?php echo LangUtil::$generalTerms['YEARS']; ?></input>
						&nbsp;&nbsp;&nbsp;
						<input type='radio' id='rage_unit' name='rage_unit' value='Months'<?php
						if($age_unit == 2)
							echo " checked ";
						?>><?php echo LangUtil::$generalTerms['MONTHS']; ?></input>
						&nbsp;&nbsp;&nbsp;
						<input type='radio' id='rage_unit' name='rage_unit' value='Weeks'<?php
						if($age_unit == 3)
							echo " checked ";
						?>><?php echo LangUtil::$generalTerms['WEEKS']; ?></input>
						&nbsp;&nbsp;&nbsp;
						<input type='radio' id='rage_unit' name='rage_unit' value='Days'<?php
						if($age_unit == 4)
							echo " checked ";
						?>><?php echo LangUtil::$generalTerms['DAYS']; ?></input>

					</td>
				</tr>
				<tr valign='top' id='agegrouprow' <?php
						//if($sp_byAge == 0)
						//	echo " style='display:none' ";
						?>>
					<td><?php echo LangUtil::$pageTerms['RANGE_AGE']; ?> </td>
					<td>
						<div id='agegrouplist'>
							<span id='agegrouplist_inner'>
							<?php

								# Group by age enabled. Shoe prefilled form fields.
                                                            $age_parts = explode(",", $ageGroups);
								foreach($age_parts as $age_part)
								{
									if(trim($age_part) == "")
										continue;
									$age_bounds = explode(":", $age_part);
									?>
									<input type='text' name='age_l[]' class='range_field' value='<?php echo $age_bounds[0]; ?>'></input>-<input type='text' name='age_u[]' class='range_field' value='<?php echo $age_bounds[1]; ?>'></input>&nbsp;&nbsp;&nbsp;
									<?php
								}

							?>
							</span>
							<br>
							<a href='javascript:agegrouplist_append();'><?php echo LangUtil::$generalTerms['ADDANOTHER']; ?> &raquo;</a>
						</div>
					</td>
				</tr>
								<tr valign='top'>
					<td><?php echo LangUtil::$pageTerms['GROUP_BYAGE']; ?></td>
					<td>
						<input type='radio' id='rage' name='rage' value='y'<?php
						if($byAge == 1)
							echo " checked ";
						?>><?php echo LangUtil::$generalTerms['YES']; ?></input>
						&nbsp;&nbsp;&nbsp;
						<input type='radio' id='rage' name='rage' value='n'<?php
						if($byAge == 0)
							echo " checked ";
						?>><?php echo LangUtil::$generalTerms['NO']; ?></input>
					</td>
				</tr>


                                <tr valign='top'>
					<td><?php echo "Counts to Display"; ?></td>
					<td>
						<input type='radio' id='rcombo' name='rcombo' value='1'<?php
						if($combo == 1)
							echo " checked ";
						?>><?php echo "All registered tests"; ?></input>
						<br>
						<input type='radio' id='rcombo' name='rcombo' value='2'<?php
						if($combo == 2)
							echo " checked ";
						?>><?php echo "Only completed tests"; ?></input>
                                                <br>
                                                <input type='radio' id='rcombo' name='rcombo' value='3'<?php
						if($combo == 3)
							echo " checked ";
						?>><?php echo "Both completed and pending tests (separated by a slash)"; ?></input>
					</td>
				</tr>
                                <tr>
                                <th></th>
                                 <th><br>Specimen Count (Grouped) Report Settings:</th>
                                 </tr>
                                <tr valign='top'>
					<td><?php echo LangUtil::$pageTerms['GROUP_BYGENDER']; ?></td>
					<td>
						<input type='radio' id='sp_rgender' name='sp_rgender' value='y' <?php
						if($sp_byGender == 1)
							echo " checked ";
						?>><?php echo LangUtil::$generalTerms['YES']; ?></input>
						&nbsp;&nbsp;&nbsp;
						<input type='radio' id='sp_rgender' name='sp_rgender' value='n' <?php
						if($sp_byGender == 0)
							echo " checked ";
						?>><?php echo LangUtil::$generalTerms['NO']; ?></input>
					</td>
				</tr>
				<tr valign='top'>
					<td><?php echo LangUtil::$pageTerms['GROUP_BYAGE']; ?></td>
					<td>
						<input type='radio' id='sp_rage' name='sp_rage' value='y'<?php
						if($sp_byAge == 1)
							echo " checked ";
						?>><?php echo LangUtil::$generalTerms['YES']; ?></input>
						&nbsp;&nbsp;&nbsp;
						<input type='radio' id='sp_rage' name='sp_rage' value='n'<?php
						if($sp_byAge == 0)
							echo " checked ";
						?>><?php echo LangUtil::$generalTerms['NO']; ?></input>
					</td>
				</tr>
				<tr valign='top'>
					<td><?php echo LangUtil::$pageTerms['AGE_UNIT']; ?></td>
					<td>
						<input type='radio' id='sp_rage_unit' name='sp_rage_unit' value='Years'<?php
						if($sp_age_unit == 1)
							echo " checked ";
						?>><?php echo LangUtil::$generalTerms['YEARS']; ?></input>
						&nbsp;&nbsp;&nbsp;
						<input type='radio' id='sp_rage_unit' name='sp_rage_unit' value='Months'<?php
						if($sp_age_unit == 2)
							echo " checked ";
						?>><?php echo LangUtil::$generalTerms['MONTHS']; ?></input>
						&nbsp;&nbsp;&nbsp;
						<input type='radio' id='sp_rage_unit' name='sp_rage_unit' value='Weeks'<?php
						if($sp_age_unit == 3)
							echo " checked ";
						?>><?php echo LangUtil::$generalTerms['WEEKS']; ?></input>
						&nbsp;&nbsp;&nbsp;
						<input type='radio' id='sp_rage_unit' name='sp_rage_unit' value='Days'<?php
						if($sp_age_unit == 4)
							echo " checked ";
						?>><?php echo LangUtil::$generalTerms['DAYS']; ?></input>

					</td>
				</tr>
				<tr valign='top' id='sp_agegrouprow' <?php
						//if($sp_byAge == 0)
						//	echo " style='display:none' ";
						?>>
					<td><?php echo LangUtil::$pageTerms['RANGE_AGE']; ?></td>
					<td>
						<div id='s_agegrouplist'>
							<span id='s_agegrouplist_inner'>
							<?php

								# Group by age enabled. Shoe prefilled form fields.
                                                            $sp_age_parts = explode(",", $sp_ageGroups);
								foreach($sp_age_parts as $age_part)
								{
									if(trim($age_part) == "")
										continue;
									$age_bounds = explode(":", $age_part);
									?>
									<input type='text' name='sp_age_l[]' class='range_field' value='<?php echo $age_bounds[0]; ?>'></input>-<input type='text' name='sp_age_u[]' class='range_field' value='<?php echo $age_bounds[1]; ?>'></input>&nbsp;&nbsp;&nbsp;
									<?php
								}

							?>
							</span>
							<br>
							<a href='javascript:s_agegrouplist_append();'><?php echo LangUtil::$generalTerms['ADDANOTHER']; ?> &raquo;</a>
						</div>
					</td>
				</tr>

                                <tr valign='top'>
					<td></td>
					<td>
						<br>
						<input type='button' id='rsubmit' onclick='javascript:specimen_aggregate_checkandsubmit();' value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT'];?>'></input>
						&nbsp;&nbsp;&nbsp;
						<span id='grouped_count_country_dir_progress_spinner' style='display:none'>
							<?php $this->getProgressSpinner(LangUtil::$generalTerms['CMD_SUBMITTING']); ?>
						</span>
					</td>
				</tr>

                                </tbody>
		</table>
		</div>
            <?php
        }

        public function getTestAggregateReportSummary($lab_config_id, $test_type)
        {
        	$test_type_id = $test_type->testTypeId;
        	$test_agg_report_count = TestAggReportConfig::getByTestTypeId(
        		$lab_config_id, $test_type_id, 1);
        	$test_agg_report_site = TestAggReportConfig::getByTestTypeId(
        		$lab_config_id, $test_type_id, 2);
        	?>

        	<div class="pretty_box"
        		 style="width: 700px;">

        		<table class="hor-minimalist-b">
        			<tr>
        				<th></th>
        				<th><b><?php
        					echo $test_agg_report_count->title.
        					" ".
        					LangUtil::$pageTerms['COUNT_REPORT'];
        					?></b></th>
					</tr>
        			<tbody>
        				<tr valign="top">
							<td><?php echo LangUtil::$pageTerms['GROUP_BYAGE']; ?></td>
							<td>
								<?php
									if ($test_agg_report_count->group_by_age == 1)
										echo LangUtil::$generalTerms['YES'];
									else
									    echo LangUtil::$generalTerms['NO'];
								?>
							</td>
						</tr>
        				<tr valign="top">
							<td><?php echo LangUtil::$pageTerms['AGE_UNIT']; ?></td>
							<td>
								<?php
									switch($test_agg_report_count->age_unit)
									{
										case 1:
											echo LangUtil::$generalTerms['YEARS'];
											break;
										case 2:
											echo LangUtil::$generalTerms['MONTHS'];
											break;
										case 3:
											echo LangUtil::$generalTerms['WEEKS'];
											break;
										case 4:
											echo LangUtil::$generalTerms['DAYS'];
											break;
									}
								?>
							</td>
						</tr>
        				<tr valign="top"
        				<?php
        					if($test_agg_report_count->group_by_age == 0)
        						echo " style='display:none'";
        				?>>
							<td><?php echo LangUtil::$pageTerms['RANGE_AGE']; ?>
								(<?php echo LangUtil::$generalTerms['YEARS']; ?>)
							</td>
							<td>
								<?php
									foreach ($test_agg_report_count->age_groups as $age_group)
									{
									    if(trim($age_group) == "")
									    	continue;
									    $age_bounds = explode('-', $age_group);
									    echo $age_bounds[0]."-".$age_bounds[1];
									    echo "&nbsp;&nbsp;&nbsp;";
									}
								?>
							</td>
						</tr>
        			<tr>
        				<th></th>
        				<th><b><?php
        					echo $test_agg_report_site->title.
        					" ".
        					LangUtil::$pageTerms['SITE_REPORT'];
        					?></b></th>
					</tr>
        				<tr valign="top">
							<td><?php echo LangUtil::$pageTerms['GROUP_BYAGE']; ?></td>
							<td>
								<?php
									if ($test_agg_report_site->group_by_age == 1)
										echo LangUtil::$generalTerms['YES'];
									else
									    echo LangUtil::$generalTerms['NO'];
								?>
							</td>
						</tr>
        				<tr valign="top">
							<td><?php echo LangUtil::$pageTerms['AGE_UNIT']; ?></td>
							<td>
								<?php
									switch($test_agg_report_site->age_unit)
									{
										case 1:
											echo LangUtil::$generalTerms['YEARS'];
											break;
										case 2:
											echo LangUtil::$generalTerms['MONTHS'];
											break;
										case 3:
											echo LangUtil::$generalTerms['WEEKS'];
											break;
										case 4:
											echo LangUtil::$generalTerms['DAYS'];
											break;
									}
								?>
							</td>
						</tr>
        				<tr valign="top"
        				<?php
        					if($test_agg_report_site->group_by_age == 0)
        						echo " style='display:none'";
        				?>>
							<td><?php echo LangUtil::$pageTerms['RANGE_AGE']; ?>
								(<?php echo LangUtil::$generalTerms['YEARS']; ?>)
							</td>
							<td>
								<?php
									foreach ($test_agg_report_site->age_groups as $age_group)
									{
									    if(trim($age_group) == "")
									    	continue;
									    $age_bounds = explode('-', $age_group);
									    echo $age_bounds[0]."-".$age_bounds[1];
									    echo "&nbsp;&nbsp;&nbsp;";
									}
								?>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<?php
        }

        public function getTestAggregateReportConfigureForm($lab_config_id, $test_type)
        {
        	$test_type_id = $test_type->testTypeId;
        	$test_agg_report_count = TestAggReportConfig::getByTestTypeId(
        		$lab_config_id, $test_type_id, 1);
        	$test_agg_report_site = TestAggReportConfig::getByTestTypeId(
        		$lab_config_id, $test_type_id, 2);
        	?>

        	<div class="pretty_box" style="width: 700px">
        		<input type="hidden" id="lab_config_id" name="lab_config_id" value="<?php echo $lab_config_id; ?>">
			    <input type="hidden" id="test_type_id" name="test_type_id" value="<?php echo $test_type_id;?>">
        		<table cellspacing="5px">
        			<tbody>
        				<tr>
        					<th></th>
        					<th>
        						<?php
        						echo $test_agg_report_count->title.
 		       					" ".
    	    					LangUtil::$pageTerms['COUNT_REPORT'];
 								?>
 							</th>
						</tr>
						<tr valign="top">
							<td><?php echo LangUtil::$pageTerms['GROUP_BYAGE']; ?></td>
							<td>
								<input type="radio" id="groupby_age_toggle_count"
									name="groupby_age_toggle_count" value="1"
									<?php
										if($test_agg_report_count->group_by_age == 1)
											echo " checked ";
									?>
								><?php echo LangUtil::$generalTerms['YES']; ?>
								&nbsp;&nbsp;&nbsp;
								<input type="radio" id="groupby_age_toggle_count"
									name="groupby_age_toggle_count" value="0"
									<?php
										if($test_agg_report_count->group_by_age == 0)
											echo " checked ";
									?>
								><?php echo LangUtil::$generalTerms['NO']; ?>
							</td>
						</tr>
						<tr valign="top">
							<td><?php echo LangUtil::$pageTerms['AGE_UNIT']; ?></td>
							<td>
								<input type="radio" id="age_unit_choice_count"
									name="age_unit_choice_count" value="1"
									<?php
										if($test_agg_report_count->age_unit == 1)
											echo " checked ";
									?>
								><?php echo LangUtil::$generalTerms['YEARS']; ?>
								<input type="radio" id="age_unit_choice_count"
									name="age_unit_choice_count" value="2"
									<?php
										if($test_agg_report_count->age_unit == 2)
											echo " checked ";
									?>
								><?php echo LangUtil::$generalTerms['MONTHS']; ?>
								<input type="radio" id="age_unit_choice_count"
									name="age_unit_choice_count" value="3"
									<?php
										if($test_agg_report_count->age_unit == 3)
											echo " checked ";
									?>
								><?php echo LangUtil::$generalTerms['WEEKS']; ?>
								<input type="radio" id="age_unit_choice_count"
									name="age_unit_choice_count" value="4"
									<?php
										if($test_agg_report_count->age_unit == 4)
											echo " checked ";
									?>
								><?php echo LangUtil::$generalTerms['DAYS']; ?>
							</td>
						</tr>
						<tr valign="top" id="age_group_row_count">
							<td><?php echo LangUtil::$pageTerms['RANGE_AGE']; ?>
							<td>
								<div id="age_group_split_div_count">
									<span id="age_group_split_span_count">
										<?php
											foreach ($test_agg_report_count->age_groups as $age_group)
											{
												$age_bounds = explode('-', $age_group);
										?>

										<input type="text" name="age_limit_lower_count[]"
											class="range_field"
											value="<?php echo $age_bounds[0]; ?>">-
										<input type="text" name="age_limit_upper_count[]"
											class="range_field"
											value="<?php echo $age_bounds[1]; ?>">
										&nbsp;&nbsp;&nbsp;

										<?php
											}
 										?>
 										<br>
										<a href="javascript:agegrouplist_append_tcount();">
											<?php echo LangUtil::$generalTerms['ADDANOTHER']; ?>&raquo
										</a>
									</span>
								</div>

							</td>
						</tr>
        				<tr>
        					<th></th>
        					<th>
        						<?php
        						echo $test_agg_report_site->title.
 		       					" ".
    	    					LangUtil::$pageTerms['SITE_REPORT'];
 								?>
 							</th>
						</tr>
						<tr valign="top">
							<td><?php echo LangUtil::$pageTerms['GROUP_BYAGE']; ?></td>
							<td>
								<input type="radio" id="groupby_age_toggle_site"
									name="groupby_age_toggle_site" value="1"
									<?php
										if($test_agg_report_site->group_by_age == 1)
											echo " checked ";
									?>
								><?php echo LangUtil::$generalTerms['YES']; ?>
								&nbsp;&nbsp;&nbsp;
								<input type="radio" id="groupby_age_toggle_site"
									name="groupby_age_toggle_site" value="0"
									<?php
										if($test_agg_report_site->group_by_age == 0)
											echo " checked ";
									?>
								><?php echo LangUtil::$generalTerms['NO']; ?>
							</td>
						</tr>
						<tr valign="top">
							<td><?php echo LangUtil::$pageTerms['AGE_UNIT']; ?></td>
							<td>
								<input type="radio" id="age_unit_choice_site"
									name="age_unit_choice_site" value="1"
									<?php
										if($test_agg_report_site->age_unit == 1)
											echo " checked ";
									?>
								><?php echo LangUtil::$generalTerms['YEARS']; ?>
								<input type="radio" id="age_unit_choice_site"
									name="age_unit_choice_site" value="2"
									<?php
										if($test_agg_report_site->age_unit == 2)
											echo " checked ";
									?>
								><?php echo LangUtil::$generalTerms['MONTHS']; ?>
								<input type="radio" id="age_unit_choice_site"
									name="age_unit_choice_site" value="3"
									<?php
										if($test_agg_report_site->age_unit == 3)
											echo " checked ";
									?>
								><?php echo LangUtil::$generalTerms['WEEKS']; ?>
								<input type="radio" id="age_unit_choice_site"
									name="age_unit_choice_site" value="4"
									<?php
										if($test_agg_report_site->age_unit == 4)
											echo " checked ";
									?>
								><?php echo LangUtil::$generalTerms['DAYS']; ?>
							</td>
						</tr>
						<tr valign="top" id="age_group_row_site">
							<td><?php echo LangUtil::$pageTerms['RANGE_AGE']; ?>
							<td>
								<div id="age_group_split_div_site">
									<span id="age_group_split_span_site">
										<?php
											foreach ($test_agg_report_site->age_groups as $age_group)
											{
												$age_bounds = explode('-', $age_group);
										?>

										<input type="text" name="age_limit_lower_site[]"
											class="range_field"
											value="<?php echo $age_bounds[0]; ?>">-
										<input type="text" name="age_limit_upper_site[]"
											class="range_field"
											value="<?php echo $age_bounds[1]; ?>">
										&nbsp;&nbsp;&nbsp;

										<?php
											}
 										?>
 										<br>
										<a href="javascript:agegrouplist_append_tsite();">
											<?php echo LangUtil::$generalTerms['ADDANOTHER']; ?>&raquo
										</a>
									</span>
								</div>
							</td>
						</tr>
						<tr valign="top">
							<td></td>
							<td>
								<br>
								<input type="button" id="test_report_config_submit"
									onclick="javascript:test_report_conf_submit();"
									value="<?php echo LangUtil::$generalTerms['CMD_SUBMIT'];?>">
								&nbsp;&nbsp;&nbsp;
								<span id="test_report_config_submit_spinner" style="display: none;">
									<?php $this->getProgressSpinner(LangUtil::$generalTerms['CMD_SUBMITTING']);?>
								</span>
							</td>
						</tr>
					</tbody>
				</table>
			</div>

			<?php
        }

        public function showAggregateCountReport(
        $lab_config, $test, $test_report_config)
        {
            # Display the Count Report for a specific test
            # Just get test information, map to patients
            # and group by age

            $from_arr = array($_REQUEST['yyyy_from'], $_REQUEST['mm_from'], $_REQUEST['dd_from']);
            $to_arr = array($_REQUEST['yyyy_to'], $_REQUEST['mm_to'], $_REQUEST['dd_to']);
            $from_date = implode('-', $from_arr);
            $to_date = implode('-', $to_arr);

            $specimen_type_ids = SpecimenTest::getSpecimenIdsByTestTypeId($test_report_config->test_type_id);
            $specimens = array();
            foreach ($specimen_type_ids as $id)
            	$specimens[] = Specimen::getSpecimensByDateRange($id['specimen_type_id'], $from_date, $to_date);

            $table_data = array();
            $site_data = array();

            foreach ($specimens as $specimen_type) {
                if ($specimen_type == null)
                	$specimen_type = array();
            	foreach ($specimen_type as $sample) {
                    $data = array();
            		$patient_id = $sample->patientId;
            		$site_id = $sample->site_id;
            		$patient_age = Patient::getById($patient_id)->getAgeNumber();
            		$site = Sites::getById($site_id);

            		$data['age'] = $patient_age;
            	    $data['name'] = $site->name;
            		$table_data[] = $data;
            		$site_data[] = $site->name;
            	}
            }
            $sites = array_unique($site_data);
            $all_sites = Sites::getByLabConfigId($lab_config->id);
            ?>
            <head>
            <style>
            	table {
            		margin-left: 60px;
            		border: 1px solid black;
            	}
            	thead th, tbody td {
            		width: 70px;
            		text-align: center;
            		border: 1px solid black;
            		border-collapse: collapse;
            	}
			</style>
			</head>
			<br><br>

            <table id="count_report_table">
            	<thead>
            		<tr>
            			<th><?php echo LangUtil::$pageTerms['SITE']; ?></th>
            			<?php
						foreach ($test_report_config->age_groups as $range) {
                            if ($range != "") {

                            ?>
                            <th><?php echo $range ?></th>
                            <?php
                                }
						}
						?>
            			<th><?php echo LangUtil::$pageTerms['SAMPLES_RECEIVED']; ?></th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach ($all_sites as $sname) {
						?>
						<tr>
						<td><?php echo $sname->name; ?></td>

						<?php
						$ages = array();
						foreach ($table_data as $pair) {
							if ($pair['name'] == $sname->name)
								$ages[] = $pair['age'];
						}
						foreach ($test_report_config->age_groups as $range) {
                        if ($range != "") {
                            $limits = explode('-', $range);
                            $count = 0;
                            if ($limits[1] == '+')
                                $limits[1] = 100;
                            foreach ($ages as $age) {
                                if ($age >= $limits[0] && $age <= $limits[1])
                                    $count++;
                            }
                            ?>
                            <td><?php echo $count; ?></td>
                            <?php
                            }
						}
						?>
						<td> <?php echo count($ages); ?></td>
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
			<br><br>

            <b><?php echo LangUtil::$pageTerms['TOTAL_SAMPLES'] . " : ". count($table_data); ?></b>

            <?php

        }

        public function showAggregateSiteReport($site_id, $test, $test_report_config)
        {
            $from_arr = array($_REQUEST['yyyy_from'], $_REQUEST['mm_from'], $_REQUEST['dd_from']);
            $to_arr = array($_REQUEST['yyyy_to'], $_REQUEST['mm_to'], $_REQUEST['dd_to']);
            $from_date = implode('-', $from_arr);
            $to_date = implode('-', $to_arr);

            $specimen_type_ids = SpecimenTest::getSpecimenIdsByTestTypeId($test_report_config->test_type_id);
            $specimens = array();
            foreach ($specimen_type_ids as $id)
            	$specimens[] = Specimen::getSpecimensByDateRange($id['specimen_type_id'], $from_date, $to_date);

            $table_data = array();
            $site = Sites::getById($site_id);
			$no_sample = 0;
            foreach ($specimens as $specimen_type) {
                if ($specimen_type == null)
                	$specimen_type = array();
            	foreach ($specimen_type as $sample) {
            	    $record = Test::getTestBySpecimenID($sample->specimenId);
					$data = array();
					$patient_id = $sample->patientId;
					if ($sample->site_id == $site_id) {
						$patient = Patient::getById($patient_id);
						$data['patient_id'] = $patient->surrogateId;
						$data['dob'] = $patient->dob;
						$data['name'] = $patient->name;
						$data['collection_date'] = $sample->dateCollected;
						$data['test_name'] = $test->name;
						if ($record->result == null)
							#$data['result'] = $sample->specimenId;
							$data['result'] = "N/A";
						else {
							$data['result'] = $record->decodeResult(false,false);
						}
						$data['lab_staff'] = $sample->doctor;
						$table_data[] = $data;
						$no_sample = $no_sample + 1;

					}
            	}
            }
            ?>

            <head>
            <style>
            	table {
            		margin-left: 60px;
            		border: 1px solid black;
            	}
            	thead th, tbody td {
            		width: 70px;
            		text-align: center;
            		border: 1px solid black;
            		border-collapse: collapse;
            	}
			</style>
			</head>
			<p> <?php echo LangUtil::$pageTerms['SITE_REPORT'] . " : ". $site->name; ?></p>
			<p> <?php echo LangUtil::$pageTerms['TOTAL_SAMPLES'] . " : " . $no_sample; ?></p>

			<table id="site_report_table">
			    <thead><tr>
			    <th><?php echo LangUtil::$generalTerms['PATIENT_ID']; ?></th>
			    <th><?php echo LangUtil::$generalTerms['DOB']; ?></th>
			    <th><?php echo LangUtil::$generalTerms['NAME']; ?> </th>
			    <th><?php echo LangUtil::$generalTerms['C_DATE']; ?></th>
			    <th><?php echo LangUtil::$generalTerms['TEST']; ?></th>
			    <th><?php echo LangUtil::$generalTerms['RESULTS']; ?></th>
			    <th><?php echo LangUtil::$generalTerms['LAB_STAFF']; ?></th>
				</tr></thead>

				<tbody>
					<?php
					foreach ($table_data as $data) {
						?>
						<tr>
							<td><?php echo $data['patient_id']; ?></td>
							<td><?php echo $data['dob']; ?></td>
							<td><?php echo $data['name']; ?></td>
							<td><?php echo $data['collection_date']; ?></td>
							<td><?php echo $data['test_name']; ?></td>
							<td><?php echo $data['result']; ?></td>
							<td><?php echo $data['lab_staff']; ?></td>
                		</tr>
						<?php
					}
					?>
				</tbody>
			</table>

            <?php

        }

        public function getGroupedCountReportSummary($lab_config)
        {
            $configArray = getTestCountGroupedConfig($lab_config->id);
            $byAge = $configArray['group_by_age'];
            $ageGroups = $configArray['age_groups'];
            $byGender = $configArray['group_by_gender'];
            $bySection = $configArray['measure_id'];
            $combo = $configArray['test_type_id']; // 1 - registered, 2 - completed, 3 - completed / pending


            $sp_configArray = getSpecimenCountGroupedConfig($lab_config->id);
            $sp_byAge = $sp_configArray['group_by_age'];
            $sp_ageGroups = $sp_configArray['age_groups'];
            $sp_byGender = $sp_configArray['group_by_gender'];
            $sp_bySection = $sp_configArray['measure_id'];
            $sp_combo = $sp_configArray['test_type_id']; // 1 - registered, 2 - completed, 3 - completed / pending

            ?>
		<div class='pretty_box' style='width:700px;'>
		<table class='hor-minimalist-b'>
                    <tr>
                    <th></th>
                    <th><b>Test Count (Grouped) Report Settings:</b></th>
                    </tr>
			<tbody>
                            <tr valign='top'>
					<td><?php echo "Group By Lab Section"; ?></td>
					<td>
						<?php
						if($bySection == 1)
							echo LangUtil::$generalTerms['YES'];
						else
							echo LangUtil::$generalTerms['NO'];
						?>
					</td>
				</tr>
				<tr valign='top'>
					<td><?php echo LangUtil::$pageTerms['GROUP_BYGENDER']; ?></td>
					<td>
						<?php
						if($byGender == 1)
							echo LangUtil::$generalTerms['YES'];
						else
							echo LangUtil::$generalTerms['NO'];
						?>
					</td>
				</tr>
				<tr valign='top'>
					<td><?php echo LangUtil::$pageTerms['GROUP_BYAGE']; ?></td>
					<td>
						<?php
						if($byAge == 1)
							echo LangUtil::$generalTerms['YES'];
						else
							echo LangUtil::$generalTerms['NO'];
						?>
					</td>
				</tr>
				<tr valign='top' <?php
						if($byAge == 0)
							echo " style='display:none' ";
						?>>
					<td><?php echo LangUtil::$pageTerms['RANGE_AGE']; ?> (<?php echo LangUtil::$generalTerms['YEARS']; ?>)</td>
					<td>
						<?php
						# Group by age enabled
                                                $age_parts = explode(",", $ageGroups);
						foreach($age_parts as $age_part)
						{
							if(trim($age_part) == "")
								continue;
							$age_bounds = explode(":", $age_part);
							echo $age_bounds[0]."-".$age_bounds[1];
							echo "&nbsp;&nbsp;&nbsp;";
						}

					?>
					</td>
				</tr>
                                <tr valign='top'>
					<td><?php echo "Counts to Display"; ?></td>
					<td>
						<?php
						if($combo == 1)
							echo "All registered tests";
						else if($combo == 3)
							echo "Both completed and pending tests (separated by a slash)";
                                                else
                                                    echo "Only completed tests";

						?>
					</td>
				</tr>
                                <tr>
                                <th></th>
                                 <th><b>Specimen Count (Grouped) Report Settings:</b></th>
                                 </tr>
				<tr valign='top'>
					<td><?php echo LangUtil::$pageTerms['GROUP_BYGENDER']; ?></td>
					<td>
						<?php
						if($sp_byGender == 1)
							echo LangUtil::$generalTerms['YES'];
						else
							echo LangUtil::$generalTerms['NO'];
						?>
					</td>
				</tr>
				<tr valign='top'>
					<td><?php echo LangUtil::$pageTerms['GROUP_BYAGE']; ?></td>
					<td>
						<?php
						if($sp_byAge == 1)
							echo LangUtil::$generalTerms['YES'];
						else
							echo LangUtil::$generalTerms['NO'];
						?>
					</td>
				</tr>
				<tr valign='top' <?php
						if($sp_byAge == 0)
							echo " style='display:none' ";
						?>>
					<td><?php echo LangUtil::$pageTerms['RANGE_AGE']; ?> (<?php echo LangUtil::$generalTerms['YEARS']; ?>)</td>
					<td>
						<?php
						# Group by age enabled
                                                $sp_age_parts = explode(",", $sp_ageGroups);
						foreach($sp_age_parts as $age_part)
						{
							if(trim($age_part) == "")
								continue;
							$age_bounds = explode(":", $age_part);
							echo $age_bounds[0]."-".$age_bounds[1];
							echo "&nbsp;&nbsp;&nbsp;";
						}

					?>
					</td>
				</tr>

                                </tbody>
		</table>
		</div>
		<?php
        }
    public function getGroupedCountReportSummaryCountryDir($lab_config)
    {
        $configArray = getTestCountGroupedConfigCountryDir($lab_config->id);
        $byAge = $configArray['group_by_age'];
        $ageGroups = $configArray['age_groups'];
        $byGender = $configArray['group_by_gender'];
        $bySection = $configArray['measure_id'];
        $combo = $configArray['test_type_id']; // 1 - registered, 2 - completed, 3 - completed / pending
        $age_unit = $configArray['age_unit'];

        $sp_configArray = getSpecimenCountGroupedConfigCountryDir($lab_config->id);
        $sp_byAge = $sp_configArray['group_by_age'];
        $sp_ageGroups = $sp_configArray['age_groups'];
        $sp_byGender = $sp_configArray['group_by_gender'];
        $sp_bySection = $sp_configArray['measure_id'];
        $sp_combo = $sp_configArray['test_type_id']; // 1 - registered, 2 - completed, 3 - completed / pending
        $sp_age_unit = $sp_configArray['age_unit'];
        ?>
		<div class='pretty_box' style='width:700px;'>
		<table class='hor-minimalist-b'>
	                <tr>
	                <th></th>
	                <th><b>Test Count (Grouped) Report Settings:</b></th>
	                </tr>
			<tbody>
	                        <tr valign='top'>
					<td><?php echo "Group By Lab Section"; ?></td>
					<td>
						<?php
						if($bySection == 1)
							echo LangUtil::$generalTerms['YES'];
						else
							echo LangUtil::$generalTerms['NO'];
						?>
					</td>
				</tr>
				<tr valign='top'>
					<td><?php echo LangUtil::$pageTerms['GROUP_BYGENDER']; ?></td>
					<td>
						<?php
						if($byGender == 1)
							echo LangUtil::$generalTerms['YES'];
						else
							echo LangUtil::$generalTerms['NO'];
						?>
					</td>
				</tr>
				<tr valign='top'>
					<td><?php echo LangUtil::$pageTerms['GROUP_BYAGE']; ?></td>
					<td>
						<?php
						if($byAge == 1)
							echo LangUtil::$generalTerms['YES'];
						else
							echo LangUtil::$generalTerms['NO'];
						?>
					</td>
				</tr>
				<tr valign='top' <?php
						if($byAge == 0)
							echo " style='display:none' ";
						?>>
					<td><?php echo LangUtil::$pageTerms['AGE_UNIT']; ?></td>
					<td>
						<?php
						if($age_unit == 1)
							echo LangUtil::$generalTerms['YEARS'];
						else if($age_unit == 2)
							echo LangUtil::$generalTerms['MONTHS'];
						else if($age_unit == 3)
							echo LangUtil::$generalTerms['WEEKS'];
						else if($age_unit == 4)
							echo LangUtil::$generalTerms['DAYS'];
						?>
					</td>
				</tr>
				<tr valign='top' <?php
						if($byAge == 0)
							echo " style='display:none' ";
						?>>
					<td><?php echo LangUtil::$pageTerms['RANGE_AGE']; ?></td>
					<td>
						<?php
						# Group by age enabled
	                                            $age_parts = explode(",", $ageGroups);
						foreach($age_parts as $age_part)
						{
							if(trim($age_part) == "")
								continue;
							$age_bounds = explode(":", $age_part);
							echo $age_bounds[0]."-".$age_bounds[1];
							echo "&nbsp;&nbsp;&nbsp;";
						}

					?>
					</td>
				</tr>
	                            <tr valign='top'>
					<td><?php echo "Counts to Display"; ?></td>
					<td>
						<?php
						if($combo == 1)
							echo "All registered tests";
						else if($combo == 3)
							echo "Both completed and pending tests (separated by a slash)";
	                                            else
	                                                echo "Only completed tests";

						?>
					</td>
				</tr>
	                            <tr>
	                            <th></th>
	                             <th><b>Specimen Count (Grouped) Report Settings:</b></th>
	                             </tr>
				<tr valign='top'>
					<td><?php echo LangUtil::$pageTerms['GROUP_BYGENDER']; ?></td>
					<td>
						<?php
						if($sp_byGender == 1)
							echo LangUtil::$generalTerms['YES'];
						else
							echo LangUtil::$generalTerms['NO'];
						?>
					</td>
				</tr>
				<tr valign='top'>
					<td><?php echo LangUtil::$pageTerms['GROUP_BYAGE']; ?></td>
					<td>
						<?php
						if($sp_byAge == 1)
							echo LangUtil::$generalTerms['YES'];
						else
							echo LangUtil::$generalTerms['NO'];
						?>
					</td>
				</tr>
				<tr valign='top' <?php
						if($sp_byAge == 0)
							echo " style='display:none' ";
						?>>
					<td><?php echo LangUtil::$pageTerms['AGE_UNIT']; ?></td>
					<td>
						<?php
						if($sp_age_unit == 1)
							echo LangUtil::$generalTerms['YEARS'];
						else if($sp_age_unit == 2)
							echo LangUtil::$generalTerms['MONTHS'];
						else if($sp_age_unit == 3)
							echo LangUtil::$generalTerms['WEEKS'];
						else if($sp_age_unit == 4)
							echo LangUtil::$generalTerms['DAYS'];
						?>
					</td>
				</tr>
				<tr valign='top' <?php
						if($sp_byAge == 0)
							echo " style='display:none' ";
						?>>
					<td><?php echo LangUtil::$pageTerms['RANGE_AGE']; ?> </td>
					<td>
						<?php
						# Group by age enabled
	                                            $sp_age_parts = explode(",", $sp_ageGroups);
						foreach($sp_age_parts as $age_part)
						{
							if(trim($age_part) == "")
								continue;
							$age_bounds = explode(":", $age_part);
							echo $age_bounds[0]."-".$age_bounds[1];
							echo "&nbsp;&nbsp;&nbsp;";
						}

					?>
					</td>
				</tr>

	                            </tbody>
		</table>
		</div>
		<?php
    }

	public function getAggregateReportConfigureForm($lab_config)
	{
		# Returns HTML form elements for configuring aggregate reports
		# Called from lab_config_home.php

		# Fetch site-wide settings for all tests from dummy record
		$site_settings = DiseaseReport::getByKeys($lab_config->id, 0, 0);
		if($site_settings == null)
		{
			# TODO:
			//$this->getNewAggregateReportConfigForm($lab_config);
		}
		?>
		<input type='hidden' name='lab_config_id' value='<?php echo $lab_config->id; ?>'></input>
		<div class='pretty_box' style='width:700px;'>
		<table cellspacing='5px'>
			<tbody>
				<tr valign='top'>
					<td><?php echo LangUtil::$pageTerms['GROUP_BYGENDER']; ?></td>
					<td>
						<input type='radio' id='rgender' name='rgender' value='y' <?php
						if($site_settings->groupByGender == 1)
							echo " checked ";
						?>><?php echo LangUtil::$generalTerms['YES']; ?></input>
						&nbsp;&nbsp;&nbsp;
						<input type='radio' id='rgender' name='rgender' value='n' <?php
						if($site_settings->groupByGender == 0)
							echo " checked ";
						?>><?php echo LangUtil::$generalTerms['NO']; ?></input>
					</td>
				</tr>
				<tr valign='top'>
					<td><?php echo LangUtil::$pageTerms['GROUP_BYAGE']; ?></td>
					<td>
						<input type='radio' id='rage' name='rage' value='y'<?php
						if($site_settings->groupByAge == 1)
							echo " checked ";
						?>><?php echo LangUtil::$generalTerms['YES']; ?></input>
						&nbsp;&nbsp;&nbsp;
						<input type='radio' id='rage' name='rage' value='n'<?php
						if($site_settings->groupByAge == 0)
							echo " checked ";
						?>><?php echo LangUtil::$generalTerms['NO']; ?></input>
					</td>
				</tr>
				<tr valign='top' id='agegrouprow' <?php
						if($site_settings->groupByAge == 0)
							echo " style='display:none' ";
						?>>
					<td><?php echo LangUtil::$pageTerms['RANGE_AGE']; ?> (<?php echo LangUtil::$generalTerms['YEARS']; ?>)</td>
					<td>
						<div id='agegrouplist'>
							<span id='agegrouplist_inner'>
							<?php
							if($site_settings->groupByAge == 0)
							{
								# Group by age not enabled. Show empty form fields
							?>
								<input type='text' name='age_l[]' class='range_field'></input>-<input type='text' name='age_u[]' class='range_field'></input>
							<?php
							}
							else
							{
								# Group by age enabled. Shoe prefilled form fields.
								$age_parts = explode(",", $site_settings->ageGroups);
								foreach($age_parts as $age_part)
								{
									if(trim($age_part) == "")
										continue;
									$age_bounds = explode(":", $age_part);
									?>
									<input type='text' name='age_l[]' class='range_field' value='<?php echo $age_bounds[0]; ?>'></input>-<input type='text' name='age_u[]' class='range_field' value='<?php echo $age_bounds[1]; ?>'></input>&nbsp;&nbsp;&nbsp;
									<?php
								}
							}
							?>
							</span>
							<br>
							<a href='javascript:agegrouplist_append();'><?php echo LangUtil::$generalTerms['ADDANOTHER']; ?> &raquo;</a>
						</div>
					</td>
				</tr>
				<?php
				# For each test with numeric range, show ranges
				$test_list = $lab_config->getTestTypes();
				foreach($test_list as $test_type)
				{
					?>
					<tr valign='top'>
						<td>
							<?php echo $test_type->getName(); ?>
							<input type='hidden' name='ttypes[]' value='<?php echo $test_type->testTypeId; ?>'></input>
						</td>
						<td>
							<?php
							$measure_to_set = false;
							$measure_list = $test_type->getMeasures();
							?>
							<?php
							$measure_count = 0;
							foreach($measure_list as $measure)
							{
								$disease_report = DiseaseReport::getByKeys($lab_config->id, $test_type->testTypeId, $measure->measureId);
								$measure_count++;
								if(strpos($measure->range, "/") !== false)
								{
									# Alphanumeric options
									# Do nothing
									//$range_options = explode("/", $measure->range);
								}
								else
								{
									# Numeric ranges
									# Show fields to select range slots
									$measure_to_set = true;

									if(count($measure_list) != 1)
									{
										# Show measure names if more than one.
                                                                            if($measure->checkIfSubmeasure() == 1)
                                                                            {
                                                                                $decName = $measure->truncateSubmeasureTag();
                                                                            }
                                                                            else
                                                                            {
                                                                                $decName = $measure->getName();
                                                                            }
										echo $decName."&nbsp;&nbsp;&nbsp;";
									}
									$range_bounds = explode(":", $measure->range);
									$span_id = $test_type->testTypeId."_".$measure_count;
									$field_name_upper = "slotu_".$test_type->testTypeId."_".$measure->measureId;
									$field_name_lower = "slotl_".$test_type->testTypeId."_".$measure->measureId;
									?>
									<span id='<?php echo $span_id; ?>'>
										<?php
										if($disease_report == null)
										{
											# No entry exists. Show default values.
											?>
											<input type='text' class='range_field' name='<?php echo $field_name_lower; ?>[]' value='<?php echo $range_bounds[0]; ?>'></input>-<input type='text' class='range_field' name='<?php echo $field_name_upper; ?>[]' value='<?php echo $range_bounds[1]; ?>'></input>
											<?php
										}
										else
										{
											# Entries exist. Prefill form with these values.
											$slot_list = explode(",", $disease_report->measureGroups);
											foreach($slot_list as $slot_part)
											{
												if(trim($slot_part) == "")
													continue;
												$slot_bounds = explode(":", $slot_part);
                                                                                                if($slot_bounds[0] == "\$freetext$$")
												continue;
												?>
												<input type='text' class='range_field' name='<?php echo $field_name_lower; ?>[]' value='<?php echo $slot_bounds[0]; ?>'></input>-<input type='text' class='range_field' name='<?php echo $field_name_upper; ?>[]' value='<?php echo $slot_bounds[1]; ?>'></input>&nbsp;&nbsp;&nbsp;
												<?php
											}
										}
									?>
									</span>
									<br>
									<a href="javascript:add_slot(<?php echo "'".$span_id."', '".$field_name_lower."', '".$field_name_upper."'"; ?>);"><?php echo LangUtil::$generalTerms['ADDANOTHER']; ?> &raquo;</a>
									<?php
									echo "<br><br>";
								}
							}
							if($measure_to_set === false)
							{
								echo "<small>".LangUtil::$pageTerms['RANGE_NOTREQD']."</small><br><br>";
							}
							?>
						</td>
					</tr>
					<?php
				}
				?>
				<tr valign='top'>
					<td></td>
					<td>
						<br>
						<input type='button' id='rsubmit' onclick='javascript:agg_checkandsubmit();' value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT'];?>'></input>
						&nbsp;&nbsp;&nbsp;
						<input type='button' id='rpreview' onclick='javascript:agg_preview();' value='<?php echo LangUtil::$generalTerms['PREVIEW']; ?>'></input>
						&nbsp;&nbsp;&nbsp;
						<small><a href="javascript:right_load(1, 'site_info_div');"><?php echo LangUtil::$generalTerms['CMD_CANCEL'];?></a></small>
						&nbsp;&nbsp;&nbsp;
						<span id='agg_progress_spinner' style='display:none'>
							<?php $this->getProgressSpinner(LangUtil::$generalTerms['CMD_SUBMITTING']); ?>
						</span>
					</td>
				</tr>
			</tbody>
		</table>
		</div>
		<?php
	}



	public function getInfectionReportConfigureForm()
	{
		# Returns HTML form elements for configuring infection reports
		# Called from lab_config_home.php

		# Fetch site-wide settings for all tests from dummy record
		$site_settings = GlobalInfectionReport::getByKeys($_SESSION['user_id'], 0, 0);
		?>
		<input type='hidden' name='user_id' value=<?php echo $_SESSION['user_id']; ?>></input>
		<div class='pretty_box' style='width:700px;'>
		<table cellspacing='5px'>
			<tbody>
				<tr valign='top'>
					<td><?php echo "Group By Gender"; //LangUtil::$pageTerms['GROUP_BYGENDER']; ?></td>
					<td>
						<input type='radio' id='rgender' name='rgender' value='y' <?php
						if($site_settings->groupByGender == 1)
							echo " checked ";
						?>><?php echo LangUtil::$generalTerms['YES']; ?></input>
						&nbsp;&nbsp;&nbsp;
						<input type='radio' id='rgender' name='rgender' value='n' <?php
						if($site_settings->groupByGender == 0)
							echo " checked ";
						?>><?php echo LangUtil::$generalTerms['NO']; ?></input>
					</td>
				</tr>
				<tr valign='top'>
					<td><?php echo "Group By Age"; //LangUtil::$pageTerms['GROUP_BYAGE']; ?></td>
					<td>
						<input type='radio' id='rage' name='rage' value='y'<?php
						if($site_settings->groupByAge == 1)
							echo " checked ";
						?>><?php echo LangUtil::$generalTerms['YES']; ?></input>
						&nbsp;&nbsp;&nbsp;
						<input type='radio' id='rage' name='rage' value='n'<?php
						if($site_settings->groupByAge == 0)
							echo " checked ";
						?>><?php echo LangUtil::$generalTerms['NO']; ?></input>
					</td>
				</tr>
				<tr valign='top' id='agegrouprow' <?php
						if($site_settings->groupByAge == 0)
							echo " style='display:none'; ";
						?>>
					<td><?php echo "Age Range"; //LangUtil::$pageTerms['RANGE_AGE']; ?> (<?php echo "Years"; //LangUtil::$generalTerms['YEARS']; ?>)</td>
					<td>
						<div id='agegrouplist'>
							<span id='agegrouplist_inner'>
							<?php
							if($site_settings->groupByAge == 0) {
								# Group by age not enabled. Show empty form fields
							?>
								<input type='text' name='age_l[]' class='range_field'></input>-<input type='text' name='age_u[]' class='range_field'></input>
							<?php
							}
							else
							{
								# Group by age enabled. Shoe prefilled form fields.
								$age_parts = explode(",", $site_settings->ageGroups);
								foreach($age_parts as $age_part)
								{
									if(trim($age_part) == "")
										continue;
									$age_bounds = explode(":", $age_part);
									?>
									<input type='text' name='age_l[]' class='range_field' value='<?php echo $age_bounds[0]; ?>'></input>-<input type='text' name='age_u[]' class='range_field' value='<?php echo $age_bounds[1]; ?>'></input>&nbsp;&nbsp;&nbsp;
									<?php
								}
							}
							?>
							</span>
							<br>
							<a href='javascript:agegrouplist_append();'><?php echo LangUtil::$generalTerms['ADDANOTHER']; ?> &raquo;</a>
						</div>
					</td>
				</tr>
				<?php
				# For each test with numeric range, show ranges
				$test_list = getTestTypesCountryLevel();
				foreach($test_list as $test_type)
				{
					?>
					<tr valign='top'>
						<td>
							<?php echo $test_type->getName(); ?>
							<input type='hidden' name='ttypes[]' value='<?php echo $test_type->testId; ?>'></input>
						</td>
						<td>
							<?php
							$measure_to_set = false;
							$measure_list = $test_type->getMeasures();
							?>
							<?php
							$measure_count = 0;
							foreach($measure_list as $measure)
							{
								$disease_report = GlobalInfectionReport::getByKeys($_SESSION['user_id'], $test_type->testId, $measure->measureId);
								$measure_count++;
								if(strpos($measure->range, "/") !== false)
								{
									# Alphanumeric options
									# Do nothing
									//$range_options = explode("/", $measure->range);
								}
								else
								{
									# Numeric ranges
									# Show fields to select range slots
									$measure_to_set = true;

									if(count($measure_list) != 1)
									{
										# Show measure names if more than one.
										echo $measure->getName()."&nbsp;&nbsp;&nbsp;";
									}
									$range_bounds = explode(":", $measure->range);
									$span_id = $test_type->testId."_".$measure_count;
									$field_name_upper = "slotu_".$test_type->testId."_".$measure->measureId;
									$field_name_lower = "slotl_".$test_type->testId."_".$measure->measureId;
									?>
									<span id='<?php echo $span_id; ?>'>
										<?php
										if($disease_report == null)
										{
											# No entry exists. Show default values.
											?>
											<input type='text' class='range_field' name='<?php echo $field_name_lower; ?>[]' value='<?php echo $range_bounds[0]; ?>'></input>-<input type='text' class='range_field' name='<?php echo $field_name_upper; ?>[]' value='<?php echo $range_bounds[1]; ?>'></input>
											<?php
										}
										else
										{
											# Entries exist. Prefill form with these values.
											$slot_list = explode(",", $disease_report->measureGroups);
											foreach($slot_list as $slot_part)
											{
												if(trim($slot_part) == "")
													continue;
												$slot_bounds = explode(":", $slot_part);
												?>
												<input type='text' class='range_field' name='<?php echo $field_name_lower; ?>[]' value='<?php echo $slot_bounds[0]; ?>'></input>-<input type='text' class='range_field' name='<?php echo $field_name_upper; ?>[]' value='<?php echo $slot_bounds[1]; ?>'></input>&nbsp;&nbsp;&nbsp;
												<?php
											}
										}
									?>
									</span>
									<br>
									<a href="javascript:add_slot(<?php echo "'".$span_id."', '".$field_name_lower."', '".$field_name_upper."'"; ?>);"><?php echo LangUtil::$generalTerms['ADDANOTHER']; ?> &raquo;</a>
									<?php
									echo "<br><br>";
								}
							}
							if($measure_to_set === false)
							{
								echo "<small>".LangUtil::$pageTerms['RANGE_NOTREQD']."</small><br><br>";
							}
							?>
						</td>
					</tr>
					<?php
				}
				?>
				<tr valign='top'>
					<td></td>
					<td>
						<br>
						<input type='button' id='rsubmit' onclick='javascript:agg_checkandsubmit();' value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT'];?>'></input>
						&nbsp;&nbsp;&nbsp;
						<input type='button' id='rpreview' onclick='javascript:agg_preview();' value='<?php echo LangUtil::$generalTerms['PREVIEW']; ?>'></input>
						&nbsp;&nbsp;&nbsp;
						<small><a href="javascript:toggleInfectionReportSettings();"><?php echo LangUtil::$generalTerms['CMD_CANCEL'];?></a></small>
						&nbsp;&nbsp;&nbsp;
						<span id='agg_progress_spinner' style='display:none'>
							<?php $this->getProgressSpinner(LangUtil::$generalTerms['CMD_SUBMITTING']); ?>
						</span>
					</td>
				</tr>
			</tbody>
		</table>
		</div>
		<?php
	}

	public function getAggregateReportSummary($lab_config)
	{
		# Returns HTML form elements for configuring infection report
		# Called from lab_config_home.php

		# Fetch site-wide settings for all tests from dummy record
		$site_settings = DiseaseReport::getByKeys($lab_config->id, 0, 0);
		if($site_settings == null)
		{
			# TODO:
			//$this->getNewAggregateReportConfigForm($lab_config);
		}
		?>
		<div class='pretty_box' style='width:700px;'>
		<table class='hor-minimalist-b'>
			<tbody>
				<tr valign='top'>
					<td><?php echo LangUtil::$pageTerms['GROUP_BYGENDER']; ?></td>
					<td>
						<?php
						if($site_settings->groupByGender == 1)
							echo LangUtil::$generalTerms['YES'];
						else
							echo LangUtil::$generalTerms['NO'];
						?>
					</td>
				</tr>
				<tr valign='top'>
					<td><?php echo LangUtil::$pageTerms['GROUP_BYAGE']; ?></td>
					<td>
						<?php
						if($site_settings->groupByAge == 1)
							echo LangUtil::$generalTerms['YES'];
						else
							echo LangUtil::$generalTerms['NO'];
						?>
					</td>
				</tr>
				<tr valign='top' <?php
						if($site_settings->groupByAge == 0)
							echo " style='display:none' ";
						?>>
					<td><?php echo LangUtil::$pageTerms['RANGE_AGE']; ?> (<?php echo LangUtil::$generalTerms['YEARS']; ?>)</td>
					<td>
						<?php
						# Group by age enabled
						$age_parts = explode(",", $site_settings->ageGroups);
						foreach($age_parts as $age_part)
						{
							if(trim($age_part) == "")
								continue;
							$age_bounds = explode(":", $age_part);
							echo $age_bounds[0]."-".$age_bounds[1];
							echo "&nbsp;&nbsp;&nbsp;";
						}

					?>
					</td>
				</tr>
				<?php
				# For each test with numeric range, show ranges
				$test_list = $lab_config->getTestTypes();
				foreach($test_list as $test_type)
				{
					?>
					<tr valign='top'>
						<td>
							<?php echo $test_type->getName(); ?>
						</td>
						<td>
							<?php
							$measure_to_set = false;
							$measure_list = $test_type->getMeasures();
							?>
							<?php
							$measure_count = 0;
							foreach($measure_list as $measure)
							{
								$disease_report = DiseaseReport::getByKeys($lab_config->id, $test_type->testTypeId, $measure->measureId);
								$measure_count++;
								if(strpos($measure->range, "/") !== false)
								{
									# Alphanumeric options
									# Do nothing
									//$range_options = explode("/", $measure->range);
								}
								else
								{
									# Numeric ranges
									# Show fields to select range slots
									$measure_to_set = true;

									if(count($measure_list) != 1)
									{
										# Show measure names if more than one.
                                                                            if($measure->checkIfSubmeasure() == 1)
                                                                            {
                                                                                $decName = $measure->truncateSubmeasureTag();
                                                                            }
                                                                            else
                                                                            {
                                                                                $decName = $measure->getName();
                                                                            }
										echo $decName."&nbsp;&nbsp;&nbsp;";
									}
									$range_bounds = explode(":", $measure->range);
									if($disease_report == null)
									{
										# No entry exists. Show default values.
										echo $range_bounds[0]."-".$range_bounds[1];
									}
									else
									{
										# Entries exist. Prefill form with these values.
										$slot_list = explode(",", $disease_report->measureGroups);
										foreach($slot_list as $slot_part)
										{
											if(trim($slot_part) == "")
												continue;
											$slot_bounds = explode(":", $slot_part);
                                                                                        if($slot_bounds[0] == "\$freetext$$")
                                                                                            continue;
											echo $slot_bounds[0]."-".$slot_bounds[1];
											echo "&nbsp;&nbsp;&nbsp;";
										}
									}
									echo "<br><br>";
								}
							}
							if($measure_to_set === false)
							{
								echo "<small>".LangUtil::$pageTerms['RANGE_NOTREQD']."</small><br><br>";
							}
							?>
						</td>
					</tr>
					<?php
				}
				?>
			</tbody>
		</table>
		</div>
		<?php
	}

	public function getInfectonReportSummary()
	{
		# Returns HTML form elements for configuring infection report for country administrators
		# Called from reports.php

		# Fetch settings for all tests from dummy record
		$site_settings = GlobalInfectionReport::getByKeys($_SESSION['user_id'], 0, 0);
		?>
		<div class='pretty_box' style='width:700px;'>
		<table class='hor-minimalist-b'>
			<tbody>
				<tr valign='top'>
					<td><?php echo "Group By Gender"; //LangUtil::$pageTerms['GROUP_BYGENDER']; ?></td>
					<td>
						<?php
						if($site_settings->groupByGender == 1)
							echo LangUtil::$generalTerms['YES'];
						else
							echo LangUtil::$generalTerms['NO'];
						?>
					</td>
				</tr>
				<tr valign='top'>
					<td><?php echo "Group By Age"; //LangUtil::$pageTerms['GROUP_BYAGE']; ?></td>
					<td>
						<?php
						if($site_settings->groupByAge == 1)
							echo LangUtil::$generalTerms['YES'];
						else
							echo LangUtil::$generalTerms['NO'];
						?>
					</td>
				</tr>
				<tr valign='top' <?php
						if($site_settings->groupByAge == 0)
							echo " style='display:none' ";
						?>>
					<td><?php echo "Age Range"; //LangUtil::$pageTerms['RANGE_AGE']; ?> (<?php echo "Years"; //LangUtil::$generalTerms['YEARS']; ?>)</td>
					<td>
						<?php
						# Group by age enabled
						$age_parts = explode(",", $site_settings->ageGroups);
						foreach($age_parts as $age_part)
						{
							if(trim($age_part) == "")
								continue;
							$age_bounds = explode(":", $age_part);
							echo $age_bounds[0]."-".$age_bounds[1];
							echo "&nbsp;&nbsp;&nbsp;";
						}

					?>
					</td>
				</tr>
				<?php
				# For each test with numeric range, show ranges
				$test_list = getTestTypesCountryLevel();
				foreach($test_list as $test_type)
				{
					?>
					<tr valign='top'>
						<td>
							<?php echo $test_type->getName(); ?>
						</td>
						<td>
							<?php
							$measure_to_set = false;
							$measure_list = $test_type->getMeasures();
							?>
							<?php
							$measure_count = 0;
							foreach($measure_list as $measure)
							{
								$disease_report = GlobalInfectionReport::getByKeys($_SESSION['user_id'], $test_type->testId, $measure->measureId);
								$measure_count++;
								if(strpos($measure->range, "/") !== false)
								{
									# Alphanumeric options
									# Do nothing
									//$range_options = explode("/", $measure->range);
								}
								else
								{
									# Numeric ranges
									# Show fields to select range slots
									$measure_to_set = true;

									if(count($measure_list) != 1)
									{
										# Show measure names if more than one.
										echo $measure->getName()."&nbsp;&nbsp;&nbsp;";
									}
									$range_bounds = explode(":", $measure->range);
									if($disease_report == null)
									{
										# No entry exists. Show default values.
										echo $range_bounds[0]."-".$range_bounds[1];
									}
									else
									{
										# Entries exist. Prefill form with these values.
										$slot_list = explode(",", $disease_report->measureGroups);
										foreach($slot_list as $slot_part)
										{
											if(trim($slot_part) == "")
												continue;
											$slot_bounds = explode(":", $slot_part);
											echo $slot_bounds[0]."-".$slot_bounds[1];
											echo "&nbsp;&nbsp;&nbsp;";
										}
									}
									echo "<br><br>";
								}
							}
							if($measure_to_set === false)
							{
								echo "<small>"."No range configuration required"./*LangUtil::$pageTerms['RANGE_NOTREQD'].*/"</small><br><br>";
							}
							?>
						</td>
					</tr>
					<?php
				}
				?>
			</tbody>
		</table>
		</div>
		<?php
	}

	public function getReportConfigForm($report_config, $worksheet_config=false, $test_type_id = 0)
	{
		# Creates html fields for report configuration form
		// $lab_config = LabConfig::getById($_SESSION['lab_config_id']);
		// echo $report_config->usePatientId, "hello";
		// echo "<br>";
		// $temp = $lab_config->getAllReportConfigs();
		// echo $report_config->reportId, "->", $report_config->testTypeId, "->",$report_config->usePatientId, "->", $report_config->headerText, "->",$report_config->useDailyNum;
		// echo "<br>";
		// echo "hihello";
		// echo "<br>";
		// foreach ($temp as $value)
		// {
		// 	echo $value['report_id'], "->", $value['test_type_id'], "->",$value['p_fields'], "->", $value['header'];
		// 	echo "<br>";
		// }
		?>
		<?php #echo $report_config->name."<br>"; ?>
		<form name='report_config_submit_form' id='report_config_submit_form' action='ajax/report_config_update.php' method='post'>
		<input type='hidden' name='location' value='<?php echo $report_config->labConfigId; ?>'></input>
		<input type='hidden' name='report_id' value='<?php echo $report_config->reportId; ?>'></input>
		<input type='hidden' name='t_type' value=<?php
		if($report_config->testTypeId == null)
		{
			echo $test_type_id;
		}
		else
		{
			echo $report_config->testTypeId;
		}
		?>>
		</input>
		<table cellspacing='5px' class='smaller_font'>
			<tr valign='top'>
			<td>Alignment</td>
			<td>
					<input type='radio' name='align' value='left' <?php echo " checked "; ?>>Left</input>
					<input type='radio' name='align' value='center' <?php
					if($report_config->alignment_header == 'center') echo " checked "; ?>>Center</input>
					<input type='radio' name='align' value='right' <?php
					if($report_config->alignment_header == 'right') echo " checked "; ?>>Right</input>
				</td>

			<tr valign='top'>
				<td>Header</td>
				<td>
					<input type='text' name='header' id='header' value='<?php echo $report_config->headerText; ?>' class='uniform_width_more'>
					</input>
				</td>
			</tr>
			<tr valign='top'>
				<td>Title</td>
				<td>
					<span id='title_lines'>
					<?php
					$title_list = explode("<br>", $report_config->titleText);
					foreach($title_list as $title_string)
					{
						?>
						<input type='text' name='title[]' value='<?php echo trim($title_string); ?>' class='uniform_width_more'>
						</input><br>
						<?php
					}
					?>
					</span>
					<small><a href='javascript:add_title_line();'><?php echo LangUtil::$generalTerms['ADDANOTHER']; ?> &raquo;</a></small>
				</td>
			</tr>
			<tr valign='top'>
				<td>Footer</td>
				<td>
					<input type='text' name='footer' id='footer' value='<?php echo $report_config->footerText; ?>' class='uniform_width_more'>
					</input>
				</td>
			</tr>
			<tr valign='top'>
				<td>Designation</td>
				<td>
					<input type='text' name='designation' id='designation' value='<?php echo $report_config->designation; ?>' class='uniform_width_more'>
					</input>
				</td>
			</tr>
			<tr valign='top'>
				<td><?php echo LangUtil::$pageTerms['MARGINS']; ?> (%)</td>
				<td>
					<?php echo LangUtil::$pageTerms['TOP'];?>
					&nbsp;
					<input type='text' name='margin_top' id='margin_top' value='<?php echo $report_config->margins[ReportConfig::$TOP]; ?>' size='2'></input>
					&nbsp;&nbsp;&nbsp;
					<?php echo LangUtil::$pageTerms['BOTTOM'];?>
					&nbsp;
					<input type='text' name='margin_bottom' id='margin_bottom' value='<?php echo $report_config->margins[ReportConfig::$BOTTOM]; ?>' size='2'></input>
					&nbsp;&nbsp;&nbsp;
					<?php echo LangUtil::$pageTerms['LEFT'];?>
					&nbsp;
					<input type='text' name='margin_left' id='margin_left' value='<?php echo $report_config->margins[ReportConfig::$LEFT]; ?>' size='2'></input>
					&nbsp;&nbsp;&nbsp;
					<?php echo LangUtil::$pageTerms['RIGHT'];?>
					&nbsp;
					<input type='text' name='margin_right' id='margin_right' value='<?php echo $report_config->margins[ReportConfig::$RIGHT]; ?>' size='2'></input>
				</td>
			</tr>
			<tr valign='top'>
				<td><?php echo LangUtil::$generalTerms['LANDSCAPE']; ?></td>
				<td>
					<input type='radio' name='do_landscape' value='Y' <?php
					if($report_config->landscape == true) echo " checked "; ?>><?php echo LangUtil::$generalTerms['YES']; ?></input>
					<input type='radio' name='do_landscape' value='N' <?php
					if($report_config->landscape == false) echo " checked "; ?>><?php echo LangUtil::$generalTerms['NO']; ?></input>
				</td>

			</tr>
			<tr valign='top'>
				<td>Clinical Data</td>
				<td>
					<input type='radio' name='Clinical_Data' value='Y' <?php
					if($report_config->useClinicalData == 1) echo " checked "; ?>><?php echo LangUtil::$generalTerms['YES']; ?></input>
					<input type='radio' name='Clinical_Data' value='N' <?php
					if($report_config->useClinicalData == 0) echo " checked "; ?>><?php echo LangUtil::$generalTerms['NO']; ?></input>
				</td>
			</tr>
<!--             <tr>
            <td><?php echo LangUtil::$pageTerms['RPT_ITEMS_ON_ROW']; ?></td>
            <td><input type="text" id="row_items" name="row_items" value="<?php echo $report_config->rowItems;?>" size="2" /></td>
            </tr> -->
             <!-- <tr>
            <td><?php echo LangUtil::$pageTerms['RPT_SHOW_DEMO_BORDER']; ?></td>
            <td>
            	<input type='radio' name='show_border' value='Y' <?php
					if($report_config->showBorder == 1) echo " checked "; ?>><?php echo LangUtil::$generalTerms['YES']; ?></input>
					<input type='radio' name='show_border' value='N' <?php
					if($report_config->showBorder == 0) echo " checked "; ?>><?php echo LangUtil::$generalTerms['NO']; ?></input>
              </td>
            </tr> -->
            <tr>
            <td><?php echo LangUtil::$pageTerms['RPT_SHOW_SPM_BORDER'] ?></td>
            <td><input type='radio' name='show_rborder' value='Y' <?php
					if($report_config->showResultBorder == 1) echo " checked "; ?> onclick="javascript:$('#R_Border').show();"><?php echo LangUtil::$generalTerms['YES']; ?></input>
					<input type='radio' name='show_rborder' value='N' <?php
					if($report_config->showResultBorder == 0) echo " checked "; ?> onclick="javascript:$('#R_Border').hide();"><?php echo LangUtil::$generalTerms['NO']; ?></input>
                    &nbsp;&nbsp;&nbsp;&nbsp;<span id="R_Border">
                   <input type="checkbox" name="result_box_hori" value="Y" <?php if($report_config->resultborderHorizontal == 1) echo " checked "; ?> ><?php echo  LangUtil::$pageTerms['RPT_R_BORDER_HOR'];?>&nbsp;
                    <input type="checkbox" name="result_box_vert"  value="Y"  <?php if($report_config->resultborderVertical == 1) echo " checked "; ?>  ><?php echo LangUtil::$pageTerms['RPT_R_BORDER_VERT'];?>
                    </span>
                    </td>
            </tr>
			<?php if($report_config->reportId==1){?>
			<tr><td><h4><?php $name="../logos/logo_".$lab_config_id.".jpg";
			 if (file_exists("../logos/logo_".$report_config->labConfigId.".jpg")==true)
			echo "LOGO being Used "; ?></h4></td></tr>
	  		<tr><td><h3>File Upload:</h3></td><td><?php

	 if (file_exists("../logos/logo_".$report_config->labConfigId.".jpg")==false)
	{echo "( Add a Logo)"; }else echo "(Change Logo)"; ?>
	Choose a .jpg logo File to upload:
	<input type="file" name="file" >
	</>
	<br />
	</td></tr> <?php }?>
	<br/>


		</table>
		<table cellspacing='5px' class='smaller_font'>
			<tr valign='top'>
				<td><b><?php echo LangUtil::$generalTerms['PATIENTS']?></b></td>
				<td></td>
			</tr>
			<?php # Patient main fields ?>
			<tr valign='top'>
				<td>
					<input type='checkbox' name='p_field_0' <?php
						if($report_config->usePatientId == 1)
							echo " checked ";
						?>>
					</input>
					<?php echo LangUtil::$generalTerms['PATIENT_ID']; ?>
				</td>
				<td></td>
			</tr>
			<tr valign='top'>
				<td>
					<input type='checkbox' name='p_field_9' <?php
						if($report_config->usePatientBarcode == 1)
							echo " checked ";
						?>>
					</input>
					<?php echo LangUtil::$generalTerms['PATIENT_BARCODE']; ?>
				</td>
				<td></td>
			</tr>
			<tr valign='top'>
				<td>
					<input type='checkbox' name='p_field_10' <?php
						if($report_config->usePatientSignature == 1)
							echo " checked ";
						?>>
					</input>
					<?php echo LangUtil::$generalTerms['PATIENT_SIGNATURE']; ?>
				</td>
				<td></td>
			</tr>
			<tr valign='top'>
				<td>
					<input type='checkbox' name='p_field_1' <?php
						if($report_config->useDailyNum == 1)
							echo " checked ";
						?>>
					</input>
					<?php echo LangUtil::$generalTerms['PATIENT_DAILYNUM']; ?>
				</td>
				<td></td>
			</tr>
			<tr valign='top'>
				<td>
					<input type='checkbox' name='p_field_2' <?php
						if($report_config->usePatientAddlId == 1)
							echo " checked ";
						?>>
					</input><?php echo LangUtil::$generalTerms['ADDL_ID']; ?>
				</td>
				<td></td>
			</tr>
			<tr valign='top'>
				<td>
					<input type='checkbox' name='p_field_3' <?php
						if($report_config->useGender == 1)
							echo " checked ";
						?>>
					</input>
					<?php echo LangUtil::$generalTerms['GENDER']; ?>
				</td>
				<td></td>
			</tr>
			<tr valign='top'>
				<td>
					<input type='checkbox' name='p_field_4' <?php
						if($report_config->useAge == 1)
							echo " checked ";
						?>>
					</input>
					<?php echo LangUtil::$generalTerms['AGE']; ?>
				</td>
				<td></td>
			</tr>
			<tr valign='top'>
				<td>
				<input type='checkbox' name='p_field_5' <?php
						if($report_config->useDob == 1)
							echo " checked ";
						?>>
					</input>
					<?php echo LangUtil::$generalTerms['DOB']; ?>
				</td>
				<td></td>
			</tr>
			<tr valign='top'>
				<td>
					<input type='checkbox' name='p_field_6' <?php
						if($report_config->usePatientName == 1)
							echo " checked ";
						?>>
					</input>
					<?php echo LangUtil::$generalTerms['NAME']; ?>
				</td>
				<td></td>
			</tr>
			<tr valign='top'>
				<td>
					<input type='checkbox' name='p_field_7' <?php
						if($report_config->useTest == 1)
							echo " checked ";
						?>>
					</input>
					<?php echo LangUtil::$generalTerms['TEST']; ?>
				</td>
				<td></td>
			</tr>
			<tr valign='top'>
				<td>
					<input type='checkbox' name='p_field_8' <?php
						if($report_config->usePatientRegistrationDate == 1)
							echo " checked ";
						?>>
					</input>
					<?php echo "Registration Date"; ?>
				</td>
				<td></td>
			</tr>
			<tr valign='top'>
				<td>
					<input type='checkbox' name='p_field_13' <?php
						if($report_config->useViewPatientReport == 1)
							echo " checked ";
						?>>
					</input>
					<?php echo LangUtil::$generalTerms['VIEW_REPORT']; ?>
				</td>
				<td></td>
			</tr>
			<?php
			# Patient custom fields
			$lab_config = LabConfig::getById($report_config->labConfigId);
			if( $lab_config ) {
				$custom_field_list = $lab_config->getPatientCustomFields();
				foreach($custom_field_list as $custom_field)
				{
					?>
					<tr valign='top'>
						<td>
							<input type='checkbox' name='p_custom_<?php echo $custom_field->id; ?>' <?php
								if(in_array($custom_field->id, $report_config->patientCustomFields))
									echo " checked ";
								?>>
							</input>
							<?php echo $custom_field->fieldName; ?>
						</td>
					</tr>
				<?php
				}
			}
			?>

			<tr valign='top'<?php
			if($report_config->reportId != 6)
				echo " style='display:none;' ";
			?>>
				<td><b>Patient Daily Report - Other Fields</b></td>
			</tr>

			<tr valign='top'>
				<td>
				<?php if($report_config->reportId == 6){?>
					<input type='checkbox' name='p_field_11' <?php
						if($report_config->useRequesterName == 1)
							echo " checked ";
						?>>
					</input>
							<?php echo "Requester Name"; }?>
				</td>
				<td></td>
			<!--<?php echo $report_config->reportId. " | Requester ".$report_config->useRequesterName." | ReferredTo ".$report_config->useReferredTo ?>-->
			</tr>

			<tr valign='top'<?php
			if($report_config->reportId != 4)
				echo " style='display:none;' ";
			?>>
				<td><b>Specimen Daily Report - Other Fields</b></td>
			</tr>
			<tr valign='top'>
				<td>
				<?php if($report_config->reportId == 4){?>
					<input type='checkbox' name='p_field_12' <?php
						if($report_config->useReferredToHospital == 1)
							echo " checked ";
						?>>
					</input>
							<?php echo "Referred From "; }?>
				</td>
				<td></td>
			<!--<?php echo $report_config->reportId. " | Requester ".$report_config->useRequesterName." | ReferredTo ".$report_config->useReferredTo ?>-->
			</tr>

			<tr valign='top'<?php
			if($report_config->reportId == 6)
				echo " style='display:none;' ";
			?>>
				<td><b><?php echo LangUtil::$generalTerms['SPECIMENS']?></b></td>
			</tr>
			<?php # Specimen main fields ?>
			<tr valign='top'<?php
			//if($report_config->reportId == 6)
			if(true)
			# specimen_id as DB internal key: Hide this section
			# For the user "specimen ID" is now stored in aux_id field
				echo " style='display:none;' ";
			?>>
				<td>
					<input type='checkbox' name='s_field_0' <?php
						//if($report_config->useSpecimenId == 1)
						if(true)
							echo " checked ";
						?>>
					</input>
					<?php echo LangUtil::$generalTerms['SPECIMEN_ID']; ?>
				</td>
			</tr>
			<tr valign='top'<?php
			if($report_config->reportId == 6)
				echo " style='display:none;' ";
			?>>
				<td>
					<input type='checkbox' name='s_field_1' <?php
						if($report_config->useSpecimenAddlId == 1)
							echo " checked ";
						?>>
					</input>
					<?php
					# For the user "specimen ID" is now stored in aux_id field
					echo LangUtil::$generalTerms['SPECIMEN_ID'];
					?>
				</td>
			</tr>
			<tr valign='top'<?php
			if($report_config->reportId == 6)
				echo " style='display:none;' ";
			?>>
				<td>
					<input type='checkbox' name='s_field_5' <?php
						if($report_config->useSpecimenName == 1)
							echo " checked ";
						?>>
					</input>
					<?php echo LangUtil::$generalTerms['SPECIMEN_TYPE']; ?>
				</td>

			</tr>
			<tr valign='top'<?php
			if($report_config->reportId == 6)
				echo " style='display:none;' ";
			?>>
				<td>
					<input type='checkbox' name='s_field_2' <?php
						if($report_config->useDateRecvd == 1)
							echo " checked ";
						?>>
					</input>
					<?php echo LangUtil::$generalTerms['R_DATE']; ?>
				</td>

			</tr>
			<tr valign='top'<?php
			if($report_config->reportId == 6)
				echo " style='display:none;' ";
			?>>
				<td>
					<input type='checkbox' name='s_field_3' <?php
						if($report_config->useComments == 1)
							echo " checked ";
						?>>
					</input>
					<?php echo LangUtil::$generalTerms['COMMENTS']; ?>
				</td>

			</tr>
			<tr valign='top'<?php
			if($report_config->reportId == 6)
				echo " style='display:none;' ";
			?>>
				<td>
					<input type='checkbox' name='s_field_4' <?php
						if($report_config->useReferredTo == 1)
							echo " checked ";
						?>>
					</input>
					<?php echo "Referred To";//LangUtil::$generalTerms['REF_OUT']; ?>
				</td>

			</tr>
			<tr valign='top'<?php
			if($report_config->reportId == 6)
				echo " style='display:none;' ";
			?>>
				<td>
					<input type='checkbox' name='s_field_6' <?php
						if($report_config->useDoctor == 1)
							echo " checked ";
						?>>
					</input>
					<?php echo LangUtil::$generalTerms['DOCTOR']; ?>
				</td>

			</tr>
			<?php
			# Specimen custom fields
			$lab_config = LabConfig::getById($report_config->labConfigId);
			if( $lab_config ) {
				$custom_field_list = $lab_config->getSpecimenCustomFields();
				foreach($custom_field_list as $custom_field)
				{
					?>
					<tr valign='top'<?php

				if($report_config->reportId == 6)
					echo " style='display:none;' ";
				?>>
						<td>
							<input type='checkbox' name='s_custom_<?php echo $custom_field->id; ?>' <?php
								if(in_array($custom_field->id, $report_config->specimenCustomFields))
									echo " checked ";
								?>>
							</input>
							<?php echo $custom_field->fieldName; ?>
						</td>

					</tr>
				<?php
				}
			}
			?>

			<tr valign='top'<?php
			if($report_config->reportId == 6 || $report_config->reportId == 2)
				echo " style='display:none;' ";
			?>>
				<td><b><?php echo LangUtil::$generalTerms['TESTS']?></b></td>

			</tr>


			<?php # Test main fields ?>
			<tr valign='top'<?php
			if($report_config->reportId == 6 || $report_config->reportId == 2)
				echo " style='display:none;' ";
			?>>
				<td>
					<input type='checkbox' name='t_field_7' <?php
						if($report_config->useTestName == 1)
							echo " checked ";
						?>>
					</input>
					<?php echo LangUtil::$generalTerms['TEST_TYPE']; ?>
				</td>
			</tr>
			<tr valign='top'<?php
			if($report_config->reportId == 6 || $report_config->reportId == 2)
				echo " style='display:none;' ";
			?>>
				<td>
					<input type='checkbox' name='t_field_8' <?php
						if($report_config->useMeasures == 1)
							echo " checked ";
						?>>
					</input>
					<?php echo LangUtil::$generalTerms['MEASURES']; ?>
				</td>
			</tr>
			<tr valign='top'<?php
			if($report_config->reportId == 6 || $report_config->reportId == 2)
				echo " style='display:none;' ";
			?>>
				<td>
					<input type='checkbox' name='t_field_0' <?php
						if($report_config->useResults == 1)
							echo " checked ";
						?>>
					</input>
					<?php echo LangUtil::$generalTerms['RESULTS']; ?>
				</td>
			</tr>
			<tr valign='top'<?php
			if($report_config->reportId == 6 || $report_config->reportId == 2)
			//if(true)
				echo " style='display:none;' ";
			?>>
				<td>
					<input type='checkbox' name='t_field_1' <?php
						if($report_config->useRange == 1)
							echo " checked ";
						?>>
					</input>
					<?php echo LangUtil::$generalTerms['RANGE']; ?></td>

			</tr>
			<tr valign='top'<?php
			if($report_config->reportId == 6 || $report_config->reportId == 2)
				echo " style='display:none;' ";
			?>>
				<td>
					<input type='checkbox' name='t_field_2' <?php
						if($report_config->useRemarks == 1)
							echo " checked ";
						?>>
					</input>
					<?php echo LangUtil::$generalTerms['RESULT_COMMENTS']; ?>
				</td>

			</tr>
			<tr valign='top'<?php
			if($report_config->reportId == 6 || $report_config->reportId == 2)
				echo " style='display:none;' ";
			?>>
				<td>
					<input type='checkbox' name='t_field_3' <?php
						if($report_config->useEntryDate == 1)
							echo " checked ";
						?>>
					</input>
					<?php echo LangUtil::$generalTerms['E_DATE']; ?>
				</td>

			</tr>
			<tr valign='top'<?php
			if($report_config->reportId == 6 || $report_config->reportId == 2)
				echo " style='display:none;' ";
			?>>
				<td>
					<input type='checkbox' name='t_field_4' <?php
						if($report_config->useEnteredBy == 1)
							echo " checked ";
						?>>
					</input>
					<?php echo LangUtil::$generalTerms['ENTERED_BY']; ?>
				</td>

			</tr>
			<tr valign='top'<?php
			if($report_config->reportId == 6 || $report_config->reportId == 2)
				echo " style='display:none;' ";
			?>>
				<td>
					<input type='checkbox' name='t_field_5' <?php
						if($report_config->useVerifiedBy == 1)
							echo " checked ";
						?>>
					</input>
					<?php echo LangUtil::$generalTerms['VERIFIED_BY']; ?>
				</td>

			</tr>
			<tr valign='top'<?php
			if($report_config->reportId == 6 || $report_config->reportId == 2)
				echo " style='display:none;' ";

			?>>
				<td>
					<input type='checkbox' name='t_field_6' <?php
						if($report_config->useStatus == 1)
							echo " checked ";
						?>>
					</input>
					<?php echo LangUtil::$generalTerms['SP_STATUS']; ?>
				</td>

			</tr>
			<tr valign='top'<?php
			if($report_config->reportId == 6 || $report_config->reportId == 2)
				echo " style='display:none;' ";
			?>>
				<td>
					<input type='checkbox' name='t_field_10' <?php
						if($report_config->usePrintConfirm == 1)
							echo " checked ";
						?>>
					</input>
					<?php echo "Confirm before print" ?>
				</td>

			</tr>
			<tr valign='top'<?php
			if($report_config->reportId == 6 || $report_config->reportId == 2)
				echo " style='display:none;' ";
			?>>
				<td>
					<input type='checkbox' name='t_field_11' <?php
						if($report_config->useResultConfirm == 1)
							echo " checked ";
						?>>
					</input>
					<?php echo "Confirm before updating results" ?>
				</td>

			</tr>
		</table>
		<table>
			<tr valign='top'>

				<td>
					<input type='button' value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>' onclick="<?php
					if($worksheet_config === false)
						echo "javascript:update_report_config();";
					else
						echo "javascript:update_worksheet_config();";
					?>"></input>
					&nbsp;&nbsp;&nbsp;
					<a href="<?php
					if($worksheet_config === false)
						echo "javascript:hide_report_config();";
					else
						echo "javascript:hide_worksheet_config();";
					?>">
					<?php echo LangUtil::$generalTerms['CMD_CANCEL']; ?>
					</a>
					&nbsp;&nbsp;&nbsp;
					<span id='<?php
					if($worksheet_config === false)
						echo "submit_report_config_progress";
					else
						echo "submit_worksheet_config_progress";
					?>' style='display:none;'>
						<?php $this->getProgressSpinner(LangUtil::$generalTerms['CMD_SUBMITTING']); ?>
					</span>
				</td>
			</tr>
			<tr valign='top'>
				<td></td>
				<td>

				</td>
			</tr>

		</table>
		</form>
		<?php
	}

	public function getReportConfigSummary($report_config, $worksheet_config=false)
	{
		if($report_config == null)
		{
			?>
			<div class='sidetip_nopos'>
				<?php echo LangUtil::$generalTerms['ERROR'].": ".LangUtil::$generalTerms['MSG_NOTFOUND']; ?>
			</div>
			<?php
			return;
		}
		?>
		<table class='hor-minimalist-b'>
			<tbody>
			<tr valign='top'>
				<td>Header</td>
				<td><?php echo $report_config->headerText; ?></td>
			</tr>
			<tr valign='top'>
				<td>Title</td>
				<td><?php echo $report_config->titleText; ?></td>
			</tr>
			<tr valign='top'>
				<td>Footer</td>
				<td>
					<?php echo $report_config->footerText; ?>
				</td>
			</tr>
			<tr valign='top'>
				<td>Designation</td>
				<td>
					<?php echo $report_config->designation ?>
				</td>
			</tr>
			<tr valign='top'>
				<td><?php echo LangUtil::$pageTerms['MARGINS']; ?> (%)</td>
				<td>
					<?php echo LangUtil::$pageTerms['TOP'];?>
					&nbsp;
					<?php echo $report_config->margins[ReportConfig::$TOP]; ?>
					&nbsp;&nbsp;&nbsp;
					<?php echo LangUtil::$pageTerms['BOTTOM'];?>
					&nbsp;
					<?php echo $report_config->margins[ReportConfig::$BOTTOM]; ?>
					&nbsp;&nbsp;&nbsp;
					<?php echo LangUtil::$pageTerms['LEFT'];?>
					&nbsp;
					<?php echo $report_config->margins[ReportConfig::$LEFT]; ?>
					&nbsp;&nbsp;&nbsp;
					<?php echo LangUtil::$pageTerms['RIGHT'];?>
					&nbsp;
					<?php echo $report_config->margins[ReportConfig::$RIGHT]; ?>
				</td>
			</tr>
			<tr valign='top'>
				<td><?php echo LangUtil::$generalTerms['LANDSCAPE']; ?></td>
				<td>
					<?php
					if($report_config->landscape == true)
						echo LangUtil::$generalTerms['YES'];
					else
						echo LangUtil::$generalTerms['NO'];
					?>
				</td>
			</tr>
			<tr valign='top'>
				<td>Clinical Data</td>
				<td>
					<?php
					if($report_config->useClinicalData == 1)
						echo LangUtil::$generalTerms['YES'];
					else
						echo LangUtil::$generalTerms['NO'];
					?>
				</td>
			</tr>
            <tr valign='top'>
				<td><?php  echo LangUtil::$pageTerms['RPT_ITEMS_ON_ROW'];?></td>
				<td>
					<?php
					echo $report_config->rowItems;
					?>
				</td>
			</tr>
            <tr valign='top'>
				<td><?php  echo LangUtil::$pageTerms['RPT_SHOW_DEMO_BORDER'];?></td>
				<td>
					<?php
					if($report_config->showBorder == 1)
						echo LangUtil::$generalTerms['YES'];
					else
						echo LangUtil::$generalTerms['NO'];
					?>
				</td>
			</tr>
             <tr valign='top'>
				<td><?php  echo LangUtil::$pageTerms['RPT_SHOW_SPM_BORDER'];?></td>
				<td>
					<?php
					if($report_config->showResultBorder == 1)
						echo LangUtil::$generalTerms['YES'];
					else
						echo LangUtil::$generalTerms['NO'];
						?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <?php
						echo  LangUtil::$pageTerms['RPT_R_BORDER_VERT'];
						if( $report_config->resultborderVertical == 1)
							echo ": ".LangUtil::$generalTerms['YES'];
						else
							echo ": ".LangUtil::$generalTerms['NO'];
					?>
                    &nbsp;&nbsp;
                     <?php
						echo  LangUtil::$pageTerms['RPT_R_BORDER_HOR'];
						if( $report_config->resultborderHorizontal == 1)
							echo ": ".LangUtil::$generalTerms['YES'];
						else
							echo ": ".LangUtil::$generalTerms['NO'];
					?>
				</td>
			</tr>
		</table>
		<table cellspacing='5px' class='smaller_font'>
			<tr valign='top'>
				<td><b><?php echo LangUtil::$generalTerms['PATIENTS']?></b></td>
				<td></td>
			</tr>
			<?php # Patient main fields ?>
			<tr valign='top'>
				<?php
				if($report_config->usePatientId == 1)
				{
					echo "<td>";
					echo LangUtil::$generalTerms['PATIENT_ID'];
					echo "</td>";
				}
				?>
			</tr>
			<tr valign='top'>
				<?php
				if($report_config->usePatientBarcode == 1)
				{
					echo "<td>";
					echo LangUtil::$generalTerms['PATIENT_BARCODE'];
					echo "</td>";
				}
				?>
			</tr>
			<tr valign='top'>
				<?php
				if($report_config->usePatientSignature == 1)
				{
					echo "<td>";
					echo LangUtil::$generalTerms['PATIENT_SIGNATURE'];
					echo "</td>";
				}
				?>
			</tr>
			<tr valign='top'>
				<?php
				if($report_config->useDailyNum == 1)
				{
					echo "<td>";
					echo LangUtil::$generalTerms['PATIENT_DAILYNUM'];
					echo "</td>";
				}
				?>
			</tr>
			<tr valign='top'>
				<?php
				if($report_config->usePatientAddlId == 1)
				{
					echo "<td>";
					echo LangUtil::$generalTerms['ADDL_ID'];
					echo "</td>";
				}
				?>
			</tr>
			<tr valign='top'>
				<td>
					<?php
					if($report_config->useGender == 1)
						echo LangUtil::$generalTerms['GENDER'];
					?>
				</td>
			</tr>
			<tr valign='top'>
				<td>
					<?php
					if($report_config->useAge == 1)
						echo LangUtil::$generalTerms['AGE'];
					?>
				</td>
			</tr>
			<tr valign='top'>
				<td>
					<?php
					if($report_config->useDob == 1)
						echo LangUtil::$generalTerms['DOB'];
					?>
				</td>
			</tr>
			<tr valign='top'>
				<td>
					<?php
					if($report_config->usePatientName == 1)
						echo LangUtil::$generalTerms['NAME'];
					?>
				</td>
			</tr>
			<tr valign='top'>
				<td>
					<?php
					if($report_config->useTest == 1)
						echo LangUtil::$generalTerms['TEST'];
					?>
				</td>
			</tr>
			<tr valign='top'>
				<td>
					<?php
					if($report_config->usePatientRegistrationDate == 1)
						echo "Registration Date";
					?>
				</td>
			</tr>
			<?php
			# Patient custom fields
			$lab_config = LabConfig::getById($report_config->labConfigId);
			$custom_field_list = $lab_config->getPatientCustomFields();
			foreach($custom_field_list as $custom_field)
			{
				?>
				<tr valign='top'>
					<td>
						<?php
						if(in_array($custom_field->id, $report_config->patientCustomFields))
							echo $custom_field->fieldName;
						?>
					</td>
				</tr>
			<?php
			}
			?> <br/>


			<?php
			if($report_config->reportId == 4 || $report_config->reportId == 6){
			 if($report_config->useRequesterName == 1 || $report_config->useReferredToHospital == 1) {
			?>
			<tr valign='top'>
				<td><b><?php echo "Other Fields"?></b></td>
				<td></td>
			</tr>
			<?php }?>


			<tr valign='top'>
				<td>
					<?php
					if($report_config->useRequesterName == 1)
						echo "Requester Name";
					?>
				</td>
			</tr>
			<tr valign='top'>
				<td>
					<?php
					if($report_config->useReferredToHospital == 1)
						echo "Referrer To Hospital Name";
					?>
				</td>
			</tr>
			<?php }?>

				<br/>

			<tr valign='top'<?php
			if($report_config->reportId == 6)
				echo " style='display:none;' ";
			?>>
				<td><b><?php echo LangUtil::$generalTerms['SPECIMENS']?></b></td>
			</tr>
			<?php # Specimen main fields ?>
			<tr valign='top'<?php
			if($report_config->reportId == 6)
				echo " style='display:none;' ";
			?>>
				<td>
					<?php
					if($report_config->useSpecimenAddlId == 1)
						# For the user "specimen ID" is now stored in aux_id field
						echo LangUtil::$generalTerms['SPECIMEN_ID'];
					?>
				</td>
			</tr>
			<tr valign='top'<?php
			if($report_config->reportId == 6)
				echo " style='display:none;' ";
			?>>
				<td>
					<?php
					if($report_config->useSpecimenName == 1)
						echo LangUtil::$generalTerms['SPECIMEN_TYPE'];
					?>
				</td>
			</tr>
			<tr valign='top'<?php
			if($report_config->reportId == 6)
				echo " style='display:none;' ";
			?>>
				<td>
					<?php
					if($report_config->useDateRecvd == 1)
						echo LangUtil::$generalTerms['R_DATE'];
					?>
				</td>

			</tr>
			<tr valign='top'<?php
			if($report_config->reportId == 6)
				echo " style='display:none;' ";
			?>>
				<td>
					<?php
					if($report_config->useComments == 1)
						echo LangUtil::$generalTerms['COMMENTS'];
					?>
				</td>
			</tr>
			<tr valign='top'<?php
			if($report_config->reportId == 6)
				echo " style='display:none;' ";
			?>>
				<td>
					<?php
					if($report_config->useReferredTo == 1)
						echo LangUtil::$generalTerms['REF_OUT'];
					?>
				</td>

			</tr>
			<tr valign='top'<?php
			if($report_config->reportId == 7)
				echo " style='display:none;' ";
			?>>
				<td>
					<?php
					if($report_config->useDoctor == 1)
						echo LangUtil::$generalTerms['DOCTOR'];
					?>
				</td>

			</tr>
			<?php
			# Specimen custom fields
			$lab_config = LabConfig::getById($report_config->labConfigId);
			$custom_field_list = $lab_config->getSpecimenCustomFields();
			foreach($custom_field_list as $custom_field)
			{
				?>
				<tr valign='top'<?php
			if($report_config->reportId == 6)
				echo " style='display:none;' ";
			?>>
					<td>
						<?php
						if(in_array($custom_field->id, $report_config->specimenCustomFields))
							echo $custom_field->fieldName;
						?>
					</td>
				</tr>
			<?php
			}
			?>

			<tr valign='top'<?php
			if($report_config->reportId == 6 || $report_config->reportId == 2)
				echo " style='display:none;' ";
			?>>
				<td><b><?php echo LangUtil::$generalTerms['TESTS']?></b></td>

			</tr>
			<?php # Test main fields ?>
			<tr valign='top'<?php
			if($report_config->reportId == 6 || $report_config->reportId == 2)
				echo " style='display:none;' ";
			?>>
				<td>
					<?php
					if($report_config->useTestName == 1)
						echo LangUtil::$generalTerms['TEST_TYPE'];
					?>
				</td>
			</tr>
			<tr valign='top'<?php
			if($report_config->reportId == 6 || $report_config->reportId == 2)
				echo " style='display:none;' ";
			?>>
				<td>
					<?php
					if($report_config->useMeasures == 1)
						echo LangUtil::$generalTerms['MEASURES'];
					?>
				</td>
			</tr>
			<tr valign='top'<?php
			if($report_config->reportId == 6 || $report_config->reportId == 2)
				echo " style='display:none;' ";
			?>>
				<td>
					<?php
					if($report_config->useResults == 1)
						echo LangUtil::$generalTerms['RESULTS'];
					?>
				</td>
			</tr>
			<tr valign='top'<?php
			if($report_config->reportId == 6 || $report_config->reportId == 2)
			//if(true)
				echo " style='display:none;' ";
			?>>
				<td>
					<?php
						if($report_config->useRange == 1)
							echo LangUtil::$generalTerms['RANGE'];
					?>
				</td>
			</tr>
			<tr valign='top'<?php
			if($report_config->reportId == 6 || $report_config->reportId == 2)
				echo " style='display:none;' ";
			?>>
				<td>
					<?php
					if($report_config->useRemarks == 1)
						echo LangUtil::$generalTerms['RESULT_COMMENTS'];
					?>
				</td>
			</tr>
			<tr valign='top'<?php
			if($report_config->reportId == 6 || $report_config->reportId == 2)
				echo " style='display:none;' ";
			?>>
				<td>
					<?php
					if($report_config->useEntryDate == 1)
						echo LangUtil::$generalTerms['E_DATE'];
					?>
				</td>

			</tr>
			<tr valign='top'<?php
			if($report_config->reportId == 6 || $report_config->reportId == 2)
				echo " style='display:none;' ";
			?>>
				<td>
					<?php
					if($report_config->useEnteredBy == 1)
						echo LangUtil::$generalTerms['ENTERED_BY'];
					?>
				</td>
			</tr>
			<tr valign='top'<?php
			if($report_config->reportId == 6 || $report_config->reportId == 2)
				echo " style='display:none;' ";
			?>>
				<td>
					<?php
					if($report_config->useVerifiedBy == 1)
						echo LangUtil::$generalTerms['VERIFIED_BY'];
					?>
				</td>

			</tr>
			<tr valign='top'<?php
			if($report_config->reportId == 6 || $report_config->reportId == 2)
				echo " style='display:none;' ";

			?>>
				<td>
					<?php
					if($report_config->useStatus == 1)
						echo LangUtil::$generalTerms['SP_STATUS'];
					?>
				</td>

			</tr>
			<tr valign='top'<?php
			if($report_config->reportId == 6 || $report_config->reportId == 2)
				echo " style='display:none;' ";
			?>>
				<td>
					<?php
					if($report_config->usePrintConfirm == 1)
						echo 'Confirm before print';
					?>
				</td>

			</tr>
			<tr valign='top'<?php
			if($report_config->reportId == 6 || $report_config->reportId == 2)
				echo " style='display:none;' ";
			?>>
				<td>
					<?php
					if($report_config->useResultConfirm == 1)
						echo 'Confirm before updating results';
					?>
				</td>

			</tr>
			</tbody>
		</table>
		<?php
	}

	public function getReportConfigCss($margin_list, $left_margin_line=true)
	{
		?>
		#report_config_content {
			padding-left: 10px;
			margin-top:<?php echo $margin_list[ReportConfig::$TOP]; ?>px;
			margin-bottom:<?php echo $margin_list[ReportConfig::$BOTTOM]; ?>px;
			margin-right:<?php echo $margin_list[ReportConfig::$RIGHT]; ?>px;
			margin-left:<?php echo $margin_list[ReportConfig::$LEFT]; ?>px;
			<?php
			if($left_margin_line)
			{
				echo "border-left: 1px solid black;";
			}
			?>
		}
	<?php
	}

	public function getTableSortTip()
	{
		$tips_string = LangUtil::$pageTerms['TIPS_TABLESORT'];
		?>
		<small>
			<?php echo LangUtil::$generalTerms['TIPS'].": ".$tips_string; ?>
		</small>
		<?php
	}

	public function getDateFormatSelect($lab_config)
	{
		global $DATE_FORMAT_LIST, $DATE_FORMAT_PRETTY_LIST;
		$format_list = $DATE_FORMAT_LIST;
		$count = 0;
		foreach($format_list as $format)
		{
			$formatted_date = date($format);
			echo "<option value='$format'";
			if($lab_config->dateFormat === $format)
				echo " selected ";
			echo">".$DATE_FORMAT_PRETTY_LIST[$count]."</option>";
			$count++;
		}
	}

	public function getExportTxtScript()
	{
		?>
		<script type='text/javascript'>
		function export_as_txt(div_id)
		{
			var content = $('#'+div_id).html();
			$('#txt_data').attr("value", content);
			$('#txt_format_form').submit();
		}
		</script>
		<form id='txt_format_form' name='txt_format_form' action='export_txt.php' method='post' target='_blank'>
			<input type='hidden' name='data' value='' id='txt_data' />
		</form>
		<?php
	}

	public function getRegistrationFieldsSummary($lab_config)
	{
		?>
		<table class='hor-minimalist-b' style='width:auto;'>
						<tbody>
							<tr valign='top'>
								<td><?php echo LangUtil::$generalTerms['PATIENTS']; ?> - <?php echo LangUtil::$generalTerms['PATIENT_ID']; ?></td>
								<td>
									<?php
									if($lab_config->pid != 0)
										echo " In use ";
									else
										echo "Not in use";
									if($lab_config->pid == 1 )
										echo "(allows duplicates)";
									if($lab_config->pid == 2 )
										echo " (Mandatory field) (allows duplicates)";
									if($lab_config->pid == 4)
										echo " (Mandatory field) (no duplicates)";
									if($lab_config->pid == 3)
										echo "(no duplicates)";
									?>
								</td>
							</tr>
							<tr valign='top'>
								<td><?php echo LangUtil::$generalTerms['PATIENTS']; ?> - <?php echo LangUtil::$generalTerms['ADDL_ID']; ?></td>
								<td>
								<?php
									if($lab_config->patientAddl != 0)
										echo " In use ";
									else
										echo "Not in use";
									if($lab_config->patientAddl == 2)
										echo " (Mandatory field) ";
								?>
								</td>
							</tr>
							<tr>
								<td><?php echo LangUtil::$generalTerms['PATIENTS']; ?> - <?php echo LangUtil::$generalTerms['PATIENT_DAILYNUM']; ?></td>
								<td>
									<?php
									if($lab_config->dailyNum == 1 || $lab_config->dailyNum == 11 || $lab_config->dailyNum == 2 || $lab_config->dailyNum == 12)
										echo " In use ";
									else
										echo "Not in use";
									if($lab_config->dailyNum == 2 || $lab_config->dailyNum == 12)
									{
										echo " (Mandatory field) ";
										echo "&nbsp;&nbsp;";
									}
									if($lab_config->dailyNum == 1 || $lab_config->dailyNum == 11 || $lab_config->dailyNum == 2 || $lab_config->dailyNum == 12)
									{
										echo "&nbsp;&nbsp;".LangUtil::$generalTerms['MSG_RESET'].": ";
										switch($lab_config->dailyNumReset)
										{
											case LabConfig::$RESET_DAILY:
												echo LangUtil::$pageTerms['DAILY'];
												break;
											case LabConfig::$RESET_WEEKLY:
												echo LangUtil::$pageTerms['WEEKLY'];
												break;
											case LabConfig::$RESET_MONTHLY:
												echo LangUtil::$pageTerms['MONTHLY'];
												break;
											case LabConfig::$RESET_YEARLY:
												echo LangUtil::$pageTerms['YEARLY'];
												break;
										}
									}
									?>
								</td>
							</tr>
							<tr style='display:none;'>
								<td><?php echo LangUtil::$generalTerms['PATIENTS']; ?> - <?php echo LangUtil::$generalTerms['NAME']; ?></td>
								<td>
									<?php
									if($lab_config->pname != 0)
										echo " In use ";
									else
										echo "Not in use";
									if($lab_config->pname == 2)
										echo " (Mandatory field) ";
									?>
								</td>
							</tr>
							<tr style='display:none;'>
								<td><?php echo LangUtil::$generalTerms['PATIENTS']; ?> - <?php echo LangUtil::$generalTerms['GENDER']; ?></td>
								<td>
									<?php
									if($lab_config->sex != 0)
										echo " In use ";
									else
										echo "Not in use";
									if($lab_config->sex == 2)
										echo " (Mandatory field) ";
									?>
								</td>
							</tr>
							<tr>
								<td><?php echo LangUtil::$generalTerms['PATIENTS']; ?> - <?php echo LangUtil::$generalTerms['DOB']; ?></td>
								<td>
									<?php
									if($lab_config->dob != 0)
										echo " In use ";
									else
										echo "Not in use";
									if($lab_config->dob == 2)
										echo " (Mandatory field) ";
									?>
								</td>
							</tr>
							<tr style='display:none;'>
								<td><?php echo LangUtil::$generalTerms['PATIENTS']; ?> - <?php echo LangUtil::$generalTerms['AGE']; ?></td>
								<td>
								<?php
									if($lab_config->age == 1 || $lab_config->age == 2 || $lab_config->age == 11 || $lab_config->age == 12)
										echo " In use ";
									else
										echo "Not in use";
									if($lab_config->age == 2 || $lab_config->age == 12)
										echo " (Mandatory field) ";
								?>
								</td>
							</tr>
							<?php
							# Hide patient name flag: Hidden
							# Option moved to technician account profile from v0.8.2
							/*
							<tr>
								<td><?php echo LangUtil::$generalTerms['PATIENTS']; ?> - <?php echo LangUtil::$pageTerms['USE_PNAME_RESULTS']; ?>?</td>
								<td>
								<?php
									if($lab_config->hidePatientName == 0)
										echo " Yes ";
									else
										echo " No ";
								?>
								</td>
							</tr>
							*/
							?>
							<tr valign='top' style='display:none;'>
								<td><?php echo LangUtil::$generalTerms['SPECIMENS']; ?> - <?php echo LangUtil::$generalTerms['SPECIMEN_ID']; ?></td>
								<td>
									<?php
									if($lab_config->sid != 0)
										echo " In use ";
									else
										echo "Not in use";
									if($lab_config->sid == 2)
										echo " (Mandatory field) ";
								?>
								</td>
							</tr>
							<tr>
								<td><?php echo LangUtil::$generalTerms['SPECIMENS']; ?> - <?php echo LangUtil::$generalTerms['SPECIMEN_ID']; ?></td>
								<td>
									<?php
									if($lab_config->specimenAddl != 0)
										echo " In use ";
									else
										echo "Not in use";
									if($lab_config->specimenAddl == 2)
										echo " (Mandatory field) ";
								?>
								</td>
							</tr>
							<tr>
								<td><?php echo LangUtil::$generalTerms['SPECIMENS']; ?> - <?php echo LangUtil::$generalTerms['COMMENTS']; ?></td>
								<td>
								<?php
									if($lab_config->comm != 0)
										echo " In use ";
									else
										echo "Not in use";
									if($lab_config->comm == 2)
										echo " (Mandatory field) ";
								?>
								</td>
							</tr>
							<tr>
								<td><?php echo LangUtil::$generalTerms['SPECIMENS']; ?> - <?php echo LangUtil::$generalTerms['R_DATE']; ?></td>
								<td>
									<?php
									if($lab_config->rdate != 0)
										echo " In use ";
									else
										echo "Not in use";
									if($lab_config->rdate == 2)
										echo " (Mandatory field) ";
								?>
								</td>
							</tr>
							<tr>
								<td><?php echo LangUtil::$generalTerms['SPECIMENS']; ?> - <?php echo LangUtil::$generalTerms['REF_OUT']; ?></td>
								<td>
									<?php
									if($lab_config->refout != 0)
										echo " In use ";
									else
										echo "Not in use";
									if($lab_config->refout == 2)
										echo " (Mandatory field) ";
								?>
								</td>
							</tr>
							<tr>
								<td><?php echo LangUtil::$generalTerms['SPECIMENS']; ?> - <?php echo LangUtil::$generalTerms['DOCTOR']; ?></td>
								<td>
									<?php
									if($lab_config->doctor != 0)
										echo " In use ";
									else
										echo "Not in use";
									if($lab_config->doctor == 2)
										echo " (Mandatory field) ";
								?>
								</td>
							</tr>
							<tr>
								<td><?php echo LangUtil::$generalTerms['DATE_FORMAT']; ?></td>
								<td><?php echo $lab_config->dateFormat; ?></td>
							</tr>
						</tbody>
					</table>

		<?php
	}

	public function getDoctorRegistrationFieldsSummary($lab_config)
	{
		?>
			<table class='hor-minimalist-b' style='width:auto;'>
							<tbody>

								<tr>
									<td><?php echo LangUtil::$generalTerms['PATIENTS']; ?> - <?php echo LangUtil::$generalTerms['PATIENT_DAILYNUM']; ?></td>
									<td>
										<?php
										if($lab_config->dailyNum == 1 || $lab_config->dailyNum == 11 || $lab_config->dailyNum == 2 || $lab_config->dailyNum == 12)
											echo " In use ";
										else
											echo "Not in use";
										if($lab_config->dailyNum == 2 || $lab_config->dailyNum == 12)
										{
											echo " (Mandatory field) ";
											echo "&nbsp;&nbsp;";
										}
										if($lab_config->dailyNum == 1 || $lab_config->dailyNum == 11 || $lab_config->dailyNum == 2 || $lab_config->dailyNum == 12)
										{
											echo "&nbsp;&nbsp;".LangUtil::$generalTerms['MSG_RESET'].": ";
											switch($lab_config->dailyNumReset)
											{
												case LabConfig::$RESET_DAILY:
													echo LangUtil::$pageTerms['DAILY'];
													break;
												case LabConfig::$RESET_WEEKLY:
													echo LangUtil::$pageTerms['WEEKLY'];
													break;
												case LabConfig::$RESET_MONTHLY:
													echo LangUtil::$pageTerms['MONTHLY'];
													break;
												case LabConfig::$RESET_YEARLY:
													echo LangUtil::$pageTerms['YEARLY'];
													break;
											}
										}
										?>
									</td>
								</tr>
								<tr style='display:none;'>
									<td><?php echo LangUtil::$generalTerms['PATIENTS']; ?> - <?php echo LangUtil::$generalTerms['NAME']; ?></td>
									<td>
										<?php
										if($lab_config->pname != 0)
											echo " In use ";
										else
											echo "Not in use";
										if($lab_config->pname == 2)
											echo " (Mandatory field) ";
										?>
									</td>
								</tr>
								<tr>
									<td><?php echo LangUtil::$generalTerms['PATIENTS']; ?> - <?php echo LangUtil::$generalTerms['GENDER']; ?></td>
									<td>
										<?php
										if($lab_config->sex != 0)
											echo " In use ";
										else
											echo "Not in use";
										if($lab_config->sex == 2)
											echo " (Mandatory field) ";
										?>
									</td>
								</tr>
								<tr>
									<td><?php echo LangUtil::$generalTerms['PATIENTS']; ?> - <?php echo LangUtil::$generalTerms['DOB']; ?></td>
									<td>
										<?php
										if($lab_config->dob != 0)
											echo " In use ";
										else
											echo "Not in use";
										if($lab_config->dob == 2)
											echo " (Mandatory field) ";
										?>
									</td>
								</tr>
								<tr>
									<td><?php echo LangUtil::$generalTerms['PATIENTS']; ?> - <?php echo LangUtil::$generalTerms['AGE']; ?></td>
									<td>
									<?php
										if($lab_config->age == 1 || $lab_config->age == 2 || $lab_config->age == 11 || $lab_config->age == 12)
											echo " In use ";
										else
											echo "Not in use";
										if($lab_config->age == 2 || $lab_config->age == 12)
											echo " (Mandatory field) ";
									?>
									</td>
								</tr>
								<?php
								# Hide patient name flag: Hidden
								# Option moved to technician account profile from v0.8.2
								/*
								<tr>
									<td><?php echo LangUtil::$generalTerms['PATIENTS']; ?> - <?php echo LangUtil::$pageTerms['USE_PNAME_RESULTS']; ?>?</td>
									<td>
									<?php
										if($lab_config->hidePatientName == 0)
											echo " Yes ";
										else
											echo " No ";
									?>
									</td>
								</tr>
								*/
								?>
								<tr valign='top' style='display:none;'>
									<td><?php echo LangUtil::$generalTerms['SPECIMENS']; ?> - <?php echo LangUtil::$generalTerms['SPECIMEN_ID']; ?></td>
									<td>
										<?php
										if($lab_config->sid != 0)
											echo " In use ";
										else
											echo "Not in use";
										if($lab_config->sid == 2)
											echo " (Mandatory field) ";
									?>
									</td>
								</tr>
								<tr>
									<td><?php echo LangUtil::$generalTerms['SPECIMENS']; ?> - <?php echo LangUtil::$generalTerms['SPECIMEN_ID']; ?></td>
									<td>
										<?php
										if($lab_config->specimenAddl != 0)
											echo " In use ";
										else
											echo "Not in use";
										if($lab_config->specimenAddl == 2)
											echo " (Mandatory field) ";
									?>
									</td>
								</tr>
								<tr>
									<td><?php echo LangUtil::$generalTerms['SPECIMENS']; ?> - <?php echo LangUtil::$generalTerms['COMMENTS']; ?></td>
									<td>
									<?php
										if($lab_config->comm != 0)
											echo " In use ";
										else
											echo "Not in use";
										if($lab_config->comm == 2)
											echo " (Mandatory field) ";
									?>
									</td>
								</tr>
								<tr>
									<td><?php echo LangUtil::$generalTerms['SPECIMENS']; ?> - <?php echo LangUtil::$generalTerms['R_DATE']; ?></td>
									<td>
										<?php
										if($lab_config->rdate != 0)
											echo " In use ";
										else
											echo "Not in use";
										if($lab_config->rdate == 2)
											echo " (Mandatory field) ";
									?>
									</td>
								</tr>
								<tr>
									<td><?php echo LangUtil::$generalTerms['SPECIMENS']; ?> - <?php echo LangUtil::$generalTerms['REF_OUT']; ?></td>
									<td>
										<?php
										if($lab_config->refout != 0)
											echo " In use ";
										else
											echo "Not in use";
										if($lab_config->refout == 2)
											echo " (Mandatory field) ";
									?>
									</td>
								</tr>
								<tr>
									<td><?php echo LangUtil::$generalTerms['SPECIMENS']; ?> - <?php echo LangUtil::$generalTerms['DOCTOR']; ?></td>
									<td>
										<?php
										if($lab_config->doctor != 0)
											echo " In use ";
										else
											echo "Not in use";
										if($lab_config->doctor == 2)
											echo " (Mandatory field) ";
									?>
									</td>
								</tr>
								<tr>
									<td><?php echo LangUtil::$generalTerms['DATE_FORMAT']; ?></td>
									<td><?php echo $lab_config->dateFormat; ?></td>
								</tr>
							</tbody>
						</table>

			<?php
		}

	public function getPatientSearchAttribSelect($hide_patient_name=false)
	{
            $userrr = get_user_by_id($_SESSION['user_id']);

		global $LIS_TECH_RO, $LIS_TECH_RW, $LIS_CLERK, $LIS_VERIFIER,$LIS_DOCTOR, $LIS_PHYSICIAN;
		if
		(
			$_SESSION['user_level'] == $LIS_TECH_RO ||
			$_SESSION['user_level'] == $LIS_TECH_RW ||
			$_SESSION['user_level'] == $LIS_CLERK ||
			$_SESSION['user_level'] == $LIS_DOCTOR ||
			$_SESSION['user_level'] == $LIS_VERIFIER ||
			$_SESSION['user_level'] == 17
		)
		{
			$lab_config = LabConfig::getById($_SESSION['lab_config_id']);
                        $patientBarcodeSearch = patientSearchBarcodeCheck();
                        echo $hide_patient_name;
                        echo $lab_config->pname ;
			if($hide_patient_name === false && $lab_config->pname != 0)
			{
				?>
				<option value='1'><?php echo LangUtil::$generalTerms['PATIENT_NAME']; ?></option>
				<?php
			}
			if($lab_config->dailyNum == 1 || $lab_config->dailyNum == 11 || $lab_config->dailyNum == 2 || $lab_config->dailyNum == 12 || $lab_config->dailyNum == 17)
			{
				?>
				<option value='3'><?php echo LangUtil::$generalTerms['PATIENT_DAILYNUM']; ?></option>
				<?php
			}
			if($lab_config->pid != 0)
			{
				?>
				<option value='0'><?php echo LangUtil::$generalTerms['PATIENT_ID']; ?></option>
				<?php
			}
			if($lab_config->patientAddl != 0)
			{
				?>
				<option value='2'><?php echo LangUtil::$generalTerms['ADDL_ID']; ?></option>
				<?php
			}
                        if($patientBarcodeSearch != 0 && is_country_dir($userrr) != 1 && is_super_admin($userrr) != 1 )
			{
				?>
				<option value='9'><?php echo 'Barcode Search'; ?></option>
				<?php
			}
		}
		else if(User::onlyOneLabConfig($_SESSION['user_id'], $_SESSION['user_level']))
		{
			# Lab admin
			$lab_config_list = get_lab_configs($_SESSION['user_id']);
			$lab_config = $lab_config_list[0];
                        $patientBarcodeSearch = patientSearchBarcodeCheck();
			if($lab_config->pname != 0)
			{
				?>
				<option value='1'><?php echo LangUtil::$generalTerms['PATIENT_NAME']; ?></option>
				<?php
			}
			if($lab_config->dailyNum == 1 || $lab_config->dailyNum == 11 || $lab_config->dailyNum == 2 || $lab_config->dailyNum == 12)
			{
				?>
				<option value='3'><?php echo LangUtil::$generalTerms['PATIENT_DAILYNUM']; ?></option>
				<?php
			}
			if($lab_config->pid != 0)
			{
				?>
				<option value='0'><?php echo LangUtil::$generalTerms['PATIENT_ID']; ?></option>
				<?php
			}
			if($lab_config->patientAddl != 0)
			{
				?>
				<option value='2'><?php echo LangUtil::$generalTerms['ADDL_ID']; ?></option>
				<?php
			}
                        if($patientBarcodeSearch != 0 && is_country_dir($userrr) != 1 && is_super_admin($userrr) != 1 )
			{
				?>
				<option value='9'><?php echo 'Barcode Search'; ?></option>
				<?php
			}
		}
		else
		{
                                            $patientBarcodeSearch = patientSearchBarcodeCheck();
                                            $specimenBarcodeSearch = specimenSearchBarcodeCheck();

			# Show all options
			?>
			<option value='1'><?php echo LangUtil::$generalTerms['PATIENT_NAME']; ?></option>
			<option value='3'><?php echo LangUtil::$generalTerms['PATIENT_DAILYNUM']; ?></option>
			<option value='0'><?php echo LangUtil::$generalTerms['PATIENT_ID']; ?></option>
			<option value='2'><?php echo LangUtil::$generalTerms['ADDL_ID']; ?></option>


			<?php
               if($patientBarcodeSearch != 0 && is_country_dir($userrr) != 1 && is_super_admin($userrr) != 1 ){ ?>
                        				<option value='10'><?php echo 'Patient Barcode'; ?></option>
                                                        <?php } ?>


            <?php
                if($specimenBarcodeSearch != 0 && is_country_dir($userrr) != 1 && is_super_admin($userrr) != 1 ){ ?>
                        				<option value='9'><?php echo 'Specimen Barcode'; ?></option>
                                                        <?php } ?>



			<?php
		}
	}

	public function getNewCustomWorksheetForm($lab_config)
	{
		if($lab_config == null)
		{
			return;
		}
		?>
		<input type='hidden' name='location' value='<?php echo $lab_config->id; ?>'></input>
		<table class='hor-minimalist-b' style='width:auto;'>
			<tbody>
			<tr valign='top'>
				<td><?php echo LangUtil::$generalTerms['NAME']; ?></td>
				<td><input type='text' name='wname' id='wname' value='' class='uniform_width_more'></input></td>
			</tr>
			<tr valign='top'>
				<td>Header</td>
				<td><input type='text' name='header' id='header' value='' class='uniform_width_more'></td>
			</tr>
			<tr valign='top'>
				<td>Title</td>
				<td><input type='text' name='title' id='title' value='' class='uniform_width_more'></td>
			</tr>
			<tr valign='top'>
				<td>Footer</td>
				<td><input type='text' name='footer' id='footer' value='' class='uniform_width_more'></td>
			</tr>
			<tr valign='top'>
				<td><?php echo LangUtil::$pageTerms['MARGINS']; ?> (%)</td>
				<td>
					<?php echo LangUtil::$pageTerms['TOP'];?>
					&nbsp;
					<input type='text' name='margin_top' id='margin_top' value='<?php echo CustomWorksheet::$DEFAULT_MARGINS[ReportConfig::$TOP]; ?>' size='2'></input>
					&nbsp;&nbsp;&nbsp;
					<?php echo LangUtil::$pageTerms['BOTTOM'];?>
					&nbsp;
					<input type='text' name='margin_bottom' id='margin_bottom' value='<?php echo CustomWorksheet::$DEFAULT_MARGINS[ReportConfig::$BOTTOM]; ?>' size='2'></input>
					&nbsp;&nbsp;&nbsp;
					<?php echo LangUtil::$pageTerms['LEFT'];?>
					&nbsp;
					<input type='text' name='margin_left' id='margin_left' value='<?php echo CustomWorksheet::$DEFAULT_MARGINS[ReportConfig::$LEFT]; ?>' size='2'></input>
					&nbsp;&nbsp;&nbsp;
					<?php echo LangUtil::$pageTerms['RIGHT'];?>
					&nbsp;
					<input type='text' name='margin_right' id='margin_right' value='<?php echo CustomWorksheet::$DEFAULT_MARGINS[ReportConfig::$RIGHT]; ?>' size='2'></input>
				</td>
			</tr>
			<tr valign='top'>
				<td><?php echo LangUtil::$generalTerms['PATIENT_ID']; ?></td>
				<td>
					<input type='radio' name='is_pid' value='Y' id='is_pid'><?php echo LangUtil::$generalTerms['YES']; ?></input>
					<input type='radio' name='is_pid' value='N' checked><?php echo LangUtil::$generalTerms['NO']; ?></input>
				</td>
			</tr>
			<tr valign='top'>
				<td><?php echo LangUtil::$generalTerms['PATIENT_DAILYNUM']; ?></td>
				<td>
					<input type='radio' name='is_dnum' value='Y' id='is_dnum'><?php echo LangUtil::$generalTerms['YES']; ?></input>
					<input type='radio' name='is_dnum' value='N' checked><?php echo LangUtil::$generalTerms['NO']; ?></input>
				</td>
			</tr>
			<tr valign='top'>
				<td><?php echo LangUtil::$generalTerms['ADDL_ID']; ?></td>
				<td>
					<input type='radio' name='is_addlid' value='Y' id='is_addlid'><?php echo LangUtil::$generalTerms['YES']; ?></input>
					<input type='radio' name='is_addlid' value='N' checked><?php echo LangUtil::$generalTerms['NO']; ?></input>
				</td>
			</tr>
			<tr valign='top'>
				<td><?php echo LangUtil::$pageTerms['CUSTOMFIELDS']; ?></td>
				<td>
					<span id='uf_list_box'>
					<?php echo LangUtil::$generalTerms['NAME']; ?>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?php echo LangUtil::$pageTerms['COLUMN_WIDTH']; ?>
					<br>
					<input type='text' name='uf_name[]' class='uniform_width'></input>
					<input type='text' name='uf_width[]' size='2' value='<?php echo CustomWorksheet::$DEFAULT_WIDTH; ?>'></input>
					<br>
					</span>
					<small><a href='javascript:add_another_uf();'><?php echo LangUtil::$generalTerms['ADDANOTHER']; ?>&raquo;</a></small>
				</td>
			</tr>

			<tr valign='top'>
				<td><?php echo LangUtil::$generalTerms['LAB_SECTION']; ?></td>
				<td>
					<select name='cat_code' id='cat_code' class='uniform_width'>
						<?php $this->getTestCategorySelect(); ?>
					</select>
					&nbsp;&nbsp;&nbsp;
					<span id='test_boxes_progress' style='display:none'>
						<?php echo $this->getProgressSpinner(LangUtil::$generalTerms['CMD_FETCHING']); ?>
					</span>
				</td>
			</tr>
		</table>
		<?php
		if(false)
		{
		?>
		<table cellspacing='5px' class='smaller_font'>
			<tr valign='top'>
				<td><b><?php echo LangUtil::$generalTerms['PATIENTS']?></b></td>
				<td></td>
			</tr>
			<?php # Patient main fields ?>
			<tr valign='top'>
				<td>
					<input type='checkbox' name='p_field_0'>
					</input>
					<?php echo LangUtil::$generalTerms['PATIENT_ID']; ?>
				</td>
				<td></td>
			</tr>
			<tr valign='top'>
				<td>
					<input type='checkbox' name='p_field_1'>
					</input>
					<?php echo LangUtil::$generalTerms['PATIENT_DAILYNUM']; ?>
				</td>
				<td></td>
			</tr>
			<tr valign='top'>
				<td>
					<input type='checkbox' name='p_field_2'>
					</input><?php echo LangUtil::$generalTerms['ADDL_ID']; ?>
				</td>
				<td></td>
			</tr>
			<tr valign='top'>
				<td>
					<input type='checkbox' name='p_field_3' >
					</input>
					<?php echo LangUtil::$generalTerms['GENDER']; ?>
				</td>
				<td></td>
			</tr>
			<tr valign='top'>
				<td>
					<input type='checkbox' name='p_field_4' >
					</input>
					<?php echo LangUtil::$generalTerms['AGE']; ?>
				</td>
				<td></td>
			</tr>
			<tr valign='top'>
				<td>
				<input type='checkbox' name='p_field_5' >
					</input>
					<?php echo LangUtil::$generalTerms['DOB']; ?>
				</td>
				<td></td>
			</tr>
			<tr valign='top'>
				<td>
					<input type='checkbox' name='p_field_6' >
					</input>
					<?php echo LangUtil::$generalTerms['NAME']; ?>
				</td>
				<td></td>
			</tr>
			<?php
			# Patient custom fields
			$custom_field_list = $lab_config->getPatientCustomFields();
			foreach($custom_field_list as $custom_field)
			{
				?>
				<tr valign='top'>
					<td>
						<input type='checkbox' name='p_custom_<?php echo $custom_field->id; ?>'>
						</input>
						<?php echo $custom_field->fieldName; ?>
					</td>
				</tr>
			<?php
			}
			?>

			<tr valign='top'>
				<td><b><?php echo LangUtil::$generalTerms['SPECIMENS']?></b></td>
			</tr>
			<?php # Specimen main fields ?>
			<tr valign='top'>
				<td>
					<input type='checkbox' name='s_field_1' >
					</input>
					<?php
					# For the user "specimen ID" is now stored in aux_id field
					echo LangUtil::$generalTerms['SPECIMEN_ID'];
					?>
				</td>
			</tr>
			<tr valign='top'>
				<td>
					<input type='checkbox' name='s_field_5' >
					</input>
					<?php echo LangUtil::$generalTerms['SPECIMEN_TYPE']; ?>
				</td>

			</tr>
			<tr valign='top'>
				<td>
					<input type='checkbox' name='s_field_2' >
					</input>
					<?php echo LangUtil::$generalTerms['R_DATE']; ?>
				</td>

			</tr>
			<tr valign='top'>
				<td>
					<input type='checkbox' name='s_field_3' >
					</input>
					<?php echo LangUtil::$generalTerms['COMMENTS']; ?>
				</td>

			</tr>
			<tr valign='top'>
				<td>
					<input type='checkbox' name='s_field_4' >
					</input>
					<?php echo LangUtil::$generalTerms['REF_OUT']; ?>
				</td>

			</tr>
			<tr valign='top'>
				<td>
					<input type='checkbox' name='s_field_6' >
					</input>
					<?php echo LangUtil::$generalTerms['DOCTOR']; ?>
				</td>

			</tr>
			<?php
			# Specimen custom fields
			$custom_field_list = $lab_config->getSpecimenCustomFields();
			foreach($custom_field_list as $custom_field)
			{
				?>
				<tr valign='top'>
					<td>
						<input type='checkbox' name='s_custom_<?php echo $custom_field->id; ?>' >
						</input>
						<?php echo $custom_field->fieldName; ?>
					</td>

				</tr>
			<?php
			}
			?>
			<tr valign='top'>
				<td></td>
				<td></td>
			</tr>
			</tbody>
		</table>
		<?php
		}
		# Test types and measures with width fields
		?>
		<br>
		<div id='test_boxes' class='smaller_font' style='width:auto;'>

		</div>
		<input type='button' value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>' id='worksheet_submit_button' onclick='javascript:submit_worksheet_form();'>
		</input>
		&nbsp;&nbsp;&nbsp;
		<small>
		<a href='lab_config_home.php?id=<?php echo $lab_config->id; ?>'>
			<?php echo LangUtil::$generalTerms['CMD_CANCEL']; ?>
		</a>
		</small>
		&nbsp;&nbsp;&nbsp;
		<span id='worksheet_submit_progress' style='display:none;'>
			<?php $this->getProgressSpinner(LangUtil::$generalTerms['CMD_SUBMITTING']); ?>
		</span>
		<?php
	}

	public function getCustomWorksheetSummary($worksheet)
	{
		?>
		<table class='hor-minimalist-b' style='width:auto;'>
			<tbody>
			<tr valign='top'>
				<td><?php echo LangUtil::$generalTerms['NAME']; ?></td>
				<td><?php echo $worksheet->name; ?></td>
			</tr>
			<tr valign='top'>
				<td>Header</td>
				<td><?php echo $worksheet->headerText; ?></td>
			</tr>
			<tr valign='top'>
				<td>Title</td>
				<td><?php echo $worksheet->titleText; ?></td>
			</tr>
			<tr valign='top'>
				<td>Footer</td>
				<td><?php echo $worksheet->footerText; ?></td>
			</tr>
			<tr valign='top'>
				<td><?php echo LangUtil::$pageTerms['MARGINS']; ?> (%)</td>
				<td>
					<?php echo LangUtil::$pageTerms['TOP'];?>
					&nbsp;
					<?php echo $worksheet->margins[ReportConfig::$TOP]; ?>
					&nbsp;&nbsp;&nbsp;
					<?php echo LangUtil::$pageTerms['BOTTOM'];?>
					&nbsp;
					<?php echo $worksheet->margins[ReportConfig::$BOTTOM]; ?>
					&nbsp;&nbsp;&nbsp;
					<?php echo LangUtil::$pageTerms['LEFT'];?>
					&nbsp;
					<?php echo $worksheet->margins[ReportConfig::$LEFT]; ?>
					&nbsp;&nbsp;&nbsp;
					<?php echo LangUtil::$pageTerms['RIGHT'];?>
					&nbsp;
					<?php echo $worksheet->margins[ReportConfig::$RIGHT]; ?>
				</td>
			</tr>
			<tr valign='top'>
				<td><?php echo LangUtil::$generalTerms['PATIENT_ID']; ?></td>
				<td>
					<?php
					if($worksheet->idFields[CustomWorksheet::$OFFSET_PID] == 1)
					{
						echo LangUtil::$generalTerms['YES'];
					}
					else
					{
						echo LangUtil::$generalTerms['NO'];
					}
					?>
				</td>
			</tr>
			<tr valign='top'>
				<td><?php echo LangUtil::$generalTerms['PATIENT_DAILYNUM']; ?></td>
				<td>
					<?php
					if($worksheet->idFields[CustomWorksheet::$OFFSET_DNUM] == 1)
					{
						echo LangUtil::$generalTerms['YES'];
					}
					else
					{
						echo LangUtil::$generalTerms['NO'];
					}
					?>
				</td>
			</tr>
			<tr valign='top'>
				<td><?php echo LangUtil::$generalTerms['ADDL_ID']; ?></td>
				<td>
					<?php
					if($worksheet->idFields[CustomWorksheet::$OFFSET_ADDLID] == 1)
					{
						echo LangUtil::$generalTerms['YES'];
					}
					else
					{
						echo LangUtil::$generalTerms['NO'];
					}
					?>
				</td>
			</tr>
			<tr valign='top'>
				<td><?php echo LangUtil::$pageTerms['CUSTOMFIELDS']; ?></td>
				<td>
					<span id='uf_list_box'>
					<?php
					foreach($worksheet->userFields as $field_entry)
					{
						$field_id = $field_entry[0];
						$field_name = $field_entry[1];
						$field_width = $field_entry[2];
						echo $field_name;
						echo "&nbsp;&nbsp;(";
						echo LangUtil::$pageTerms['COLUMN_WIDTH'].": ";
						echo $field_width;
						echo ")";
						echo "<br>";
					}
					?>
					</span>
				</td>
			</tr>
		</table>
		<br>
		<div class='smaller_font' style='width:auto;'>
		<?php
		$test_type_list = $worksheet->testTypes;
		foreach($test_type_list as $test_type_id)
		{
			$test_type = TestType::getById($test_type_id);
			$measure_list = $test_type->getMeasures();
			?>
			<div>
			<b><?php echo $test_type->getName(); ?></b>
			<br>
				<div id='ttype_<?php echo $test_type->testTypeId; ?>_mlist' style='position:relative; margin-left:15px;'>
				<table class='hor-minimalist-b'>
					<thead>
					<tr>
						<th style='width:200px;'><?php echo LangUtil::$generalTerms['MEASURES']; ?></th>
						<th><?php echo LangUtil::$pageTerms['COLUMN_WIDTH']; ?> (%)</th>
					</tr>
					<?php
					foreach($measure_list as $measure)
					{
						$measure_id = $measure->measureId;
						?>
						<tr>
							<td>
								<?php echo $measure->getName(); ?>
							</td>
							<td>
								<?php echo $worksheet->columnWidths[$test_type_id][$measure_id]; ?>
							</td>
						</tr>
						<?php
					}
					?>
					</thead>
					<tbody>
					</tbody>
				</table>
				</div>
			</div>
			<br>
			<?php
		}
		?>
		</div>
	</div>
	<?php
	}

	public function getCustomWorksheetSelect($lab_config)
	{
		if($lab_config == null)
		{
			return;
		}
		$worksheet_list = $lab_config->getCustomWorksheets();
		foreach($worksheet_list as $worksheet)
		{
			print_r($worksheet);
			echo "<option value='$worksheet->id'>$worksheet->name</option>";
		}
	}

	public function getCustomWorksheetTable($lab_config)
	{
		echo "Custom Worksheets";
		if($lab_config == null)
		{
			echo "<div class='sidetip_nopos'>".LangUtil::$generalTerms['MSG_NOTFOUND']."</div>";
			return;
		}
		$worksheet_list = $lab_config->getCustomWorksheets();
		if($worksheet_list == null || count($worksheet_list) == 0)
		{
			echo "<div class='sidetip_nopos'>".LangUtil::$generalTerms['MSG_NOTFOUND']."</div>";
			return;
		}
		?>
		<table class='hor-minimalist-b' style='width:500px;'>
			<thead>
				<tr valign='top'>
					<th>
						#
					</th>
					<th>
						<?php echo LangUtil::$generalTerms['NAME']; ?>
					</th>
					<th>
					</th>
				</tr>
			</thead>
			<tbody>
			<?php
			$count = 1;
			foreach($worksheet_list as $worksheet)
			{
				?>
					<tr valign='top'>
						<td>
							<?php echo $count; ?>.
						</td>
						<td>
							<?php echo $worksheet->name; ?>
						</td>
						<td>
							<a href="worksheet_custom_edit.php?wid=<?php echo $worksheet->id; ?>&lid=<?php echo $lab_config->id; ?>">
							<?php echo LangUtil::$generalTerms['CMD_EDIT']; ?>
							</a>
							&nbsp;&nbsp;&nbsp;&nbsp;
						</td>
					</tr>
				<?php
				$count++;
			}
			?>
			</tbody>
		</table>
		<?php
	}

	public function getEditCustomWorksheetForm($worksheet_id, $lab_config)
	{
		if($lab_config == null)
		{
			echo LangUtil::$generalTerms['MSG_NOTFOUND'];
			return;
		}
		$worksheet = CustomWorksheet::getById($worksheet_id, $lab_config);
		if($worksheet == null)
		{
			echo LangUtil::$generalTerms['MSG_NOTFOUND'];
			return;
		}
		?>
		<input type='hidden' name='location' value='<?php echo $lab_config->id; ?>'></input>
		<input type='hidden' name='wid' value='<?php echo $worksheet_id; ?>'></input>
		<table class='hor-minimalist-b' style='width:auto;'>
			<tbody>
			<tr valign='top'>
				<td><?php echo LangUtil::$generalTerms['NAME']; ?></td>
				<td><input type='text' name='wname' id='wname' value='<?php echo $worksheet->name; ?>' class='uniform_width_more'></input></td>
			</tr>
			<tr valign='top'>
				<td>Header</td>
				<td><input type='text' name='header' id='header' value='<?php echo $worksheet->headerText; ?>' class='uniform_width_more'></td>
			</tr>
			<tr valign='top'>
				<td>Title</td>
				<td><input type='text' name='title' id='title' value='<?php echo $worksheet->titleText; ?>' class='uniform_width_more'></td>
			</tr>
			<tr valign='top'>
				<td>Footer</td>
				<td><input type='text' name='footer' id='footer' value='<?php echo $worksheet->footerText; ?>' class='uniform_width_more'></td>
			</tr>
			<tr valign='top'>
				<td><?php echo LangUtil::$pageTerms['MARGINS']; ?> (%)</td>
				<td>
					<?php echo LangUtil::$pageTerms['TOP'];?>
					&nbsp;
					<input type='text' name='margin_top' id='margin_top' value='<?php echo $worksheet->margins[ReportConfig::$TOP]; ?>' size='2'></input>
					&nbsp;&nbsp;&nbsp;
					<?php echo LangUtil::$pageTerms['BOTTOM'];?>
					&nbsp;
					<input type='text' name='margin_bottom' id='margin_bottom' value='<?php echo $worksheet->margins[ReportConfig::$BOTTOM]; ?>' size='2'></input>
					&nbsp;&nbsp;&nbsp;
					<?php echo LangUtil::$pageTerms['LEFT'];?>
					&nbsp;
					<input type='text' name='margin_left' id='margin_left' value='<?php echo $worksheet->margins[ReportConfig::$LEFT]; ?>' size='2'></input>
					&nbsp;&nbsp;&nbsp;
					<?php echo LangUtil::$pageTerms['RIGHT'];?>
					&nbsp;
					<input type='text' name='margin_right' id='margin_right' value='<?php echo $worksheet->margins[ReportConfig::$RIGHT]; ?>' size='2'></input>
				</td>
			</tr>
			<tr valign='top'>
				<td><?php echo LangUtil::$generalTerms['PATIENT_ID']; ?></td>
				<td>
					<input type='radio' name='is_pid' value='Y' id='is_pid'<?php
					if($worksheet->idFields[CustomWorksheet::$OFFSET_PID] == 1)
					{
						echo " checked ";
					}?>><?php echo LangUtil::$generalTerms['YES']; ?></input>
					<input type='radio' name='is_pid' value='N'<?php
					if($worksheet->idFields[CustomWorksheet::$OFFSET_PID] == 0)
					{
						echo " checked ";
					}?>><?php echo LangUtil::$generalTerms['NO']; ?></input>
				</td>
			</tr>
			<tr valign='top'>
				<td><?php echo LangUtil::$generalTerms['PATIENT_DAILYNUM']; ?></td>
				<td>
					<input type='radio' name='is_dnum' value='Y' id='is_dnum'<?php
					if($worksheet->idFields[CustomWorksheet::$OFFSET_DNUM] == 1)
					{
						echo " checked ";
					}?>><?php echo LangUtil::$generalTerms['YES']; ?></input>
					<input type='radio' name='is_dnum' value='N'<?php
					if($worksheet->idFields[CustomWorksheet::$OFFSET_DNUM] == 0)
					{
						echo " checked ";
					}?>><?php echo LangUtil::$generalTerms['NO']; ?></input>
				</td>
			</tr>
			<tr valign='top'>
				<td><?php echo LangUtil::$generalTerms['ADDL_ID']; ?></td>
				<td>
					<input type='radio' name='is_addlid' value='Y' id='is_addlid'<?php
					if($worksheet->idFields[CustomWorksheet::$OFFSET_ADDLID] == 1)
					{
						echo " checked ";
					}?>><?php echo LangUtil::$generalTerms['YES']; ?></input>
					<input type='radio' name='is_addlid' value='N'<?php
					if($worksheet->idFields[CustomWorksheet::$OFFSET_ADDLID] == 0)
					{
						echo " checked ";
					}?>><?php echo LangUtil::$generalTerms['NO']; ?></input>
				</td>
			</tr>
			<tr valign='top'>
				<td><?php echo LangUtil::$pageTerms['CUSTOMFIELDS']; ?></td>
				<td>
					<span id='uf_list_box'>
					<?php echo LangUtil::$generalTerms['NAME']; ?>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?php echo LangUtil::$pageTerms['COLUMN_WIDTH']; ?>
					<br>
					<?php
					if($worksheet->userFields == null || count($worksheet->userFields) == 0)
					{
						//echo LangUtil::$generalTerms['NO']."<br>";
					}
					foreach($worksheet->userFields as $field_entry)
					{
						$field_id = $field_entry[0];
						$field_name = $field_entry[1];
						$field_width = $field_entry[2];
						?>
						<input type='hidden' name='existing_uf_id[]' value='<?php echo $field_id; ?>'></input>
						<input type='text' name='existing_uf_name[]' value='<?php echo $field_name; ?>' class='uniform_width'></input>
						<input type='text' name='existing_uf_width[]' size='2' value='<?php echo $field_width; ?>'></input>
						<br>
						<?php
					}
					?>
					</span>
					<small><a href='javascript:add_another_uf();'><?php echo LangUtil::$generalTerms['ADDNEW']; ?>&raquo;</a></small>
				</td>
			</tr>
			<tr valign='top'>
				<td><?php echo LangUtil::$generalTerms['LAB_SECTION']; ?></td>
				<td>
					<?php
					$test_type_id = $worksheet->testTypes[0];
					$saved_db = DbUtil::switchToGlobal();
					$query_string = "SELECT test_category_id FROM test_type WHERE test_type_id=$test_type_id";
					$record = query_associative_one($query_string);
					$cat_code = $record['test_category_id'];
					$cat_name = get_test_category_name_by_id($cat_code);
					DbUtil::switchRestore($saved_db);
					echo $cat_name;
					?>
				</td>
			</tr>
		</table>
		<br>
		<div id='test_boxes' class='smaller_font' style='width:auto;'>
		<?php
		$test_type_list = get_test_types_by_site_category($lab_config->id, $cat_code);
		foreach($test_type_list as $test_type)
		{
			$measure_list = $test_type->getMeasures();
			?>
			<div>
			<input type='checkbox' class='test_type_checkbox' name='ttype_<?php echo $test_type->testTypeId; ?>' id='ttype_<?php echo $test_type->testTypeId; ?>' <?php
			if(in_array($test_type->testTypeId, $worksheet->testTypes))
				echo " checked ";
			?>>
			<?php echo $test_type->getName(); ?>
			</input>
			<br>
				<div id='ttype_<?php echo $test_type->testTypeId; ?>_mlist' style='position:relative; margin-left:15px;<?php
				if(in_array($test_type->testTypeId, $worksheet->testTypes) === false)
					echo "display:none;";
				?>'>
				<table class='hor-minimalist-b'>
					<thead>
					<tr>
						<th style='width:200px;'><?php echo LangUtil::$generalTerms['MEASURES']; ?></th>
						<th><?php echo LangUtil::$pageTerms['COLUMN_WIDTH']; ?> (%)</th>
					</tr>
					<?php
					foreach($measure_list as $measure)
					{
						if(in_array($test_type->testTypeId, $worksheet->testTypes))
							$width_val = $worksheet->columnWidths[$test_type->testTypeId][$measure->measureId];
						else
							$width_val = "";
						?>
						<tr>
							<td>
								<?php echo $measure->getName(); ?>
							</td>
							<td>
								<input type='text' value='<?php echo $width_val; ?>' size='2' name='width_<?php echo $test_type->testTypeId."_".$measure->measureId; ?>'>
								</input>
							</td>
						</tr>
						<?php
					}
					?>
					</thead>
					<tbody>
					</tbody>
				</table>
				</div>
			</div>
			<br>
			<?php
		}
		?>
		<input type='button' value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>' id='worksheet_submit_button' onclick='javascript:submit_worksheet_form();'>
		</input>
		&nbsp;&nbsp;&nbsp;
		<small>
		<a href='lab_config_home.php?id=<?php echo $lab_config->id; ?>'>
			<?php echo LangUtil::$generalTerms['CMD_CANCEL']; ?>
		</a>
		</small>
		&nbsp;&nbsp;&nbsp;
		<span id='worksheet_submit_progress' style='display:none;'>
			<?php $this->getProgressSpinner(LangUtil::$generalTerms['CMD_SUBMITTING']); ?>
		</span>
		<script type='text/javascript'>
		$(document).ready(function(){
			$('.test_type_checkbox').change( function() {
				toggle_mlist(this);
			});
		});

		function toggle_mlist(elem)
		{
			var target_div = elem.name+"_mlist";
			if(elem.checked == true)
			{
				$('#'+target_div).show();
			}
			else
			{
				$('#'+target_div).hide();
			}
		}
		</script>
		<?php
	}

	public function getBackupRevertRadio($field_name, $lab_config_id)
	{
		global $log;

		# Returns radio options for selecting one among existing backup directories
		$folder_list = get_backup_folders($lab_config_id);

		$zip_list = BackupLib::listServerBackups($lab_config_id);

		$backups_not_found = ($folder_list === null || count($folder_list) == 0) && count($zip_list) == 0;

		if ($backups_not_found)
		{
			echo LangUtil::$generalTerms['MSG_NOTFOUND'];
			return;
		}

		$count = 0;
		foreach($folder_list as $key=>$value)
		{
			echo "<input type='radio' id='backup-$count' name='$field_name' value='$key'";
			echo $count == 0 ? " checked>\n" : ">\n";
			echo "<label for='backup-$count'>$value</label>";
			echo "<br>\n";
			$count++;
		}

		foreach($zip_list as $backup)
		{
			echo "<input type='radio' id='backup-$count' name='$field_name' value='" .
				$backup->file_name()."'" .
				($count == 0 ? " checked " : "") .
				">" .
				"<label for='backup-$count'>" . $backup->friendlyDate() .
				"</label><br>\n";
			$count++;
		}
	}

	public function getPatientSearchCondition()
	{
		?>
        	<option value='%[pq]%'><?php echo LangUtil::getSearchCondition('SEARCH_CONTAINS'); ?></option>
			<option value='[pq]%'><?php echo LangUtil::getSearchCondition('SEARCH_BEGIN_WITH'); ?></option>
		<?php

	}

	public function getToggleTestReportsForm()
	{
		$lab_config_id = $_SESSION['lab_config_id'];
		?>

		<select id="test_list_left" name="test_list_left[]"
		multiple="multiple" size="10" style="width: 20em;">
			<?php
			$tests_without_reports = TestType::getByReportingStatus(0);
			foreach ($tests_without_reports as $test)
				echo "<option id='$test->testTypeId' value='$test->testTypeId'>".
					$test->name."</option>";
			?>
		</select>

		<select id="test_list_right" name="test_list_right[]"
		multiple="multiple" size="10" style="width: 20em;">
			<?php
			$tests_with_reports = TestType::getByReportingStatus(1);
			foreach ($tests_with_reports as $test)
				echo "<option id='$test->testTypeId' value='$test->testTypeId'>".
					$test->name."</option>";
			?>
		</select>
		<br><br>
        <input type="button" name="move_left" id="move_left" value="<"
        	onclick="javascript:moveLeft();" />
        <input type="button" name="move_right" id="move_right" value=">"
        	onclick="javascript:moveRight();" />
        <br><br>
        <input type="button" name="submit" id="submit_toggle_test_reports"
        	value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT'];?>'
        	onclick="javascript:submit_toggle_test_reports_form();" />
        <small>
        	<a href='lab_config_home.php?id=<?php echo $_SESSION['lab_config_id'] ?>'>
        		<?php echo LangUtil::$generalTerms['CMD_CANCEL']; ?>
        	</a>
        </small>

        <span id='toggle_test_reports_submit_progress' style='display:none;'>
			<?php $this->getProgressSpinner(LangUtil::$generalTerms['CMD_SUBMITTING']); ?>
		</span>

		<script type="text/javascript">
			function sort_alphabetic(element)
			{
				var options = $(element+' option');
				options.detach().sort(function(a,b) {
					var opt1 = $(a).text();
					var opt2 = $(b).text();
					return (opt1 > opt2) ? 1 : ((opt1 < opt2) ? -1 : 0);
				});
				options.appendTo(element);
			}

			function move_items(source, destination)
			{
				$(source).find(':selected').appendTo(destination);
				sort_alphabetic(source);
				sort_alphabetic(destination);
			}

			function moveRight()
			{
				move_items('#test_list_left', '#test_list_right');
			}

			function moveLeft()
			{
				move_items('#test_list_right', '#test_list_left');
			}
		</script>
		<?php
	}

	public function getPrintUnverified($lab_config)
	{
	    return LabConfig::getPrintUnverified($lab_config);
	}


	public function getTestTypesByReportingStatusOptions()
	{
	    $tests = TestType::getByReportingStatus();
//echo "<option>".$tests."</option>";
	    foreach ($tests as $test)
				echo "<option id='$test->testTypeId' value='$test->testTypeId'>".$test->name."</option>";
	}

	public function getTestTypewithreferencerangeOptions()
	{
	    $tests = TestType::getTestTypewithreferencerange();
//echo "<option>".$tests."</option>";
	    foreach ($tests as $test)
				echo "<option id='$test->testTypeId' value='$test->testTypeId'>".$test->name."</option>";
	}

	public function getTestreferencerange()
	{
	    $tests = TestType::getTestreferencerange();
	}


	//starting point of changes
	public function getBatchResultsFieldsForm($lab_config_id)
	{
		$lab_config = LabConfig::getById($lab_config_id);
		$report_config = $lab_config->getAnyWorksheetConfig();
		// echo $report_config->usePatientId, "hello";
		// echo "<br>";
		// $temp = $lab_config->getAllReportConfigs();
		// echo $report_config->reportId, "->", $report_config->testTypeId, "->",$report_config->usePatientId, "->", $report_config->headerText, "->",$report_config->useDailyNum;
		// echo "<br>";
		// echo "hihello";
		// echo "<br>";
		// foreach ($temp as $value)
		// {
		// 	echo $value['report_id'], "->", $value['test_type_id'], "->",$value['p_fields'], "->", $value['header'];
		// 	echo "<br>";
		// }
		// if()
	?>
		<table cellspacing='6px' class='smaller_font'>
		<tr valign='top'>
				<td><b><?php echo LangUtil::$generalTerms['PATIENTS']?></b></td>
				<td></td>
			</tr>
			<?php # Patient main fields ?>
			<tr valign='top'>
				<td>
					<input type='checkbox' name='p_field_0' <?php
						if($report_config->usePatientId == 1)
							echo " checked ";
						?>>
					</input>
					<?php echo LangUtil::$generalTerms['PATIENT_ID']; ?>
				</td>
				<td></td>
			</tr>
			<tr valign='top'>
				<td>
					<input type='checkbox' name='p_field_1' <?php
						if($report_config->useDailyNum == 1)
							echo " checked ";
						?>>
					</input>
					<?php echo LangUtil::$generalTerms['PATIENT_DAILYNUM']; ?>
				</td>
				<td></td>
			</tr>
			<tr valign='top'>
				<td>
					<input type='checkbox' name='p_field_2' <?php
						if($report_config->usePatientAddlId == 1)
							echo " checked ";
						?>>
					</input><?php echo LangUtil::$generalTerms['ADDL_ID']; ?>
				</td>
				<td></td>
			</tr>
			<tr valign='top'>
				<td>
					<input type='checkbox' name='p_field_3' <?php
						if($report_config->useGender == 1)
							echo " checked ";
						?>>
					</input>
					<?php echo LangUtil::$generalTerms['GENDER']; ?>
				</td>
				<td></td>
			</tr>
			<tr valign='top'>
				<td>
					<input type='checkbox' name='p_field_4' <?php
						if($report_config->useAge == 1)
							echo " checked ";
						?>>
					</input>
					<?php echo LangUtil::$generalTerms['AGE']; ?>
				</td>
				<td></td>
			</tr>
			<tr valign='top'>
				<td>
				<input type='checkbox' name='p_field_5' <?php
						if($report_config->useDob == 1)
							echo " checked ";
						?>>
					</input>
					<?php echo LangUtil::$generalTerms['DOB']; ?>
				</td>
				<td></td>
			</tr>
			<tr valign='top'>
				<td>
					<input type='checkbox' name='p_field_6' <?php
						if($report_config->usePatientName == 1)
							echo " checked ";
						?>>
					</input>
					<?php echo LangUtil::$generalTerms['NAME']; ?>
				</td>
				<td></td>
			</tr>
			<tr valign='top'>
				<td>
					<input type='checkbox' name='p_field_8' <?php
						if($report_config->usePatientRegistrationDate == 1)
							echo " checked ";
						?>>
					</input>
					<?php echo "Registration Date"; ?>
				</td>
				<td></td>
			</tr>
			<tr valign='top'>
				<td>
					<input type='button' value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>' id='batch_results_fields_submit' onclick='javascript:submit_batch_results_fields_form();'>
					</input><small>
					<a href='lab_config_home.php?id=<?php echo $lab_config->id; ?>'>
						<?php echo LangUtil::$generalTerms['CMD_CANCEL']; ?>
					</a>
					</small>
				</td>

				<td>&nbsp;&nbsp;&nbsp;
				<span id='batch_results_fields_submit_progress' style='display:none;'>
					<?php $this->getProgressSpinner(LangUtil::$generalTerms['CMD_SUBMITTING']); ?>
				</span>
				</td> <td></td>
			</tr>

		</table>

	<?php
	}
	// ending point of changes

	public 	function  getPatientFieldsOrderForm()
	{
		global $SYSTEM_PATIENT_FIELDS;
		?>
		<table cellspacing='5px' class='smaller_font'>
			<tr valign='top'>
				<td><b><?php echo LangUtil::$generalTerms['PATIENT_FIELDS']?></b></td>
                <td></td>
				<td><b><?php echo LangUtil::$generalTerms['PATIENT_ORDERED_FIELDS']?></b></td>
                <td></td>
			</tr>
			<?php # Patient main fields ?>
			<tr valign='top'>
            <td>
            <input type="hidden" id="p_fields_left" name="p_fields_left" />
            <input type="hidden" id="o_fields_left" name="o_fields_left" />
            <select id="p_fields" name="p_fields"  size="15" onchange="javascript:setSel(this);">
            <?php
			 $combined_fields =$SYSTEM_PATIENT_FIELDS;
				$lab_config = LabConfig::getById($_SESSION['lab_config_id']);
				if( $lab_config ) {
					$custom_field_list = $lab_config->getPatientCustomFields();
					foreach($custom_field_list as $custom_field)
					{
						 $custom_array = array ("p_custom_$custom_field->id" => $custom_field->fieldName);
						 $combined_fields = array_merge($combined_fields,$custom_array);

					}
				}

			$record=Patient::getReportfieldsOrder();
			if((!is_array($record)) or (is_array($record) and (strlen(trim($record["o_fields"])) ==0)))
			{
				foreach ($combined_fields as $field=>$text)
				{?>
					<option value="<?php echo $field ?>">
						<?php
						if(!stristr($field,"custom"))
							echo LangUtil::$generalTerms[$text];

						else
							echo $text;
						?></option>

				<?php
				}

			}
			else
			{
				$unordered=explode(",",$record['p_fields']);
				foreach( $unordered as $field)
				{
				?>
				<option value="<?php echo $field ?>"><?php
				if(!stristr($field,"custom"))
					echo LangUtil::$generalTerms[$combined_fields[$field]];
				else
					echo $combined_fields[$field];
					?></option>
				<?php
				}
            }
			?>

            </select>
            </td>
            <td valign="middle">
            <input type="button" name="AddOrder" id="AddOrder" value=">" disabled="disabled"  onclick="javascript:setOrder();"/>
            <input type="button" name="RemOrder" id="RemOrder" value="<" disabled="disabled"  onclick="javascript:remOrder();" />
            </td>
            <td><select id="o_fields" name="o_fields" size="15" onchange="javascript:setSel(this);">
            <?php
			if(is_array($record) and (strlen(trim($record["o_fields"]))>0))
			{
				$ordered=explode(",",$record['o_fields']);
				foreach( $ordered as $field)
				{
				?>
				<option value="<?php echo $field ?>"><?php
				if(!stristr($field,"custom"))
					echo LangUtil::$generalTerms[$combined_fields[$field]];
				else
					echo $combined_fields[$field];?></option>
			<?php
				}
            }
			?>
            </select>
            </td>
            <td valign="middle">
            <input type="button" id="o_up" name="o_up" value="Move Up"  onclick="javascript:reorder('up');"/><br />
             <input type="button" id="o_down" name="o_down" value="Move Down" onclick="javascript:reorder('down');" />
            </td>
            </tr>
            <tr>

            <td> <br />   <input type='button' value='<?php echo LangUtil::$generalTerms['CMD_SUBMIT']; ?>' id='ordered_fields_submit' onclick='javascript:submit_ordered_fields_form();'>
		</input><small>
		<a href='lab_config_home.php?id=<?php echo $lab_config->id; ?>'>
			<?php echo LangUtil::$generalTerms['CMD_CANCEL']; ?>
		</a>
		</small>
		</td>
            <td>&nbsp;&nbsp;&nbsp;
		<span id='ordered_fields_submit_progress' style='display:none;'>
			<?php $this->getProgressSpinner(LangUtil::$generalTerms['CMD_SUBMITTING']); ?>
		</span></td> <td></td>
            </tr>
            </table>

       <script type='text/javascript'>
		var selvalue;
		var seltext;
		var selIndex;
		function setSel(sel)
		{

			selvalue=sel.options[sel.selectedIndex].value;
			seltext=sel.options[sel.selectedIndex].text;
			selIndex=sel.selectedIndex;
			if($(sel).attr("name")=="p_fields")
			{
				document.getElementById("AddOrder").disabled=false;
				document.getElementById("RemOrder").disabled=true;
			}
			else
			{
				document.getElementById("RemOrder").disabled=false;
				document.getElementById("AddOrder").disabled=true;
			}
		}

		function setOrder()
		{
			var opt = document.createElement("option");
			document.getElementById("o_fields").options.add(opt);
			opt.text = seltext;
			opt.value = selvalue;
			document.getElementById("p_fields").options.remove(selIndex);
			document.getElementById("AddOrder").disabled=true;
		}

		function remOrder()
		{
			var opt = document.createElement("option");
			document.getElementById("p_fields").options.add(opt);
			opt.text = seltext;
			opt.value = selvalue;
			document.getElementById("o_fields").options.remove(selIndex);
			document.getElementById("RemOrder").disabled=true;
		}

		function reorder(direction)
		{

			var o_fields=document.getElementById("o_fields");
			var newIndex=0;

			if(direction=="up")
				newIndex=selIndex-1;
			else
				newIndex=selIndex+1;

			if(newIndex >=o_fields.options.length || newIndex < 0)
				return;

			var keys = new Array();
			var texts = new Array();
			var tempkey="";
			var temptext="";
				for(var i=0;i<o_fields.options.length;i++)
				{
					keys[i] = o_fields.options[i].value;
					texts[i] = o_fields.options[i].text;
				}

				while(o_fields.options.length>0)
				{
					o_fields.options.remove(0);
				}

				tempkey=keys[newIndex];
				temptext=texts[newIndex];

				keys[newIndex]=keys[selIndex];
				texts[newIndex]=texts[selIndex];

				keys[selIndex]=tempkey;
				texts[selIndex]=temptext;

				for(var i=0;i<keys.length;i++)
				{
					var opt = document.createElement("option");
					o_fields.options.add(opt);
					opt.text = texts[i];
					opt.value = keys[i];
				}

			o_fields.selectedIndex=newIndex;
			selIndex=newIndex;

		}
		</script>
  <?php
	}
	public function DHIMS2ConfigsForm($lab_config_id)
	{ ?>
   	<div class='pretty_box' style='width:800px;'>
   	  <table class='hor-minimalist-b'>
            <tr>
                    <th></th>
                    <th><b>Authentication:</b></th>
        </tr>
    	<tbody>
        <tr>
        <td>Username:</td>
        <td><input type="text"  name="dhims2username"  id="dhims2username"/></td>
        </tr>
        <tr>
         <td>Password:</td>
        <td><input type="password"  name="dhims2password"  id="dhims2password"/></td>

        </tr>
        <tr>
         <td></td>
        <td><input type="button" id="dhims2Authenticate" name="dhims2Authenticate" value="Authenticate" onclick="javascript:authenticateDHIMS2();" />
        	<span id='DHIMS2AuthenticateProgress' style='display:none'>
            <br />
											<?php $this->getProgressSpinner("Connecting to DHIMS2, Please wait...");
											?>

		  </span>
        </td>

        </tr>
         <tr>
         <td>Organisation Unit:</td>
        <td><select id="dhims2orgunit" name="dhims2orgunit" onchange="javascript:getDHIMS2DataSet(this.value);">
        </select><span id='DHIMS2orgunitProgress' style='display:none'>
            <br />
											<?php $this->getProgressSpinner("Connecting to DHIMS2, Please wait...");
											?>

										</span>  </td>

        </tr>
        <th></th>
          <th><b>Dataset Mapping:</b></th>
          </tr>
         <tr>
         <td>Dataset:</td>
        <td><select id="dhims2dataset" name="dhims2dataset" onchange="javascript:getDHIMS2DataElements(this.value);">
        </select><a style="display:none" id="DHIMS2datasetProgressRetry" href="javascript:getDHIMS2DataElements(null);">Retry</a><span id='DHIMS2datasetProgress' style='display:none'>
            <br />
											<?php $this->getProgressSpinner("Connecting to DHIMS2, Please wait...");
											?>

										</span> </td>

        </tr>
        <tr>
        <td>Entry Period:</td>
         <td><input type="text" name="entryperiod" id="entryperiod"  readonly="readonly"/></td>
        </tr>
       <tr><th></th>
          <th><b>DataElements Mapping:</b></th>
        </tr>
        </tbody>
        </table>
        <table class='hor-minimalist-b'>
         <tbody>
         <tr>
        <th><b>DHIMS2</b></th>
          <th colspan="2"><b>BLIS</b></th>
          </tr>
           <tr valign="middle">
         <td>DataElement:<select id="dhims2dataelement" name="dhims2dataelement" onchange="javascript:getDHIMS2CatComboOptions(this.value);">

        </select><a style="display:none" id="DHIMS2ElementProgressRetry" href="javascript:getDHIMS2CatComboOptions(null);">Retry</a><span id='DHIMS2ElementProgress' style='display:none'>
            <br />
											<?php $this->getProgressSpinner("Connecting to DHIMS2, Please wait...");
											?>

										</span> </td>
        <td valign="middle">
        <select id="blis2dataelement" name="blis2dataelement" class='uniform_width' onchange="javascript:setSelB(this);">
        <option value="">-</option>
        <?php
			$this->getTestTypesSelect($lab_config_id->id);
		?>
        </select><input type="button" id="addBlisTest" value=">" onclick="javascript:addtoBlisList();" /><input type="button" id="removeBlisTest"  onclick="javascript: remBOrder();" value="<" /></td><td>Selected:<select id="blistestSelected" name="blistestSelected" size="5" onchange="javascript: setSelB(this);">
        </select></td>
           </tr>
          <tr>
         <td>Date Range:<select id="dhims2catCombo" name="dhims2catCombo">
         </select></td>
        <td colspan="2"><select id="bliscat" name="bliscat">
        <?php
		$configArray = getTestCountGroupedConfig($lab_config_id->id);
		$ageGroups = $configArray['age_groups'];
		if(!empty($ageGroups))
		{
			$age_parts = explode(",", $ageGroups);
			foreach($age_parts as $age_part)
			{
				if(trim($age_part) == "")
					continue;
					$age_bounds = explode(":", $age_part);
					echo '<option value="'.$age_bounds[0]."-".$age_bounds[1].'">'.$age_bounds[0]."-".$age_bounds[1].'</option>';
			}
		}
		?>
        </select>

        Sex:<input type="text" id="blisgender" name="blisgender" size="1" value="B" /><input type="button" id="addtolist" name="addtolist" value="Apply"  onclick="javascript:AddnewDHIMS2Config();" disabled="disabled"/><span id='DHIMS2ApplyProgress' style='display:none'>
											<?php $this->getProgressSpinner(LangUtil::$generalTerms['CMD_SUBMITTING']);
											?>
										</span>
         <input type="hidden" name="dhims2orgunit_text"  id="dhims2orgunit_text" />
         <input type="hidden" name="dhims2dataset_text" id="dhims2dataset_text" />
         <input type="hidden" name="dhims2dataelement_text" id="dhims2dataelement_text" />
         <input type="hidden" name="blis2dataelement_text" id="blis2dataelement_text" />
         <input type="hidden" name="dhims2catCombo_text" id="dhims2catCombo_text" />
         <input type="hidden" name="lid" id="lid" value="<?php echo $lab_config_id->id?>" />
        </td>

        </tr>
        <tr>
        <td colspan="3"><?php $this->getDHIMSConfigs($lab_config_id->id);?></td>
        </tr>
          <tr>
         <td colspan="3" align="center"><a href="javascript:toggle_DHIMS2();"><?php echo LangUtil::$generalTerms['CMD_CANCEL']; ?></a></td>

        </tr>
         </tbody>
        </table>
    </div>
	<?php
	}


	public function getDHIMSConfigs($lab_config_id)
	{
		?>
        <script type='text/javascript'>
		var selvalue;
		var seltext;
		var selIndex;
		function setSelB(sel)
		{
			selvalue=sel.options[sel.selectedIndex].value;
			seltext=sel.options[sel.selectedIndex].text;
			selIndex=sel.selectedIndex;
		}
		function addtoBlisList()
		{
			 if (isNaN(parseInt(selvalue)))
				return;

			var opt = document.createElement("option");
			document.getElementById("blistestSelected").options.add(opt);
			opt.text = seltext;
			opt.value = selvalue;
			//document.getElementById("p_fields").options.remove(selIndex);
			//document.getElementById("AddOrder").disabled=true;
		}

		function remBOrder()
		{
			if (isNaN(parseInt(selvalue)))
				return;
			//var opt = document.createElement("option");
			//document.getElementById("p_fields").options.add(opt);
			//opt.text = seltext;
			//opt.value = selvalue;
			document.getElementById("blistestSelected").options.remove(selIndex);
			//document.getElementById("remBOrder").disabled=true;
		}
		var zTree, rMenu;
		$(document).ready(function(){
			showTree();
			zTree = $.fn.zTree.getZTreeObj("treeDemo");
			rMenu = $("#rMenu");

		});

		function showTree()
		{
			//alert("here");
			var setting = {
				check: {
					enable: true
				},
				async: {
					enable: true,
					url:"ajax/getDHIMS2Config.php",
					autoParam:["id", "name=n", "level=lv"],
					otherParam:{"l":"<?php echo $lab_config_id ?>"}
				},
				callback: {
					onRightClick: OnRightClick
				},
				data: {
					simpleData: {
						enable: true
					}
				}
			};

			try{
				$.fn.zTree.init($("#treeDemo"), setting);
				$.fn.zTree.init($("#treeDemo2"), setting);
			}catch(err){ alert(err.message);}
		}

function OnRightClick(event, treeId, treeNode) {
			if (!treeNode && event.target.tagName.toLowerCase() != "button" && $(event.target).parents("a").length == 0) {
				zTree.cancelSelectedNode();
				showRMenu("root", event.pageX, event.pageY);
			} else if (treeNode && !treeNode.noR) {
				zTree.selectNode(treeNode);
				showRMenu("node", event.pageX, event.pageY);
			}
		}

		function showRMenu(type, x, y) {
			$("#rMenu ul").show();
			if (type=="root") {
				$("#m_del").hide();
				$("#m_check").hide();
				$("#m_unCheck").hide();
			} else {
				$("#m_del").show();
				$("#m_check").show();
				$("#m_unCheck").show();
			}
			rMenu.css({"top":y+"px", "left":x+"px", "visibility":"visible"});

			$("body").bind("mousedown", onBodyMouseDown);
		}
		function hideRMenu() {
			if (rMenu) rMenu.css({"visibility": "hidden"});
			$("body").unbind("mousedown", onBodyMouseDown);
		}
		function onBodyMouseDown(event){
			if (!(event.target.id == "rMenu" || $(event.target).parents("#rMenu").length>0)) {
				rMenu.css({"visibility" : "hidden"});
			}
		}
		var addCount = 1;
		function addTreeNode() {
			hideRMenu();
			var newNode = { name:"newNode " + (addCount++)};
			if (zTree.getSelectedNodes()[0]) {
				newNode.checked = zTree.getSelectedNodes()[0].checked;
				zTree.addNodes(zTree.getSelectedNodes()[0], newNode);
			} else {
				zTree.addNodes(null, newNode);
			}
		}
		function removeTreeNode() {
			hideRMenu();
			var nodes = zTree.getSelectedNodes();
			if (nodes && nodes.length>0) {
				if (nodes[0].children && nodes[0].children.length > 0) {
					var msg = "Deleting this node will also delete all sub-nodes under it. \n\nPlease confirm!";
					//alert(nodes[0].ename);
					if (confirm(msg)==true){
						//zTree.removeNode(nodes[0]);
						prepareDeleteList(nodes[0]);
						deleteItems();
						getDHIMS2CatComboOptions(null);
					}
				} else {
					//zTree.removeNode(nodes[0]);
					prepareDeleteList(nodes[0]);
					deleteItems();
					getDHIMS2CatComboOptions(null);
				}
			}
		}

		var listtodelete="";

		function prepareDeleteList(node)
		{
			if (node.children && node.children.length > 0)
			{
				for(var i=0; i<node.children.length;i++)
				{
					prepareDeleteList(node.children[i]);
				}
			}
			else
			{
				if(listtodelete.length > 0)
					listtodelete = listtodelete +","+node.ename;
				else
					listtodelete = node.ename;
			}
		}

		function deleteItems()
		{
			//alert(listtodelete);
			var url_string = "ajax/deleteDHIMS2Config.php?items="+listtodelete+"&l=<?php echo $lab_config_id ?>";
			$.ajax({ url: url_string, async: false, success: function() {
				listtodelete ="";
				resetTree();
			}});
		}

		function resetTree() {
			hideRMenu();
			showTree();
		}

		function hideNodes()
		{
			var zTree = $.fn.zTree.getZTreeObj("treeDemo");
			var nodes = zTree.getNodes();
			for(var i=0;i<nodes.length;i++)
			{
				zTree.hideNodes(nodes[i].children);
				zTree.hideNode(nodes[i]);
			}
		}

		function showNodes()
		{
			var zTree = $.fn.zTree.getZTreeObj("treeDemo");
			var nodes = zTree.getNodes();
			for(var i=0;i<nodes.length;i++)
			{
				zTree.showNodes(nodes[i].children);
			}
		}
		function clearsearch()
		{
			//var value = $('#listSearch').attr('value');
			$('#listSearch').attr('value','');
		}

		function searchList(value)
		{
			hideNodes();
			var zTree = $.fn.zTree.getZTreeObj("treeDemo");
			var	nodeList = [];
			var node;
			var value = value;
			var keyType = "name";
			nodeList = zTree.getNodesByParamFuzzy(keyType, value);
			for(var i=0;i<nodeList.length;i++)
			{
				showNode(nodeList[i]);
			}

		}

		function showNode(node)
		{
			var flag = false;
			try{
				var nodeParent = node.getParentNode();
				flag = true;
			}catch(err){ nodeParent = "";}
			var zTree = $.fn.zTree.getZTreeObj("treeDemo");
			zTree.showNode(node);
			if(flag)
			{
				//alert("hasParent");
				showNode(nodeParent);
			}
		}


		function resetsearch()
		{
			var value = $('#listSearch').attr('value');
			if(value.length == 0)
			{
				$('#listSearch').attr('value','Search here');
				showNodes();
			}

		}
		</script>

        <table class='tablesorter' id='dhims_config_list'  style='width:750px'>
	<thead>
    <tr align='left'>
    <th colspan="4"><b>Saved Interface mappings</b>&nbsp;&nbsp;(Right click on item to delete or show details)&nbsp;&nbsp;
    <input type="text" id="listSearch" name="listSearch" value="Search here" onclick="javascript:clearsearch();" onkeyup="javascript:searchList(this.value);" onblur="javascript:resetsearch();" /> </th>

    </tr>
    </thead>
    <tbody>
    <tr align='left'>
    <td colspan="4"><ul id="treeDemo" class="ztree"></ul></td>
    </tr>
    </tbody>
    </table>
    <link rel="stylesheet" href="css/popoupmenu/style.css" type="text/css" />
    <style type="text/css">._css3m{display:none}</style>
    <style type="text/css">
div#rMenu {position:absolute; visibility:visible; top:0;}
div#rMenu ul li{
	cursor: pointer;
	list-style: none outside none;
}

	</style>

    <div id="rMenu">
	<ul id="css3menu1">
	<ul>
		<li><a href="javascript:removeTreeNode();">Delete Node</a></li>
		<li class="sublast"><a href="javascript:resetTree();">Refresh Tree</a></li>

	</ul>
</ul>
</div>

        <?php
	}
	public function DHIMS2ConfigsSummary($lab_config_id)
	{ ?>
    	<div class='pretty_box' style='width:750px;'>
		  <table class='tablesorter' id='dhims_config_list'  style='width:750px'>
			<thead>
    			<tr align='left'>
    			<th colspan="4"><b>Saved Interface mappings</b></th>
    			</tr>
    		</thead>
    		<tbody>
    			<tr align='left'>
    			<td colspan="4"><ul id="treeDemo2" class="ztree"></ul></td>
    			</tr>
    		</tbody>
    	  </table>
   		</div>
	<?php
	}


	public function getEquipmentList()
	{
		# Returns a set of drop down options for equipment List
		$list = getEquipmentList();
		if(is_array($list) && count($list) > 0)
		{
			foreach($list as $Equipment)
			{
				echo "<option value='".$Equipment['id']."'>".$Equipment['equipment_name']."</option>";
			}
		}

	}


public function gettestRangeStatsTable($test_range_count)
	{
		# Returns HTML table showing number of tests performed
		# Called from reports_tests_done.php
		?>
		<script type='text/javascript'>
		$(document).ready(function(){
			$('#testsdone_table').tablesorter();
		});
		</script>
		<table class='tablesorter' id='testsdone_table' style='width:500px'>
		<thead>
			<tr>
				<!--<th><?php echo LangUtil::$generalTerms['TEST_TYPE']; ?></th>-->
				<th> Test Type </th>
				<th> Below Lower Range</th>
				<th> In Range</th>
				<th> Above Upper Range</th>
			</tr>
		</thead>
		<tbodys>
			<?php
			$below_range=$test_range_count['BELOW_LOWER_RANGE'];
			$in_range = $test_range_count['IN_RANGE'];
			$above_high_range=$test_range_count['ABOVE_HIGH_RANGE'];
			$tt= $test_range_count['TEST_TYPE'];
			?>
			<tr>
			<td><?php echo $tt; ?></td>
			<td><?php echo $below_range; ?></td>
			<td><?php echo $in_range; ?></td>
			<td><?php echo $above_high_range; ?></td>
			</tr>
			<?php
		?>
		</tbody>
		</table>
		<?php
	}
}

if(session_id() == "")
	session_start();
?>
