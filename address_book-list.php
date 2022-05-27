<?php // 資料庫連線 
?>
<?php require __DIR__ . '/parts/database_connect_by_pdo.php';
$pageName = 'address_book-list';
$title = '通訊錄 - 丹德里恩的練習';

$perPage = 20; // 每一頁有幾筆

// 用戶要看第幾頁
// 將取得的 query string parameter 轉換成數字
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
    header('Location: ?page=1');
    exit;
}

// 總共有幾筆資料
$t_sql = "SELECT COUNT(*) FROM address_book";
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];

// 除錯時先看有幾筆資料用
// echo $totalRows;
// exit;

// 總共有幾頁
$totalPages = ceil($totalRows / $perPage);

// 給預設值避免沒跑迴圈或資料為空 $rows 變成 undefined
$rows = [];

if ($totalRows > 0) {
    // 頁碼若超過總頁數
    if ($page > $totalPages) {
        header("Location: ?page=$totalPages");
        exit;
    }

    $sql = sprintf("SELECT * FROM address_book ORDER BY sid DESC LIMIT %s, %s", ($page - 1) * $perPage, $perPage);
    $rows = $pdo->query($sql)->fetchAll();
}

?>

<?php // HTML 部分 
?>
<?php include __DIR__ . '/parts/html-head.php' ?>
<?php include __DIR__ . '/parts/navbar.php' ?>

<div class="container">
    <div class="row">
        <div class="col">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=1">
                            <i class="fa-solid fa-angles-left"></i>
                        </a>
                    </li>
                    <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page - 1 ?>">
                            <i class="fa-solid fa-angle-left"></i>
                        </a>
                    </li>
                    <?php for ($i = $page - 5; $i <= $page + 5; $i++) :
                        if ($i >= 1 and $i <= $totalPages) :
                    ?>
                    <li class="page-item <?= $page == $i ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                    <?php endif;
                    endfor; ?>
                    <li class="page-item <?= $page == $totalPages ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page + 1 ?>">
                            <i class="fa-solid fa-angle-right"></i>
                        </a>
                    </li>
                    <li class="page-item <?= $page == $totalPages ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $totalPages ?>">
                            <i class="fa-solid fa-angles-right"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>

<div class="container">
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col"><i class="fa-solid fa-trash-can"></i></th>
                <th scope="col">#</th>
                <th scope="col">姓名</th>
                <th scope="col">手機</th>
                <th scope="col">電郵</th>
                <th scope="col">生日</th>
                <th scope="col">地址</th>
                <th scope="col"><i class="fa-solid fa-pen-to-square"></i></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $r) : ?>
                <tr>
                    <!-- 一般盡量不刪資料 因為資料難得-->
                    <!-- 可以在資料庫中新增一個欄位 -->
                    <!-- 如果是 true 就視為資料刪除不顯示 -->
                    <!-- 也就是所謂假刪除 -->
                    <td>
                        <?php /*
                        <a href="address_book-delete.php?sid=<?= $r['sid'] ?>" onclick="return confirm('確定要刪除編號為 <?= $r['sid'] ?> 的這筆資料嗎？');">
                            <i class="fa-solid fa-trash-can text-primary"></i>
                        */ ?>

                        <a href="javascript: deleteRow(<?= $r['sid'] ?>);">
                            <i class="fa-solid fa-trash-can text-primary"></i>
                        </a>
                    </td>
                    <td><?= $r['sid'] ?></td>
                    <td><?= $r['name'] ?></td>
                    <td><?= $r['mobile'] ?></td>
                    <td><?= $r['email'] ?></td>
                    <td><?= $r['birthday'] ?></td>
                    <td><?= htmlentities($r['address']) ?></td>
                    <?php 
                    /*
                    <td><?= strip_tags($r['address']) ?></td>
                    */ 
                    ?>
                    <td>
                        <a href="address_book-edit.php?sid=<?= $r['sid'] ?>">
                            <i class="fa-solid fa-pen-to-square text-primary"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>

    </table>


</div>

<?php include __DIR__ . '/parts/scripts.php' ?>
<script>
    const deleteRow = (sid) => {
        if (confirm(`確定要刪除編號為 ${sid} 的這筆資料嗎？`)) {
            location.href = `address_book-delete.php?sid=${sid}`;
        }
    }
</script>
<?php include __DIR__ . '/parts/html-foot.php' ?>