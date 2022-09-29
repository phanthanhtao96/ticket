<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('type', 40)->default('');
            $table->string('email')->unique();
            $table->string('name')->default('');
            $table->string('company_name')->default('');
            $table->string('phone', 15)->default('');
            $table->string('postcode')->default('');
            $table->string('tax_code')->default('');
            $table->string('identification_number')->default('');
            $table->string('country', 40)->default('');
            $table->string('city', 40)->default('');
            $table->string('state', 40)->default('');
            $table->string('address')->default('');
            $table->text('notes')->default('');
            $table->boolean('disable')->default(0);
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
        Schema::dropIfExists('clients');
    }
}
