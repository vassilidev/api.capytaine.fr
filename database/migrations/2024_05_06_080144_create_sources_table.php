<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sources', static function (Blueprint $table) {
            $table->uuid('id')->index();
            $table->string('name');
            $table->string('url');
            $table->string('logo');
            $table->longText('description')->nullable();
            $table->string('rss');
            $table->dateTime('last_extracted_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sources');
    }
};
