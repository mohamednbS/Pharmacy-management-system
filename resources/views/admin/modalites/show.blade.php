@extends('admin.layouts.app')

<x-assets.datatables />

@push('page-css')

@endpush

@push('page-header')
<div class="col-sm-7 col-auto">
	<h3 class="page-title">Gestion Modalités</h3>
	<ul class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Tableau de Bord</a></li>
		<li class="breadcrumb-item active">Modalité-Equipements</li>
	</ul>
</div>

@endpush

@section('content')
<div class="row">
	<div class="col-md-12">
        <div class="profile-header">
			<div class="row align-items-center">

				<div class="col ml-md-n2 profile-user-info">
					<h4 class="user-name mb-0"> Modalité : {{$modalite->name}}</h4>
				</div>

			</div>
		</div>

		<!-- Recent Orders -->
		<div class="card">
			<div class="card-body">
				<div class="table-bordered">
					<table id="equipementmodalite-table" class="datatable table table-hover table-center mb-0">
						<thead>
							<tr>
                                <th>#</th>
								<th>Designation</th>
								<th>Modèle</th>
								<th>Numéro Série</th>
								<th>Date Installation</th>
                                <th>Software</th>

							</tr>
						</thead>
                        <tbody>
                            <?php $i=0; ?>
							@foreach ($equipements as $equipement)
                            @if(!empty($equipement->modalite))
                            <?php $i++; ?>
							<tr>
                                <td>{{ $i }}</td>
								<td>{{$equipement->designation}}</td>
								<td>{{$equipement->modele}}</td>
								<td>{{$equipement->numserie}}</td>
								<td>{{$equipement->date_installation}}</td>
								<td>{{$equipement->software}}</td>
							</tr>
                            @endif
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
