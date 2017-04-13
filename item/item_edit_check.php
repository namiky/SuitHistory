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
$item_id=$post['item_id'];
$item_name=$post['item_name'];
$img_id=$post['img_id'];
$img_name=$post['img_name'];

#form
print('<form method="post" action="item_edit_done.php">');
print('<input type="hidden" name="item_id" value="'.$item_id.'">');
print('<input type="hidden" name="item_name" value="'.$item_name.'">');
print('<input type="hidden" name="img_id" value="'.$img_id.'">');
print('<input type="hidden" name="img_name" value="'.$img_name.'">');
print('</br>');
print('<input type="button" onclick="history.back()" value="戻る">');
print('<input type="submit" value="OK">');
print('</form>');

 ?>

</body>
</html>
