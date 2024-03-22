<?php

namespace App\Http\Controllers\Admin;

use App\Models\Intervention;
use App\Models\Equipement;
use App\Models\Sousequipement;
use App\Models\Client;
use App\Models\User;
use App\Models\Etat;
use App\Models\Soustraitant;
use App\Models\Sousintervention;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use QCod\AppSettings\Setting\AppSettings;

class InterventionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = 'interventions';
        if($request->ajax()){
            $interventions = Intervention::get();
            return DataTables::of($interventions)

                ->addColumn('etat',function($intervention){
                    return '<a href="'.route("interventions.show", $intervention->id).'">'. $intervention->etat .'</a>';
                })
                ->addColumn('client',function($intervention){
                    if(!empty($intervention->client)){
                        return $intervention->client->name;
                    }
                })
                ->addColumn('equipement',function($intervention){
                    if(!empty($intervention->equipement)){
                        return $intervention->equipement->modele;
                    }
                })
                ->addColumn('etat_initial',function($intervention){
                    return $intervention->etat_initial;
                })
                ->addColumn('destinateur',function($intervention){
                    if (is_array($intervention->destinateur)) {
                        return implode(', ', $intervention->destinateur);
                    }
                    return $intervention->destinateur;
                })
                ->addColumn('soustraitant',function($intervention){
                    if(!empty($intervention->soustraitant)){
                        return $intervention->soustraitant->name;
                    }
                })
                ->addColumn('sousequipement',function($intervention){
                    if(!empty($intervention->sousequipement)){
                        return $intervention->sousequipement->designation;
                    }
                })
                ->addColumn('appel_client',function($intervention){
                    return $intervention->appel_client;
                })
                ->addColumn('type_intervention',function($intervention){
                    return $intervention->type_intervention;
                })
                ->addColumn('action', function ($row) {
                    $editbtn = '<a href="'.route("interventions.edit", $row->id).'" class="editbtn"><button class="btn btn-primary" title="Modifier"><i class="fas fa-edit"></i></button></a>';
                    $viewbtn = '<a href="'.route("interventions.show", $row->id).'" class="viewbtn"><button class="btn btn-success" title="Voir"><i class="fas fa-eye"></i></button></a>';
                    $deletebtn = '<a data-id="'.$row->id.'" data-route="'.route('interventions.destroy',$row->id).'" href="javascript:void(0)" id="deletebtn"><button class="btn btn-danger" title="Supprimer"><i class="fas fa-trash"></i></button></a>';
                    if ($row->trashed()) {
                        $deletebtn = ''; // Or you can show a restore button
                    }
                    if (!auth()->user()->hasPermissionTo('edit-intervention')) {
                        $editbtn = '';
                    }
                    if (!auth()->user()->hasPermissionTo('destroy-intervention')) {
                        $deletebtn = '';
                    }
                    if (!auth()->user()->hasPermissionTo('view-intervention')) {
                        $viewbtn = '';
                    }
                    $btn = $editbtn.' '.$deletebtn.' '.$viewbtn;
                    return $btn;
                })
                ->rawColumns(['etat','action'])
                ->make(true);
        }
        return view('admin.interventions.index',compact(
            'title'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'ajouter intervention';
        $equipements= Equipement::get();
        $clients = Client::get();
        $etats = Etat::get();
        $soustraitants = Soustraitant::get();
        $users = User::whereIn('role', ['technicien', 'ingenieur','administrateur'])->get();
        $sousequipements = Sousequipement::get();
        return view('admin.interventions.create',compact(
            'title','equipements','clients','users','etats','sousequipements','soustraitants'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'client'=>'required',
            'equipement'=>'required',
            'mode_appel'=>'required',
            'appel_client'=>'required',
            'sousequipement_id' => 'nullable|integer',
            'soutraitant_id' => 'nullable|integer',

        ]);

        Intervention::create([
            'client_id'=>$request->client,
            'equipement_id'=>$request->equipement,
            'sousequipement_id'=>$request->equipement,
            'etat_initial'=>$request->etat_initial,
            'description_panne'=>$request->description_panne,
            'priorite'=>$request->priorite,
            'mode_appel'=>$request->mode_appel,
            'destinateur'=> $request->destinateur,
            'soustraitant_id'=>$request->soustraitant_id,
            'appel_client'=>$request->appel_client,
            'date_debut'=>$request->date_debut,
            'etat'=>$request->etat,
        ]);
        $notifications = notify("Intervention ajoutée avec succès");
        return redirect()->route('interventions.index')->with($notifications);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \app\Models\Intervention $purchase
     * @return \Illuminate\Http\Response
     */
    public function edit(Intervention $intervention)
    {
        $title = 'modifier intervention';
        $equipements= Equipement::get();
        $clients = Client::get();
        $users = User::whereIn('role', ['technicien', 'ingenieur','administrateur'])->get();
        $etats = Etat::get();
        $soustraitants = Soustraitant::get();
        $sousequipements = Sousequipement::get();
        return view('admin.interventions.edit',compact(
            'title','equipements','clients','users','etats','sousequipements','intervention','soustraitants'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \app\Models\Intervention $purchase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Intervention $intervention)
    {
        $this->validate($request,[
            'equipement'=>'required',
            'client'=>'required',
            'mode_appel'=>'required',
            'appel_client'=>'required',
            'sousequipement_id' => 'nullable|integer',
            'soutraitant_id' => 'nullable|integer',

        ]);
        $rapportName = null;
        if($request->hasFile('rapport')){
            $rapportName = time().'.'.$request->rapport->extension();
            $request->rapport->move(public_path('storage/interventions'), $rapportName);
        }
        $intervention->update([
            'client_id'=>$request->client,
            'equipement_id'=>$request->equipement,
            'sousequipement_id'=>$request->equipement,
            'etat_initial'=>$request->etat_initial,
            'desciption_panne'=>$request->desciption_panne,
            'priorite'=>$request->priorite,
            'mode_appel'=>$request->mode_appel,
            'destinateur'=> $request->destinateur, 
            'soustraitant_id'=>$request->soustraitant_id,
            'appel_client'=>$request->appel_client,
            'description_intervention'=>$request->description_intervention,
            'date_debut'=>$request->date_debut,
            'date_fin'=>$request->date_fin,
            'etat_final'=>$request->etat_final,
            'etat'=>$request->etat,
            'rapport'=>$rapportName,
        ]);
        $notifications = notify("Intervention modifiée avec succès");
        return redirect()->route('interventions.index')->with($notifications);
    }

    public function reports(){
        $title ='rapport interventions';
        return view('admin.interventions.reports',compact('title'));
    }

    public function generateReport(Request $request){
        $this->validate($request,[
            'from_date' => 'required',
            'to_date' => 'required'
        ]);
        $title = 'rapport interventions';
        $interventions = Intervention::whereBetween(DB::raw('DATE(created_at)'), array($request->from_date, $request->to_date))->get();
        return view('admin.interventions.reports',compact(
            'interventions','title'
        ));
    }

    public function show($id){
        $title = 'intervention';
        $intervention = Intervention::findOrFail($id);
        $clients = Client::get();
        $equipements= Equipement::get();
        $sousequipements= Sousequipement::get();
        $users= User::get();
        $soustraitants = Soustraitant::get();
        $sousinterventions = $intervention->sousinterventions;
        return view('admin.interventions.show',compact(
            'title','clients','sousequipements','intervention',
            'users','equipements','soustraitants','sousinterventions'

        ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        return Intervention::findOrFail($request->id)->delete();
    }

    public function archive(Request $request)
    {
        $title = 'interventions';
        if($request->ajax()){
            $interventions = Intervention::whereIn('etat',['Cloturé','Cloturé par téléphone','Cloturé à distance'])->get();
            return DataTables::of($interventions)

                ->addColumn('etat',function($intervention){
                    return '<a href="'.route("interventions.show", $intervention->id).'">'. $intervention->etat .'</a>';
                })
                ->addColumn('client',function($intervention){
                    if(!empty($intervention->client)){
                        return $intervention->client->name;
                    }
                })
                ->addColumn('equipement',function($intervention){
                    if(!empty($intervention->equipement)){
                        return $intervention->equipement->modele;
                    }
                })
                ->addColumn('type_panne',function($intervention){
                    return $intervention->type_panne;
                })
                ->addColumn('destinateur',function($intervention){
                    if (is_array($intervention->destinateur)) {
                        return implode(', ', $intervention->destinateur);
                    }
                    return $intervention->destinateur;
                })
                ->addColumn('soustraitant',function($intervention){
                    if(!empty($intervention->soustraitant)){
                        return $intervention->soustraitant->name;
                    }
                })
                ->addColumn('sousequipement',function($intervention){
                    if(!empty($intervention->sousequipement)){
                        return $intervention->sousequipement->designation;
                    }
                })
                ->addColumn('appel_client',function($intervention){
                    return $intervention->appel_client;
                })
                ->addColumn('type_intervention',function($intervention){
                    return $intervention->type_intervention;
                })
                ->addColumn('action', function ($row) {
                    $editbtn = '<a href="'.route("interventions.edit", $row->id).'" class="editbtn"><button class="btn btn-primary"><i class="fas fa-edit"></i></button></a>';
                    $viewbtn = '<a href="'.route("interventions.show", $row->id).'" class="viewbtn"><button class="btn btn-success"><i class="fas fa-eye"></i></button></a>';
                    $deletebtn = '<a data-id="'.$row->id.'" data-route="'.route('interventions.destroy',$row->id).'" href="javascript:void(0)" id="deletebtn"><button class="btn btn-danger"><i class="fas fa-trash"></i></button></a>';
                    if ($row->trashed()) {
                        $deletebtn = ''; // Or you can show a restore button
                    }
                    if (!auth()->user()->hasPermissionTo('destroy-intervention')) {
                        $deletebtn = '';
                    }
                    if (!auth()->user()->hasPermissionTo('view-intervention')) {
                        $viewbtn = '';
                    }
                    $btn = $editbtn.' '.$deletebtn.' '.$viewbtn;
                    return $btn;
                })
                ->rawColumns(['etat','action'])
                ->make(true);
        }
        return view('admin.interventions.archive',compact(
            'title'
        ));
    }

    public function unclosed(Request $request)
    {
        $title = 'interventions';
        if($request->ajax()){
            $interventions = Intervention::whereNotIn('etat', ['Cloturé', 'Cloturé par téléphone', 'Cloturé à distance'])->get();
            return DataTables::of($interventions)

                ->addColumn('etat',function($intervention){
                    return '<a href="'.route("interventions.show", $intervention->id).'">'. $intervention->etat .'</a>';
                })
                ->addColumn('client',function($intervention){
                    if(!empty($intervention->client)){
                        return $intervention->client->name;
                    }
                })
                ->addColumn('equipement',function($intervention){
                    if(!empty($intervention->equipement)){
                        return $intervention->equipement->modele;
                    }
                })
                ->addColumn('type_panne',function($intervention){
                    return $intervention->type_panne;
                })
                ->addColumn('destinateur',function($intervention){
                    if (is_array($intervention->destinateur)) {
                        return implode(', ', $intervention->destinateur);
                    }
                    return $intervention->destinateur;
                })
                ->addColumn('soustraitant',function($intervention){
                    if(!empty($intervention->soustraitant)){
                        return $intervention->soustraitant->name;
                    }
                })
                ->addColumn('sousequipement',function($intervention){
                    if(!empty($intervention->sousequipement)){
                        return $intervention->sousequipement->designation;
                    }
                })
                ->addColumn('appel_client',function($intervention){
                    return $intervention->appel_client;
                })
                ->addColumn('type_intervention',function($intervention){
                    return $intervention->type_intervention;
                })
                ->addColumn('action', function ($row) {
                    $editbtn = '<a href="'.route("interventions.edit", $row->id).'" class="editbtn"><button class="btn btn-primary"><i class="fas fa-edit"></i></button></a>';
                    $viewbtn = '<a href="'.route("interventions.show", $row->id).'" class="viewbtn"><button class="btn btn-success"><i class="fas fa-eye"></i></button></a>';
                    $deletebtn = '<a data-id="'.$row->id.'" data-route="'.route('interventions.destroy',$row->id).'" href="javascript:void(0)" id="deletebtn"><button class="btn btn-danger"><i class="fas fa-trash"></i></button></a>';

                    if (!auth()->user()->hasPermissionTo('destroy-intervention')) {
                        $deletebtn = '';
                    }
                    if (!auth()->user()->hasPermissionTo('view-intervention')) {
                        $viewbtn = '';
                    }
                    $btn = $editbtn.' '.$deletebtn.' '.$viewbtn;
                    return $btn;
                })
                ->rawColumns(['etat','action'])
                ->make(true);
        }
        return view('admin.interventions.unclosed',compact(
            'title'
        ));
    }
}


