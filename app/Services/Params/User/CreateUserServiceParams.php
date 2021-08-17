<?php

namespace App\Services\Params\User;

use App\Services\Params\BaseServiceParams;

class CreateUserServiceParams extends BaseServiceParams
{
    public $name;
    public $email;
    public $password;

    public function __construct(
        string $name,
        string $email,
        string $password
    ) {
        parent::__construct();
    }
}
