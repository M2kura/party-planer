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
        Schema::create('items', function (Blueprint $table) {
            $table->id();

            // Foreign key for the party this item belongs to
            $table->foreignId('party_id')->constrained('parties')->onDelete('cascade');
            
            $table->string('name');
            $table->integer('quantity')->default(1);
            
            // We can add this later if we want guests to "claim" items
            // $table->foreignId('guest_id')->nullable()->constrained('guests');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};