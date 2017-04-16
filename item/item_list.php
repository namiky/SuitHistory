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
try{
  #共通関数の読み取り
	require_once('../common/common.php');

  #DB接続
	$dbh=DBconnect();
  $sql='SELECT item.id AS item_id, item.name AS item_name, img_id, img.name AS img_name FROM item JOIN img ON item.img_id=img.id ORDER BY item.id';
	##これだとimg_idとitem.img_idがイコールでないものが表示されない

  #SQL実行
	$stmt=DBexecute2($dbh,$sql);

	#dbh破棄（$stmtを使用するので）
	$dbh=null;

  # 表記
  print 'アイテム一覧<br><br>';
  print '<form method="post" action="item_branch.php">';
  print '<table border="1"><tr><th>Radio</th>';
	#print '<th>ItemID</th>';
	print '<th>ItemName</th>';
	#print '<th>imgID</th>';
	print '<th>IMG</th>';# table のborder=1はいずれ削除!!!!!!!!!!!!

  # テーブル内部をwhileとSQL結果にて取得
  while(true){
    $rec=$stmt->fetch(PDO::FETCH_ASSOC);
    if($rec==false){
      break;
    }
    print'<tr>';
    print '<td><input type="radio" name="item_id" value="'.$rec['item_id'].'"></td>';
    #print '<td>'.$rec['item_id'].'</td>';
    print '<td>'.$rec['item_name'].'</td>';
    #print '<td>'.$rec['img_id'].'</td>';
    print '<td><img class="image img-circle" src="../picture/'.$rec['img_name'].'"></td>';
    print'</tr>';
  }

  print '</table>';
#  print '<input type="submit" name="disp" value="参照">';
  print '<input type="submit" name="add" value="追加">';
  print '<input type="submit" name="edit" value="修正">';
  print '<input type="submit" name="delete" value="削除">';
  print '<br>';
  print '<br>';
  print '</form>';
  print '<br><a href="../login/mypage.php">戻る</a>';
}

catch(Exception $e){
  print'DB障害';
  var_dump($e);
  exit();
}

 ?>
</body>
</html>
