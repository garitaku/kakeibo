<?php

//情報全部
$sql = "SELECT * FROM main 
    LEFT JOIN in_out ON in_out.id = main.type 
    LEFT JOIN income_category ON income_category.id = main.income_category 
    LEFT JOIN spending_category ON spending_category.id = main.spending_category 
    WHERE `deleted_at`IS NULL
    AND main_id = '".$main_id."';";
$statement = $pdo->query($sql);
$main = $statement->fetchAll();

//収入を選んだ際のカテゴリリスト
$sql = "SELECT * FROM income_category;";
$statement = $pdo->query($sql);
$income = $statement->fetchAll();

//支出を選んだ際のカテゴリリスト
$sql = "SELECT * FROM spending_category;";
$statement = $pdo->query($sql);
$spending = $statement->fetchAll();

//出入のリスト
$sql = "SELECT * FROM in_out;";
$statement = $pdo->query($sql);
$in_out = $statement->fetchAll();