<?php
require_once "../functions.php";
get_cur_user();
$current_slide = fetch_one("SELECT VALUE FROM `options` WHERE `key`='home_slides'")['VALUE'];
$current_slide = json_decode($current_slide);

?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Slides &laquo; Admin</title>
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
        <h1>图片轮播</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="row">
        <div class="col-md-4">
          <form action='./api/updateSlide.php' method="post" enctype="multipart/form-data">
            <h2>添加新轮播内容</h2>
            <div class="form-group">
              <label for="image">图片</label>
              <!-- show when image chose -->
              <img class="help-block thumbnail" style="display: none">
              <input id="image" class="form-control" name="image" type="file" required>
            </div>
            <div class="form-group">
              <label for="text">文本</label>
              <input id="text" class="form-control" name="text" type="text" placeholder="文本" required>
            </div>
            <div class="form-group">
              <label for="link">链接</label>
              <input id="link" class="form-control" name="link" type="text" placeholder="链接" required>
            </div>
            <div class="form-group">
              <button class="btn btn-primary" type="submit">添加</button>
            </div>
          </form>
        </div>
        <div class="col-md-8">
          <div class="page-action">
            <!-- show when multiple checked -->
            <a class="btn btn-danger btn-sm" href="javascript:;" style="display: none">批量删除</a>
          </div>
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th class="text-center" width="40"><input type="checkbox"></th>
                <th class="text-center">图片</th>
                <th>文本</th>
                <th>链接</th>
                <th class="text-center" width="100">操作</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($current_slide as $key=>$item): ?>
                <tr>
                  <td class="text-center"><input type="checkbox" data-id="<?php echo $key;?>"></td>
                  <td class="text-center"><img class="slide" src="<?php echo $item->image; ?>"></td>
                  <td><?php echo $item->text ?></td>
                  <td><?php echo $item->link ?></td>
                  <td class="text-center">
                    <a href="./api/updateSlide.php?id=<?php echo $key;?>" class="btn btn-danger btn-xs">删除</a>
                  </td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <?php $current_page = 'slides'; ?>
  <?php include 'inc/sidebar.php'; ?>

  <script src="/baixiu/static/assets/vendors/jquery/jquery.js"></script>
  <script src="/baixiu/static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script>NProgress.done()</script>
</body>
</html>
