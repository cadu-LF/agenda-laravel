<?php

namespace App\Services\Params\Contact;

use App\Services\Params\BaseServiceParams;

class UpdateContactServiceParams extends BaseServiceParams
{
    public $id_contact;
    public $fullname;
    public $phone;
    public $email;
    public $note;
    public $id_user;
    public $id_address;
    public $id_category;

    public function __construct(
        int $id_contact,
        string $fullname,
        string $phone,
        $email,
        $note,
        int $id_user,
        int $id_address,
        int $id_category
    ) {
        parent::__construct();
    }
}
