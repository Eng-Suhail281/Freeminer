<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        
        Schema::create('promo_codes', function (Blueprint $table) {
            $table->id();
    $table->string('code')->unique();
    $table->string('description')->nullable(); // مثل "كود مؤثر X على تيك توك"
    $table->unsignedInteger('total_users')->default(0);
    $table->unsignedInteger('total_deposit_users')->default(0);
    $table->decimal('total_deposit_amount', 10, 2)->default(0);
    $table->decimal('reward', 8, 2)->default(1000);
        $table->decimal('commission', 5, 2)->default(0.10);
        $table->string('influencer_name')->nullable();
    $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promo_codes');
    }
};
