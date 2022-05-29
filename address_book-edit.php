<?php require __DIR__ . '/parts/database_connect_by_pdo.php';
$pageName = 'address_book-edit';
$title = '編輯通訊錄 - 丹德里恩的練習';

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
if (empty($sid)) {
    header('Location: address_book-list.php');
    exit;
}

$newRow = $pdo->query("SELECT * FROM `address_book` WHERE sid=$sid")->fetch();
if (empty($newRow)) {
    header('Location: address_book-list.php');
    exit;
}

?>
<?php include __DIR__ . '/parts/html-head.php' ?>
<?php include __DIR__ . '/parts/navbar.php' ?>
<style type="text/css">
    .form-control.red {
        border: 1px solid #f00;
    }

    .form-text.red {
        color: #f00;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">編輯資料</h5>
                    <form name="formEdit" onsubmit="sendData();return false;" novalidate>
                        <?php
                            // 利用隱藏欄位送出 sid
                        ?>
                        <input type="hidden" name="sid" value="<?= $newRow['sid'] ?>">
                        <div class="mb-3">
                            <label for="name" class="form-label">name *</label>
                            <input type="text" class="form-control" id="name" name="name" required value="<?= htmlentities($newRow['name']) ?>">
                            <div class="form-text red"></div>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">email</label>
                            <input type="text" class="form-control" id="email" name="email" value="<?= $newRow['email'] ?>">
                            <div class="form-text red"></div>
                        </div>
                        <div class="mb-3">
                            <label for="mobile" class="form-label">mobile</label>
                            <input type="text" class="form-control" id="mobile" name="mobile" value="<?= $newRow['mobile'] ?>">
                            <div class="form-text red"></div>
                        </div>
                        <div class="mb-3">
                            <label for="birthday" class="form-label">birthday</label>
                            <input type="date" class="form-control" id="birthday" name="birthday" value="<?= $newRow['birthday'] ?>">
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">address</label>
                            <textarea class="form-control" name="address" id="address" cols="30" rows="3"><?= $newRow['address'] ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">修改</button>
                    </form>
                    <div id="info-bar" class="alert alert-success" role="alert" style="display:none;"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include __DIR__ . '/parts/scripts.php' ?>
<script>
    const newRow = <?= json_encode($newRow,JSON_UNESCAPED_UNICODE); ?>;


    // 檢查用的 pattern
    // Ref: https://stackoverflow.com/questions/46155/how-can-i-validate-an-email-address-in-javascript
    const email_re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zAZ]{2,}))$/;
    const mobile_re = /^09\d{2}-?\d{3}-?\d{3}$/;

    // 取得欄位 (field) 參照 
    const name_field = document.formEdit.name;
    const email_field = document.formEdit.email;
    const mobile_field = document.formEdit.mobile;

    const info_bar = document.querySelector('#info-bar');

    // 將紅色驗證模式變數化來處理
    const fields = [name_field, email_field, mobile_field];
    const fieldTexts = [];

    for (let f of fields) {
        fieldTexts.push(f.nextElementSibling);
    }



    const sendData = async () => {
        // 讓欄位的外觀回復原來的狀態
        for (let i in fields) {
            fields[i].classList.remove('red');
            fieldTexts[i].innerText = '';
            // display none 也可以
        }
        info_bar.style.display = 'none'; // 隱藏訊息列

        // Todo: 欄位檢查 前端的檢查
        let isPass = true; // 預設是通過檢查的

        if (name_field.value.length < 2) {
            // alert('姓名至少要兩個字元');
            name_field.classList.add('red');

            // 第一種寫法較好
            // name_field.nextElementSibling.classList.add('red');
            // name_field.closest('.mb-3').querySelector('.form-text').classList.add('red');

            fields[0].classList.add('red');
            // fieldTexts[0].classList.add('red');
            fieldTexts[0].innerText = '姓名至少要兩個字元';

            isPass = false;
        }

        // 測試訊息方塊時要註解掉
        if (email_field.value && !email_re.test(email_field.value)) {
            // alert('email 格式錯誤');

            fields[1].classList.add('red');
            // fieldTexts[1].classList.add('red');
            fieldTexts[1].innerText = 'email 格式錯誤';

            isPass = false;
        }

        if (mobile_field.value && !mobile_re.test(mobile_field.value)) {
            // alert('手機號碼格式錯誤');

            fields[2].classList.add('red');
            // fieldTexts[2].classList.add('red');
            fieldTexts[2].innerText = '手機號碼格式錯誤';

            isPass = false;
        }

        if (!isPass) {
            return; // 結束函式
        }

        const fd = new FormData(document.formEdit);
        const r = await fetch('address_book-edit-api.php', {
            method: 'POST',
            body: fd
        });
        const result = await r.json();
        // 取得的訊息會印在 console 中
        console.log(result);

        info_bar.style.display = 'block'; // 顯示訊息列
        if (result.success) {
            info_bar.classList.remove('alert-danger');
            info_bar.classList.add('alert-success');
            info_bar.innerText = '資料修改成功';

            // 跳轉回列表頁
            setTimeout(()=>{
                location.href = 'address_book-list.php'; 
            }, 2000);
        } else {
            info_bar.classList.remove('alert-success');
            info_bar.classList.add('alert-danger');
            info_bar.innerText = result.error || '資料無法修改';
        }
    }
</script>
<?php include __DIR__ . '/parts/html-foot.php' ?>