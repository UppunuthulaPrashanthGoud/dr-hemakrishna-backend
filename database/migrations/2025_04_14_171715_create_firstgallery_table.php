<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFirstgalleryTable extends Migration
{
    public function up()
    {
        Schema::create('firstgallery', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('firstgallery');
    }
}
