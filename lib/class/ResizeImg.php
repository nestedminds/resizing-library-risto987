<?php

class ResizeImg {

    private $image;
    private $type;
    private $width;
    private $height;
    private $resizeWith;
    private $resizeHeight;
    private $imageResize;

    /**
     * Specific type of image and original with and height
     *
     * @param  $imageFile     - path to specific image
     */
    function __construct($imageFile)
    {
        $this->getImage($imageFile); //method to check and return jpg/gif/png
        $this->width = imagesx($this->image);
        $this->height = imagesy($this->image);
    }

    private function getImage($imageFile)
    {
        // check the image type and get it with GD Library function
        $size = getimagesize($imageFile);
        $this->type = $size['mime'];

         switch($this->type) {

             case 'image/jpg':
             case 'image/jpeg':
                 // jpg extension
                 $this->image = imagecreatefromjpeg($imageFile);
                 break;

             case 'image/gif':
                 //for gif extension
                 $this->image = imagecreatefromgif($imageFile);
                 break;

             case 'image/png':
                 //for png extension
                 $this->image = imagecreatefrompng($imageFile);
                 break;

             default:
                 throw new Exception('The file in not an image, tray another file type. ');
                 break;
         }

    }

    /**
     * Resizing to exact with and height using GD Library
     *
     * @param  integer $newWith
     * @param  integer $newHeight
     *
     */
    public function exactResize($newWith, $newHeight)
    {
        $this->resizeWith = $newWith;
        $this->resizeHeight = $newHeight;

        $this->imageResize = imagecreatetruecolor($this->resizeWith, $this->resizeHeight);
        imagecopyresampled($this->imageResize, $this->image, 0, 0, 0, 0, $this->resizeWith, $this->resizeHeight,
            $this->width,
            $this->height);

    }

    /**
     * Saving image to specific path
     *
     * @param  String $savePath
     * @param  string $quality - The quality level of image to create
     *
     */
    public function saveImage($savePath, $quality = '100')
    {
        switch($this->type){

            case 'image/jpg':
            case 'image/jpeg':

                if(imagetypes() & IMG_JPG){
                    imagejpeg($this->imageResize, $savePath, $quality);
                }
                break;

            case 'image/gif':

                if(imagetypes() & IMG_GIF){
                    imagegif($this->imageResize, $savePath, $quality);
                }
                break;

            case 'image/png':

                $pngScaleQuality = 9 - round(($quality/100) * 9);
                if (imagetypes() & IMG_PNG){
                    imagepng($this->imageResize, $savePath, $pngScaleQuality);
                }
                break;
        }
        imagedestroy($this->imageResize);
    }

}
