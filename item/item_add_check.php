<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>てすと</title>
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
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

#DB接続
$dbh=DBconnect();

#SQL実行準備
$sql='SELECT name AS img_name FROM img WHERE img.id='.$img_id;

#SQL実行
$stmt=DBexecute2($dbh,$sql);

#dbh破棄（$stmtを使用するので）
$dbh=null;

#SQL結果を変数に格納
$rec=$stmt->fetch(PDO::FETCH_ASSOC);
$img_name=$rec['img_name'];

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
if($img_name!='' && $img_id!=''){
  print 'アイテム画像：<img class="image img-circle" src="../picture/'.$img_name.'"><br>';
}
print '上記データを登録しますか？<br>';
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
