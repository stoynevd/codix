<?php

/**
 * @author Dimitar Stoynev
 */

require_once('Api/Wrapper.php');
require_once('Models/Country.php');
require_once('Services/CountryService.php');

$countryService = new Services\CountryService();

print_r($countryService->getByRegion());
print_r("\n");
print_r($countryService->getAllLanguages());

/**
 * Due to the task description was a bit unclear, I have made two versions:
 * 1. The two methods above combine all the functionality of the subtasks into one function
 * 2. The rest of the function calls below represent the functionality of all the subtasks as separate functions
 */
//print_r($countryService->groupByRegion());
//print_r($countryService->sumPopulation());
//print_r($countryService->sumPopulationForSpecificRegion('Asia'));
//print_r($countryService->getNumberOfCountriesInARegion('Asia'));


