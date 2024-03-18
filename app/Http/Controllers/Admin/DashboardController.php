<?php

namespace App\Http\Controllers\Admin;

use App\Models\Contrat;
use App\Models\Equipement;
use App\Models\Client;
use App\Models\Modalite;
use App\Models\Intervention;
use App\Models\Etat;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(){
        $title = 'dashboard';
        $intervention_cloture = Intervention::whereIn('etat', ['Cloturé', 'Cloturé à distance','Cloturé par téléphone'])->count();
        $intervention_non_cloture = Intervention::whereNotIn('etat', ['Cloturé', 'Cloturé par téléphone', 'Cloturé à distance'])->count();
        $all_contrats = Contrat::count();
        $all_equipements = Equipement::count();
        $all_clients = Client::count();



        $pieChart_interventions = app()->chartjs
                ->name('pieChart_interventions')
                ->type('pie')
                ->size(['width' => 400, 'height' => 200])
                ->labels(['Intervention Cloturé', 'Intervention non Cloturé'])
                ->datasets([
                    [
                        'backgroundColor' => ['#FF6384', '#36A2EB','#7bb13c'],
                        'hoverBackgroundColor' => ['#FF6384', '#36A2EB','#7bb13c'],
                        'data' => [$intervention_cloture, $intervention_non_cloture]
                    ]
                ])
                ->options([]);

        $contrats_encours = Contrat::whereIn('status', ['En cours'])->count();
        $contrats_expire = Contrat::whereNotIn('status', ['En cours'])->count();
        $pieChart_contrats = app()->chartjs
        ->name('pieChart_contrats')
        ->type('pie')
        ->size(['width' => 400, 'height' => 200])
        ->labels(['contrats en cours', 'Contrats proche d'.'.'.'expiration'])
        ->datasets([
            [
                'backgroundColor' => ['#7bb13c', '#36A2EB'],
                'hoverBackgroundColor' => ['#7bb13c', '#36A2EB'],
                'data' => [$contrats_encours, $contrats_expire]
            ]
        ])
        ->options([]);


        return view('admin.dashboard',compact(
            'title','pieChart_interventions','pieChart_contrats','all_contrats','all_equipements','all_clients'
        ));
    }
}

