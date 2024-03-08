@extends('admin.layouts.app')

@push('page-css')

@endpush

@push('page-header')
<div class="col-sm-12">
	<h3 class="page-title">Gestion Client</h3>
	<ul class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Tableau de Bord</a></li>
		<li class="breadcrumb-item active">Modifier Client</li>
	</ul>
</div>
@endpush

@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="card">
			<div class="card-body custom-edit-service">

			<!-- Edit client -->
			<form method="post" enctype="multipart/form-data" action="{{route('clients.update',$client)}}">
				@csrf
				@method("PUT")
				<div class="service-fields mb-3">
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Nom Client/Raison Sociale<span class="text-danger">*</span></label>
								<input class="form-control" type="text" value="{{$client->name ?? old('name')}}" name="name">
							</div>
						</div>
						<div class="col-lg-6">
							<label>Email</label>
							<input class="form-control" type="text" value="{{$client->email ?? old('email')}}" name="email" >
						</div>
					</div>
				</div>

				<div class="service-fields mb-3">
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Mobile</label>
								<input class="form-control" type="text" value="{{$client->phone ?? old('phone')}}" name="phone">
							</div>
						</div>
						<div class="col-lg-6">
							<label>Fax<span class="text-danger">*</span></label>
							<input class="form-control" type="text" value="{{$client->fax ?? old('fax')}}" name="fax">
						</div>
					</div>
				</div>

				<div class="service-fields mb-3">
					<div class="row">
						<div class="col-12">
							<label>Adresse</label>
							<input name="address" class="form-control" value="{{$client->address ?? old('address')}}">{{$client->address}}
						</div>
					</div>
				</div>


				<div class="submit-section">
					<button class="btn btn-primary submit-btn" type="submit" name="form_submit" value="submit">Modifier</button>
				</div>
			</form>

			<!-- /Edit client -->

			</div>
		</div>
	</div>
</div>
@endsection



@push('page-js')
	<!-- Select2 JS -->
	<script src="{{asset('assets/plugins/select2/js/select2.min.js')}}"></script>
@endpush

