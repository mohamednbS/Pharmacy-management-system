@extends('admin.layouts.app')

@push('page-css')
	<!-- Datetimepicker CSS -->
	<link rel="stylesheet" href="{{asset('assets/css/bootstrap-datetimepicker.min.css')}}">
@endpush

@push('page-header')
<div class="col-sm-12">
	<h3 class="page-title">Gestion Contrats Maintenance</h3>
	<ul class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Tableau de Bord</a></li>
		<li class="breadcrumb-item active">Ajouter Contrat maintenance</li>
	</ul>
</div>
@endpush


@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="card">
			<div class="card-body custom-edit-service">

				<!-- Add Contrat -->
				<form method="post" enctype="multipart/form-data" autocomplete="off" action="{{route('contrats.store')}}">
					@csrf
					<div class="service-fields mb-3">
						<div class="row">
							<div class="col-lg-4">
								<div class="form-group">
									<label>Client<span class="text-danger">*</span></label>
									<select id="client" onchange="getEquipements(this.value)" class="select2 form-select form-control" name="client">
										<option value="Sélectionner un Client">Sélectionner un Client</option>
										@foreach ($clients as $client)
											<option value="{{ $client->id }}">{{ $client->name }}</option>
										@endforeach
								   </select>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="form-group">
									<label for="equipement">Equipement<span class="text-danger">*</span></label>
									<select id="equipement" onchange="getSousequipements(this.value)" class="select2 form-select form-control" name="equipement">
										<option value="Sélectionner un equipement">Sélectionner un Equipement</option>
									</select>
								</div>
						    </div>
							<div class="col-lg-4">
								<div class="form-group">
	                                <label>Etat contrat<span class="text-danger">*</span></label>
									<select  class="select2 form-select form-control" name="status">
                                        <option >--Sélectionner l'Etat du Contrat--</option>
                                        <option value="En cours">En cours</option>
                                        <option value="Proche expiration">Proche expiration</option>
                                        <option value="Renouvelé">Renouvelé</option>
                                        <option value="Expiré">Expiré</option>
                                        <option value="Attente approbation">Attente approbation</option>
                                        <option value="En cours rénégociation">En cours rénégociation</option>
									</select>
								</div>
							</div>
						</div>
					</div>

					<div class="service-fields mb-3">
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
								    <label>Date début<span class="text-danger">*</span></label>
									<input type="date" name="date_debut" class="form-control">
								</div>
							</div>

							<div class="col-lg-6">
								<div class="form-group">
								    <label>Date fin<span class="text-danger">*</span></label>
									<input type="date" name="date_fin" class="form-control">
								</div>
							</div>
						</div>
					</div>
					<div class="service-fields mb-3">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Type contrat<span class="text-danger">*</span></label>
                                    <select  class="select2 form-select form-control" name="type_contrat">
									<option >Sélectionner le type contrat</option>
									<option value="Contrat pieces et main oeuvre">Contrat pieces et main oeuvre</option>
									<option value="Contrat main oeuvre">Contrat main oeuvre</option>
									</select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="service-fields mb-3">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Notes</label>
                                    <textarea class="form-control service-desc" name="note" placeholder="Ecrire une note"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>


					<div class="submit-section">
                        <a href="{{route('contrats.index')}}" class="btn btn-danger submit-btn">Annuler</a>
						<button class="btn btn-primary submit-btn" type="submit" >Valider</button>
					</div>
				</form>
				<!-- /Add Contrat -->

			</div>
		</div>
	</div>
</div>
@endsection

@push('page-js')
	<!-- Datetimepicker JS -->
	<script src="{{asset('assets/js/moment.min.js')}}"></script>
	<script src="{{asset('assets/js/bootstrap-datetimepicker.min.js')}}"></script>
	<script>
        function getEquipements(clientId) {
            fetch('/getEquipements?client_id=' + clientId)
                .then(response => response.json())
                .then(data => {
                    const equipementSelect = document.getElementById('equipement');
                    equipementSelect.innerHTML = '<option value="">Selectionner un Equipement</option>';
                    data.forEach(equipement => {
                        const option = document.createElement('option');
                        option.value = equipement.id;
                        option.text = equipement.modele;
                        equipementSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching equipements:', error));
        }
    </script>
@endpush

