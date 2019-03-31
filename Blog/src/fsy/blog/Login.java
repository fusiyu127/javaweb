package fsy.blog;

import java.io.IOException;
import java.io.PrintWriter;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;

import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;

import org.apache.catalina.Session;

import com.mysql.jdbc.Connection;

import fsy.JdbcUtils.JdbcUtils;

/**
 * Servlet implementation class Login
 */
@WebServlet("/login")
public class Login extends HttpServlet {
	private static final long serialVersionUID = 1L;

	/**
	 * @see HttpServlet#doPost(HttpServletRequest request, HttpServletResponse response)
	 */
	protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		// TODO Auto-generated method stub
		String username = request.getParameter("username");
		String passwd = request.getParameter("passwd");
		
		PrintWriter out = response.getWriter();
		Connection con = null;
		PreparedStatement statement = null;
		ResultSet resultSet = null;
		try {
			Class.forName("com.mysql.jdbc.Driver");
			String url = "jdbc:mysql://localhost:3306/blog";
			String user = "fusiyu";
			String password = "111111";
			con = (Connection) DriverManager.getConnection(url, user, password);
			
			String sql = "select * from user where username =? and passwd=?";
			statement = con.prepareStatement(sql);
			statement.setString(1,username);
			statement.setString(2, passwd);
			
			resultSet = statement.executeQuery();
			
			if(resultSet.next()) {
				HttpSession session = request.getSession();
				session.setAttribute(username, passwd);
				out.print("true");
				
			}
			else {
				out.print("false");
			}
			
		} catch (Exception e) {
			e.printStackTrace();
		}finally {
			JdbcUtils.releaseConnection(con);
		}
		
	}

}
