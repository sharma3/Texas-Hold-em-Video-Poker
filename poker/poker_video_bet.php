<script language=php>
	// validate bet with existing pages
	// pick new cards for discarded pages
	// calculate winning hand and assign points
	// select new hand to play
	// save current deck, current hand, winning hand

	$cur_bet_value = $_POST['cur_bet_value'];

// fetch current deal data from members table
	$cur_hand = $deck = array();
	$cuser = $db->mysqlFetchRow(" SELECT * FROM members WHERE id='$guserid' ");
	if($cuser['cur_hand']!="") $cur_hand = unserialize($cuser['cur_hand']);
	if($cuser['deck']!="") $deck = unserialize($cuser['deck']);
	$cur_game = new pokerVideo();
	$cur_game->Deal($deck);

	$tr = $db->mysqlFetchRow(" SELECT sum(points) pts FROM points WHERE mid='$guserid' ");
	$cur_points = $tr['pts'];

	if(empty($cur_hand)) $lastError .= "You do not have Poker Hand. Please play again !! <br>";
	if(intval($cur_bet_value) <= 0) $lastError .= "You must select some points to bet on !! <br>";
	if($cur_bet_value > $cur_points) $lastError .= "Sorry you don't have sufficient points avilable to bet on !! <br>";

	if($lastError=="")
	{
		// Now assign new card to discarded card
		for($i=1;$i<6;$i++)
		{
			if($_POST['cardv'.$i]=='D')
			{
				unset($cur_hand[$i-1]);
				$cur_hand[$i-1] = $cur_game->pickCard();
			}
		}

		// calculate points now
		$cur_hand_value = $cur_game->calculateHand($cur_hand);
		$cur_hand_points = $cur_bet_value * $cur_game->calculatePoints($cur_hand_value);

		// create new deal and store as current game.
		$new_game = new pokerVideo();
		$new_game->Deal();
		$fv = array();
		$fv['id'] = $guserid;
		$fv['cur_hand'] = serialize($new_game->pickHand());
		$fv['win_hand'] = serialize($cur_hand);
		$fv['deck'] = serialize($new_game->currentDeck);
		$db->mysqlAddUpdateRow("members",$fv);

		$pv = array();
		$pv['mid'] = $guserid;
		$pv['edate'] = date("YmdHis");
		$pv['points'] = $cur_hand_points;
		$pv['game'] = 'V';
		$db->mysqlAddUpdateRow("points",$pv);
	}
</script>