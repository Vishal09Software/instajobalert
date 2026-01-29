<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Occupation;
class JobSeo extends Model
{
    protected $table = 'job_seo';
    protected $fillable = ['job_id', 'key', 'values'];

    public function job()
    {
        return $this->belongsTo(Occupation::class, 'job_id');
    }
}
