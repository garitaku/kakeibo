<?php

try {
    $pdo = new PDO(
        'mysql:host=localhost;dbname=kakeibo;charset=utf8mb4',
        'root',
        '',
        [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, //エラーメッセージの出力
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC //fetchメソッドで引数が省略された場合のスタイル
        ]
    );
    echo "接続成功\n";
} catch (PDOException $e) {
    echo "接続失敗: " . $e->getMessage() . "\n";
    exit();
}