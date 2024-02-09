<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMsMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_member', function (Blueprint $table) {
            $table->idMember();
            $table->string('name');
            $table->string('nrp')->unique();
            $table->string('email')->unique();
            $table->string('noTelp');
            $table->integer('departemen');
            $table->integer('title');
            $table->integer('role');
            $table->integer('gender');
            $table->string('deskripsi_notes');
            $table->string('created_by');
            $table->string('updated_by');
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
        Schema::dropIfExists('ms_member');
    }
}
