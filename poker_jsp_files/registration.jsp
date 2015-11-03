<%-- 
    Document   : registration
    Created on : 18 Oct, 2013, 11:39:14 PM
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
        
<table cellspacing="3" cellpadding="3" width="1024" border="0">
    <form action="registration" method="post" name="registration" onSubmit="return validateForm();">
    <tr>
        <td colspan="2">
            
            <center><span class="reg">Register Here For Virtual Casino</span><br>
            <span class="tf">It's Free & Always Will BE!!</span></center><br><br>
        </td>
    </tr>
  <tr>
      <td align="right"><span class="tf">First Name:</span></td><td><input type="text" name="firstname" required="required" placeholder="First Name" size="50" />
	</td>
	</tr>

	<tr>
             <td align="right"><span class="tf">Last Name:</span></td>
	<td><input type="text" name="lastname" required="required" placeholder="Last Name" size="50" />
	</td>
	</tr>

	<tr>
             <td align="right"><span class="tf">Email:</span></td>
	<td><input type="text" name="email" required="required" placeholder="Email Address" size="50" />
	</td>
	</tr>

	<tr>
             <td align="right"><span class="tf">Password:</span></td>
	<td><input type="password" name="password" required="required" placeholder="Your Password" size="50" />
	</td>
	</tr>

	<tr>
             <td align="right"><span class="tf">Confirm Password:</span></td>
	<td>
        <input type="password" name="confpass" required="required" placeholder="Re-Enter Your Password" size="50" /></td>
	</tr>

	<tr>
             <td align="right"><span class="tf">Gender:</span></td>
	<td><input type="radio" name="gender" value="male" checked="checked">
	<span class="tf">Male</span><input type="radio" name="gender" value="female" class="style9">
        <span  class="tf">Female</span></td>
	</tr>

	<tr>
             <td align="right"><span class="tf">Age:</span></td>
	<td><input type="text" name="age"  required="required" placeholder="Your Age"></td>
        </tr>


	<tr>
             <td align="right"><span class="tf">Country:</span></td>
             <td><select name="country" id="country" onChange="showState(this.value);"> 
                 <option value="0">--Select Country--</option>
                 <%
                 Class.forName("sun.jdbc.odbc.JdbcOdbcDriver").newInstance();
                 Connection con=DriverManager.getConnection("jdbc:odbc:pubs","root","");
                 Statement st=con.createStatement();
                 ResultSet rs = st.executeQuery("Select * from country");
                 while(rs.next())
                 {
                 %>
                     <option value="<%=rs.getString(1)%>"><%=rs.getString(2)%></option>  
                 <%
                 }
                 %>
                </select>  
                </td>
	</tr>

	
	<tr>
        <td align="right"><span class="tf">State:</span></td>
	<td><div id='state1'>  
      <select name='state' id="state" >  
      <option value="0">--Select State--</option>
          
      </select>
      </div></td>
	</tr>

	<tr>
             <td align="right"><span class="tf">Postal Code:</span></td>
	<td><input type="text" name="postalcode" required="required" placeholder="Your PostalCode" size="50" /><br>
         </td>
	</tr>
         <tr>
             <td></td>
         </tr>
         <tr>
             <td></td>
         </tr>
   	<tr>
             <td></td>
         </tr>
         <tr>
           <td></td><td align="left"><button type="submit" style="background-color:Black;border-color:black;border:'0'"><img src="images/n.jpg"  height="100" width="300" alt="submit"></button></td>
        </tr>

</form>
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

      	 <tr>
    <td></td>
    <td class=bodytext align=middle height=35>
      <center><span class="tf">&nbsp;© 2010-2014 - GTU</span></center>
		</td>
	</tr>
</table>

</center></body></html>
