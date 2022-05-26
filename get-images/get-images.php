<?php

$birdGallery = [
    "https://cdn.pixabay.com/photo/2018/08/12/16/59/parrot-3601194_960_720.jpg",
    "https://cdn.pixabay.com/photo/2017/05/08/13/15/bird-2295436_960_720.jpg",
    "https://cdn.pixabay.com/photo/2017/02/18/13/55/swan-2077219_960_720.jpg",
    "https://cdn.pixabay.com/photo/2017/07/18/18/24/dove-2516641_960_720.jpg",
    "https://cdn.pixabay.com/photo/2017/05/08/13/15/bird-2295431_960_720.jpg",
    "https://cdn.pixabay.com/photo/2016/08/07/16/45/owl-1576572_960_720.jpg",
    "https://cdn.pixabay.com/photo/2017/02/07/16/47/kingfisher-2046453_960_720.jpg",
    "https://cdn.pixabay.com/photo/2011/09/27/18/52/bird-9950_960_720.jpg",
    "https://cdn.pixabay.com/photo/2015/11/16/16/28/bird-1045954_960_720.jpg"
];

foreach ($birdGallery as $url) {
    $fileName = './images/'. basename($url);

    if(!file_put_contents($fileName, file_get_contents($url))){
        // 權限不夠無法存入檔案時才會顯示出來
        echo basename($url) . PHP_EOL;
    };
}
echo 'Clear!';