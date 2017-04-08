<?php namespace EC\LemonBee;
defined('_ESPADA') or die(NO_ACCESS);

use E, EC;

class LUserInfo extends E\Layout
{

    public function __construct(SLemonBee $site)
    {
        parent::__construct('LemonBee:userInfo');

        // $site->m->spk->addScript('LemonBee:UserInfo');

        $this->setFields([
            'uris' => [
                'userInfo' => $site->lbGetUri('userInfo'),
                'logOut' => $site->lbGetUri('logOut')
            ],
            'login' => $site->lbGetUserName()
        ]);
    }

}
