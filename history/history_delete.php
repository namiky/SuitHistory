<?php session_start();?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>てすと</title>
    <link rel="stylesheet" href="../css/style.css">
    <!-- Bootstrap-select利用のためのライブラリ読み込み -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/bootstrap-select.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <script src="../js/bootstrap-select.js"></script>
    <!-- Bootstrap-select利用のためのライブラリ読み込み ここまで-->
  </head>

<?php
try{

#共通関数の読み取り
require_once('../common/common.php');

$user_id=$_SESSION['user_id'];
$history_id=$_GET['history_id'];


#####DBよりhistryoを取得
#DB接続
$dbh=DBconnect();
$sql='SELECT history.date AS history_date, history.item_id AS item_id, img.id AS img_id, img.name AS img_name, item.name AS item_name
      FROM history
      INNER JOIN (item INNER JOIN img ON item.img_id=img.id)
      ON history.item_id=item.id
      WHERE history.id=?';

#
$question[]=$history_id;

#SQL実行
$stmt=DBexecute($dbh,$sql,$question);

#dbh破棄（$stmtを使用するので）
$dbh=null;

$rec=$stmt->fetch(PDO::FETCH_ASSOC);

}
catch(Exception $e){
  print'DB障害';
  var_dump($e);
  exit();
}
 ?>

  <body>
    ヒストリー削除</br></br>
    <form method="post" action="history_delete_done.php">

      <input type="hidden" name="history_id" value="<?=$history_id?>">
        該当日付：<?php print $rec['history_date'];?><br>
        画像：<img class="image img-circle" src="../picture/<?=$rec['img_name'];?>"><br>
        アイテム名：<?=$rec['item_name']?><br><br>

      </br>
      上記を削除してもよろしいですか？</br>
      <input type="button" onclick="history.back()" value="戻る">
      <input type="submit" value="OK">

    </form>
  </body>
</html>
