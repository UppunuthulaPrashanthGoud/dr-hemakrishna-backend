<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagegalleryTable extends Migration
{
    public function up()
    {
        Schema::create('imagegallery', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('imagegallery');
    }
}
