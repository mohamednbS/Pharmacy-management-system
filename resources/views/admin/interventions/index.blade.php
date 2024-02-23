@extends('admin.layouts.app')

<x-assets.datatables />

@push('page-css')

@endpush

@push('page-header')
<div class="col-sm-7 col-auto">
	<h3 class="page-title">Gestion Interventions</h3>
	<ul class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
		<li class="breadcrumb-item active">Interventions</li>
	</ul>
</div>
<div class="col-sm-5 col">
	<a href="{{route('interventions.create')}}" class="btn btn-primary float-right mt-2">Ajouter</a>
</div>
@endpush

@section('content')
<div class="row">
	<div class="col-md-12">

		<!-- Recent Orders -->
		<div class="card">
			<div class="card-body">
				<div class="table-responsive">
					<table id="intervention-table" class="datatable table table-hover table-center mb-0">
						<thead>
							<tr>
							    <th>Etat</th>
								<th>Client</th>
								<th>Equipement</th>
								<th>Panne Initial</th>
								<th>Intervenant(s)</th>
                                <th>Sous-traitant</th>
                                <th>Sous equipement</th>
								<th>Description Panne</th>
                                <th>Heure/Date d'appel client</th>
								<th class="action-btn">Action</th>
							</tr>
						</thead>
						<tbody>

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
<script>
    $(document).ready(function() {
        var table = $('#intervention-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{route('interventions.index')}}",
            columns: [
				{data: 'etat', name: 'etat'},
                {data: 'client', name: 'client'},
                {data: 'equipement', name: 'equipement'},
                {data: 'type_panne', name: 'type_panne'},
                {data: 'destinateur', name: 'destinateur'},
                {data: 'soustraitant', name: 'soustraitant'},
                {data: 'sousequipement', name: 'sousequipement'},
				{data: 'description_panne', name: 'description_panne'},
                {data: 'appel_client', name: 'appel_client'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

    });
</script>
@endpush
