<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
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
            $table->string("username");
            $table->string("email");
            $table->string("password");
            $table->string("firstName");
            $table->string("lastName");
            $table->string("frontIdPic");
            $table->string("backIdPic");
            $table->enum('userStatus', ['verified', 'notVerified'])->default('notVerified');
            $table->enum('registrationStatus', ['accepted', 'pending'])->default('pending');
            $table->string("CV");
            $table->text("bio")->nullable();
            $table->string("linkedinURL")->nullable();
            $table->string("skills")->nullable();
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
        Schema::dropIfExists('users');
    }
}
