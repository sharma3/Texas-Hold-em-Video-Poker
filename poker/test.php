<script language=php>
	
	if($val1!="")
	{
		
		$hand[] = array('value' =>$val1,'suit' =>$suit1);
		$hand[] = array('value' =>$val2,'suit' =>$suit2);
		$hand[] = array('value' =>$val3,'suit' =>$suit3);
		$hand[] = array('value' =>$val4,'suit' =>$suit4);
		$hand[] = array('value' =>$val5,'suit' =>$suit5);

		echo "<b>Current Hand is:".calculateHand($hand)."</b><br><br>";
	}
</script>

<form method=post action="test.php">
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

<script language=php>
function print_array($ar,$msg="")
{
	echo $msg;
//	echo "<pre>";
  print_r ($ar);
//	echo "</pre>";
}

	function calculateHand($hand)
	{
		$card_appears = 0;
		$hasPair = false; $hasTwoPair = false; $hasThreeKind = false; $hasStraight = false;
		$hasFlush = false; $hasFullHouse = false; $hasFourKind = false; $hasStraightFlush = false;
		$hasRoyalFlush = false;
		//pair check

		foreach($hand as $card)
		{
			$card_value = $card['value'];
			foreach($hand as $card2)
			{
				if($card_value == $card2['value'])
				{
					$card_appears++;
					if($card_appears == 2)
					{
						$hasPair = true;
						break;
					}
				}
			}
			$card_appears = 0;
			if($hasPair)break;
		}

		if($hasPair)
		{
			$tot_pairs=$card_appears=$card2_appears=$card3_appears=$card2_value=$card3_value=0;
			//three/four of a kind
			foreach($hand as $card)
			{
				if($card_value == $card['value']) $card_appears++;
				elseif(!$card2_value) { $card2_value = $card['value']; $card2_appears++; }
				elseif($card2_value == $card['value']) $card2_appears++;
				elseif(!$card3_value) { $card3_value = $card['value']; $card3_appears++; }
				elseif($card3_value == $card['value']) $card3_appears++;
			}
			if($card_appears == 4 || $card2_appears == 4) $hasFourKind = true;
			elseif($card_appears == 3 || $card2_appears == 3 || $card2_appears == 3) $hasThreeKind = true;

			if($card_appears>=2) $tot_pairs++;
			if($card2_appears>=2) $tot_pairs++;
			if($card3_appears>=2) $tot_pairs++;

			if($tot_pairs>=2) $hasTwoPair = true;
			
			if($hasTwoPair && $hasThreeKind) $hasFullHouse = true;
		}
		else
		{
			//Flush 
			$noFlush = false;
			foreach($hand as $card)
			{
				$card_suit = $card['suit'];
				foreach($hand as $card2)
				{
					if($card_suit != $card2['suit'])
					{
						$noFlush = true;
					}
				}
			}
			if(!$noFlush) $hasFlush = true;

			//Straight
			$noStraight = false;

$card_index = array(2=>2,3=>3,4=>4,5=>5,6=>6,7=>7,8=>8,9=>9,10=>10,'J'=>11,'Q'=>12,'K'=>13,'A'=>14);
			$hand_index = array();
			foreach($hand as $card)
			{
				$hand_index[] = $card_index[$card['value']];
			}

			rsort($hand_index);

			$index_value = $hand_index[0];
			foreach($hand_index as $cur_index)
			{
echo "<br>IV:$index_value CI:$cur_index";
				if($index_value==13 && $cur_index==5) $index_value=5;
				if($index_value != $cur_index)
				{
					$noStraight = true;
				}
				$index_value -= 1;
			}
			if(!$noStraight) $hasStraight = true;
			
			if($hasFlush && $hasStraight) $hasStraightFlush = true;
			//Royal Flush
			if($hasStraightFlush && $hand[0]['value'] == 'K')
			{
				$hasRoyalFlush = true;
			}
		}
		
		if($hasRoyalFlush) return 'RF';
		if($hasStraightFlush) return 'SF';
		if($hasFourKind) return 'FK';
		if($hasFullHouse) return 'FH';
		if($hasFlush) return 'F';
		if($hasStraight) return 'S';
		if($hasThreeKind) return 'TK';
		if($hasTwoPair) return 'TP';
		if($hasPair) return 'P';
		return 'HC';
	}

</script>