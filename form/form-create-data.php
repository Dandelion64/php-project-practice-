<?php
// 資料從後端過來
$hobbies = [
    '1' => '游泳',
    '2' => '爬山',
    '3' => '滑雪',
    '4' => '慢跑',
    '5' => '攀岩',
    '6' => '倒立',
    '7' => '繪畫',
    '8' => '寫作',
    '9' => '睡覺'
];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>FORM-CREATE-DATA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous" />
    <style type="text/css">
        .mb-3 {
            margin-top: 15px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <!-- Bootstraps Form Overview -->
                <form name="formForm" onsubmit="sendData(); return false;">

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">你的興趣是？</label>
                        <!-- combobox -->
                        <!-- Bootstraps Form Select -->
                        <!-- 超過 20 個項目時 -->
                        <!-- 建議選擇使用 Combobox -->
                        <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" data-multiple name="hobbiesOne">
                            <option value="" selected disabled>-- 請選擇 --</option>
                            <?php foreach ($hobbies as $k => $v) : ?>
                                <option value="<?= $k ?>"><?= $v ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- 項目不多時 -->
                    <!-- 建議選擇使用 Radio Btton Group -->
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">你的興趣是（二）？</label>
                        <!-- 注意 name 相同 -->
                        <!-- 才會是相同的 group -->
                        <?php foreach ($hobbies as $k => $v) : ?>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="hobbiesTwo" id="hobbiesTwo-<?= $k ?>" value="<?= $k ?>">
                                <label class="form-check-label" for="hobbiesTwo">
                                    <?= $v ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">你的興趣是（三）？</label>

                        <?php foreach ($hobbies as $k => $v) : ?>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="hobbiesThree[]" value="<?= $k ?>" id="hobbiesThree-<?= $k ?>">
                                <label class="form-check-label" for="hobbiesThree-<?= $k ?>">
                                    <?= $v ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <!-- 放兩個隱藏的測試用 input -->
                    <!-- 注意送出的和 checkbox 相同樣式 -->
                    <!-- 會以相同 key 被 POST 送出 -->
                    <!-- PHP 收到 *[] 的多個 key 時 -->
                    <!-- 會將其組成陣列 * = [*, *, ...] -->
                    <input type="hidden" name="test[]" value="hola">
                    <input type="hidden" name="test[]" value="哈囉">

                    <button type="submit" class="btn btn-primary">送出</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script>
        // 注意這裡 如果在 console 跳脫要使用兩個 \\
        // name="" 中是字串
        // 第一個用來跳脫第二個 第二個用來跳脫前後中括號
        // document.querySelectorAll('input[name=hobby3\\[\\]]').forEach(e=>console.log(e.checked, e.value));
        
        const sendData = async () => {
            const fd = new FormData(document.formForm);

            const r = await fetch('file-put-contents-api.php',
                {
                    method: "POST",
                    body: fd    
            });

            const result = await r.json();

            console.log(result);
        }
    </script>
</body>

</html>