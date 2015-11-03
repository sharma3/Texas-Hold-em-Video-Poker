<%-- 
    Document   : state
    Created on : 31 Oct, 2013, 10:23:15 AM
    Author     : samsung
--%>

<%@page contentType="text/html" pageEncoding="UTF-8"%>
<%@page import="java.sql.*"%>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">
 
<%
String country=request.getParameter("count");  
String buffer="<select name='state'><option value='-1'>--Select State--</option>";  
try
{
    Class.forName("sun.jdbc.odbc.JdbcOdbcDriver").newInstance();
    Connection con=DriverManager.getConnection("jdbc:odbc:pubs","root","");
    Statement st=con.createStatement();
    ResultSet rs = st.executeQuery("Select * from state where Country_Id='"+country+"' ");
    while(rs.next())
    {
         buffer=buffer+"<option value='"+rs.getString(1)+"'>"+rs.getString(3)+"</option>";    
    }  
    buffer=buffer+"</select>";  
    response.getWriter().println(buffer); 
 }
 catch(Exception e)
 {
     System.out.println(e);
 }

 %>