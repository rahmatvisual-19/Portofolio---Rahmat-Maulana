<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel Showcase Projects
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('company');
            $table->string('category'); // design atau dev
            $table->text('description');
            $table->string('image_path');
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        // Tabel Selected Clients
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('logo_path')->nullable();
            $table->timestamps();
        });

        // Tabel Story (About Me)
        Schema::create('stories', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('content');
            $table->string('image_path');
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        // Tabel Experience
        Schema::create('experiences', function (Blueprint $table) {
            $table->id();
            $table->string('company');
            $table->string('role');
            $table->string('start_year');
            $table->string('end_year')->default('Present');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Tabel Tools
        Schema::create('tools', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        // Tabel Gallery
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('image_path');
            $table->timestamps();
        });

        // Tabel Settings (LinkedIn, Resume, CV)
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // linkedin_url, resume_path, cv_path
            $table->text('value')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
        Schema::dropIfExists('galleries');
        Schema::dropIfExists('tools');
        Schema::dropIfExists('experiences');
        Schema::dropIfExists('stories');
        Schema::dropIfExists('clients');
        Schema::dropIfExists('projects');
    }
};
