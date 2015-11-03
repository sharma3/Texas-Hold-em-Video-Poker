<script language=php>
	function player_hrml($n)
	{
		if($n==1 || $n==2 || $n==3)
		{
			echo '
				<table border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td>
							<table border="0" width="100%" cellspacing="0" cellpadding="0">
								<tr><td height=22><div id="nick_name'.$n.'" class="nick_name"></div><div id="table_stack'.$n.'" class="table_stack"></td></tr>
								<tr><td width="100%"><div id="avtar'.$n.'" class="avtar"><img src="images/animal'.$n.'.png"></div></td></tr>
								<tr><td>
									<table>
										<tr>
											<td align="center"><div id="dealer'.$n.'" class="dealer"></td>
											<td><div id="current_share'.$n.'" class="current_share"></div></td>
										</tr>
									</table>
								</td></tr>
							</table>
						</td>
						<td valign=top><div id="pocket_cards'.$n.'1" class="pocket_cards1"></div></td>
						<td valign=top><div id="pocket_cards'.$n.'2" class="pocket_cards2"></div></td>
					</tr>
				</table>
			';
		}
		elseif($n==5 || $n==6 || $n==7)
		{
			echo '
				<table border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td>
							<table border="0" width="100%" cellspacing="0" cellpadding="0">
								<tr><td>
									<table>
										<tr>
											<td align="center"><div id="dealer'.$n.'" class="dealer"></td>
											<td><div id="current_share'.$n.'" class="current_share"></div></td>
										</tr>
									</table>
								</td></tr>
								<tr><td width="100%"><div id="avtar'.$n.'" class="avtar"><img src="images/animal'.$n.'.png"></div></td></tr>
								<tr><td height=22><div id="nick_name'.$n.'" class="nick_name"></div><div id="table_stack'.$n.'" class="table_stack"></td></tr>
							</table>
						</td>
						<td valign=bottom><div id="pocket_cards'.$n.'1" class="pocket_cards1"></div></td>
						<td valign=bottom><div id="pocket_cards'.$n.'2" class="pocket_cards2"></div></td>
					</tr>
				</table>
			';
		}
		elseif($n==4)
		{
			echo '
				<table border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td>
							<table border="0" width="100%" cellspacing="0" cellpadding="0">
								<tr>
									<td valign=top><div id="pocket_cards'.$n.'1" class="pocket_cards1"></div></td>
									<td valign=top><div id="pocket_cards'.$n.'2" class="pocket_cards2"></div></td>
								</tr>
								<tr>
									<td align="center"><div id="dealer'.$n.'" class="dealer"></td>
									<td><div id="current_share'.$n.'" class="current_share"></div></td>
								</tr>
							</table>
						</td>
						<td>
							<table border="0" width="100%" cellspacing="0" cellpadding="0">
								<tr><td width="100%"><div id="avtar'.$n.'" class="avtar"><img src="images/animal'.$n.'.png"></div></td></tr>
								<tr><td height=22><div id="nick_name'.$n.'" class="nick_name"></div><div id="table_stack'.$n.'" class="table_stack"></td></tr>
							</table>
						</td>
					</tr>
				</table>
			';
		}
		elseif($n==8)
		{
			echo '
				<table border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td>
							<table border="0" width="100%" cellspacing="0" cellpadding="0">
								<tr><td width="100%"><div id="avtar'.$n.'" class="avtar"><img src="images/animal'.$n.'.png"></div></td></tr>
								<tr><td height=22><div id="nick_name'.$n.'" class="nick_name"></div><div id="table_stack'.$n.'" class="table_stack"></td></tr>
							</table>
						</td>
						<td>
							<table border="0" width="100%" cellspacing="0" cellpadding="0">
								<tr>
									<td valign=top><div id="pocket_cards'.$n.'1" class="pocket_cards1"></div></td>
									<td valign=top><div id="pocket_cards'.$n.'2" class="pocket_cards2"></div></td>
								</tr>
								<tr>
									<td align="center"><div id="dealer'.$n.'" class="dealer"></td>
									<td><div id="current_share'.$n.'" class="current_share"></div></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			';
		}
		else
		{
			echo '
				<table border="1" cellpadding="0" cellspacing=0 width=100%>
					<tr>
						<td width="100%">
							<table border="0" width="100%" cellpadding="0" cellspacing=0>
								<tr>
									<td align="center" height=22 valign="middle" nowrap><div id="nick_name'.$n.'" class="nick_name"></div></td>
									<td align="right" valign=bottom nowrap width=60><div style="width:60px;" id="pocket_cards'.$n.'" class="pocket_cards"></div></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr><td width="100%" height=17 align="center"><div id="current_state'.$n.'" class="current_state"></div></td></tr>
					<tr><td width="100%" height=17 align="center"><div id="current_share'.$n.'" class="current_share"></div></td></tr>
					<tr><td width="100%" height=17 align="center"><div id="table_stack'.$n.'" class="table_stack"></div></td></tr>
					<tr><td width="100%" height=17 align="center" nowrap><div id="action_url'.$n.'" class="action_url"></div></td></tr>
				</table>
			';
		}
	}
