@extends('admin.layouts.app')

@push('page-css')
	<!-- Datetimepicker CSS -->
	<link rel="stylesheet" href="{{asset('assets/css/bootstrap-datetimepicker.min.css')}}">
@endpush

@push('page-header')
<div class="col-sm-12">
	<h3 class="page-title">Gestion Equipements</h3>
	<ul class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Tableau de Bord</a></li>
		<li class="breadcrumb-item active">Ajouter Equipement</li>
	</ul>
</div>
@endpush


@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="card">
			<div class="card-body custom-edit-service">

				<!-- Add equipement -->
				<form method="post" enctype="multipart/form-data" autocomplete="off" action="{{route('equipements.store')}}">
					@csrf
					<div class="service-fields mb-3">
						<div class="row">
							<div class="col-lg-4">
								<div class="form-group">
									<label>Code</label>
									<input class="form-control" type="text" name="code" placeholder="Saisir le code de l'équipement">
								</div>
							</div>
							<div class="col-lg-4">
								<div class="form-group">
									<label>Client <span class="text-danger">*</span></label>
									<select class="select2 form-select form-control" name="client_id">
                                        <option value="Sélectionner un client">Sélectionner un client</option>
										@foreach ($clients as $client)
											<option value="{{$client->id}}">{{$client->name}}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="form-group">
									<label>Modalité <span class="text-danger">*</span></label>
									<select class="select2 form-select form-control" name="modalite_id">
                                        <option value="Sélectionner une modalité">Sélectionner une modalité</option>
										@foreach ($modalites as $modalite)
											<option value="{{$modalite->id}}">{{$modalite->name}}</option>
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
									<label>Désignation<span class="text-danger">*</span></label>
									<input class="form-control" type="text" name="designation" placeholder="Exemple: CT, IRM, CV,US, MATC, PACS, Robot de gravure, RADIO MOBILE">
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label>Modèle<span class="text-danger">*</span></label>
									<input class="form-control" type="text" name="modele" placeholder="Saisir le modéle de l'équipement">
								</div>
							</div>
						</div>
					</div>

					<div class="service-fields mb-3">
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label>Numéro Série<span class="text-danger">*</span></label>
									<input class="form-control" type="text" name="numserie" placeholder="Saisir le numéro de série de l'équipement">
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label>Marque</label>
									<input class="form-control" type="text" name="marque" placeholder="Saisir la marque de l'équipement">
								</div>
							</div>
						</div>
					</div>

					<div class="service-fields mb-3">
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label>Date Installation</label>
									<input class="form-control" type="date" name="date_installation" placeholder="Saisir la date d'installation">
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label>Software</label>
									<input type="text" name="software" class="form-control" placeholder="Saisir la version du software">
								</div>
							</div>
						</div>
					</div>

                    <div class="service-fields mb-3">
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label>Nombre Planning Préventif/an</label>
									<input class="form-control" type="number" name="plan_prev" placeholder="Saisir le nombre de planning préventif/an">
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label>Fiche Technique</label>
									<input type="file" name="document" class="form-control" placeholder="Importer la fiche technique">
								</div>
							</div>
						</div>
					</div>




					<div class="submit-section">
                        <a href="{{route('equipements.index')}}" class="btn btn-danger submit-btn">Annuler</a>
						<button class="btn btn-primary submit-btn" type="submit" >Valider</button>
					</div>
				</form>
				<!-- /Add Equipement -->

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

