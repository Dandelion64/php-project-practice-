<?php
require __DIR__ . '/parts/database_connect_by_pdo.php';
// 效率比 dirname(__FILE__) 好

$pageName = 'products';
$perPage = 6; // 每頁資料筆數
$title = '產品介紹 - 丹德里恩的練習';
// $params = [];

// 用戶要看的頁數
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
    header('Location: products.php');
    exit;
}

$cate = isset($_GET['cate']) ? intval($_GET['cate']) : 0;
if(isset($_GET['cate'])){
    $params['cate'] = $cate;
}

// 取得分類資料
// stmt for PDO::statement
$c_sql = "SELECT * FROM categories WHERE parent_sid=0";
$c_stmt = $pdo->query($c_sql);
$cates = $c_stmt->fetchAll(PDO::FETCH_ASSOC);

$where = ' WHERE 1 ';
if(! empty($cate)){
    $where .= " AND category_sid=$cate ";
}

// 總資料數
$t_sql = "SELECT COUNT(*) FROM products $where";
// 因為 count(*) 只會有一筆 取成索引式陣列用索引取值
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];

// 總頁數
$totalPages = ceil($totalRows / $perPage);

// 避免資料庫中完全沒有資料時會出錯
$rows = [];

if ($totalRows>0) {
    // 頁碼超過總頁數時跳脫
    if ($page > $totalPages) {
        header("Location: ?page=$totalPages");
        exit;
    }

    $p_sql = sprintf("SELECT * FROM products $where ORDER BY sid ASC LIMIT %s, %s", ($page - 1) * $perPage, $perPage);
    $p_stmt = $pdo->query($p_sql);
    $rows = $p_stmt->fetchAll();
}

// echo json_encode($rows);

?>

<?php include __DIR__ . '/parts/html-head.php' ?>
<?php include __DIR__ . '/parts/navbar.php' ?>

<style type="text/css">
    td i.fa-trash-can {
        cursor: pointer;
    }
</style>

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
                    <?php for ($i = $page - 2; $i <= $page + 2; $i++) :
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
                <th scope="col">書名</th>
                <th scope="col">出版日期</th>
                <th scope="col">ISBN</th>
                <th scope="col">價格</th>
                <th scope="col"><i class="fa-solid fa-pen-to-square"></i></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $r) : ?>
                <tr>
                    <td><a href="javascript:" onclick=removeRow(event); return false;><i class="fa-solid fa-trash-can text-primary"></i></a></td>
                    <td><?= $r['sid'] ?></td>
                    <td><?= $r['bookname'] ?></td>
                    <td><?= $r['publish_date'] ?></td>
                    <td><?= $r['isbn'] ?></td>
                    <td><?= $r['price'] ?></td>
                    <td><i class="fa-solid fa-pen-to-square text-primary"></i></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include __DIR__ . '/parts/scripts.php' ?>

<script>
    const removeRow = (event) => {
        const deleteNode = event.currentTarget.closest('tr');
        deleteNode.remove();
    }
</script>

<?php include __DIR__ . '/parts/html-foot.php' ?>