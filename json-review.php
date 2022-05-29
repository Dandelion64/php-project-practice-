<?php

$ar = array(
'name' => '彼德潘 / peter',
'age' => 30,
'other'=> array(56, 'aaa', 72)
);

echo json_encode($ar, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
echo json_encode($ar, JSON_UNESCAPED_UNICODE+JSON_UNESCAPED_SLASHES);

$str = '{"name":"peter"}';
$br = json_decode($str);
var_dump($br);
echo $br->name;
$cr = json_decode($str, true);
echo $cr['name'];

?>