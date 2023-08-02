<?php
class Thumb_generator{
    public $existing_image;
    public $i_w;
    public $i_h;
    public $_if;

    public $extension;
    public $height;
    public $width;
    public $thumb_create;
    public $thumbnail;
    public $source;
    public $factor;


    public function __construct($existing_image,$thumbnail,$i_w){
        $this->i_w = $i_w;
        $this->thumbnail = $thumbnail;
        $this->existing_image = $existing_image;
        list($this->width,$this->height) = getimagesize($this->existing_image);
        $this->extension=$this->getExtension();
        $this->calculateHeight();
        $this->create_thumb();
    }
    public function getExtension(){
        $this->_if          = pathinfo($this->existing_image);
        return $this->_if['extension'];
    }
    public function calculateHeight(){
        $this->factor = $this->width / $this->i_w;
        $this->i_h    = $this->height / $this->factor;
    }

    // public function thumb($existing_image='', $thumbnail='',$i_w,$i_h,$extension){
    public function create_thumb(){
        $this->thumb_create = imagecreatetruecolor($this->i_w,$this->i_h);
        switch($this->extension){
            case 'jpg':
                $this->source = imagecreatefromjpeg($this->existing_image);
                break;
            case 'jpeg':
                $this->source = imagecreatefromjpeg($this->existing_image);
                break;
            case 'JPG':
                $this->source = imagecreatefromjpeg($this->existing_image);
                break;
            case 'JPEG':
                $this->source = imagecreatefromjpeg($this->existing_image);
                break;
            case 'png':
                $this->source = imagecreatefrompng($this->existing_image);
                break;
            case 'gif':
                $this->source = imagecreatefromgif($this->existing_image);
                break;
            case 'PNG':
                $this->source = imagecreatefrompng($this->existing_image);
                break;
            case 'GIF':
                $this->source = imagecreatefromgif($this->existing_image);
                break;
            default:
                echo 'Failed to create thumbnail!';
                return false;
        }
        imagecopyresampled($this->thumb_create, $this->source, 0, 0, 0, 0, $this->i_w, $this->i_h, $this->width, $this->height);
        switch($this->extension){
            case 'png':
                imagepng($this->thumb_create,$this->thumbnail,9); // 100 represents image quality
                break;
            case 'gif':
                imagegif($this->thumb_create,$this->thumbnail,100);
                break;
            default:
                imagejpeg($this->thumb_create,$this->thumbnail,100);
        }
        return $this->thumbnail;
    }
}
