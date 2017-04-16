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
#共通関数の読み取り
require_once('../common/common.php');

#XSS対策
$post=sanitize($_POST);

#postを取得
$history_date=$post['history_date'];
$history_id=$post['history_id'];
$new_item_id=$post['new_item_id'];
$old_item_name=$post['old_item_name'];
$old_img_name=$post['old_img_name'];


#DB接続
$dbh=DBconnect();

#SQL実行準備
$sql='SELECT item.id AS item_id, item.name AS item_name, item.img_id AS img_id, img.name AS img_name
      FROM item JOIN img ON item.img_id=img.id
      WHERE item.id=?
      ORDER BY item.id';
$question[]=$new_item_id;

#SQL実行
$stmt=DBexecute($dbh,$sql,$question);

#dbh破棄（$stmtを使用するので）
$dbh=null;

##
$rec=$stmt->fetch(PDO::FETCH_ASSOC);

# 表記_確認メッセージ
#print('アイテムID：'.$item_id.'</br>');
print('＜修正前＞<br>');
print('アイテム名：'.$post['old_item_name'].'</br>');
print('修正前画像：<img class="image img-circle" src="../picture/'.$post['old_img_name'].'">.</br>');
print'<br>';

print'＜修正後＞<br>';
print('アイテム名：'.$rec['item_name'].'</br>');
print('画像：<img class="image img-circle" src="../picture/'.$rec['img_name'].'">.</br>');
print('日付：'.$history_date.'</br>');

print('上記の値で登録を行いますか</br>');
# 表記_form
print('<form method="post" action="history_edit_done.php">');
print('<input type="hidden" name="history_id" value="'.$history_id.'">');
print('<input type="hidden" name="history_date" value="'.$history_date.'">');
print('<input type="hidden" name="new_item_id" value="'.$new_item_id.'">');
print('</br>');
print('<input type="submit" value="登録">');
print('<input type="button" onclick="history.back()" value="戻る">');
print('</form>');


 ?>

</body>
</html>
