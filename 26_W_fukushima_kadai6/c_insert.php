<?php
//入力チェック(受信確認処理追加)
if(
  !isset($_POST["t_name"]) || $_POST["t_name"]=="" ||
  !isset($_POST["c_name"]) || $_POST["c_name"]=="" ||
  !isset($_POST["c_length"]) || $_POST["c_length"]=="" 
){
  exit('ParamError');
}


//1. POSTデータ取得
$t_name=$_POST["t_name"];
$c_name=$_POST["c_name"];
$c_length=$_POST["c_length"];





//2. DB接続します(エラー処理追加)
try {
  $pdo = new PDO('mysql:dbname=gs_kdb;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('DbConnectError:'.$e->getMessage());
}


//３．データ登録SQL作成
$stmt = $pdo->prepare("INSERT INTO  gs_course_table (c_id, c_name, t_name, c_length, 
indate )VALUES(NULL, :a1, :a2, :a3, sysdate())");
$stmt->bindValue(':a1', $c_name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':a2', $t_name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':a3', $c_length, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("QueryError:".$error[2]);

}else{
  //５．index.phpへリダイレクト
  header("Location: c_select.php");
  exit;

}
?>
