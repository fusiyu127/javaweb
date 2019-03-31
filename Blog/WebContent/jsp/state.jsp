<%@ page language="java" contentType="text/html; charset=UTF-8"
    pageEncoding="UTF-8"%>
<%
	if(session.getAttribute("fusiyu")==null){
		request.getRequestDispatcher("error.jsp").forward(request, response);
	}
%>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>发布动态</title>
<style type="text/css">
	html{
            width:100%;
            height: 100%;
            margin:0;
            padding:0
        }
        body{
            background-color: #F5F5D5;
        }
</style>
</head>
<body>

</body>
</html>