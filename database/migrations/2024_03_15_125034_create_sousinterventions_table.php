<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSousinterventionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sousinterventions', function (Blueprint $table) {
            $table->id();
            $table->datetime('date_debut');
            $table->datetime('date_fin')->nullable();
            $table->string('etat_initial')->nullable();
            $table->string('etat_final')->nullable();
            $table->string('intervenant');
            $table->string('description_panne');
            $table->string('description_sousintervention')->nullable();
            $table->foreignId('intervention_id')->constrained()->onDelete('cascade');
            $table->string('rapport')->nullable();
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
        Schema::dropIfExists('sousinterventions');
    }
}
