<?php

namespace App\Http\Controllers\Admin;

use App\Models\Equipement;
use App\Models\Client;
use App\Models\Modalite;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use QCod\AppSettings\Setting\AppSettings;


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
                    return date_format(date_create($equipement->date_installation),'d M, Y');
                })
                ->addColumn('type_contrat',function($equipement){
                    return $equipement->type_contrat;
                })
                ->addColumn('action', function ($row) {
                    $editbtn = '<a href="'.route("equipements.edit", $row->id).'" class="editbtn"><button class="btn btn-primary"><i class="fas fa-edit"></i></button></a>';
                    $deletebtn = '<a data-id="'.$row->id.'" data-route="'.route('equipements.destroy', $row->id).'" href="javascript:void(0)" id="deletebtn"><button class="btn btn-danger"><i class="fas fa-trash"></i></button></a>';

                    if (!auth()->user()->hasPermissionTo('edit-equipement')) {
                        $editbtn = '';
                    }
                    if (!auth()->user()->hasPermissionTo('destroy-equipement')) {
                        $deletebtn = '';
                    }

                    $btn = $editbtn.' '.$deletebtn;
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
        $title = 'create equipement';
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
            'tyoe_contrat'=>$request->type_contrat,
            'date_installation'=>$request->date_installation,
            'plan_prev'=>$request->plan_prev,
            'document'=>$documentName,
        ]);
        $notifications = notify("equipement has been added");
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
        $title = 'edit equipement';
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
            'software'=>'required',
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
            'tyoe_contrat'=>$request->type_contrat,
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
        return view('admin.equipements.show',compact(
            'title','modalites','clients','equipement'
        ));
    }

    public function getEquipements(Request $request)
    {
        $client_id = $request->input('client_id');
        $equipements = Client::find($client_id)->equipements()->get();
        return response()->json($equipements);
    }
}


