<script language=php>

//echo "ACT:$act BACT:$sact BACTN:$bactN<br>";
	
	if ($act=="") $act="home";

	if($act=='home') $rfile="home.php";
	elseif($act=='register')
	{
		$rfile="register.php";
		if($sact=="save")
		{
			require("register_save.php");
			if($lastError=="") $redir = my_url("mac");
		}
	}	
	elseif($act=='logout')
	{
		logout_user();
	}
	else
	{
		if($guserid=="") $rfile="home.php";
		elseif($act=='video')
		{
			$rfile="poker_video_deal.php";
			if($sact=="bet")
			{
				require("poker_video_bet.php");
				if($lastError=="") $redir = my_url("video");
			}
		}
		elseif($act=='holdem') $rfile="poker_holdem_html.php";
		elseif($act=='mac')
		{
			$rfile="welcome.php";
		}
		else
		{
			$rfile="welcome.php";
		}
	}

	if ($rfile=="" && $redir=="")
	{
		$redir = "main.php?$qstr&act=home";
	}
</script>