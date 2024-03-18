@extends('admin.layouts.app')

@push('page-css')

@endpush

@push('page-header')
<div class="col-sm-12">
	<h3 class="page-title">Gestion Utilisateurs</h3>
	<ul class="breadcrumb">
		<li class="breadcrumb-item active">Tableau de Bord</li>
	</ul>
</div>
@endpush

@section('content')

<div class="row">
    <div class="col-md-12 col-lg-12">

        <div class="card card-table">
            <div class="card-header">
                <h4 class="card-title ">Ajouter</h4>
            </div>
            <div class="card-body">
                <div class="p-5">
                    <form method="POST" enctype="multipart/form-data" action="{{route('users.store')}}">
                        @csrf
                        <div class="row form-row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Nom Complet</label>
                                    <input type="text" name="name" class="form-control" placeholder="John Doe">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Matricule</label>
                                    <input type="text" name="matricule" class="form-control" placeholder="Saisir la matricule de l'utilisateur">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Adresse mail</label>
                                    <input type="email" name="email" class="form-control" placeholder="exemple@gmail.com">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Département</label>
                                    <div class="form-group">
                                        <select class="select2 form-select form-control" name="departement">
                                            <option value="Sélectionner un département">Sélectionner un département</option>
                                            @foreach ($departements as $departement)
                                                <option value="{{$departement->name}}">{{$departement->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Modalité</label>
                                    <div class="form-group">
                                        <select class="select2 form-select form-control"  name="modalite">
                                            <option value="Sélectionner une modalité">Sélectionner une modalité</option>
                                            @foreach ($modalites as $modalite)
                                                <option value="{{$modalite->name}}">{{$modalite->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Rôle</label>
                                    <div class="form-group">
                                        <select class="select2 form-select form-control" name="role">
                                            <option value="Sélectionner le role de l'utilisateur">Sélectionner le rôle de l'utilisateur</option>
                                            @foreach ($roles as $role)
                                                <option value="{{$role->name}}">{{$role->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Mobile</label>
                                    <input type="text" name="phone" class="form-control" placeholder="Saisir le mobile de l'utilisateur">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Avatar</label>
                                    <input type="file" name="avatar" class="form-control">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Mot de passe</label>
                                            <input type="password" name="password" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Confirmer Mot de Passe</label>
                                            <input type="password" name="password_confirmation" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Valider</button>
                        <a href="{{route('users.index')}}" class="btn btn-danger btn-block">Annuler</a>
                    </form>
                </div>
            </div>
        </div>

    </div>


</div>

@endsection

@push('page-js')

@endpush
