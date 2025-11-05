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
        Schema::create('guests', function (Blueprint $table) {
            $table->id();

            // Foreign key for the user who is the guest
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Foreign key for the party they are attending
            $table->foreignId('party_id')->constrained('parties')->onDelete('cascade');
            
            $table->string('status')->default('pending'); // e.g., pending, accepted, declined
            
            $table->timestamps();

            // Add a unique constraint to prevent a user from being
            // added to the same party more than once.
            $table->unique(['user_id', 'party_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guests');
    }
};