<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_settings', function (Blueprint $table) {
            $table->id();
            $table->string("header_logo")->nullable();
            $table->string("header_phone")->nullable();
            $table->string("header_email")->nullable();
            $table->string("fb_link")->nullable();
            $table->string("insta_link")->nullable();
            $table->string("twitter_link")->nullable();
            $table->string("pintrest_link")->nullable();
            $table->string("youtube_link")->nullable();
            $table->string("linkdin_link")->nullable();
            $table->string("whatsapp_no")->nullable();
            $table->string("footer_logo")->nullable();
            $table->string("footer_email")->nullable();
            $table->string("footer_phone")->nullable();
            $table->string("footer_copyright")->nullable();
            $table->string("website_name")->nullable();
            $table->string('favicon')->nullable();
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
        Schema::dropIfExists('general_settings');
    }
};
