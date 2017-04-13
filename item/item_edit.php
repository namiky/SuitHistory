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
  $item_id=$_GET['item_id'];

  #共通関数の読み取り
	require_once('../common/common.php');

  #DB接続
	$dbh=DBconnect();

  #SQL文定義
  $sql='SELECT item.id AS item_id, item.name AS item_name, img_id, img.name AS img_name FROM item JOIN img ON item.img_id=img.id WHERE item.id=?';
  $question[]=$item_id;

  #SQL実行
	$stmt=DBexecute($dbh,$sql,$question);

	#dbh破棄（$stmtを使用するので）
	$dbh=null;

  #sql結果取得
  $rec = $stmt->fetch(PDO::FETCH_ASSOC);
  $item_id=$rec['item_id'];
  $item_name=$rec['item_name'];
  $img_id=$rec['img_id'];
  $img_name=$rec['img_name'];

}catch (Exception $e){
  print'DB障害';
  exit();

}
 ?>
アイテム修正</br>
<br>
アイテムID：<?php print $item_id; ?><br>
<form method="post" action="item_edit_check.php">
  <input type="hidden" name="item_id" value="<?php print $item_id;?>">
  <input type="hidden" name="img_name" value="<?php print $img_name;?>">


  アイテム名：
  <input type="text" name="item_name" style="width:200px" value="<?php print $item_name;?>"><br>
  イメージID：
  <input type="text" name="img_id" style="width:200px" value="<?php print $img_id;?>"><br>
  イメージ：
  <style type="text/css">img.pic {width: 100px;}</style>
  <img class=pic src="../img/<?php print $img_name;?>"><br>
  </br>
  <input type="button" onclick="history.back()" value="戻る">
  <input type="submit" value="OK">
</form>


</body>
</html>
