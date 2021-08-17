<?php

namespace App\Services\Category;

use App\Model\Category;

class CategoryServices
{
    /**
     *
     * Pega o id de uma categoria
     *
     * @param decription:string
     * @return id:int
     */
    public static function getCategoryId($description)
    {
        $categories = Category::all()->toArray();

        foreach ($categories as $category) {
            if ($category['description'] === $description) {
                return $category['id'];
            }
        }
        return -1;
    }
}
