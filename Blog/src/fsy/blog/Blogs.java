package fsy.blog;

import java.io.IOException;
import java.io.PrintWriter;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.SQLException;

import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;

import com.mysql.jdbc.Connection;

/**
 * Servlet implementation class Blogs
 */
@WebServlet("/blogs")
public class Blogs extends HttpServlet {
	private static final long serialVersionUID = 1L;

	/**
	 * @see HttpServlet#doPost(HttpServletRequest request, HttpServletResponse response)
	 */
	protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		// TODO Auto-generated method stub
		request.setCharacterEncoding("UTF-8");
		String content = request.getParameter("content");
		String head = request.getParameter("head");
		String time = request.getParameter("time");
		
		PrintWriter out = response.getWriter();
		Connection con = null;
		PreparedStatement statement = null;
		
		
		try {
			Class.forName("com.mysql.jdbc.Driver");
			String url = "jdbc:mysql://localhost:3306/blog?characterEncoding=utf8";
			String user = "fusiyu";
			String password = "111111";
			con = (Connection) DriverManager.getConnection(url, user, password);
			
			String sql = "insert into  blogs values(?,?,?)";
			statement = con.prepareStatement(sql);
			statement.setString(1,head);
			statement.setString(2, content);
			statement.setString(3, time);
			
			int result = statement.executeUpdate();
			
			if(result>0) {
				response.sendRedirect("./jsp/success.jsp");
			}
			else {
				response.sendRedirect("./jsp/lose.jsp");
			}
			
		} catch (Exception e) {
			e.printStackTrace();
		}finally {
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

