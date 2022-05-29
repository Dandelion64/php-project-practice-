<?php require __DIR__ . '/parts/database_connect_by_pdo.php';
$pageName = 'address_book-add';
$title = '新增通訊錄 - 丹德里恩的練習';
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

    /* #info-bar {
        margin-top: 20px;
    } */
</style>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">新增資料</h5>
                    <form name="formAdd" onsubmit="sendData();return false;" novalidate>
                        <div class="mb-3">
                            <label for="name" class="form-label">name *</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                            <div class="form-text red"></div>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">email</label>
                            <input type="text" class="form-control" id="email" name="email">
                            <div class="form-text red"></div>
                        </div>
                        <div class="mb-3">
                            <label for="mobile" class="form-label">mobile</label>
                            <input type="text" class="form-control" id="mobile" name="mobile">
                            <div class="form-text red"></div>
                        </div>
                        <div class="mb-3">
                            <label for="birthday" class="form-label">birthday</label>
                            <input type="date" class="form-control" id="birthday" name="birthday">
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">address</label>
                            <textarea class="form-control" name="address" id="address" cols="30" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">新增</button>
                    </form>
                    <!-- Bootstrap Components Alert -->
                    <!-- 加上 inline style -->
                    <!-- display none -->
                    <!-- <div id="info-bar" class="alert alert-success" role="alert" style="display:none;"></div> -->

                    <!-- 嘗試改為 Modal -->
                    <!-- Bootstrap Components Modal -->
                    <!-- 要在訊息回來才跳出來 -->
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                        Launch static backdrop modal
                    </button>

                    <!-- Modal -->
                    <div id="myModal" class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel"></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body"></div>
                                <div class="modal-footer">
                                    <button id="modal-uncheck" type="button" class="btn btn-secondary" data-bs-dismiss="modal"></button>
                                    <button id="modal-check" type="button" class="btn btn-primary"></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include __DIR__ . '/parts/scripts.php' ?>
<script>
    // 檢查用的 pattern
    // Ref: https://stackoverflow.com/questions/46155/how-can-i-validate-an-email-address-in-javascript
    const email_re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zAZ]{2,}))$/;
    const mobile_re = /^09\d{2}-?\d{3}-?\d{3}$/;

    // 取得欄位 (field) 參照 
    const name_field = document.formAdd.name;
    const email_field = document.formAdd.email;
    const mobile_field = document.formAdd.mobile;

    // const info_bar = document.querySelector('#info-bar');

    const modalTitle = document.querySelector('.modal-title');
    const modalBody = document.querySelector('.modal-body');
    const modalUncheck = document.querySelector('#modal-uncheck');
    const modalCheck = document.querySelector('#modal-check');

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
        // info_bar.style.display = 'none'; // 隱藏訊息列

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
        // if (email_field.value && !email_re.test(email_field.value)) {
        //     // alert('email 格式錯誤');

        //     fields[1].classList.add('red');
        //     // fieldTexts[1].classList.add('red');
        //     fieldTexts[1].innerText = 'email 格式錯誤';

        //     isPass = false;
        // }

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

        const fd = new FormData(document.formAdd);
        const r = await fetch('address_book-add-api.php', {
            method: 'post',
            body: fd
        });
        const result = await r.json();
        // 取得的訊息會印在 console 中
        console.log(result);

        // info_bar.style.display = 'block'; // 顯示訊息列
        // if (result.success) {
        //     info_bar.classList.remove('alert-danger');
        //     info_bar.classList.add('alert-success');
        //     info_bar.innerText = '資料新增成功';

        //     // 跳轉回列表頁
        //     setTimeout(() => {
        //         location.href = 'address_book-list.php';
        //     }, 2000);
        // } else {
        //     info_bar.classList.remove('alert-success');
        //     info_bar.classList.add('alert-danger');
        //     info_bar.innerText = result.error || '資料無法新增';
        // }

        // Modal 部分
        const myModal = new bootstrap.Modal(document.querySelector('#myModal'), {
            keyboard: false
        });
            
        if (result.success) {
            modalTitle.innerHTML = `您的資料新增成功`;
            modalBody.innerHTML = `這份資料填寫詳盡，已經新增進通訊錄囉。`;
            modalUncheck.innerHTML = `我不想走`;
            modalCheck.innerHTML = `我要走了`;
            myModal.show();
            modalCheck.addEventListener("click", 
                refresh = (event) => {
                    location.href = 'address_book-list.php';
            });
            modalCheck.removeEventListener("click", 
                refresh = (event) => {
                    location.href = 'address_book-list.php';
            });
        } else {
            modalTitle.innerHTML = `您的資料格式有誤`;
            modalBody.innerHTML = `這筆資料 Email 格式不對，請您修正。`;
            modalUncheck.innerHTML = `我會改進`;
            modalCheck.innerHTML = `我想硬闖`;
            myModal.show();
        }

        // const nunu = () => {
        //     myModal.hide()
        // }
    
        // setTimeout(nunu, 2000);
    }

</script>
<?php include __DIR__ . '/parts/html-foot.php' ?>