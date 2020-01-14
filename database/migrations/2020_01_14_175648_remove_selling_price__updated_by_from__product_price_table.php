<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveSellingPriceUpdatedByFromProductPriceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product__prices', function (Blueprint $table) {
            $table->dropColumn('selling_cost');
          //  Schema::disableForeignKeyConstraints();
            $table->dropForeign('product__prices_updated_by_foreign');
            $table->dropColumn('updated_by');
          //  Schema::enableForeignKeyConstraints();
            $table->decimal('selling_price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product__prices', function (Blueprint $table) {
            $table->decimal('selling_cost');
            $table->bigInteger('updated_by')->unsigned()->nullable();;
            $table->foreign('updated_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('set null');
            $table->dropColumn('selling_price');
        });
    }
}
