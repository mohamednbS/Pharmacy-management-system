<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Models\Modalite;
use App\Models\Departement;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = 'utilisateurs';
        if ($request->ajax()) {
            $users = User::get();
            return DataTables::of($users)
                ->addIndexColumn()

                ->addColumn('avatar', function ($user) {
                    $src = asset('assets/img/avatar.png');
                    if (!empty($user->avatar)) {
                        $src = asset('storage/users/'.$user->avatar);
                    }
                    return '<img src="'.$src.'" class="avatar-img rounded-circle" width="50" />';
                })
                ->addColumn('role', function ($row) {
                    foreach ($row->getRoleNames() as $role) {
                        return '<span>'.$role.'</span>';
                    }
                })
                ->addColumn('modalite',function($user){
                    return $user->modalite;
                })

                ->addColumn('action', function ($row) {
                    $editbtn = '<a href="'.route("users.edit", $row->id).'" class="editbtn"><button class="btn btn-primary"><i class="fas fa-edit"></i></button></a>';
                    $deletebtn = '<a data-id="'.$row->id.'" data-route="'.route('users.destroy', $row->id).'" href="javascript:void(0)" id="deletebtn"><button class="btn btn-danger"><i class="fas fa-trash"></i></button></a>';

                    if ($row->trashed()) {
                        $deletebtn = ''; // Or you can show a restore button
                    }
                    if (!auth()->user()->hasPermissionTo('edit-user')) {
                        $editbtn = '';
                    }
                    if (!auth()->user()->hasPermissionTo('destroy-user')) {
                        $deletebtn = '';
                    }
                    $btn = $editbtn.' '.$deletebtn;
                    return $btn;
                })
                ->rawColumns(['avatar','role','action'])
                ->make(true);
        }
        return view('admin.users.index', compact(
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
        $title = 'ajouter utilisateur';
        $roles = Role::where('name', '!=', 'super-admin')->get();
        $modalites = Modalite::get();
        $departements = Departement::get();
        return view('admin.users.create', compact('title','roles','modalites','departements'));
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
            'email'=>'required|email',
            'role'=>'required',
            'password'=>'required|confirmed|max:200',
            'modalite'=>'required',
            'departement'=>'required',

        ]);
        $imageName = null;
        if ($request->hasFile('avatar')) {
            $imageName = time().'.'.$request->avatar->extension();
            $request->avatar->move(public_path('storage/users'), $imageName);
        }
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'matricule' => $request->matricule,
            'phone' => $request->phone,
            'modalite' => $request->modalite,
            'departement' => $request->departement,
            'role' => $request->role,
            'avatar' => $imageName,
            'password' => Hash::make($request->password),
        ]);
        $user->assignRole($request->role);

        $notifiation = notify('utilisateur ajouté avec succès');
        return redirect()->route('users.index')->with($notifiation);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \app\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $title = "modifier utilisateur";
        $roles = Role::where('name', '!=', 'super-admin')->get();
        $modalites = Modalite::get();
        $departements = Departement::get();
        return view('admin.users.edit',compact(
            'title','roles','modalites','departements','user'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \app\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request,[
            'name'=>'required',
            'email'=>'required|email',
            'role'=>'required',
            'password'=>'required|confirmed|max:200',
            'modalite'=>'required',
            'departement'=>'required',

        ]);
        $imageName = $user->avatar;
        $password = $user->password;
        if($request->hasFile('avatar')){
            $imageName = time().'.'.$request->avatar->extension();
            $request->avatar->move(public_path('storage/users'), $imageName);
        }
        if(!empty($request->password) && ($user->password != $request->password)){
            $password = Hash::make($request->password);
        }
        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'matricule' => $request->matricule,
            'phone' => $request->phone,
            'modalite' => $request->modalite,
            'departement' => $request->departement,
            'role' => $request->role,
            'avatar' => $imageName,
            'password' => Hash::make($request->password),
        ]);
        foreach($user->getRoleNames() as $userRole){
            $user->removeRole($userRole);
        }
        $user->assignRole($request->role);
        $notification = notify('utilisateur modifié avec succès');
        return redirect()->route('users.index')->with($notification);
    }

    public function profile(){
        $title = 'profil utilsateur';
        $roles = Role::get();
        return view('admin.users.profile',compact(
            'title','roles'
        ));
    }

    public function updateProfile(Request $request,User $user){
        $this->validate($request,[
            'name' => 'required|min:5|max:200',
            'email' => 'required|email',
            'username' => 'nullable|min:3|max:200',
            'avatar' => 'nullable|file|image|mimes:jpg,jpeg,png,gif'
        ]);
        $imageName = $user->avatar;
        if($request->hasFile('avatar')){
            $imageName = time().'.'.$request->avatar->extension();
            $request->avatar->move(public_path('storage/users'), $imageName);
        }
        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'avatar' => $imageName,
        ]);
        $notification = notify('profil modifié avec succès');
        return redirect()->route('profile')->with($notification);
    }

    /**
     * Update current user password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request, User $user)
    {
        $this->validate($request, [
            'current_password'=>'required',
            'password'=>'required|max:200|confirmed',
        ]);
        $verify_password = password_verify($request->current_password, $user->password);
        if ($verify_password) {
            $user->update(['password'=>Hash::make($request->password)]);
            $notification = notify('Mot de passe modifié avec succès!!!');
            $logout = auth()->logout();
            return back()->with($notification, $logout);
        } elseif(!$verify_password) {
            $notification = notify("Mot de passe incorrect!!!",'danger');
            return back()->with($notification);
        }
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    */
    public function destroy(Request $request)
    {
        return User::findOrFail($request->id)->delete();
    }
}
