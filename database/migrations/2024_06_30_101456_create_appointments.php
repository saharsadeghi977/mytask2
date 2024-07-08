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
      Schema::create('appointments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('date_id')->constrained()->cascadeOnDelete();
        $table->string('time');
        $table->enum('type',['null','past','notnull'])->default('null');
        $table->timestamps();
        

    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
