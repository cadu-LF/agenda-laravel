<?php

namespace App\Repositories\Contact;

use App\Model\Contact;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contact\ContactRepository;
use App\Services\Params\Contact\CreateContactServiceParams;
use App\Validators\ContactValidator;

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
     * Create a new contact on Database
     *
     * @param contact:ContactServicesParams
     * @return boolean
     */
    public function make(CreateContactServiceParams $contact)
    {
        Contact::create([
            'fullname' => $contact->fullname,
            'phone' => $contact->phone,
            'email' => $contact->email,
            'note' => $contact->note,
            'id_user' => $contact->id_user,
            'id_address' => $contact->id_address,
            'id_category' => $contact->id_category
        ]);
    }

    /**
     * Verifica se usuário já foi criado
     *
     * @param contact:CreateContactServiceParams
     * @return string
     */
    public function verifyContact(CreateContactServiceParams $contact)
    {
        $result = $this->findWhere([
            'phone' => $contact->phone
        ]);

        if ($result->count() == 0) {
            $this->make($contact);
            return "Novo contato cadastrado";
        }

        return "Contato já cadastrado";
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
