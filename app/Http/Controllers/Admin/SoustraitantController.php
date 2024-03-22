<?php

namespace App\Http\Controllers\Admin;
use App\Models\Soustraitant;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use QCod\AppSettings\Setting\AppSettings;

class SoustraitantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = 'soustraitants';
        if($request->ajax()){
            $soustraitants = Soustraitant::get();
            return DataTables::of($soustraitants)
                ->addIndexColumn()
                ->addColumn('name',function($soustraitant){
                    return $soustraitant->name;
                })

                ->addColumn('email',function($soustraitant){
                    return $soustraitant->email;
                })

                ->addColumn('phone',function($soustraitant){
                    return $soustraitant->phone;
                })

                ->addColumn('fax',function($soustraitant){
                    return $soustraitant->fax;
                })

                ->addColumn('adress',function($soustraitant){
                    return $soustraitant->adress;
                })

                ->addColumn('action', function ($row) {
                    $editbtn = '<a href="'.route("soustraitants.edit", $row->id).'" class="editbtn"><button class="btn btn-primary" title="Modifier"><i class="fas fa-edit"></i></button></a>';
                    $deletebtn = '<a data-id="'.$row->id.'" data-route="'.route('soustraitants.destroy', $row->id).'" href="javascript:void(0)" id="deletebtn"><button class="btn btn-danger" title="Supprimer"><i class="fas fa-trash"></i></button></a>';

                    if ($row->trashed()) {
                        $deletebtn = ''; // Or you can show a restore button
                    }
                    if (!auth()->user()->hasPermissionTo('edit-soustraitant')) {
                        $editbtn = '';
                    }
                    if (!auth()->user()->hasPermissionTo('destroy-soustraitant')) {
                        $deletebtn = '';
                    }
                    $btn = $editbtn.' '.$deletebtn;
                    return $btn;
                })
                ->rawColumns(['name','action'])
                ->make(true);
        }

        return view('admin.soustraitants.index',compact(
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
        $title = 'ajouter soustraitant';
        return view('admin.soustraitants.create',compact(
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
            'name'=>'required'

        ]);
        Soustraitant::create([
            'name'=>$request->name,
            'address'=>$request->address,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'fax'=>$request->fax,

        ]);
        $notification = notify("soustraitant ajouté avec succès");
        return redirect()->route('soustraitants.index')->with($notification);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \app\Models\Soustraitant $soustraitant
     * @return \Illuminate\Http\Response
     */
    public function edit(Soustraitant $soustraitant)
    {
        $title = 'modifier soustraitant';
        return view('admin.soustraitants.edit',compact(
            'title','soustraitant'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \app\Models\Soustraitant $soustraitant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Soustraitant $soustraitant)
    {
        $this->validate($request,[
            'name'=>'required'

        ]);

        $soustraitant->update([
            'name'=>$request->name,
            'address'=>$request->address,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'fax'=>$request->fax,
        ]);
        $notification = notify("soustraitant modifié avec succès");
        return redirect()->route('soustraitants.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        return Soustraitant::findOrFail($request->id)->delete();
    }

}
