<?php

namespace App\Http\Controllers\Admin;
use App\Models\Contrat;
use App\Models\Client;
use App\Models\Equipement;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use QCod\AppSettings\Setting\AppSettings;

class ContratController extends Controller
{
    //
     /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = 'contrats';
        if($request->ajax()){
            $contrats = Contrat::get();
            return DataTables::of($contrats)
                ->addColumn('client',function($contrat){
                    if(!empty($contrat->client)){
                        return $contrat->client->name;
                    }
                })
                ->addColumn('equipement',function($contrat){
                    if(!empty($contrat->equipement)){
                        return $contrat->equipement->modele;
                    }
                })
                ->addColumn('date_debut',function($contrat){
                    return $contrat->date_debut;
                })
                ->addColumn('date_fin',function($contrat){
                    return $contrat->date_fin;
                })
                ->addColumn('type_contrat',function($contrat){
                    return $contrat->type_contrat;
                })
                ->addColumn('status',function($contrat){
                    return $contrat->status;
                })
                ->addColumn('note',function($contrat){
                    return $contrat->note;
                })
                ->addColumn('action', function ($row) {
                    $editbtn = '<a href="'.route("contrats.edit", $row->id).'" class="editbtn"><button class="btn btn-primary"><i class="fas fa-edit"></i></button></a>';
                    $deletebtn = '<a data-id="'.$row->id.'" data-route="'.route('contrats.destroy', $row->id).'" href="javascript:void(0)" id="deletebtn"><button class="btn btn-danger"><i class="fas fa-trash"></i></button></a>';
                    if ($row->trashed()) {
                        $deletebtn = ''; // Or you can show a restore button

                    }
                    if (!auth()->user()->hasPermissionTo('edit-contrat')) {
                        $editbtn = '';
                    }
                    if (!auth()->user()->hasPermissionTo('destroy-contrat')) {
                        $deletebtn = '';
                    }
                    $btn = $editbtn.' '.$deletebtn;
                    return $btn;
                })
                ->rawColumns(['client','action'])
                ->make(true);
        }

        return view('admin.contrats.index',compact(
            'title',
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'ajouter contrat';
        $clients = Client::get();
        $equipements = Equipement::get();
        return view('admin.contrats.create',compact(
            'title','clients','equipements'
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
            'date_fin'=>'required',
        ]);

        Contrat::create([
            'client_id'=>$request->client,
            'equipement_id'=>$request->equipement,
            'date_debut'=>$request->date_debut,
            'date_fin'=>$request->date_fin,
            'type_contrat'=>$request->type_contrat,
            'status'=>$request->status,
            'note'=>$request->note,
        ]);
        $notifications = notify("Contrat ajouté avec succès");
        return redirect()->route('contrats.index')->with($notifications);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \app\Models\Contrat $contrat
     * @return \Illuminate\Http\Response
     */
    public function edit(Contrat $contrat)
    {
        $title = 'modifier contrat';
        $clients = Client::get();
        $equipements = Equipement::get();
        return view('admin.contrats.edit',compact(
            'title','contrat','clients','equipements'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \app\Models\Contrat $contrat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contrat $contrat)
    {
        $this->validate($request,[
            'client'=>'required',
            'date_fin'=>'required',
        ]);

        $contrat->update([
            'client_id'=>$request->client,
            'equipement_id'=>$request->equipement,
            'date_debut'=>$request->date_debut,
            'date_fin'=>$request->date_fin,
            'type_contrat'=>$request->type_contrat,
            'status'=>$request->status,
            'note'=>$request->note,
        ]);
        $notifications = notify("contrat modifié avec succès");
        return redirect()->route('contrats.index')->with($notifications);
    }

    public function reports(){
        $title ='rapport contrat';
        return view('admin.contrats.reports',compact('title'));
    }

    public function generateReport(Request $request){
        $this->validate($request,[
            'from_date' => 'required',
            'to_date' => 'required'
        ]);
        $title = 'rapport contrat';
        $contrats = Contrat::whereBetween(DB::raw('DATE(created_at)'), array($request->from_date, $request->to_date))->get();
        return view('admin.contrats.reports',compact(
            'contrats','title'
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
        return Contrat::findOrFail($request->id)->delete();
    }
}
