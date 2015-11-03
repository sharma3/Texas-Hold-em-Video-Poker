<script language=php>
	require_once("poker_cards.php");

	// player states
	define("P_STATE_NEW",						0);
	define("P_STATE_VIEWING",				1);
	define("P_STATE_WAITING",				2);
	define("P_STATE_ACTING",				3);
	define("P_STATE_FOLD",					4);
	define("P_STATE_ALLIN",					5);
	define("P_STATE_SITTING_OUT",		6);
	define("P_STATE_TIMED_OUT",			8);

	// player actions
	define("P_ACTION_FOLD",				1);
	define("P_ACTION_ALLIN",			2);
	define("P_ACTION_CALL",				3);
	define("P_ACTION_RAISE",			4);
	define("P_ACTION_SIT",				5);
	define("P_ACTION_LEAVE",			6);
	define("P_ACTION_SITOUT",			7);
	define("P_ACTION_CKECK",			8);

	//Hand States
	define("H_STATE_PREFLOP",		1);
	define("H_STATE_FLOP",			2);
	define("H_STATE_TURN",			3);
	define("H_STATE_RIVER",			4);
	define("H_STATE_SHOWDOWN",	5);
	define("H_STATE_CLOSED",		6);

	//Hand Ranks
	define("R_STRAIGHT_FLUSH",		90);
	define("R_FOUR_KIND",					80);
	define("R_FULL_HOUSE",				70);
	define("R_FLUSH",							60);
	define("R_STRAIGHT",					50);
	define("R_THREE_KIND",				40);
	define("R_TWO_PAIR",					30);
	define("R_PAIR",							20);
	define("R_HIGH_CARD",					10);

	//Other Constants
	define("ACTION_TIMEOUT",		60);

	class pokerHoldemPlayer
	{
		// player state: VIEWING, WAITING, ACTING, FOLD, ALLIN, SITTING_OUT

		var $id;
		var $player_id;
		var $table_id;
		var $nick_name;
		var $table_stack;
		var $pocket_cards=array();
		var $pots_share=array();
		var $pots_win=array();
		var $current_share=0;
		var $current_state;
		var $wait_start_time=0;
		var $last_request_time=0;
		var $table_position;
		var $best_hand = array();
		var $ischanged=1;
		var $win_html="";
		var $act_times=0;
		var $is_timeout=false;

		function pokerHoldemPlayer($table_id,$player_id)
		{
			$this->id=0;
			$this->table_id = $table_id;
			$this->player_id = $player_id;
		}

		function savePlayer()
		{
			global $db;
			$p = array();
			$p['id'] = $this->id;
			$p['player_id'] = $this->player_id;
			$p['table_id'] = $this->table_id;
			$p['nick_name'] = $this->nick_name;
			$p['table_stack'] = $this->table_stack;
			$p['pocket_cards'] = serialize($this->pocket_cards);
			$p['pots_share'] = serialize($this->pots_share);
			$p['current_share'] = $this->current_share;
			$p['current_state'] = $this->current_state;
			$p['wait_start_time'] = $this->wait_start_time;
			$p['last_request_time'] = $this->last_request_time;
			$p['table_position'] = $this->table_position;
			$p['win_html'] = $this->win_html;
			$p['act_times'] = $this->act_times;

			$db->mysqlAddUpdateRow('holdem_hand_palyer', $p);
			if(intval($this->id)==0) $this->id = mysql_insert_id();
		}

		function addToPot($amount,$cp)
		{
			$this->table_stack -= $amount;
			$this->current_share += $amount;
		}

		function addWinAmount($amount,$cp)
		{
			$this->table_stack += $amount;
			$this->pots_win[$cp] = $amount;
		}
	}

	class pokerHoldem extends Cards
	{
		//input vars, this will come from UI (html form or url vars)
		var $request = array(); //table_id, request_player_id, action, bet_val, request_position, nick_name

		//poker table vars, get values from db
		var $table_id; var $numberof_players; var $bet_limit; var $initial_stake; var $minimum_bet;

		//current hand vars, get values from db
		var $hand_id; var $community_cards = array(); var $pots = array(); var $current_bet;
		var $dealer_position; var $blind_position=0; var $current_state=0; var $ischanged;
		var $last_time=0;

		// array of playing players
		var $hand_players = array();

		// Util vars
		var $current_pot=0; var $acp; var $last_error; var $last_error_code; var $last_message;
		var $animation_queue = array();

		function addAnimation($bl)
		{
			$this->animation_queue[] = $bl;
		}

		function getHand()
		{
			// select from db and assign to class variables
			global $db;

			$this->table_id = $this->request['table_id'];
			$this->current_state = H_STATE_CLOSED;

			$sql = " SELECT * FROM holdem_table WHERE id='{$this->table_id}' ";
			$ro = $db->mysqlFetchRow($sql);
			if($ro)
			{
				$this->numberof_players = $ro['numberof_players'];
				$this->bet_limit = $ro['bet_limit'];
				$this->initial_stake = $ro['initial_stake'];
				$this->minimum_bet = $ro['minimum_bet'];
			}

			$sql = " SELECT * FROM holdem_hand WHERE table_id='{$this->table_id}' ORDER BY id DESC LIMIT 1 ";
			$ro = $db->mysqlFetchRow($sql);
			if($ro)
			{
				$this->hand_id = $ro['id'];
				if($ro['community_cards']!="") $this->community_cards = unserialize($ro['community_cards']);
				if($ro['currentDeck']!="") $this->currentDeck = unserialize($ro['currentDeck']);
				if($ro['pots']!="") $this->pots = unserialize($ro['pots']);
				$this->current_bet = $ro['current_bet'];
				$this->current_state = $ro['current_state'];
				$this->dealer_position = $ro['dealer_position'];
				$this->blind_position = $ro['blind_position'];
				$this->last_time = $ro['last_time'];
			}

			$sql = " SELECT * FROM holdem_hand_palyer WHERE table_id='{$this->table_id}' ORDER BY table_position ";
			$r = mysql_query($sql);
			while($ro=mysql_fetch_array($r))
			{
				$p = new pokerHoldemPlayer($this->table_id,$ro['player_id']);

				$p->id = $ro['id'];
				$p->nick_name = $ro['nick_name'];
				$p->table_stack = $ro['table_stack'];
				if($ro['pocket_cards']!="") $p->pocket_cards = unserialize($ro['pocket_cards']);
				if($ro['pots_share']!="") $p->pots_share = unserialize($ro['pots_share']);
				$p->current_share = $ro['current_share'];
				$p->current_state = intval($ro['current_state']);
				$p->wait_start_time = $ro['wait_start_time'];
				$p->last_request_time = $ro['last_request_time'];
				$p->table_position = $ro['table_position'];
				$p->win_html = $ro['win_html'];
				$p->act_times = $ro['act_times'];

				$this->hand_players[$p->table_position] = $p;
			}
		}

		function saveHand()
		{
			// from class variables to database, also save each players changed values
			global $db;
			$hh = array();
			$hh['id'] = $this->hand_id;
			$hh['table_id'] = $this->table_id;
			$hh['community_cards'] = serialize($this->community_cards);
			$hh['currentDeck'] = serialize($this->currentDeck);
			$hh['pots'] = serialize($this->pots);
			$hh['current_bet'] = $this->current_bet;
			$hh['current_state'] = $this->current_state;
			$hh['dealer_position'] = $this->dealer_position;
			$hh['blind_position'] = $this->blind_position;
			$hh['last_time'] = $this->last_time;

			$db->mysqlAddUpdateRow('holdem_hand', $hh);
			$hid = $this->hand_id;
			if(!$hid) $hid = mysql_insert_id();

			foreach ($this->hand_players as $p)
			{
				$p->savePlayer();
			}

			return $hid;
		}

		function communityCardsHtml()
		{
			$tstr = "";

			for ($i=0; $i<5; $i++)
			{
				if(isset($this->community_cards[$i]))
				{
					$card = $this->community_cards[$i];
					$url = '<img src="images/'.$card['value'].$card['suit'].'.jpg" border=0>';
				}
				else $url = "";

				if ($tstr!="") $tstr .= ",";
				$tstr .= '{"url":"'.my_json_encode($url).'"}';
			}

			return $tstr;
		}

		function currentStateHtml()
		{
			switch ($this->current_state)
			{
				case H_STATE_PREFLOP: return "Pre Flop Round";
				case H_STATE_FLOP: return "Flop Round";
				case H_STATE_TURN: return "Turn Round";
				case H_STATE_RIVER: return "River Round";
				case H_STATE_SHOWDOWN: return "Showdown";
				case H_STATE_CLOSED: return "Waiting For Players";
				default: return "Waiting For Players";
			}
		}

		function playerStateHtml($current_state)
		{
			switch ($current_state)
			{
				case P_STATE_WAITING: return "Waiting";
				case P_STATE_ACTING: return "<blink>Acting</blink>";
				case P_STATE_FOLD: return "<font color=#cccccc>Fold</font>";
				case P_STATE_ALLIN: return "All In";
				case P_STATE_SITTING_OUT: return "Sitting Out";
				case P_STATE_NEW: return "Just Join";
				default: return "";
			}
		}

		function playerWinHtml($p)
		{
			if(count($p->best_hand)==0) return "";

			switch ($p->best_hand['rank'])
			{
				case R_STRAIGHT_FLUSH:	$tstr = "Straight Flush"; break;
				case R_FOUR_KIND:				$tstr = "Four Kind"; break;
				case R_FULL_HOUSE:			$tstr = "Full House"; break;
				case R_FLUSH:						$tstr = "Flush"; break;
				case R_STRAIGHT:				$tstr = "Straight"; break;
				case R_THREE_KIND:			$tstr = "Three Kind"; break;
				case R_TWO_PAIR:				$tstr = "Two Pair"; break;
				case R_PAIR:						$tstr = "Pair"; break;
				case R_HIGH_CARD:				$tstr = "High Card"; break;
				default:								$tstr = ""; break;
			}

			return "<font style='font-size:12px;' color='#7f0000'>".$tstr."</font>";
		}

		function playerActionHtml($p)
		{
			$tstr = "";
			if($p->player_id==$this->request['request_player_id'])
			{
				if($p->current_state==P_STATE_ACTING)
				{
					$tstr = "<a class=\"actions\" onclick=\"playAction(".P_ACTION_FOLD.",0)\">Fold</a>";

					if($this->current_bet == $p->current_share )
						$tstr .= "<a class=\"actions\" onclick=\"playAction(".P_ACTION_CKECK.",0)\">Check</a>";
					else
					{
						$call = $this->current_bet - $p->current_share;
						if($p->table_stack > $call)
							$tstr .= "<a class=\"actions\" onclick=\"playAction(".P_ACTION_CALL.",$call)\">Call $call</a>";
					}

					$raise = $this->current_bet - $p->current_share + $this->minimum_bet;
					if($p->table_stack > $raise)
					{
						if($this->current_bet==0)
							$tstr .= "<a class=\"actions\" onclick=\"playAction(".P_ACTION_RAISE.",$raise)\">Bet $raise</a>";
						else
							$tstr .= "<a class=\"actions\" onclick=\"playAction(".P_ACTION_RAISE.",$raise)\">Raise $raise</a>";
					}
					if($p->table_stack>0)
						$tstr .= "<a class=\"actions\" onclick=\"playAction(".P_ACTION_ALLIN.",".$p->table_stack.")\">All ".$p->table_stack." In</a>";
				}
				elseif($p->current_state==P_STATE_SITTING_OUT)
				{
					$tstr = "You are currently sitting out, Please <a class=\"actions1\" onclick=\"playSitOn(".P_ACTION_SIT.",".$p->table_position.")\"><b>Sit On</b></a>";
				}
				elseif( ($this->current_state==H_STATE_SHOWDOWN || $this->current_state==H_STATE_CLOSED) )
				{
					$tstr = "<a class=\"actions\" onclick=\"playAction(".P_ACTION_LEAVE.",0)\">Leave Table</a>";
					$tstr .= "<a class=\"actions\" onclick=\"playAction(".P_ACTION_SITOUT.",0)\">Sit Out</a>";
				}
			}

			return $tstr;
		}

		function drawHand()
		{
			// draw HTML from class variables
			$card_html = array("H"=>'&hearts;',"S"=>'&spades;',"C"=>'&clubs;',"D"=>'&diams;');

			$ht_array = array();
			$ht_array['table_id'] = $this->table_id;
			$ht_array['dealer_position'] = $this->dealer_position;
			$ht_array['numberof_players'] = $this->numberof_players;
			$ht_array['last_error'] = $this->last_error;
			$ht_array['last_error_code'] = $this->last_error_code;
			$ht_array['last_message'] = $this->last_message;
//			$ht_array['main_action'] = "<a class=\"actions\" onclick=\"playTurn()\"><b>Refresh</b></a>";
			$ht_array['main_action'] = $this->currentStateHtml();

// following 3 lines was for initial testing to start game manually.
//			$ht_array['main_action'] = "";
//			if($this->current_state==0 || $this->current_state==H_STATE_SHOWDOWN || $this->current_state==H_STATE_CLOSED)
//				$ht_array['main_action'] = "<a class=\"actions\" onclick=\"playTurn()\"><b>Refresh</b></a>";

			for ($i=0; $i<5; $i++)
			{
				if(isset($this->community_cards[$i]))
				{
					$card = $this->community_cards[$i];
					$url = '<img src="images/'.$card['value'].$card['suit'].'.jpg" border=0>';
				}
				else $url = "";

				$ht_array['community_cards'][]= $url;
			}

			$ht_array['pots']= $this->pots;
			if(count($ht_array['pots'])==0) $ht_array['pots'] = array("");

			// player data: $player_id $nick_name $table_stack $pocket_cards $current_share $current_state

			for ($i=1; $i<=$this->numberof_players; $i++)
			{
				$pa = array();
				if(isset($this->hand_players[$i]))
				{
					$p = $this->hand_players[$i];
					$pa['player_id'] = $p->player_id;
					$pa['nick_name'] = $p->nick_name;
					$pa['table_stack'] = $p->table_stack;
					$pa['current_share'] = $p->current_share;
					$pa['action_url'] = "";
					$pa['pocket_cards'] = array("","");

					$pa['current_state'] = $this->playerStateHtml($p->current_state);
					if($this->current_state==H_STATE_SHOWDOWN) $pa['table_stack']=$p->win_html;
					if($p->current_state==P_STATE_SITTING_OUT) $pa['table_stack'] = "Sitting Out";

					$pa['action_url'] = $this->playerActionHtml($p);

					if( count($p->pocket_cards)>0 && $p->player_id==$this->request['request_player_id']
								|| ($this->current_state==H_STATE_SHOWDOWN && $p->current_state==P_STATE_WAITING) )
					{
						unset($pa['pocket_cards']);
						for($j=0; $j<count($p->pocket_cards); $j++)
						{
							$card = $p->pocket_cards[$j];
							$suit = $card['suit'];
							$pa['pocket_cards'][] = '<img src="images/'.$card['value'].$card['suit'].'.jpg" border=0>';
						}
						$this->addAnimation("pocket_cards".$p->table_position);
					}
					else
					{
						$pa['pocket_cards'] = array('<img src="images/back.jpg" border=0>','<img src="images/back.jpg" border=0>');
					}
				}
				else
				{
					$pa['player_id'] = 0;
					$pa['nick_name'] = "<a class=\"actions1\" onclick=\"playSitOn(".P_ACTION_SIT.",$i)\"><b>Sit On</b></a>";
					$pa['table_stack'] = "";
					$pa['pocket_cards'] = array("","");
					$pa['current_share'] = "";
					$pa['action_url'] = "";
					$pa['current_state'] = "Empty";
				}
				$ht_array['players'][]= $pa;
			}

			$ht_array['animation_queue'] = $this->animation_queue;

			echo array2json($ht_array);
		}

		function performAction()
		{
			// this is top level function
			//todo: validate users action, if valid to do so and sufficient amount to do so

			$fourceful = false;

			$action = intval($this->request['action']);

			$p = $this->getPlayerByID($this->request['request_player_id']);
			if($p)
			{
				if( (time() - $p->last_request_time)>10 )
				{
					$p->last_request_time = time();
					$p->savePlayer();
				}
			}

			if($action<=0)
			{
				if( $this->current_state==H_STATE_SHOWDOWN && (time()-$this->last_time)>=13 )
				{
					if($this->activePlayers()>=2)
					{
						$this->startNewHand();
					}
					else
					{
						$this->current_state=H_STATE_CLOSED;
					}
					$this->saveHand();
					return;
				}
				elseif($this->current_state!=H_STATE_CLOSED && $this->current_state!=H_STATE_SHOWDOWN)
				{
					if($this->waitingPlayers()<2 ) $fourceful = true;
					else
					{
						$c = $this->nextPlayerIndex($this->dealer_position,P_STATE_ACTING);
						if($c)
						{
							$tout_p = $this->hand_players[$c];
							if( (time()-$tout_p->wait_start_time)>=ACTION_TIMEOUT )
							{
								$this->request['request_player_id'] = $tout_p->player_id;
								$action=P_ACTION_FOLD;
								$tout_p->is_timeout = true;
							}
							else
							{
								$rtm = ACTION_TIMEOUT - (time()-$tout_p->wait_start_time);
								$this->last_message = "Waiting for ".$tout_p->nick_name." to act. $rtm seconds left.";
							}
						}
					}
				}
			}

			if(	$action==P_ACTION_SIT || $action==P_ACTION_LEAVE || $action==P_ACTION_SITOUT )
			{
				switch($action)
				{
					case P_ACTION_SIT:
						$this->sitOnTable();
						break;
					case P_ACTION_LEAVE:
						$this->leaveTable();
						break;
					case P_ACTION_SITOUT:
						$this->sittingOut();
						break;
					default: break;
				}

				if( $action==P_ACTION_SIT && $this->current_state==H_STATE_CLOSED && $this->activePlayers()>=2 )
				{
					$this->startNewHand();
				}

				$this->saveHand();
				return;
			}
			elseif(	$action==P_ACTION_CKECK || $action==P_ACTION_FOLD || $action==P_ACTION_ALLIN
					|| $action==P_ACTION_RAISE || $action==P_ACTION_CALL )
			{
				$c = $this->nextPlayerIndex($this->dealer_position,P_STATE_ACTING);
				if(!$c) return;

				$this->acp = $this->hand_players[$c];
				if($this->request['request_player_id']!=$this->acp->player_id) return;
				$this->acp->act_times++;

				switch($action)
				{
					case P_ACTION_CKECK:
						$this->Check();
						break;
					case P_ACTION_FOLD:
						$this->Fold();
						break;
					case P_ACTION_ALLIN:
						$this->Allin();
						break;
					case P_ACTION_CALL:
						$this->Raise();
						break;
					case P_ACTION_RAISE:
						$this->Raise();
						break;
					default: break;
				}

				if($this->acp->is_timeout) $this->acp->current_state = P_STATE_SITTING_OUT;
			}

			if(	$action==P_ACTION_CKECK || $action==P_ACTION_FOLD || $action==P_ACTION_ALLIN
					|| $action==P_ACTION_RAISE || $action==P_ACTION_CALL || $fourceful )
			{
				$this->addAnimation("current_state".$this->acp->table_position);
				$this->addAnimation("current_share".$this->acp->table_position);
				$this->addAnimation("table_stack".$this->acp->table_position);

				$bet_over = false;

				$c = $this->nextPlayerIndex($this->acp->table_position,P_STATE_WAITING);

				if(!$c || $this->hand_players[$c]->table_position==$this->acp->table_position || $this->waitingPlayers()<2 )
					$fourceful = true;
				else
				{
					$cp = $this->hand_players[$c];
					if( ($this->current_bet==0 && $cp->act_times>0) || ($this->current_bet>0 && $cp->current_share==$this->current_bet) )
					{
//						if($this->current_bet==0 && $this->current_state==H_STATE_PREFLOP && $cp->table_position==$this->blind_position)
						if($cp->act_times==0)
						{
							$cp->current_state = P_STATE_ACTING;
							$cp->wait_start_time = time();
						}
						else $bet_over = true;
					}
				}

				if($bet_over || $fourceful)
				{
					$this->endBettingRound();
					$this->addAnimation("pots".$this->current_pot);

					if($this->current_state==H_STATE_PREFLOP)
					{
						$this->dealFlop();
						$this->current_state=H_STATE_FLOP;
						$this->addAnimation("community_cards0");
						$this->addAnimation("community_cards1");
						$this->addAnimation("community_cards2");
					}
					elseif($this->current_state==H_STATE_FLOP)
					{
						$this->dealTurn();
						$this->current_state=H_STATE_TURN;
						$this->addAnimation("community_cards3");
					}
					elseif($this->current_state==H_STATE_TURN)
					{
						$this->dealRiver();
						$this->current_state=H_STATE_RIVER;
						$this->addAnimation("community_cards4");
					}
					elseif($this->current_state==H_STATE_RIVER)
					{
						$this->current_state=H_STATE_SHOWDOWN;
						$this->Showdown();
						$this->last_time = time();
					}

					if( (!$fourceful) &&
							($this->current_state==H_STATE_FLOP || $this->current_state==H_STATE_TURN || $this->current_state==H_STATE_RIVER) )
					{
						$c = $this->nextPlayerIndex($this->dealer_position,P_STATE_WAITING);
						if($c)
						{
							$this->hand_players[$c]->current_state = P_STATE_ACTING;
							$this->hand_players[$c]->wait_start_time = time();
						}
					}
				}
				else
				{
					//advance role to next player
					$cp->current_state = P_STATE_ACTING;
					$cp->wait_start_time = time();
					$this->addAnimation("current_state".$cp->table_position);
					$this->addAnimation("action_url".$cp->table_position);
				}
				$this->saveHand();
			}
		}

		function startNewHand()
		{
			// reset all player statistics
			foreach($this->hand_players as $p)
			{
				if($p->table_stack<=0)
				{
					$this->leaveTable($p->player_id);
				}
				else
				{
					unset($p->pocket_cards);
					unset($p->pots_share);
					$p->current_share=0;
					$p->win_html = "";
					$p->act_times = 0;
					if($p->current_state==P_STATE_NEW)
					{
						// was commented not to$p->addToPot($this->minimum_bet,$this->current_pot);
						$p->current_state=P_STATE_WAITING;
					}
					if (!($p->current_state==P_STATE_SITTING_OUT || $p->current_state==P_STATE_NEW || $p->current_state==P_STATE_TIMED_OUT))
						$p->current_state=P_STATE_WAITING;
					$p->savePlayer();
				}
			}

			// reset old and create new db record for new hand
			unset($this->community_cards);
			$this->Deal(); //create new deck and shuffle
			unset($this->pots);
			$this->current_bet=0;
			$this->ischanged=true;

			if($this->activePlayers()>=2)
			{
				$this->hand_id=0;
				$this->current_state = H_STATE_PREFLOP;
				$this->hand_id=$this->saveHand();

				// decide dealer
				$this->decideDealer();

				// pocket cards and blinds
				$this->dealPoketCards();
				$this->postBlinds();
			}
			else
			{
				$this->current_state = H_STATE_PREFLOP;
				$this->saveHand();
			}
		}

		function decideDealer()
		{
			// first time then need to High card, for time being set the starter
			// next onwards move in clockwise, i.e move on left

			if($this->dealer_position==0) // while playing first ever hand
			{
				$k = array_rand($this->hand_players);
				$this->dealer_position = $this->hand_players[$k]->table_position;
			}
			else
			{
				$c = $this->nextPlayerIndex($this->dealer_position,P_STATE_WAITING);
				if($c) $this->dealer_position = $this->hand_players[$c]->table_position;
			}
		}

		function dealPoketCards()
		{
			foreach ($this->hand_players as $p)
			{
				if($p->current_state==P_STATE_WAITING)
				{
					$p->pocket_cards[] = $this->pickCard();
					$p->pocket_cards[] = $this->pickCard();
				}
			}
		}

		function postBlinds()
		{
			// find next position left to the dealer and post his small blind
			//todo: if there are only two players special rule: dealer is big blind
			$c = $this->nextPlayerIndex($this->dealer_position,P_STATE_WAITING);
			if($c)
			{

				$this->hand_players[$c]->addToPot($this->minimum_bet/2,$this->current_pot);

				// find next player position and post big blind
				$c1 = $this->nextPlayerIndex($c,P_STATE_WAITING);
				if($c1)
				{
					$this->hand_players[$c1]->addToPot($this->minimum_bet,$this->current_pot);
					$this->current_bet = $this->hand_players[$c1]->current_share;
					$this->blind_position = $this->hand_players[$c1]->table_position;
				}

				if($c1) // find the next acting player
				{
					$c2 = $this->nextPlayerIndex($c1,P_STATE_WAITING);
					if($c2)
					{
						$this->hand_players[$c2]->current_state = P_STATE_ACTING;
						$this->hand_players[$c2]->wait_start_time = time();
					}
				}
			}
		}

		function dealFlop()
		{
			// deal 3 community cards
			$this->community_cards[] = $this->pickCard();
			$this->community_cards[] = $this->pickCard();
			$this->community_cards[] = $this->pickCard();

			$this->current_state = H_STATE_FLOP;
		}

		function dealTurn()
		{
			// deal 1 turn card
			$this->community_cards[] = $this->pickCard();

			$this->current_state = H_STATE_TURN;
		}

		function dealRiver()
		{
			// deal 1 river card
			$this->community_cards[] = $this->pickCard();

			$this->current_state = H_STATE_RIVER;
		}

// user actions
		function Fold()
		{
			// perfom fold action
			$this->acp->current_state = P_STATE_FOLD;
		}

		function Check()
		{
			// perform check action
			$this->acp->current_state = P_STATE_WAITING;
		}

		function Raise()
		{
			// perform raise action

			$this->acp->addToPot($this->request['bet_val'],$this->current_pot);
			$this->acp->current_state = P_STATE_WAITING;
			$this->current_bet = ($this->acp->current_share>$this->current_bet ? $this->acp->current_share : $this->current_bet);
		}

		function AllIn()
		{
			// perform all in action
			$this->acp->addToPot($this->request['bet_val'],$this->current_pot);
			$this->acp->current_state = P_STATE_ALLIN;
			$this->current_bet = ($this->acp->current_share>$this->current_bet ? $this->acp->current_share : $this->current_bet);
		}

		function Call()
		{
			// perform call action. This is same as the raise option
		}

		function sittingOut()
		{
			$p = $this->getPlayerByID($this->request['request_player_id']);
			if($p) $p->current_state = P_STATE_SITTING_OUT;
		}

		function getPlayerByID($id)
		{
			foreach($this->hand_players as $p) if($p->player_id==$id) return $p;
			return false;
		}

		function sitOnTable()
		{
			global $db;

			if(!isset($this->hand_players[$this->request['request_position']]))
			{
				$hp_id = 0;
				$sql = " SELECT * FROM holdem_hand_palyer WHERE player_id='".$this->request['request_player_id']."' ";
				$pro = $db->mysqlFetchRow($sql);
				if($pro)
				{
					if(intval($pro['table_id'])==0) $hp_id=$pro['id'];
					else
					{
						$this->setLastError("You are already playing on some table");
						return;
					}
				}

				$sql = " SELECT SUM(points) pts FROM points WHERE mid='".$this->request['request_player_id']."' ";
				$ro = $db->mysqlFetchRow($sql);
				if(intval($ro['pts'])<$this->initial_stake)
				{
					$this->setLastError("You do not have sufficient balance to play on this table");
					return;
				}

				$sql = " SELECT * FROM members WHERE id='".$this->request['request_player_id']."' ";
				$ro = $db->mysqlFetchRow($sql);
				if(!$ro)
				{
					$this->setLastError("User not found. Please login and try again");
					return;
				}

				$p = new pokerHoldemPlayer($this->request['table_id'],$this->request['request_player_id']);
				$p->id = $hp_id;
				$p->current_state = P_STATE_NEW;
				$p->table_position = $this->request['request_position'];

				$p->nick_name = $this->request['nick_name'];
				$p->table_stack = $this->request['table_stack'];
				if(intval($p->table_stack)==0) $p->table_stack = $this->initial_stake;
				if($p->nick_name=="") $p->nick_name = $ro['First_Name'];

				$p->last_request_time = time();
				$p->savePlayer();
				$this->hand_players[$this->request['request_position']] = $p;

				$mp = array();
				$mp['mid'] = $p->player_id;
				$mp['edate'] = date("YmdHis");
				$mp['points'] = 0 - $p->table_stack;
				$mp['game'] = "T";
				$db->mysqlAddUpdateRow('points ', $mp);
			}
			else
			{
				$p = $this->hand_players[$this->request['request_position']];
				if($this->request['request_player_id']==$p->player_id && $p->current_state==P_STATE_SITTING_OUT)
				{
					$p->current_state = P_STATE_NEW;
					$p->savePlayer();
				}
			}
		}

		function leaveTable($id=0)
		{
			global $db;

			if($id==0) $id = $this->request['request_player_id'];

			$p = $this->getPlayerByID($id);
			if($p)
			{
				$mp = array();
				$mp['mid'] = $p->player_id;
				$mp['edate'] = date("YmdHis");
				$mp['points'] = $p->table_stack;
				$mp['game'] = "T";
				$tp = $p->table_position;

				$p->table_id = 0;
				$p->table_stack=0;
				$p->pocket_cards = array();
				$p->pots_share = array();
				$p->current_share=0;
				$p->current_state=0;
				$p->wait_start_time=0;
				$p->last_request_time=0;
				$p->table_position=0;
				$p->win_html="";
				$p->act_times=0;

				$p->savePlayer();
				if(intval($mp['points'])>0) $db->mysqlAddUpdateRow('points ', $mp);

				unset($this->hand_players[$tp]);
			}
		}

// closing actions

		function endBettingRound()
		{
			//collect each players bet into main or side pots
			$cs = array();
			foreach($this->hand_players as $k=>$p)
			{
				$p->act_times = 0;
				if($p->current_share>0)
				{
					if($p->current_state==P_STATE_ALLIN || $p->current_state==P_STATE_WAITING)
						$cs[$k] = $p->current_share;
					else
					{
						$this->pots[$this->current_pot] += $p->current_share;
						$p->pots_share[$this->current_pot] += $p->current_share;
						$p->current_share = 0;
					}
				}
			}

			//now split pots further based on allin users
			if(count($cs)>0)
			{
				asort($cs);
				$remain=current($cs); $min=0;
				while($remain>0)
				{
					$min=0;
					foreach($cs as $k=>$cs_val)
					{
						if($min==0) $min = $cs_val;
						if($min>0 && $cs_val>0)
						{
							$p = $this->hand_players[$k];
							$this->pots[$this->current_pot] += $min;
							$p->pots_share[$this->current_pot] += $min;
							$p->current_share -= $min;
							$remain = $cs_val - $min;
							$cs[$k] -= $min;
						}
					}
					if($remain>0)
					{
						$this->current_pot++;
						$this->pots[$this->current_pot] = 0;
					}
				}
			}

			$this->current_bet = 0;

			$this->removeInactivePlayers();
		}

		function removeInactivePlayers()
		{
			foreach($this->hand_players as $p)
			{
				if( (time() - $p->last_request_time)>63 )
				{
					$this->leaveTable($p->player_id);
				}
			}
		}

		function Showdown()
		{
			//calculate all active players rank
			foreach($this->hand_players as $p)
			{
				if($p->current_state==P_STATE_ALLIN || $p->current_state==P_STATE_WAITING)
				{
					$p->best_hand = $this->getPlayerRank($p->pocket_cards);
					$p->win_html = $this->playerWinHtml($p);
				}
			}

			//start from the lowest side pot
			$wins = array();
			foreach($this->pots as $cp=>$pot_value)
			{
				unset($wins); $j=0;
				foreach($this->hand_players as $pk=>$p)
				{
					if( (!empty($p->best_hand)) && (intval($p->pots_share[$cp])>0) )
					{
						$wins[$j]['rank'] = $p->best_hand['rank'];
						$wins[$j++]['key'] = $pk;
					}
				}
				$wins = $this->calculateWinners($wins);
				$aval = intval($pot_value/count($wins));
				$rval = $pot_value-($aval*count($wins));
				$lp=100;
				foreach($wins as $win)
				{
					$pk = $win['key'];
					$p = $this->hand_players[$pk];
					$p->addWinAmount($aval,$cp);
					if($lp>$pk) $lp=$pk;
				}
				$p->addWinAmount($rval,$lp);
			}
		}

		function calculateWinners($wins)
		{
			$remains = array();
			rsort($wins);
			$fr = $wins[0]['rank']; // this is the heighest rank;

			foreach($wins as $win)
			{
				if($win['rank']!=$fr) break;
				$remains[] = $win;
			}

			if(count($remains)==1) return $remains;

			//compare high cards of all remainig players with same rank
			$prevk = array();
			for($i=0; $i<5; $i++)
			{
				$hc = 0; unset($prevk);
				foreach($remains as $k=>$win)
				{
					$pk = $win['key'];
					$cc = $this->hand_players[$pk]->best_hand[$i]['ind'];
					if($cc>$hc)
					{
						$hc = $cc;
						if(!empty($prevk)) foreach($prevk as $tk) if(isset($remains[$tk])) unset($remains[$tk]);
						unset($prevk);
						$prevk[] = $k;
					}
					elseif($cc<$hc)
					{
						if(isset($remains[$k])) unset($remains[$k]);
					}
					else $prevk[] = $k;
					if(count($remains)==1) return $remains;
				}
			}
			return $remains;
		}

		function getPlayerRank($pc)
		{
			$hPair = false; $hTwoPair = false; $hThreeKind = false; $hStraight = false;
			$hFlush = false; $hFullHouse = false; $hFourKind = false; $hStraightFlush = false;
			$hRoyalFlush = false;

			$cards = $card_appear = $card_suits = $card_appear_k = $card_suits_k = array();
			$kik = $best_k = "";

			$c1 = array();
			foreach($pc as $c)
			{
				$c1['ind'] = $this->card_index[$c['value']];
				$c1['value'] = $c['value'];
				$c1['suit'] = $c['suit'];
				$cards[] = $c1;
			}
			foreach($this->community_cards as $c)
			{
				$c1['ind'] = $this->card_index[$c['value']];
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

// some utility functions
		function nextPlayerIndex($c,$state)
		{
			for ($i=1; $i<=$this->numberof_players; $i++)
			{
				$c++;
				if($c>$this->numberof_players) $c=1;
				if( isset($this->hand_players[$c]) && $this->hand_players[$c]->current_state == $state )
				{
					return $c;
				}
			}
			return 0;
		}

		function waitingPlayers()
		{
			$np = 0;
			foreach($this->hand_players as $p)
			{
				if ($p->current_state == P_STATE_WAITING || $p->current_state == P_STATE_ACTING) $np++;
				elseif($p->current_state == P_STATE_ALLIN && $p->current_share>0) $np++;
			}

			return $np;
		}

		function activePlayers()
		{
			$np = 0;
			foreach($this->hand_players as $p)
			{
				if ( !($p->current_state == P_STATE_SITTING_OUT || $p->current_state == P_STATE_TIMED_OUT) ) $np++;
			}
			return $np;
		}

		function setLastError($err)
		{
			$this->last_error = $err;
		}
	} // end of poker holdm class


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

function array2json($arr)
{
	$parts = array();
	$is_list = false;

	//Find out if the given array is a numerical array
	$keys = array_keys($arr);
	$max_length = count($arr)-1;
	if(($keys[0] == 0) and ($keys[$max_length] == $max_length))
	{//See if the first key is 0 and last key is length - 1
		$is_list = true;
		for($i=0; $i<count($keys); $i++)
		{ //See if each key correspondes to its position
			if($i != $keys[$i])
			{ //A key fails at position check.
				$is_list = false; //It is an associative array.
				break;
			}
		}
	}

	foreach($arr as $key=>$value)
	{
		if(is_array($value))
		{ //Custom handling for arrays
			if($is_list) $parts[] = array2json($value); /* :RECURSION: */
			else $parts[] = '"' . $key . '":' . array2json($value); /* :RECURSION: */
		}
		else
		{
			$str = '';
			if(!$is_list) $str = '"' . $key . '":';

			//Custom handling for multiple data types
			if(is_numeric($value)) $str .= $value; //Numbers
			elseif($value === false) $str .= 'false'; //The booleans
			elseif($value === true) $str .= 'true';
			else $str .= '"' . addslashes($value) . '"'; //All other things
			// :TODO: Is there any more datatype we should be in the lookout for? (Object?)

			$parts[] = $str;
		}
	}
	$json = implode(',',$parts);

	if($is_list) return '[' . $json . ']';//Return numerical JSON
	return '{' . $json . '}';//Return associative JSON
}

</script>