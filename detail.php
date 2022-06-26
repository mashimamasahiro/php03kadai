<?php
//１．PHP
//select.phpの[PHPコードだけ！]をマルっとコピーしてきます。
//※SQLとデータ取得の箇所を修正します。

$id = $_GET["id"];
// echo $id; でまずIDがとれているか確認

//////////////SELECT.PHPからコピペ///////////////////////
include("funcs.php");  //funcs.phpを読み込む（関数群）
$pdo = db_conn();      //DB接続関数

//２．データ登録SQL作成 where以降で場所を特定
$stmt   = $pdo->prepare("SELECT * FROM gs_bm_table WHERE id=:id"); //SQLをセット
$stmt->bindValue(':id',   $id,    PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute(); //SQLを実行→エラーの場合falseを$statusに代入

//３．データ表示
$view=""; //HTML文字列作り、入れる変数
if($status==false) {
  //SQLエラーの場合
  sql_error($stmt);
}else{
  //SQL成功の場合
  // while( $r = $stmt->fetch(PDO::FETCH_ASSOC)){ //データ取得数分繰り返す
  //   //以下でリンクの文字列を作成, $r["id"]でidをdetail.phpに渡しています
  //   $view .= '<a href="detail.php?id='.h($r["id"]).'">';
  //   $view .= h($r["id"])."|".h($r["name"])."|".h($r["email"])."<br>";
  //   $view .= '</a>';
  // }
  $row = $stmt->fetch();//ひとつのデータを取り出して$rowに格納
  // var_dump($row);で内容とれているか確認

}
//////////////////////////


?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>データ更新</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>

<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
    <div class="navbar-header"><a class="navbar-brand" href="select.php">データ一覧</a></div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<form method="POST" action="update.php">
  <div class="jumbotron">
   <fieldset>
   <legend>お気に入りの本を登録しよう</legend>
     <label>書籍名：<br><input type="text" name="book"></label><br>
     <label>書籍URL：<br><input type="text" name="url"></label><br>
     <label>コメント：<br><textArea name="comment" rows="4" cols="40"></textArea></label><br>
     <!-- idを隠して送信 -->
     <input type="hidden" name="id" value="<?=$id?>">
     <!-- idを隠して送信 -->
     <input type="submit" value="送信">
    </fieldset>
  </div>
</form>
<!-- Main[End] -->


</body>
</html>




