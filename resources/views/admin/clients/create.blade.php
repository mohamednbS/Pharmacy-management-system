@extends('admin.layouts.app')

@push('page-css')
	<!-- Datetimepicker CSS -->
	<link rel="stylesheet" href="{{asset('assets/css/bootstrap-datetimepicker.min.css')}}">
@endpush

@push('page-header')
<div class="col-sm-12">
	<h3 class="page-title">Gestion Clients</h3>
	<ul class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Tableau de Bord</a></li>
		<li class="breadcrumb-item active">Ajouter Client</li>
	</ul>
</div>
@endpush

@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="card">
			<div class="card-body custom-edit-service">


			<!-- Add client -->
			<form method="post" enctype="multipart/form-data" action="{{route('clients.store')}}">
				@csrf

				<div class="service-fields mb-3">
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Nom Client/Raison Sociale<span class="text-danger">*</span></label>
								<input class="form-control" type="text" name="name" placeholder="Saisir le nom client/raison sociale">
							</div>
						</div>
						<div class="col-lg-6">
							<label>Email</label>
							<input class="form-control" type="text" name="email" id="email" placeholder="exemple@gmail.com">
						</div>
					</div>
				</div>

				<div class="service-fields mb-3">
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Mobile</label>
								<input class="form-control" type="text" name="phone" placeholder="Saisir le numéro de téléphone">
							</div>
						</div>
						<div class="col-lg-6">
							<label>Fax</label>
							<input class="form-control" type="text" name="fax" placeholder="Saisir le fax">
						</div>
					</div>
				</div>

				<div class="service-fields mb-3">
					<div class="row">
						<div class="col-12">
							<label>Address</label>
							<input name="address" class="form-control" placeholder="Saisir l'adresse">
						</div>
					</div>
				</div>

				<div class="submit-section">
                    <a href="{{route('clients.index')}}" class="btn btn-danger submit-btn">Annuler</a>
					<button class="btn btn-primary submit-btn" type="submit" name="form_submit" value="submit">Valider</button>
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

