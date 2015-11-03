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
	require("poker_holdem.php");
	validate_session();

	function my_printr($a)
	{
		echo "<pre>";
		print_r($a);
		echo "</pre>";
	}

	$g = new pokerHoldem();
	$g->request['table_id']=$table_id;
	$g->request['request_player_id']=$request_player_id;
	$g->request['action']=$action;
	$g->request['bet_val']=$bet_val;
	$g->request['request_position']=$request_position;
	$g->request['nick_name']=$nick_name;

	$g->getHand();
	$g->performAction();
	$g->drawHand();
</script>