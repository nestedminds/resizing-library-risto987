<?php
require 'class/ResizeImg.php';
$img = new ResizeImg('img/banner.jpg');
$img->exactResize(200,200);
$img->saveImage('img/banner-resize.jpg');
print_r($img);
?>
<!doctype html>
<html>
<head>
    <title>Resize-Images</title>
</head>
<body>

</body>
</html>


