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
            $table->string('icon')->nullable();
            $table->boolean('status')->default(false);
            $table->timestamps();
        });

        // Insert default skills with icons
        $skills = [
            ['title' => 'PHP', 'slug' => 'php', 'icon' => 'bi-code-slash'],
            ['title' => 'JavaScript', 'slug' => 'javascript', 'icon' => 'bi-filetype-js'],
            ['title' => 'Python', 'slug' => 'python', 'icon' => 'bi-filetype-py'],
            ['title' => 'Java', 'slug' => 'java', 'icon' => 'bi-filetype-java'],
            ['title' => 'React', 'slug' => 'react', 'icon' => 'bi-filetype-jsx'],
            ['title' => 'Vue.js', 'slug' => 'vuejs', 'icon' => 'bi-filetype-vue'],
            ['title' => 'Laravel', 'slug' => 'laravel', 'icon' => 'bi-code-slash'],
            ['title' => 'Node.js', 'slug' => 'nodejs', 'icon' => 'bi-filetype-node'],
            ['title' => 'MySQL', 'slug' => 'mysql', 'icon' => 'bi-database'],
            ['title' => 'PostgreSQL', 'slug' => 'postgresql', 'icon' => 'bi-database-fill'],
            ['title' => 'MongoDB', 'slug' => 'mongodb', 'icon' => 'bi-database-check'],
            ['title' => 'Git', 'slug' => 'git', 'icon' => 'bi-git'],
            ['title' => 'Docker', 'slug' => 'docker', 'icon' => 'bi-box'],
            ['title' => 'AWS', 'slug' => 'aws', 'icon' => 'bi-cloud'],
            ['title' => 'HTML/CSS', 'slug' => 'html-css', 'icon' => 'bi-filetype-html'],
        ];

        foreach ($skills as $skill) {
            DB::table('skills')->insert([
                'title'      => $skill['title'],
                'slug'       => $skill['slug'],
                'icon'       => $skill['icon'],
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
