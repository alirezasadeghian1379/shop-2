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
        Schema::create('whats_app_messages', function (Blueprint $table) {
            $table->id();
            $table->string('message_id')->nullable()->unique();
            $table->string('phone', 32)->index();
            $table->enum('direction', ['incoming', 'outgoing'])->index();
            $table->text('message');
            $table->string('source', 20)->default('customer');
            $table->string('media_type', 20)->nullable();
            $table->string('media_mime', 100)->nullable();
            $table->string('media_name')->nullable();
            $table->timestamp('sent_at')->nullable()->index();
            $table->timestamps();
            $table->index(['phone', 'sent_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('whats_app_messages');
    }
};
