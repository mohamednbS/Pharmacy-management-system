@extends('admin.layouts.app')

@push('page-css')
	<!-- Datetimepicker CSS -->
	<link rel="stylesheet" href="{{asset('assets/css/bootstrap-datetimepicker.min.css')}}">
@endpush

@push('page-header')
<div class="col-sm-12">
	<h3 class="page-title">Gestion Contrats Maintenance</h3>
	<ul class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
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
									<select class="select2 form-select form-control" name="client"> 
										@foreach ($clients as $client)
											<option value="{{$client->id}}">{{$client->name}}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="form-group">
	                         	    <label>Date début<span class="text-danger">*</span></label>
									<input type="datetime-local" name="date_debut" class="form-control">									  
								</div>
							</div>
							<div class="col-lg-4">
								<div class="form-group">
	                         	    <label>Date fin<span class="text-danger">*</span></label>
									<input type="datetime-local" name="date_fin" class="form-control">								  
								</div>
							</div>
						</div>
					</div>
					
					<div class="service-fields mb-3">
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
								    <label>Type Contrat<span class="text-danger">*</span></label>
									<select  class="select2 form-select form-control" name="type_contrat">
									<option >Sélectionner le type contrat</option>
										<option value="Contrat pieces et main oeuvre">Contrat pieces et main oeuvre</option>
										<option value="Contrat main oeuvre">Contrat main oeuvre</option>
									</select>
								</div>
							</div>
				
							<div class="col-lg-6">
								<div class="form-group">
								    <label>Type Contrat<span class="text-danger">*</span></label>
									<select  class="select2 form-select form-control" name="status">
									<option >Sélectionner etat contrat</option>
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
                                    <textarea class="form-control service-desc" name="note"></textarea>
                                </div>
                            </div>     
                        </div>
                    </div>
					
					
					<div class="submit-section">
						<button class="btn btn-primary submit-btn" type="submit" >Submit</button>
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
@endpush

