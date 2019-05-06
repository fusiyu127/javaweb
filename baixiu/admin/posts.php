<?php
    require_once '../functions.php';
    get_cur_user();

    //记录筛选条件
    $where = '1 = 1';
    //记录传递参数
    $search = '';

    //判断筛选条件是否有分类
    if(!empty($_GET['category'])){
        if($_GET['category'] !== '-1'){
            $where .= ' and posts.category_id = ' . $_GET['category'];
            $search .= '&category='.$_GET['category'];
        }
    }

    //判断筛选条件是否有状态
    if(!empty($_GET['status'])){
        if($_GET['status'] !== 'all_status'){
            $where .= " and posts.status = '{$_GET['status']}'";
            $search .= '&status='.$_GET['status'];
        }
    }

    //处理分页参数
    $size = 20;//每页显示数据的条数
    //计算总条数和最大页数
    $total_count = (int)fetch_one("select count(1) as num from posts where {$where}")['num'];
    $total_pages = (int)ceil($total_count / $size);
    $page = empty($_GET['page']) ? 1: (int)$_GET['page'];

    if($page < 1){
        header('location:posts.php?page=1');
    }
    if($page > $total_pages){
        header('location:posts.php?page='.$total_pages);
    }

    $offset = ($page - 1) * $size;

    //绘制分页组件
    $visiables = 5;
    $region = ($visiables - 1) / 2;
    $begin = $page - $region;
    $end = $begin + $visiables;
    //确保begin最小为1
    if($begin < 1){
        $begin = 1;
        $end = $begin + $visiables;
    }
    //确保end小于等于最大页数
    if($end > $total_pages + 1){
        $end = $total_pages + 1;
        $begin = $end - $visiables;
        if($begin < 1){
            $begin = 1;
        }
    }

    //获取全部数据
    $posts = fetch_all("select
                        posts.id,
                        posts.title,
                        users.nickname as user_name,
                        categories.`name` as category_name,
                        posts.created,
                        posts.`status`
                        from posts
                        INNER JOIN categories on posts.category_id = categories.id
                        INNER JOIN users on posts.user_id = users.id
                        where {$where}
                        ORDER BY posts.created DESC
                        LIMIT {$offset},{$size};");

    //处理数据转换,将状态转换为中文
    function convert_status($status){
        $dict = array(
        'published' => '已发布',
        'drafted' => '草稿',
        'trashed' => '回收站'
        );
        return isset($dict[$status]) ? $dict[$status] : '未知状态';
    }

    //转换时间格式
    function convert_time($created){
        $timestamp = strtotime($created);
        return date('Y年m月d日<b\r>H:i:s', $timestamp);
    }

    //获取所有分类
    $categories = fetch_all('select * from categories');

 ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Posts &laquo; Admin</title>
  <link rel="stylesheet" href="/baixiu/static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="/baixiu/static/assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="/baixiu/static/assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="/baixiu/static/assets/css/admin.css">
  <script src="/baixiu/static/assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <?php
        //不知道为什么这里加上导航条部分会出问题
        include 'inc/navbar.php';
     ?>

    <div class="container-fluid">
      <div class="page-title">
        <h1>所有文章</h1>
        <a href="/baixiu/admin/post-add.php" class="btn btn-primary btn-xs">写文章</a>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <a class="btn btn-danger btn-sm" href="javascript:;" style="display: none">批量删除</a>
        <form class="form-inline" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get">
          <select name="category" class="form-control input-sm">
            <option value="-1">所有分类</option>
            <?php foreach($categories as $item): ?>
                <option value="<?php echo $item['id']; ?>" <?php echo isset($_GET['category'])&&$_GET['category']==$item['id']?'selected':''; ?> ><?php echo $item['name'] ?></option>
            <?php endforeach ?>
          </select>
          <select name="status" class="form-control input-sm">
            <option value="all_status">所有状态</option>
            <option value="drafted"  <?php echo isset($_GET['status'])&& $_GET['status']=="drafted"?'selected':'' ?> >草稿</option>
            <option value="published" <?php echo isset($_GET['status'])&& $_GET['status']=="published"?'selected':'' ?>>已发布</option>
            <option value="trashed" <?php echo isset($_GET['status'])&& $_GET['status']=="trashed"?'selected':'' ?>>回收站</option>
          </select>
          <button class="btn btn-default btn-sm" >筛选</button>
        </form>
        <ul class="pagination pagination-sm pull-right">
          <li><a href="?page=<?php echo (($page-1)>0 ?($page-1):1).$search ; ?>">上一页</a></li>

          <?php for($i = $begin; $i < $end; $i++): ?>
             <li <?php echo $i===$page ? 'class="active"':''; ?>><a href="?page=<?php echo $i.$search; ?>"><?php echo $i; ?></a></li>
          <?php endfor ?>

          <li><a href="?page=<?php echo (($page+1) > $total_pages ? $total_pages:($page+1)).$search; ?>">下一页</a></li>
        </ul>
      </div>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th class="text-center" width="40"><input type="checkbox"></th>
            <th>标题</th>
            <th>作者</th>
            <th>分类</th>
            <th class="text-center">发表时间</th>
            <th class="text-center">状态</th>
            <th class="text-center" width="100">操作</th>
          </tr>
        </thead>
        <tbody>
            <?php foreach($posts as $item): ?>
                <tr>
                    <td class="text-center"><input type="checkbox" data-id="<?php echo $item['id'] ?>"></td>
                    <td><?php echo $item['title']; ?></td>
                    <td><?php echo $item['user_name']; ?></td>
                    <td><?php echo $item['category_name']; ?></td>
                    <td class="text-center"><?php echo convert_time($item['created']); ?></td>
                    <td class="text-center"><?php echo convert_status($item['status']); ?></td>
                    <td class="text-center">
                      <!--<a href="#" class="btn btn-default btn-xs">编辑</a>-->
                      <a href="post-delete.php?id=<?php echo $item['id'] ?>" class="btn btn-danger btn-xs">删除</a>
                    </td>
                  </tr>
            <?php endforeach ?>

        </tbody>
      </table>
    </div>
  </div>

  <?php $current_page = 'posts'; ?>
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
