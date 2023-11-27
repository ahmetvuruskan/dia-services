<?php

namespace Ahmet\Dia\Ote;

use Ahmet\Dia\Common;
use Ahmet\Dia\Ote\FrontOffice;
use Ahmet\Dia\RequestHandler\RequestHandler;

class Ote
{
    private static $module = 'ote';
    protected $sessionKey;
    protected $client;
    protected $firmCode;
    protected $term;

    public function __construct()
    {
        $common = new Common();
        $this->client = new RequestHandler(self::$module);
        $this->sessionKey = $common->sessionKey;
        $this->firmCode = $common->firmCode;
        $this->term = $common->term;
    }

}