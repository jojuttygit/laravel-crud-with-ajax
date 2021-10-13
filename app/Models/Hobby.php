<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hobby extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'hobby_id';

    /**
     * The employees that belong to the hobby.
     */
    public function employees()
    {
        return $this->belongsToMany('Employee', 'employee_hobby', 'hobby_id', 'employee_id');
    }
}
