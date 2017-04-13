<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>てすと</title>
</head>
<body>

<?php
try{
  #共通関数の読み取り
	require_once('../common/common.php');

  #DB接続
	$dbh=DBconnect();

	#SQL文定義
	$sql='SELECT history.id AS history_id, history.date AS history_date, item.id AS item_id, item.img_id AS img_id, img.name AS img_name
				FROM history
				INNER JOIN (item INNER JOIN img ON item.img_id=img.id)
				ON history.item_id=item.id
				WHERE history.user_id='.$_SESSION['user_id'];


  #SQL実行
	$stmt=DBexecute2($dbh,$sql);

	#dbh破棄（$stmtを使用するので）
	$dbh=null;

  # 表記
  print 'ヒストリ一覧<br><br>';
  print '<form method="post" action="history_branch.php">';
  print '<table><tr><th>Radio</th><th>HistoryID</th><th>HistoryDate</th><th>imgID</th><th>IMG</th>';

  # テーブル内部をwhileとSQL結果にて取得
  while(true){
    $rec=$stmt->fetch(PDO::FETCH_ASSOC);
    if($rec==false){
      break;
    }
    print'<tr>';
    print '<td><input type="radio" name="history_id" value="'.$rec['history_id'].'"></td>';
    print '<td>'.$rec['history_id'].'</td>';
    print '<td>'.$rec['history_date'].'</td>';
    print '<td>'.$rec['img_id'].'</td>';
		print'<style type="text/css">img.pic {width: 100px;}</style>'; # 正式な表示方法を決めたら削除tmp!!!!!!!!
    print '<td><img class=pic src="../img/'.$rec['img_name'].'"></td>';
    print'</tr>';
  }

  print '</table>';
  print '<input type="submit" name="disp" value="参照">';
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
