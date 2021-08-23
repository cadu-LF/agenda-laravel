<?php

namespace App\Services\Address;

use App\Services\Responses\ServiceResponse;
use App\Repositories\AddressRepositoryEloquent;
use App\Services\Params\Address\CreateAddressServiceParams;
use App\Services\Params\Address\UpdateAddressServiceParams;

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

    /**
     * Retorna um endereço de acordo com o id
     *
     * @param int
     * @return ServiceResponse
     */
    public function getAddress(int $id)
    {
        $address = $this->addressRepositoryEloquent->find($id);
        return new ServiceResponse(
            true,
            "Endereço encontrado",
            $address
        );
    }

    /**
     * Atualiza os dados de um endereço
     *
     * @param UpdateAddressServiceParams
     *
     * @return ServiceResponse
     */
    public function updateAddress(UpdateAddressServiceParams $address)
    {
        $id = $address->id_address;
        $address = $address->toArray();
        $this->addressRepositoryEloquent->update($address, $id);

        return new ServiceResponse(
            true,
            "Endereço Atualizado com sucesso",
            $this->addressRepositoryEloquent->find($id)
        );
    }
}
