<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateClient extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('document_types', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string("name", 30)->nullable(false);
        });

        DB::table('document_types')->insert([
            ["id" => 1, "name" => "Cédula de Ciudadanía"],
            ["id" => 2, "name" => "Tarjeta de identidad"],
        ]);

        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string("first_name", 20)->nullable(false);
            $table->string("second_name", 20)->nullable(true)->default(NULL);
            $table->string("first_lastname", 20)->nullable(false);
            $table->string("second_lastname", 20)->nullable(false);
            $table->tinyInteger("document_id");
            $table->foreign("document_id")->references("id")->on("document_types");
            //Softdeletes
            $table->softDeletes();
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
        Schema::dropIfExists('client');
    }
}
