<script language=php>
class Cards
{
	var $currentDeck=array();
	var $card_values = array(2,3,4,5,6,7,8,9,10,'J','Q','K','A');
	var $card_suits = array('H','S','C','D');
	var $card_index = array(2=>2,3=>3,4=>4,5=>5,6=>6,7=>7,8=>8,9=>9,10=>10,'J'=>11,'Q'=>12,'K'=>13,'A'=>14);

	function Deal($deck=array())
	{
		$this->currentDeck = $deck;
		if (empty($this->currentDeck))
		{
			foreach($this->card_suits as $suit_index => $suit)
			{
				foreach($this->card_values as $value_index => $value)
				{
					$this->currentDeck[] = array('value' =>$value,'suit' =>$suit);
				}
			}
			shuffle($this->currentDeck);
		}
	}

	function pickCard()
	{
		$card = array_pop($this->currentDeck);
		return $card;
	}

	function pickHand()
	{
		$hand = array();
		$hand[] = $this->pickCard();
		$hand[] = $this->pickCard();
		$hand[] = $this->pickCard();
		$hand[] = $this->pickCard();
		$hand[] = $this->pickCard();
		return $hand;
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

/*
			$card_appears=0;
			//three/four of a kind
			foreach($hand as $card)
			{
				if($card_value == $card['value'])
				{
					$card_appears++;
				}
			}
			if($card_appears == 4) $hasFourKind = true;
			elseif($card_appears == 3) $hasThreeKind = true;
			
			// two pair check
			foreach($hand as $card)
			{
				if($card_value != $card['value']) $card_value_second = $card['value'];
				if($card_value != $card['value'] && $card_value_second != $card['value']) $card_value_third = $card_['value'];
			}
			$card_appears = 0;
			foreach($hand as $card)
			{
				if($card_value_second == $card['value']) $card_appears++;
			}
			if($card_appears > 1) $hasTwoPair = true;
			$card_appears = 0;
			foreach($hand as $card)
			{
				if($card_value_third == $card['value']) $card_appears++;
			}
			if($card_appears > 1) $hasTwoPair = true;
			if($hasTwoPair && $hasThreeKind) $hasFullHouse = true;
*/
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

/*
			//Straight this was old bogus stuff.
			$noStraight = false;
			arsort($hand);
			$card_value = $hand[0]['value'];
			foreach($hand as $card)
			{
				if($card_value != ($card['suit']-1))
				{
					$noStraight = true;
				}
				$card_value = $card['suit']-1;
			}
			if(!noStraight) $hasStraight = true;
*/			
			//Straight
			$noStraight = false;
			$hand_index = array();
			foreach($hand as $card) $hand_index[] = $this->card_index[$card['value']];
			rsort($hand_index);
			$index_value = $hand_index[0];
			foreach($hand_index as $cur_index)
			{
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
}
</script>