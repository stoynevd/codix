<?php

namespace Models;

class Country {

    public $name;
    public $population;
    public $languages;

    public function __construct($name, $population, $languages) {
        $this->name = $name;
        $this->population = $population;
        $this->languages = $languages;
    }

}