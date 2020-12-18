<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('data_points', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("data_point");
            $table->string("entity");
            $table->string("parent_entity");
            $table->string("responsible_role", 512)->nullable();
            $table->string("dw_server")->nullable();
            $table->string("dw_database")->nullable();
            $table->string("table_name")->nullable();
            $table->string("dw_field_name")->nullable();
            $table->string("data_type")->nullable();
            $table->string("source")->nullable();
            $table->string("read_write")->nullable();
            $table->string("definition_stakeholder")->nullable();
            $table->string("ongoing_definition_owner")->nullable();
            $table->string("owner")->nullable();
            $table->unique(['data_point', 'entity', 'parent_entity'], 'data_point_unique_key');
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
        Schema::dropIfExists('data_points');
    }
}
