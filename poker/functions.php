<script language=php>
error_reporting(E_ALL ^ E_NOTICE);
ini_set("display_errors","1");

require("CDatabase.php");
$db = new CDatabase($dbhost,$dbuser,$dbpass,$dbname);

function validate_session()
{
	global $db, $session_timeout,$login_error,$guserid,$lastError,$glemail,$gpwd;
	session_start();
	
	if($glemail=="") $glemail=$_POST['lemail'];
	if($gpwd=="") $gpwd=$_POST['pwd'];

	if ($glemail!="" && $gpwd!="") 
	{
		$user = $db->mysqlEscapeString($glemail);
		$pwd = $db->mysqlEscapeString($gpwd);
		$sql = sprintf("SELECT * FROM members WHERE login='%s' AND password='%s'",$user ,$pwd);
		$row = $db->mysqlFetchRow($sql);
		if ($row)
		{
			$ssid = uniqid("");
			$sn = $ssid;

			@mysql_query(" UPDATE members SET did = '$ssid' WHERE login='$user' AND password ='$pwd' ");

			//destroy any previous session for security reason
			unset($_SESSION['login']);
			unset($_SESSION['sn']);
			unset($_SESSION['last_time']);
			session_destroy();

			session_start();
			$_SESSION['login'] = $glemail;
			$_SESSION['sn'] = $sn;
			$_SESSION['last_time'] = time();
			$guserid = $row['id'];

			return 1;
		} 
		else
		{
			$login_error = "invalid";
			$lastError = "Invalid username or bad password. Please try again.";
		}
	}
	elseif( isset($_SESSION['login']) && isset($_SESSION['sn']) )
	{
		$user = $db->mysqlEscapeString($_SESSION['login']);
		$sn = $db->mysqlEscapeString($_SESSION['sn']);

		$sql = sprintf("SELECT * FROM members WHERE login='%s' AND did='%s'", $user,$sn);
		$row = $db->mysqlFetchRow($sql);
		if ($row)
		{
			if( isset($_SESSION['last_time']) && (time() - $_SESSION['last_time']) > $session_timeout )
			{
				unset($_SESSION['login']);
				unset($_SESSION['sn']);
				unset($_SESSION['last_time']);
				session_destroy();
				$login_error = "timeout";
			}
			else 
			{
				$_SESSION['last_time'] = time();
				$guserid = $row['id'];
			}
		} 
		else 
		{
			unset($_SESSION['login']);
			unset($_SESSION['sn']);
			unset($_SESSION['last_time']);
			session_destroy();
			$login_error = "sinvalid";
			$lastError = "Invalid login session.";
		}
	}
	else 
	{
		unset($_SESSION['login']);
		unset($_SESSION['sn']);
		unset($_SESSION['last_time']);
		$guserid = "";
		$login_error = "nologin";
	}
}

function logout_user()
{
	unset($_SESSION['login']);
	unset($_SESSION['sn']);
	unset($_SESSION['last_time']);
	@session_destroy();
	header('Location: main.php');
	exit();
}

function hidden_field($name,$value="")
{
	echo "<input type=hidden name=$name value=\"$value\">\r\n";
}

function show_error($err)
{
	if ($err=="") return;
	echo "<p class=\"err_txt\">$err</p>\r\n";
}

function show_message($err)
{
	echo "<p class=\"msg_txt\">$err</p>\r\n";
}

function show_lasterror()
{
	global $lastError;
	show_error($lastError);
	$lastError="";
}

function my_url($act,$sact="",$extra="")
{
	$url = "main.php?act=$act";
	if ($sact!="") $url .= "&sact=$sact";
	$url .= $extra;
	return $url;
}

function my_json_encode($var)
{
	if ( gettype($var)!="string" ) $var = strval($var);

	$ascii = '';
	$strlen_var = strlen($var);

	/*
	* Iterate over every character in the string,
	* escaping with a slash or encoding to UTF-8 where necessary
	*/

	for ($c = 0; $c < $strlen_var; ++$c) 
	{
		$ord_var_c = ord($var{$c});
		switch (true) 
		{
			case $ord_var_c == 0x08:
					$ascii .= '\b';
					break;
			case $ord_var_c == 0x09:
					$ascii .= '\t';
					break;
			case $ord_var_c == 0x0A:
					$ascii .= '\n';
					break;
			case $ord_var_c == 0x0C:
					$ascii .= '\f';
					break;
			case $ord_var_c == 0x0D:
					$ascii .= '\r';
					break;

			case $ord_var_c == 0x22:
			case $ord_var_c == 0x2F:
			case $ord_var_c == 0x5C:
					// double quote, slash, slosh
					$ascii .= '\\'.$var{$c};
					break;

			case (($ord_var_c >= 0x20) && ($ord_var_c <= 0x7F)):
					// characters U-00000000 - U-0000007F (same as ASCII)
					$ascii .= $var{$c};
					break;
		}
	}

	return $ascii;
}

</script>