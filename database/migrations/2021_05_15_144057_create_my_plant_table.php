<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMyPlantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('my_plant', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('user_id');
            $table->string('plant_name',128);
            $table->decimal('price', 10, 2)->nullable();
            $table->string('main_image',32);
            $table->string('image_list',32);
            $table->integer('plant_status_id');
            $table->date('received_date')->nullable();
            $table->text('note')->nullable();
            
            $table->timestamps();

            $table->engine = 'MyISAM';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('my_plant');
    }
}
