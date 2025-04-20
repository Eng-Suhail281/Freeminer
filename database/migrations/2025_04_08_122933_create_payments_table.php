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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
$table->unsignedBigInteger('user_id')->nullable();
$table->string('telegram_id')->nullable();
$table->decimal('amount', 10, 2);
$table->string('method');
$table->enum('status', ['pending', 'completed'])->default('pending');
$table->timestamp('payment_deadline')->nullable();
$table->string('order_id')->nullable();
$table->timestamps();

$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
