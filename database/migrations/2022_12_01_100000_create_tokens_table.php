<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTokensTable extends Migration
{

    public function up()
    {

        Schema::create("tokens", function(Blueprint $table){
            $table->id();
            $table->foreignId("user_id")->constrained();
            $table->unsignedBigInteger("service_id");
            $table->text("access_token");
            $table->text("refresh_token");
            $table->dateTime("expires_at");
            $table->timestamps();
        });

    }

    public function down()
    {

        Schema::dropIfExists("tokens");

    }

}