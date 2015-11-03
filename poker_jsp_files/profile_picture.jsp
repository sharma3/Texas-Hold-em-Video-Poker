<%-- 
    Document   : profile_picture
    Created on : 13 Nov, 2013, 4:43:47 PM
    Author     : samsung
--%>

<%@page import="java.sql.*,java.io.*"%>
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
        <td width="712" height="20"></td><td align="right"><span class="footer"><b>Hello,<% out.println(rs1.getString(11)); %></b>&nbsp;&nbsp;|&nbsp;&nbsp;<a style="COLOR:white" href="my_account.jsp"><b>My Account</b></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a style="COLOR:white" href="index.jsp"><span class="footer"><b>Logout</b></span></a></td>
   </tr>
    </table>
  
<table cellspacing="3" cellpadding="6" width="1024" border="1">
    <tr>
        <td colspan="2">
            
            <center><span class="reg">Upload Your Picture!!</span><br><br><br><br>
        </td>
    </tr>
    </table>
    
<table cellspacing="3" cellpadding="6" width="1024" border="1">    
        <tr>
              <td width="300" align="left"><input type="image" value="<%
              }
    InputStream sImage;
    ResultSet rs=st.executeQuery("SELECT images FROM image where(Email_Id='"+session.getAttribute("uname")+"')");
      if(rs.next()) {
      byte[] bytearray = new byte[1048576];
      int size=0;
      sImage = rs.getBinaryStream(1);
      response.reset();
      response.setContentType("image/jpg");
      while((size=sImage.read(bytearray))!= -1 ){
      response.getOutputStream().write(bytearray,0,size);
  }
}
 con.close();
}     
catch(Exception ex){
out.println("error :"+ex);
}
%>" height="300" width="300"></td>
              <td><span class="regs" align="right">Choose Your Profile Picture<span><br>
                  <INPUT NAME="file" TYPE="file"><br><br><br>
              <a href="upload1.jsp"><img src="images/upload.jpg" height="100" width="100"  border="0" /></a><br><br></td>
        </tr>
        </table>
        <table cellspacing="3" cellpadding="6" width="1024" border="1">    

        <tr>
            <td colspan="2" align="center"><a href="games.jsp"><img src="images/done.jpg" height="100" width="150"  border="0" /></a></td>
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

