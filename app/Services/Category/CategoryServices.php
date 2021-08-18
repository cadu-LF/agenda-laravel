<?php

namespace App\Services\Category;

use App\Repositories\CategoryRepositoryEloquent;
use App\Services\Params\Category\CreateCategoryServiceParams;
use App\Services\Responses\ServiceResponse;

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
     * Cria uma novo categoria caso ainda não exista
     *
     * @param category:CreateCategoryServiceParams
     * @return ServiceResponse
     */
    public function createCategory(CreateCategoryServiceParams $category)
    {
        $result = $this->categoryRepositoryEloquent->findWhere([
            'description' => $category->description
        ]);

        if ($result->count() == 0) {
            $this->categoryRepositoryEloquent->create([
                'description' => $category->description
            ]);

            return new ServiceResponse(
                true,
                "Categoria cadastrada com sucesso",
                $this->categoryRepositoryEloquent->findWhere([
                    'description' => $category->description
                ])
            );
        }

        return new ServiceResponse(
            true,
            "Categoria já cadastrada",
            $result
        );
    }
}
