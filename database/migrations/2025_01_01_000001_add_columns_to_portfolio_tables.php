<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            if (!Schema::hasColumn('projects', 'title'))      $table->string('title')->after('id');
            if (!Schema::hasColumn('projects', 'company'))    $table->string('company')->after('title');
            if (!Schema::hasColumn('projects', 'category'))   $table->string('category')->after('company');
            if (!Schema::hasColumn('projects', 'description'))$table->text('description')->after('category');
            if (!Schema::hasColumn('projects', 'image_path')) $table->string('image_path')->after('description');
            if (!Schema::hasColumn('projects', 'order'))      $table->integer('order')->default(0)->after('image_path');
        });

        Schema::table('clients', function (Blueprint $table) {
            if (!Schema::hasColumn('clients', 'name'))      $table->string('name')->nullable()->after('id');
            if (!Schema::hasColumn('clients', 'logo_path')) $table->string('logo_path')->nullable()->after('name');
        });

        Schema::table('experiences', function (Blueprint $table) {
            if (!Schema::hasColumn('experiences', 'company'))     $table->string('company')->after('id');
            if (!Schema::hasColumn('experiences', 'role'))        $table->string('role')->after('company');
            if (!Schema::hasColumn('experiences', 'start_year'))  $table->string('start_year')->after('role');
            if (!Schema::hasColumn('experiences', 'end_year'))    $table->string('end_year')->default('Present')->after('start_year');
            if (!Schema::hasColumn('experiences', 'description')) $table->text('description')->nullable()->after('end_year');
        });

        Schema::table('tools', function (Blueprint $table) {
            if (!Schema::hasColumn('tools', 'name')) $table->string('name')->after('id');
        });

        Schema::table('galleries', function (Blueprint $table) {
            if (!Schema::hasColumn('galleries', 'title'))       $table->string('title')->after('id');
            if (!Schema::hasColumn('galleries', 'description')) $table->text('description')->after('title');
            if (!Schema::hasColumn('galleries', 'image_path'))  $table->string('image_path')->after('description');
        });

        Schema::table('settings', function (Blueprint $table) {
            if (!Schema::hasColumn('settings', 'key'))   $table->string('key')->unique()->after('id');
            if (!Schema::hasColumn('settings', 'value')) $table->text('value')->nullable()->after('key');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(array_filter(
                ['title', 'company', 'category', 'description', 'image_path', 'order'],
                fn($col) => Schema::hasColumn('projects', $col)
            ));
        });

        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn(array_filter(
                ['name', 'logo_path'],
                fn($col) => Schema::hasColumn('clients', $col)
            ));
        });

        Schema::table('experiences', function (Blueprint $table) {
            $table->dropColumn(array_filter(
                ['company', 'role', 'start_year', 'end_year', 'description'],
                fn($col) => Schema::hasColumn('experiences', $col)
            ));
        });

        Schema::table('tools', function (Blueprint $table) {
            if (Schema::hasColumn('tools', 'name')) $table->dropColumn('name');
        });

        Schema::table('galleries', function (Blueprint $table) {
            $table->dropColumn(array_filter(
                ['title', 'description', 'image_path'],
                fn($col) => Schema::hasColumn('galleries', $col)
            ));
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(array_filter(
                ['key', 'value'],
                fn($col) => Schema::hasColumn('settings', $col)
            ));
        });
    }
};
