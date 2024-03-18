<?php

namespace App\Http\Controllers\Admin;
use App\Models\Sousintervention;
use App\Models\Intervention;
use App\Models\User;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use QCod\AppSettings\Setting\AppSettings;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SousinterventionController extends Controller
{
      /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = 'sousinterventions';
        if($request->ajax()){
            $sousinterventions = Sousintervention::get();
            return DataTables::of($sousinterventions)
                ->addIndexColumn()
                ->addColumn('date_debut',function($sousintervention){
                    return $sousintervention->date_debut;
                })
                ->addColumn('date_fin',function($sousintervention){
                    return $sousintervention->date_fin;
                })
                ->addColumn('etat_initial',function($sousintervention){
                    return $sousintervention->etat_initial;
                })
                ->addColumn('etat_final',function($sousintervention){
                    return $sousintervention->etat_final;
                })
                ->addColumn('description_panne',function($sousintervention){
                    return $sousintervention->description_panne;
                })
                ->addColumn('description_sousintervention',function($sousintervention){
                    return $sousintervention->description_sousintervention;
                })
                ->addColumn('user',function($sousintervention){
                    if(!empty($sousintervention->user)){
                        return $sousintervention->user->name;
                    }
                })
                ->addColumn('rapport',function($sousintervention){
                    return $sousintervention->rapport;
                })
                ->addColumn('action', function ($row) {
                    $editbtn = '<a href="'.route("sousinterventions.edit", $row->id).'" class="editbtn"><button class="btn btn-primary"><i class="fas fa-edit"></i></button></a>';
                    $deletebtn = '<a data-id="'.$row->id.'" data-route="'.route('sousinterventions.destroy', $row->id).'" href="javascript:void(0)" id="deletebtn"><button class="btn btn-danger"><i class="fas fa-trash"></i></button></a>';
                    if ($row->trashed()) {
                        $deletebtn = ''; // Or you can show a restore button
                    }
                    if (!auth()->user()->hasPermissionTo('edit-sousintervention')) {
                        $editbtn = '';
                    }
                    if (!auth()->user()->hasPermissionTo('destroy-sousintervention')) {
                        $deletebtn = '';
                    }

                    $btn = $editbtn.' '.$deletebtn;
                    return $btn;
                })
                ->rawColumns(['date_debut','action'])
                ->make(true);
        }
        return view('admin.sousinterventions.index',compact(
            'title'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($intervention_id)
    {
        $title = 'Ajouter sousintervention';
        $users = User::whereIn('role', ['technicien', 'ingenieur','administrateur'])->get();
        $intervention = Intervention::with('sousinterventions')->findOrFail($intervention_id);
        return view('admin.interventions.show',compact(
            'title','intervention_id','intervention','users'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$intervention_id)
    {
        $this->validate($request,[

            'date_debut'=>'required',
            'date_fin' => 'nullable|date',
            'rapport' => 'nullable|string',
            'description_sousintervention' => 'nullable|string',


        ]);
        Sousintervention::create([
            'date_debut'=>$request->date_debut,
            'date_fin'=>$request->date_fin,
            'etat_initial'=>$request->etat_initial,
            'etat_final'=>$request->etat_final,
            'intervenant'=>$request->intervenant,
            'description_panne'=>$request->description_panne,
            'description_sousintervention'=>$request->description_sousintervention,
            'rapport'=>$request->rapport,
            'intervention_id'=>$intervention_id,


        ]);
        $notifications = notify("Sousintervention ajoutée avec succès");
        return redirect()->route('interventions.show', ['intervention' => $intervention_id])->with($notifications);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \app\Models\Sousintervention $Sousintervention
     * @return \Illuminate\Http\Response
     */
    public function edit(Sousintervention $Sousintervention)
    {
        $title = 'edit Sousintervention';

        return view('admin.sousinterventions.edit',compact(
            'title','Sousintervention'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \app\Models\Sousintervention $Sousintervention
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sousintervention $Sousintervention)
    {
        $this->validate($request,[

            'date_fin'=>'required',
            'designation'=>'required|min:1',
        ]);

        $Sousintervention->update([
            'date_fin'=>$request->date_fin,
            'designation'=>$request->designation,
            'etat_initial'=>$request->etat_initial,
            'etat_final'=>$request->etat_final,
            'description'=>$request->description,

        ]);
        $notifications = notify("Sousintervention modifié avec succès");
        return redirect()->route('sousinterventions.index')->with($notifications);
    }

       /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        return Sousintervention::findOrFail($request->id)->delete();
    }
}

