<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('occupations', function (Blueprint $table) {
            $table->id();
            $table->string('category_id')->nullable()->index();
            $table->string('skill_id')->nullable()->index();
            $table->string('type')->nullable();
            $table->string('title');
            $table->string('amount')->nullable();
            $table->string('slug')->nullable();
            $table->string('company')->nullable();
            $table->string('location')->nullable();
            $table->longText('description')->nullable();
            $table->text('link')->nullable();
            $table->string('job_id')->unique();
            $table->timestamp('posted_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->string('employment_type_id')->nullable()->index();
            $table->string('seniority_level')->nullable();
            $table->string('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('occupations');
    }
};
