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
$name=$post['name'];
$pass=$post['pass'];
$pass2=$post['pass2'];

###########################
## user_add_check
## Validateチェック
###########################
$flg=true;
# ユーザIDのチェック
if($name==''){
  $flg=false;
  print 'ユーザIDが入力されていません<br>';
}else{
  print("ユーザID：");
  print $name.'<br />';
}

# パスワード入力のチェック
if($pass==''){
  $flg=false;
  print("パスワードが入力されていません。</br>");
}

# パスワード同一のチェック
if($pass!=$pass2){
  $flg=false;
  print("パスワードが一致しません。</br>");
}

# validateチェックの結果によって遷移
if($flg==false){
  print('<formt>');
  print('<input type="button" onclick="history.back()" value="戻る"');
  print'<formt>';
}else{
  $pass=md5($pass);
  print('<form method="post" action="user_add_done.php">');
  print('<input type="hidden" name="name" value="'.$name.'">');
  print('<input type="hidden" name="pass" value="'.$pass.'">');
  print('</br>');
  print('<input type="button" onclick="history.back()" value="戻る">');
  print('<input type="submit" value="OK">');
  print('</form>');
}

 ?>

</body>
</html>
