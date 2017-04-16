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

#####DBよりアイテムの全データを取得
#DB接続
$dbh2=DBconnect();
$sql2='SELECT item.id AS item_id, item.name AS item_name, item.img_id AS img_id, img.name AS img_name
      FROM item INNER JOIN img
      ON item.img_id=img.id';


#SQL実行
$stmt2=DBexecute2($dbh2,$sql2);

#dbh破棄（$stmtを使用するので）
$dbh2=null;


 ?>

  <body>
    ヒストリー修正</br></br>
    <form method="post" action="history_edit_check.php">

      <input type="hidden" name="history_id" value="<?=$history_id?>">
      <input type="hidden" name="old_img_name" value="<?=$rec['img_name'];?>">
      <input type="hidden" name="old_item_name" value="<?=$rec['item_name'];?>">
        修正前アイテム名：<?=$rec['item_name']?><br><br>
        修正前画像：<img class="image img-circle" src="../picture/<?=$rec['img_name'];?>"><br>

        該当日付：<input type="date" name="history_date" value="<?php print $rec['history_date'];?>"><br>
        修正後アイテム名を選択してください</br>
        <select title="Select your surfboard" class="selectpicker" name="new_item_id">
          <?php
          while(true){
            $rec2=$stmt2->fetch(PDO::FETCH_ASSOC);
            if($rec2==false){
              break;
            }
          print '<option data-thumbnail="../picture/'.$rec2['img_name'].'" value="'.$rec2['item_id'].'">'.$rec2['item_name'].'</option>';

          }

          }
          catch(Exception $e){
            print'DB障害';
            var_dump($e);
            exit();
          }
  ?>

      </select>

      </br>
      <input type="button" onclick="history.back()" value="戻る">
      <input type="submit" value="OK">

    </form>
  </body>
</html>
