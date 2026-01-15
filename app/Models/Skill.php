<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Occupation;

class Skill extends Model
{
    protected $fillable = ['title', 'slug', 'icon', 'status'];

    public function occupations()
    {
        return $this->hasMany(Occupation::class, 'skill_id');
    }
}

