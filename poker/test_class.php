<script language=php>
	class pokerHoldemPlayer
	{
		// player state: VIEWING, WAITING, ACTING, FOLD, ALLIN, SITTING_OUT

		var $hand_id;
		var $player_id;
		var $nick_name;

		// player attributes
		function getPlayer($table_id,$hand_id,$nick_name)
		{
			$this->hand_id = $hand_id;
			$this->table_id = $table_id;
			$this->nick_name = $nick_name;
		}
		
		function savePlayer()
		{
			echo "I am into saving player";
		}
	}

	class pokerHoldem 
	{

		var $hand_players = array();

		function printPlayers()
		{
			$k=1;

			$p = new pokerHoldemPlayer();
			$p->getPlayer(1,1,"player A");
			$this->hand_players[$k++] = $p;

			$p = new pokerHoldemPlayer();
			$p->getPlayer(1,2,"player B");
			$this->hand_players[$k++] = $p;

			$p = new pokerHoldemPlayer();
			$p->getPlayer(1,3,"player C");
			$this->hand_players[$k++] = $p;

			$k=2;
			$t = $this->hand_players[$k];
			echo $t->hand_id." TN :".$t->nick_name."<br>";
			$t->nick_name .= "Its NEW NOW";
			$t->savePlayer();
			echo $this->hand_players[$k]->hand_id." N :".$this->hand_players[$k]->nick_name."<br>";

			$k=3;
			echo $this->hand_players[$k]->hand_id." N :".$this->hand_players[$k]->nick_name."<br>";

			echo "<pre>".print_r($this->hand_players)."</pre>";

		}
	}
	
	$cards = array();
	$cards[]= array('value'=>'2','suit'=>'H');
	$cards[]= array('value'=>'5','suit'=>'S');
	$cards[]= array('value'=>'8','suit'=>'C');
	$cards[]= array('value'=>'10','suit'=>'D');
	$cards[]= array('value'=>'J','suit'=>'H');
	$cards[]= array('value'=>'Q','suit'=>'S');
	$cards[]= array('value'=>'A','suit'=>'C');

	foreach($cards as $k=>$c) echo "K:$k <br>";

	echo "<pre>".print_r($cards)."</pre>";
	arsort($cards);
	echo "<pre>".print_r($cards)."</pre>";

</script>