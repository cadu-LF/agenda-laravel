<?php

namespace App\Services\Contact;

use App\Repositories\ContactRepositoryEloquent;
use App\Services\Params\Contact\CreateContactServiceParams;
use App\Services\Responses\ServiceResponse;

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
     * Cria um novo contato caso já não pertença ao usuário logado
     *
     * @param contact:CreateContactServiceParams
     * @return ServiceResponse
     */
    public function createContact(CreateContactServiceParams $contact)
    {
        // procura se existe algum telefone com o numero passado  ligado ao usuário cadastrado
        $result = $this->contactRepositoryEloquent->findWhere([
            'id_user' => $contact->id_user,
            'phone' => $contact->phone
        ]);

        // se não houver nenhum registro no banco cria um novo
        if ($result->count() == 0) {
            // cria novo contato
            $this->contactRepositoryEloquent->create([
                'fullname' => $contact->fullname,
                'phone' => $contact->phone,
                'email' => $contact->email,
                'note' => $contact->note,
                'id_user' => $contact->id_user,
                'id_address' => $contact->id_address,
                'id_category' => $contact->id_category
            ]);

            // retorna um ServiceResponse
            return new ServiceResponse(
                true,
                "Novo contato cadastrado",
                $this->contactRepositoryEloquent->findWhere([
                    'id_user' => $contact->id_user,
                    'phone' => $contact->phone
                ])
            );
        }

        // retorna um Service com os dados encontrados caso o usuário já exista
        return new ServiceResponse(
            true,
            "Contato já cadastrado",
            $result
        );
    }

    /**
     * Retorna todos os dados do contato
     *
     * @param id:int
     * @return ServiceResponse
     */
    public function getFullContact(int $id)
    {
        $contact = $this->contactRepositoryEloquent->find($id);
        var_dump($contact->address());
        exit();
        return new ServiceResponse(
            true,
            "Contato encontrado",
            $contact
        );
    }
}
