@extends('admin.layouts.app')

<x-assets.datatables />

@push('page-css')

@endpush

@push('page-header')
<div class="col-sm-7 col-auto">
	<h3 class="page-title">Gestion Contrats de Maintenances</h3>
	<ul class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
		<li class="breadcrumb-item active">contrats</li>
	</ul>
</div>
<div class="col-sm-5 col">
	<a href="{{route('contrats.create')}}" class="btn btn-primary float-right mt-2">Ajouter</a>
</div>
@endpush

@section('content')
<div class="row">
	<div class="col-md-12">

		<!-- Recent Orders -->
		<div class="card">
			<div class="card-body">
				<div class="table-responsive">
					<table id="contrat-table" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>Client</th>
                                <th>Equipement</th>
								<th>date début</th>
								<th>date fin</th>
								<th>Type contrat</th>
								<th>Etat</th>
								<th>Notes</th>
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
        var table = $('#contrat-table').DataTable({
            processing: true,
            serverSide: false,
            ajax: "{{route('contrats.index')}}",
            columns: [
                {data: 'client', name: 'client'},
                {data: 'equipement', name: 'equipement'},
                {data: 'date_debut', name: 'date_debut'},
                {data: 'date_fin', name: 'date_fin'},
                {data: 'type_contrat', name: 'type_contrat'},
                {data: 'status', name: 'status'},
				{data: 'note', name: 'note'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

    });
</script>
@endpush
