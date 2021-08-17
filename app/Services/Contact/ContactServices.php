<?php

namespace App\Services\Contact;

use App\Model\Contact;
use App\Repositories\Contact\ContactRepositoryEloquent;
use App\Services\Params\Contact\CreateContactServiceParams;

class ContactServices
{
    /**
     * Inicializa a repository de contacts
     */
    protected $contactRepositoryEloquent;

    public function __construct(
        ContactRepositoryEloquent $contactRepositoryEloquent
    ) {
        $this->contactRepositoryEloquent = $contactRepositoryEloquent;
    }

    /**
     * Verifica se um contato já existe
     *
     * @param contact:CreateContactServiceParams
     * @return message:string
     */
    public function contactExists(CreateContactServiceParams $contact)
    {
        return $this->contactRepositoryEloquent->verifyContact($contact);
    }
}
