<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'employee_id';

    /**
     * The category that belong to the employee.
     */
    public function category()
    {
        return $this->belongsTo('Category', 'category_id', 'category_id');
    }

    /**
     * The hobbies that belong to the employee.
     */
    public function hobbies()
    {
        return $this->belongsToMany('Hobby', 'employee_hobby', 'employee_id', 'hobby_id');
    }

    /**
     * Set storage path to image
     */
    public function getImageAttribute($image)
    {
        return asset(\Storage::url($image));
    }
}
