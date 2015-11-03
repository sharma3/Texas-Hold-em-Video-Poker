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

	function display_hand($hand)
	{
		$card_html = array("H"=>'&hearts;',"S"=>'&spades;',"C"=>'&clubs;',"D"=>'&diams;');

		$i=0;
		foreach($hand as $card)
		{
			$i++;
			if($cssids)
				echo "<div class=\"card\">";
			else
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
	}

	if($val1!="")
	{
		$phand[] = array('value' =>$pval1,'suit' =>$psuit1);
		$phand[] = array('value' =>$pval2,'suit' =>$psuit2);

		$chand[] = array('value' =>$val1,'suit' =>$suit1);
		$chand[] = array('value' =>$val2,'suit' =>$suit2);
		$chand[] = array('value' =>$val3,'suit' =>$suit3);
		$chand[] = array('value' =>$val4,'suit' =>$suit4);
		$chand[] = array('value' =>$val5,'suit' =>$suit5);

		$prank = getPlayerRank($phand,$chand);
		print_array($prank,"<br><br>The resultant array");

		echo "<p><b>Select best from following.</b><br>";
		display_hand($phand);
		display_hand($chand);
		echo "</p>";

		echo "<br><br><p><b>The Best Hand is: {$prank['rank']} </b><br>";
		display_hand($prank);
		echo "</p><br><br>";
	}
</script>
<p>Enter the cards to test:(suits-> H C D S)<br>
<form method=post action="test_hand.php">
<input type=text name=pval1 value="<? echo $pval1; ?>" size=2>
<input type=text name=pval2 value="<? echo $pval2; ?>" size=2>
<input type=text name=val1 value="<? echo $val1; ?>" size=2>
<input type=text name=val2 value="<? echo $val2; ?>" size=2>
<input type=text name=val3 value="<? echo $val3; ?>" size=2>
<input type=text name=val4 value="<? echo $val4; ?>" size=2>
<input type=text name=val5 value="<? echo $val5; ?>" size=2><br>
<input type=text name=psuit1 value="<? echo $psuit1; ?>" size=2>
<input type=text name=psuit2 value="<? echo $psuit2; ?>" size=2>
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
	echo "<br>".$msg;
//	echo "<pre>";
  print_r ($ar);
//	echo "</pre>";
}

