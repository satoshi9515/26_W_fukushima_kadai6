 <?php
session_start();
//2. SESSION変数に値を代入！！
$u_name =$_SESSION["u_name"] ;
$u_account=$_SESSION["u_account"];
$u_pw =$_SESSION["u_pw"];

include("u_funcs.php");
loginCheck();
//1.  DB接続します
$pdo = db_connect();

//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_teachers_table");
$status = $stmt->execute();

//３．データ表示
$tview="";
if($status==false) {
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);

} else {
  //Selectデータの数だけ自動でループしてくれる
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
    $tview .= "<p>";
    $tview .= '講師名　';
    $tview .= $result["t_name"];
    $tview .="</p>";
  }

}

$pdo = db_connect();

//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_course_table");
$status = $stmt->execute();

//３．データ表示
$cview="";
if($status==false) {
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);

} else {
  //Selectデータの数だけ自動でループしてくれる
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
    $cview .= "<p>";
    $cview .= '<a href="u_view.php?id='.$result["c_name"].'">';
    $cview .= '講師名　';
    $cview .= $result["t_name"]."　:授業時間".$result["c_length"];
    $cview .='分'; 
    $cview .='</a>';
    $cview .='　　';
    $cview .= '<a href="delete.php?id='.$result["c_id"].'">';
    $cview .='[削除]';

    $cview .='</a>';
    
    $cview .="</p>";
  }

}
?>



<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>大学メインメニュ</title>
  <link rel="stylesheet" href="samplem.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>



</head>
<body>
  <div class="header">
    <div class="univdisplay">ようこそ<?=$u_name?>大学様</div>
    <ul class="header-menu">
      <li><a href="t_select.php">授業・講師管理</a></li>
      <li><a href="mainmenu.php">受講状況</a></li>
      <li><a href="asobimenu.php">学生管理</a></li>
      <li><a href="logout.php">ログアウト</a></li>
      <li><a href="setting.php">各種設定</a></li>
    </ul>
  </div>

  <div id="container"> <!-- コンテナ -->
    <div id="itemA">
      <div>講師一覧</div>
      <div class="container jumbotron"><?=$tview?></div>
    </div> <!-- アイテム -->

    <div id="itemB">
      <div>授業ダッシュボード</div>
      <div class="container jumbotron"><?=$cview?></div>
    </div>
    
    <div id="itemC">
      <div>人気講師</div>
    </div>
  </div>
</body>
</html>
