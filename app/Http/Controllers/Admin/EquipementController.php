<?php

namespace App\Http\Controllers\Admin;

use App\Models\Equipement;
use App\Models\Client;
use App\Models\Modalite;
use App\Models\Contrat;
use App\Models\Sousequipement;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use QCod\AppSettings\Setting\AppSettings;
use Illuminate\Support\Facades\Cache; // Importer la classe Cache


class EquipementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = 'equipements';
        // Vérifier si les données sont en cache
        if (Cache::has('equipements_data')) {
            $equipements = Cache::get('equipements_data');
        } else {
            // Si les données ne sont pas en cache, les récupérer normalement
            $equipements = Equipement::get();

            // Mettre en cache les données pour une durée spécifiée (par exemple, 60 minutes)
            Cache::put('equipements_data', $equipements, 60);
        }
        if($request->ajax()){
            $equipements = Equipement::get();
            return DataTables::of($equipements)
                ->addColumn('designation',function($equipement){
                    return $equipement->designation;
                })
                ->addColumn('modele',function($equipement){
                    return '<a href="'.route("equipements.show", $equipement->id).'">'. $equipement->modele .'</a>';
                })
                ->addColumn('client',function($equipement){
                    if(!empty($equipement->client)){
                        return $equipement->client->name;
                    }
                })
                ->addColumn('numserie',function($equipement){
                    return $equipement->numserie;
                })
                ->addColumn('modalite',function($equipement){
                    return $equipement->modalite->name;
                })
                ->addColumn('date_installation',function($equipement){
                    return $equipement->date_installation;
                })

                ->addColumn('action', function ($row) {
                    $editbtn = '<a href="'.route("equipements.edit", $row->id).'" class="editbtn"><button class="btn btn-primary" title="Modifier"><i class="fas fa-edit"></i></button></a>';
                    $deletebtn = '<a data-id="'.$row->id.'" data-route="'.route('equipements.destroy', $row->id).'" href="javascript:void(0)" id="deletebtn" title="Supprimer"><button class="btn btn-danger"><i class="fas fa-trash"></i></button></a>';
                    $viewbtn = '<a href="'.route("equipements.show", $row->id).'" class="viewbtn"><button class="btn btn-success" title="Voir"><i class="fas fa-eye"></i></button></a>';
                    if ($row->trashed()) {
                        $deletebtn = ''; // Or you can show a restore button
                    }
                    if (!auth()->user()->hasPermissionTo('edit-equipement')) {
                        $editbtn = '';
                    }
                    if (!auth()->user()->hasPermissionTo('destroy-equipement')) {
                        $deletebtn = '';
                    }
                    if (!auth()->user()->hasPermissionTo('view-equipement')) {
                        $viewbtn = '';
                    }

                    $btn = $editbtn.' '.$deletebtn.' '.$viewbtn;
                    return $btn;
                })
                ->rawColumns(['modele','action'])
                ->make(true);
        }
        return view('admin.equipements.index',compact(
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
        $title = 'ajouter equipement';
        $clients = Client::get();
        $modalites = Modalite::get();
        return view('admin.equipements.create',compact(
            'title','clients','modalites'
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

            'modele'=>'required',
            'marque'=>'required|min:1',
            'designation'=>'required|min:1',
            'numserie'=>'required',
            'modalite_id'=>'required',
            'client_id'=>'required',
            'software'=>'required',
            'date_installation'=>'required',
            'plan_prev'=>'required',

        ]);
        $documentName = null;
        if($request->hasFile('document')){
            $documentName = time().'.'.$request->document->extension();
            $request->document->move(public_path('storage/equipements'), $documentName);
        }
        Equipement::create([
            'code'=>$request->code,
            'modele'=>$request->modele,
            'marque'=>$request->marque,
            'designation'=>$request->designation,
            'numserie'=>$request->numserie,
            'modalite_id'=>$request->modalite_id,
            'client_id'=>$request->client_id,
            'software'=>$request->software,
            'date_installation'=>$request->date_installation,
            'plan_prev'=>$request->plan_prev,
            'document'=>$documentName,
        ]);
        $notifications = notify("equipement ajouté avec succès");
        return redirect()->route('equipements.index')->with($notifications);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \app\Models\Equipement $equipement
     * @return \Illuminate\Http\Response
     */
    public function edit(Equipement $equipement)
    {
        $title = 'modifier equipement';
        $clients = Client::get();
        $modalites = Modalite::get();
        return view('admin.equipements.edit',compact(
            'title','equipement','clients','modalites'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \app\Models\Equipement $equipement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Equipement $equipement)
    {
        $this->validate($request,[
            'modele'=>'required',
            'marque'=>'required|min:1',
            'designation'=>'required|min:1',
            'numserie'=>'required',
            'modalite_id'=>'required',
            'client_id'=>'required',
            'date_installation'=>'required',
            'plan_prev'=>'required',
        ]);
        $documentName = $equipement->document;
        if($request->hasFile('document')){
            $documentName = time().'.'.$request->document->extension();
            $request->document->move(public_path('storage/equipements'), $documentName);
        }
        $equipement->update([
            'code'=>$request->code,
            'modele'=>$request->modele,
            'marque'=>$request->marque,
            'designation'=>$request->designation,
            'numserie'=>$request->numserie,
            'modalite_id'=>$request->modalite_id,
            'client_id'=>$request->client_id,
            'software'=>$request->software,
            'date_installation'=>$request->date_installation,
            'plan_prev'=>$request->plan_prev,
            'document'=>$documentName,
        ]);
        $notifications = notify("equipement modifié avec succès");
        return redirect()->route('equipements.index')->with($notifications);
    }

    public function reports(){
        $title ='equipement reports';
        return view('admin.equipements.reports',compact('title'));
    }

    public function generateReport(Request $request){

        $this->validate($request, [
            'search_keyword' => 'required',
        ]);

        $title = 'rapport equipements' .' '.$request->search_keyword;
        $equipements = Equipement::where('designation', 'like', '%' . $request->search_keyword . '%')->get();
        return view('admin.equipements.reports',compact(
            'equipements','title'
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
        return Equipement::findOrFail($request->id)->delete();
    }

    public function show($id){
        $title = 'equipement';
        $equipement = Equipement::findOrFail($id);
        $clients = Client::get();
        $modalites = Modalite::get();
        $contrat = $equipement->contrat; 
        $sousequipements = $equipement->sousequipements;
        return view('admin.equipements.show',compact(
            'title','modalites','clients','equipement','contrat','sousequipements'
        ));
    }

    public function getEquipements(Request $request)
    {
        $client_id = $request->input('client_id');
        $equipements = Client::find($client_id)->equipements()->get();
        return response()->json($equipements);
    }

    public function UpdategetEquipements(Request $request)
    {
        $client_id = $request->input('client_id');
        // Vous devez implémenter la logique pour récupérer les équipements en fonction du client
        // Par exemple :
        $equipements = Equipement::where('client_id', $client_id)->get(['id', 'modele']);
        return response()->json($equipements);
    }
    public function addPiece(Request $request, $id)
    {
        $request->validate([
            'designation' => 'required',

        ]);

        $equipement = Equipement::findOrFail($id);

        $sousequipement = new Sousequipement();
        $sousequipement->identifiant = $request->identifiant;
        $sousequipement->designation = $request->designation;
        $sousequipement->marque = $request->marque;
        $sousequipement->modele = $request->modele;
        $sousequipement->equipement_id = $equipement->id;
        $sousequipement->save();

        return redirect()->route('equipements.show', $equipement->id)->with('success', 'Pièce ajoutée avec succès.');
    }

}


