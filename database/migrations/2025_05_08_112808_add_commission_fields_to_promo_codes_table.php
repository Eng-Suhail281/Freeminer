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
    Schema::table('promo_codes', function (Blueprint $table) {
        $table->decimal('commission_withdrawn', 10, 2)->default(0);
        $table->decimal('commission_available', 10, 2)->default(0);
    });
}

public function down()
{
    Schema::table('promo_codes', function (Blueprint $table) {
        $table->dropColumn(['commission_withdrawn', 'commission_available']);
    });
}

};
