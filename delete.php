<?php

require('dbconnect.php');
$main_id = $_POST["main_id"];
var_dump($_POST["main_id"]);
$sql = "UPDATE `main` SET `deleted_at`= CURRENT_TIME() WHERE `main_id`= ".$main_id;
var_dump($sql);
$stmt = $pdo->prepare($sql); //SQL文を準備するメソッド
$stmt->execute();

header('Location:index.php');
?>