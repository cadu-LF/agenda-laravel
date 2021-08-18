<?php

namespace App\Repositories;

use App\Model\Contact;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\ContactRepository;

/**
 * Class ContactRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ContactRepositoryEloquent extends BaseRepository implements ContactRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Contact::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
