<?php
// 讀取檔案 這部分沒有更動
$json = file_get_contents('./hobbiesList.json'); 
$data = json_decode($json, true);

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
    <title>FORM-RENDER-DATA-BY-JS</title>
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
                <form name="formForm" onsubmit="sendData(); return false;">

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">你的興趣是？</label>
                        <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" data-multiple name="hobbiesOne">
                            <option value="" selected disabled>-- 請選擇 --</option>
                            <?php foreach ($hobbies as $k => $v) : ?>
                                <option value="<?= $k ?>"><?= $v ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">你的興趣是（二）？</label>
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
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script>
        // 換一個方式做資料比對以還原選項
        const data = <?= json_encode($data, JSON_UNESCAPED_UNICODE); ?>;

        document.formForm.hobbiesOne.value = data.postData.hobbiesOne;
        document.formForm.hobbiesTwo.value = data.postData.hobbiesTwo;

        // 注意要使用兩個 \ 跳脫
        document.querySelectorAll('input[name=hobbiesThree\\[\\]]').forEach(
            element => {
                if (data.postData.hobbiesThree.includes(element.value)) {
                    element.checked = true;
                }
            }
        );
    </script>
</body>

</html>