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
        Schema::create('parties', function (Blueprint $table) {
            $table->id();

            // This is the foreign key linking to the 'id' on the 'users' table.
            // It represents the user who is hosting the party.
            $table->foreignId('host_id')->constrained('users')->onDelete('cascade');

            $table->string('name');
            $table->text('description')->nullable();
            $table->dateTime('party_date');
            $table->string('location');

            $table->timestamps(); // Adds 'created_at' and 'updated_at' columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parties');
    }
};
