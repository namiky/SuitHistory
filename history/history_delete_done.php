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
	$history_id=$post['history_id'];

  #DB接続
	$dbh=DBconnect();

  #SQL実行準備
	$sql='DELETE FROM history WHERE history.id=?';
	$question[]=$history_id;

	#SQL実行
	$stmt=DBexecute($dbh,$sql,$question);

	#dbh破棄（$stmtを使用するので）
	$dbh=null;

  #正常処理後
  print 'ヒストリを削除しました<br />';
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
