<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterventionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interventions', function (Blueprint $table) {
            $table->id();
            $table->string('equipement_name');
            $table->string('souseq_name')->nullable();
            $table->string('client_name');
            $table->string('type_panne');
            $table->string('description_panne')->nullable();
            $table->string('priorite');
            $table->string('mode_appel');
            $table->string('destinateur');
            $table->string('soustraitant_name')->nullable();
            $table->string('appel_client');
            $table->text('description_intervention')->nullable();
            $table->text('observation')->nullable();
            $table->datetime('date_debut')->nullable();
            $table->datetime('date_fin')->nullable();
            $table->string('etat');
            $table->string('rapport')->nullable();
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
        Schema::dropIfExists('interventions');
    }
}
