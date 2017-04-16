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
$item_id=$post['item_id'];
$old_item_name=$post['old_item_name'];
$old_img_name=$post['old_img_name'];
$old_img_id=$post['old_img_name'];
$new_item_name=$post['new_item_name'];
$new_img_id=$post['new_img_id'];

#DB接続
$dbh=DBconnect();

#SQL文定義
$sql='SELECT img.name AS new_img_name FROM img WHERE img.id=?';
$question[]=$new_img_id;

#SQL実行
$stmt=DBexecute($dbh,$sql,$question);

#dbh破棄（$stmtを使用するので）
$dbh=null;

#sql結果取得
$rec = $stmt->fetch(PDO::FETCH_ASSOC);
$new_img_name=$rec['new_img_name'];

}catch (Exception $e){
  print'DB障害';
  exit();

}
?>

<table border=1>
  <tr>
    <th></th>
    <th>修正前</th>
    <th>修正後</th>
  </tr>
  <tr>
    <td>アイテム名</td>
    <td><?=$old_item_name?></td>
    <td><?=$new_item_name?></td>
  </tr>
  <tr>
    <td>画像</td>
    <td><img class="image img-circle" src="../picture/<?=$old_img_name?>"></td>
    <td><img class="image img-circle" src="../picture/<?=$new_img_name?>"></td>
  </tr>

</table>

上記の通り修正を行いますか？<br>

<form method="post" action="item_edit_done.php">
  <input type="hidden" name="item_id" value="<?=$item_id?>">
  <input type="hidden" name="item_name" value="<?=$new_item_name?>">
  <input type="hidden" name="img_id" value="<?=$new_img_id?>">
  <input type="hidden" name="img_name" value="<?=$new_img_name?>">
  </br>
  <input type="button" onclick="history.back()" value="戻る">
  <input type="submit" value="OK">
</form>


</body>
</html>
