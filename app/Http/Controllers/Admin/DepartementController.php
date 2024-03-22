<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Departement;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class DepartementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = 'departements';
        if($request->ajax()){
            $departements = Departement::get();
            return DataTables::of($departements)
                    ->addIndexColumn()
                    ->addColumn('created_at',function($departement){
                        return date_format(date_create($departement->created_at),"d M,Y");
                    })
                    ->addColumn('action',function ($row){
                        $editbtn = '<a data-id="'.$row->id.'" data-name="'.$row->name.'" href="javascript:void(0)" class="editbtn"><button class="btn btn-primary" title="Modifier"><i class="fas fa-edit"></i></button></a>';
                        $deletebtn = '<a data-id="'.$row->id.'" data-route="'.route('departements.destroy',$row->id).'" href="javascript:void(0)" id="deletebtn"><button class="btn btn-danger" title="Supprimer"><i class="fas fa-trash"></i></button></a>';
                        if ($row->trashed()) {
                            $deletebtn = ''; // Or you can show a restore button
                        }
                        if(!auth()->user()->hasPermissionTo('edit-departement')){
                            $editbtn = '';
                        }
                        if(!auth()->user()->hasPermissionTo('destroy-departement')){
                            $deletebtn = '';
                        }
                        $btn = $editbtn.' '.$deletebtn;
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('admin.departements.departements',compact(
            'title'
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
            'name'=>'required|max:100',
        ]);
        Departement::create($request->all());
        $notification=array("Département est ajouté avec succès");
        return back()->with($notification);
    }




    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request,['name'=>'required|max:100']);
        $departement = Departement::find($request->id);
        $departement->update([
            'name'=>$request->name,
        ]);
        $notification = notify("Département modifié avec succès");
        return back()->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        return Departement::findOrFail($request->id)->delete();
    }


}


