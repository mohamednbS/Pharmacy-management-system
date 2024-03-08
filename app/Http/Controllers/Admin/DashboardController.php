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
        $title = 'Tableau de Bord';
        $intervention_cloture = Intervention::whereIn('etat', ['Clôturé', 'Clôturé à distance'])->count();
        $intervention_non_cloture = Intervention::where('etat','!=','Clôturé')->count();
        $all_contrats = Contrat::count();
        $all_equipements = Equipement::count();



        $pieChart = app()->chartjs
                ->name('pieChart')
                ->type('pie')
                ->size(['width' => 400, 'height' => 200])
                ->labels(['Intervention Clôturé', 'Intervention non Clôturé'])
                ->datasets([
                    [
                        'backgroundColor' => ['#FF6384', '#36A2EB','#7bb13c'],
                        'hoverBackgroundColor' => ['#FF6384', '#36A2EB','#7bb13c'],
                        'data' => [$intervention_cloture, $intervention_non_cloture]
                    ]
                ])
                ->options([]);

                $all_clients = Client::count();
        return view('admin.dashboard',compact(
            'title','pieChart','all_contrats','all_equipements','all_clients'
        ));
    }
}
