<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('job_types', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->string('slug')->unique();
            $table->boolean('status')->default(false);
            $table->timestamps();
        });

        // Insert default job types with icons
        $jobTypes = [
            ['title' => 'Full-time', 'slug' => 'full-time'],
            ['title' => 'Part-time', 'slug' => 'part-time'],
            ['title' => 'Contract', 'slug' => 'contract'],
            ['title' => 'Temporary', 'slug' => 'temporary'],
            ['title' => 'Internship', 'slug' => 'internship'],
            ['title' => 'Freelance', 'slug' => 'freelance'],
            ['title' => 'Volunteer', 'slug' => 'volunteer'],
        ];

        foreach ($jobTypes as $jobType) {
            DB::table('job_types')->insert([
                'title'      => $jobType['title'],
                'slug'       => $jobType['slug'],
                'status'     => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_types');
    }
};
