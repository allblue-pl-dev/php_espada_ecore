<?php namespace EC\Images;
defined('_ESPADA') or die(NO_ACCESS);

use E, EC;

class HImages
{

    static public function Create($file_path)
    {
        $mime = getimagesize($file_path)['mime'];

        if ($mime === 'image/jpeg')
            return imagecreatefromjpeg($file_path);
        if ($mime === 'image/gif')
            return imagecreatefromgif($file_path);
        if ($mime === 'image/png')
            return imagecreatefrompng($file_path);

        return null;
    }

    static public function Scale_ToMinSize($file_path, $dest_file_path,
            $min_width, $min_height, $quality = 75)
    {
        $memory_limit = ini_get('memory_limit');
        ini_set('memory_limit', '128M');

        $image = self::Create($file_path);

        $image_width = imagesx($image);
        $image_height = imagesy($image);

        if ($image_width < $min_width || $image_height < $min_height)
            return copy($file_path, $dest_file_path);

        $width_factor = $min_width / $image_width;
        $height_factor = $min_height / $image_height;
        $factor = max($width_factor, $height_factor);

        $scaled_image = imagescale($image, $factor * $image_width,
                $factor * $image_height);
        imagedestroy($image);

        $result = imagejpeg($scaled_image, $dest_file_path, $quality);

        imagedestroy($scaled_image);

        ini_set('memory_limit', $memory_limit);

        return $result;
    }

}
