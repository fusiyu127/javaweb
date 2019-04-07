<%@ page language="java" contentType="text/html; charset=UTF-8"
    pageEncoding="UTF-8"%>
<%@ page import="java.io.*,java.util.*" %>
<%@ page import="javax.servlet.*,java.text.*" %>
<%
	if(session.getAttribute("fusiyu")==null){
		request.getRequestDispatcher("error.jsp").forward(request, response);
	}
%>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>发布个人日志</title>
<style type="text/css">
	html,body{
            width:100%;
            height: 100%;
            margin:0;
            padding:0
        }
        body{
            background-color: #F5F5D5;
        }
        textarea {
			resize: none;
}
</style>
</head>
<body>
	<%
        Date date = new Date();
        SimpleDateFormat df = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
        String s = df.format(date);
    %>

	<form action="../blogs" method="post">
		<textarea name="content" id="editor"></textarea>
		<br>
		文章标题：<input type="text" name="head" >
		当前时间：<input type="text" readonly="readonly" name="time" value="<%= s%>">
		<input type="submit" value="提交">
	</form>
	<script src="../ckeditor/ckeditor.js"></script>
	<script>CKEDITOR.replace('content', { height: '600px', width: '100%',resize: 'none' })</script>
</body>
</html>