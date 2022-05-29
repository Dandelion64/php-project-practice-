<?php // 資料庫連線 
?>
<?php require __DIR__ . '/parts/database_connect_by_pdo.php';
$pageName = 'address_book-list';
$title = '通訊錄 - 丹德里恩的練習';

$perPage = 20;

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
    header('Location: ?page=1');
    exit;
}

$t_sql = "SELECT COUNT(*) FROM address_book";
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];

$totalPages = ceil($totalRows / $perPage);

$rows = [];

if ($totalRows > 0) {
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
                    <?php
                    $beginPage;
                    $endPage;
                    $pagesOptional = 3;
                    if ($totalPages <= $pagesOptional) {
                        $beginPage = 1;
                        $endPage = $totalPages;
                    } else if ($page - 1 < $pagesOptional) {
                        $beginPage = 1;
                        $endPage = $pagesOptional * 2 + 1;
                    } else if ($totalPages - $page < $pagesOptional) {
                        $beginPage = $totalPages - ($pagesOptional * 2);
                        $endPage = $totalPages;
                    } else {
                        $beginPage = $page - $pagesOptional;
                        $endPage = $page + $pagesOptional;
                    }
                    ?>
                    <?php for ($i = $beginPage; $i <= $endPage; $i++) :
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
                <th scope="col">
                    <?php 
                    // 先怪怪的沒關係
                    // 這裡是要練習 checkbox
                    ?>
                    <a href="javascript: deleteRow(<?= $r['sid'] ?>);" style="text-decoration: none;">
                        <input type="checkbox" class="form-check-input" value="" id="deleteTableHead" onchange="checkAll(event)">
                        <label for="deleteTableHead" class="form-check-label" style="display: none;">
                    </a>
                </th>
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
                    <td>
                        <a href="javascript: deleteRow(<?= $r['sid'] ?>);" style="text-decoration: none;">
                            <input class="form-check-input checktarget" type="checkbox" value="" id="deleteTableBody-<?= $r['sid'] ?>">
                            <label class="form-check-label" for="deleteTableBody-<?= $r['sid'] ?>" style="display: none;">
                        </a>
                    </td>
                    <td><?= $r['sid'] ?></td>
                    <td><?= $r['name'] ?></td>
                    <td><?= $r['mobile'] ?></td>
                    <td><?= $r['email'] ?></td>
                    <td><?= $r['birthday'] ?></td>
                    <td><?= htmlentities($r['address']) ?></td>
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
    const checkTarget = document.querySelectorAll('.checktarget');

    const checkAll = (e) => {
        if (e.target.checked === true) {
            for (let row of checkTarget) {
                row.setAttribute('checked', 'checked');
            }
        } else {
            for (let row of checkTarget) {
                row.removeAttribute('checked');
            }
        }
    }

    const deleteRow = (sid) => {
        if (confirm(`確定要刪除編號為 ${sid} 的這筆資料嗎？`)) {
            location.href = `address_book-delete.php?sid=${sid}`;
        }
    }
</script>
<?php include __DIR__ . '/parts/html-foot.php' ?>