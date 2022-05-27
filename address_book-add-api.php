<?php require __DIR__ . '/parts/database_connect_by_pdo.php';
header('Content-Type: application/json');
// API 只有功能 沒有外觀 用來回應 JSON

// 預設不成功
// 'code' 用來除錯 自行設定錯誤碼
$output = [
    'success' => false,
    'postData' => $_POST, 
    'code' => 0,
    'lastInsertId' => 0,
    'error' => ''
];

// Todo: 欄位檢查 後端的檢查

// 先檢查必填的欄位
if (empty($_POST['name'])) {
    $output['error'] = '沒有姓名資料';
    $output['code'] = 400;
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
exit;
}

$sql = 
"INSERT INTO `address_book`(
        `name`, `email`, `mobile`,
        `birthday`, `address`, `created_at`
    ) VALUES (
        ?, ?, ?,
        ?, ?, NOW()
    )";

$stmt = $pdo->prepare($sql);

// 注意這裡對生日欄位做了預設值處理防止資料為空的狀況
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$mobile = $_POST['mobile'] ?? '';
$birthday = empty($_POST['birthday']) ? NULL : $_POST['birthday'];
$address = $_POST['address'] ?? '';

// if (! empty($email) and filter_var($email, FILTER_VALIDATE_EMAIL)===false) {
//     $output['error'] = 'email 格式錯誤';
//     $output['code'] = '405';
//     echo json_encode($output,JSON_UNESCAPED_UNICODE);
//     exit;
// }

// 嘗試用 preg_filter() 改寫以上部分
$emailPattern = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
// A crazy example of a regex that attempts to validate email addresses according to RFC 822 grammar:
// Ref: https://stackoverflow.com/questions/13719821/email-validation-using-regular-expression-in-php
// Ref2: https://stackoverflow.com/questions/20771794/mailrfc822address-regex


// 稍微改格式做辨別
if (! empty($email) and (!! preg_match($emailPattern, $email))===false) {
    $output['error'] = 'Email 格式不對啦';
    $output['code'] = '405-05'; 
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

// Todo: 其它欄位檢查

$stmt->execute([
    $name,
    $email,
    $mobile,
    $birthday,
    $address
]);

// $output['success'] = !! $stmt->rowCount();
// Alternative
// $output['success'] = $stmt->rowCount()==1;

if (!! $stmt->rowCount()) {
    $output['success'] = true;
    $output['code'] = 200;
    // 最近新增資料的 Primary Key
    $output['lastInsertId'] = $pdo->lastInsertId();
} else {
    $output['error'] = '無法新增資料';
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);

?>