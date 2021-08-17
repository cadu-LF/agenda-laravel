<?php

namespace App\Services\Address;

use App\Model\Address;

class AddressServices
{
    /**
     * Pega o id de um endereço de acordo com o cep
     *
     * @param $cep
     * @return int
     */
    public static function getAddressId($cep)
    {
        $addresses = Address::all()->toArray();

        foreach ($addresses as $address) {
            if ($address['cep'] === $cep) {
                return $address['id'];
            }
        }
        return -1;
    }
}
