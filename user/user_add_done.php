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
	$name=$post['name'];
	$pass=$post['pass'];

  #DB接続
	$dbh=DBconnect();

  #SQL実行準備
  $sql='INSERT INTO user(name,password) VALUES(?,?)';
	$question[]=$name;
	$question[]=$pass;

	#SQL実行
	$stmt=DBexecute($dbh,$sql,$question);

	#dbh破棄（$stmtを使用するので）
	$dbh=null;

  #正常処理後
  print $name.'を追加しました<br />';
}
catch (Exception $e){
  print 'データベース障害';
	# var_dump($e);
  exit();
}
 ?>
 <a href="../login/login.html">戻る</a>

</body>
</html>
