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
  $img_id=$_GET['img_id'];
  #共通関数の読み取り
	require_once('../common/common.php');

  #DB接続
	$dbh=DBconnect();

  #SQL文定義
  $sql='SELECT img.id AS img_id, img.name AS img_name FROM img WHERE img.id=?';
  $question[]=$img_id;

  #SQL実行
	$stmt=DBexecute($dbh,$sql,$question);

	#dbh破棄（$stmtを使用するので）
	$dbh=null;

  #sql結果取得
  $rec = $stmt->fetch(PDO::FETCH_ASSOC);
  $img_id=$rec['img_id'];
  $img_name=$rec['img_name'];

}catch (Exception $e){
  print'DB障害';
  var_dump($e);
  exit();
}


 ?>
アイテム削除</br>
</br>
イメージ名：<?php print $img_name;?><br>
イメージ：
<img class="image img-circle" src="../picture/<?php print $img_name;?>"><br>

このアイテムを削除してよいですか？<br>
<form method="post" action="img_delete_done.php">
  <input type="hidden" name="img_name" value="<?php print $img_name?>"></br>
  <input type="hidden" name="img_id" value="<?php print $img_id?>"></br>
  <input type="button" onclick="history.back()" value="戻る">
  <input type="submit" value="OK">
</form>


</body>
</html>
