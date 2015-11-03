<style type="text/css">
	.card {
		border:1px solid black;
		padding-left:3px;
		padding-right:3px;
		margin:1px;
		width:35px;
		height:35px;
		float:left;
		text-align:center;
		background-color:white;
		}
	.hearts {color:red}
	.diamonds {color:red}
</style>

<script language=php>
	function print_array($ar,$msg="")
	{
		echo "<br>".$msg; 
	//	echo "<pre>";
		print_r ($ar);
	//	echo "</pre>";
	}

	function display_hand($hand)
	{
		$card_html = array("H"=>'&hearts;',"S"=>'&spades;',"C"=>'&clubs;',"D"=>'&diams;');

		echo '<div>';
		foreach($hand as $card)
		{
			echo '<div class="card">';
			if($card['suit'] == 'H')
				echo '<span class="hearts">'.$card_html['H'].$card['value'].'</span>';
			elseif($card['suit'] == 'C')
				echo '<span class="clubs">'.$card_html['C'].$card['value'].'</span>';
			elseif($card['suit'] == 'D')
				echo '<span class="diamonds">'.$card_html['D'].$card['value'].'</span>';
			elseif($card['suit'] == 'S')
				echo '<span class="spades">'.$card_html['S'].$card['value'].'</span>';
			echo '</div>';
		}
		echo '</div>';
	}

	require("poker_holdem.php");

	$g = new pokerHoldem();
	$g->Deal();

	if($pval11!="")
	{
		for($i=1; $i<=4; $i++)
		{
			$pval1 = "pval".$i."1"; $pval1 = ${$pval1};
			$pval2 = "pval".$i."2"; $pval2 = ${$pval2};
			$psuit1 = "psuit".$i."1"; $psuit1 = ${$psuit1};
			$psuit2 = "psuit".$i."2"; $psuit2 = ${$psuit2};

			$p = new pokerHoldemPlayer(1,$i);

			$p->id = $i;
			$p->nick_name = "Player: ".$i;
			$p->table_stack = 100;
			$p->pocket_cards[] = array('value' =>$pval1,'suit' =>$psuit1);
			$p->pocket_cards[] = array('value' =>$pval2,'suit' =>$psuit2);
			$p->pots_share[0] = 10; $g->pots[0] += $p->pots_share[0];
			if($i!=1) $p->pots_share[1] = 5; $g->pots[1] += $p->pots_share[1];
			$p->current_state = P_STATE_WAITING;
			$p->table_position = $i;

			$g->hand_players[$i] = $p;
		}
		$g->pots[0] +=1;
		$g->community_cards[] = array('value' =>$val1,'suit' =>$suit1);
		$g->community_cards[] = array('value' =>$val2,'suit' =>$suit2);
		$g->community_cards[] = array('value' =>$val3,'suit' =>$suit3);
		$g->community_cards[] = array('value' =>$val4,'suit' =>$suit4);
		$g->community_cards[] = array('value' =>$val5,'suit' =>$suit5);

		$g->Showdown();

		echo "<p><b>Community Cards</b><br>";
		display_hand($g->community_cards);
		echo "</p>";

		echo "<br><br><p><b>Players Hands </b><br><table><tr>";

		echo "<td>Player 1:(".$g->hand_players[1]->table_stack.")(".$g->hand_players[1]->best_hand['rank'].")<br>";
		display_hand($g->hand_players[1]->pocket_cards); echo "<br>";
		display_hand($g->hand_players[1]->best_hand); echo "</td>";

		echo "<td>Player 2:(".$g->hand_players[2]->table_stack.")(".$g->hand_players[2]->best_hand['rank'].")<br>";
		display_hand($g->hand_players[2]->pocket_cards); echo "<br>";
		display_hand($g->hand_players[2]->best_hand); echo "</td>";

		echo "<td>Player 3:(".$g->hand_players[3]->table_stack.")(".$g->hand_players[3]->best_hand['rank'].")<br>";
		display_hand($g->hand_players[3]->pocket_cards); echo "<br>";
		display_hand($g->hand_players[3]->best_hand); echo "</td>";

		echo "<td>Player 4:(".$g->hand_players[4]->table_stack.")(".$g->hand_players[4]->best_hand['rank'].")<br>";
		display_hand($g->hand_players[4]->pocket_cards); echo "<br>";
		display_hand($g->hand_players[4]->best_hand); echo "</td>";

		echo "</tr></table></p><br><br>";

		foreach($g->hand_players as $p)
		{
			$p->pocket_cards[0] = $g->pickCard();
			$p->pocket_cards[1] = $g->pickCard();
		}
		$g->community_cards[0] = $g->pickCard();
		$g->community_cards[1] = $g->pickCard();
		$g->community_cards[2] = $g->pickCard();
		$g->community_cards[3] = $g->pickCard();
		$g->community_cards[4] = $g->pickCard();

		$g->Showdown();

		echo "<h3><u>Random Test:</u></h3>";
		display_hand($g->community_cards);
		echo "</p>";

		echo "<br><br><p><b>Players Hands </b><br><table><tr>";

		echo "<td>Player 1:(".$g->hand_players[1]->table_stack.")(".$g->hand_players[1]->best_hand['rank'].")<br>";
		display_hand($g->hand_players[1]->pocket_cards); echo "<br>";
		display_hand($g->hand_players[1]->best_hand); echo "</td>";

		echo "<td>Player 2:(".$g->hand_players[2]->table_stack.")(".$g->hand_players[2]->best_hand['rank'].")<br>";
		display_hand($g->hand_players[2]->pocket_cards); echo "<br>";
		display_hand($g->hand_players[2]->best_hand); echo "</td>";

		echo "<td>Player 3:(".$g->hand_players[3]->table_stack.")(".$g->hand_players[3]->best_hand['rank'].")<br>";
		display_hand($g->hand_players[3]->pocket_cards); echo "<br>";
		display_hand($g->hand_players[3]->best_hand); echo "</td>";

		echo "<td>Player 4:(".$g->hand_players[4]->table_stack.")(".$g->hand_players[4]->best_hand['rank'].")<br>";
		display_hand($g->hand_players[4]->pocket_cards); echo "<br>";
		display_hand($g->hand_players[4]->best_hand); echo "</td>";

		echo "</tr></table></p><br><br>";


	}
