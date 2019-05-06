<?php
require_once "../functions.php";
get_cur_user();
function add_category(){
    $name = $_POST['name'];
    $slug = $_POST['slug'];
    $result = execute("INSERT INTO categories VALUES(NULL,'{$slug}','{$name}');");
    if($result <= 0){
        $GLOBALS['success'] = false;
        $GLOBALS['message'] = "添加失败！";
     }
    else{
        $GLOBALS['success'] = true;
        $GLOBALS['message'] = "添加成功！";
    }
}

function edit_category(){
    $name = $_POST['name'];
    $slug = $_POST['slug'];
    $result = execute("update categories set slug='{$slug}',name='{$name}' where id = {$_GET['id']};");
    if($result <= 0){
        $GLOBALS['success'] = false;
        $GLOBALS['message'] = "修改失败！";
     }
    else{
        $GLOBALS['success'] = true;
        $GLOBALS['message'] = "修改成功！";
    }
}

//添加分类
//表单提交请求
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(empty($_GET['id'])){
        add_category();
    }else{
        edit_category();
    }

}

//编辑分类
if(!empty($_GET['id'])){
    $edit_category = fetch_one('select * from categories where id = '.$_GET['id']);

}

//获取分类
$categories = fetch_all('select * from categories');
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Categories &laquo; Admin</title>
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
        <h1>分类目录</h1>
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

          <?php if(isset($edit_category)): ?>
          <form action = "<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $edit_category['id']; ?>" method="post">
             <h2>编辑目录分类</h2>
             <div class="form-group">
               <label for="name">名称</label>
               <input id="name" value="<?php echo $edit_category['name'] ?>" class="form-control" name="name" type="text" placeholder="分类名称" required>
             </div>
             <div class="form-group">
               <label for="slug">别名</label>
               <input id="slug" value="<?php echo $edit_category['slug'] ?>" class="form-control" name="slug" type="text" placeholder="slug" required>
             </div>
             <div class="form-group">
               <button class="btn btn-primary" type="submit">保存</button>
             </div>
           </form>

          <?php else: ?>
          <form action = "<?php echo $_SERVER['PHP_SELF']  ?>" method="post">
             <h2>添加新分类目录</h2>
             <div class="form-group">
               <label for="name">名称</label>
               <input id="name" class="form-control" name="name" type="text" placeholder="分类名称" required>
             </div>
             <div class="form-group">
               <label for="slug">别名</label>
               <input id="slug" class="form-control" name="slug" type="text" placeholder="slug" required>
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
            <a class="btn btn-danger btn-sm" href="category-delete.php" style="display: none" id="delete_btn">批量删除</a>
          </div>

          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th class="text-center" width="40"><input type="checkbox"></th>
                <th>名称</th>
                <th>Slug</th>
                <th class="text-center" width="100">操作</th>
              </tr>
            </thead>
            <tbody>

              <?php foreach($categories as $item): ?>
                <tr>
                   <td class="text-center"><input type="checkbox" data-id="<?php echo $item['id'] ?>"></td>
                    <td><?php echo $item['name'] ?></td>
                    <td><?php  echo $item['slug'] ?></td>
                    <td class="text-center">
                      <a href="categories.php?id=<?php echo $item['id'] ?>" class="btn btn-info btn-xs">编辑</a>
                      <a href="category-delete.php?id=<?php echo $item['id'] ?>" class="btn btn-danger btn-xs">删除</a>
                    </td>
                 </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <?php $current_page = 'categories'; ?>
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
            console.log('allChecks')
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
