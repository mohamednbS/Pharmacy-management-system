@extends('admin.layouts.app')

<x-assets.datatables />

@push('page-css')

@endpush

@push('page-header')
<div class="col-sm-7 col-auto">
	<h3 class="page-title">Gestion Clients</h3>
	<ul class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
		<li class="breadcrumb-item active">Clients-Equipements</li>
	</ul>
</div>

@endpush

@section('content')
<div class="row">
	<div class="col-md-12">
        <div class="profile-header">
			<div class="row align-items-center">

				<div class="col ml-md-n2 profile-user-info">
					<h4 class="user-name mb-0"> Client : {{$client->name}}</h4>
					<h5 class="text-muted">Adresse : {{$client->adress}}</h5>
				</div>

			</div>
		</div>

		<!-- Recent Orders -->
		<div class="card">
			<div class="card-body">
				<div class="table-responsive">
					<table id="equipementclient-table" class="datatable table table-hover table-center mb-0">
						<thead>
							<tr>

								<th>Designation</th>
								<th>Modèle</th>
								<th>Numéro Série</th>
								<th>Date Installation</th>
                                <th>Software</th>

								<th class="action-btn">Action</th>
							</tr>
						</thead>
                        <tbody>
							@foreach ($equipements as $equipement)
							<tr>
								<td>{{$equipement->designation}}</td>
								<td>{{$equipement->modele}}</td>
								<td>{{$equipement->numserie}}</td>
								<td>{{$equipement->date_installation}}</td>
								<td>{{$equipement->software}}</td>
                                @if (Auth::user()->role == "super-admin")
														<td><a href="/equipement/mod/{{ $equipement->id }}" data-toggle="tooltip" data-placement="top" title="Modifier" class="btn btn-sm bg-success-light"><i class="fe fe-pencil"></i></a>
															<a  data-toggle="tooltip" data-placement="top" title="supprimer" class="btn btn-sm bg-danger-light"  href="/equipement/del/{{ $equipement->id}}"><i class="fe fe-trash"></i></a>

                                                        </td>
                             @endif
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<!-- /Recent Orders -->

	</div>
</div>
@endsection

@push('page-js')

@endpush
