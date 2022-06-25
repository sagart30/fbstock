<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_details', function (Blueprint $table) {
            $table->id();
            $table->char('symbol', 20);
            $table->double('open', 15, 4);
            $table->double('high', 15, 4);
            $table->double('low', 15, 4);
            $table->double('price', 15, 4);
            $table->integer('volume');
            $table->date('latest_trading_day');
            $table->double('previous_close', 15, 4);
            $table->double('change', 15, 4);
            $table->string('change_percent');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_details');
    }
};
