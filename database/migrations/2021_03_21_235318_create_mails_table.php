<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mails', function (Blueprint $table) {
            $table->id();
            $table->string('type', 40);
            $table->bigInteger('rel_id')->default(0);
            $table->string('name');
            $table->longText('content');
            $table->string('from');
            $table->text('to');
            $table->text('cc')->default('[]');
            $table->boolean('sent');
            $table->longText('attachments')->default('[]');
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
        Schema::dropIfExists('mails');
    }
}
