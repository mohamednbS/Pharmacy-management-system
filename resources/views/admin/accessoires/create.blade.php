@extends('admin.layouts.app')

@push('page-css')
	<!-- Datetimepicker CSS -->
	<link rel="stylesheet" href="{{asset('assets/css/bootstrap-datetimepicker.min.css')}}">
@endpush

@push('page-header')
<div class="col-sm-12">
	<h3 class="page-title">Gestion Accessoires</h3>
	<ul class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
		<li class="breadcrumb-item active">Ajouter Accessoire</li>
	</ul>
</div>
@endpush

@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="card">
			<div class="card-body custom-edit-service">
				
		
			<!-- Add Supplier -->
            <form method="POST" enctype="multipart/form-data" action="{{ route('accessoires.store', ['equipement_id' => $equipement_id]) }}">

				@csrf
				
				<div class="service-fields mb-3">
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Désignation<span class="text-danger">*</span></label>
								<input class="form-control" type="text" name="designation">
							</div>
						</div>
						<div class="col-lg-6">
							<label>Numéro de Série<span class="text-danger">*</span></label>
							<input class="form-control" type="text" name="identifiant">
						</div>
					</div>
				</div>

				<div class="service-fields mb-3">
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Qunatité<span class="text-danger">*</span></label>
								<input class="form-control" type="number" name="quantite">
							</div>
						</div>
						<div class="col-lg-6">
							<label>Description</label>
							<input class="form-control" type="text" name="description">
						</div>
					</div>
				</div>
			
				<input type="hidden" name="equipement_id" value="{{ $equipement_id }}">

				<div class="submit-section">
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

