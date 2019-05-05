<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameTransactionsColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->renameColumn('created_at', 't_created_at');
            $table->renameColumn('updated_at', 't_approved_at');
            $table->renameColumn('to', 'user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->renameColumn('t_created_at', 'created_at');
            $table->renameColumn('t_approved_at', 'updated_at');
            $table->renameColumn('user_id', 'to');
        });
    }
}
