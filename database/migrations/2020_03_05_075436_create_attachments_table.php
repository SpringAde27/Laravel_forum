<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attachments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('article_id')->nullable()->unsigned()->index();
            $table->string('filename');
            $table->integer('bytes')->nullable()->unsigned();
            $table->string('mime')->nullable();
            $table->timestamps();

            // $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');

            // 테이블 간의 관계와 모델 간의 관계는 별개.
            // 테이블에 외래 키 연결이 없어도 모델 간의 관계 연결 가능.
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('attachments', function (Blueprint $table) {
        //     $table->dropForeign('attachments_article_id_foreign');
        // });
        
        Schema::dropIfExists('attachments');
    }
}
