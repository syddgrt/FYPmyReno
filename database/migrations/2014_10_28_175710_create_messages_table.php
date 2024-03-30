<?php

use Cmgmyr\Messenger\Models\Models;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Models::table('messages'), function (Blueprint $table) {
            $table->increments('id');
            $table->integer('thread_id')->unsigned()->nullable(); // Make thread_id nullable
            $table->integer('user_id')->unsigned();
            $table->unsignedBigInteger('recipient_id');
            $table->text('body');
            $table->timestamps();
        });

        // After creating the recipient_id column, specify the order using the 'after' method
        Schema::table(Models::table('messages'), function (Blueprint $table) {
            $table->foreign('recipient_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['thread_id', 'user_id', 'recipient_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Models::table('messages'));
    }
}


