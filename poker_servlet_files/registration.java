/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


import java.io.*;
import java.net.*;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.Statement;

import javax.servlet.*;
import javax.servlet.http.*;

/**
 *
 * @author samsung
 */
public class registration extends HttpServlet {
   
    /** 
    * Processes requests for both HTTP <code>GET</code> and <code>POST</code> methods.
    * @param request servlet request
    * @param response servlet response
    */
    protected void processRequest(HttpServletRequest request, HttpServletResponse response)
    throws ServletException, IOException {
        response.setContentType("text/html;charset=UTF-8");
        PrintWriter out = response.getWriter();
        String firstname=request.getParameter("firstname");
        String lastname=request.getParameter("lastname");
        String email=request.getParameter("email");
        String password=request.getParameter("password");
        String gender=request.getParameter("gender");
        String age=request.getParameter("age");
        String country=request.getParameter("country");
        String state=request.getParameter("state");
        String postalcode=request.getParameter("postalcode");
        String date="";
        try 
        {
            out.println("<html>");
            out.println("<head>");
            out.println("<title>Servlet registration</title>");  
            out.println("</head>");
            out.println("<body>");
            out.println("<h1>Servlet registration at " + request.getContextPath () + "</h1>");
            Class.forName("sun.jdbc.odbc.JdbcOdbcDriver");
            Connection con=DriverManager.getConnection("jdbc:odbc:pubs","root","");
            Statement st=con.createStatement();
            Statement st1=con.createStatement();
            Statement st2=con.createStatement();
            Statement st3=con.createStatement();
            Statement st4=con.createStatement();
            ResultSet rs=st.executeQuery("Select * from country where(Country_Id='"+country+"')");
            ResultSet rs1=st1.executeQuery("Select * from state where(State_Id='"+state+"')");
            rs.next();
            rs1.next();
            st2.executeUpdate("insert into members(edate,login,password,email,First_Name,Last_Name,Gender,Age,Country,State,Postal_Code,Email_Id) values ('"+date+"','"+email+"','"+password+"','"+email+"','"+firstname+"','"+lastname+"','"+gender+"','"+Integer.parseInt(age)+"','"+rs.getString(2)+"','"+rs1.getString(3)+"','"+postalcode+"','"+email+"')");
            ResultSet rs2=st3.executeQuery("Select id from members where login='"+email+"'");
            rs2.next();
            st4.executeUpdate("insert into points(mid,edate,points,game) values('"+rs2.getInt("id")+"','"+date+"',5000,'R')");
            response.sendRedirect("index.jsp");      
        } 
        catch(java.sql.SQLException sqle)
        {
              out.println(sqle);
              response.sendRedirect("registration.jsp");
        }
        catch(ClassNotFoundException e)
        {
            out.println(e);
            response.sendRedirect("registration.jsp");
        }
        catch(NumberFormatException c)
        {
            out.println(c);
            response.sendRedirect("registration.jsp");
        }
        catch(NullPointerException ne)
        {
            out.println(ne);
            response.sendRedirect("registration.jsp");
        }
        out.println("</body>");
        out.println("</html>");    
    } 

    // <editor-fold defaultstate="collapsed" desc="HttpServlet methods. Click on the + sign on the left to edit the code.">
    /** 
    * Handles the HTTP <code>GET</code> method.
    * @param request servlet request
    * @param response servlet response
    */
    @Override
    protected void doGet(HttpServletRequest request, HttpServletResponse response)
    throws ServletException, IOException {
        processRequest(request, response);
    } 

    /** 
    * Handles the HTTP <code>POST</code> method.
    * @param request servlet request
    * @param response servlet response
    */
    @Override
    protected void doPost(HttpServletRequest request, HttpServletResponse response)
    throws ServletException, IOException {
        processRequest(request, response);
    }

    /** 
    * Returns a short description of the servlet.
    */
    @Override
    public String getServletInfo() {
        return "Short description";
    }
    // </editor-fold>
}
