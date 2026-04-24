<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stories', function (Blueprint $table) {
            $table->string('title')->nullable()->after('id');
            $table->text('content')->after('title');
            $table->string('image_path')->after('content');
            $table->integer('order')->default(0)->after('image_path');
        });
    }

    public function down(): void
    {
        Schema::table('stories', function (Blueprint $table) {
            $table->dropColumn(['title', 'content', 'image_path', 'order']);
        });
    }
};
