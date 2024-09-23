<?php
namespace App\Repositories;

use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class ObatRepository implements ObatRepositoryInterface
{
    private $url;
    private $email;
    private $password;
    private $accessToken;

    public function __construct()
    {
        $this->url = "http://recruitment.rsdeltasurya.com/api/v1/";
        $this->email = "percival5695@gmail.com";
        $this->password = "085850261700";
    }

    public function authenticate()
    {
        $http_options = [
            'base_uri' => $this->url,
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ],
            'http_errors' => false
        ];

        $client = new Client($http_options);

        $response = $client->request("POST", "auth",[
            'json' => [
                'email' => $this->email,
                'password' => $this->password,
            ]
        ]);

        if ($response->getStatusCode() == 200) {
            $content = $response->getBody();
            
            return json_decode($content);
        } else {
            Log::error("[API-OBAT] | " . __METHOD__ . ' | '. $response->getReasonPhrase());

            return false;
        }
    }

    public function getListObat($token)
    {
        $http_options = [
            'base_uri' => $this->url,
            'headers' => [
                'Authorization' => 'Bearer '.$token,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ],
            'http_errors' => false
        ];

        $client = new Client($http_options);

        $response = $client->request("GET", "medicines");

        if ($response->getStatusCode() == 200) {
            $content = $response->getBody();
            
            return json_decode($content, true);
        } else {
            Log::error("[API-OBAT] | " . __METHOD__ . ' | '. $response->getReasonPhrase());

            return false;
        }
    }

    public function getHargaObat($token, $uuid)
    {
        $http_options = [
            'base_uri' => $this->url,
            'headers' => [
                'Authorization' => 'Bearer '.$token,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ],
            'http_errors' => false
        ];

        $client = new Client($http_options);

        $response = $client->request("GET", "medicines/" . $uuid . "/prices");

        if ($response->getStatusCode() == 200) {
            $content = $response->getBody();
            
            return json_decode($content, true);
        } else {
            Log::error("[API-OBAT] | " . __METHOD__ . ' | '. $response->getReasonPhrase());

            return false;
        }
    }
}