<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Ramsey\Uuid\v1;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->String('type');
            $table->integer('status');
            $table->text('title');
            $table->text('titlePlain')->nullable();
            $table->longText('content');
            $table->String('featuredImage')->nullable();
            $table->text('videoURL')->nullable();
            $table->integer('category_id');
            $table->integer('author_id');
            $table->integer('attachment_id')->nullable();
            $table->integer('views')->default(0);
            $table->integer('answers')->default(0);
            $table->String('commentStatus')->nullable();
            $table->String('share')->nullable();
            $table->boolean('favorite')->default(0);
            $table->boolean('polled')->default(0);
            $table->boolean('imagePolled')->default(0);
            $table->text('pollTitle')->nullable();
            $table->String('custom_field_id')->nullable();
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
        Schema::dropIfExists('questions');
    }
}
