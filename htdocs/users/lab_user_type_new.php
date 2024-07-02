<?php
#
# (c) C4G, Santosh Vempala, Ruban Monu and Amol Shintre
# Main page for adding new lab user account
# Called from lab_config_home.php
#

include(__DIR__ . "/../users/accesslist.php");
if( !(isAdmin(get_user_by_id($_SESSION['user_id'])) && in_array(basename($_SERVER['PHP_SELF']), $adminPageList)) 
     && !(isCountryDir(get_user_by_id($_SESSION['user_id'])) && in_array(basename($_SERVER['PHP_SELF']), $countryDirPageList)) 
	 && !(isSuperAdmin(get_user_by_id($_SESSION['user_id'])) && in_array(basename($_SERVER['PHP_SELF']), $superAdminPageList)) ) {
		header( 'Location: home.php' );
}

include("redirect.php");
include("includes/page_elems.php");
include("includes/script_elems.php");
LangUtil::setPageId("lab_config_home");

$script_elems = new ScriptElems();
$page_elems = new PageElems();
$reload_url = $_REQUEST['ru']."&show_u=1";
$lab_config_id = $_REQUEST['lid'];
?>
<script type="text/javascript">
function add_lab_user()
{
	var username = $('#lab_user').attr('value');
	var pwd = $('#pwd').attr('value');
	var email = $('#email').attr('value');
	var phone = $('#phone').attr('value');
	var fullname = $('#fullname').attr('value');
	var ut = $('#user_type').attr('value');
	var lang_id = $('#lang_id').attr("value");
	var showpname = 0;
	if($('#showpname').is(":checked"))
	{
		showpname = 1;
	}
	/*
	var fn_regn = 0;
	var fn_results = 0;
	var fn_reports = 0;
	if
	(
		$('#fn_regn').is(":checked") == false &&
		$('#fn_results').is(":checked") == false &&
		$('#fn_reports').is(":checked") == false
	)
	{
		$('#error_msg').html("<?php echo LangUtil::$generalTerms['ERROR'].": ".$generalTerms['USER_FUNCTIONS']; ?>");
		$('#error_msg').show();
	}
	if($('#fn_regn').is(":checked"))
	{
		fn_regn = 1;
	}
	if($('#fn_results').is(":checked"))
	{
		fn_results = 1;
	}
	if($('#fn_reports').is(":checked"))
	{
		fn_reports = 1;
	}
	*/
	if(username == "" || pwd == "")
	{
		document.getElementById('error_msg').innerHTML="<?php echo LangUtil::$generalTerms['TIPS_INCOMPLETEINFO']; ?>";
		$('#error_msg').show();
		return;
	}

	// Begin email address test
	var email_regex = new RegExp(/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/i);

	if(!email_regex.test(email) && !(email == '')) {
		alert("Invalid email supplied.  Please enter an email in the form abcd@efgh.ijk or leave the field blank.");
		return;
	}
	// End email address test

	// readwriteOption = $('#readwriteOpt:checked').length;
    var readwriteOption = 0;
    var rwoptions = ',';
    
	$('input[name="readwriteOpt"]:checked').each(function() {
		readwriteOption++;
		rwoptions = rwoptions + this.value+','  ; 
	});

	rwoptions = rwoptions.slice(1,-1);
	
	if(readwriteOption < 1){
		alert("Select at least one read or write options");
		return;
	}

	$('#error_msg').hide();
	var url_string = 'ajax/lab_user_add.php';
	//var data_string = 'u='+username+'&p='+pwd+'&fn='+fullname+'&em='+email+'&ph='+phone+'&ut='+ut+'&lid=<?php echo $lab_config_id; ?>&lang='+lang_id+"&fn_reports="+fn_reports+"&fn_results="+fn_results+"&fn_regn="+fn_regn;
	var data_string = 'u='+username+'&p='+pwd+'&fn='+fullname+'&em='+email+'&ph='+phone+'&ut='+ut+'&lid=<?php echo $lab_config_id; ?>&lang='+lang_id+"&showpname="+showpname+"&opt="+rwoptions;
	$('#add_user_progress').show();
	$.ajax({
		type: "POST",
		url: url_string,
		data: data_string,
		success: function(msg) {
			document.getElementById('server_msg').innerHTML="<small>"+msg+"</small>";
			$('#add_user_progress').hide();
			$('#form_table').hide();
			$('#server_msg').show();
			window.location="<?php echo $reload_url; ?>&aadd="+username;
		}
	});
}
function add_user_type(){
	var typename = $('#lab_user_type').attr('value');
	var showpname = 0;
	if($('#showpname').is(":checked"))
	{
		showpname = 1;
	}

	if(typename == "")
	{
		document.getElementById('error_msg').innerHTML="<?php echo LangUtil::$generalTerms['TIPS_INCOMPLETEINFO']; ?>";
		$('#error_msg').show();
		return;
	}
	var readwriteOption = 0;
    var rwoptions = ',';
    
	$('input[name="readwriteOpt"]:checked').each(function() {
		readwriteOption++;
		rwoptions = rwoptions + this.value+','  ; 
	});

	rwoptions = rwoptions.slice(1,-1);
	
	if(readwriteOption < 1){
		alert("Select at least one read or write option");
		return;
	}
	$('#error_msg').hide();
	//Add to user_type table and return the id
	var data_string = 'u='+typename+'&d='+showpname+'&rw='+rwoptions;
	$.ajax({
		type: "POST",
		url: 'ajax/lab_user_type_add.php',
		data: data_string,
		success: function(msg) {
			window.location="<?php echo $reload_url; ?>&aaddtype="+typename+"&typeflag="+msg;
		}
	});

}

