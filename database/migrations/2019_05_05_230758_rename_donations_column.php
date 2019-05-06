<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameDonationsColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->renameColumn('created_at', 'd_created_at');
            $table->renameColumn('updated_at', 'd_updated_at');
            // $table->renameColumn('campaign_id', 'campaigns_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->renameColumn('d_created_at', 'created_at');
            $table->renameColumn('d_updated_at', 'updated_at');
            // $table->renameColumn('campaigns_id', 'campaign_id');
        });
    }
}
