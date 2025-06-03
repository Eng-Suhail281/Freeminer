<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWalletAddressToInfluencersTable extends Migration
{
    public function up()
    {
        Schema::table('influencers', function (Blueprint $table) {
            $table->string('wallet_address')->nullable()->after('promo_code'); // إضافة حقل wallet_address
        });
    }

    public function down()
    {
        Schema::table('influencers', function (Blueprint $table) {
            $table->dropColumn('wallet_address'); // إزالة الحقل في حالة التراجع
        });
    }
}
