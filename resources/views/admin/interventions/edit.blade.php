@extends('admin.layouts.app')

@push('page-css')
	<!-- Datetimepicker CSS -->
	<link rel="stylesheet" href="{{asset('assets/css/bootstrap-datetimepicker.min.css')}}">
@endpush

@push('page-header')
<div class="col-sm-12">
	<h3 class="page-title">Gestion Interventions</h3>
	<ul class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Tableau de Bord</a></li>
		<li class="breadcrumb-item active">Modifier Intervention</li>
	</ul>
</div>
@endpush


@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="card">
			<div class="card-body custom-edit-service">

				<!-- edit intervention -->
				<form method="post" enctype="multipart/form-data" autocomplete="off" action="{{route('interventions.update',$intervention)}}">
					@csrf
					@method("PUT")
					<div class="service-fields mb-3">
						<div class="row">
							<div class="col-lg-4">
								<div class="form-group">
									<label for="client">Client<span class="text-danger">*</span></label>
								    <select id="client" onchange="getEquipements(this.value)" class="select2 form-select form-control" name="client">
										<option value="Sélectionner un Client">Sélectionner un Client</option>
										@foreach ($clients as $client)
											<option value="{{ $client->id }}"
												{{ ($intervention->client_id ?? null) === $client->id ? 'selected' : '' }}>
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
									    <option value="Sélectionner un equipement">Sélectionner un equipement</option>
										@foreach ($equipements as $equipement)
										<option value="{{ $equipement->id }}"
											{{ ($intervention->equipement_id ?? null) === $equipement->id ? 'selected' : '' }}>
											{{ $equipement->modele }}
										</option>
									    @endforeach

								    </select>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="form-group">
								<label for="sousequipement">Sous equipement</label>
								<select id="sousequipement" class="select2 form-select form-control" name="sousequipement">
									<option value="Sélectionner un sous equipement">Sélectionner un sous equipement</option>
									@foreach ($sousequipements as $sousequipement)
										<option value="{{ $sousequipement->id }}"
											{{ ($intervention->sousequipement_id ?? null) === $sousequipement->id ? 'selected' : '' }}>
											{{ $sousequipement->designation }}
										</option>
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
									<select  class="select2 form-select form-control" name="etat_initial">

                                        @if ( $intervention->etat_initial == "Fonctionnel")

										<option selected value='Fonctionnel'>Fonctionnel</option>
										<option value="Partiellement Fonctionnel">Partiellement Fonctionnel</option>
										<option value="Panne Intermittente">Panne Intermittente</option>
										<option value="A l'arrêt">A l'arrêt</option>

										@elseif ($intervention->etat_initial == "Partiellement Fonctionnel")

										<option selected value='Partiellement Fonctionnel'>Partiellement Fonctionnel</option>
										<option value='Fonctionnel'>Fonctionnel</option>
										<option value="Panne Intermittente">Panne Intermittente</option>
										<option value="A l'arrêt">A l'arrêt</option>

										@elseif ($intervention->etat_initial == "Panne Intermittente")
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
                                        @if ( $intervention->mode_appel == "Mail")

										<option selected value='Mail'>Mail</option>
										<option value="Téléphone">Téléphone</option>
                                        <option value="Fax">Fax</option>
                                        <option value="WhatsApp">WhatsApp</option>

										@elseif ($intervention->mode_appel == "Téléphone")

										<option selected value='Téléphone'>Téléphone</option>
										<option value='Mail'>Mail</option>
										<option value="Fax">Fax</option>
                                        <option value="WhatsApp">WhatsApp</option>

										@elseif ($intervention->mode_appel == "WhatsApp")
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
                                </div>
							</div>


							<div class="col-lg-6">
								<div class="form-group">
									<label>Sous-traitant</label>
									<select  class="select2 form-select form-control" name="soustraitant">
                                    <option >Sélectionner le sous-traitant</option>
                                        @foreach ($soustraitants as $soustraitant)
                                                <option value="{{ $soustraitant->id }}"
                                                {{ ($intervention->soustraitant_id ?? null) === $soustraitant->id ? 'selected' : '' }}>
                                                {{ $soustraitant->name }}
                                                </option>
                                        @endforeach
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
                                    value="{{$intervention->date_fin ?? old('date_fin')}}">
								</div>
							</div>
							<div class="col-lg-4">
								<div class="form-group">
									<label>Equipement après visite<span class="text-danger">*</span></label>
										<select  class="select2 form-select form-control" name="etat_final">
                                        @if ( $intervention->etat_final == "Fonctionnel")
                                            <option selected value="Fonctionnel">Fonctionnel</option>
											<option value="Partiellement Fonctionnel">Partiellement Fonctionnel</option>
											<option value="Panne Intermittente">Panne Intermittente</option>
											<option value="A l'arrêt">A l'arrêt</option>
										@elseif ($intervention->etat_final == "Partiellement Fonctionnel")
                                            <option selected value="Partiellement Fonctionnel">Partiellement Fonctionnel</option>
											<option value="Fonctionnel">Fonctionnel</option>
											<option value="Panne Intermittente">Panne Intermittente</option>
											<option value="A l'arrêt">A l'arrêt</option>
										@elseif ($intervention->etat_final == "Panne Intermittente")
                                            <option selected value="Panne Intermittente">Panne Intermittente</option>
											<option value="Fonctionnel">Fonctionnel</option>
											<option value="Partiellement Fonctionnel">Partiellement Fonctionnel</option>
											<option value="A l'arrêt">A l'arrêt</option>
										@elseif ($intervention->etat_final == "A l'arrêt")
                                            <option selected value="A l'arrêt">A l'arrêt</option>
											<option value="Fonctionnel">Fonctionnel</option>
											<option value="Partiellement Fonctionnel">Partiellement Fonctionnel</option>
											<option value="Panne Intermittente">Panne Intermittente</option>
										@else
											<option> Sélectionner l'etat final de l'equipement</option>
											<option value="Fonctionnel">Fonctionnel</option>
											<option value="Partiellement Fonctionnel">Partiellement Fonctionnel</option>
											<option value="Panne Intermittente">Panne Intermittente</option>
											<option value="A l'arrêt">A l'arrêt</option>
										@endif
										</select>
								</div>
							</div>
						</div>
					</div>

					<div class="service-fields mb-3">
						<div class="row">
							<div class="col-lg-4">
							    <div class="form-group">
								    <label>Etat intervention<span class="text-danger">*</span></label>
									<select  class="select2 form-select form-control" name="etat">
										<option >Sélectionner un état de l'intervention</option>
										    @foreach ($etats as $etat)
										    	<option @if($intervention->etat == $etat->name) selected @endif>{{ $etat->name }}</option>
								            @endforeach
									</select>
							    </div>
						    </div>
							<div class="col-lg-4">
								<div class="form-group">
									<label>Priorité</label>
									<select  class="select2 form-select form-control" name="priorite">

									@if ( $intervention->priorite == "Tres urgent")
										<option >Selectionner une priorité</option>
										<option selected value='Tres urgent'>Tres urgent</option>
										<option value="Urgent">Urgent</option>
										<option value="Normale">Normale</option>

									@elseif ($intervention->priorite == "Urgent")
										<option selected value='Urgent'>Urgent</option>
										<option value='Normale'>Normale</option>
										<option value='Tres urgent'>Tres urgent</option>

									@elseif ($intervention->priorite == "Normale")
										<option selected value='Normale'>Normale</option>
										<option value='Tres urgent'>Tres urgent</option>
										<option value='Urgent'>Urgent</option>
                                    @else
                                        <option value='Normale'>Normale</option>
										<option value='Tres urgent'>Tres urgent</option>
										<option value='Urgent'>Urgent</option>
									@endif
									</select>
							    </div>
						    </div>
							<div class="col-lg-4">
								<div class="form-group">
								<label>Description de l'intervention</label>
									<input type="textarea" name="description_intervention" class="form-control" placeholder="décrire l'intervention" value="{{$intervention->description_intervention ?? old('description_intervention')}}">
								</div>
							</div>
						</div>

						<div class="service-fields mb-3">
							<div class="row">
								<div class="col-12">
									<label>Rapport d'intervention</label>
									<input type="file" class="form-control" name='rapport' value="{{$intervention->rapport ?? old('rapport')}}">
								</div>
							</div>
						</div>

					</div>


					<div class="submit-section">
                        <a href="{{route('interventions.index')}}" class="btn btn-danger submit-btn">Annuler</a>
						<button class="btn btn-primary submit-btn" type="submit" >Modifier</button>
					</div>
				</form>
				<!-- /edit intervention -->

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
                    equipementSelect.innerHTML = '<option value="">Select Equipement</option>';
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
	<script>
        function getSousequipements(equipementId) {
            fetch('/getSousequipements?equipement_id=' + equipementId)
                .then(response => response.json())
                .then(data => {
                    const sousequipementSelect = document.getElementById('sousequipement');
                    sousequipementSelect.innerHTML = '<option value="">Select Sousequipement</option>';
                    data.forEach(sousequipement => {
                        const option = document.createElement('option');
                        option.value = sousequipement.id;
                        option.text = sousequipement.designation;
                        sousequipementSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching sousequipements:', error));
        }
    </script>
@endpush
