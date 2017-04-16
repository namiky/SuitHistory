<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

    <title>てすと</title>
  </head>

  <body>
    画像追加</br></br>
    <form method="post" action="img_add_check.php" enctype="multipart/form-data">

      画像を選択してください</br>
      <input type="file" name="img" style="width:400px"></br>

      </br>
      <input type="button" onclick="history.back()" value="戻る">
      <input type="submit" value="OK">

    </form>
  </body>
</html>