function add_read_mode(){
	var usermode = $('select[name="user_type"]').val();
	if(usermode == 16){
		$("#readOrWrite").empty();
		$("#readOrWrite").append("Read Options");

		$("#readWrite_options").empty();
		$("#readWrite_options").append("<input type='checkbox' name='readwriteOpt' id='readwriteOpt' value='51'>Select Test - option<br><input type='checkbox' id='readwriteOpt' name='readwriteOpt' value='52'>Generate Bill - option");
	} /*else if(usermode == 15){
		$("#readOrWrite").empty();
		$("#readOrWrite").append("Selected Write Options");
		$("#readWrite_options").empty();
		$("#readWrite_options").append("<input type='checkbox' name='readwriteOpt' id='readwriteOpt3' value='3'>Test Results<br><input type='checkbox' name='readwriteOpt' id='readwriteOpt4' value='4'>Search<br>");
		checkAllReadWriteOptions();
	} else if(usermode == 6){
		$("#readOrWrite").empty();
		$("#readOrWrite").append("Selected Read Options");
		$("#readWrite_options").empty();
		$("#readWrite_options").append("<input type='checkbox' name='readwriteOpt' id='readwriteOpt2' value='2'>Patient Registration<br><input type='checkbox' name='readwriteOpt' id='readwriteOpt3' value='3'>Test Results<br><input type='checkbox' name='readwriteOpt' id='readwriteOpt4' value='4'>Search<br>");
		checkAllReadWriteOptions();
	}*/ else {
		$("#readOrWrite").empty();
		$("#readOrWrite").append("Write Options");
		$("#readWrite_options").empty();
		$("#readWrite_options").append("<input type='checkbox' name='readwriteOpt' id='readwriteOpt2' checked='true' value='2'>Patient Registration<br><input type='checkbox' name='readwriteOpt' id='readwriteOpt3' value='3'>Test Results<br><input type='checkbox' name='readwriteOpt' id='readwriteOpt4'  checked='true' value='4'>Search<br><input type='checkbox' name='readwriteOpt' id='readwriteOpt6' value='6'>Inventory<br><input type='checkbox' name='readwriteOpt' id='readwriteOpt7' value='7'>Backup Data <br>");
	}
	if(usermode!=17) {
		checkAllReadWriteOptions();
	}
	if(usermode==17){
			$("#patient-entry").hide();
			$("#patient-entry_check").hide();
}
	else
	{
		$("#patient-entry").show();
		$("#patient-entry_check").show();
	}
}

function checkAllReadWriteOptions(){
	checkboxes = document.getElementsByName('readwriteOpt');
	  for(var i=0, n=checkboxes.length;i<n;i++) {
	    checkboxes[i].checked = true;
	  }
}

$(document).ready(function(){
		checkAllReadWriteOptions();
});

</script>

<table cellspacing="20px">
<tr>
<td>

<b><?php echo "New Lab User Type"; ?></b>
<br><br>
<form name='admin_ops' action='ajax/lab_user_type_add.php' method='post'>
	<table id='form_table' width = "500px">
		<tr>
			<td><?php echo LangUtil::$generalTerms['NAME']; ?><?php $page_elems->getAsterisk(); ?></td>
			<td><input name='u' id='lab_user_type' type='text' class='uniform_width' /></td>
		</tr>
		<tr valign='top'>
			<td>Display by default</td>
			<td>
				<div id="patient-entry_check"><input type="checkbox" name="d" id="showpname" /><?php echo LangUtil::$generalTerms['YES']; ?>
			</div></td>
		</tr>

		<tr valign='middle'>
			<td> <div id="readOrWrite" name="readOrWrite" > Writeable Options </div><?php $page_elems->getAsterisk(); ?>
		 	</td>
		 	<td><div id="readWrite_options" name="readWrite_options">
		 		
					<input type="checkbox" name="readwriteOpt" id='readwriteOpt2' value="2">Patient Registration<br>
					<input type="checkbox" name="readwriteOpt" id='readwriteOpt3' value="3">Test Results<br>
					<input type="checkbox" name="readwriteOpt" id='readwriteOpt4' value="4">Search<br>
					<input type="checkbox" name="readwriteOpt" id='readwriteOpt6' value="6">Inventory<br>
					<input type="checkbox" name="readwriteOpt" id='readwriteOpt7' value="7">Backup Data <br>
				
				</div>
		 	</td>
		</tr>
		<tr>
			<td></td>
			<td>
				<br>
				<input value='<?php echo LangUtil::$generalTerms['CMD_ADD']; ?>' type='button' onclick="javascript:add_user_type();" />
				&nbsp;&nbsp;&nbsp;
				<span id='add_user_progress' style='display:none'>
					<?php $page_elems->getProgressSpinner(LangUtil::$generalTerms['CMD_SUBMITTING']); ?>
				</span>
			</td>
		</tr>
		<tr>
			<td></td>
			<td>
				<span id='error_msg' class='error_string'>
				</span>
			</td>
		</tr>
	</table>
</form>
<span id='server_msg' style='display:none;'>
</span>
</td>
</tr>
</table>
