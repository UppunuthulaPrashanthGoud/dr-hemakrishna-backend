<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use DB;

class GeneralSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('general_settings')->insert([
                'id' => 1, 
                'header_logo' => '/img/logo.png',
                'header_phone' => '987 654 3219',
                'header_email' => 'prashanth@gmail.com',
                'fb_link' => 'https://facebook.com',
                'insta_link' => 'https://instagram.com',
                'twitter_link' => 'https://twitter.com',
                'pintrest_link' => 'https://pintrest.com',
                'youtube_link' => 'https://youtube.com',
                'linkdin_link' => 'https://linkdein.com',
                'whatsapp_no' => '+919876543219',
                'footer_logo' => '/img/logo.png',
                'footer_email' => 'prashanth@gmail.com  ',
                'footer_phone' => '/img/logo.png',
                'footer_copyright' => '© 2023 Prashanth. All Rights Reserved.',
                'website_name' => 'Prashanth goud',
                'favicon' => '/img/logo.png',
            ]);
    }
}


