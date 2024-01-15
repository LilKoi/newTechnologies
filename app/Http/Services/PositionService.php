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
            ->has('childs')
            ->with([
                'childs.positions' => function ($builder) use ($date) {
                    $builder->where('date', $date);
                }
            ])
            ->get();
        return $categories->mapWithKeys(function ($category, $index) {
            $minValue = $category->childs->reduce(function ($min, $child) {
                $childMinValue = $child->positions->min('value');
                return $min === null || ($childMinValue !== null && $childMinValue < $min) ? $childMinValue : $min;
            }, null);

            return [$category->name => $minValue];
        });
    }
}
