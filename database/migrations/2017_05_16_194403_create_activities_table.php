<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("activities", function (Blueprint $table) {
            $table->increments("id");
            $table->string("name");
            $table->timestamp("start")->nullable();
            $table->timestamp("end")->nullable();

            $table->timestamps();

            $table->integer("category_id")->unsigned()->nullable();
            $table->foreign("category_id")
                  ->references("id")
                  ->on("categories")
                  ->onDelete("set null");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("activities");
    }
}
