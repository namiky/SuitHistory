<?php session_start();?>
<!DOCTYPE html>
  <html lang="ja">
    <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Bootstrap Sample</title>
      <link rel="stylesheet" href="../css/style.css">
      <!-- Bootstrap-select利用のためのライブラリ読み込み -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
      <link rel="stylesheet" href="../css/bootstrap-select.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
      <script src="../js/bootstrap-select.js"></script>
      <!-- Bootstrap-select利用のためのライブラリ読み込み ここまで-->

  <body>
    <?php
    $user_id=$_SESSION['user_id'];

    #共通関数の読み取り
    require_once('../common/common.php');

    #ユーザが登録した画像を全量取得
    $image1=getImg($user_id);

    #デフォルトで登録されている画像を全量取得
    $image2=getImg();

?>

    アイテム追加</br></br>
    <form method="post" action="item_add_check.php">

      名前を入力してください。</br>
      <input type="text" name="item_name" style="width:100px"></br>

      画像を選択してください</br>
      <!--画像プルダウン-->
      <select title="Select your surfboard" class="selectpicker" name="img_id">
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
      画像の追加を行いたい場合は先に<a href="../img/img_add.php">コチラ</a>からどうぞ</br>

      </br>
      <input type="button" onclick="history.back()" value="戻る">
      <input type="submit" value="OK">



  </body>
</html>
