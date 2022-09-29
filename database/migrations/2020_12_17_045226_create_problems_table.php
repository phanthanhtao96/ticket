<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProblemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('problems', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('level')->default(0);
            $table->string('site', 10);
            $table->boolean('flag');
            $table->text('requests')->default('[]');
            $table->text('solutions')->default('[]');
            $table->smallInteger('company_id');
            $table->integer('group_id')->default(0);
            $table->integer('technician_id');
            $table->smallInteger('category_id');
            $table->integer('request_by');
            $table->smallInteger('sla_id');
            $table->smallInteger('priority_id');
            $table->string('status', 40);
            $table->string('name');
            $table->longText('root_cause')->default('');
            $table->longText('content');
            $table->text('attachments')->default('[]');
            $table->boolean('hidden');

            //
            $table->integer('response_time_estimate')->default(0);
            $table->dateTime('response_time_estimate_datetime')->nullable();
            $table->integer('response_time')->default(0);
            $table->dateTime('response_time_datetime')->nullable();
            $table->integer('response_time_late')->default(0);
            $table->text('late_response_reason')->default('');
            //

            //
            $table->integer('resolve_time_estimate')->default(0);
            $table->dateTime('resolve_time_estimate_datetime')->nullable();
            $table->integer('resolve_time')->default(0);
            $table->dateTime('resolve_time_datetime')->nullable();
            $table->integer('resolve_time_late')->default(0);
            $table->text('late_resolve_reason')->default('');
            //

            $table->boolean('overdue_status')->default(0);

            //
            $table->integer('pending_time')->default(0);
            $table->text('pending_reason')->default('');
            //

            $table->dateTime('active_date')->nullable();
            $table->dateTime('last_reply')->nullable();
            $table->dateTime('due_by_date')->nullable();
            $table->dateTime('closed_date')->nullable();
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
        Schema::dropIfExists('problems');
    }
}
