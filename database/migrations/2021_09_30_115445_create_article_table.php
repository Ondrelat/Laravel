<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('type');
            $table->string('etat');
            $table->boolean('baseArticle');
            $table->string('image')->nullable();
            $table->text('content');
            $table->foreignId('user_id');
            $table->integer('vote_up');
            $table->integer('vote_down');
            $table->integer('rank');
            $table->integer('score');
            $table->timestamps();
            $table->timestamp('published_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
