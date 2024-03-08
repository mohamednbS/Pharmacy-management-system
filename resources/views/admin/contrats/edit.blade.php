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
		<li class="breadcrumb-item active">Modifier Contrat maintenance</li>
	</ul>
</div>
@endpush


@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="card">
			<div class="card-body custom-edit-service">

				<!-- Add Contrat -->
				<form method="post" enctype="multipart/form-data" autocomplete="off" action="{{route('contrats.update',$contrat)}}">
					@csrf
                    @method("PUT")
					<div class="service-fields mb-3">
						<div class="row">
							<div class="col-lg-4">
								<div class="form-group">
									<label>Client<span class="text-danger">*</span></label>
									<select id="client" onchange="getEquipements(this.value)" class="select2 form-select form-control" name="client">
										<option value="Sélectionner un Client">Sélectionner un Client</option>
										@foreach ($clients as $client)
											<option value="{{ $client->id }}"
												{{ ($contrat->client_id ?? null) === $client->id ? 'selected' : '' }}>
												{{ $client->name }}
											</option>
									    @endforeach
								   </select>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="form-group">
									<label for="equipement">Equipement<span class="text-danger">*</span></label>
									<select id="equipement" onchange="getSousequipements(this.value)" class="select2 form-select form-control" name="equipement">
										<option value="Sélectionner un equipement">Sélectionner un Equipement</option>
                                        @foreach ($equipements as $equipement)
										<option value="{{ $equipement->id }}"
											{{ ($contrat->equipement_id ?? null) === $equipement->id ? 'selected' : '' }}>
											{{ $equipement->modele }}
										</option>
									    @endforeach
									</select>
								</div>
						    </div>
							<div class="col-lg-4">
								<div class="form-group">
	                                <label>Etat contrat<span class="text-danger">*</span></label>
									<select  class="select2 form-select form-control" name="status">
									<option >Sélectionner etat contrat</option>
                                    @if ( $contrat->status == "En cours")
                                        <option >Sélectionner l'état du contrat</option>
                                        <option selected value='En cours'>En cours</option>
                                        <option value='Proche expiration'>Proche expiration</option>
                                        <option value='Renouvelé'>Renouvelé</option>
                                        <option value='Expiré'>Expiré</option>
                                        <option value='Attente approbation'>Attente approbation</option>
                                        <option value='En cours rénégociation'>En cours rénégociation</option>

                                    @elseif ( $contrat->status == "Proche expiration")
                                        <option >Sélectionner l'état du contrat</option>
                                        <option selected value='Proche expiration'>Proche expiration</option>
                                        <option value='En cours'>En cours</option>
                                        <option value='Renouvelé'>Renouvelé</option>
                                        <option value='Expiré'>Expiré</option>
                                        <option value='Attente approbation'>Attente approbation</option>
                                        <option value='En cours rénégociation'>En cours rénégociation</option>

                                    @elseif ( $contrat->status == "Renouvelé")
                                        <option >Sélectionner l'état du contrat</option>
                                        <option selected value='Renouvelé'>Renouvelé</option>
                                        <option value='En cours'>En cours</option>
                                        <option value='Proche expiration'>Proche expiration</option>
                                        <option value='Expiré'>Expiré</option>
                                        <option value='Attente approbation'>Attente approbation</option>
                                        <option value='En cours rénégociation'>En cours rénégociation</option>

                                    @elseif ( $contrat->status == "Expiré")
                                        <option >Sélectionner l'état du contrat</option>
                                        <option selected value='Expiré'>Expiré</option>
                                        <option value='En cours'>En cours</option>
                                        <option value='Proche expiration'>Proche expiration</option>
                                        <option value='Renouvelé'>Renouvelé</option>
                                        <option value='Attente approbation'>Attente approbation</option>
                                        <option value='En cours rénégociation'>En cours rénégociation</option>

                                    @elseif ( $contrat->status == "Attente approbation")
                                        <option >Sélectionner l'état du contrat</option>
                                        <option selected value='Attente approbation'>Attente approbation</option>
                                        <option value='En cours'>En cours</option>
                                        <option value='Proche expiration'>Proche expiration</option>
                                        <option value='Renouvelé'>Renouvelé</option>
                                        <option value='Expiré'>Expiré</option>
                                        <option value='En cours rénégociation'>En cours rénégociation</option>


                                    @else
                                        <option >Sélectionner l'état du contrat</option>

                                        <option value='En cours rénégociation'>En cours rénégociation</option>
                                        <option selected value='En cours'>En cours</option>
                                        <option selected value='Proche expiration'>Proche expiration</option>
                                        <option selected value='Renouvelé'>Renouvelé</option>
                                        <option selected value='Expiré'>Expiré</option>
                                        <option selected value='Attente approbation'>Attente approbation</option>

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
								    <label>Date début<span class="text-danger">*</span></label>
									<input type="date" name="date_debut" class="form-control" value="{{$contrat->date_debut}}">
								</div>
							</div>

							<div class="col-lg-6">
								<div class="form-group">
								    <label>Date fin<span class="text-danger">*</span></label>
									<input type="date" name="date_fin" class="form-control" value="{{$contrat->date_fin}}">
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
                                    @if ( $contrat->type_contrat == "Contrat pieces et main oeuvre")
                                        <option selected value='Contrat pieces et main oeuvre'>Contrat pieces et main oeuvre</option>
                                        <option value="Contrat main oeuvre">Contrat main oeuvre</option>

                                    @elseif ( $contrat->type_contrat == "Contrat main oeuvre")
                                        <option selected value='Contrat main oeuvre'>Contrat main oeuvre</option>
                                        <option value="Contrat pieces et main oeuvre">Contrat pieces et main oeuvre</option>
									@else
                                        <option value='Contrat main oeuvre'>Contrat main oeuvre</option>
                                        <option value="Contrat pieces et main oeuvre">Contrat pieces et main oeuvre</option>
                                    @endif
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
                                    <textarea class="form-control service-desc" name="note" value="{{$contrat->note}}"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>


					<div class="submit-section">
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

