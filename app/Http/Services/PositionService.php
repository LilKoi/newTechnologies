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
            $minValue = null;
            $category->childs->each(function ($child) use (&$minValue) {
                $childMinValue = $child->positions->min('value');
                if ($minValue === null || ($childMinValue !== null && $childMinValue < $minValue)) {
                    $minValue = $childMinValue;
                }
            });

            return [$category->name => $minValue];
        });
    }
}
