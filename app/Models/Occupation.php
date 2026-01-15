<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Occupation extends Model
{
    protected $fillable = [
        'category_id',
        'skill_id',
        'type',
        'title',
        'amount',
        'slug',
        'company',
        'location',
        'description',
        'link',
        'job_id',
        'posted_at',
        'expires_at',
        'employment_type_id',
        'seniority_level',
        'status',
    ];

    public function category()
    {
        return $this->belongsTo(JobCategory::class, 'category_id');
    }

    public function employmentType()
    {
        return $this->belongsTo(JobType::class, 'employment_type_id');
    }
}
