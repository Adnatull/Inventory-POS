<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('supplier_code')->unique();
            $table->string('supplier_name');
            $table->string('contact_person');
            $table->string('phone')->unique();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->decimal('dues')->default(0)->comment('Amount supplier should receive from this');
            $table->decimal('advance')->default(0)->comment('Amount this shop has payed in advanced');
            $table->boolean('status')->default('0')->comment('0 means this supllier is deactivated & vice versa');

            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('set null');

            $table->bigInteger('updated_by')->unsigned()->nullable();
            $table->foreign('updated_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('suppliers');
    }
}
