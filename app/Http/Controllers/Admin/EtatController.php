<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Etat;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class EtatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = 'etats';
        if($request->ajax()){
            $etats = Etat::get();
            return DataTables::of($etats)
                    ->addIndexColumn()
                    ->addColumn('created_at',function($etat){
                        return date_format(date_create($etat->created_at),"d M,Y");
                    })
                    ->addColumn('action',function ($row){
                        $editbtn = '<a data-id="'.$row->id.'" data-name="'.$row->name.'" href="javascript:void(0)" class="editbtn"><button class="btn btn-primary" title="Modifier"><i class="fas fa-edit"></i></button></a>';
                        $deletebtn = '<a data-id="'.$row->id.'" data-route="'.route('etats.destroy',$row->id).'" href="javascript:void(0)" id="deletebtn"><button class="btn btn-danger" title="Supprimer"><i class="fas fa-trash"></i></button></a>';
                        if ($row->trashed()) {
                            $deletebtn = ''; // Or you can show a restore button
                        }
                        if(!auth()->user()->hasPermissionTo('edit-etat')){
                            $editbtn = '';
                        }
                        if(!auth()->user()->hasPermissionTo('destroy-etat')){
                            $deletebtn = '';
                        }
                        $btn = $editbtn.' '.$deletebtn;
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('admin.etats.etats',compact(
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
        Etat::create($request->all());
        $notification=array("Etat est ajouté avec succès");
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
        $etat = Etat::find($request->id);
        $etat->update([
            'name'=>$request->name,
        ]);
        $notification = notify("Etat modifié avec succès");
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
        return Etat::findOrFail($request->id)->delete();
    }
}
