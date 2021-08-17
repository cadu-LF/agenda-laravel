<?php

namespace App\Services\Params\Contact;

use App\Services\Params\BaseServiceParams;

class CreateContactServiceParams extends BaseServiceParams
{
    public $fullName;
    public $phone;
    public $email;
    public $note;
    public $id_user;
    public $id_address;
    public $id_category;

    public function __construct(
        string $fullName,
        string $phone,
        $email,
        $note,
        int $id_user,
        int $id_address,
        $id_category
    ) {
        parent::__construct();
    }
}
