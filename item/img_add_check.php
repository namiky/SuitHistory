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

#post_fileを取得
$img=$_FILES['img'];
$size=$img['size'];

# 画像サイズのチェック
if($size>1000000 ){
  print '画像容量が大きすぎます。1MB以下にしてください<br>';
  print('<input type="button" onclick="history.back()" value="戻る">');
  exit();
}else{
  #画像fileの取得と格納
  move_uploaded_file($img['tmp_name'],'../img/'.$img['name']);

  #画像情報
  print '画像：<img src="../img/'.$img['name'].'"><br>';
  print 'ファイル名：'.$img['name'].'<br>';
  print '<br>';

  #form表示
  print('<form method="post" action="img_add_done.php">');
  print'登録を行いますか？';
  print('<input type="hidden" name="img_name" value="'.$img['name'].'">');
  print('</br>');
  print('<input type="submit" value="登録">');
  print('<input type="button" onclick="history.back()" value="戻る">');
  print('</form>');
}


 ?>

</body>
</html>
