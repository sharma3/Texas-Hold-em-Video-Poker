<%-- 
    Document   : texas_holdem
    Created on : 18 Oct, 2013, 11:42:35 PM
    Author     : samsung
--%>

<%@page contentType="text/html" pageEncoding="UTF-8"%>
<%@page import="java.sql.*"%>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

 
<html>
<head>
	<title>Texas Holedem And Video Poker</title>
	<META http-equiv=Content-Type content="text/html; charset=windows-1252">
        <link rel="stylesheet" type="text/css" href="style/main.css">
            <link href="style/styles.css" rel="stylesheet" type="text/css" />
          <script src="script/first.js" type="text/javascript" language="JavaScript"></script>
           <script src="script/poker_holdem.js" type="text/javascript" language="JavaScript"></script>
</head>
<body topmargin=0 BGCOLOR="black">
<center>
<table cellSpacing=0 cellPadding=0 width=1024 border=0 height=100>
        <tr>
          <td width="30"></td>
          <td height=21><span class="tom">Texas Hold'em and Video Poker</span><br>
          <span class="sub_title">Turn Into The World Of Poker</span>
	  </td>
	</tr>
</table>
<br>
    <br>
        <%
                 Class.forName("sun.jdbc.odbc.JdbcOdbcDriver").newInstance();
                 Connection con=DriverManager.getConnection("jdbc:odbc:pubs","root","");
                 Statement st=con.createStatement();
                 ResultSet rs = st.executeQuery("Select * from members where(Email_Id='"+session.getAttribute("uname")+"')");
                 int n=0;
                 while(rs.next())
                 {
                     n=rs.getInt("id");
                 %>
                 <table cellspacing="3" cellpadding="0" width="1024" border="0">
                 <tr>
                    <td width="712" height="20"></td><td align="right"><span class="footer"><b>Hello,<% out.println(rs.getString(11)); %></b>&nbsp;&nbsp;|&nbsp;&nbsp;<a style="COLOR:white" href="games.jsp"><b>Games</b></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a style="COLOR:white" href="my_account.jsp"><b>My Account</b></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a style="COLOR:white" href="index.jsp"><span class="footer"><b>Logout</b></span></a></td>
                </tr>
                </table>
                 <%
                 }
                 %>
           
<table cellspacing="3" cellpadding="6" width="1024" border="0">
    <tr>
        <td colspan="2">
            
            <center><span class="reg">Texas Hold'em</span>
        </td>
    </tr>
</table>
    <br>
            <br>

 
<TABLE cellSpacing=0 cellPadding=0 width=961 border=0>						
<script language=javascript> 
	var table_id = 1;
	var request_player_id = <% out.print(n); %>;
