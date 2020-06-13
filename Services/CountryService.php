<?php

namespace Services;

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
            $this->regions = $this->setRegions();
        }

        if (!$this->result) {
            $this->setCountries();
        }

    }

    /**
     * This function sets up the countries using the Country model based on the region where the country is located.
     * It further sets up the languages paired with the number of people speaking a given language.
     * For a given language it is possible to be spoken from multiple countries. The information from the api fetch, does
     * not give information about a specific % of the population that speaks a given language, in this scenario we can
     * assume that the whole population speaks the specified language.
     */
    public function setCountries() {

        foreach ($this->regions as $region) {

            $sameRegion = [];

            foreach ($this->allCountries as $country) {

                if ($region == $country['region']) {
                    $sameRegion[] = new Country($country['name'], $country['population'], array_column($country['languages'], 'name'));

                    foreach ($country['languages'] as $language) {

                        if (!isset($this->languages[$language['name']])) {
                            $this->languages[$language['name']] = $country['population'];
                        } else if (isset($this->languages[$language['name']])) {
                            $this->languages[$language['name']] += $country['population'];
                        }

                    }

                }

            }

            $this->result[$region] = $sameRegion;

        }
    }

    /**
     * This functions sets up the regions array with all the unique regions available
     * Filtering the array removes empty values a.k.a null
     * @return array
     */
    public function setRegions() {
        return array_filter(array_unique(array_column($this->allCountries, 'region')));
    }


    /**
     * This function returns all the Languages and the Number of people speaking the specified language
     * @return mixed
     */
    public function getAllLanguages() {
        arsort($this->languages);
        return $this->languages;
    }

    /**
     * This function returns a list of the regions with some data about:
     *  1. The total population of the region
     *  2. The total number of countries in the specified region
     *
     * N.B. The key values:
     *  1. Sum of population in region
     *  2. Number of Countries In the region
     * are used as specified only for printing/formatting reasons -
     * it's not a good coding practice to specify keys the same way
     * @return array
     */
    public function getByRegion() {

        $data = [];

        foreach ($this->regions as $region) {

            $data[$region] = [
                'Sum of population in region'       => array_sum(array_column($this->result[$region], 'population')),
                'Number of Countries In the region' => count($this->result[$region]),
            ];

        }

        asort($data);
        return $data;
    }


    /**
     * The functions below are the functionalities mentioned as 1.1, 1.2 etc in the sent task
     * The functionalities below are separated from each other
     */

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

        asort($totalSum);

        return $totalSum;
    }

    public function sumPopulationForSpecificRegion($region) {
        if (in_array($region, $this->regions)) {
            return array_sum(array_column($this->result[$region], 'population'));
        }

        return 'The region "' . $region . '" does not exist';
    }

}