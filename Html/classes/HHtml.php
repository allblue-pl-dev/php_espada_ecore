<?php namespace EC\Html;
defined('_ESPADA') or die(NO_ACCESS);

use E, EC;

class HHtml
{

    static public function Img($src, $alt)
    {
        return "<img src=\"{$src}\" alt=\"{$alt}\" />";
    }

}
