<?php
//1. POSTデータ取得
//まずPOSTでとってきたデータを変数で定義
$book = $_POST['book'];
$url = $_POST['url'];
$comment = $_POST['comment'];

//2. DB接続します
try {
  //Password:MAMP='root',XAMPP=''
  $pdo = new PDO('mysql:dbname=gs_bookmark;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('DBConnection Error:'.$e->getMessage());
}


//３．データ登録SQL作成
//仮置しておいた内容にbindValueで後から置き換えることで脆弱性から守る。
$stmt = $pdo->prepare("insert into gs_bm_table(book, url, comment, date) values(:book, :url, :comment, sysdate())");
$stmt->bindValue(':book', $book, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':url', $url, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':comment', $comment, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
//撮ってきた値の真偽をステータスでみせるための変数
$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("SQL_ERROR:".$error[2]);
}else{
  //５．index.phpへリダイレクト
  //locaton:のあとに必ず半角スペースが必要
  header("Location: index.php");
  //exiteで処理終了
  exit();
}
?>

