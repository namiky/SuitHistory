<?php
## ログイン状態確認
require_once('../common/common.php');
sessionStart();
 ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>タイトル</title>
</head>
<body>

ショップ管理トップメニュー<br />
<br />
<a href="../history/history_list.php">ヒストリー</a><br />
<br />
<a href="../item/item_list.php">アイテム</a><br />
<br />
<a href="../img/img_list.php">画像登録</a><br />
<br />
<a href="../login/logout.php">ログアウト</a><br />

</body>
</html>
