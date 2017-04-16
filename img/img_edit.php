<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="../css/style.css">
<!-- Bootstrap-select利用のためのライブラリ読み込み -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet" href="../css/bootstrap-select.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="../js/bootstrap-select.js"></script>
<!-- Bootstrap-select利用のためのライブラリ読み込み ここまで-->

<title>てすと</title>
</head>
<body>
<?php
try{
  $img_id=$_GET['img_id'];
  $user_id=$_SESSION['user_id'];

  #共通関数の読み取り
	require_once('../common/common.php');

  #DBから(1)前画面で選択した情報を取得(2)プルダウンリスト用にimgの一覧を取得
  #DB接続
	$dbh=DBconnect();

  #SQL文定義
  $sql='SELECT img.name AS img_name FROM img WHERE img.id=?';
  $question[]=$img_id;

  #SQL実行
	$stmt=DBexecute($dbh,$sql,$question);

	#dbh破棄（$stmtを使用するので）
	$dbh=null;

  #sql結果取得
  $rec = $stmt->fetch(PDO::FETCH_ASSOC);
  $img_name=$rec['img_name'];

}catch (Exception $e){
  print'DB障害';
  exit();
}
 ?>
画像修正</br>
<br>
<form method="post" action="img_edit_check.php"  enctype="multipart/form-data">
  <input type="hidden" name="img_id" value="<?php print $img_id;?>">
  <input type="hidden" name="old_img_name" value="<?php print $img_name;?>">

  <table border=1>
    <tr>
      <td>変更前のイメージ：</td>
      <td><img class="image img-circle" src="../picture/<?php print $img_name;?>"></td>
    </tr>
    <tr>
      <td>変更後のイメージ：</td>
      <td><input type="file" name="img" style="width:400px"></br></td>
    </tr>
  </table>
  </br>
  <input type="button" onclick="history.back()" value="戻る">
  <input type="submit" value="OK">
</form>


</body>
</html>
