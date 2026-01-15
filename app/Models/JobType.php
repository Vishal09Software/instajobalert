<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Occupation;

class JobType extends Model
{
    protected $fillable = ['title', 'slug', 'status',];

    public function occupations()
    {
        return $this->hasMany(Occupation::class, 'type_id');
    }
}

