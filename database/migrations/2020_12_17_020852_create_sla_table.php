<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSLATable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sla', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->smallInteger('priority_id')->default(0);
            $table->string('name');
            $table->text('description');
            $table->integer('max_response_time');
            $table->integer('max_resolve_time');
            $table->text('enable_levels')->default('[]');
            $table->integer('time_to_l2');
            $table->integer('time_to_l3');
            $table->integer('time_to_l4');
            $table->mediumText('response_data')->default('[]');
            $table->mediumText('l2_data')->default('[]');
            $table->mediumText('l3_data')->default('[]');
            $table->mediumText('l4_data')->default('[]');
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
        Schema::dropIfExists('priorities');
    }
}
