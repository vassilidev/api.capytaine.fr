<?php

use App\Enums\Scraper\Method;
use App\Models\Connector;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('scrapers', static function (Blueprint $table) {
            $table->uuid('id')->index();
            $table->string('name');
            $table->foreignIdFor(Connector::class)
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->longText('description')->nullable();
            $table->string('method')->default(Method::GET->value);
            $table->string('type')->default(Method::GET->value);
            $table->text('url');
            $table->json('headers')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scrapers');
    }
};
