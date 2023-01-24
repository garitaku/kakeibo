<?php
require('dbconnect.php');

$date = $_POST['date'];
$title = $_POST['title'];
$amount = $_POST['amount'];
$title = $_POST['title'];
$category = $_POST['category'];
$type = $_POST['inout'];
$memo = $_POST['memo'];

//SQLインジェクション対策のためVALUESの中に直接値を入れず、プレースホルダ(?)でいったん記載
if ($type == 1) {
    $sql = "INSERT INTO `main`(`date`, `title`, `amount`, `spending_category`, `type`, `memo`) VALUES (?,?,?,?,?,?);";
} elseif ($type == 2) {
    $sql = "INSERT INTO `main`(`date`, `title`, `amount`, `income_category`, `type`, `memo`) VALUES (?,?,?,?,?,?);";
}

$stmt = $pdo->prepare($sql); //SQL文を準備するメソッド

//変数の値とプレースホルダ(?)を結び付ける
$stmt->bindValue(1, $date, PDO::PARAM_STR);
$stmt->bindValue(2, $title, PDO::PARAM_STR);
$stmt->bindValue(3, $amount, PDO::PARAM_STR);
$stmt->bindValue(4, $category, PDO::PARAM_STR);
$stmt->bindValue(5, $type, PDO::PARAM_STR);
$stmt->bindValue(6, $memo, PDO::PARAM_STR);

$stmt->execute();

header('Location:index.php');
exit;
?>