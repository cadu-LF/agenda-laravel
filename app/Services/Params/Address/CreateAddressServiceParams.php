<?php

namespace App\Services\Params\Address;

use App\Model\Address;
use App\Services\Params\BaseServiceParams;

class CreateAddressServiceParams extends BaseServiceParams
{
    public $cep;
    public $number;
    public $street;
    public $neighborhood;
    public $city;
    public $state;
    public $country;

    public function __construct(
        string $cep,
        $number,
        string $street,
        string $neighborhood,
        string $city,
        string $state,
        $country
    ) {
        parent::__construct();
    }
}
