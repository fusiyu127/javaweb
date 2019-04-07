<%@ page language="java" contentType="text/html; charset=UTF-8"
    pageEncoding="UTF-8"%>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>日志</title>
</head>
<body>
	<div id="content"></div>
	<script src="../js/jquery-3.0.0.js"></script>
	<%
		String head = request.getParameter("head");
		head = new String(head.getBytes("ISO8859-1"),"UTF-8");
	%>
	<script>
	$(document).ready(function () {
		$.ajax({
			url:"../getcontent?head=<%= head%>",
			success:function(data){
				$("#content").html(data);
			},
			error:function(data){
				alert("请求失败！");
			}
		})
	})
	</script>
</body>
</html>