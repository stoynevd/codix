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

    /**
     * This function in the Wrapper class is used to fetch the data from the api and deliver it as an associative array
     * @return mixed
     */
    public function getAllCountries() {

        if (!$this->allCountries) {

            try {

                $response = $this->client->get('');

                $this->allCountries = \GuzzleHttp\json_decode($response->getBody(), true);

            } catch (\Exception $e) {
                echo $e->getMessage();
            }
        }

        return $this->allCountries;

    }

}