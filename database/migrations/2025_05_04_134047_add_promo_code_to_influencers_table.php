<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('influencers', function (Blueprint $table) {
        $table->string('promo_code')->nullable()->after('email');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('influencers', function (Blueprint $table) {
            //
        });
    }
};
