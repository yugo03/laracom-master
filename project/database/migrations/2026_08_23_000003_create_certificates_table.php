<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned()->unique();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->string('appraiser_name')->nullable();
            $table->string('grade')->nullable();
            $table->string('serial_number')->nullable();
            $table->date('appraised_at')->nullable();
            $table->text('notes')->nullable();
            $table->string('file')->nullable();
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
        Schema::dropIfExists('certificates');
    }
}
