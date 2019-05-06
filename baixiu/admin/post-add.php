<?php
require_once '../functions.php';
$current_user = get_cur_user();
$categories = fetch_all('select * from categories');
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Add new post &laquo; Admin</title>
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
        <h1>写文章</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <form class="row" id="addpost" >
        <input style="display:none" value="<?php echo $current_user['id'];?>" name="user_id">
        <div class="col-md-9">
          <div class="form-group">
            <label for="title">标题</label>
            <input required id="title" class="form-control input-lg" name="title" type="text" placeholder="文章标题">
          </div>
          <div class="form-group">
            <label for="content">内容</label>
            <textarea id="content" name="content" required>注意文章内容不能为空，否则无法提交！</textarea>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="slug">别名</label>
            <input id="slug" class="form-control" name="slug" type="text" placeholder="唯一的slug" required>

          </div>
          <div class="form-group">
            <!--<label for="feature">特色图像</label>
            <img class="help-block thumbnail" style="display: none">
            <input id="feature" class="form-control" name="feature" type="file">
            -->
          </div>
          <div class="form-group">
            <label for="category">所属分类</label>
            <select id="category" class="form-control" name="category">

              <?php foreach($categories as $item): ?>
              <option value="<?php echo $item['id']; ?>"><?php echo $item['name']; ?></option>
              <?php endforeach ?>

            </select>
          </div>
          <div class="form-group">
            <label for="created">发布时间</label>
            <input id="created" class="form-control" name="created" readonly>
          </div>
          <div class="form-group">
            <label for="status">状态</label>
            <select id="status" class="form-control" name="status">
              <option value="drafted">草稿</option>
              <option value="published">已发布</option>
              <option value="trashed">回收站</option>
            </select>
          </div>
          <div class="form-group">
            <button class="btn btn-primary" type="submit" id="addpost">保存</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <?php $current_page = 'post-add'; ?>
  <?php include 'inc/sidebar.php'; ?>

  <script src="/baixiu/static/assets/vendors/jquery/jquery.js"></script>
  <script src="/baixiu/static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="/baixiu/static/assets/vendors/ueditor/ueditor.config.js"></script>
  <script src="/baixiu/static/assets/vendors/ueditor/ueditor.all.js"></script>
  <script src="/baixiu/static/assets/vendors/layer/layer.js"></script>
  <script type="text/javascript">
     $(function(){
        var date = new Date();
        var seperator1 = "-";
        var seperator2 = ":";
        var month = date.getMonth() + 1<10? "0"+(date.getMonth() + 1):date.getMonth() + 1;
        var strDate = date.getDate()<10? "0" + date.getDate():date.getDate();
        var currentdate = date.getFullYear() + seperator1  + month  + seperator1  + strDate
        	 + " "  + date.getHours()  + seperator2  + date.getMinutes()
        	 + seperator2 + date.getSeconds();
        $("#created").val(currentdate)
     })
     var ue = UE.getEditor('content');
     $("#addpost").on('submit',function(e){
        e.preventDefault()
        console.log("oooo")
        $.ajax({
            url:'./api/addPost.php',
            type: "post",
            data:$('form').serializeArray(),
            success:function(data){
                if(data == '1'){
                   layer.open({
                     type: 0,
                     title:'提示',
                     icon:1,
                     content: '文章发表成功'
                   });
                }else{
                    layer.open({
                      type: 0,
                      title:'温馨提示',
                      icon:2,
                      content: '文章发表失败<br>请检查是否slug有冲突<br>本系统要求slug唯一！'
                    });
                }
            }
        })
     })
  </script>
  <script>NProgress.done()</script>
</body>
</html>
