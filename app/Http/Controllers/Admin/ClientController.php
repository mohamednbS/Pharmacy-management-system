<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = 'clients';
        if($request->ajax()){
            $clients = Client::get();
            return DataTables::of($clients)
                ->addIndexColumn()
                ->addColumn('name',function($client){
                    return $client->name ;
                })

                ->addColumn('email',function($client){
                    return $client->email;
                })

                ->addColumn('phone',function($client){
                    return $client->phone;
                })

                ->addColumn('fax',function($client){
                    return $client->fax;
                })

                ->addColumn('adress',function($client){
                    return $client->adress;
                })

                ->addColumn('action', function ($row) {
                    $editbtn = '<a href="'.route("clients.edit", $row->id).'" class="editbtn"><button class="btn btn-primary"><i class="fas fa-edit"></i></button></a>';
                    $deletebtn = '<a data-id="'.$row->id.'" data-route="'.route('clients.destroy', $row->id).'" href="javascript:void(0)" id="deletebtn"><button class="btn btn-danger"><i class="fas fa-trash"></i></button></a>';
                    $viewbtn = '<a href="'.route("clients.show", $row->id).'" class="viewbtn"><button class="btn btn-success"><i class="fas fa-eye"></i></button></a>';
                    if ($row->trashed()) {
                        $deletebtn = ''; // Or you can show a restore button
                    }
                    if (!auth()->user()->hasPermissionTo('destroy-client')) {
                        $deletebtn = '';
                    }
                    if (!auth()->user()->hasPermissionTo('view-client')) {
                        $viewbtn = '';
                    }
                    $btn = $editbtn.' '.$deletebtn.' '.$viewbtn;
                    return $btn;
                })
                ->rawColumns(['name','action'])
                ->make(true);
        }

        return view('admin.clients.index',compact(
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
        $title = 'ajouter client';
        return view('admin.clients.create',compact(
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
            'name'=>'required|min:4|max:255',
            'address'=>'nullable|max:200',
            'email'=>'nullable|email|string',
            'phone'=>'nullable|min:8|max:20',



        ]);
        Client::create([
            'name'=>$request->name,
            'address'=>$request->address,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'fax'=>$request->fax,

        ]);
        $notification = notify("Client ajouté avec succès");
        return redirect()->route('clients.index')->with($notification);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \app\Models\Client $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        $title = 'modifier Client';
        return view('admin.clients.edit',compact(
            'title','client'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \app\Models\Client $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        $this->validate($request,[
            'name'=>'required',

        ]);

        $client->update([
            'name'=>$request->name,
            'address'=>$request->address,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'fax'=>$request->fax,
        ]);
        $notification = notify("Client modifié avec succès");
        return redirect()->route('clients.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        return Client::findOrFail($request->id)->delete();
    }

    public function show($id){
        $title = 'client';
        $client = Client::findOrFail($id);
        $equipements = $client->equipements;
        return view('admin.clients.show',compact(
            'title','client','equipements'
        ));
    }
}

