<?php
namespace Ahmet\Dia\Ote\FrontOffice;

use Ahmet\Dia\Common;
use Ahmet\Dia\Ote\Ote;

class Reservations extends Ote{

    public function __construct()
    {
        parent::__construct();
    }

    public function getReservations(){
        $data = [
            'ote_rezervasyonkarti_listele' => [
                'session_id' => $this->sessionKey,
                'firma_kodu' => $this->firmCode,
                'donem_kodu' => $this->term,
                'filters'=>"",
                'sorts'=>"",
                'params'=>"",
                "limit" => 10,
                "offset" => 0
            ]
        ];
        return $this->requestHandler->post($data);
    }
}