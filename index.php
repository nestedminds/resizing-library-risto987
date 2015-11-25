<?php
require "vendor/autoload.php";

$img = new \Resize\ResizeImg('lib/img/banner.jpg');

$img->exactResize(600,200);
$img->saveImage('lib/img', 'banner-exact-resize.jpg', 60);

$img->autoResize(300,200);
$img->saveImage('lib/img', 'banner-auto-resize.jpg', 60);

$img->cropImage(150,150,0,0);
$img->saveImage('lib/img', 'banner-crop.jpg', 60);


var_dump($img);
//print_r($img);
?>
<!doctype html>
<html>
<head>
    <title>Resize-Images</title>
</head>
<body>

</body>
</html>



