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
        Schema::create('alertes', function (Blueprint $table) {
            $table->id();
            $table->string("observation");
            
            $table->foreignId('id_user')->references("id")->on("utilisateurs");
            $table->foreignId('id_region')->references("id")->on("regions");
            $table->foreignId('id_niveau')->references("id")->on("niv_alertes");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alertes');
    }
};
