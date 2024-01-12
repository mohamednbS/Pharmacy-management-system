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
		<li class="breadcrumb-item active">Ajouter Intervention</li>
	</ul>
</div>
@endpush


@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="card">
			<div class="card-body custom-edit-service">

				<!-- Add Medicine -->
				<form method="post" enctype="multipart/form-data" autocomplete="off" action="{{route('interventions.store')}}">
					@csrf
					<div class="service-fields mb-3">
						<div class="row">
							<div class="col-lg-4">
								<div class="form-group">
									<label>Client<span class="text-danger">*</span></label>
									<select class="select2 form-select form-control" name="client_name">
                                    <option>--Sélectionner un client--</option>
										@foreach ($clients as $client)
											<option value="{{$client->name}}">{{$client->name}}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="form-group">
									<label>Equipement<span class="text-danger">*</span></label>
									<select class="select2 form-select form-control" name="equipement_name">
                                       <option>--Sélectionner un equipement--</option>
										@foreach ($equipements as $equipement)
											<option value="{{$equipement->modele.'--'.$equipement->numserie}}">{{$equipement->modele.'--'.$equipement->numserie }}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="form-group">
									<label>Sous equipement</label>
									<select class="select2 form-select form-control" name="souseq_name">
                                        <option>--Sélectionner un sous Equipement--</option>
										@foreach ($sousequipements as $sousequipement)
											<option value="{{$sousequipement->designation}}">{{$sousequipement->designation}}</option>
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
                                     <option >Sélectionner l'etat initial</option>
                                            <option value="Fonctionnel">Fonctionnel</option>
                                            <option value="Partiellement Fonctionnel">Partiellement Fonctionnel</option>
                                            <option value="Panne Intermittente">Panne Intermittente</option>
                                            <option value="A l'arrêt">A l'arrêt</option>
                                    </select>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label>Description panne<span class="text-danger">*</span></label>
									<input class="form-control" type="text" name="description_panne" placeholder="décrire la panne">
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
                                    <option >Sélectionner le mode d'appel</option>
                                        <option value="Mail">Mail</option>
                                        <option value="Téléphone">Téléphone</option>
                                        <option value="Fax">Fax</option>
                                        <option value="WhatsApp">WhatsApp</option>
                                    </select>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label>Heure/Date d'appel client<span class="text-danger">*</span></label>
									<input type="datetime-local" name="appel_client" class="form-control">
								</div>
							</div>
						</div>
					</div>

                    <div class="service-fields mb-3">
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label>Intervenant(s)<span class="text-danger">*</span></label>
								    <select class="select2 form-select form-control" name="destinateur">
                                       <option>--Sélectionner le/les inetervenant(s)--</option>
										@foreach ($users as $user)
											<option value="{{$user->name}}">{{$user->name}}</option>
										@endforeach
									</select>
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
							<div class="col-lg-6">
								<div class="form-group">
									<label>Date/Heure début<span class="text-danger">*</span></label>
									<input type="datetime-local" name="date_debut" class="form-control">
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label>Priorité</label>
                                    <select  class="select2 form-select form-control" name="priorite">
                                        <option >Sélectionner une priorité</option>
                                        <option value="Très urgent">Très urgent</option>
                                        <option value="Urgent">Urgent</option>
                                        <option value="Normale">Normale</option>
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
                                        <option >Sélectionner un etat</option>
                                        <option value="Demandé">Demandé</option>
                                        <option value="Diagnostic en Cours">Diagnostic en Cours</option>
                                        <option value="Reporté">Reporté</option>
                                        <option value="Attente BC">Attente BC</option>
                                        <option value="Attente Pièce">Attente Pièce</option>
                                        <option value="Devis à fournir">Devis à fournir</option>
                                        <option value="Mise en Attente">Mise en Attente</option>
                                        <option value="Attente Rapport">Attente Rapport</option>
                                        <option value="Clôturé Sans Rappport">Clôturé Sans Rappport</option>
                                        <option value="Cloture">Clôturé</option>
                                    </select>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label>Description de l'intervention</label>
                                    <input type="text" name="description_intervention" class="form-control" placeholder="décrire l'intervention">
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
