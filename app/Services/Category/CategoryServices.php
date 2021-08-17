<?php

namespace App\Services\Category;

use App\Model\Category;
use App\Repositories\Category\CategoryRepositoryEloquent;
use App\Services\Params\Category\CreateCategoryServiceParams;

class CategoryServices
{
    /**
     * Inicializa o repository
     */
    protected $categoryRepositoryEloquent;

    public function __construct(
        CategoryRepositoryEloquent $categoryRepositoryEloquent
    ) {
        $this->categoryRepositoryEloquent = $categoryRepositoryEloquent;
    }
    /**
     *
     * Pega o id de uma categoria
     *
     * @param category:CreateCategoryServiceParams
     * @return id:int
     */
    public function getCategoryId(CreateCategoryServiceParams $category)
    {
        return $this->categoryRepositoryEloquent->getCategoryId($category);
    }
}
