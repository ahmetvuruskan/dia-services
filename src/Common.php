<?php

namespace Ahmet\Dia;

use Ahmet\Dia\RequestHandler\RequestHandler;
use GuzzleHttp\Exception\GuzzleException;

class Common
{
    static $username = 'ws';
    static $password = 'ws';
    static $disconnect_same_user = false;
    protected $companyCode = 'diademo';
     static $module='sis';
    public $requestHandler;
    public $sessionKey;
    public $firmCode;
    public $term;


    /**
     * Constructor for the class.
     *
     * @return void
     */
    public function __construct()
    {
        $this->requestHandler = new RequestHandler(self::$module, $this->companyCode);
        $this->login(self::$username, self::$password, self::$disconnect_same_user);
    }


    /**
     * Logs in a user with the provided username and password.
     *
     * @param string $username The username of the user.
     * @param string $password The password of the user.
     * @param bool $disconnect_same_user Whether to disconnect the same user if already logged in.
     * @return void
     * @throws Some_Exception_Class A description of the exception that can be thrown.
     */
    private function login($username, $password, $disconnect_same_user)
    {
        $data = [
            'login' => [
                'username' => $username,
                'password' => $password,
                'disconnect_same_user' => $disconnect_same_user,
                'lang' => 'tr',
                'params' => ['apikey' => '']
            ]
        ];
        $response = $this->requestHandler->post($data);
        $credentials = $response->getBody()->getContents();
        if ($response->getStatusCode() == 200) {
            $credentials = json_decode($credentials);
            $this->sessionKey = $credentials->msg;
            $this->getCompanyDetails();
        }
    }

    private function getCompanyDetails()
    {
        $data = [
            'sis_yetkili_firma_donem_sube_depo' => [
                'session_id' => $this->sessionKey
            ]
        ];
        $response = $this->requestHandler->post($data);
        $credentials = $response->getBody()->getContents();
        echo "<pre>";
        if ($response->getStatusCode() == 200) {
            $credentials = json_decode($credentials);
            $result = $credentials->result[0];
            $this->firmCode = $result->firmakodu;
            $this->term = end($result->donemler)->donemkodu;
        }
    }


    /**
     * Logout the user.
     *
     * @throws Some_Exception_Class if the logout request fails
     */
    private function logout()
    {
        if ($this->sessionKey) {
            $data = [
                'logout' => [
                    'session_id' => $this->sessionKey
                ]
            ];
            $this->requestHandler->post($data);
        }

    }
}