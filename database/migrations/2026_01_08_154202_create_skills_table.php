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
        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->string('slug')->unique();
            $table->boolean('status')->default(false);
            $table->timestamps();
        });

        // Insert default skills with icons
        $skills = [
            ['title' => 'PHP', 'slug' => 'php'],
            ['title' => 'JavaScript', 'slug' => 'javascript'],
            ['title' => 'Python', 'slug' => 'python'],
            ['title' => 'Java', 'slug' => 'java'],
            ['title' => 'React', 'slug' => 'react'],
            ['title' => 'Vue.js', 'slug' => 'vuejs'],
            ['title' => 'Laravel', 'slug' => 'laravel'],
            ['title' => 'Node.js', 'slug' => 'nodejs'],
            ['title' => 'MySQL', 'slug' => 'mysql'],
            ['title' => 'PostgreSQL', 'slug' => 'postgresql'],
            ['title' => 'MongoDB', 'slug' => 'mongodb'],
            ['title' => 'Git', 'slug' => 'git'],
            ['title' => 'Docker', 'slug' => 'docker'],
            ['title' => 'AWS', 'slug' => 'aws'],
            ['title' => 'HTML/CSS', 'slug' => 'html-css'],
        ];

        foreach ($skills as $skill) {
            DB::table('skills')->insert([
                'title'      => $skill['title'],
                'slug'       => $skill['slug'],
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
        Schema::dropIfExists('skills');
    }
};
