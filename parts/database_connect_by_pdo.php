<?php
    $db_host = 'localhost';
    $db_user = 'dandelion';
    $db_pass = 'dandelio';
    $db_name = 'self_study';
    $db_charset = 'utf8mb4';
    $db_collate = 'utf8mb4_unicode_ci';

    $dsn = "mysql:host={$db_host};dbname={$db_name};charset={$db_charset}";

    // ATTR_PERSISTENT 持久連線會有佔線問題
    // ATTR_EMULATE_PREPARES 防止 SQL injection
    $pdo_options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_PERSISTENT => false,
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES {$db_charset} COLLATE {$db_collate}"
    ];

    try {
        $pdo = new PDO($dsn, $db_user, $db_pass, $pdo_options);
    } catch(PDOException $ex) {
        echo 'Connection failed: ' . $ex->getMessage();
    }

if (! isset($_SESSION)){
    session_start();
}
?>