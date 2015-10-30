<?php
require "vendor/autoload.php";

$img = new \Resize\ResizeImg('lib/img/banner.jpg');
var_dump($img);

//$img->exactResize(200,200);
//$img->saveImage('img/banner-resize.jpg');


//$img = new ResizeImg('img/banner.jpg');
//$img->autoResize(200,200);
//$img->saveImage('img/new_auto-resize.gif');

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



