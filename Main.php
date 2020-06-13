<?php

require_once('Api/Wrapper.php');
require_once('Models/Country.php');
require_once('Service/CountryService.php');

$test = new Service\CountryService();
//$test = new Api\Wrapper();

print_r($test->getByRegion());


