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

  #DB接続
	$dbh=DBconnect();

  #SQL実行準備
  $sql='DELETE FROM item WHERE id=?';
	$question[]=$item_id;

	#SQL実行
	$stmt=DBexecute($dbh,$sql,$question);

	#dbh破棄（$stmtを使用するので）
	$dbh=null;

  #正常処理後
  print '削除しました<br />';
}
catch (Exception $e){
  print 'データベース障害';
  exit();
}

 ?>
 <a href="item_list.php">戻る</a>

</body>
</html>