</script>
<p>Enter the cards to test:(suits-> H C D S)<br>
<form method=post action="test_showdown.php">
<table><tr>
	<td>
		Player 1:<br>
		<input type=text name=pval11 value="<? echo $pval11; ?>" size=2><input type=text name=pval12 value="<? echo $pval12; ?>" size=2><br>
		<input type=text name=psuit11 value="<? echo $psuit11; ?>" size=2><input type=text name=psuit12 value="<? echo $psuit12; ?>" size=2>
	</td>
	<td>
		Player 2:<br>
		<input type=text name=pval21 value="<? echo $pval21; ?>" size=2><input type=text name=pval22 value="<? echo $pval22; ?>" size=2><br>
		<input type=text name=psuit21 value="<? echo $psuit21; ?>" size=2><input type=text name=psuit22 value="<? echo $psuit22; ?>" size=2>
	</td>
	<td>
		Player 3:<br>
		<input type=text name=pval31 value="<? echo $pval31; ?>" size=2><input type=text name=pval32 value="<? echo $pval32; ?>" size=2><br>
		<input type=text name=psuit31 value="<? echo $psuit31; ?>" size=2><input type=text name=psuit32 value="<? echo $psuit32; ?>" size=2>
	</td>
	<td>
		Player 4:<br>
		<input type=text name=pval41 value="<? echo $pval41; ?>" size=2><input type=text name=pval42 value="<? echo $pval42; ?>" size=2><br>
		<input type=text name=psuit41 value="<? echo $psuit41; ?>" size=2><input type=text name=psuit42 value="<? echo $psuit42; ?>" size=2>
	</td>
</tr></table>
<br>Community Cards:<br>
<input type=text name=val1 value="<? echo $val1; ?>" size=2>
<input type=text name=val2 value="<? echo $val2; ?>" size=2>
<input type=text name=val3 value="<? echo $val3; ?>" size=2>
<input type=text name=val4 value="<? echo $val4; ?>" size=2>
<input type=text name=val5 value="<? echo $val5; ?>" size=2><br>
<input type=text name=suit1 value="<? echo $suit1; ?>" size=2>
<input type=text name=suit2 value="<? echo $suit2; ?>" size=2>
<input type=text name=suit3 value="<? echo $suit3; ?>" size=2>
<input type=text name=suit4 value="<? echo $suit4; ?>" size=2>
<input type=text name=suit5 value="<? echo $suit5; ?>" size=2>
<br>
<input type=submit name=submit value=submit>
</form>
