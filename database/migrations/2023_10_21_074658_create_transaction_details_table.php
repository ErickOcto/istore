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
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->id();

            $table->foreignId('transaction_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->integer('price');
            $table->enum('transaction_status', ['Pending', 'Shipping', 'Success', 'Failed']);
            $table->string('resi');
            $table->string('code');
            $table->string('shipping_status');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_details');
    }
};
