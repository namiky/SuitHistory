<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>てすと</title>
</head>
<body>
<?php
#DBから削除
try{
  #共通関数の読み取り
	require_once('../common/common.php');

	#XSS対策
	$post=sanitize($_POST);

	#postを取得
	$img_id=$post['img_id'];
	$img_name=$post['img_name'];

	##DB：削除する画像に紐づいているアイテムに対して、違う画像を割り振り
	#DB接続
	$dbh=DBconnect();

  #SQL実行準備
  $sql='UPDATE item SET item.img_id=? WHERE item.img_id=?';
	$question[]=1;
	$question[]=$img_id;

	#SQL実行
	$stmt=DBexecute($dbh,$sql,$question);

	#dbh破棄（$stmtを使用するので）
	$dbh=null;
	$question=array();

	##########
	##DB：削除処理
  #DB接続
	$dbh=DBconnect();

  #SQL実行準備
  $sql='DELETE FROM img WHERE id=?';
	$question[]=$img_id;

	#SQL実行
	$stmt=DBexecute($dbh,$sql,$question);

	#dbh破棄（$stmtを使用するので）
	$dbh=null;



  #正常処理後
  print '削除しました<br />';
}
catch (Exception $e){
  print 'データベース障害';
	var_dump($e);
  exit();
}

###画像ファイルの削除
if(file_exists("../picture/".$img_name)){
  unlink("../picture/".$img_name);
}else{
  print'ERROR:1000_画像fileが見つからない。';
}
 ?>
 <a href="img_list.php">戻る</a>

</body>
</html>
