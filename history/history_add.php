<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>てすと</title>
  </head>

  <body>
    ヒストリー追加</br></br>
    <form method="post" action="history_add_check.php">

      該当日付</br>
      <input type="date" name="history_date" value="<?php print(date("Y-m-d"));?>"><br>
      item_idを選択してください</br>
      <input type="text" name="item_id" style="width:100px"></br>
      <!-- ここにitem_idを取得して、プルダウンで選択して、合わせて、画像が変わる仕組みを作る-->

      </br>
      <input type="button" onclick="history.back()" value="戻る">
      <input type="submit" value="OK">

    </form>
  </body>
</html>
