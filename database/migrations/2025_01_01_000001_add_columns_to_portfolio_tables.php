<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('title')->after('id');
            $table->string('company')->after('title');
            $table->string('category')->after('company'); // design atau dev
            $table->text('description')->after('category');
            $table->string('image_path')->after('description');
            $table->integer('order')->default(0)->after('image_path');
        });

        Schema::table('clients', function (Blueprint $table) {
            $table->string('name')->nullable()->after('id');
            $table->string('logo_path')->nullable()->after('name');
        });

        Schema::table('experiences', function (Blueprint $table) {
            $table->string('company')->after('id');
            $table->string('role')->after('company');
            $table->string('start_year')->after('role');
            $table->string('end_year')->default('Present')->after('start_year');
            $table->text('description')->nullable()->after('end_year');
        });

        Schema::table('tools', function (Blueprint $table) {
            $table->string('name')->after('id');
        });

        Schema::table('galleries', function (Blueprint $table) {
            $table->string('title')->after('id');
            $table->text('description')->after('title');
            $table->string('image_path')->after('description');
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->string('key')->unique()->after('id');
            $table->text('value')->nullable()->after('key');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['title', 'company', 'category', 'description', 'image_path', 'order']);
        });

        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn(['name', 'logo_path']);
        });

        Schema::table('experiences', function (Blueprint $table) {
            $table->dropColumn(['company', 'role', 'start_year', 'end_year', 'description']);
        });

        Schema::table('tools', function (Blueprint $table) {
            $table->dropColumn('name');
        });

        Schema::table('galleries', function (Blueprint $table) {
            $table->dropColumn(['title', 'description', 'image_path']);
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['key', 'value']);
        });
    }
};
