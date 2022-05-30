<?php
header('Content-Type: application/json');

$folder = __DIR__ . '/uploaded/';

// 把上傳的檔案搬移到指定位置
move_uploaded_file($_FILES['myfile']['tmp_name'], $folder . $_FILES['myfile']['name']);
// 同名檔案將會被覆蓋所以可以用雜湊處理檔名
// 晚點再討論

echo json_encode($_FILES);

// 單一檔案
// $_FILES['myfile']

// 注意表單欄位名稱會變成內建變數的 key
// tmp_name 是暫存的暫存檔 會存在一個資料夾中
// 因為安全性的緣故 不會以原本的檔名去存放
// 是一個暫存檔 這個 php 跑完就會消除
// 這個路徑可以在 php.ini 中設定 一般不會去調整它

// 上傳多個檔案 欄位名稱要改成 myfile[]
/*
{
    "myfile": {
        "name": "v_149255855_m_601_m1_220_124.jpg",
        "type": "image/jpeg",
        "tmp_name": "C:\\xampp\\tmp\\phpFB9.tmp",
        "error": 0,
        "size": 5576
    }
}
*/

//
/*
{
    "myfile": {
        "name": [
            "v_147904924_m_601_220_124.jpg",
            "v_148103914_m_601_m2_220_124.jpg",
            "v_148111956_m_601_m1_220_124.jpg"
        ],
        "type": [
            "image/jpeg",
            "image/jpeg",
            "image/jpeg"
        ],
        "tmp_name": [
            "C:\\xampp\\tmp\\php4272.tmp",
            "C:\\xampp\\tmp\\php4273.tmp",
            "C:\\xampp\\tmp\\php4274.tmp"
        ],
        "error": [
            0,
            0,
            0
        ],
        "size": [
            5815,
            7780,
            6892
        ]
    }
}
*/

?>
