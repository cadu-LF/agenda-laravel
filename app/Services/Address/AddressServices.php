<?php

namespace App\Services\Address;

use App\Model\Address;
use App\Repositories\Address\AddressRepositoryEloquent;
use App\Services\Params\Address\CreateAddressServiceParams;

class AddressServices
{
    /**
     * Inicializando Repository usado
     *
     * @var AddressRepositoryEloquent
     */
    protected $addressRepositoryEloquent;


    public function __construct(
        AddressRepositoryEloquent $addressRepositoryEloquent
    ) {
        $this->addressRepositoryEloquent = $addressRepositoryEloquent;
    }
    /**
     * Pega o id de um endereço de acordo com o cep
     *
     * @param cep:string
     * @return int
     */
    public function checkAddress(CreateAddressServiceParams $address)
    {
        return $this->addressRepositoryEloquent->getCepId($address);
    }
}
