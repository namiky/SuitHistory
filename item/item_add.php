<?php session_start();?>
<!DOCTYPE html>
  <html lang="ja">
    <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Bootstrap Sample</title>
      <!-- BootstrapのCSS読み込み -->
      <link href="../css/bootstrap.min.css" rel="stylesheet">
      <!-- jQuery読み込み -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
      <!-- BootstrapのJS読み込み -->
      <script src="../js/bootstrap.min.js"></script>


  <body>
    <?php
    $user_id=$_SESSION['user_id'];

    #共通関数の読み取り
    require_once('../common/common.php');

    #DB接続
  	$dbh=DBconnect();

    #SQL実行準備
    #こちらが正しい    $sql='SELECT * FROM img WHERE user_id='.$user_id;
        $sql='SELECT * FROM img';

  	#SQL実行
  	$stmt=DBexecute2($dbh,$sql);

  	#dbh破棄（$stmtを使用するので）
  	$dbh=null;

    while(true){
      $rec=$stmt->fetch(PDO::FETCH_ASSOC);
      if($rec==false){
        break;
      }
      $list_img_id[]=$rec['id'];
      $list_img_name[]=$rec['name'];
    }
?>

    アイテム追加</br></br>
    <form method="post" action="item_add_check.php">

      名前を入力してください。</br>
      <input type="text" name="item_name" style="width:100px"></br>

      img_idを選択してください</br>

<!--      <input type="text" name="img_id" style="width:100px"></br>-->
      <!-- ここにimg_idを取得して、プルダウンで選択して、合わせて、画像が変わる仕組みを作る-->

      <select title="Select your surfboard" class="selectpicker">
        <option>Select...</option>
        <?php
              for($i=0;$i<count($list_img_id);$i++){
                print'<option data-thumbnail="../img/'.$list_img_name[$i].'">'.$list_img_id[$i].'</option>';
              }
              ?>
      </select>



      </br>
      <input type="button" onclick="history.back()" value="戻る">
      <input type="submit" value="OK">

    </form>
  </body>
</html>
