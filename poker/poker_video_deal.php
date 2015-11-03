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

			if($sact=="bet")
			{
				
				require("poker_video_bet.php");
				if($lastError=="") header("Location: http://127.0.0.1/projects/poker/poker_video_deal.php?guserid=".$guserid); exit;
			}



</script>
<script type="text/javascript">
	function discardCard(i)
	{
		card = document.getElementById('card'+i);
		cardv = document.getElementById('cardv'+i);
		if(cardv.value=="T")
		{
			card.className = "carddiscard";
			cardv.value="D";
		}
		else
		{
			card.className = "card";
			cardv.value="T";
		}
	}
</script>
<style type="text/css">
	.card
	{
		border:1px solid grey;
		float:left;
	}
	.carddiscard
	{
		border:2px solid red;
		float:left;
	}
.tom
{
	font-family:Verdana;
	font-size:30px;
	color:white;
	font-weight:bold;
}
.sub_title
{
	font-family:Verdana;
	font-size:16px;
	color:white;
	font-weight:bold;
}
.error
{
	font-family:Verdana;
	font-size:16px;
	color:Red;
	font-weight:bold;
}
.error1
{
	font-family:Verdana;
	font-size:18px;
	color:Red;
	font-weight:bold;
}

.footer
{
	font-family:Verdana;
	font-size:12px;
	color:white;
	font-weight:bold;
}
.tf
{
	font-family:Verdana;
	font-size:14px;
	color:white;
	font-weight:bold;
}
.regs
{
	font-family:Verdana;
	font-size:20px;
	color:white;
	font-weight:bold;
}
.reg
{
	Position:Absolute;
	font-family:Verdana;
	font-size:25px;
	color:red;
	left:200px;
	font-weight:bold;
}
.a1
{
	font-family:Verdana;
	font-size:25px;
	color:white;
	font-weight:bold;
}
</style>

<script language=php>


	$card_html = array("H"=>'&hearts;',"S"=>'&spades;',"C"=>'&clubs;',"D"=>'&diams;');

	function print_select_bet($cur_bet_value)
	{
		echo "<select name='cur_bet_value'>";
		for ($i=10; $i<=50; $i+=5)
		{
			$selected = ""; if ($cur_bet_value==$i) $selected = "selected";
			echo "<option $selected value=$i>$i</option>";
		}
		echo "</select>";
	}

	function display_hand($hand,$cssids=false)
	{
		global $card_html;
		$i=0;
		foreach($hand as $card)
		{
			$i++;
			if($cssids)
				echo "<div  id=\"card".$i."\" onClick=\"discardCard('".$i."')\" class=\"card\">";
			else
				echo '<div class="card">';
			echo '<img src="images/'.$card['value'].$card['suit'].'.jpg" border=0>';
			echo '</div>';
			if($cssids) $strhand = '<input type="hidden" name="cardv'.$i.'" id="cardv'.$i.'" value="T">';
		}
		echo '<br style="clear:both">'.$strhand;
	}

	$hand_result_string = array
	(
		'RF' =>'Royal Flush',
		'SF' =>'Straight Flush',
		'FK' =>'Four of a Kind',
		'FH' =>'Full House',
		'F' =>'Flush',
		'S' =>'Straight',
		'TK' =>'Three of a Kind',
		'TP' =>'Two Pair',
		'P' =>'Pair',
		'HC' =>'High Cards'
	);

	$tr = $db->mysqlFetchRow(" SELECT sum(points) pts FROM points WHERE mid='$guserid' ");
	$cur_points = $tr['pts'];

	$tr = $db->mysqlFetchRow(" SELECT points FROM points WHERE mid='$guserid' ORDER BY id DESC LIMIT 1 ");
	$last_points = $tr['points'];

	$cur_hand = $win_hand = $deck = array();
	$cuser = $db->mysqlFetchRow(" SELECT * FROM members WHERE id='$guserid' ");

	if($cuser['cur_hand']!="") $cur_hand = unserialize($cuser['cur_hand']);
	if($cuser['win_hand']!="") $win_hand = unserialize($cuser['win_hand']);
	if($cuser['deck']!="") $deck = unserialize($cuser['deck']);

	$cur_game = new pokerVideo();
	$cur_game->Deal($deck);
	if(empty($cur_hand)) $cur_hand = $cur_game->pickHand();

	if(!empty($win_hand)) $cur_hand_value = $cur_game->calculateHand($win_hand);

	$fv = array();
	$fv['id'] = $guserid;
	$fv['cur_hand'] = serialize($cur_hand);
	$fv['win_hand'] = "";
	$fv['deck'] = serialize($cur_game->currentDeck);
	$db->mysqlAddUpdateRow("members",$fv);

</script>
<body topmargin=0 BGCOLOR="black">
<table cellSpacing=0 cellPadding=0 width=1024>
        <tr>
          <td><span class="tom">Texas Hold'em and Video Poker</span><br>
          <span class="sub_title">Turn Into The World Of Poker</span>
	  </td>
	</tr>
</table>
          <br>
<table cellspacing="0" cellpadding="0" width="1024">
    <tr>
        <td colspan="2">   
            <center><span class="reg">Video Poker</span>
        </td>
    </tr>
</table>
    <br>
            <br>
<div id="maindiv" class="def_txt">
<font color="#ffcc00">Available Credit:<b> <?php echo intval($cur_points); ?></b> Points</font><br><br>
	<?php if(!empty($win_hand)): ?>
		<div id="windiv" style="margin:5px;">
			<font size=3 color='#ff0000'><b>Result of your last Deal</b></font><br><br>
			<script language=php>
				echo "<font size=3 color='#ff0000'><b>";
				echo ($last_points>=0 ? "Congratulations.." : "OOPS..");
				echo "</b></font>";
				echo "<font color='cyan'> You got <b>".$hand_result_string[$cur_hand_value]."</b> ";
				if($last_points==0) echo "You Break even";
				elseif($last_points<0) echo "You Loose $last_points Points.";
				else echo "You Win $last_points Points.";
				echo "</font><br><br>";
				echo "<font color='cyan'>Here is the resultant hand from your last Deal.</font><br>";
				display_hand($win_hand);
			</script>
		</div>
		<hr>
	<?php endif; ?>
	<div id="curdiv" style="margin:5px;">
		<form method="post" action="poker_video_deal.php" name="c_deal">
			<?php hidden_field("act",$act); ?>
			<?php hidden_field("sact","bet"); ?>
			<?php hidden_field("guserid",$guserid); ?>

			<font size=3 color='#ff0000'><b>Start here for a fresh deal</b></font><br><br>
			<font color='#ffcc00'>Your fresh Deal, Bet on it now.</font><br>
			<?php display_hand($cur_hand,true); ?>
			<font color='#ff0000'>Click on the card to discard it.</font><br><br>
			
			Bet : <?php print_select_bet($cur_bet_value); ?> Points
			<input type="submit" name="bet_now" value="Bet Now">
		</form>
	</div>
</div>
