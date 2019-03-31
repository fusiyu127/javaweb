package fsy.JdbcUtils;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;

public class JdbcUtils {
	public static Connection getConnection() {
		Connection con = null;
		try {
			Class.forName("com.mysql.jdbc.Driver");
			String url = "jdbc:mysql://localhost:3306/blog?useUnicode=true&characterEncoding=UTF-8";
			String user = "fusiyu";
			String password = "111111";
			con = DriverManager.getConnection(url, user, password);
			
		} catch (Exception e) {
			e.printStackTrace();
		}
		return con;
	}
	
	public static void releaseConnection(Connection con) {
		try {
			if(con != null)
				con.close();
		} catch (SQLException e2) {
			e2.printStackTrace();
		}
	}
}
