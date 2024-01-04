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
                    ->addColumn('created_at',function($modalite){
                        return date_format(date_create($modalite->created_at),"d M,Y");
                    })
                    ->addColumn('action',function ($row){
                        $editbtn = '<a data-id="'.$row->id.'" data-name="'.$row->name.'" href="javascript:void(0)" class="editbtn"><button class="btn btn-primary"><i class="fas fa-edit"></i></button></a>';
                        $deletebtn = '<a data-id="'.$row->id.'" data-route="'.route('modalites.destroy',$row->id).'" href="javascript:void(0)" id="deletebtn"><button class="btn btn-danger"><i class="fas fa-trash"></i></button></a>';
                        if(!auth()->user()->hasPermissionTo('edit-modalite')){
                            $editbtn = '';
                        }
                        if(!auth()->user()->hasPermissionTo('destroy-modalite')){
                            $deletebtn = '';
                        }
                        $btn = $editbtn.' '.$deletebtn;
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('admin.products.modalites',compact(
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
        $notification=array("Modalite est ajoutée");
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
}

