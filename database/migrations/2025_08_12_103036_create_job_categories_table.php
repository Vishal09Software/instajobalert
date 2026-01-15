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
        Schema::create('job_categories', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->string('slug')->unique();
            $table->string('icon')->nullable();
            $table->string('parent_id')->nullable()->index();
            $table->boolean('status')->default(false);
            $table->timestamps();
        });

        // Insert default categories with icons
        $categories = [
            ['title' => 'Engineering', 'slug' => 'engineering', 'icon' => 'bi-code-slash'],
            ['title' => 'Information Technology', 'slug' => 'information-technology', 'icon' => 'bi-laptop'],
            ['title' => 'Marketing', 'slug' => 'marketing', 'icon' => 'bi-megaphone'],
            ['title' => 'Finance', 'slug' => 'finance', 'icon' => 'bi-bank'],
            ['title' => 'Accounting', 'slug' => 'accounting', 'icon' => 'bi-calculator'],
            ['title' => 'Healthcare Service', 'slug' => 'healthcare-service', 'icon' => 'bi-heart-pulse'],
            ['title' => 'Education', 'slug' => 'education', 'icon' => 'bi-book'],
            ['title' => 'Customer Service', 'slug' => 'customer-service', 'icon' => 'bi-headset'],
            ['title' => 'Arts and Design', 'slug' => 'arts-and-design', 'icon' => 'bi-palette'],
            ['title' => 'Sales', 'slug' => 'sales', 'icon' => 'bi-graph-up-arrow'],
            ['title' => 'Human Resources', 'slug' => 'human-resources', 'icon' => 'bi-people'],
            ['title' => 'Operations', 'slug' => 'operations', 'icon' => 'bi-gear'],
            ['title' => 'Business Development', 'slug' => 'business-development', 'icon' => 'bi-briefcase'],
            ['title' => 'Administrative Assistant', 'slug' => 'administrative-assistant', 'icon' => 'bi-clipboard-check'],
            ['title' => 'Administrative', 'slug' => 'administrative', 'icon' => 'bi-clipboard-check'],
            ['title' => 'Retail Associate', 'slug' => 'retail-associate', 'icon' => 'bi-shop'],
            ['title' => 'Program and Project Management', 'slug' => 'program-and-project-management', 'icon' => 'bi-kanban'],
            ['title' => 'Consulting', 'slug' => 'consulting', 'icon' => 'bi-lightbulb'],
            ['title' => 'Legal', 'slug' => 'legal', 'icon' => 'bi-scale'],
            ['title' => 'Media and Communications', 'slug' => 'media-and-communications', 'icon' => 'bi-broadcast'],
            ['title' => 'Product Management', 'slug' => 'product-management', 'icon' => 'bi-box-seam'],
            ['title' => 'Research', 'slug' => 'research', 'icon' => 'bi-search'],
            ['title' => 'Support', 'slug' => 'support', 'icon' => 'bi-life-preserver'],
            ['title' => 'Other', 'slug' => 'other', 'icon' => 'bi-grid'],
        ];

        foreach ($categories as $category) {
            DB::table('job_categories')->insert([
                'title'      => $category['title'],
                'slug'       => $category['slug'],
                'icon'       => $category['icon'],
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
        Schema::dropIfExists('job_categories');
    }
};
