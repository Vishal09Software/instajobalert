<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Occupation;

class JobCategory extends Model
{
    protected $fillable = ['title', 'slug', 'icon', 'status' ,'parent_id'];

    public function occupations()
    {
        return $this->hasMany(Occupation::class, 'category_id');
    }

    public function parent()
    {
        return $this->belongsTo(JobCategory::class, 'parent_id');
    }
}
