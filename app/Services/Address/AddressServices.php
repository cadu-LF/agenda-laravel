<?php

namespace App\Services\Address;

use App\Repositories\AddressRepositoryEloquent;
use App\Services\Responses\ServiceResponse;
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
     * cria um novo endereco
     *
     * @param CreateAddressServiceParams
     * @return ServiceResponse
     */
    public function createAddress(CreateAddressServiceParams $address)
    {
        // procura um endereco a partir do cep
        $result = $this->addressRepositoryEloquent->findWhere([
            'cep' => $address->cep
        ]);

        // se não tiver nenhum endereço é cadastrado um novo e retorna o ServiceResponse
        if ($result->count() == 0) {
            // cria um novo endereço
            $this->addressRepositoryEloquent->create([
                'cep' => $address->cep,
                'number' => $address->number,
                'street' => $address->street,
                'neighborhood' => $address->neighborhood,
                'city' => $address->city,
                'state' => $address->state,
                'country' => $address->country
            ]);

            //retorna ServiceResponse
            return new ServiceResponse(
                true,
                "Endereço cadastrado com sucesso",
                $this->addressRepositoryEloquent->findWhere([
                    'cep' => $address->cep
                ])
            );
        }

        return new ServiceResponse(
            true,
            "Endereço já cadastrado",
            $result
        );
    }
}
