<?php
$hash = '$2y$10$aAkTsOTRPTXkp11Dncei7.GTy1VITyrsjC2J4CFliIIJckLgOxIOq';

$password = isset($_GET['password']) ? $_GET['password'] : '';

if (password_verify($password, $hash)) {
    echo '逼波逼波';
} else {
    echo '鱉鱉';
}

// echo password_hash($password, PASSWORD_BCRYPT);

?>