function my_keysort($ar)
{
	$ta = array(); $ra = array();

	foreach($ar as $key=>$cnt) $ta[$cnt][] = $key;
	foreach($ta as $key=>$c) arsort($ta[$key]);

	foreach($ta as $key=>$c)
		foreach($c as $v)
			$ra[$v]=$key;

	return $ra;
}

		function getPlayerRank($pc,$cc)
		{
			$card_values = array(2,3,4,5,6,7,8,9,10,'J','Q','K','A');
			$card_suits = array('H','S','C','D');
			$card_index = array(2=>2,3=>3,4=>4,5=>5,6=>6,7=>7,8=>8,9=>9,10=>10,'J'=>11,'Q'=>12,'K'=>13,'A'=>14);

			$hPair = false; $hTwoPair = false; $hThreeKind = false; $hStraight = false;
			$hFlush = false; $hFullHouse = false; $hFourKind = false; $hStraightFlush = false;
			$hRoyalFlush = false;
			
			$cards = $card_appear = $card_suits = $card_appear_k = $card_suits_k = array();
			$kik = $best_k = "";
			
			$c1 = array();
			foreach($pc as $c) 
			{
				$c1['ind'] = $card_index[$c['value']];
				$c1['value'] = $c['value'];
				$c1['suit'] = $c['suit'];
				$cards[] = $c1;
			}
			foreach($cc as $c)
			{
				$c1['ind'] = $card_index[$c['value']];
				$c1['value'] = $c['value'];
				$c1['suit'] = $c['suit'];
				$cards[] = $c1;
			}
			
			rsort($cards);
			foreach($cards as $k=>$c)
			{
				$val = $c['value']; $ind = $c['ind']; $suit = $c['suit'];
				if(isset($card_appear[$ind])) $card_appear[$ind]++; else $card_appear[$ind]=1;
				if(isset($card_suits[$suit])) $card_suits[$suit]++; else $card_suits[$suit]=1;
				$card_appear_k[$ind] .= $k."_";
				$card_suits_k[$suit] .= $k."_";
			}
			
			arsort($card_appear);
			$card_appear = my_keysort($card_appear);
			foreach($card_appear as $key=>$cnt)
			{
				if($cnt==4)
				{
					$hFourKind = true;
					$best_k .= $card_appear_k[$key];
				}
				elseif($cnt==3)
				{
					if($hFourKind)
					{ 
						$kik .= $card_appear_k[$key];
					}
					elseif($hThreeKind) 
					{ 
						$hFullHouse = true;
						$best_k .= $card_appear_k[$key];
					}
					else
					{
						$hThreeKind = true;
						$best_k .= $card_appear_k[$key];
					}
				}
				elseif($cnt==2)
				{
					if($hFourKind)
					{ 
						$kik .= $card_appear_k[$key];
					}
					elseif($hThreeKind) 
					{ 
						$hFullHouse = true; 
						$best_k .= $card_appear_k[$key];
					}
					elseif($hTwoPair) 
					{ 
						$kik .= $card_appear_k[$key];
					}
					elseif($hPair) 
					{ 
						$hTwoPair = true; 
						$best_k .= $card_appear_k[$key];
					}
					else
					{
						$hPair = true;
						$best_k .= $card_appear_k[$key];
					}
				}
				elseif($cnt==1)
				{
					$kik .= $card_appear_k[$key];
				}
			}

			if(!$hFullHouse && !$hFourKind)
			{
				arsort($card_suits);
				foreach($card_suits as $key=>$cnt)
				{
					if($cnt>=5)
					{
						$hFlush = true;
						$best_k = $card_suits_k[$key];
					}
					break;
				}
				
				$prev = 0; $first=0; $found=0; $stk=""; $fk=""; $s_suit=""; $found5=false;
				foreach($cards as $k=>$c)
				{
					$ind = $c['ind'];
					if($found>=4)
					{
						if($ind==$prev){ $stk .= $k."_"; }
						else break;
					}
					else
					{
						if($prev==0){ $prev=$ind; $first=$ind; if($ind==14) $fk=$k."_"; $stk = $k."_"; }
						else
						{
							if($first==14 && $ind==5 && $found<3) 
							{ 
								$found5=true;
								if($prev==5) $stk .= $k."_"; else $stk = $k."_";
								$found=1;
							}
							elseif($ind==$prev-1) { $found++; $stk .= $k."_"; }
							elseif($ind==$prev){ if($ind==14) $fk.=$k."_"; $stk .= $k."_"; }
							else { $found=0; $stk=$k."_"; }
							
							if($found>0 && $card_appear[$c['ind']]==1) $s_suit = $c['suit'];
							
							if($found>=4)
							{ 
								if(!$found5) $fk="";
								$hStraight=true;
							}
							$prev = $ind;
						}
					}
				}
			}
			
			//now find the best possible hand out of 7 cards.
			$best_k_ar = $kik_ar = array(); $best_hand=array();

			if($hStraight)
			{
				$best_k_ar = explode("_", $fk.$stk);
				$best_k_ar = array_unique($best_k_ar);
				$j=0; $prev = 0; 
				foreach($best_k_ar as $i)
//				for($i=0; $i<count($cards); $i++)
				{
					if($prev==$cards[$i]['ind'])
					{
						if($s_suit==$cards[$i]['suit']) {$best_hand[$j-1]=$cards[$i];}
					}
					else 
					{
						if($j>4) break;
						$best_hand[$j++]=$cards[$i];
					}
					$prev=$cards[$i]['ind'];
				}

				$hStraightFlush = true;
				for($i=0; $i<5; $i++)
				{
					if($s_suit!=$best_hand[$i]['suit']) 
					{
						$hStraightFlush = false;
						break;
					}
				}
			}
			
			if($hStraightFlush)
			{
				$best_hand['rank'] = R_STRAIGHT_FLUSH;
				return $best_hand;
			}
			
			if($hStraight && !$hFourKind && !$hFullHouse && !$hFlush)
			{
				$best_hand['rank'] = R_STRAIGHT;
				return $best_hand;
			}

			if($hFlush)
			{
				$t_best_k="";
				$tk_ar = explode("_", $best_k);

				for($i=0; $i<(count($tk_ar)-4); $i++)
				{
					$hStraightFlush = true;
					for($j=$i; $j<($i+5); $j++) 
					{
						if($j>$i && ($cards[$tk_ar[$j-1]]['ind']-1)!=$cards[$tk_ar[$j]]['ind']) 
						{ 
							$hStraightFlush = false; 
							$t_best_k="";
							break; 
						}
						else $t_best_k .= $tk_ar[$j]."_";
					}
					if($hStraightFlush)
					{
						$best_k = $t_best_k;
						break;
					}
				}
			}

			$best_k_ar = explode("_", $best_k);
			$kik_ar = explode("_", $kik);
			
			$j=0;
			foreach($best_k_ar as $k)
			{
				if($k!="") $best_hand[$j++] = $cards[$k];
				if($j>=5) break;
			}
		
			if($j<5)
			{
				sort($kik_ar);
				foreach($kik_ar as $k)
				{
					if($k!="") $best_hand[$j++] = $cards[$k];
					if($j>=5) break;
				}
			}

			if($j<5)
			{
				for($i=0; $i<count($cards); $i++)
				{
					$best_hand[$j++] = $cards[$i];
					if($j>=5) break;
				}
			}
			

			if($hStraightFlush) $best_hand['rank'] = R_STRAIGHT_FLUSH;
			elseif($hFourKind) $best_hand['rank'] = R_FOUR_KIND;
			elseif($hFullHouse) $best_hand['rank'] = R_FULL_HOUSE;
			elseif($hFlush) $best_hand['rank'] = R_FLUSH;
			elseif($hStraight) $best_hand['rank'] = R_STRAIGHT;
			elseif($hThreeKind) $best_hand['rank'] = R_THREE_KIND;
			elseif($hTwoPair) $best_hand['rank'] = R_TWO_PAIR;
			elseif($hPair) $best_hand['rank'] = R_PAIR;
			else $best_hand['rank'] = R_HIGH_CARD;
			return $best_hand;
		}


	require_once("poker_cards.php");
	echo "<h3><u>Some Random Testing</u></h3><table>";

	$pcards = new Cards();
	for($i=0; $i<20; $i++)
	{
		$pcards->Deal();
		unset($ph); unset($ch);
		$ph[] = $pcards->pickCard(); $ph[] = $pcards->pickCard();
		$ch[] = $pcards->pickCard(); $ch[] = $pcards->pickCard();
		$ch[] = $pcards->pickCard(); $ch[] = $pcards->pickCard();
		$ch[] = $pcards->pickCard();

		echo "<tr><td><p><b>Select best from following.</b><br>";
		display_hand($ph);
		display_hand($ch);
		echo "</p></td>";

		$prank = getPlayerRank($ph,$ch);

		echo "<td><p><b>Result:{$prank['rank']} </b><br>";
		display_hand($prank);
		echo "</p></td></tr>";
	}
	echo "</table>";
</script>



