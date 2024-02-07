@extends('admin.layouts.app')

@push('page-css')
	<!-- Datetimepicker CSS -->
	<link rel="stylesheet" href="{{asset('assets/css/bootstrap-datetimepicker.min.css')}}">
@endpush

@push('page-header')
<div class="col-sm-12">
	<h3 class="page-title">Gestion Interventions</h3>
	<ul class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
		<li class="breadcrumb-item active">Modifier Intervention</li>
	</ul>
</div>
@endpush


@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="card">
			<div class="card-body custom-edit-service">

				<!-- Add Medicine -->
				<form method="post" enctype="multipart/form-data" autocomplete="off" action="{{route('interventions.update',$intervention)}}">
					@csrf
					@method("PUT")
					<div class="service-fields mb-3">
						<div class="row">
							<div class="col-lg-4">
								<div class="form-group">
									<label>Client<span class="text-danger">*</span></label>
									<select class="select2 form-select form-control" name="client_name">
                                    <option>--Sélectionner un client--</option>
										@foreach ($clients as $client)
										@if ($client->name == $intervention->client_name)
											<option selected value="{{$client->name}}">{{$client->name}}</option>
										@else
										    <option value="{{$client->name}}">{{$client->name}}</option>
										@endif
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="form-group">
									<label>Equipement<span class="text-danger">*</span></label>
									<select class="select2 form-select form-control" name="equipement_name">

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
							<div class="col-lg-4">
								<div class="form-group">
									<label>Sous equipement</label>
									<select class="select2 form-select form-control" name="souseq_name">

                                            @foreach($sousequipements as $sousequipement )
                                            @if ($sousequipement->name == $intervention->souseq_name)
                                                <option selected value='{{ $sousequipement->name }}'>{{ $sousequipement->name }}</option>
                                            @else
                                                <option value='{{ $sousequipement->name }}'>{{ $sousequipement->name }}</option>
                                            @endif
                                            @endforeach
									</select>
								</div>
							</div>
						</div>
					</div>

					<div class="service-fields mb-3">
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label>Etat initial d'equipement<span class="text-danger">*</span></label>
									<select  class="select2 form-select form-control" name="type_panne">

                                        @if ( $intervention->type_panne == "Fonctionnel")

										<option selected value='Fonctionnel'>Fonctionnel</option>
										<option value="Partiellement Fonctionnel">Partiellement Fonctionnel</option>
										<option value="Panne Intermittente">Panne Intermittente</option>
										<option value="A l'arrêt">A l'arrêt</option>

										@elseif ($intervention->type_panne == "Partiellement Fonctionnel")

										<option selected value='Partiellement Fonctionnel'>Partiellement Fonctionnel</option>
										<option value='Fonctionnel'>Fonctionnel</option>
										<option value="Panne Intermittente">Panne Intermittente</option>
										<option value="A l'arrêt">A l'arrêt</option>

										@elseif ($intervention->type_panne == "Panne Intermittente")
										<option selected value='Panne Intermittente'>Panne Intermittente</option>
										<option value='Partiellement Fonctionnel'>Partiellement Fonctionnel</option>
										<option value='Fonctionnel'>Fonctionnel</option>
										<option value="A l'arrêt">A l'arrêt</option>

										@else

										<option selected value="A l'arrêt">A l'arrêt</option>
										<option value='Panne Intermittente'>Panne Intermittente</option>
										<option value='Partiellement Fonctionnel'>Partiellement Fonctionnel</option>
										<option value='Fonctionnel'>Fonctionnel</option>
                                        @endif
                                    </select>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label>Description panne<span class="text-danger">*</span></label>
									<input class="form-control" type="text" name="description_panne" placeholder="décrire la panne" value="{{$intervention->description_panne}}">
								</div>
							</div>
						</div>
					</div>

					<div class="service-fields mb-3">
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label>Mode d'appel client<span class="text-danger">*</span></label>
									<select  class="select2 form-select form-control" name="mode_appel">
                                        @if ( $intervention->etat == "Mail")

										<option selected value='Mail'>Mail</option>
										<option value="Téléphone">Téléphone</option>
                                        <option value="Fax">Fax</option>
                                        <option value="WhatsApp">WhatsApp</option>

										@elseif ($intervention->etat == "Téléphone")

										<option selected value='Téléphone'>Téléphone</option>
										<option value='Mail'>Mail</option>
										<option value="Fax">Fax</option>
                                        <option value="WhatsApp">WhatsApp</option>

										@elseif ($intervention->etat == "WhatsApp")
										<option selected value='WhatsApp'>WhatsApp</option>
										<option value="Mail">Mail</option>
                                        <option value="Téléphone">Téléphone</option>
                                        <option value="WhatsApp">WhatsApp</option>

										@else

										<option selected value='Fax'>Fax</option>
										<option value="Mail">Mail</option>
                                        <option value="Téléphone">Téléphone</option>
                                        <option value="WhatsApp">WhatsApp</option>
                                        @endif
                                    </select>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label>Heure/Date d'appel client<span class="text-danger">*</span></label>
									<input type="datetime-local" name="appel_client" class="form-control" value="{{$intervention->appel_client}}">
								</div>
							</div>
						</div>
					</div>

                    <div class="service-fields mb-3">
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label for="destinateur">Intervenant(s) <span class="text-danger">*</span></label>
									<select class="select2 form-select form-control" name="destinateur[]" multiple>
                                        @foreach($users as $user)
                                            @if(in_array($user->name, $intervention->destinateur))
                                                <option selected value='{{ $user->name }}'>{{ $user->name }}</option>
                                            @else
                                                <option value='{{ $user->name }}'>{{ $user->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                <div>
							</div>

							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label>Sous-traitant</label>
									<select  class="select2 form-select form-control" name="soustraitant_name">
                                    <option >Sélectionner le sous-traitant</option>
                                        <option value="CMI">CMI</option>
                                        <option value="Tiamed">Tiamed</option>
                                        <option value="Fax">Fax</option>
                                        <option value="WhatsApp">WhatsApp</option>
                                    </select>
								</div>
							</div>
						</div>
					</div>

                    <div class="service-fields mb-3">
						<div class="row">
							<div class="col-lg-4">
								<div class="form-group">
									<label>Date/Heure début<span class="text-danger">*</span></label>
									<input type="datetime-local" name="date_debut" class="form-control" value="{{$intervention->date_debut}}">
								</div>
							</div>
                            <div class="col-lg-4">
								<div class="form-group">
									<label>Date/Heure fin<span class="text-danger">*</span></label>
									<input type="datetime-local" name="date_fin" class="form-control"
                                    value="{{$intervention->date_fin ?? old('date_fin')}}">{{$intervention->date_fin}}
								</div>
							</div>
							<div class="col-lg-4">
								<div class="form-group">
									<label>Priorité</label>
                                    <select  class="select2 form-select form-control" name="priorite">
                                        @if ( $intervention->etat == "Tres urgent")

                                        <option >Selectionner une priorité</option>
                                        <option selected value='Tres urgent'>Tres urgent</option>
                                        <option value="Urgent">Urgent</option>
                                        <option value="Normale">Normale</option>

                                        @elseif ($intervention->etat == "Urgent")

                                        <option>-- Sélectionner une priorité--</option>
                                        <option selected value='Urgent'>Urgent</option>
                                        <option value='Normale'>Normale</option>
                                        <option value='Tres urgent'>Tres urgent</option>

                                        @else

                                        <option>-- Sélectionner une priorité --</option>
                                        <option selected value='Normale'>Normale</option>
                                        <option value='Tres urgent'>Tres urgent</option>
                                        <option value='Urgent'>Urgent</option>

                                    @endif
                                    </select>
								</div>
							</div>
						</div>
					</div>

							<div class="service-fields mb-3">
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<label>Etat<span class="text-danger">*</span></label>
											<select  class="select2 form-select form-control" name="etat">
											@if ( $intervention->etat == "Demandé")
											<option>-- Sélectionner un Etat --</option>
											<option selected value='Demandé'>Demandé</option>
											<option value="Diagnostic en Cours">Diagnostic en Cours</option>
											<option value="Reporté">Reporté</option>
											<option value="Attente BC">Attente BC</option>
											<option value="Attente Pièce">Attente Pièce</option>
											<option value="Devis à fournir">Devis à fournir</option>
											<option value="Mise en Attente">Mise en Attente</option>
											<option value="Attente Rapport">Attente Rapport</option>
											<option value="Clôturé Sans Rappport">Clôturé Sans Rappport</option>
											<option value="Poursuivre le Diagnostic">Poursuivre le Diagnostic</option>
											<option value="Clôturé par Téléphone">Clôturé par Téléphone</option>
											<option value="Clôturé à Distance">Clôturé à Distance</option>
											<option value="Cloture">Clôturé </option>

										    @elseif ($intervention->etat == "Diagnostic en Cours")
											<option>-- Sélectionner un Etat --</option>
											<option selected value='Diagnostic en Cours'>Diagnostic en Cours</option>
											<option value='Demandé'>Demandé</option>
											<option value="Reporté">Reporté</option>
											<option value="Attente BC">Attente BC</option>
											<option value="Attente Pièce">Attente Pièce</option>
											<option value="Devis à fournir">Devis à fournir</option>
											<option value="Mise en Attente">Mise en Attente</option>
											<option value="Attente Rapport">Attente Rapport</option>
											<option value="Clôturé Sans Rappport">Clôturé Sans Rappport</option>
											<option value="Poursuivre le Diagnostic">Poursuivre le Diagnostic</option>
											<option value="Clôturé par Téléphone">Clôturé par Téléphone</option>
											<option value="Clôturé à Distance">Clôturé à Distance</option>
											<option value="Cloture">Clôturé </option>

										    @elseif ($intervention->etat == "Reporté")
											<option>-- Sélectionner un Etat --</option>
											<option selected value='Reporté'>Reporté</option>
											<option value='Demandé'>Demandé</option>
											<option value="Diagnostic en Cours">Diagnostic en Cours</option>
											<option value="Attente BC">Attente BC</option>
											<option value="Attente Pièce">Attente Pièce</option>
											<option value="Devis à fournir">Devis à fournir</option>
											<option value="Mise en Attente">Mise en Attente</option>
											<option value="Attente Rapport">Attente Rapport</option>
											<option value="Clôturé Sans Rappport">Clôturé Sans Rappport</option>
											<option value="Poursuivre le Diagnostic">Poursuivre le Diagnostic</option>
											<option value="Clôturé par Téléphone">Clôturé par Téléphone</option>
											<option value="Clôturé à Distance">Clôturé à Distance</option>
											<option value="Cloture">Clôturé </option>

										    @elseif ($intervention->etat == "Attente BC")
											<option>-- Sélectionner un Etat --</option>
											<option selected value='Attente BC'>Attente BC</option>
											<option value='Demandé'>Demandé</option>
											<option value="Diagnostic en Cours">Diagnostic en Cours</option>
											<option value="Reporté">Reporté</option>
											<option value="Reporté">Reporté</option>
											<option value="Attente BC">Attente BC</option>
											<option value="Attente Pièce">Attente Pièce</option>
											<option value="Devis à fournir">Devis à fournir</option>
											<option value="Mise en Attente">Mise en Attente</option>
											<option value="Attente Rapport">Attente Rapport</option>
											<option value="Clôturé Sans Rappport">Clôturé Sans Rappport</option>
											<option value="Poursuivre le Diagnostic">Poursuivre le Diagnostic</option>
											<option value="Clôturé par Téléphone">Clôturé par Téléphone</option>
											<option value="Clôturé à Distance">Clôturé à Distance</option>
											<option value="Cloture">Clôturé </option>

										    @elseif ($intervention->etat == "Attente Pièce")
											<option>-- Sélectionner un Etat --</option>
											<option selected value='Attente Pièce'>Attente Pièce</option>
											<option value='Demandé'>Demandé</option>
											<option value="Diagnostic en Cours">Diagnostic en Cours</option>
											<option value="Reporté">Reporté</option>
											<option value="Attente BC">Attente BC</option>
											<option value="Devis à fournir">Devis à fournir</option>
											<option value="Mise en Attente">Mise en Attente</option>
											<option value="Attente Rapport">Attente Rapport</option>
											<option value="Clôturé Sans Rappport">Clôturé Sans Rappport</option>
											<option value="Poursuivre le Diagnostic">Poursuivre le Diagnostic</option>
											<option value="Clôturé par Téléphone">Clôturé par Téléphone</option>
											<option value="Clôturé à Distance">Clôturé à Distance</option>
											<option value="Cloture">Clôturé </option>

										    @elseif ($intervention->etat == "Devis à fournir")
											<option>-- Sélectionner un Etat --</option>
											<option selected value='Devis à fournir'>Devis à fournir</option>
											<option value='Demandé'>Demandé</option>
											<option value="Diagnostic en Cours">Diagnostic en Cours</option>
											<option value="Reporté">Reporté</option>
											<option value="Attente BC">Attente BC</option>
											<option value="Attente Pièce">Attente Pièce</option>
											<option value="Mise en Attente">Mise en Attente</option>
											<option value="Attente Rapport">Attente Rapport</option>
											<option value="Clôturé Sans Rappport">Clôturé Sans Rappport</option>
											<option value="Poursuivre le Diagnostic">Poursuivre le Diagnostic</option>
											<option value="Clôturé par Téléphone">Clôturé par Téléphone</option>
											<option value="Clôturé à Distance">Clôturé à Distance</option>
											<option value="Cloture">Clôturé </option>

										    @elseif ($intervention->etat == "Mise en Attente")
											<option>-- Sélectionner un Etat --</option>
											<option selected value='Mise en Attente'>Mise en Attente</option>
											<option value='Demandé'>Demandé</option>
											<option value="Diagnostic en Cours">Diagnostic en Cours</option>
											<option value="Reporté">Reporté</option>
											<option value="Attente BC">Attente BC</option>
											<option value="Attente Pièce">Attente Pièce</option>
											<option value="Devis à fournir">Devis à fournir</option>
											<option value="Attente Rapport">Attente Rapport</option>
											<option value="Clôturé Sans Rappport">Clôturé Sans Rappport</option>
											<option value="Poursuivre le Diagnostic">Poursuivre le Diagnostic</option>
											<option value="Clôturé par Téléphone">Clôturé par Téléphone</option>
											<option value="Clôturé à Distance">Clôturé à Distance</option>
											<option value="Cloture">Clôturé </option>

										    @elseif ($intervention->etat == "Attente Rapport")
											<option>-- Sélectionner un Etat --</option>
											<option selected value='Attente Rapport'>Attente Rapport</option>
											<option value='Demandé'>Demandé</option>
											<option value="Diagnostic en Cours">Diagnostic en Cours</option>
											<option value="Reporté">Reporté</option>
											<option value="Attente BC">Attente BC</option>
											<option value="Attente Pièce">Attente Pièce</option>
											<option value="Devis à fournir">Devis à fournir</option>
											<option value="Mise en Attente">Mise en Attente</option>
											<option value="Clôturé Sans Rappport">Clôturé Sans Rappport</option>
											<option value="Poursuivre le Diagnostic">Poursuivre le Diagnostic</option>
											<option value="Clôturé par Téléphone">Clôturé par Téléphone</option>
											<option value="Clôturé à Distance">Clôturé à Distance</option>
											<option value="Cloture">Clôturé </option>

										    @elseif ($intervention->etat == "Clôturé Sans Rappport")
											<option>-- Sélectionner un Etat --</option>
											<option selected value='Clôturé Sans Rappport'>Clôturé Sans Rappport</option>
											<option value='Demandé'>Demandé</option>
											<option value="Diagnostic en Cours">Diagnostic en Cours</option>
											<option value="Reporté">Reporté</option>
											<option value="Attente BC">Attente BC</option>
											<option value="Attente Pièce">Attente Pièce</option>
											<option value="Devis à fournir">Devis à fournir</option>
											<option value="Mise en Attente">Mise en Attente</option>
											<option value="Attente Rapport">Attente Rapport</option>
											<option value="Poursuivre le Diagnostic">Poursuivre le Diagnostic</option>
											<option value="Clôturé par Téléphone">Clôturé par Téléphone</option>
											<option value="Clôturé à Distance">Clôturé à Distance</option>
											<option value="Cloture">Clôturé </option>
											<option value='Terminé'>Terminé</option>

										    @else
											<option>-- Sélectionner un Etat --</option>
											<option selected value='Clôturé'>Clôturé</option>
											<option value='Demandé'>Demandé</option>
											<option value="Diagnostic en Cours">Diagnostic en Cours</option>
											<option value="Reporté">Reporté</option>
											<option value="Attente BC">Attente BC</option>
											<option value="Attente Pièce">Attente Pièce</option>
											<option value="Devis à fournir">Devis à fournir</option>
											<option value="Mise en Attente">Mise en Attente</option>
											<option value="Attente Rapport">Attente Rapport</option>
											<option value="Cloture">En Cours</option>
											<option value="Poursuivre le Diagnostic">Poursuivre le Diagnostic</option>
											<option value="Clôturé par Téléphone">Clôturé par Téléphone</option>
											<option value="Clôturé à Distance">Clôturé à Distance</option>
											<option value="Clôturé Sans Rappport">Clôturé Sans Rappport</option>
										    @endif
											</select>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label>Description de l'intervention</label>
											<input type="text" name="description_intervention" class="form-control" placeholder="décrire l'intervention" value="{{$intervention->description_intervention ?? old('description intervention')}}">{{$intervention->description_intervention}}
										</div>
									</div>
								</div>

									<div class="service-fields mb-3">
										<div class="row">
											<div class="col-12">
												<label>Rapport d'intervention</label>
												<input type="file" class="form-control" name='rapport' value="{{$intervention->rapport ?? old('rapport')}}">{{$intervention->rapport}}
											</div>
										</div>
									</div>

					</div>


					<div class="submit-section">
						<button class="btn btn-primary submit-btn" type="submit" >Valider</button>
					</div>
				</form>
				<!-- /Add Medicine -->

			</div>
		</div>
	</div>
</div>
@endsection

@push('page-js')
	<!-- Datetimepicker JS -->
	<script src="{{asset('assets/js/moment.min.js')}}"></script>
	<script src="{{asset('assets/js/bootstrap-datetimepicker.min.js')}}"></script>
@endpush
