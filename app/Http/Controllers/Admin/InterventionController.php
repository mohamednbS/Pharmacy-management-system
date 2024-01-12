<?php

namespace App\Http\Controllers\Admin;

use App\Models\Intervention;
use App\Models\Equipement;
use App\Models\Sousequipement;
use App\Models\Client;
use App\Models\User;
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
                ->addColumn('client_name',function($intervention){
                    return $intervention->client_name;
                })
                ->addColumn('equipement_name',function($intervention){
                    return $intervention->equipement_name;

                })
                ->addColumn('type_panne',function($intervention){
                    return $intervention->type_name;
                })
                ->addColumn('destinateur',function($intervention){
                    return $intervention->destinateur;
                })
                ->addColumn('description_panne',function($intervention){
                    return $intervention->description_panne;
                })
                ->addColumn('appel_client',function($intervention){
                    return $intervention->appel_client;
                })
                ->addColumn('type_contrat',function($intervention){
                    return $intervention->type_contrat;
                })
        
                ->addColumn('action', function ($row) {
                    $editbtn = '<a href="'.route("interventions.edit", $row->id).'" class="editbtn"><button class="btn btn-primary"><i class="fas fa-edit"></i></button></a>';
                    $deletebtn = '<a data-id="'.$row->id.'" data-route="'.route('interventions.destroy', $row->id).'" href="javascript:void(0)" id="deletebtn"><button class="btn btn-danger"><i class="fas fa-trash"></i></button></a>';
                    if (!auth()->user()->hasPermissionTo('edit-intervention')) {
                        $editbtn = '';
                    }
                    if (!auth()->user()->hasPermissionTo('destroy-intervention')) {
                        $deletebtn = '';
                    }
                    $btn = $editbtn.' '.$deletebtn;
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
        $title = 'create intervention';
        $equipements= Equipement::get();
        $clients = Client::get();
        $users = User::whereIn('role', ['technicien', 'ingenieur'])->get();
        $sousequipements = Sousequipement::get();
        return view('admin.interventions.create',compact(
            'title','equipements','clients','users','sousequipements'
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
            'equipement_name'=>'required',
            'client_name'=>'required',
            'mode_appel'=>'required',
            'destinateur'=>'required',
            'appel_client'=>'required',

        ]);

        Intervention::create([
            'equipement_name'=>$request->equipement_name,
            'souseq_name'=>$request->souseq_name,
            'client_name'=>$request->client_name,
            'type_panne'=>$request->type_panne,
            'description_panne'=>$request->description_panne,
            'priorite'=>$request->priorite,
            'mode_appel'=>$request->mode_appel,
            'destinateur'=>$request->destinateur,
            'soustraitant_name'=>$request->soustraitant_name,
            'appel_client'=>$request->appel_client,
            'observation'=>$request->observation,
            'date_debut'=>$request->date_debut,
            'etat'=>$request->etat,
        ]);
        $notifications = notify("Intervention ajoutée");
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
        $title = 'edit intervention';
        $equipements= Equipement::get();
        $clients = Client::get();
        $users = User::whereIn('role', ['technicien', 'ingenieur'])->get();
        $sousequipements = Sousequipement::get();
        return view('admin.interventions.edit',compact(
            'title','equipements','clients','users','sousequipements','intervention'
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
            'equipement_name'=>'required',
            'client_name'=>'required',
            'mode_appel'=>'required',
            'destinateur'=>'required',
            'appel_client'=>'required',
            
        ]);
        $rapportName = null;
        if($request->hasFile('rapport')){
            $rapportName = time().'.'.$request->rapport->extension();
            $request->rapport->move(public_path('storage/interventions'), $rapportName);
        }
        $intervention->update([
            'equipement_name'=>$request->equipement_name,
            'souseq_name'=>$request->souseq_name,
            'client_name'=>$request->client_name,
            'type_panne'=>$request->type_panne,
            'desciption_panne'=>$request->desciption_panne,
            'priorite'=>$request->priorite,
            'mode_appel'=>$request->mode_appel,
            'destinateur'=>$request->destinateur,
            'soustraitant_name'=>$request->soustraitant_name,
            'appel_client'=>$request->appel_client,
            'observation'=>$request->observation,
            'date_debut'=>$request->date_debut,
            'date_fin'=>$request->date_fin,
            'date_fin'=>$request->date_fin,
            'etat'=>$request->etat,
            'rapport'=>$rapportName,
        ]);
        $notifications = notify("Intervention modifiée");
        return redirect()->route('interventions.index')->with($notifications);
    }

    public function reports(){
        $title ='purchase reports';
        return view('admin.interventions.reports',compact('title'));
    }

    public function generateReport(Request $request){
        $this->validate($request,[
            'from_date' => 'required',
            'to_date' => 'required'
        ]);
        $title = 'interventions reports';
        $interventions = Purchase::whereBetween(DB::raw('DATE(created_at)'), array($request->from_date, $request->to_date))->get();
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
        return view('admin.interventions.show',compact(
            'title','clients','sousequipements','intervention',
            'users','equipements'

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

}
