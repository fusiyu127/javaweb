package fsy.blog;

import java.io.IOException;
import java.io.PrintWriter;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;

import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;

import com.mysql.jdbc.Connection;



/**
 * Servlet implementation class Getblogs
 */
@WebServlet("/getblogs")
public class Getblogs extends HttpServlet {
	private static final long serialVersionUID = 1L;

	/**
	 * @see HttpServlet#doGet(HttpServletRequest request, HttpServletResponse response)
	 */
	protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		// TODO Auto-generated method stub
		
		response.setHeader("Content-type", "text/html;charset=UTF-8");  
		response.setCharacterEncoding("UTF-8");  
		
		PrintWriter out = response.getWriter();
		Connection con = null;
		PreparedStatement statement = null;
		ResultSet resultSet = null;
		try {
			Class.forName("com.mysql.jdbc.Driver");
			String url = "jdbc:mysql://localhost:3306/blog?characterEncoding=utf8";
			String user = "fusiyu";
			String password = "111111";
			con = (Connection) DriverManager.getConnection(url, user, password);
			
			String sql = "select time,head from blogs ";
			statement = con.prepareStatement(sql);
			
			List<String> blogs = new ArrayList<String>();
			
			resultSet = statement.executeQuery();
			
			while(resultSet.next()) {
				String blog = "{\"time\":\""+resultSet.getString("time")+"\",\"head\":\""+resultSet.getString("head")+"\"}";
				blogs.add(blog);
			}
			
			out.print(blogs);
			
		} catch (Exception e) {
			e.printStackTrace();
		}finally {

			try {
				if(resultSet != null)
					resultSet.close();
			} catch (SQLException e2) {
				e2.printStackTrace();
			}
			
			try {
				if(statement != null)
					statement.close();
			} catch (SQLException e2) {
				e2.printStackTrace();
			}

			try {
				if(con != null)
					con.close();
			} catch (SQLException e2) {
				e2.printStackTrace();
			}

		
		}
		
	}

}


