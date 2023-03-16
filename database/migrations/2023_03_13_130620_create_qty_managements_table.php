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
        Schema::create('qty_managements', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('material_id')->unsigned();
            $table->foreign('material_id')->references('id')->on('materials')->onDelete('cascade');
            $table->date('date');
            $table->smallInteger('qty');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('qty_managements');
    }
};
