@extends('admin.layouts.app')

@push('page-css')

@endpush

@push('page-header')
<div class="col-sm-12">
	<h3 class="page-title">Edit Purchase</h3>
	<ul class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Tableau de Bord</a></li>
		<li class="breadcrumb-item active">Edit Purchase</li>
	</ul>
</div>
@endpush

@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="card">
			<div class="card-body custom-edit-service">

			<!-- Edit Supplier -->
			<form method="post" enctype="multipart/form-data" autocomplete="off" action="{{route('equipements.update',$equipement)}}">
				@csrf
				@method("PUT")
                <div class="service-fields mb-3">
						<div class="row">
							<div class="col-lg-4">
								<div class="form-group">
									<label>Code</label>
									<input class="form-control" type="text" name="code" value="{{$equipement->code ?? old('code')}}">
								</div>
							</div>
							<div class="col-lg-4">
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
							<div class="col-lg-4">
								<div class="form-group">
									<label>Modalité <span class="text-danger">*</span></label>
									<select class="select2 form-select form-control" name="modalite_id">
										@foreach ($modalites as $modalite)
                                            @if($modalite->id == $equipement->modalite_id)

											    <option selected value="{{$modalite->id}}">{{$modalite->name}}</option>
                                            @else
                                                <option value="{{$modalite->id}}">{{$modalite->name}}</option>
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
									<label>Désignation<span class="text-danger">*</span></label>
									<input class="form-control" type="text" name="designation" value="{{$equipement->designation}}">
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label>Modèle<span class="text-danger">*</span></label>
									<input class="form-control" type="text" name="modele" value="{{$equipement->modele}}">
								</div>
							</div>
						</div>
					</div>

					<div class="service-fields mb-3">
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label>Numéro Série<span class="text-danger">*</span></label>
									<input class="form-control" type="text" name="numserie" value="{{$equipement->numserie}}">
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label>Marque</label>
									<input class="form-control" type="text" name="marque" value="{{$equipement->marque}}">
								</div>
							</div>
						</div>
					</div>

					<div class="service-fields mb-3">
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label>Date Installation</label>
									<input class="form-control" type="date" name="date_installation" value="{{$equipement->date_installation}}">
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label>Software</label>
									<input type="text" name="software" class="form-control" value="{{$equipement->software}}">
								</div>
							</div>
						</div>
					</div>

                    <div class="service-fields mb-3">
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label>Nombre Planning Préventif/an</label>
									<input class="form-control" type="number" name="plan_prev" value="{{$equipement->plan_prev}}">
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label>Fiche Technique</label>
									<input type="file" name="document" class="form-control" value="{{$equipement->document}}">
								</div>
							</div>
						</div>
					</div>

					<div class="submit-section">
                        <a href="{{route('equipements.index')}}" class="btn btn-danger submit-btn">Annuler</a>
						<button class="btn btn-primary submit-btn" type="submit" >Modifier</button>
					</div>
				</form>
				<!-- /Edit Equipement-->

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
