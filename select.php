<?php
//相対パスで上のファイルを指定し、ファイルｈを使えるようにする
require_once('funcs.php');

//1.  DB接続します
try {
  //Password:MAMP='root',XAMPP=''
  $pdo = new PDO('mysql:dbname=gs_bookmark;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('DBConnection Error:'.$e->getMessage());
}


//２．データ取得SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_bm_table");
$status = $stmt->execute();

//３．データ表示
//データを取り出してTHTML化していく指示を行う
$view=""; //HTML文字列作り、入れる変数
if($status==false) {
  //SQLエラーの場合
  sql_error($stmt);
}else{
  //SQL成功の場合
  while( $r = $stmt->fetch(PDO::FETCH_ASSOC)){ //データ取得数分繰り返す
    //以下でリンクの文字列を作成, $r["id"]でidをdetail.phpに渡しています
    $view .= '<a href="detail.php?id='.h($r["id"]).'">';
    $view .= h($r["id"])."|".h($r["book"])."|".h($r["url"]);
    $view .= '</a>';
    $view .= '<a href="delete.php?id='.h($r["id"]).'">';
    $view .= "[削除]<br>";
    $view .= '</a>';
  }
}

?>


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>ブックマーク</title>
<link rel="stylesheet" href="css/range.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}</style>
</head>
<body id="main">
<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
      <a class="navbar-brand" href="index.php">ブックマーク一覧</a>
      </div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<div>
    <div class="container jumbotron"><?=$view?></div>
</div>
<!-- Main[End] -->

</body>
</html>
