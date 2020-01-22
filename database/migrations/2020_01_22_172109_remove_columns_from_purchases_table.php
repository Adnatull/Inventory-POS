<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveColumnsFromPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->dropForeign('purchases_product_id_foreign');
            $table->dropColumn('product_id');

            $table->dropColumn('purchase_cost');
            $table->dropColumn('quantity');

            $table->decimal('total_purchases_cost', 18, 3)->default(0);
            $table->decimal('total_paid', 18, 3)->default(0);
            $table->decimal('discount', 18, 3)->default(0);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchases', function (Blueprint $table) {
          $table->bigInteger('product_id')->unsigned()->nullable();
          $table->foreign('product_id')->references('id')->on('products')->onUpdate('cascade')->onDelete('set null');
          $table->integer('quantity');
          $table->decimal('purchase_cost');

          $table->dropColumn('total_purchases_cost');
          $table->dropColumn('total_paid');
          $table->dropColumn('discount');
        });
    }
}
