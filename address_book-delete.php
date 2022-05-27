<?php require __DIR__ . '/parts/database_connect_by_pdo.php';

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
if (! empty($sid)) {
    $pdo->query("DELETE FROM `address_book` WHERE sid=$sid");
}

$comeFrom = 'address_book-list.php';
if (! empty($_SERVER['HTTP_REFERER'])) {
    $comeFrom = $_SERVER['HTTP_REFERER'];
}
header("Location: $comeFrom");

?>