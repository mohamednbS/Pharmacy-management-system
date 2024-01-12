<?php

namespace App\Http\Controllers\Admin;

use App\Models\Sousequipement;
use App\Models\Equipement;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;



class SousequipementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = 'sousequipements';
        if($request->ajax()){
            $sousequipements = Sousequipement::get();
            return DataTables::of($sousequipements)
                ->addIndexColumn()
                ->addColumn('designation',function($sousequipement){               
                    return $sousequipement->designation;
                })
                ->addColumn('identifiant',function($sousequipement){
                    return $sousequipement->identifiant;
                })
                ->addColumn('marque',function($sousequipement){
                    return $sousequipement->marque;
                })
                ->addColumn('modele',function($sousequipement){
                    return $sousequipement->modele;
                })
                ->addColumn('action', function ($row) {
                    $editbtn = '<a href="'.route("sousequipements.edit", $row->id).'" class="editbtn"><button class="btn btn-primary"><i class="fas fa-edit"></i></button></a>';
                    $deletebtn = '<a data-id="'.$row->id.'" data-route="'.route('sousequipements.destroy', $row->id).'" href="javascript:void(0)" id="deletebtn"><button class="btn btn-danger"><i class="fas fa-trash"></i></button></a>';
                    
                    if (!auth()->user()->hasPermissionTo('edit-sousequipement')) {
                        $editbtn = '';
                    }
                    if (!auth()->user()->hasPermissionTo('destroy-sousequipement')) {
                        $deletebtn = '';
                    }

                    $btn = $editbtn.' '.$deletebtn; 
                    return $btn;
                })
                ->rawColumns(['modele','action'])
                ->make(true);
        }
        return view('admin.sousequipements.index',compact(
            'title'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($equipement_id)
    {
        $title = 'create sousequipement';
        $equipement = Equipement::with('sousequipements')->findOrFail($equipement_id);
        return view('admin.sousequipements.create',compact(
            'title','equipement_id','equipement'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$equipement_id)
    {
        $this->validate($request,[
           
            'identifiant'=>'required',
            'designation'=>'required|min:1',

        ]);
        Sousequipement::create([
            'identifiant'=>$request->identifiant,
            'designation'=>$request->designation,
            'marque'=>$request->marque,
            'modele'=>$request->modele,
            'description'=>$request->description,
            'equipement_id'=>$equipement_id,
            
        ]);
        $notifications = notify("Sousequipement ajouté avec succès");
        return redirect()->route('sousequipements.index')->with($notifications);
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \app\Models\Sousequipement $sousequipement
     * @return \Illuminate\Http\Response
     */
    public function edit(Sousequipement $sousequipement)
    {
        $title = 'edit sousequipement';
    
        return view('admin.sousequipements.edit',compact(
            'title','sousequipement'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \app\Models\Sousequipement $sousequipement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sousequipement $sousequipement)
    {
        $this->validate($request,[
           
            'identifiant'=>'required',
            'designation'=>'required|min:1',
        ]);

        $sousequipement->update([
            'identifiant'=>$request->identifiant,
            'designation'=>$request->designation,
            'marque'=>$request->marque,
            'modele'=>$request->modele,
            'description'=>$request->description,
        
        ]);
        $notifications = notify("Sousequipement modifié avec succès");
        return redirect()->route('sousequipements.index')->with($notifications);
    }

       /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        return Sousequipement::findOrFail($request->id)->delete();
    }

    public function reports(){
        $title ='sousequipement reports';
        return view('admin.soussousequipements.reports',compact('title'));
    }

    public function generateReport(Request $request){
        $this->validate($request,[
            'from_date' => 'required',
            'to_date' => 'required'
        ]);
        $title = 'soussousequipements reports';
        $soussousequipements = sousequipement::whereBetween(DB::raw('DATE(created_at)'), array($request->from_date, $request->to_date))->get();
        return view('admin.soussousequipements.reports',compact(
            'soussousequipements','title'
        ));
    }

}


