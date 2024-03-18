@extends('admin.layouts.app')

@push('page-header')
<div class="col">
	<h3 class="page-title">Gestion Interventions</h3>
	<ul class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Tableau de Bord</a></li>
		<li class="breadcrumb-item active">Aperçu Intervention</li>
	</ul>
</div>
@endpush

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="profile-header">

				<div class="col ml-md-n2 profile-user-info">

					<h4 class="user-name mb-3">Client : {{$intervention->client->name}}</h4>
					<h5 class="user-name mb-3">Equipmement : {{$intervention->equipement->modele.'-'.$intervention->equipement->numserie}}</h5>
                    <h5 class="user-name mb-3">Sous équipement:
                                @if($intervention->sousequipement)
                                {{$intervention->sousequipement->designation}}@endif
                    </h5>
                    <h6 class="user-name mb-3">Etat : {{$intervention->etat}}</h6>
				</div>


		</div>
		<div class="profile-menu">
			<ul class="nav nav-tabs nav-tabs-solid">
				<li class="nav-item">
					<a class="nav-link active" data-toggle="tab" href="#per_details_tab">Aperçu</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" data-toggle="tab" href="#password_tab">Historiques</a>
				</li>
			</ul>
		</div>

		<div class="tab-content profile-tab-cont">

			<!-- Aperçu intervention Tab -->
			<div class="tab-pane fade show active" id="per_details_tab">

				<!-- Aperçu intervention -->
				<div class="row">
					<div class="col-lg-12">
						<div class="card">
							<div class="card-body">
								<h5 class="card-title d-flex justify-content-between">
									<span>Aperçu</span>
									<a class="edit-link" data-toggle="modal" href="#edit_intervention_details"><i class="fa fa-edit mr-1"></i>Modifier</a>
                                    <a class="edit-link" data-toggle="modal" href="#ajout_sousintervention"><i class="fa fa-edit mr-1"></i>Ajouter sous-intervention</a>
									<span class="label label-primary"></span>


								</h5>


								<div class="row">
									<p class="col-sm-2 text-muted text-sm-right mv-0 mb-sm-3">État initial d'équipement</p>
									<p class="col-sm-10">	{{$intervention->etat_initial}}</p>
								</div>

								<div class="row">
									<p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Description de la Panne</p>
									<p class="col-sm-10">{{$intervention->description_panne}}</p>
								</div>

                                <div class="row">
									<p class="col-sm-2 text-muted text-sm-right mv-0 mb-sm-3">Heure/Date d'appel client</p>
									<p class="col-sm-10">	{{$intervention->appel_client}}</p>
								</div>

                                <div class="row">
									<p class="col-sm-2 text-muted text-sm-right mv-0 mb-sm-3">Mode d'appel client</p>
									<p class="col-sm-10">	{{$intervention->mode_appel}}</p>
								</div>

								<div class="row">
									<p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Intervenant(s)</p>
									<p class="col-sm-10">
                                        @if (is_array($intervention->destinateur))
                                        {{
                                           implode(', ', $intervention->destinateur)
                                         }}
                                        @endif
                                    </p>
								</div>

                                <div class="row">
									<p class="col-sm-2 text-muted text-sm-right mv-0 mb-sm-3">Sous-traitant</p>
                                    @if($intervention->soustraitant)
                                    <p class="col-sm-10">{{$intervention->soustraitant->name}}@endif</p>
								</div>

                                <div class="row">
									<p class="col-sm-2 text-muted text-sm-right mv-0 mb-sm-3">Date/Heure de début</p>
									<p class="col-sm-10">	{{$intervention->date_debut}}</p>
								</div>

                                <div class="row">
									<p class="col-sm-2 text-muted text-sm-right mv-0 mb-sm-3">Date/Heure de fin</p>
									<p class="col-sm-10">	{{$intervention->date_fin}}</p>
								</div>

                                <div class="row">
									<p class="col-sm-2 text-muted text-sm-right mv-0 mb-sm-3">Description de l'intervention</p>
									<p class="col-sm-10">{{$intervention->description_intervention}}</p>
								</div>

                                <div class="row">
									<p class="col-sm-2 text-muted text-sm-right mv-0 mb-sm-3">État final d'équipement</p>
									<p class="col-sm-10">	{{$intervention->etat_final}}</p>
								</div>

						</div>
                        <!-- Edit Details Modal -->
						<div class="modal fade" id="edit_intervention_details" aria-hidden="true" role="dialog">
							<div class="modal-dialog modal-dialog-centered" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title">Détails intervention</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<form method="post" enctype="multipart/form-data" action="{{route('interventions.update',$intervention)}}">
											@csrf
											@method("PUT")
											<div class="row form-row">
												<div class="col-12">
                                                    <div class="form-group">
                                                        <label>Client <span class="text-danger">*</span></label>
                                                        <select class="select2 form-select form-control" name="client_id">
                                                            @foreach ($clients as $client)
                                                                @if ($client->id == $intervention->client_id )

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
                                                            <label>Equipement<span class="text-danger">*</span></label>
                                                            <select class="form-control" type="text" name="equipement_name">
															@foreach ($equipements as $equipement)
																@if ($equipement->modele.'--'.$equipement->numserie == $intervention->equipement_name)
																	<option selected value="{{$equipement->modele.'--'.$equipement->numserie}}">{{$equipement->modele.'--'.$equipement->numserie }}</option>
																@else
																	<option value="{{$equipement->modele.'--'.$equipement->numserie}}">{{$equipement->modele.'--'.$equipement->numserie }}</option>
																@endif
																@endforeach
															</select>
                                                        </div>
												</div>

												<div class="col-12">
													<div class="form-group">
														<label>Description Panne</label>
														<input class="form-control select edit_role" name="numserie" value="{{$intervention->description_panne}}">
													</div>
												</div>

												<div class="col-12">
													<div class="form-group">
														<label>Date/Heure Début</label>
														<input type="datetime-local" value="{{$intervention->date_debut}}" class="form-control" name="date_debut">
													</div>
												</div>

											</div>
											<button type="submit" class="btn btn-primary btn-block">Modifier</button>
										</form>
									</div>
								</div>
							</div>
						</div>
						<!-- /Edit Details intervention -->

                        <!-- Ajout sous intervention -->
						<div class="modal fade" id="ajout_sousintervention" aria-hidden="true" role="dialog">
							<div class="modal-dialog modal-dialog-centered" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title">Ajouter une sous-intervention</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<form method="post" enctype="multipart/form-data" action="{{ route('sousinterventions.store', ['intervention_id' => $intervention->id]) }}">
										@csrf
											<div class="row form-row">
												<div class="col-12">
                                                    <div class="form-group">
                                                        <label>Date/Heure début <span class="text-danger">*</span></label>
             											<input type="datetime-local" name="date_debut" class="form-control">
                                                    </div>
												</div>
												<div class="col-12">
                                                    <div class="form-group">
                                                        <label>Date/Heure fin <span class="text-danger">*</span></label>
             											<input type="datetime-local" name="date_fin" class="form-control">
                                                    </div>
												</div>

												<div class="col-12">
													<div class="form-group">
														<label>Equipement avant visite<span class="text-danger">*</span></label>
														<select  class="select2 form-select form-control" name="etat_initial">
															<option >Sélectionner l'etat initial</option>
															<option value="Fonctionnel">Fonctionnel</option>
															<option value="Partiellement Fonctionnel">Partiellement Fonctionnel</option>
															<option value="Panne Intermittente">Panne Intermittente</option>
															<option value=" l'arrêt">A l'arrêt</option>

														</select>
													</div>
												</div>

												<div class="col-12">
													<div class="form-group">
														<label>Intervenant(s)</label>
														<select  class="select2 form-select form-control" name="intervenant[]" multiple>
															<option >Sélectionner l'intervenant(s)</option>
															@foreach($users as $user)
																<option value="{{ $user->name }}">{{ $user->name }}</option>
															@endforeach
														</select>
													</div>
												</div>

												<div class="col-12">
													<div class="form-group">
														<label>Description</label>
														<input type="text" name="description_panne" class="form-control">
													</div>
												</div>


											<button type="submit" class="btn btn-primary btn-block">Valider</button>
										</form>
									</div>
								</div>
							</div>
						</div>
						<!-- /Ajout sous-intervention -->

					</div>

                    <!-- /Aperçcu-->

                </div>
                <!-- /Personal Details Tab -->

                    <!-- Sous interventions -->
                    <div id="password_tab" class="tab-pane fade">

                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Sous-interventions</h5>
                                <div class="row">
                                    <div class="col-md-10 col-lg-12">
                                        <!-- Liste des sous-interventions -->
                                        @if($intervention->sousinterventions)
                                        <div class="card-body">
                                            <h5 class="card-title d-flex justify-content-between">
                                                <span>Historique de l'intervention</span>
                                            </h5>
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table id="sousinterventions-table" class="datatable table table-hover table-center mb-0">
                                                            <thead>
                                                                <tr>

                                                                    <th>Date début</th>
                                                                    <th>Date fin</th>
                                                                    <th>Etat initial</th>
                                                                    <th>Description</th>
                                                                   

                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($sousinterventions as $sousintervention)
                                                                <tr>
                                                                    <td>{{$sousintervention->date_debut}}</td>
                                                                    <td>{{$sousintervention->date_fin}}</td>
                                                                    <td>{{$sousintervention->etat_initial}}</td>
                                                                    <td>{{$sousintervention->description_panne}}</td>

                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                        @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Sous interventions -->

            </div>
        </div>
    </div>
    @endsection
