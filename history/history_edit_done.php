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
	$new_item_id=$post['new_item_id'];
	$history_date=$post['history_date'];
	$history_id=$post['history_id'];

  #DB接続
	$dbh=DBconnect();


  #SQL実行準備
	$sql='UPDATE history SET item_id=?, date=? WHERE history.id=?';
	$question[]=$new_item_id;
	$question[]=$history_date;
	$question[]=$history_id;

	#SQL実行
	$stmt=DBexecute($dbh,$sql,$question);

	#dbh破棄（$stmtを使用するので）
	$dbh=null;

  #正常処理後
  print 'ヒストリを修正しました<br />';
}
catch (Exception $e){
  print 'データベース障害';
	 var_dump($e);
  exit();
}
 ?>
 <a href="../login/mypage.php">戻る</a>

</body>
</html>
