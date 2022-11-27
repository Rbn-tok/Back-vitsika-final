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
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string("type");
            $table->string("chemin")->nullable();
            
            $table->foreignId("id_pub")->references("id")->on("publications")->nullable();
            $table->foreignId("id_alerte")->references("id")->on("alertes")->nullable();
            $table->foreignId("id_tag")->references("id")->on("htags")->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media');
    }
};
