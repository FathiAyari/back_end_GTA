<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plannings', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id");
            $table->foreignId("activity_id")->constrained()
                ->onDelete('cascade');
            $table->dateTime("start_time");
            $table->string("note");
            $table->dateTime("end_time");
            $table->dateTime("real_end_time")->nullable();
            $table->dateTime("real_start_time")->nullable();
            $table->integer("status")->default(0);
            $table->string("created");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plannings');
    }
}
