<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{

    protected $fillable = ['category_id', 'date', 'value'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
