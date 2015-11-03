<%-- 
    Document   : games
    Created on : 18 Oct, 2013, 11:42:06 PM
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
                 Statement st1=con.createStatement();
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
            
            <center><span class="reg">Select Your Game</span><br>
            <span class="tf">Just Click Away From Game.</span></center><br><br>
        </td>
    </tr>
</table>
<%
ResultSet rs1=st1.executeQuery("Select sum(points) pts from points where(mid='"+n+"')");
rs1.next();
%>
<table cellspacing="3" cellpadding="0" width="1024" border="0">
                 <tr>
                    <td align="right"><span class="sub_title"><b>Total Chips:<span class="red"><% out.println(rs1.getInt("pts")); %></b></td>
                </tr>
                </table>
                
    <br>
            <br>
    <table cellspacing="3" cellpadding="6" width="1024" border="0">

    <tr>
        <td><center><span class="a1">Texas Hold'em</span></center><br></td>
        <td><center><span class="a1">Video Poker</span></center><br></td>
    </tr>
    <tr>
        <td><center><a href="texas_holdem.jsp"><img src="images/texas1.jpg" height="300" width="300" /></a><br><br>
        <a style="color:white" href="texas_holdem.jsp"><span class="sub_title">Click Here For Start To Play</span></a></center></td>
        <td><center><a href="http://localhost/projects/poker/poker_video_deal.php?act=video&guserid=<% out.print(n); %>" onclick="window.open('http://localhost/projects/poker/poker_video_deal.php?act=video&guserid=<% out.print(n); %>','popup','width=550,height=600,scrollbars=no,resizable=no,toolbar=no,directories=no,location=no,menubar=no,status=no,left=0,top=0'); return false"><img src="images/poker.jpg" height="300" width="300" /></a><br><br>
        <a style="color:white" href="http://localhost/projects/poker/poker_video_deal.php?act=video&guserid=<% out.print(n); %>" onclick="window.open('http://localhost/projects/poker/poker_video_deal.php?act=video&guserid=<% out.print(n); %>','popup','width=550,height=600,scrollbars=no,resizable=no,toolbar=no,directories=no,location=no,menubar=no,status=no,left=0,top=0'); return false"><span class="sub_title">Click Here For Start To Play</span></a></center></td>
    </tr>
</table>
<br>
    <br>
        <br>
            <br>
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
                         </td>
      	 <tr>
    <td></td>
    <td class=bodytext align=middle height=35>
      <center><span class="tf">&nbsp;© 2010-2014 - GTU</span></center>
		</td>
	</tr>
</table>

</center></body></html>
