<?php

################################################
# 共通処理系
################################################
##XSS(クロスサイトスクリプティング）対策用の関数
##引数１（配列）に対して、対策を行い戻り値１（配列）で返す
function sanitize($before){
	if(is_array($before)==true){
		foreach($before as $key=>$value){
			$after[$key]=htmlspecialchars($value);
			#$after[$key]=htmlspecialchars($value,ENT_QUOTES,'UTF-8');
		}
	}else{
		echo'error message 0001';
	}
	return $after;
}

##ログイン（セッション開始）
function sessionStart(){
	session_start();
	# sessionの値を再作成してセキュリティ向上
	session_regenerate_id(true);
	# session['login']==1ならログイン中のフラグ
	if(isset($_SESSION['login'])==false){
	  print 'ログインされていません<br>';
	  print '<a href=../login/login.html>ログインページ</a>';
	  exit();
	}
	return;
}

##ログアウト（セッション終了）
function sessionEnd(){
	session_start();
	#（１）session配列に対して空配列を挿入
	$_SESSION=array();
	#（２）クライアントのブラウザ上のcookieの値が使用されていたら初期化
	if(isset($_COOKIE[session_name()])==true){
		# 第1引数はクッキー変数名、第2引数は置換後のクッキー変数名、第3引数は有効期限
	  setcookie(session_name(),'',time()-42000,'/');
	}
	#（３）サーバ側のsessionIDの破棄
	session_destroy();
}


################################################
# DB関係
################################################

## DB接続
## 戻り値１：PDOインスタンス
# アロー演算子(->)＝インスタンスのメソッド/プロパティにアクセス
# スコープ定義演算(::)＝クラスのメソッド/プロパティにアクセス（静的メソッド、プロパティ）
function DBconnect(){
	#変数定義
	$dsn='mysql:dbname=suit;host=localhost;charset=utf8';
	$user='root';
	$password='';
	#インスタンス化（コンストラクタで接続）
	$dbh=new PDO($dsn,$user,$password);
	# PDO classのsetAttributeメソッド（設定を指定する）を実行
	# 第1引数、PDO::ATTR_ERRMODE。SQL実行でエラーが起こった際にどう処理するかを指定。
	# 第2引数、PDO::ERRMODE_EXCEPTION を設定すると例外をスローしてくれる
	$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	return $dbh;
}

## SQL実行
## 引数１：PDOインスタンス、引数２：実行SQL文のString、引数３：SQLの？となる文が格納された配列
## 戻り値１：プリペアステートメントされたPDOインスタンス
function DBexecute($dbh,$sql,$question){
	$stmt=$dbh->prepare($sql);
	$stmt->execute($question);
	return $stmt;
}

function DBexecute2($dbh,$sql){
	$stmt=$dbh->prepare($sql);
	$stmt->execute();
	return $stmt;
}


?>
