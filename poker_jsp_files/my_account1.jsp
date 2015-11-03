<%-- 
    Document   : my_account1
    Created on : 7 Nov, 2013, 5:28:12 PM
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
        <script src="script/reg.js" type="text/javascript" language="JavaScript"></script>
        
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
        try
                {
                 Class.forName("sun.jdbc.odbc.JdbcOdbcDriver").newInstance();
                 Connection con=DriverManager.getConnection("jdbc:odbc:pubs","root","");
                 Statement st=con.createStatement();
                 Statement st1=con.createStatement();
                 ResultSet rs1 = st1.executeQuery("Select * from members where(Email_Id='"+session.getAttribute("uname")+"')");
                 while(rs1.next())
                 {
             
        %>           
      
      <table cellspacing="3" cellpadding="0" width="1024" border="0">
    <tr>
        <td width="712" height="20"></td><td align="right"><span class="footer"><b>Hello,<% out.println(rs1.getString(11)); %></b>&nbsp;&nbsp;|&nbsp;&nbsp;<a style="COLOR:white" href="games.jsp"><b>Games</b></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a style="COLOR:white" href="my_account.jsp"><b>My Account</b></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a style="COLOR:white" href="index.jsp"><span class="footer"><b>Logout</b></span></a></td>
   </tr>
    </table>
  
<table cellspacing="3" cellpadding="6" width="1024" border="0">
    <tr>
        <td colspan="2">
            
            <center><span class="reg">My Account</span><br>
            <span class="tf">Check Your Profile!!</span></center><br><br>
        </td>
        </table>
        <%
                 }
                 ResultSet rs = st.executeQuery("Select * from members where(Email_Id='"+session.getAttribute("uname")+"')");
                 while(rs.next())
                 {
                   
        %>
       
        <form name="myaccount1" method="post" action="my_account"  onSubmit="return validateForm();">
        <table cellspacing="6" cellpadding="6" width="1024" border="0">

                 <tr class="tf"><td align="right" width="512"><b>Email-Id:<b></td>
                 <td><% out.println(rs.getString(4));%></td></tr>
                 <tr class="tf"><td align="right" width="512"><b>Password:<b></td>
                 <td><input type="text" name="pass" value="<% out.println(rs.getString(5));%>" required="required"></td></tr>
                 <tr class="tf"><td align="right" width="512"><b>First Name:<b></td>
                 <td><input type="text" name="fname" value="<% out.println(rs.getString(11));%>" required="required"></td></tr>
                 <tr class="tf"><td align="right" width="512"><b>Last Name:<b></td>
                 <td><input type="text" name="lname" value="<% out.println(rs.getString(12));%>" required="required"></td></tr>
                 <tr class="tf"><td align="right" width="512"><b>Gender:<b></td>
                 <td><input type="radio" name="gender" value="male" checked="checked">
                 <span class="tf">Male</span><input type="radio" name="gender" value="female" class="style9">
                 <span  class="tf">Female</span></td></tr>
                 <tr class="tf"><td align="right" width="512"><b>Age:<b></td>
                 <td><input type="text" name="ag" value="<% out.println(rs.getString(14));%>" required="required"></td></tr>
                 <tr class="tf"><td align="right" width="512"><b>Country:<b></td>
                 <td><% out.println(rs.getString(15));%></td></tr>
                 <tr class="tf"><td align="right" width="512"><b>State:<b></td>
                 <td><% out.println(rs.getString(16));%></td></tr>
                 <tr class="tf"><td align="right" width="512"><b>Postal Code:<b></td>
                 <td><input type="text" name="pc" value="<% out.println(rs.getString(17));%>" required="required"></td></tr>
                 <tr class="tf"><td colspan="2" align="center">
                 <button type="submit" style="background-color:Black;border-color:black;border:'0'"><img src="images/save.jpg"  height="50" width="150" alt="submit"></button></td></tr>  
                </table>
                </form>

        <%             
                 }
        }
        catch(Exception e)
        {
                out.println(e);
        }
        %>
              
      
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
