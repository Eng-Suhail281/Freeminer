<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('promo_codes', function (Blueprint $table) {
            $table->unsignedBigInteger('influencer_id')->nullable()->after('id');

            $table->foreign('influencer_id')
                  ->references('id')->on('influencers')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('promo_codes', function (Blueprint $table) {
            $table->dropForeign(['influencer_id']);
            $table->dropColumn('influencer_id');
        });
    }
};
