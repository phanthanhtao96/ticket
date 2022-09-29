<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('replies', function (Blueprint $table) {
            $table->id();
            $table->string('type', 40);
            $table->bigInteger('rel_id');
            $table->string('rel_mail_id')->default('');
            $table->string('replier_type', 40);
            $table->bigInteger('replier_id');
            $table->string('replier_name');
            $table->string('name')->default('');
            $table->longText('content');
            $table->boolean('sent_mail');
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
        Schema::dropIfExists('replies');
    }
}
