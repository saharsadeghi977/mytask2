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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('qrcode_id')->constrained()->cascadeOnDelete();
            $table->datetime('order-date');
            $table->enum('stastus',['canceled','delivered','sent','Processing']);
            $table->decimal('number');
            $table->decimal('total_amount',10,2);
            $table->timestamps();
        });
    

    }


    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
