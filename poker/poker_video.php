<script language=php>
	require_once("poker_cards.php");

	class pokerVideo extends Cards
	{
		function calculatePoints($result)
		{
			switch($result)
			{
				case 'RF'	: return 10;
				case 'SF'	: return 8;
				case 'FK'	: return 6;
				case 'FH'	: return 5;
				case 'F'	: return 4;
				case 'S'	: return 3;
				case 'TK'	: return 2;
				case 'TP'	: return 1;
				case 'P'	: return 0;
				case 'HC'	: return -1;
				default : return 0;
			}
		}
	}
</script>
