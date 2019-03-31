<%@ page language="java" contentType="text/html; charset=UTF-8"
    pageEncoding="UTF-8"%>
    

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Insert title here</title>
<style type="text/css">
	html{
            width:100%;
            height: 100%;
            margin:0;
            padding:0
        }
        body{
            background-repeat: no-repeat;
            background-attachment:fixed;
            background-size: cover;
            background-position:50% 50%;
            margin:0;
            padding:0;
            width:100%;
            height:100%;
            background-image:url("../images/bg1.jpg");
        }
        #container{
            background-color:rgba(0,0,0,0.2);
            border-radius: 1.5em;
            color: #fefefe;
            overflow: auto;
            position: absolute;
            left: 50%;
            top: 50%;
            width: 500px;
            height:300px;
            margin-left: -250px;
            margin-top: -150px;
        }
        #back{
            width: 80px;
            height: 50px;
            text-align: center;
            background-color:rgba(0,0,0,0.2);
            border-radius: 1.5em;
            color: #fefefe;
            float: right;
            margin-top: 10px;
            margin-right: 10px;
        }
        h3{
            text-align: center;
        }
        #container p{
            width: 300px;
            height: 50px;
            background-color: rgba(0, 0, 0, 0.5);
            margin-left: 100px;
            line-height: 50px;
            border-radius: 0.8em;
            padding-left: 2px;
        }
        a{
            text-decoration: none;
            color: #ffffff;
        }
        #container p:hover {
            background-color: #ffffff;
        }
        #container p:hover a{
            color: #000000;
        }
	
</style>
</head>
<body>
	<%
		if(session.getAttribute("fusiyu")==null){
			request.getRequestDispatcher("error.jsp").forward(request, response);
		}
	%>
	<input type="button" value="返回" id="back">
	<div id="container">
        <h3>hello fsy</h3>
        <div>
            <p>
                »
                <a href="blog.jsp">发布个人日志(Blog)</a>
            </p>
            <p>
                »
                <a href="state.jsp">发布动态</a>
            </p>
            <p>
                »
                <a href="work.jsp">发布小作品</a>
            </p>
        </div>
    </div>
    <script src="../js/jquery-3.0.0.js"></script>
    <script type="text/javascript">
    	$("#back").on("click",function(){
    		window.location.href="../index.html"
    	})
    </script>
</body>
</html>