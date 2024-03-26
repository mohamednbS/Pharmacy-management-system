@extends('admin.layouts.app')

<x-assets.datatables />

@push('page-css')

@endpush

@push('page-header')
<div class="col-sm-7 col-auto">
	<h3 class="page-title">Gestion Clients</h3>
	<ul class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Tableau de Bord</a></li>
		<li class="breadcrumb-item active">Clients-Equipements</li>
	</ul>
</div>

@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="profile-header">
                <div class="row align-items-center">

                    <div class="col ml-md-n2 profile-user-info">
                        <h4 class="user-name mb-0"> Client : {{$client->name}}</h4>
                        <h5 class="text-muted">Adresse : {{$client->adress}}</h5>
                    </div>

                </div>
            </div>

            <!-- Equipements table -->
            @if($client->equipements->isEmpty())
            <div class="p-3 mb-2 bg-warning text-light">
                <h6 class=text-center>Ce client n'admet pas des équipements.</h6>
            </div>
            @else
            <div class="card">
                <div class="card-body">
                    <h4 class="text-uppercase"><span class="badge rounded-pill bg-info text-light">Liste des équipements</span></h4>
                    <div class="table-responsive">
                        <table id="equipementclient-table" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Designation</th>
                                    <th>Modèle</th>
                                    <th>Numéro Série</th>
                                    <th>Date Installation</th>
                                    <th>Software</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($equipements as $equipement)
                                <tr>
                                    <td>{{$equipement->designation}}</td>
                                    <td>{{$equipement->modele}}</td>
                                    <td>{{$equipement->numserie}}</td>
                                    <td>{{$equipement->date_installation}}</td>
                                    <td>{{$equipement->software}}</td>
                                    <td class="text-center">
                                        <a href="{{route('equipements.show', $equipement->id)}}" class="btn btn-success btn-sm"><i class="fas fa-eye"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
            <!-- /Equipement table -->

            <!-- Details contrats -->
                @if($client->contrats->isEmpty())
                <div class="p-3 mb-2 bg-warning text-light">
                    <h6 class="text-center">Ce client est hors contrat.</h6>
                </div>
                @else
                <div class="card">
                    <div class="card-body">
                        <h4 class="text-uppercase"><span class="badge rounded-pill bg-info text-light">listes des contrats de maintenance</span></h4>
                        <div class="table-responsive">
                            <table id="client-contrats-table" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Equipement</th>
                                        <th>Type Contrat</th>
                                        <th>Date début</th>
                                        <th>Date fin</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($contrats as $contrat)
                                    <tr>
                                        <td>{{$contrat->equipement->modele}}</td>
                                        <td>{{$contrat->type_contrat}}</td>
                                        <td>{{date('d-m-Y', strtotime($contrat->date_debut))}}</td>
                                        <td>{{date('d-m-Y', strtotime($contrat->date_))}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif
            <!-- /Details contrats -->

			<!-- intervention -->

                <div class="card">
                    <div class="card-body">
                        <h4 class="text-uppercase"><span class="badge rounded-pill bg-info text-light">historique des interventions</span></h4>
                        @if($interventions->isNotEmpty())
						<div class="table-responsive">
                            <table id="client-interventions-table" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Equipement</th>
                                        <th>Panne</th>
                                        <th>Heure/Date d'appel client</th>
                                        <th>Etat</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($interventions as $intervention)
                                    <tr>
                                        <td>{{$intervention->equipement->modele}}</td>
                                        <td>{{$intervention->description_panne}}</td>
                                        <td>{{date('d-m-Y h:m', strtotime($intervention->appel_client))}}</td>
                                        <td>{{$intervention->etat}}</td>
                                        <td class="text-center">
                                            <a href="{{route('interventions.show', $intervention->id)}}" class="btn btn-success btn-sm"><i class="fas fa-eye"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
						@else
						<div class="p-3 mb-2 bg-warning text-light">
            				<h5 class="text-center">Ce client n'a pas d'interventions.</h5>
						</div>
        				@endif
                    </div>
                </div>

            <!-- /interventions -->
        </div>

    </div>
    <div class="clearfix"></div>
    <footer>
        <div class="container-fluid">
            <p class="copyright text-right">&copy; 2024 <a href="#" target="_blank">STIET</a>.</p>
        </div>
    </footer>

@endsection

@push('page-js')

@endpush
