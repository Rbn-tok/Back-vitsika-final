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
        Schema::create('publications', function (Blueprint $table) {
            $table->id();
            $table->string("description");
            $table->date("date_pub");

            $table->foreignId("id_region")->references("id")->on("regions")->nullable();
            $table->foreignId("id_pollution")->references("id")->on("pollutions");
            $table->foreignId("id_user")->references("id")->on("utilisateurs");
            $table->foreignId("id_tag")->references("id")->on("htags");
            $table->foreignId("id_alerte")->references("id")->on("alertes");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('publications');
    }
};
