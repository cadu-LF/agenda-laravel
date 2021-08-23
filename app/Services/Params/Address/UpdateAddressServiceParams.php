<?php

namespace App\Services\Params\Address;

use App\Services\Params\BaseServiceParams;

class UpdateAddressServiceParams extends BaseServiceParams
{
    public $id_address;
    public $cep;
    public $number;
    public $street;
    public $neighborhood;
    public $city;
    public $state;
    public $country;

    public function __construct(
        $id_address,
        string $cep,
        int $number,
        string $street,
        string $neighborhood,
        string $city,
        string $state,
        string $country
    ) {
        parent::__construct();
    }
}
