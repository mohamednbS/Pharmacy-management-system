@extends('admin.layouts.app')

@push('page-header')
<div class="col">
	<h3 class="page-title">Gestion Equipement</h3>
	<ul class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Tableau de Bord</a></li>
		<li class="breadcrumb-item active">Equipement</li>
	</ul>
</div>
@endpush

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="profile-header">
			<div class="row align-items-center">

				<div class="col ml-md-n2 profile-user-info">
					<h4 class="user-name mb-0">Modèle : {{$equipement->modele}}</h4>
                    <h5 class="user-name mb-0">Marque : {{$equipement->marque}}</h5>
					<h6 class="text-muted">{{$equipement->code}}</h6>
				</div>

			</div>
		</div>
		<div class="profile-menu">
			<ul class="nav nav-tabs nav-tabs-solid">
				<li class="nav-item">
					<a class="nav-link active" data-toggle="tab" href="#per_details_tab">Aperçu</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" data-toggle="tab" href="#password_tab">Pièces remplacées</a>
				</li>
				<li class="nav-item">
				    <a class="nav-link" href="/equipements/{{ $equipement->id}}/sousequipements/create" class="btn btn-primary float-right mt-2 text-light">Ajouter Sous-equipement</a>
				</li>

			</ul>
		</div>

		<div class="tab-content profile-tab-cont">

			<!-- Aperçu equipement Tab -->
			<div class="tab-pane fade show active" id="per_details_tab">

				<!-- Aperçu equipement -->
				<div class="row">
					<div class="col-lg-12">
						<div class="card">
							<div class="card-body">
								<h5 class="card-title d-flex justify-content-between">
									<span>Aperçu</span>
									<a class="edit-link" data-toggle="modal" href="#edit_equipement_details"><i class="fa fa-edit mr-1"></i>Modifier</a>
								</h5>


								<div class="row">
									<p class="col-sm-2 text-muted text-sm-right mv-0 mb-sm-3">Client</p>
									<p class="col-sm-10">	{{$equipement->client->name}}</p>
								</div>

								<div class="row">
									<p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Modalité</p>
									<p class="col-sm-10">{{$equipement->designation}}</p>
								</div>

								<div class="row">
									<p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Numéro de Série</p>
									<p class="col-sm-10">{{$equipement->numserie}}</p>
								</div>

                                <div class="row">
									<p class="col-sm-2 text-muted text-sm-right mv-0 mb-sm-3">Date Installation</p>
									<p class="col-sm-10">	{{$equipement->date_installation}}</p>
								</div>

                                <div class="row">
									<p class="col-sm-2 text-muted text-sm-right mv-0 mb-sm-3">Software</p>
									<p class="col-sm-10">	{{$equipement->software}}</p>
								</div>

                                <div class="row">
									<p class="col-sm-2 text-muted text-sm-right mv-0 mb-sm-3">Nombre planning préventif/an</p>
									<p class="col-sm-10">	{{$equipement->plan_prev}}</p>
								</div>

							</div>
							<!-- Details contrats -->
							@if($equipement->contrat)
							<div class="card-body">
								<h5 class="card-title d-flex justify-content-between">
									<span>Détails du contrat</span>
							    </h5>
                                <div class="row">
									<p class="col-sm-2 text-muted text-sm-right mv-0 mb-sm-3">Type contrat</p>
									<p class="col-sm-10">	{{$equipement->contrat->type_contrat}}</p>
								</div>
								<div class="row">
									<p class="col-sm-2 text-muted text-sm-right mv-0 mb-sm-3">Date de début</p>
									<p class="col-sm-10">	{{$equipement->contrat->date_debut}}</p>
								</div>

								<div class="row">
									<p class="col-sm-2 text-muted text-sm-right mv-0 mb-sm-3">Date de fin</p>
									<p class="col-sm-10">	{{$equipement->contrat->date_fin}}</p>
								</div>

								<div class="row">
									<p class="col-sm-2 text-muted text-sm-right mv-0 mb-sm-3">Garantie</p>
								</div>
							</div>
							@else
							<div class="p-3 mb-2 bg-primary text-light">
                    			<p>Cet équipement est hors contrat.</p>
							</div>
							@endif
							<!-- /Details contrats -->



                        <!-- Edit Details Modal -->
						<div class="modal fade" id="edit_equipement_details" aria-hidden="true" role="dialog">
							<div class="modal-dialog modal-dialog-centered" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title">Détails Equipement</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<form method="post" enctype="multipart/form-data" action="{{route('equipements.update',$equipement)}}">
											@csrf
											@method("PUT")
											<div class="row form-row">
												<div class="col-12">
                                                    <div class="form-group">
                                                        <label>Client <span class="text-danger">*</span></label>
                                                        <select class="select2 form-select form-control" name="client_id">
                                                            @foreach ($clients as $client)
                                                                @if ($client->id == $equipement->client_id )

                                                                    <option selected value="{{$client->id}}">{{$client->name}}</option>
                                                                @else
                                                                    <option value="{{$client->id}}">{{$client->name}}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
												</div>
												<div class="col-12">
                                                        <div class="form-group">
                                                            <label>Modèle<span class="text-danger">*</span></label>
                                                            <input class="form-control" type="text" name="modele" value="{{$equipement->modele}}">
                                                        </div>
												</div>

												<div class="col-12">
													<div class="form-group">
														<label>Numéro Série</label>
														<input class="form-control select edit_role" name="numserie" value="{{$equipement->numserie}}">
													</div>
												</div>


												<div class="col-12">
													<div class="form-group">
														<label>software</label>
														<input class="form-control select edit_role" name="software" value="{{$equipement->software}}">
													</div>
												</div>


												<div class="col-12">
													<div class="form-group">
														<label>Nombre planning préventif/an</label>
														<input class="form-control select edit_role" type="number" name="plan_prev" value="{{$equipement->plan_prev}}">
													</div>
												</div>

												<div class="col-12">
													<div class="form-group">
														<label>Date insatallation</label>
														<input type="date" value="{{$equipement->date_installation}}" class="form-control" name="date_installation">
													</div>
												</div>

											</div>
											<button type="submit" class="btn btn-primary btn-block">Modifier</button>
										</form>
									</div>
								</div>
							</div>
						</div>
						<!-- /Edit Details Modal -->
						</div>
                    </div>
                    <!-- /Personal Details -->



                 <!-- Liste des sous equipements -->
                 @if($equipement->sousequipements)
                 <div class="card-body">
                     <h5 class="card-title d-flex justify-content-between">
                         <span>Liste des sous-équipement</span>
                     </h5>
                     <div class="card">
                         <div class="card-body">
                             <div class="table-responsive">
                                 <table id="equipementsousequipement-table" class="datatable table table-hover table-center mb-0">
                                     <thead>
                                         <tr>

                                             <th>Designation</th>
                                             <th>Numéro Série</th>
                                             <th>Modèle</th>
                                             <th>Marque</th>

                                         </tr>
                                     </thead>
                                     <tbody>
                                        @foreach ($sousequipements as $sousequipement)
                                        <tr>
                                            <td>{{$sousequipement->designation}}</td>
                                            <td>{{$sousequipement->identifiant}}</td>
                                            <td>{{$sousequipement->modele}}</td>
                                            <td>{{$sousequipement->marque}}</td>
                                        </tr>
                                        @endforeach
                                     </tbody>
                                 </table>
                             </div>
                         </div>

                 @endif
                </div>
                 <!-- Change Password Tab -->
                <div id="password_tab" class="tab-pane fade">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Pièces remplacées</h5>
                            <div class="row">
                                <div class="col-md-10 col-lg-12">
                                    <form action="{{ route('equipements.addPiece', $equipement->id) }}" method="POST">
                                        @csrf
                                        <div class="row form-row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label>Désignation<span class="text-danger">*</span></label>
                                                    <input type="text" name="designation"  class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                    <div class="form-group">
                                                        <label>Numéro de série<span class="text-danger">*</span></label>
                                                      <input type="text" name="identifiant" class="form-control">
                                                    </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label>Modèle</label>
                                                    <input class="form-control" type="text" name="modele">
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label>Marque</label>
                                                    <input class="form-control" type="text" name="marque">
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label>Date de remplacement</label>
                                                    <input type="date" class="form-control" name="date_remplacement">
                                                </div>
                                            </div>

                                        </div>
                                        <button type="submit" class="btn btn-primary btn-block">Ajouter</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Change Password Tab -->




            </div>
        </div>
    </div>
    @endsection
    @push('page-js')

@endpush
