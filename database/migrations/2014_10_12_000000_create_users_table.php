<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use \Carbon\Carbon;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('secondname');
            $table->enum('sex', ['MALE', 'FEMALE']);
            $table->timestamp('birthdate');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });


        DB::table('users')->insert([
           [
               'name' => 'Рома',
               'secondname' => 'Головешкин',
               'sex' => 'MALE',
               'birthdate' => '1998-07-07',
               'email' => 'romaha@mail.ru',
               'password' => Hash::make('password'),
               'created_at' => Carbon::now(),
               'updated_at' => Carbon::now(),
           ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
