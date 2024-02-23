<?php

namespace App\Http\Controllers\Admin;
use App\Models\Contrat;
use App\Models\Client;
use App\Models\Equipement;

use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use QCod\AppSettings\Setting\AppSettings;
use Illuminate\Http\Request;

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
        $title = 'create contrat';
        $clients = Client::get();
        return view('admin.contrats.create',compact(
            'title','clients'
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
            'date_debut'=>'required',
            'date_fin'=>'required',
        ]);
      
        Contrat::create([
            'client_id'=>$request->client,
            'date_debut'=>$request->date_debut,
            'date_fin'=>$request->date_fin,
            'type_contrat'=>$request->type_contrat,
            'status'=>$request->status,
            'note'=>$request->note,
        ]);
        $notifications = notify("Contrat ajouté avec succés");
        return redirect()->route('contrats.index')->with($notifications);
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \app\Models\contrat $contrat
     * @return \Illuminate\Http\Response
     */
    public function edit(contrat $contrat)
    {
        $title = 'edit contrat';
        $categories = Category::get();
        $date_fins = date_fin::get();
        return view('admin.contrats.edit',compact(
            'title','contrat','categories','date_fins'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \app\Models\contrat $contrat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, contrat $contrat)
    {
        $this->validate($request,[
            'product'=>'required|max:200',
            'category'=>'required',
            'date_debut'=>'required|min:1',
            'quantity'=>'required|min:1',
            'expiry_date'=>'required',
            'date_fin'=>'required',
        ]);
        $imageName = $contrat->image;
        if($request->hasFile('image')){
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('storage/contrats'), $imageName);
        }
        $contrat->update([
            'product'=>$request->product,
            'category_id'=>$request->category,
            'date_fin_id'=>$request->date_fin,
            'date_debut'=>$request->cost_price,
            'quantity'=>$request->quantity,
            'expiry_date'=>$request->expiry_date,
            'image'=>$imageName,
        ]);
        $notifications = notify("contrat has been updated");
        return redirect()->route('contrats.index')->with($notifications);
    }

    public function reports(){
        $title ='contrat reports';
        return view('admin.contrats.reports',compact('title')); 
    }

    public function generateReport(Request $request){
        $this->validate($request,[
            'from_date' => 'required',
            'to_date' => 'required'
        ]);
        $title = 'contrats reports';
        $contrats = contrat::whereBetween(DB::raw('DATE(created_at)'), array($request->from_date, $request->to_date))->get();
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
        return contrat::findOrFail($request->id)->delete();
    }
}
