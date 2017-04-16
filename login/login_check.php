<?php
##
## login成功の場合は次の画面に繊維し、失敗の場合は失敗の旨表記
##
try
{
	#共通関数の読み取り
	require_once('../common/common.php');

	#XSS対策
	$post=sanitize($_POST);

	#postを取得
	$name=$post['name'];
	$pass=$post['pass'];

	#PWの暗号化
	$pass=md5($pass);

	#DB接続
	$dbh=DBconnect();

	#SQL実行準備
	$sql='SELECT id FROM user WHERE name=? AND password=?';
	$question[]=$name;
	$question[]=$pass;

	#SQL実行
	$stmt=DBexecute($dbh,$sql,$question);

	#dbh破棄（$stmtを使用するので）
	$dbh=null;

	# sql実行予定結果をFETCH_ASSOC形式で取り出す
	# FETCH_ASSOC形式：連想配列でKeyが項目名、値がSQL結果。
	# 1行取得のときに使用。複数行が結果の場合は最後のカラムが対象
	$rec=$stmt->fetch(PDO::FETCH_ASSOC);

	# ユーザIDとPWの組み合わせが存在しない場合
	if($rec==false){
		print 'スタッフコードかパスワードが間違っています。<br />';
		print '<a href="login.html"> 戻る</a>';
	}else{
		session_start();
		$_SESSION['login']=1;
  	$_SESSION['name']=$name;
		$_SESSION['user_id']=$rec['id'];

		header('Location:mypage.php');
		exit();
	}

}catch(Exception $e){
	print 'ただいま障害により大変ご迷惑をお掛けしております。';
	exit();
}

?>
