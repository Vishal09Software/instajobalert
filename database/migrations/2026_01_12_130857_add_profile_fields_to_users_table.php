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
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar')->nullable()->after('email');
            $table->string('first_name')->nullable()->after('avatar');
            $table->string('last_name')->nullable()->after('first_name');
            $table->string('phone')->nullable()->after('last_name');
            $table->date('date_of_birth')->nullable()->after('phone');
            $table->string('location')->nullable()->after('date_of_birth');
            $table->string('professional_title')->nullable()->after('location');
            $table->string('resume')->nullable()->after('professional_title');
            $table->text('cover_letter')->nullable()->after('resume');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'avatar',
                'first_name',
                'last_name',
                'phone',
                'date_of_birth',
                'location',
                'professional_title',
                'resume',
                'cover_letter'
            ]);
        });
    }
};
