var resultSet={};
var action="";
var bet_val=0;
var request_position=0;

var debug = false;

function playTurn()
{
	updateSearch();
}

function playSitOn(act,rpos)
{
	action = act;
	request_position = rpos;
	updateSearch();
}

function playAction(act,bet)
{
	action = act;
	bet_val = bet;
	updateSearch();
}

function updateSearch()
{
	var request;
	var postString;
	postString = constructPostString();
	var opt={};
	var opt={method:'post',postBody:postString,onSuccess:mainBack};

	//alert(postString);
	request=new Ajax.Request('http://127.0.0.1//projects/poker/poker_play_holdem.php',opt);
};

function mainBack(http_request)
{
	debgdiv('<textarea rows=10 cols=100>'+http_request.responseText+'</textarea>');
	//alert(http_request.responseText);
	if(http_request.readyState==4)
	{
		if(http_request.status==200)
		{
			var json_data=http_request.responseText;
			try
			{
				resultSet=eval('('+json_data+')');
			}
			catch(e)
			{
				debgdiv("mainBack: error parsing JSON:\n"+e);
			}
			refreshHtml();
		}
	}
}

function constructPostString()
{
	var postString;
	postString="";
	postString+="&table_id="+table_id;
	postString+="&request_player_id="+request_player_id;
	postString+="&action="+action;
	postString+="&bet_val="+bet_val;
	postString+="&request_position="+request_position;
	
	action="";
	bet_val=0;
	request_position=0;

	return postString;
}

function debgdiv(dbgtxt)
{
	if(debug)
		new Insertion.Top('debgdiv',dbgtxt+"<br />");
}

function refreshHtml()
{
	var dealer_position = resultSet['dealer_position'];

	var last_message = resultSet['last_message'];
	var last_message_b = $('last_message');
	last_message_b.innerHTML = last_message;

	var last_error = resultSet['last_error'];
	if(last_error!="")
	{
		var last_error_b = $('last_error');
		last_error_b.innerHTML = last_error;
	}

	var main_action = resultSet['main_action'];
	var main_action_b = $('main_action');
	main_action_b.innerHTML = main_action;

//animations
	var animation_queue = resultSet['animation_queue'];
	for(var i=0;i<animation_queue.length;i++)
	{
//		Element.hide(animation_queue[i]);
//		new Effect.Appear(animation_queue[i],{queue:{scope:"fadeInOut",position:'end'}});
	}


//community_cards
	var community_cards=resultSet['community_cards'];
	var community_card;
	var community_card_b;
	for(var i=0;i<community_cards.length;i++)
	{
		community_card = 'community_cards'+i;
		community_card_b = $(community_card);
		community_card_b.innerHTML = community_cards[i];
	}

//pots
	var pots=resultSet['pots'];
	var pot;
	var pot_b;
	for(var i=0;i<pots.length;i++) { pot = 'pots'+i; pots_b = $(pot); pots_b.innerHTML = pots[i]; }
	for(var j=i;j<5;j++){ pot = 'pots'+j; pots_b = $(pot); pots_b.innerHTML = ""; }

//palyers
	var players=resultSet['players'];
	var ind, nick_name, pocket_cards, current_state, current_share, action_url, table_stack;
	var nick_name_b, pocket_cards_b, pocket_cards_b2, current_state_b, current_share_b, action_url_b, table_stack_b;

	action_url = 'action_url';
	action_url_b = $(action_url);
	action_url_b.innerHTML = "";

	for(var i=0;i<players.length;i++)
	{
		ind = i+1;
		
		nick_name = 'nick_name'+ind;
		dealer = 'dealer'+ind;
		pocket_cards = 'pocket_cards'+ind;
		current_state = 'current_state'+ind;
		current_share = 'current_share'+ind;
		table_stack = 'table_stack'+ind;

		nick_name_b = $(nick_name);
		dealer_b = $(dealer);
		pocket_cards_b = $(pocket_cards+'1');
		pocket_cards_b2= $(pocket_cards+'2');
//hhr		current_state_b = $(current_state);
		current_share_b = $(current_share);
		table_stack_b = $(table_stack);

		nick_name_b.innerHTML = players[i].nick_name;

		if(ind == dealer_position)
			dealer_b.innerHTML = 'D';
		else dealer_b.innerHTML = '';

		pocket_cards_b.innerHTML = players[i].pocket_cards[0];
		pocket_cards_b2.innerHTML = players[i].pocket_cards[1];
//hhr		current_state_b.innerHTML = players[i].current_state;
		current_share_b.innerHTML = players[i].current_share;
		table_stack_b.innerHTML = players[i].table_stack;
		if(players[i].action_url!="") action_url_b.innerHTML = players[i].action_url;
	}
}
window.setInterval("playTurn()", 4000);
