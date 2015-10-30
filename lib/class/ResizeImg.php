<?php
namespace Resize;

class ResizeImg {

    private $image;
    private $type;
    private $width;
    private $height;
    private $resizeWidth;
    private $resizeHeight;
    private $imageResize;
    private $workshopLib;


    /**
     * Set the image witch you want to resize
     *
     * @param  $imageFile     - path to specific image
     */
    function __construct($imageFile)
    {

        $this->setImage($imageFile); //method to check and return jpg/gif/png
        $this->width = imagesx($this->image);
        $this->height = imagesy($this->image);
    }

    private function setImage($imageFile)
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
     * @param  integer $newWidth
     * @param  integer $newHeight
     *
     */
    public function exactResize($newWidth, $newHeight)
    {
        $this->resizeWidth = $newWidth;
        $this->resizeHeight = $newHeight;

        $this->copy_and_resize();

    }


    /**
     * Auto resize image according to its aspect ratio
     *
     * @param  integer $newWidth
     * @param  integer $newHeight
     *
     */
    public function autoResize($newWidth, $newHeight)
    {
        if($this->width > $this->height){

            //landscape
            $this->resizeWidth = $newWidth;
            $this->resizeHeight = $this->calculateHeight($newWidth);

        }elseif($this->width < $this->height){

            //portrait
            $this->resizeWidth = $this->calculateWidth($newHeight);
            $this->resizeHeight = $newHeight;

        }else{

            //exact
            $this->resizeWidth = $newWidth;
            $this->resizeHeight = $newHeight;

        }

        $this->copy_and_resize();
    }


    /**
     * Function for implementing a CROP method from Workshop-Image Library
     *
     */
    public function cropImage($newWidth, $newHeight, $positionX, $positionY, $position)
    {
        // not working
        $this->workshopLib = new \PHPImageWorkshop\ImageWorkshop();
         cropInPixel($newWidth, $newHeight, $positionX, $positionY, $position);

    }


    /**
     * Calculate width and height keeping the aspect ratio
     *
     * @param  integer $newWidth - Max image width
     *
     * @return newHeight
     */
    private function calculateHeight($newWidth)
    {
        $ratio = $this->height / $this->width;
        $newHeight = $newWidth * $ratio;
        return $newHeight;
    }



    /**
     * Calculate width keeping the aspect ratio
     *
     * @param  integer $newHeight - Max image height
     *
     * @return newWidth keeping aspect ratio
     */
    private function calculateWidth($newHeight)
    {
        $ratio = $this->width / $this->height;
        $newWidth = $newHeight * $ratio;
        return $newWidth;
    }


    /**
     * GD Library functions to copy and resize image
     *
     */
    private function copy_and_resize()
    {
        $this->imageResize = imagecreatetruecolor($this->resizeWidth, $this->resizeHeight);
        imagecopyresampled($this->imageResize, $this->image, 0, 0, 0, 0, $this->resizeWidth, $this->resizeHeight,
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
