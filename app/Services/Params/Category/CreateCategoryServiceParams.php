<?php

namespace App\Services\Params\Category;

use App\Services\Params\BaseServiceParams;

class CreateCategoryServiceParams extends BaseServiceParams
{
    public $description;

    public function __construct(
        $description
    ) {
        parent::__construct();
    }
}
