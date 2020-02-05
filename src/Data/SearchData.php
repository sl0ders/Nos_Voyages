<?php


namespace App\Data;

use App\Entity\City;
use App\Entity\Country;

class SearchData
{
    /**
     * @var string
     */
    public $q = '';

    /**
     * @var City[]
     */
    public $cities = [];

    /**
     * @var Country[]
     */
    public $countries = [];
}