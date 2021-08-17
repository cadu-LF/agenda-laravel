<?php

namespace App\Repositories\Category;

use App\Model\Category;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Category\CategoryRepository;
use App\Services\Params\Category\CreateCategoryServiceParams;
use App\Validators\CategoryValidator;

/**
 * Class CategoryRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CategoryRepositoryEloquent extends BaseRepository implements CategoryRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Category::class;
    }

    /**
     * Cria uma nova categoria no database
     *
     * @param category:CreateCategoryServiceParams
     */
    public function make(CreateCategoryServiceParams $category)
    {
        Category::create([
            'description' => $category->description
        ]);
    }

    /**
     * Retorna o id de uma categoria
     *
     * @param category:CreateCategoryServiceParams
     * @return id:int
     */
    public function getCategoryId(CreateCategoryServiceParams $category)
    {
        $result = $this->findWhere([
            'description' => $category->description
        ]);

        if ($result->count() == 0) {
            $this->make($category);
        }

        $result = $this->findWhere([
            'description' => $category->description
        ]);

        return $result->toArray()[0]['id'];
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
