@extends('admin.layouts.app')

<x-assets.datatables />

@push('page-css')

@endpush

@push('page-header')
<div class="col-sm-7 col-auto">
	<h3 class="page-title">Gestion Sous Equipements</h3>
	<ul class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Tableau de Bord</a></li>
		<li class="breadcrumb-item active">Sous-Equipements</li>
	</ul>
</div>

@endpush

@section('content')
<div class="row">
	<div class="col-md-12">

		<!-- Recent Orders -->
		<div class="card">
			<div class="card-body">
				<div class="table-responsive">
					<table id="sousequipement-table" class="table table-bordered table-hover">
						<thead>
							<tr>

								<th>Designation</th>
								<th>Numéro Série</th>
								<th>Marque</th>
                                <th>Modèle</th>
                                <th>Descriptif</th>
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
        var table = $('#sousequipement-table').DataTable({
            processing: true,
            serverSide: false,
            ajax: "{{route('sousequipements.index')}}",
            columns: [
                {data: 'designation', name: 'designation'},
                {data: 'identifiant', name: 'identifiant'},
                {data: 'marque', name: 'marque'},
                {data: 'modele', name: 'modele'},
                {data: 'description', name: 'description'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]

        });

    });
</script>
@endpush
