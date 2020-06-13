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

    public function __toString() {
        return 'Country: ' . $this->name . '; Population: ' . $this->population . '; Languages: ' . $this->languages;
    }

}