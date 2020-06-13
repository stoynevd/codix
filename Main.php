<?php

require_once('Api/Wrapper.php');
require_once('Models/Country.php');
require_once('Services/CountryService.php');

$countryService = new Services\CountryService();

print_r($countryService->getByRegion());
print_r("\n");
print_r($countryService->getAllLanguages());


