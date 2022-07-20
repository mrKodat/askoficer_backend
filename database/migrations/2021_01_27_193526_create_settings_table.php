<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->longText('fcm_key')->nullable();
            $table->longText('about_us')->nullable();
            $table->longText('privacy_policy')->nullable();
            $table->longText('terms_and_conditions')->nullable();
            $table->longText('faq')->nullable();
            $table->longText('contact_us')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
