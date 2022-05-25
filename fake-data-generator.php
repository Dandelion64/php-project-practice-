<?php require __DIR__ . '/parts/database_connect_by_pdo.php';
exit; // 產生資料後就可以不用執行了

$lastName = ['雞肉', '鴨肉', '牛肉', '豬肉', '蛇肉', '鵝肉', '川味', '土味', '台味', '哈味'];
$firstName = ['王', '珍', '伯', '榮', '李', '林', '姊', '哥', '仔', '狂'];
$emailAccountPrefix = ['apple', 'banana', 'cherry', 'durian', 'grape', 'peach', 'lemon', 'papaya', 'coconut', 'litchi'];
$emailSite = ['gmail.com', 'hotmail.com', 'yahoo.com.tw', 'qq.com'];
$livingDivision = ['台北市', '新北市', '桃園市', '台中市', '台南市', '高雄市', '宜蘭縣', '新竹縣', '苗栗縣', '彰化縣', '南投縣', '雲林縣', '嘉義縣', '屏東縣', '宜蘭縣', '花蓮縣', '臺東縣', '澎湖縣', '基隆市', '新竹市', '嘉義市'];

$sql =
    "INSERT INTO `address_book`(
        `name`, `email`, `mobile`,
        `birthday`, `address`, `created_at`
    ) VALUES (
        ?, ?, ?,
        ?, ?, ?
    )";

$pdoStatement = $pdo->prepare($sql);

// 想生成的資料數量
$dataNumber = 500;

for ($i=1; $i<=$dataNumber; $i++) {
    shuffle($lastName);
    shuffle($firstName);
    shuffle($emailAccountPrefix);
    shuffle($emailSite);
    shuffle($livingDivision);

    $birthTimestamp = rand(strtotime('1970-01-01'), strtotime('2020-05-25'));
    $createAtTimestamp = rand(strtotime('2022-01-01 00:00:00'), strtotime('2022-05-25 00:00:00'));

    // 用 random 生不好 因為越長機率越高
    $emailRandomNumber = rand(1000, 999999);
    $mobileRandomNumberPrefix = rand(10, 99);
    $mobileRandomNumberSuffixP = rand(100, 999);
    $mobileRandomNumberSuffixS = rand(100, 999);
    
    $pdoStatement->execute([
        $lastName[0] . $firstName[0],
        "{$emailAccountPrefix[0]}{$emailRandomNumber}@{$emailSite[0]}",
        "09{$mobileRandomNumberPrefix}-{$mobileRandomNumberSuffixP}-{$mobileRandomNumberSuffixS}",
        date('Y-m-d', $birthTimestamp),
        $livingDivision[0],
        date('Y/m/d H:i:s', $createAtTimestamp)
    ]);
}

?>