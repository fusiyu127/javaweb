<?php

//清除登录标识
unset($_SESSION['current_login_user']);
header('location:login.php');