<?php
## ログイン状態確認
require_once('../common/common.php');
sessionStart();
/*session_start();
session_regenerate_id(true);
if(isset($_SESSION['login'])==false){
  print 'ログインされていません<br>';
  print '<a href=../login/login.html>ログインページ</a>';
  exit();
}*/

 ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title> ろくまる農園</title>
</head>
<body>

ショップ管理トップメニュー<br />
<br />
<a href="../staff/staff_list.php">スタッフ管理</a><br />
<br />
<a href="../product/pro_list.php">商品管理</a><br />
<br />
<a href="../login/logout.php">ログアウト</a><br />

</body>
</html>
