@extends('admin.layouts.app')

@push('page-css')

@endpush

@push('page-header')
<div class="col-sm-12">
	<h3 class="page-title">Gestion Sous-equipement</h3>
	<ul class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Tableau de Bord</a></li>
		<li class="breadcrumb-item active">Modifier Sous-equipement</li>
	</ul>
</div>
@endpush

@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="card">
			<div class="card-body custom-edit-service">

			<!-- Edit sous-equipement-->
			<form method="post" enctype="multipart/form-data" autocomplete="off" action="{{route('sousequipements.update',$sousequipement)}}">
				@csrf
				@method("PUT")
                <div class="service-fields mb-3">
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Désignation<span class="text-danger">*</span></label>
								<input class="form-control" type="text" name="designation" value ="{{$sousequipement->designation}}">
							</div>
						</div>
						<div class="col-lg-6">
							<label>Numéro de Série<span class="text-danger">*</span></label>
							<input class="form-control" type="text" name="identifiant" value ="{{$sousequipement->identifiant}}">
						</div>
					</div>
				</div>

				<div class="service-fields mb-3">
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Modèle<span class="text-danger">*</span></label>
								<input class="form-control" type="text" name="modele" value ="{{$sousequipement->modele}}">
							</div>
						</div>
						<div class="col-lg-6">
							<label>Marque<span class="text-danger">*</span></label>
							<input class="form-control" type="text" name="marque" value ="{{$sousequipement->marque}}">
						</div>
					</div>
				</div>

				<div class="service-fields mb-3">
					<div class="row">
						<div class="col-12">
							<label>Description</label>
							<input name="description" class="form-control" cols="10" rows="10" value ="{{$sousequipement->description}}">
						</div>
					</div>
				</div>

				<div class="submit-section">
                    <a href="{{route('sousequpements.index')}}" class="btn btn-danger submit-btn">Annuler</a>
					<button class="btn btn-primary submit-btn" type="submit" name="form_submit" value="submit">Modifier</button>
				</div>
			</form>
			<!-- /Edit sous-equipement -->


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
