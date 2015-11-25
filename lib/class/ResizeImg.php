<?php
namespace Resize;
use PHPImageWorkshop\ImageWorkshop;

class ResizeImg {

    private $image;
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
        $this->setImage($imageFile);
    }

    private function setImage($imageFile)
    {
        $this->workshopLib = ImageWorkshop::initFromPath($imageFile);
        $this->width = $this->workshopLib->getWidth();
        $this->height = $this->workshopLib->getHeight();
        $this->image = $this->workshopLib->getImage();

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
     * @param integer $newWidth - choose new Width in pixels
     * @param integer $newHeight - choose new Height in pixels
     * @param integer $positionX
     * @param integer $positionY
     * @param string $position - string LB means Left - Bottom position
     */
    public function cropImage($newWidth, $newHeight, $positionX, $positionY, $position = 'LB')
    {
        $imgcrop = ImageWorkshop::initFromResourceVar($this->image);
        $imgcrop->cropInPixel($newWidth, $newHeight, $positionX, $positionY, $position );

    }


    /**
     * Calculate width and height keeping the aspect ratio
     *
     * @param  integer $newWidth - Max image width
     *
     * @return integer $newHeight
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
     * @return integer $newWidth keeping aspect ratio
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
     * @param  String $savePath - folder to save image
     * @param  String $imgname - name for new image
     * @param  string $quality - The quality level of image to create
     *
     */
    public function saveImage( $savePath, $imgname, $quality = '100' )
    {
        $imgsave = ImageWorkshop::initFromResourceVar($this->imageResize);
        $imgsave->save( $savePath, $imgname, $quality );
    }

}
