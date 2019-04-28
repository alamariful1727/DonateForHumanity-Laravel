<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->bigIncrements('cid');
            $table->integer('user_id');
            $table->string('title')->unique();
            $table->string('c_desc');
            $table->string('c_image');
            $table->integer('c_budget');
            $table->integer('c_balance');
            $table->integer('duration');
            $table->string('starts');
            $table->string('ends');
            $table->string('c_status');
            $table->string('c_url');
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
        Schema::dropIfExists('campaigns');
    }
}
