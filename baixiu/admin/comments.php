<?php
require_once '../functions.php';
get_cur_user();

?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Comments &laquo; Admin</title>
  <link rel="stylesheet" href="/baixiu/static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="/baixiu/static/assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="/baixiu/static/assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="/baixiu/static/assets/css/admin.css">
  <script src="/baixiu/static/assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <?php include 'inc/navbar.php'; ?>

    <div class="container-fluid">
      <div class="page-title">
        <h1>所有评论</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <div class="btn-batch" >
          <button class="btn btn-info btn-sm" style="display: none">批量批准</button>
          <button class="btn btn-warning btn-sm" style="display: none">批量拒绝</button>
          <a class="btn btn-danger btn-sm" href="./api/deleteComment.php" style="display: none" id="delete_btn">批量删除</a>
        </div>
        <ul class="pagination pagination-sm pull-right" id="twbsPagination"></ul>
      </div>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th class="text-center" width="40"><input type="checkbox"></th>
            <th>作者</th>
            <th>评论</th>
            <th>评论在</th>
            <th>提交于</th>
            <th>状态</th>
            <th class="text-center" width="100">操作</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </div>

  <?php $current_page = 'comments'; ?>
  <?php include 'inc/sidebar.php'; ?>

  <script src="/baixiu/static/assets/vendors/jquery/jquery.js"></script>
  <script src="/baixiu/static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="/baixiu/static/assets/vendors/jsrender/jsrender.js"></script>
  <script src="/baixiu/static/assets/vendors/twbs-pagination/jquery.twbsPagination.js"></script>
  <script id="comment_tmpl" type="text/x-jsrender">
    {{for comments}}
        <tr>
           <td class="text-center"><input type="checkbox" data-id="{{:id}}"></td>
           <td>{{:author}}</td>
           <td width="300">{{:content}}</td>
           <td>{{:post_title}}</td>
           <td>{{:created}}</td>
           <td>{{:status}}</td>
           <td class="text-center">
             <!--<a href="post-add.html" class="btn btn-warning btn-xs">驳回</a>-->
             <a href="./api/deleteComment.php?id={{:id}}" class="btn btn-danger btn-xs">删除</a>
           </td>
         </tr>
    {{/for}}
  </script>
  <script>
     //获取总页数
     var totalPages;
     $(function(){
        $.get('./api/getTotalComentPages.php',{},function(data){
            totalPages = parseInt(data)
            $('#twbsPagination').twbsPagination({
                　totalPages: totalPages,
                　visiblePages: 5,
                　first:"首页",
                　prev:"上一页",
                　next:"下一页",
                　last:"末页",
                　loop:false,
                　onPageClick:function(event,index){
                　　　getComments(index)
                　}
               })
        })
     })
    //发送 ajax请求获取评论数据
    function getComments(page){
      $.get('./api/getComments.php',{page:page},function(data){
         var html = $("#comment_tmpl").render({comments:data})
         $("tbody").html(html).fadeIn()
         $(function(){
           $tbodyCheck = $('tbody input')
           var allChecks = []
           $tbodyCheck.on('change',function(){
               //获取自定义属性
               var id = $(this).data('id')
               if($(this).prop('checked')){
                   allChecks.includes(id) || allChecks.push(id)
              }else{
                  allChecks.splice(allChecks.indexOf(id),1)
               }
               allChecks.length ? $('#delete_btn').fadeIn() : $('#delete_btn').fadeOut()
               $('#delete_btn').prop('search','?id=' + allChecks)

           })
          $('thead input').on('change',function(){
               var checked = $(this).prop('checked')
               $tbodyCheck.prop('checked',checked).trigger('change')
           })
       })
      })
    }
  </script>
  <script>
     $(function(){
         $tbodyCheck = $('tbody input')
         console.log($tbodyCheck)
         var allChecks = []
         $tbodyCheck.on('change',function(){
             //获取自定义属性
             var id = $(this).data('id')
             if($(this).prop('checked')){
                 allChecks.includes(id) || allChecks.push(id)
             }else{
                 allChecks.splice(allChecks.indexOf(id),1)
             }
             allChecks.length ? $('#delete_btn').fadeIn() : $('#delete_btn').fadeOut()
             $('#delete_btn').prop('search','?id=' + allChecks)
             console.log(allChecks)
         })
        $('thead input').on('change',function(){
             var checked = $(this).prop('checked')
             $tbodyCheck.prop('checked',checked).trigger('change')
         })
     })
  </script>
  <script>NProgress.done()</script>
</body>
</html>
