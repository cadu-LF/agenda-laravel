<?php

namespace App\Services\API;

use App\Services\Responses\ServiceResponse;
use App\Repositories\ContactRepositoryEloquent;
use App\Services\Params\Contact\UpdateContactServiceParams;
use App\Services\Responses\ApiResponse;

class APIContactServices
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
     * @return APIResponse
     */
    public function createContact($contact)
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

            return new ApiResponse(
                true,
                200,
                $this->contactRepositoryEloquent->findWhere([
                    'id_user' => $contact->id_user,
                    'phone' => $contact->phone
                ])
            );
        }

        // retorna um Service com os dados encontrados caso o usuário já exista
        return new APIResponse(
            true,
            200,
            $result
        );
    }

    /**
     * Retorna todos os dados do contato
     *
     * @param id:int
     * @return APIResponse
     */
    public function getFullContact(int $id)
    {
        $contact = $this->contactRepositoryEloquent->find($id);
        return new APIResponse(
            true,
            200,
            $contact
        );
    }

    /**
     * Atualiza os dados de um contato
     *
     * @param UpdateContactServiceParams
     * @return APIResponse
     */
    public function updateContact(UpdateContactServiceParams $contact)
    {
        $id = $contact->id_contact;
        $contact = $contact->toArray();

        $this->contactRepositoryEloquent->update($contact, $id);

        return new APIResponse(
            true,
            200,
            $this->contactRepositoryEloquent->find($id)
        );
    }

    /**
     * Deleta um contato do banco
     *
     * @param int
     * @return APIResponse
     */
    public function deleteContact(int $id)
    {
        $contact = $this->contactRepositoryEloquent->find($id);
        $this->contactRepositoryEloquent->delete($id);

        return new APIResponse(
            true,
            200,
            $contact
        );
    }

    /**
     * Retona todos os contatos
     *
     * @return APIResponse
     */
    public function getAllContacts()
    {
        $contacts = $this->contactRepositoryEloquent->all();
        return new ApiResponse(
            true,
            200,
            $contacts
        );
    }
}