</script>

<script type="text/javascript" src="first.js"></script>
<script type="text/javascript" src="poker_holdem.js"></script>
<script language=javascript>
	var table_id = <? echo $table_id; ?>;
	var request_player_id = <? echo $guserid; ?>;
</script>
<style>
div {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; color:#008000; font-weight:bold;}
div.pocket_cards {width:40px;}
div.pots {background-color:black; font-size: 18px; color:#00FFFF;}
div.last_message {font-size: 14px; font-weight:bold; color:#7f0000;}
div.last_error {font-size: 12px; font-weight:bold; color:#ff0000;}
div.current_share {color:#00FFFF;}
div.dealer {color:#00FFFF;}
div.avtar {height:50; width:50;}
.actions1 { cursor: hand; text-decoration:underline; color:#0000FF; }

.actions
{
  float: left;
  margin: 2px 5px 2px 5px;
  padding: 2px;
  width: 100px;
  border-top: 1px solid #cccccc;
  border-bottom: 1px solid black;
  border-left: 1px solid #cccccc;
  border-right: 1px solid black;
  background: #cccccc;
  text-align: center;
  text-decoration: none;
  font: normal 10px Verdana;
  color: #0000FF;
	cursor: hand;
}


.scard {
	font-family: Arial; border:1px solid gray; background-color:white; font-weight:bold; font-size:12px; height:20px; width:20px; 
	float:left; text-align:center;
	}
.dcard {border:1px solid gray; background-color:#000000; height:20px; width:20px; float:left;}

.pocket_cards1 {padding-left:5px; width:15px; overflow:hidden;}

</style>

<center><? require("game_header.php"); ?>
</center>
<table border="0" width="766" height="351" cellspacing="0" cellpadding="0" align=center>
<tr><td style="background-repeat: no-repeat;" background="http://127.0.01/projects/poker/images/poker-table-sam.png">

<table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td width="20%" height=90></td>
    <td width="20%" valign="top" align="center"><? player_hrml(1); ?></td>
    <td width="20%" valign="top" align="center"><? player_hrml(2); ?></td>
    <td width="20%" valign="top" align="center"><? player_hrml(3); ?></td>
    <td width="20%"></td>
  </tr>
  <tr>
    <td width="20%" height=131 valign="middle" align="left"><? player_hrml(8); ?></td>
    <td width="60%" colspan="3" align="center" valign="middle">
		
<table border="0" cellpadding="0" cellspacing=0>
  <tr>
    <td width="100%">
      <table border="0" width="100%" cellpadding="0" cellspacing=0>
        <tr>
          <td width="20%" height=60 valign="middle" align="center"><div id="community_cards0" class="community_cards"></div></td>
          <td width="20%" valign="middle" align="center"><div id="community_cards1" class="community_cards"></div></td>
          <td width="20%" valign="middle" align="center"><div id="community_cards2" class="community_cards"></div></td>
          <td width="20%" valign="middle" align="center"><div id="community_cards3" class="community_cards"></div></td>
          <td width="20%" valign="middle" align="center"><div id="community_cards4" class="community_cards"></div></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td width="100%" align="center">
			<table border=0 cellpadding=0 cellspacing="2">
				<tr>
					<td height=30 width=30><img src="images/chip-hp.png" border=0></td>
					<td><div id="pots0" class="pots"></div></td>
					<td><div id="pots1" class="pots"></div></td>
					<td><div id="pots2" class="pots"></div></td>
					<td><div id="pots3" class="pots"></div></td>
					<td><div id="pots4" class="pots"></div></td>
				</tr>
			</table>
		</td>
  </tr>
</table>

		</td>
    <td width="20%" valign="middle" align=right><? player_hrml(4); ?></td>
  </tr>
  <tr>
    <td width="20%" height=90></td>
    <td width="20%" height="80" valign="bottom" align="center"><? player_hrml(7); ?></td>
    <td width="20%" valign="bottom" align="center"><? player_hrml(6); ?></td>
    <td width="20%" valign="bottom" align="center"><? player_hrml(5); ?></td>
    <td width="20%"></td>
  </tr>
</table>

</td></tr>

<tr>
	<td width="100%" height=50>
		<div id="last_message" class="last_message"></div>
		<div id="main_action" class="main_action"></div>
		<div id="last_error" class="last_error"></div>
		<form method=post action="#" name="action_form">
			<div id="action_url" class="action_url"></div>
		</form>
	</td>
</tr>
</table>


<div id="debgdiv" style="display:block;"></div>
