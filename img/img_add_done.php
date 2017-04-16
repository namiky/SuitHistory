<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>てすと</title>
</head>
<body>
<?php
try{
  #共通関数の読み取り
	require_once('../common/common.php');

	#XSS対策
	$post=sanitize($_POST);

	#postを取得
	$img_name=$post['img_name'];

  #DB接続
	$dbh=DBconnect();

  #SQL実行準備
  $sql='INSERT INTO img(name,user_id) VALUES(?,?)';
	$question[]=$img_name;
	$question[]=$_SESSION['user_id'];

	#SQL実行
	$stmt=DBexecute($dbh,$sql,$question);

	#dbh破棄（$stmtを使用するので）
	$dbh=null;

  #正常処理後
  print $img_name.'を追加しました<br />';
}
catch (Exception $e){
  print 'データベース障害';
	# var_dump($e);
  exit();
}
 ?>
 <a href="../login/mypage.php">戻る</a>

</body>
</html>
