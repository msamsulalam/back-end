<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataDefinitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_definitions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('data_point_id');
            $table->foreign('data_point_id')->references('id')->on('data_points')->onDelete('cascade');
            $table->string("entity");
            $table->string("parent_entity");
            $table->string("data_point_definition")->nullable();
            $table->string("look_up_values")->nullable();
            $table->string("look_up_value_definitions", 512)->nullable();
            $table->unique(['data_point_id', 'entity', 'parent_entity', 'look_up_values'],'data_definition_unique_key');
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
        Schema::dropIfExists('data_definitions');
    }
}
