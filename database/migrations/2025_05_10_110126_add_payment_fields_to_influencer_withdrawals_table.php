<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentFieldsToInfluencerWithdrawalsTable extends Migration
{
    public function up()
    {
        Schema::table('influencer_withdrawals', function (Blueprint $table) {
            $table->string('order_id')->after('id')->nullable();
            $table->string('price_currency', 10)->after('amount')->nullable();
            $table->string('pay_currency', 20)->after('price_currency')->nullable();
            $table->string('pay_address')->after('pay_currency')->nullable();
        });
    }

    public function down()
    {
        Schema::table('influencer_withdrawals', function (Blueprint $table) {
            $table->dropColumn(['order_id', 'price_currency', 'pay_currency', 'pay_address']);
        });
    }
}
