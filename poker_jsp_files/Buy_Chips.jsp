<%-- 
    Document   : Buy_Chips
    Created on : 15 Feb, 2014, 4:20:41 PM
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
                    <tr><span class="error1">Just select the offer and enter credit card number to buy chips.<tr>
                    </table>
                    <br>
                        <br>
                            <br>
                                <br>
                                    <br>
    <form action="Buy_Now.jsp" method="post" name="Buy_Now">

<table cellspacing="4" cellpadding="20" width="1024" border="0">
    	<tr>
	<td><input type="radio" name="buy" value="Buy 1k Chips For Just 1$." checked="checked">
         <span class="tf">Buy 1k Chips For Just 1$.</span></td>
         <td><input type="radio" name="buy" value="Buy 10M Chips For Just 150$.">
         <span class="tf">Buy 10M Chips For Just 150$.</span></td>
         </tr>
         
         <tr>
         <td><input type="radio" name="buy" value="Buy 10k Chips For Just 5$." class="style9">
         <span  class="tf">Buy 10k Chips For Just 5$.</span></td>
         <td><input type="radio" name="buy" value="Buy 15M Chips For Just 200$.">
         <span class="tf">Buy 15M Chips For Just 200$.</span></td>
         </tr>
        
         <tr>
        <td><input type="radio" name="buy" value="Buy 50k Chips For Just 15$." class="style9">
        <span  class="tf">Buy 50k Chips For Just 15$.</span></td>
        <td><input type="radio" name="buy" value="Buy 20M Chips For Just 225$.">
         <span class="tf">Buy 20M Chips For Just 225$.</span></td>
	</tr>
        
        <tr>
          <td><input type="radio" name="buy" value="Buy 1M Chips For Just 25$." class="style9">
        <span  class="tf">Buy 1M Chips For Just 25$.</span></td>
        <td><input type="radio" name="buy" value="Buy 25M Chips For Just 300$.">
         <span class="tf">Buy 25M Chips For Just 300$.</span></td>
	</tr>
         
        <tr>
            <td><input type="radio" name="buy" value="Buy 2M Chips For Just 40$." class="style9">
            <span  class="tf">Buy 2M Chips For Just 40$.</span></td>
            <td><input type="radio" name="buy" value="Buy 30M Chips For Just 400$.">
         <span class="tf">Buy 30M Chips For Just 400$.</span></td>
	</tr>
         
        <tr>
            <td><input type="radio" name="buy" value="Buy 5M Chips For Just 75$." class="style9">
        <span  class="tf">Buy 5M Chips For Just 75$.</span></td>
        <td><input type="radio" name="buy" value="Buy 50M Chips For Just 500$.">
         <span class="tf">Buy 50M Chips For Just 500$.</span></td>
	</tr>


</table>
<br>
    <br>
        <br>
<table>
    <td valign="center" align="left" height="30"><button type="submit" style="background-color:Black;border-color:black;border:'0'"><img  src="images/bch.jpg" height="70" width="200" border="0" name="I1" /></button></td>
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

