<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'category_id';

    /**
     * The employee that belong to the category.
     */
    public function employees()
    {
        return $this->hasMany('Employee', 'category_id', 'category_id');
    }
}
