<?php

namespace App\Http\Controllers\Admin;

use App\Models\Accessoire;
use App\Models\Equipement;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class AccessoireController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = 'accessoires';
        if($request->ajax()){
            $accessoires = Accessoire::get();
            return DataTables::of($accessoires)
                ->addIndexColumn()
                ->addColumn('identifiant',function($accessoire){               
                    return $accessoire->designation;
                })
                ->addColumn('numserie',function($accessoire){
                    return $accessoire->identifiant;
                })
                ->addColumn('quantite',function($accessoire){
                    return $accessoire->quantite;
                })
                ->addColumn('description',function($accessoire){
                    return $accessoire->description;
                })
                ->addColumn('action', function ($row) {
                    $editbtn = '<a href="'.route("accessoires.edit", $row->id).'" class="editbtn"><button class="btn btn-primary"><i class="fas fa-edit"></i></button></a>';
                    $deletebtn = '<a data-id="'.$row->id.'" data-route="'.route('accessoires.destroy', $row->id).'" href="javascript:void(0)" id="deletebtn"><button class="btn btn-danger"><i class="fas fa-trash"></i></button></a>';
                    
                    if (!auth()->user()->hasPermissionTo('edit-accessoire')) {
                        $editbtn = '';
                    }
                    if (!auth()->user()->hasPermissionTo('destroy-accessoire')) {
                        $deletebtn = '';
                    }

                    $btn = $editbtn.' '.$deletebtn; 
                    return $btn;
                })
                ->rawColumns(['modele','action'])
                ->make(true);
        }
        return view('admin.accessoires.index',compact(
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
        $title = 'create accessoire';
        $equipement = Equipement::with('accessoires')->findOrFail($equipement_id);
        return view('admin.accessoires.create',compact(
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
        Accessoire::create([
            'identifiant'=>$request->identifiant,
            'designation'=>$request->designation,
            'quantite'=>$request->quantite,
            'description'=>$request->description,
            'equipement_id'=>$equipement_id,
            
        ]);
        $notifications = notify("accessoire has been added");
        return redirect()->route('accessoires.index')->with($notifications);
    }


}
