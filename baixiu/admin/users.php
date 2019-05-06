<?php
require_once '../functions.php';
get_cur_user();

//处理数据转换,将状态转换为中文
function convert_status($status){
    $dict = array(
    'activated' => '激活'
    );
    return isset($dict[$status]) ? $dict[$status] : '未知状态';
}
function add_user(){
    $slug = $_POST['slug'];
    $email = $_POST['email'];
    $nickname = $_POST['nickname'];
    $password = $_POST['password'];

    $result = execute("insert into users VALUES(null,'{$slug}','{$email}','{$password}','{$nickname}','/baixiu/static/uploads/an3_3.jpg',null,'activated');");
    if($result <= 0){
        $GLOBALS['success'] = false;
        $GLOBALS['message'] = "添加失败！";
     }
    else{
        $GLOBALS['success'] = true;
        $GLOBALS['message'] = "添加成功！";
    }
}

function edit_user(){
    $slug = $_POST['slug'];
    $email = $_POST['email'];
    $nickname = $_POST['nickname'];
    $password = $_POST['password'];

    $result = execute("update users set slug='{$slug}',nickname='{$nickname}',email='{$email}',password='{$password}' where id = {$_GET['id']};");

    if($result <= 0){
        $GLOBALS['success'] = false;
        $GLOBALS['message'] = "修改失败！";
     }
    else{
        $GLOBALS['success'] = true;
        $GLOBALS['message'] = "修改成功！";
    }
}

//添加用户
//表单提交请求
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(empty($_GET['id'])){
        add_user();
    }else{
        edit_user();
    }

}

//编辑用户
if(!empty($_GET['id'])){
    $edit_user = fetch_one('select * from users where id = '.$_GET['id']);
}

$users = fetch_all('select * from users');

?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Users &laquo; Admin</title>
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
        <h1>用户</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <?php if(isset($message)): ?>
      <?php if($success): ?>
          <div class="alert alert-success">
            <strong>成功！</strong><?php echo $message; ?>
          </div>

       <?php else: ?>
           <div class="alert alert-danger">
              <strong>失败！</strong><?php echo $message; ?>
           </div>
       <?php endif ?>
       <?php endif ?>
      <div class="row">
        <div class="col-md-4">

          <?php if(isset($edit_user)): ?>
          <form action="<?php echo $_SERVER['PHP_SELF'] ?>?id=<?php echo $edit_user['id']; ?>" method="post">
            <h2>编辑用户</h2>
            <div class="form-group">
              <label required for="email">邮箱</label>
              <input id="email" class="form-control" name="email" type="email" value="<?php echo $edit_user['email'] ?>">
            </div>
            <div class="form-group">
              <label for="slug">别名</label>
              <input required id="slug" class="form-control" name="slug" type="text" value="<?php echo $edit_user['slug'] ?>">

            </div>
            <div class="form-group">
              <label for="nickname">昵称</label>
              <input required id="nickname" class="form-control" name="nickname" type="text" value="<?php echo $edit_user['nickname'] ?>">
            </div>
            <div class="form-group">
              <label for="password">密码</label>
              <input required id="password" class="form-control" name="password" type="password" value="<?php echo $edit_user['password'] ?>">
            </div>
            <div class="form-group">
              <button class="btn btn-primary" type="submit">保存</button>
            </div>
          </form>
          <?php else: ?>
          <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
             <h2>添加新用户</h2>
             <div class="form-group">
               <label for="email">邮箱</label>
               <input required id="email" class="form-control" name="email" type="email" placeholder="邮箱">
             </div>
             <div class="form-group">
               <label for="slug">别名</label>
               <input required id="slug" class="form-control" name="slug" type="text" placeholder="slug">

             </div>
             <div class="form-group">
               <label for="nickname">昵称</label>
               <input required id="nickname" class="form-control" name="nickname" type="text" placeholder="昵称">
             </div>
             <div class="form-group">
               <label for="password">密码</label>
               <input required id="password" class="form-control" name="password" type="password" >
             </div>
             <div class="form-group">
               <button class="btn btn-primary" type="submit">添加</button>
             </div>
          </form>
          <?php endif ?>
        </div>
        <div class="col-md-8">
          <div class="page-action">
            <!-- show when multiple checked -->
            <a class="btn btn-danger btn-sm" href="./api/deleteUser.php" style="display: none" id="delete_btn">批量删除</a>
          </div>
          <table class="table table-striped table-bordered table-hover">
            <thead>
               <tr>
                <th class="text-center" width="40"><input type="checkbox"></th>
                <th class="text-center" width="80">头像</th>
                <th>邮箱</th>
                <th>别名</th>
                <th>昵称</th>
                <th>状态</th>
                <th class="text-center" width="100">操作</th>
              </tr>
            </thead>
            <tbody>

            <?php foreach($users as $item): ?>
                <tr>
                  <td class="text-center"><input type="checkbox" data-id="<?php echo $item['id'] ?>"></td>
                  <td class="text-center"><img class="avatar" src="<?php echo $item['avatar'] ?>"></td>
                  <td><?php echo $item['email'] ?></td>
                  <td><?php echo $item['slug'] ?></td>
                  <td><?php echo $item['nickname'] ?></td>
                  <td><?php echo convert_status($item['status']) ?></td>
                  <td class="text-center">
                    <a href="users.php?id=<?php echo $item['id'] ?>" class="btn btn-default btn-xs">编辑</a>
                    <a href="./api/deleteUser.php?id=<?php echo $item['id'] ?>" class="btn btn-danger btn-xs">删除</a>
                  </td>
                </tr>
            <?php endforeach ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <?php $current_page = 'users'; ?>
  <?php include 'inc/sidebar.php'; ?>

  <script src="/baixiu/static/assets/vendors/jquery/jquery.js"></script>
  <script src="/baixiu/static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script>
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
  </script>
  <script>NProgress.done()</script>
</body>
</html>
