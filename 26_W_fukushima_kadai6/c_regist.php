<?php
session_start();
include("u_funcs.php");
loginCheck();
//1.  DB接続します
$pdo = db_connect();

//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_teachers_table");
$status = $stmt->execute();

//３．データ表示
$view="";
if($status==false) {
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);

} else {
  //Selectデータの数だけ自動でループしてくれる
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
    // $view .= '<select>';
    $view .= '<option>';
    $view .= $result["t_name"];
    $view .= "</option>";
    // $view .= "</select>";
    // $age_data .= "<option value='". $age_data_key;
    // $age_data .= "'>". $age_data_val. "</option>";
  }

}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>授業新規登録</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>div{padding: 10px;font-size:16px;}</style>


</head>
<body>

<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
    <div class="navbar-header">
        <a class="navbar-brand" href="univ_mainmenu.php">メインメニュー</a>
        <a class="navbar-brand" href="t_regist.php">講師登録</a>
        <a class="navbar-brand" href="t_select.php">授業管理</a>
        <a class="navbar-brand" href="c_regist.php">授業登録</a>
        <a class="navbar-brand" href="c_select.php">授業管理</a>
      </div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<form method="post" action="c_insert.php">
  <div class="jumbotron">
   <fieldset>
    <legend>新規授業登録</legend>
    <label><input name="id" type="hidden"></label><br>
     <label>授業名：<input type="text" name="c_name"></label><br>
     <label>講師名：<select name="t_name"><?=$view?></select></label><br>
     <label>授業時間：<input type="text" name="c_length">分</label><br>
     <input type="submit" value="送信">
    
    </fieldset>
  </div>
</form>
<!-- Main[End] -->


</body>
</html>
