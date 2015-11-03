<script language=php>
	if (!empty($_GET)) {
	    while(list($name, $value) = each($_GET)) {
	        $$name = $value;
	    }
	}

	if (!empty($_POST)) {
	    while(list($name, $value) = each($_POST)) {
	        $$name = $value;
	    }
}

	require("functions.php");
	require("poker_video.php");
	validate_session();

	if ($redir!="")
	{
		header("Location: $redir");
		exit;
	}

	if ($act=="logo") logout_user();

	$qstr = "";

	$rfile = "";
	$redir = "";

	require("content.php");

	if ($redir!="")
	{
		header("Location: $redir");
		exit;
	}

//	if($rfile=="poker_holdem_html.php")
//	{
//		require($rfile);
//		exit;
//	}

</script>

<HTML>
<HEAD>
	<TITLE>Play Poker Here Its FREE</TITLE>
	<META http-equiv=Content-Type content="text/html; charset=windows-1252">
	<link href="styles.css" rel="stylesheet" type="text/css" />
</HEAD>
<BODY topmargin=0 background="images/red_poker_bg.png">
<CENTER>
<TABLE cellSpacing=0 cellPadding=0 width=961 border=0 height=104>
  <TR>
    <TD width=11></TD>
    <TD width=130 bgColor=#008000 height=104 background="images/poker-sam.PNG">&nbsp;</TD>
    <TD vAlign=top align=left width=690 bgColor=#008000>
      <TABLE height=100% cellSpacing=4 cellPadding=0 width="100%" border=0>
        <TR>
          <TD height=21><B><FONT face=Verdana size=4><FONT
            color=#00ccff>FreeFastPoker.com</FONT><BR></FONT><FONT face=Verdana
            color=#ffff00 size=1>Simplest, Safest and Fastest POKER EVER !!!</FONT></B>
					</TD>
					<td width="1" bgcolor="#969696"><img height="1" src="images/blanker.gif" width="1" border="0"></td>
					<td>
						<font face="tahoma" color="#CCCC00"><b>WWW.FREEFASTPOKER.COM</b><BR></font>
						<font face="tahoma" color="white" size="2">The only website that lets you play poker for FREE from anywhere.<br>
						<b>No email - No downloads - No trace - Instant Play </b></font>
					</td>
				</TR>
			</TABLE>
		</TD>
    <TD width=130 bgColor=#008000><IMG src="images/green_top_bg.jpg" border=0></TD>
	</TR>
</TABLE>

<? if($rfile=="home.php"): show_lasterror(); require($rfile); ?>
<? else: ?>
<TABLE cellSpacing=0 cellPadding=0 width=961 border=0>
  <TR>
    <TD width=11></TD>
	  <TD width=950 bgcolor="#efefef" background="images/gray-bg.png">
			<table bordercolor="#008000" cellspacing="0" cellpadding="8" width="100%" border="1">
				<tr>
					<td width="100%">
						<? show_lasterror(); require($rfile); ?>
					</td>
				</tr>
			</table>
		</TD>
	</tr>
</table>
<? endif; ?>

<TABLE cellSpacing=0 cellPadding=0 width=961 border=0>
  <TR>
    <TD width=11></TD>
    <TD width=950 bgcolor=#008000 height=25 ></TD></TR>
  <TR>
    <TD></TD>
    <TD class=bodytext align=middle height=25>
			<STRONG>
				<FONT face=Verdana color=#ffffff size=1>
				<A style="COLOR: #ffffff" href="http://poker.takniki.com/">Home</A>&nbsp;&nbsp;|&nbsp;&nbsp;
				<? if(!$guserid): ?>
				<A style="COLOR: #ffffff" href="<? echo my_url("register"); ?>">Register</A>&nbsp;&nbsp;|&nbsp;&nbsp;
				<? else: ?>
				<A style="COLOR: #ffffff" href="<? echo my_url("logout"); ?>">Logout</A>&nbsp;&nbsp;|&nbsp;&nbsp;
				<? endif; ?>
				<A style="COLOR: #ffffff" href="<? echo my_url("mac"); ?>">My Account</A>
				</FONT>
			</STRONG>

      <P align=center><STRONG>
			<FONT face=Verdana size=1>
				Legal Disclaimer&nbsp;&nbsp;
				<FONT class=textvolite>|</FONT>&nbsp;&nbsp;FAQ&nbsp;&nbsp;
				<FONT class=textvolite>|</FONT>&nbsp;&nbsp;Privacy Policy&nbsp;&nbsp;
				<FONT class=textvolite>|</FONT>&nbsp;&nbsp;Terms Of Use&nbsp;&nbsp;
				<FONT class=textvolite>|</FONT>&nbsp;&nbsp;Contact us
			</FONT></STRONG></P>
			</TD></TR>
  <TR>
    <TD></TD>
    <TD class=bodytext align=middle height=35>
      <P align=center><FONT face=Verdana color=#008000 size=2><B>&nbsp;© 2008-2010 - FreeFastPoker.com</B></FONT></P>
		</TD>
	</TR>
</TABLE>

</CENTER>
</BODY></HTML>
