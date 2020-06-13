<?php

namespace Api;

require 'vendor/autoload.php';
use GuzzleHttp\Client;
use GuzzleHttp\Stream\Stream;

class Wrapper {

    public $client;
    public $allCountries;

    public function __construct() {
        if (!$this->client) {
            $this->client = new Client([
                'base_uri' => 'https://restcountries.eu/rest/v2/all'
            ]);
        }
    }

    public function getAllCountries() {

        if (!$this->allCountries) {

            try {

                $response = $this->client->get('');

                $this->allCountries = \GuzzleHttp\json_decode($response->getBody());

                $this->allCountries = \GuzzleHttp\json_decode(\GuzzleHttp\json_encode($this->allCountries), true);

            } catch (\Exception $e) {
                echo $e->getMessage();
            }
        }

        return $this->allCountries;

    }

}