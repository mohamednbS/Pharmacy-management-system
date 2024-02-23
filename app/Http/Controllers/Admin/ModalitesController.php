<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Modalite;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ModalitesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = 'modalites';
        if($request->ajax()){
            $modalites = Modalite::get();
            return DataTables::of($modalites)
                    ->addIndexColumn()

                    ->addColumn('action',function ($row){
                        $editbtn = '<a data-id="'.$row->id.'" data-name="'.$row->name.'" href="javascript:void(0)" class="editbtn"><button class="btn btn-primary"><i class="fas fa-edit" class="text-center action-btn"></i></button></a>';
                        $deletebtn = '<a data-id="'.$row->id.'" data-route="'.route('modalites.destroy',$row->id).'" href="javascript:void(0)" id="deletebtn"><button class="btn btn-danger" class="text-center action-btn"><i class="fas fa-trash"></i></button></a>';
                        $viewbtn = '<a href="'.route("modalites.show", $row->id).'"class="viewbtn"><button class="btn btn-success"><i class="fas fa-eye" class="text-center action-btn"></i></button></a>';
                        if(!auth()->user()->hasPermissionTo('edit-modalite')){
                            $editbtn = '';
                        }
                        if(!auth()->user()->hasPermissionTo('destroy-modalite')){
                            $deletebtn = '';
                        }
                        if(!auth()->user()->hasPermissionTo('view-modalite')){
                            $viewbtn = '';
                        }
                        $btn = $editbtn.' '.$deletebtn.' '.$viewbtn;
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('admin.modalites.modalites',compact(
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
        Modalite::create($request->all());
        $notification=array("Modalité est ajoutée");
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
        $modalite = Modalite::find($request->id);
        $modalite->update([
            'name'=>$request->name,
        ]);
        $notification = notify("Modalité modifiée avec succès");
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
        return Modalite::findOrFail($request->id)->delete();
    }

    public function show($id){
        $title = 'modalite';
        $modalite = Modalite::findOrFail($id);
        $equipements = $modalite->equipements;
        return view('admin.modalites.show',compact(
            'title','modalite','equipements'
        ));
    }


}

