<?php

namespace App\Http\Services;

use App\Models\Category;

class CategoryService
{
    public function __construct()
    {
    }

    public function getOrCreateCategory(int $applicationId, int $name, int $parent_id = null): Category
    {

        return Category::firstOrCreate([
            "application_id" => $applicationId,
            "name" => $name,
            "parent_id" => $parent_id
        ]);
    }
}
