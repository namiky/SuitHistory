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
# 画像ファイル処理系
################################################
#######################
## toJpg関数
## 引数１：file情報格納されたリスト、
##
## ～～処理概要～～
## １．アップロードされたfileの拡張子のままで一時保存
## ２．拡張子をJPG変換したファイルで保存
## ３．一時保存したファイルを削除
## ～～処理概要～～　ここまで
#######################
function toJpg($img){
	# 画像fileの取得と格納(拡張子変更前。拡張子jpgに変更する場合あとで削除)
	move_uploaded_file($img['tmp_name'],'../picture/'.$img['name']);

	# 拡張子取得
	$extension=pathinfo($img['name'], PATHINFO_EXTENSION);

	# 元データと元拡張子をもとにimage（領域？）生成
	switch ($extension){
	  case "jpg":
	  case "jpeg":
			return;
	  case "png":
	    $image = @imagecreatefrompng('../picture/'.$img['name']);
	    break;
	  case "gif":
	    $image = @imagecreatefromgif('../picture/'.$img['name']);
	    break;
	  default :
	    print "拡張子が対応していないです";
	    exit();
	}

	# 新しいPathとファイル名の定義
	$new_img_path='../picture/'.pathinfo($img['name'],PATHINFO_FILENAME).'.jpg';

	# 生成したimageに対して、jpeg拡張子のFullPathで別保存
	imagejpeg($image,$new_img_path);

	#一時保存のfile削除
	unlink('../picture/'.$img['name']);

	#imageの領域解放
	imagedestroy($image);

	return;
}

#######################
#resizeImage関数
# 引数１：リサイズしたい画像fileのフルパス
# 戻り値：なし
# 処理
# 1.リサイズして画像を上書き保存
#
#この処理のコピー元
#http://unskilled.site/php%E3%81%A7gd%E3%83%A9%E3%82%A4%E3%83%96%E3%83%A9%E3%83%AA%E3%82%92%E4%BD%BF%E3%81%A3%E3%81%A6%E7%94%BB%E5%83%8F%E3%83%AA%E3%82%B5%E3%82%A4%E3%82%BA%EF%BC%88%E3%82%B5%E3%83%A0%E3%83%8D%E3%82%A4/
# >中央トリミングでサムネイルを作るよ
#######################
function resizeImage($file){
	//元の画像のサイズを取得する
	list($w, $h) = getimagesize($file);

	//元画像の縦横の大きさを比べてどちらかにあわせる
	// 縦横の差をコピー開始位置として使えるようセット
	if($w > $h){//横のほうが長い場合
	  $diff  = ($w - $h) * 0.5;
	  $diffW = $h;
	  $diffH = $h;
	  $diffY = 0;
	  $diffX = $diff;
	}elseif($w < $h){//縦のほうが長い場合
	  $diff  = ($h - $w) * 0.5;
	  $diffW = $w;
	  $diffH = $w;
	  $diffY = $diff;
	  $diffX = 0;
	}elseif($w === $h){
	  $diffW = $w;
	  $diffH = $h;
	  $diffY = 0;
	  $diffX = 0;
	}
	//サムネイルのサイズ
	$thumbW = 100;
	$thumbH = 100;
	//サムネイルになる土台の画像を作る
	$thumbnail = imagecreatetruecolor($thumbW, $thumbH);
	//元の画像を読み込む
	$baseImage = imagecreatefromjpeg($file);
	//サムネイルになる土台の画像に合わせて元の画像を縮小しコピーペーストする
	imagecopyresampled($thumbnail, $baseImage, 0, 0, $diffX, $diffY, $thumbW, $thumbH, $diffW, $diffH);
	//保存する
	imagejpeg($thumbnail, $file);

	return;
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

#img情報取得用
#getImg():defaultがtrueの全IMGを取得
#getImg(user_id):ユーザが登録した全IMGを取得
function getImg($user_id="default"){
	#DB接続
	$dbh=DBconnect();

	switch($user_id){
		#引数なしの場合
		case "default":
			#SQL文定義
			$sql='SELECT id AS img_id, name AS img_name FROM img WHERE img.def=1';
			#SQL実行
			$stmt=DBexecute2($dbh,$sql);
			break;

		#引数ありの場合
		default:
			#SQL文定義
			$sql='SELECT id AS img_id, name AS img_name FROM img WHERE img.user_id=?';
			$question[]=$user_id;
			#SQL実行
			$stmt=DBexecute($dbh,$sql,$question);
			break;
	}

	#dbh破棄（$stmtを使用するので）
	$dbh=null;

  #sql結果取得
	$i=0;
	$image=array();
	while(true){
	  $rec = $stmt->fetch(PDO::FETCH_ASSOC);
		if($rec==false){
			break;
		}
		$image[$i]['img_id']=$rec['img_id'];
		$image[$i]['img_name']=$rec['img_name'];
		$i++;
	}

	return $image;
}

?>
