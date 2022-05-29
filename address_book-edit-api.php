<?php require __DIR__ . '/parts/database_connect_by_pdo.php';
header('Content-Type: application/json');
// API 只有功能 沒有外觀 用來回應 JSON

$output = [
    'success' => false,
    'postData' => $_POST, 
    'code' => 0,
    'error' => ''
];

$sid = isset($_POST['sid']) ? intval($_POST['sid']) : 0; 

// Todo: 欄位檢查 後端的檢查

// 先檢查必填的欄位
if (empty($sid) or empty($_POST['name'])) {
    $output['error'] = '資料不齊';
    $output['code'] = 400;
    echo json_encode($output,JSON_UNESCAPED_UNICODE);
    exit;
}

$name = $_POST['name'];
$email = $_POST['email'] ?? '';
$mobile = $_POST['mobile'] ?? '';
$birthday = empty($_POST['birthday']) ? NULL : $_POST['birthday'];
$address = $_POST['address'] ?? '';

if (!empty($email) and filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
    $output['error'] = 'email 格式錯誤';
    $output['code'] = 405;
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

$sql = 
    "UPDATE `address_book` SET `name`=?, `email`=?, `mobile`=?, `birthday`=?, `address`=? WHERE `sid`=$sid";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    $name,
    $email,
    $mobile,
    $birthday,
    $address
]);

if ($stmt->rowCount() == 1) {
    $output['success'] = true;
    $output['code'] = 200;
} else {
    $output['error'] = '無法修改資料';
}

echo json_encode($output,JSON_UNESCAPED_UNICODE);

?>