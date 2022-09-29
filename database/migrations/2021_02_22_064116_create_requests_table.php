<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id()->startingValue(100000);
            $table->uuid('uuid')->index();
            $table->string('rel_id')->default('');
            $table->tinyInteger('level')->default(0);
            $table->string('type', 40);
            $table->string('mode', 40);
            $table->string('site', 10);
            $table->string('so');
            $table->string('so_status')->default('');
            $table->string('tac');
            $table->boolean('flag');
            $table->text('solutions')->default('[]');
            $table->integer('technician_id');
            $table->text('technicians')->default('[]');
            $table->bigInteger('client_id');
            $table->bigInteger('invoice_id');
            $table->smallInteger('category_id');
            $table->smallInteger('company_id');
            $table->integer('group_id')->default(0);
            $table->string('client_email');
            $table->integer('request_by');
            $table->text('followers')->default('[]');
            $table->smallInteger('sla_id');
            $table->smallInteger('priority_id');
            $table->string('status', 40);
            $table->string('name');
            $table->longText('root_cause')->default('');
            $table->longText('content');
            $table->longText('attachments')->default('[]');
            $table->boolean('hidden');

            //
            $table->string('rma_doa')->default('');
            $table->dateTime('eta')->nullable();
            //

            //
            $table->string('part_device')->default('');
            $table->string('serial_number')->default('');
            $table->string('tracking_number')->default('');
            //

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
            $table->dateTime('email_time')->nullable();
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
        Schema::dropIfExists('requests');
    }
}
