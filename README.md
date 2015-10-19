# resizing-library-risto987 

### How to use this library###

Resize image with exact width and height:
- $img = new ResizeImg('path/to/image.jpg');
- $img->exactResize(integer,integer);
- $img->saveImage('path/to/store/image.jpg');


Auto resize image:
- $img = new ResizeImg('path/to/image.jpg');
- $img->autoResize(integer,integer);
- $img->saveImage('path/to/store/image.jpg');
