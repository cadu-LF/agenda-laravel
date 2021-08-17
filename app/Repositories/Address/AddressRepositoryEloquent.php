<?php

namespace App\Repositories\Address;

use App\Model\Address;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Address\AddressRepository;
use App\Services\Params\Address\CreateAddressServiceParams;
use App\Validators\AddressValidator;

/**
 * Class AddressRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class AddressRepositoryEloquent extends BaseRepository implements AddressRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Address::class;
    }

    /**
     * Create new address on database
     *
     * @param address
     * @return boolean
     */
    public function make(CreateAddressServiceParams $address)
    {
        Address::create([
            'cep' => $address->cep,
            'number' => $address->number,
            'street' => $address->street,
            'neighborhood' => $address->neighborhood,
            'city' => $address->city,
            'state' => $address->state,
            'country' => $address->country
        ]);

        return true;
    }

    /**
     * Get all Addresses rigistered on database
     *
     * @param null
     * @return Collection
     */
    public static function getAddresses()
    {
        return Address::all();
    }

    /**
     * Vereify if the address already exists on the database
     *
     * @param address:CreateAddressServiceParams
     * @return id:int
     */
    public function getCepId(CreateAddressServiceParams $address)
    {
        $result = $this->findWhere([
            'cep' => $address->cep
        ]);

        var_dump($result->count());
        if ($result->count() == 0) {
            $this->make($address);
        }

        $result = $this->findWhere([
            'cep' => $address->cep
        ]);
        var_dump($result->toArray()[0]['id']);
        return $result->toArray()[0]['id'];
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
