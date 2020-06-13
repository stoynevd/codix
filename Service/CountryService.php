<?php

namespace Service;

use Models\Country;
use Api\Wrapper;

class CountryService
{

    public $allCountries;
    public $result;
    public $regions;
    public $languages;

    public function __construct() {

        if (!$this->allCountries) {
            $wrapper = new Wrapper();
            $this->allCountries = $wrapper->getAllCountries();
        }

        if (!$this->regions) {
            $this->regions = array_filter(array_unique(array_column($this->allCountries, 'region')));
        }

        if (!$this->result) {
            $this->setCountries();
        }

    }

    public function setCountries() {

        foreach ($this->regions as $region) {

            $sameRegion = [];

            foreach ($this->allCountries as $country) {

                if ($region == $country['region']) {

                    $sameRegion[] = new Country($country['name'], $country['population'], array_column($country['languages'], 'name'));

                }

                foreach ($country['languages'] as $language) {

                    if (!isset($this->languages[$language['name']])) {

                        $this->languages[$language['name']] = $country['population'];

                    } else if (isset($this->languages[$language['name']])) {
                        $this->languages[$language['name']] += $country['population'];
                    }

                }

            }

            $this->result[$region] = $sameRegion;

        }
    }

    public function groupByRegion() {
        return $this->result;
    }

    public function getNumberOfCountriesInARegion($region) {

        if (in_array($region, $this->regions)) {
            return count($this->result[$region]);
        }

        return 'The region "' . $region . '" does not exist';
    }

    public function sumPopulation() {

        $totalSum = [];

        foreach ($this->regions as $region) {
            $totalSum[$region] = array_sum(array_column($this->result[$region], 'population'));
        }

        return $totalSum;
    }

    public function sumPopulationForSpecificRegion($region) {
        if (in_array($region, $this->regions)) {
            return array_sum(array_column($this->result[$region], 'population'));
        }

        return 'The region "' . $region . '" does not exist';
    }

    public function getAllLanguages() {
        arsort($this->languages);
        return $this->languages;
    }

    public function getByRegion() {

        $data = [];

        foreach ($this->regions as $region) {

            $data[$region] = [
                'Number of Countries In the region' => count($this->result[$region]),
                'Sum of population in region'       => array_sum(array_column($this->result[$region], 'population')),
            ];

        }

        return $data;

    }


}