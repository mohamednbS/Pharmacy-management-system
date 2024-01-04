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
                ->addColumn('action', function ($row) {
                    $editbtn = '<a href="'.route("clients.edit", $row->id).'" class="editbtn"><button class="btn btn-primary"><i class="fas fa-edit"></i></button></a>';
                    $deletebtn = '<a data-id="'.$row->id.'" data-route="'.route('clients.destroy', $row->id).'" href="javascript:void(0)" id="deletebtn"><button class="btn btn-danger"><i class="fas fa-trash"></i></button></a>';
                    if (!auth()->user()->hasPermissionTo('edit-client')) {
                        $editbtn = '';
                    }
                    if (!auth()->user()->hasPermissionTo('destroy-client')) {
                        $deletebtn = '';
                    }
                    $btn = $editbtn.' '.$deletebtn;
                    return $btn;
                })
                ->rawColumns(['action'])
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
        $title = 'create client';
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
            'fax'=>'nullable|min:8|max:20',
    
           
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
        $title = 'edit Client';
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
            'name'=>'required|min:4|max:255',
            'address'=>'nullable|max:200',
            'email'=>'nullable|email|string',
            'phone'=>'nullable|min:8|max:20',
            'fax'=>'nullable|min:8|max:20',
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
}

