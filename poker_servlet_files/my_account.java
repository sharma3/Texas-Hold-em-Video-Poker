/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


import java.io.*;
import java.net.*;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.Statement;

import javax.servlet.*;
import javax.servlet.http.*;

/**
 *
 * @author samsung
 */
public class my_account extends HttpServlet {
   
    /** 
    * Processes requests for both HTTP <code>GET</code> and <code>POST</code> methods.
    * @param request servlet request
    * @param response servlet response
    */
    protected void processRequest(HttpServletRequest request, HttpServletResponse response)
    throws ServletException, IOException {
        response.setContentType("text/html;charset=UTF-8");
        PrintWriter out = response.getWriter();
         HttpSession session=request.getSession(); 
        String firstname=request.getParameter("fname");
        String lastname=request.getParameter("lname");
        String password=request.getParameter("pass");
        String gender=request.getParameter("gen");
        String age=request.getParameter("ag");
        String postalcode=request.getParameter("pc");
        
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
            st.executeUpdate("UPDATE members SET First_Name='"+firstname+"',Last_Name='"+lastname+"',Password='"+password+"',Age='"+age+"',Postal_Code='"+postalcode+"',Gender='"+gender+"' where(Email_Id='"+session.getAttribute("uname")+"')");
            response.sendRedirect("my_account.jsp");
         }    
        catch(java.sql.SQLException sqle)
        {
                out.println(sqle);
        }
        catch(ClassNotFoundException e)
        {
            out.println(e);
        }
        catch(NumberFormatException c)
        {
            out.println(c);
        }
        catch(NullPointerException ne)
        {
            out.println(ne);
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
    protected void doGet(HttpServletRequest request, HttpServletResponse response)
    throws ServletException, IOException {
        processRequest(request, response);
    } 

    /** 
    * Handles the HTTP <code>POST</code> method.
    * @param request servlet request
    * @param response servlet response
    */
    protected void doPost(HttpServletRequest request, HttpServletResponse response)
    throws ServletException, IOException {
        processRequest(request, response);
    }

    /** 
    * Returns a short description of the servlet.
    */
    public String getServletInfo() {
        return "Short description";
    }
    // </editor-fold>
}
