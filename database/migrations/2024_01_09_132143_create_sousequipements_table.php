<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSousequipementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sousequipements', function (Blueprint $table) {
            $table->id();
            $table->string('identifiant')->unique();
            $table->string('designation');
            $table->string('marque')->nullable();
            $table->string('modele')->nulllable();
            $table->string('description')->nulllable();
            $table->foreignId('equipement_id')->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('sousequipements');
    }
}
