<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBackstorySchema extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('backstory_adjectives', function (Blueprint $table) {
            $table->increments('id');
            $table->string('text');

            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('backstory_nationalities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('text');

            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('backstory_skills', function (Blueprint $table) {
            $table->increments('id');
            $table->string('text');

            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('backstory_traits', function (Blueprint $table) {
            $table->increments('id');
            $table->string('text');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('backstory_adjectives');
        Schema::dropIfExists('backstory_nationalities');
        Schema::dropIfExists('backstory_skills');
        Schema::dropIfExists('backstory_traits');
    }
}
