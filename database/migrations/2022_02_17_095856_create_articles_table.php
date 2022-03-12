<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->default('')->comment('标题');
            $table->tinyInteger('type')->comment('分类');
            $table->string('image')->nullable()->comment('封面图');
            $table->date('published_at')->nullable()->comment('发布时间');
            $table->text('content')->comment('内容详情');
            $table->text('files')->nullable()->comment('附件');
            $table->tinyInteger('status')->comment('状态');
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
        Schema::dropIfExists('articles');
    }
}
