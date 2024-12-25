<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('skillsNeeded')->nullable();
            $table->enum('status', ['archived', 'active'])->default('active');
            $table->foreignId('categoryId')->constrained('categories')->onDelete('cascade'); // References categories.id
            $table->foreignId('userId')->constrained('users')->onDelete('cascade'); // References categories.id
            $table->integer('amount')->nullable();
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
        Schema::dropIfExists('projects');
    }
}
