<script language=php>

$fields_p = $_POST['fields_p'];

if ( $fields_p['login']=="" ) $lastError .= "Please Choose a Sign in ID.<br>";
if ( $fields_p['password']=="" ) $lastError .= "Please Choose a password.<br>";
if ( $fields_p['password'] != $_POST['rpassword'] ) $lastError .= "Passwords do not match, please try again.<br>";
// if ( $_POST['agree'] != "Y" ) $lastError .= "You must be over 18 years of age and You must agree to the Terms of use and Privacy Policy.<br>";

$tr = $db->mysqlFetchRow(" SELECT id FROM members WHERE login='{$fields_p['login']}' ");
if($tr) $lastError .= "This login ID<b> {$fields_p['login']} </b>is already in use. Please select other login ID<br>";

if ($fields_p['notify']=="") $fields_p['notify'] = "N";

if ($lastError=="")
{
	if (intval($fields_p['id'])<=0)
	{
		$fields_p['edate'] = date("YmdHis");
	}

	$db->mysqlAddUpdateRow("members",$fields_p,"id");
	$id = mysql_insert_id();

	$glemail = $fields_p['login'];
	$gpwd = $fields_p['password'];
	validate_session();
	
	// Now add 1000 points for him
	$pv = array();

	$pv['mid'] = $id;
	$pv['edate'] = date("YmdHis");
	$pv['points'] = 1000;
	$pv['game'] = "R";
	$db->mysqlAddUpdateRow("points",$pv);
}
</script>