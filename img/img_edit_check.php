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

#post_fileを取得
$img_id=$post['img_id'];
$old_img_name=$post['old_img_name']; #old_img
$img=$_FILES['img'];  #new_img
$size=$img['size'];
$tmp_img_name=$img['name'];

#画像有無のチェック
if($img['name']==""){
  print'画像を選択してください';
  exit();
}
# 画像サイズのチェック
if($size>1000000 ){
  print '画像容量が大きすぎます。1MB以下にしてください<br>';
  print('<input type="button" onclick="history.back()" value="戻る">');
  exit();
}

#jpg化した後の情報を定義
$new_img_name=pathinfo($img['name'], PATHINFO_FILENAME).'.jpg';
$new_img_path='../picture/'.$new_img_name;

# 拡張子をjpg化して上書き保存。
toJpg($img);

# 画像をリサイズ・トリミングして上書き保存
resizeImage($new_img_path);

#画像情報
print '変更前画像：<img class="image img-circle" src="../picture/'.$old_img_name.'"><br>';
print '変更後画像：<img class="image img-circle" src="../picture/'.$new_img_name.'"><br>';
print '登録ファイル名：'.$new_img_name.'<br>';
print '<br>';

#form表示
print('<form method="post" action="img_edit_done.php">');
print'登録を行いますか？';
print('<input type="hidden" name="img_id" value="'.$img_id.'">');
print('<input type="hidden" name="old_img_name" value="'.$old_img_name.'">');
print('<input type="hidden" name="new_img_name" value="'.$new_img_name.'">');
print('</br>');
print('<input type="submit" value="登録">');
print('<input type="button" onclick="history.back()" value="戻る">');
print('</form>');

?>




</body>
</html>
