<?php 

if (!isset($pdo)) {
    require __DIR__ . '/parts/database_connect_by_pdo.php';
}

function getTagTree($pdo) {
    $sql = 
    "SELECT * 
    FROM `categories` 
    ORDER BY `parent_sid`, `sid`";
    
    $rows = $pdo->query($sql)->fetchAll();
    
    $dict = [];
    
    foreach ($rows as $k => $v) {
        $dict[$v['sid']] = &$rows[$k];
    }
    
    $tagTree = [];

    foreach ($dict as $sid => $item) {
        if ($item['parent_sid'] != 0) {
            $dict[$item['parent_sid']]['children'][] = &$dict[$sid];
        } else {
            $tagTree[] = &$dict[$sid];
        }
    }
    return $tagTree;
}

$tag_cates = getTagTree($pdo);
echo json_encode($tag_cates, JSON_UNESCAPED_UNICODE);