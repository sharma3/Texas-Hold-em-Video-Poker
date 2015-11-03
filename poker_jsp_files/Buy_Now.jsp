<%-- 
    Document   : Buy_Now
    Created on : 15 Feb, 2014, 5:15:17 PM
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
                 String ans=request.getParameter("buy");
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
            
            <center><span class="reg">Buy Chips Here</span><br>
            <span class="tf">Grab Great Offers!!</span></center><br><br>
        </td>
    </tr>
</table>
    <br>
            <br>
                <table>
                    <tr><span class="error1">Enter Your Card Number And Enjoy Your Chips!!<tr>
                    </table>
                    <br>
                        <br>
                            <br>
                                <br>
                                    <br>
    <form action="index.jsp" method="post" name="registration">

<table cellspacing="1" cellpadding="3" width="1024" border="0">
         <tr>
      <td align="right"><span class="tf">Chips:</span></td><td><span class="tf"><% out.println(ans); %></span>
	</td>
	</tr>

           <tr>
      <td align="right"><span class="tf">Email_Id:</span></td><td><input type="text" name="email" required="required" placeholder="Email Id"/>
	</td>
	</tr>

	<tr>
             <td align="right"><span class="tf">Credit Card No:</span></td>
	<td><input type="text" name="ccn" required="required" placeholder="Your Card Number"/>
	</td>
	</tr>


</table>
<br>
    <br>
        <br>
<table>
    <td valign="center" align="left" height="30"><button type="submit" style="background-color:Black;border-color:black;border:'0'"><img  src="images/bch1.jpg" height="70" width="200" border="0" name="I1" /></button></td>
</table>

</form>

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

      	 <tr>
    <td></td>
    <td class=bodytext align=middle height=35>
      <center><span class="tf">&nbsp;© 2010-2014 - GTU</span></center>
		</td>
	</tr>
</table>

</center></body></html>


