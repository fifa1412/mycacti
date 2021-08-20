<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCloudImageDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cloud_image_details', function (Blueprint $table) {
            $table->id();
            $table->string('location');
            $table->string('img_name');
            $table->string('thumbnail_img_name');
            $table->datetime('date_taken');
            $table->string('img_cloud_path');
            $table->string('thumbnail_img_cloud_path');
            $table->boolean('is_available');
            $table->boolean('is_deleted');

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
        Schema::dropIfExists('cloud_image_details');
    }
}
