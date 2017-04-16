<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="../css/style.css">
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
	$img_id=$post['img_id'];
	$new_img_name=$post['new_img_name'];
	$old_img_name=$post['old_img_name'];

	##DB修正
  #DB接続
	$dbh=DBconnect();

  #SQL実行準備
  $sql='UPDATE img SET name=? WHERE img.id=?';
	$question[]=$new_img_name;
	$question[]=$img_id;

	#SQL実行
	$stmt=DBexecute($dbh,$sql,$question);

	#dbh破棄（$stmtを使用するので）
	$dbh=null;

	##実file削除
	unlink("../picture/".$old_img_name);

  #正常処理後
  print $old_img_name.'を'.$new_img_name.'に修正しました<br />';
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
