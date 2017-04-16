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
  $item_id=$_GET['item_id'];
  $user_id=$_SESSION['user_id'];

  #共通関数の読み取り
	require_once('../common/common.php');

  #DBから(1)前画面で選択した情報を取得(2)プルダウンリスト用にimgの一覧を取得
  #DB接続
	$dbh=DBconnect();

  #SQL文定義
  $sql='SELECT item.id AS item_id, item.name AS item_name, item.img_id AS img_id, img.name AS img_name FROM item JOIN img ON item.img_id=img.id WHERE item.id=?';
  $question[]=$item_id;

  #SQL実行
	$stmt=DBexecute($dbh,$sql,$question);

	#dbh破棄（$stmtを使用するので）
	$dbh=null;

  #sql結果取得
  $rec = $stmt->fetch(PDO::FETCH_ASSOC);
  $item_id=$rec['item_id'];
  $item_name=$rec['item_name'];
  $img_id=$rec['img_id'];
  $img_name=$rec['img_name'];

  #ユーザが登録した画像を全量取得
  $image1=getImg($user_id);

  #デフォルトで登録されている画像を全量取得
  $image2=getImg();

}catch (Exception $e){
  print'DB障害';
  exit();

}
 ?>
アイテム修正</br>
<br>
<!--アイテムID：<?php print $item_id; ?><br>-->
<form method="post" action="item_edit_check.php">
  <input type="hidden" name="item_id" value="<?php print $item_id;?>">
  <input type="hidden" name="old_item_name" value="<?php print $item_name;?>">
  <input type="hidden" name="old_img_name" value="<?php print $img_name;?>">

  アイテム名：
  <input type="text" name="new_item_name" style="width:200px" value="<?php print $item_name;?>"><br>
  変更前のイメージ：
  <img class="image img-circle" src="../picture/<?php print $img_name;?>"><br>
  変更後のイメージ：
    <select title="Select your surfboard" class="selectpicker" name="new_img_id">
      <?php
        ##ユーザが登録した画像の表示
        for($i=0;$i<count($image1);$i++){
          print'<option data-thumbnail="../picture/'.$image1[$i]['img_name'].'" value="'.$image1[$i]['img_id'].'">'.$image1[$i]['img_id'].'</option>';
        }

        ##区切り線
        print'<option data-divider="true"></option>';

        ##デフォオルトで登録されている画像の表示
        for($i=0;$i<count($image2);$i++){
          print'<option data-thumbnail="../picture/'.$image2[$i]['img_name'].'" value="'.$image2[$i]['img_id'].'">'.$image2[$i]['img_id'].'</option>';
        }

        ?>
    </select><br><br>
  </br>
  <input type="button" onclick="history.back()" value="戻る">
  <input type="submit" value="OK">
</form>


</body>
</html>
