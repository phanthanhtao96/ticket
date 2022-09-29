<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('admin')->default(0);
            $table->smallInteger('role_id');
            $table->smallInteger('company_id');
            $table->text('region');
            $table->smallInteger('department_id');
            $table->text('groups');
            $table->string('name');
            $table->string('job_title');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('image');
            $table->string('phone', 15);
            $table->text('options');
            $table->timestamp('email_verified_at')->nullable();
            $table->text('notes');
            $table->tinyInteger('disable');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
