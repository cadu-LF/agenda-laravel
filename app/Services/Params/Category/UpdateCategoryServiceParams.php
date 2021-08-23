<?php

namespace App\Services\Params\Category;

use App\Services\Params\BaseServiceParams;

class UpdateCategoryServiceParams extends BaseServiceParams
{
    public $id_category;
    public $description;

    public function __construct(
        $id_category,
        string $description
    ) {
        parent::__construct();
    }
}
