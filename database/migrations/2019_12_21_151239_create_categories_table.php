<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->text('image');
            $table->tinyInteger('status')->default('1')->comment('1=active, 0=inactive');

            $table->bigInteger('parent_id')->unsigned()->nullable();
//            $table->foreign('parent_id')->references('id')->on('categories');//->onUpdate('cascade')->onDelete('cascade');

            $table->bigInteger('created_by')->unsigned();
//            $table->foreign('created_by')->references('id')->on('users');
//

            $table->bigInteger('updated_by')->unsigned();
        //    $table->foreign('updated_by')->references('id')->on('users');
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
        Schema::dropIfExists('categories');
    }
}
