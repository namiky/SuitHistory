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
  $item_id=$post['item_id'];
  $item_name=$post['item_name'];
	$img_id=$post['img_id'];

  #DB接続
	$dbh=DBconnect();

  #SQL実行準備
  $sql='UPDATE item SET name=?, img_id=? WHERE id=?';
	$question[]=$item_name;
	$question[]=$img_id;
	$question[]=$item_id;

	#SQL実行
	$stmt=DBexecute($dbh,$sql,$question);

	#dbh破棄（$stmtを使用するので）
	$dbh=null;

  #正常処理後
  print '修正しました<br />';
}
catch (Exception $e){
  print 'データベース障害';
  var_dump($e);
  exit();
}

 ?>
 <a href="item_list.php">戻る</a>

</body>
</html>
