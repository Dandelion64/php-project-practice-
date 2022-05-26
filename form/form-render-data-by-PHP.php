<?php
// 讀取檔案
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
    <title>FORM-RENDER-DATA-BY-PHP</title>
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
                                <?php
                                // 和 $data 比對以還原
                                ?>
                                <option value="<?= $k ?>" <?= $data['postData']['hobbiesOne'] == $k ? 'selected' : '' ?>><?= $v ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">你的興趣是（二）？</label>
                        <?php foreach ($hobbies as $k => $v) : ?>
                            <div class="form-check">
                                <?php
                                // 和 $data 比對以還原
                                ?>
                                <input class="form-check-input" type="radio" name="hobbiesTwo" id="hobbiesTwo-<?= $k ?>" value="<?= $k ?>" <?= $data['postData']['hobbiesTwo'] == $k ? 'checked' : '' ?>>
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
                                <?php
                                // 和 $data 比對以還原
                                ?>
                                <input class="form-check-input" type="checkbox" name="hobbiesThree[]" value="<?= $k ?>" id="hobbiesThree-<?= $k ?>" <?= in_array($k, $data['postData']['hobbiesThree']) ? 'checked' : '' ?>>
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
</body>

</html>