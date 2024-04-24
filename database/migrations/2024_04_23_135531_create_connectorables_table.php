<?php

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
        Schema::create('connectorables', static function (Blueprint $table) {
            $table->foreignIdFor(Connector::class)
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->uuidMorphs('connectorable');

            $table->unique(['connector_id', 'connectorable_id', 'connectorable_type'], 'connectorables_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('connectorables');
    }
};
