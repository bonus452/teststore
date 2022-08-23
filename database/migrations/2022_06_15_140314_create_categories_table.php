<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('img')->nullable();
            $table->string('slug');

            $table->string('seo_title')->nullable();
            $table->string('seo_description')->nullable();
            $table->string('seo_keywords')->nullable();

            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->on('categories')->references('id')->cascadeOnDelete();

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
        Schema::dropIfExists('categories');
    }
}
