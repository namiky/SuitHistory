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
$item_name=$post['item_name'];
$img_id=$post['img_id'];

###########################
## user_add_check
## Validateチェック
###########################
$flg=true;
# アイテム名のチェック
if($item_name==''){
  $flg=false;
  print 'アイテム名が入力されていません<br>';
}else{
  print("アイテム名：");
  print $item_name.'<br />';
}

# validateチェックの結果によって遷移
if($flg==false){
  print('<formt>');
  print('<input type="button" onclick="history.back()" value="戻る"');
  print'<formt>';
}else{
  print('<form method="post" action="item_add_done.php">');
  print('<input type="hidden" name="item_name" value="'.$item_name.'">');
  print('<input type="hidden" name="img_id" value="'.$img_id.'">');
  print('</br>');
  print('<input type="button" onclick="history.back()" value="戻る">');
  print('<input type="submit" value="登録">');
  print('</form>');
}

 ?>

</body>
</html>
