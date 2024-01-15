<?php

namespace App\Http\Services;

use App\Models\Category;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

class PositionService
{
    public function __construct()
    {
    }

    public function getPositions(string $date)
    {
        $categories = Category::query()
            ->withMin([
                'positions' =>  fn ($builder)  => $builder->where('date', $date)
            ], 'value')
            ->has('parent')
            ->get();
        return $categories->mapWithKeys(function ($category, $index) {
            return [
                $category->parent->name => $category->positions_min_value,
            ];
        });
    }
}
