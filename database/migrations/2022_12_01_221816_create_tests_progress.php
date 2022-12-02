<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tests_progress', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user');
            $table->bigInteger('test');
            $table->text('answers'); // answer1&answer1&answer1&
            $table->enum('status', ['TO CHECK', 'CHECKING', 'CHECKED'])->default('TO CHECK');
            $table->smallInteger('mark')->default(0);
            $table->string('comment')->default('');
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
        Schema::dropIfExists('tests_progress');
    }
};
