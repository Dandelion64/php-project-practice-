<?php require __DIR__ . '/parts/database_connect_by_pdo.php';

$result = [
    'success' => false,
    'code' => 400,
    'info' => '參數不⾜',
    'postData' => [],
];

if (isset($_POST['name']) and isset($_POST['email'])) {
    $result['postData'] = $_POST;
    $s_sql = 
        "SELECT 1 
        FROM `address_book` 
        WHERE `email`=?";
    $s_stmt = $pdo->prepare($s_sql);

    // 注意 execute() 只接受陣列
    $s_stmt->execute([$_POST['email']]);

    if ($s_stmt->rowCount() == 1) {
        $result['code'] = 420;
        $result['info'] = 'Email 重複';
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
        exit;
    }

    $sql = 
        "INSERT INTO `address_book`(
        `name`, `email`, `mobile`, `address`, `birthday`
        ) VALUES (?, ?, ?, ?, ?)";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        $_POST['name'],
        $_POST['email'],
        $_POST['mobile'],
        $_POST['address'],
        $_POST['birthday']
    ]);
    
    // 影響的列數 (筆數)
    if ($stmt->rowCount() == 1) {
        $result['success'] = true;
        $result['code'] = 200;
        $result['info'] = '資料新增完成';
    } else {
        $result['code'] = 410;
        $result['info'] = '資料沒有新增';
    }
}
echo json_encode($result, JSON_UNESCAPED_UNICODE);
