<?php

namespace App\Services\Category;

use App\Services\Responses\ServiceResponse;
use App\Repositories\CategoryRepositoryEloquent;
use App\Services\Params\Category\CreateCategoryServiceParams;
use App\Services\Params\Category\UpdateCategoryServiceParams;

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

    /**
     * Retorna uma categoria
     *
     * @param int
     * @return ServiceResponse
     */
    public function getCategory(int $id)
    {
        $category = $this->categoryRepositoryEloquent->find($id);

        return new ServiceResponse(
            true,
            "Categoria encontrada",
            $category
        );
    }

    /**
     * Atualiza uma categoria
     *
     * @param UpdateCategoryServiceParams
     * @return ServiceResponse
     */
    public function updateCategory(UpdateCategoryServiceParams $category)
    {
        $id = $category->id_category;
        $category = $category->toArray();

        $this->categoryRepositoryEloquent->update($category, $id);

        return new ServiceResponse(
            true,
            'Categoria atualizada com sucesso',
            $this->categoryRepositoryEloquent->find($id)
        );
    }

    /**
     * Pega o id de determinada categoria
     *
     * @param string
     * @return int
     */
    public function getCategoryId(string $description)
    {
        $category = $this->categoryRepositoryEloquent->findWhere([
            'description' => $description
        ]);

        if ($category->count() > 0) {
            return $category->toArray()[0]['id'];
        } else {
            return 0;
        }
    }

    /**
     * Pega todas as categorias
     *
     * @return
     */
    public function getAllCategories()
    {
        $categories = $this->categoryRepositoryEloquent->all();
        return $categories->toArray();
    }
}
