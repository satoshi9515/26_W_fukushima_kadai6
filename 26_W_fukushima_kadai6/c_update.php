<?php

$c_name=$_POST["c_name"];
$t_name=$_POST["t_name"];
$c_length=$_POST["c_length"];
$c_id=$_POST["c_id"];

try {
  $pdo = new PDO('mysql:dbname=gs_kdb;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('DbConnectError:'.$e->getMessage());
}


//３．データ登録SQL作成
$stmt = $pdo->prepare("UPDATE gs_course_table SET c_name=:c_name, t_name=:t_name, c_length=:c_length WHERE c_id=:c_id");
$stmt->bindValue(':c_id' ,$c_id,  PDO::PARAM_INT); 
$stmt->bindValue(':c_name', $c_name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':t_name', $t_name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':c_length', $c_length, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
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
