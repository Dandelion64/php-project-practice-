<?php

$output = [
    'postData' => $_POST,
];

$json = json_encode($output, JSON_UNESCAPED_UNICODE);

file_put_contents('./hobbiesList.json', $json); // JSON 字串存成檔案

echo $json;

?>