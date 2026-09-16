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
        Schema::create('storages', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->enum('type',\App\Enums\Gallery\StorageTypeEnum::getTypes());
            $table->string('path')->nullable();
            $table->integer('item_id')->nullable();
            $table->boolean('registered')->default(false);
            $table->timestamps();
            $table->index(['item_id', 'type', 'created_at'], 'storages_item_type_created_at_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('storages');
    }
};