</script>
<style> 
div {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; color:#008000; font-weight:bold;}
div.pocket_cards {width:40px;}
div.pots {background-color:black; font-size: 18px; color:#00FFFF;}
div.last_message {font-size: 14px; font-weight:bold; color:#7f0000;}
div.last_error {font-size: 12px; font-weight:bold; color:#ff0000;}
div.current_share {color:#00FFFF;}
div.dealer {color:#00FFFF;}
div.avtar {height:50; width:50;}
.actions1 { cursor: hand; text-decoration:underline; color:#0000FF; }
 
.actions
{
  float: left;
  margin: 2px 5px 2px 5px;
  padding: 2px;
  width: 100px;
  border-top: 1px solid #cccccc;
  border-bottom: 1px solid black;
  border-left: 1px solid #cccccc;
  border-right: 1px solid black;
  background: #cccccc;
  text-align: center;
  text-decoration: none;
  font: normal 10px Verdana;
  color: #0000FF;
	cursor: hand;
}
 
 
.scard {
	font-family: Arial; border:1px solid gray; background-color:white; font-weight:bold; font-size:12px; height:20px; width:20px; 
	float:left; text-align:center;
	}
.dcard {border:1px solid gray; background-color:#000000; height:20px; width:20px; float:left;}
 
.pocket_cards1 {padding-left:5px; width:15px; overflow:hidden;}
 
</style>
<center></center>
<table border="0" width="766" height="351" cellspacing="0" cellpadding="0" align=center>
<tr><td style="background-repeat: no-repeat;" background="http://127.0.01/projects/poker/images/poker-table-sam.png">
 
<table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td width="20%" height=90></td>
    <td width="20%" valign="top" align="center">
				<table border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td>
							<table border="0" width="100%" cellspacing="0" cellpadding="0">
								<tr><td height=22><div id="nick_name1" class="nick_name"></div><div id="table_stack1" class="table_stack"></td></tr>
								<tr><td width="100%"><div id="avtar1" class="avtar"><img src="images/animal1.png"></div></td></tr>
								<tr><td>
									<table>
										<tr>
											<td align="center"><div id="dealer1" class="dealer"></td>
											<td><div id="current_share1" class="current_share"></div></td>
										</tr>
									</table>
								</td></tr>
							</table>
						</td>
						<td valign=top><div id="pocket_cards11" class="pocket_cards1"></div></td>
						<td valign=top><div id="pocket_cards12" class="pocket_cards2"></div></td>
					</tr>
				</table>
			</td>
    <td width="20%" valign="top" align="center">
				<table border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td>
							<table border="0" width="100%" cellspacing="0" cellpadding="0">
								<tr><td height=22><div id="nick_name2" class="nick_name"></div><div id="table_stack2" class="table_stack"></td></tr>
								<tr><td width="100%"><div id="avtar2" class="avtar"><img src="images/animal2.png"></div></td></tr>
								<tr><td>
									<table>
										<tr>
											<td align="center"><div id="dealer2" class="dealer"></td>
											<td><div id="current_share2" class="current_share"></div></td>
										</tr>
									</table>
								</td></tr>
							</table>
						</td>
						<td valign=top><div id="pocket_cards21" class="pocket_cards1"></div></td>
						<td valign=top><div id="pocket_cards22" class="pocket_cards2"></div></td>
					</tr>
				</table>
			</td>
    <td width="20%" valign="top" align="center">
				<table border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td>
							<table border="0" width="100%" cellspacing="0" cellpadding="0">
								<tr><td height=22><div id="nick_name3" class="nick_name"></div><div id="table_stack3" class="table_stack"></td></tr>
								<tr><td width="100%"><div id="avtar3" class="avtar"><img src="images/animal3.png"></div></td></tr>
								<tr><td>
									<table>
										<tr>
											<td align="center"><div id="dealer3" class="dealer"></td>
											<td><div id="current_share3" class="current_share"></div></td>
										</tr>
									</table>
								</td></tr>
							</table>
						</td>
						<td valign=top><div id="pocket_cards31" class="pocket_cards1"></div></td>
						<td valign=top><div id="pocket_cards32" class="pocket_cards2"></div></td>
					</tr>
				</table>
			</td>
    <td width="20%"></td>
  </tr>
  <tr>
    <td width="20%" height=131 valign="middle" align="left">
				<table border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td>
							<table border="0" width="100%" cellspacing="0" cellpadding="0">
								<tr><td width="100%"><div id="avtar8" class="avtar"><img src="images/animal8.png"></div></td></tr>
								<tr><td height=22><div id="nick_name8" class="nick_name"></div><div id="table_stack8" class="table_stack"></td></tr>
							</table>
						</td>
						<td>
							<table border="0" width="100%" cellspacing="0" cellpadding="0">
								<tr>
									<td valign=top><div id="pocket_cards81" class="pocket_cards1"></div></td>
									<td valign=top><div id="pocket_cards82" class="pocket_cards2"></div></td>
								</tr>
								<tr>
									<td align="center"><div id="dealer8" class="dealer"></td>
									<td><div id="current_share8" class="current_share"></div></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
    <td width="60%" colspan="3" align="center" valign="middle">
		
<table border="0" cellpadding="0" cellspacing=0>
  <tr>
    <td width="100%">
      <table border="0" width="100%" cellpadding="0" cellspacing=0>
        <tr>
          <td width="20%" height=60 valign="middle" align="center"><div id="community_cards0" class="community_cards"></div></td>
          <td width="20%" valign="middle" align="center"><div id="community_cards1" class="community_cards"></div></td>
          <td width="20%" valign="middle" align="center"><div id="community_cards2" class="community_cards"></div></td>
          <td width="20%" valign="middle" align="center"><div id="community_cards3" class="community_cards"></div></td>
          <td width="20%" valign="middle" align="center"><div id="community_cards4" class="community_cards"></div></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td width="100%" align="center">
			<table border=0 cellpadding=0 cellspacing="2">
				<tr>
					<td height=30 width=30><img src="images/chip-hp.png" border=0></td>
					<td><div id="pots0" class="pots"></div></td>
					<td><div id="pots1" class="pots"></div></td>
					<td><div id="pots2" class="pots"></div></td>
					<td><div id="pots3" class="pots"></div></td>
					<td><div id="pots4" class="pots"></div></td>
				</tr>
			</table>
		</td>
  </tr>
</table>
 
		</td>
    <td width="20%" valign="middle" align=right>
				<table border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td>
							<table border="0" width="100%" cellspacing="0" cellpadding="0">
								<tr>
									<td valign=top><div id="pocket_cards41" class="pocket_cards1"></div></td>
									<td valign=top><div id="pocket_cards42" class="pocket_cards2"></div></td>
								</tr>
								<tr>
									<td align="center"><div id="dealer4" class="dealer"></td>
									<td><div id="current_share4" class="current_share"></div></td>
								</tr>
							</table>
						</td>
						<td>
							<table border="0" width="100%" cellspacing="0" cellpadding="0">
								<tr><td width="100%"><div id="avtar4" class="avtar"><img src="images/animal4.png"></div></td></tr>
								<tr><td height=22><div id="nick_name4" class="nick_name"></div><div id="table_stack4" class="table_stack"></td></tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
  </tr>
  <tr>
    <td width="20%" height=90></td>
    <td width="20%" height="80" valign="bottom" align="center">
				<table border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td>
							<table border="0" width="100%" cellspacing="0" cellpadding="0">
								<tr><td>
									<table>
										<tr>
											<td align="center"><div id="dealer7" class="dealer"></td>
											<td><div id="current_share7" class="current_share"></div></td>
										</tr>
									</table>
								</td></tr>
								<tr><td width="100%"><div id="avtar7" class="avtar"><img src="images/animal7.png"></div></td></tr>
								<tr><td height=22><div id="nick_name7" class="nick_name"></div><div id="table_stack7" class="table_stack"></td></tr>
							</table>
						</td>
						<td valign=bottom><div id="pocket_cards71" class="pocket_cards1"></div></td>
						<td valign=bottom><div id="pocket_cards72" class="pocket_cards2"></div></td>
					</tr>
				</table>
			</td>
    <td width="20%" valign="bottom" align="center">
				<table border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td>
							<table border="0" width="100%" cellspacing="0" cellpadding="0">
								<tr><td>
									<table>
										<tr>
											<td align="center"><div id="dealer6" class="dealer"></td>
											<td><div id="current_share6" class="current_share"></div></td>
										</tr>
									</table>
								</td></tr>
								<tr><td width="100%"><div id="avtar6" class="avtar"><img src="images/animal6.png"></div></td></tr>
								<tr><td height=22><div id="nick_name6" class="nick_name"></div><div id="table_stack6" class="table_stack"></td></tr>
							</table>
						</td>
						<td valign=bottom><div id="pocket_cards61" class="pocket_cards1"></div></td>
						<td valign=bottom><div id="pocket_cards62" class="pocket_cards2"></div></td>
					</tr>
				</table>
			</td>
    <td width="20%" valign="bottom" align="center">
				<table border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td>
							<table border="0" width="100%" cellspacing="0" cellpadding="0">
								<tr><td>
									<table>
										<tr>
											<td align="center"><div id="dealer5" class="dealer"></td>
											<td><div id="current_share5" class="current_share"></div></td>
										</tr>
									</table>
								</td></tr>
								<tr><td width="100%"><div id="avtar5" class="avtar"><img src="images/animal5.png"></div></td></tr>
								<tr><td height=22><div id="nick_name5" class="nick_name"></div><div id="table_stack5" class="table_stack"></td></tr>
							</table>
						</td>
						<td valign=bottom><div id="pocket_cards51" class="pocket_cards1"></div></td>
						<td valign=bottom><div id="pocket_cards52" class="pocket_cards2"></div></td>
					</tr>
				</table>
			</td>
    <td width="20%"></td>
  </tr>
</table>
 
</td></tr>
 
<tr>
	<td width="100%" height=50>
		<div id="last_message" class="last_message"></div>
		<div id="main_action" class="main_action"></div>
		<div id="last_error" class="last_error"></div>
		<form method=post action="#" name="action_form">
			<div id="action_url" class="action_url"></div>
		</form>
	</td>
</tr>
</table>
 
 
<div id="debgdiv" style="display:block;"></div>
					
			</table>
	
 
<table cellSpacing=0 cellPadding=0 width=1024 border=0>
  
    <td></td>
    <td class=bodytext align=middle height=50>
			<strong>
				<span class="footer">
				<a style="COLOR:white" href="index.jsp">Home</a>&nbsp;&nbsp;|&nbsp;&nbsp;
				<a style="COLOR:white" href="registration.jsp">Register</a>&nbsp;&nbsp;|&nbsp;&nbsp;
				<a style="COLOR:white" href="about_game.jsp">About Game</a>&nbsp;&nbsp;|&nbsp;&nbsp;
				<a style="COLOR:white" href="Buy_Chips.jsp">Buy Chips</a>&nbsp;&nbsp;|&nbsp;&nbsp;
                                <a style="COLOR:white" href="faq.jsp">FAQ</a>&nbsp;&nbsp;|&nbsp;&nbsp;
				<a style="COLOR:white" href="feedback.jsp">Feedback</a>&nbsp;&nbsp;|&nbsp;&nbsp;
				<a style="COLOR:white" href="contact_us.jsp">Contact Us</a>
				
                                 </span>
			</strong>

      	 <tr><
    <td></td>
    <td class=bodytext align=middle height=35>
      <center><span class="tf">&nbsp;© 2010-2014 - GTU</span></center>
		</td>
	</tr>
</table>

</center></body></html>
