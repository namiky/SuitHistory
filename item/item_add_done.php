<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
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
	$item_name=$post['item_name'];
	$img_id=$post['img_id'];

  #DB接続
	$dbh=DBconnect();

  #SQL実行準備
  $sql='INSERT INTO item(name,user_id,img_id) VALUES(?,?,?)';
	$question[]=$item_name;
	$question[]=$_SESSION['user_id'];
	$question[]=$img_id;

	#SQL実行
	$stmt=DBexecute($dbh,$sql,$question);

	#dbh破棄（$stmtを使用するので）
	$dbh=null;

  #正常処理後
  print $item_name.'を追加しました<br />';
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
