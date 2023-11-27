<?php

namespace Ahmet\Dia\RequestHandler;

use GuzzleException;
use GuzzleHttp\Client;

class RequestHandler
{
    private $client;
    private $url;
    private $companyCode;
    private $module;

    /**
     * Constructor for the class.
     *
     * @param string $companyCode The code of the company (default: 'diademo')
     * @param string $module The name of the module eg. 'sis'
     * @return void
     */
    public function __construct($module,$companyCode = 'diademo')
    {
        $this->module = $module;
        $this->companyCode = $companyCode;
        $this->setUrl($this->module);
        $this->client = new Client([
            'base_uri' => $this->url,
            'timeout' => 10.0,
            'verify' => false
        ]);
    }


    /**
     * A description of the post function.
     *
     * @param array $data The data to be sent in the request.
     * @return mixed The response from the request.
     * @throws GuzzleException If an error occurs during the request.
     */
    public function post($data)
    {
        try {
            $response = $this->client->request('POST',$this->url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'json' => $data
            ]);
            return $response;
        } catch (GuzzleException $e) {
            throw $e;
        }
    }

    /**
     * Retrieves data using a GET request.
     *
     * @param mixed $data The data to include in the query string.
     * @return mixed The response from the GET request.
     * @throws GuzzleException If an error occurs during the request.
     */
    public function get($data)
    {
        try {
            $response = $this->client->request('GET', '', [
                'query' => $data
            ]);
            return $response;
        } catch (GuzzleException $e) {
            throw $e;
        }
    }


    /**
     * Sets the URL for the API based on the company code.
     *
     * @param string $companyCode The code of the company.
     * @return string The generated URL.
     */
    public function setUrl($module,$companyCode='diademo')
    {
        $this->url= "https://" . $companyCode . ".ws.dia.com.tr/api/v3/" . $module . "/json";
    }


}