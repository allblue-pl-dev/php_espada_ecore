<?php namespace EC\Basic;
defined('_ESPADA') or die(NO_ACCESS);

use E, EC;

class SBasic extends E\Site
{

    public function __construct()
    {
        parent::__construct();

        $this->addM('header', new \EC\Basic\MHeader());
    }

    protected function _initialize()
    {
        parent::_initialize();

        if (EDEBUG)
            $this->addL('debug', E\Notice::GetL());
    }

}
