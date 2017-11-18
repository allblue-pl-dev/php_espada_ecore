<?php namespace EC\Images;
defined('_ESPADA') or die(NO_ACCESS);

use E, EC;

class CCanvas
{

    private $image = null;

    public function __construct($image)
    {
        $this->image = $image;
    }

    public function image($file_path, $coords)
    {
        $t_image = HImages::Create($file_path);
        if ($t_image === null)
            throw new \Exception('Cannot create image.');
        [ $t_width, $t_height ] = getimagesize($file_path);

        imagecopy($this->image, $t_image, $coords[0], $coords[1], 0, 0,
                $t_width, $t_height);

        return $this;
    }

    public function text($text, $font_path, $font_size, $color, array $coords)
    {
        imagettftext($this->image, $font_size, 0,
                $coords[0], $coords[1] + $font_size,
                $color, $font_path, $text);

        return $this;
    }

}
