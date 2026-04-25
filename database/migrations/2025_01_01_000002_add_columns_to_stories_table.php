<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stories', function (Blueprint $table) {
            $table->text('content')->after('id');
            $table->string('image_path')->after('content');
            $table->integer('order')->default(0)->after('image_path');
        });
    }

    public function down(): void
    {
        Schema::table('stories', function (Blueprint $table) {
            $table->dropColumn(['content', 'image_path', 'order']);
        });
    }
};
