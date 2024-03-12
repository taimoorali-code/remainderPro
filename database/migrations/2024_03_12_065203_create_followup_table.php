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
        Schema::create('followup', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Add 'name' column
            $table->string('phone'); // Add 'phone' column
            $table->string('address'); // Add 'address' column
            $table->text('note')->nullable(); // Add 'note' column (nullable)
            $table->string('status'); // Add 'status' column
            $table->date('follow_date'); // Add 'follow_date' column
            $table->string('country'); // Add 'country' column
            $table->string('state'); // Add 'state' column
            $table->string('city'); // Add 'city' column
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('followup');
    }
};
