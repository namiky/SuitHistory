<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
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
$item_id=$post['item_id'];

# 表記_確認メッセージ
print('下記の値で登録を行いますか</br>');
print('アイテムID：'.$item_id.'</br>');
print('ターゲット日付：'.$history_date.'</br>');

# 表記_form
print('<form method="post" action="history_add_done.php">');
print('<input type="hidden" name="history_date" value="'.$history_date.'">');
print('<input type="hidden" name="item_id" value="'.$item_id.'">');
print('</br>');
print('<input type="submit" value="登録">');
print('<input type="button" onclick="history.back()" value="戻る">');
print('</form>');


 ?>

</body>
</html>
