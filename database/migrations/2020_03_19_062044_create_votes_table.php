<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('votes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('user_id')->index();
            $table->integer('comment_id')->unsigned();
            $table->tinyInteger('up')->nullable();
            $table->tinyInteger('down')->nullable();
            $table->timestamp('voted_at')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('comment_id')->references('id')->on('comments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('votes', function (Blueprint $table) {
          $table->dropForeign('votes_comment_id_foreign');
          $table->dropForeign('votes_user_id_foreign');
        });
        
        Schema::dropIfExists('votes');
    }
}
